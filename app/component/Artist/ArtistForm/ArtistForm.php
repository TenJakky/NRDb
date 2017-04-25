<?php

namespace App\Component;

use App\Validator\CoreValidator;

final class ArtistForm extends BaseComponent
{
    /** @var \App\Model\ArtistModel */
    protected $artistModel;

    /** @var \App\Model\CountryModel */
    protected $countryModel;

    /** @var \App\Model\GroupMemberModel */
    protected $groupMemberModel;

    /** @var \Nette\Database\Connection */
    protected $connection;

    public function __construct(
        \App\Model\ArtistModel $artistModel,
        \App\Model\GroupMemberModel $groupMemberModel,
        \App\Model\CountryModel $countryModel,
        \Nette\Database\Connection $connection)
    {
        $this->artistModel = $artistModel;
        $this->groupMemberModel = $groupMemberModel;
        $this->countryModel = $countryModel;
        $this->connection = $connection;
    }

    public function render($artistId = 0)
    {
        if ($artistId)
        {
            $row = $this->artistModel->findRow($artistId);
            $data = $row->toArray();

            if ($row->type === 'person')
            {
                $data['born'] = $row->year_from;
                $data['died'] = $row->year_to;
                unset($data['year_from']);
                unset($data['year_to']);
            }
            if ($row->type === 'group')
            {
                $data['members'] = $row
                    ->related('jun_group2member.group_id')
                    ->where('active', 1)
                    ->fetchPairs('id', 'member_id');
                $data['former_members'] = $row
                    ->related('jun_group2member.group_id')
                    ->where('active', 0)
                    ->fetchPairs('id', 'member_id');
            }

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/ArtistForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addHidden('id');

        $form->addRadioList('type', 'Type', ['person' => 'Person', 'pseudonym' => 'Pseudonym', 'group' => 'Group'])
            ->setDefaultValue('person')
            ->setRequired()
            ->addCondition($form::EQUAL, 'person')
                ->toggle('personSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'pseudonym')
                ->toggle('pseudonymSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'group')
                ->toggle('groupSection');

        $form->addText('name', 'Name')
            ->setRequired();

        $form->addText('middlename', 'Middle name');
        $form->addText('surname', 'Surname')
            ->addConditionOn($form['type'], $form::EQUAL, 'person')
                ->setRequired();
        $form->addSelect('country_id', 'Country', $this->countryModel->fetchSelectBox())
            ->setPrompt('Select country')
            ->addConditionOn($form['type'], $form::EQUAL, 'person')
                ->setRequired();
        $form->addText('born', 'Born')
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4);
        $form->addText('died', 'Died')
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4)
                ->addRule(CoreValidator::GREATER_EQUAL, 'Year is not in range.', 'born');

        $form->addSelect('artist_id', 'Pseudonym of', $this->artistModel->fetchPersonSelectBox())
            ->setPrompt('Select person')
            ->addConditionOn($form['type'], $form::EQUAL, 'pseudonym')
                ->setRequired();

        $form->addText('year_from', 'Year formed')
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4);
        $form->addText('year_to', 'Year disbanded')
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4)
                ->addRule(CoreValidator::GREATER_EQUAL, 'Year is not in range.', 'year_from');
        $form->addMultiSelect('member', 'Members', $this->artistModel->fetchSelectBox())
            ->setAttribute('placeholder', 'Choose members');
        $form->addMultiSelect('former_member', 'Former Members', $this->artistModel->fetchSelectBox())
            ->setAttribute('placeholder', 'Choose former members');

        $form->addTextArea('description', 'Description');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $this->connection->beginTransaction();

        switch ($data['type'])
        {
            case 'person':
                $artistId = $this->artistModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'middlename' => $data['middlename'],
                    'surname' => $data['surname'],
                    'country_id' => $data['country_id'],
                    'year_from' => $data['born'],
                    'year_to' => $data['died'],
                    'description' => $data['description']
                ]);
                break;
            case 'pseudonym':
                $artistId = $this->artistModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'artist_id' => $data['artist_id'],
                    'description' => $data['description']
                ]);
                break;
            case 'group':
                $artistId = $this->artistModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'year_from' => $data['year_from'],
                    'year_to' => $data['year_to'],
                    'description' => $data['description']
                ]);
                if ($data['id'])
                {
                    $this->groupMemberModel->findBy('artist_id', $artistId)->delete();
                }
                foreach ($data['member'] as $member)
                {
                    $this->groupMemberModel->insert(array(
                        'member_id' => $member,
                        'group_id' => $artistId
                    ));
                }
                foreach ($data['former_member'] as $member)
                {
                    $this->groupMemberModel->insert(array(
                        'member_id' => $member,
                        'group_id' => $artistId,
                        'active' => 0
                    ));
                }
                break;
        }

        $this->connection->commit();

        $this->presenter->flashMessage('Artist successfully saved.', 'success');

        if ($this->presenter->isAjax())
        {
            $this->presenter->redrawControl('flash');
            return;
        }

        $this->presenter->redirect('Artist:view', array('id' => $artistId));
    }
}
