<?php

namespace App\Component;

final class EntityForm extends BaseComponent
{
    /** @var \App\Model\EntityModel */
    protected $entityModel;

    /** @var \App\Model\ArtistModel */
    protected $artistModel;

    /** @var \App\Model\ArtistEntityModel */
    protected $artistEntityModel;

    /** @var \Nette\Database\Connection */
    protected $connection;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\ArtistModel $artistModel,
        \App\Model\ArtistEntityModel $artistEntityModel,
        \Nette\Database\Connection $connection)
    {
        $this->entityModel = $entityModel;
        $this->artistModel = $artistModel;
        $this->artistEntityModel = $artistEntityModel;
        $this->connection = $connection;
    }

    public function createComponent($name, array $args = null)
    {
        if ($name === 'form')
        {
            return $this->createComponentForm();
        }

        $form = parent::createComponent($name, $args);

        $form['form']->getElementPrototype()->addClass('ajax');
        $form['form']->onSuccess[] = [$this, 'redrawSnippets'];
    
        return $form;
    }

    public function redrawSnippets()
    {
        $this->redrawControl('formSnippet');
        $this->redrawControl('artistSnippet');
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->entityModel->findRow($id);
            $data = $row->toArray();

            foreach (\App\Enum\Type2Role::ROLES[$row->type] as $role)
            {
                $data[$role] = $row
                    ->related('jun_artist2entity')
                    ->where('role', $role)
                    ->fetchPairs('id', 'member_id');
            }

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addHidden('id');

        $form->addRadioList('type', 'Type', $this->presenter->locale['entity'])
            ->setDefaultValue('movie')
            ->setRequired()
            ->addCondition($form::EQUAL, ['movie', 'series', 'book'])
                ->toggle('langSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'series')
                ->toggle('seriesSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'season')
                ->toggle('seasonSection')
            ->endCondition()
            ->addCondition($form::EQUAL, ['movie', 'season', 'book', 'music', 'game'])
                ->toggle('yearSection');

        $form->addText('original_title', 'Original title')
            ->setRequired();

        $form->addText('english_title', 'English title')
            ->addConditionOn($form['type'], $form::EQUAL, ['movie', 'series', 'book'])
                ->setRequired();
        $form->addText('czech_title', 'Czech title');

        $form->addText('series_active', 'Active')
            ->addConditionOn($form['type'], $form::EQUAL, 'series')
                ->setRequired();

        $form->addText('series_id', 'Series')
            ->addConditionOn($form['type'], $form::EQUAL, 'season')
                ->setRequired();
        $form->addText('season_number', 'Season number')
            ->addConditionOn($form['type'], $form::EQUAL, 'season')
                ->setRequired();

        $form->addText('year', 'Year')
            ->addConditionOn($form['type'], $form::EQUAL, ['movie', 'season', 'book', 'music', 'game'])
                ->setRequired()
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4);

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
                $id = $this->artistModel->save([
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
                $id = $this->artistModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'artist_id' => $data['artist_id'],
                    'description' => $data['description']
                ]);
                break;
            case 'group':
                $id = $this->artistModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'name' => $data['name'],
                    'year_from' => $data['year_from'],
                    'year_to' => $data['year_to'],
                    'description' => $data['description']
                ]);
                $this->groupMemberModel->findBy('artist_id', $id)->delete();
                foreach ($data['members'] as $member)
                {
                    $this->groupMemberModel->insert(array(
                        'member_id' => $member,
                        'group_id' => $id
                    ));
                }
                foreach ($data['former_members'] as $member)
                {
                    $this->groupMemberModel->insert(array(
                        'member_id' => $member,
                        'group_id' => $id,
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

        $this->presenter->redirect('Artist:view', array('id' => $id));
    }
}
