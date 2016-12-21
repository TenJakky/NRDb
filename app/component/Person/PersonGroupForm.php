<?php

namespace App\Component;

final class PersonGroupForm extends BaseComponent
{
    /** @var \App\Model\PersonGroupModel */
    protected $personGroupModel;

    /** @var \App\Model\PersonModel */
    protected $personModel;

    /** @var \App\Model\GroupMemberModel */
    protected $groupMemberModel;

    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\PersonGroupModel $personGroupModel,
        \App\Model\GroupMemberModel $groupMemberModel)
    {
        $this->personModel = $personModel;
        $this->personGroupModel = $personGroupModel;
        $this->groupMemberModel = $groupMemberModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->personGroupModel->findRow($id);

            if (!$row)
            {
                $this->flashMessage('Group not found', 'failure');
                $this->redirect('Group:default');
            }

            $this['form']->setDefaults($row);
        }

        $this->template->setFile(__DIR__.'/PersonForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addHidden('id');
        $form->addText('name', 'Name')
            ->setRequired();
        $form->addText('year_from', 'Year formed')
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4);
        $form->addText('year_to', 'Year disbanded')
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4);
        $form->addText('description', 'Description');
        $form->addMultiSelect('members', 'Members', $this->personModel->fetchAllSelectBox());

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $members = $data['members'];
        unset($data['members']);

        $id = $this->personGroupModel->save($data);

        $this->groupMemberModel->findBy('person_group_id', $id)->delete();
        foreach ($members as $member)
        {
            $this->groupMemberModel->insert(array(
                'person_id' => $member,
                'person_group_id' => $id
            ));
        }

        $this->presenter->flashMessage('Group successfully saved.', 'success');

        if ($this->presenter->isAjax())
        {
            $this->presenter->redrawControl('flash');
            return;
        }

        $this->presenter->redirect('Group:view', array('id' => $id));
    }
}
