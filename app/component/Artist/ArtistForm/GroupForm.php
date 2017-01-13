<?php

namespace App\Component;

final class GroupForm extends BaseComponent
{
    /** @var \App\Model\GroupModel */
    protected $groupModel;

    /** @var \App\Model\PersonModel */
    protected $personModel;

    /** @var \App\Model\GroupMemberModel */
    protected $groupMemberModel;

    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\GroupModel $groupModel,
        \App\Model\GroupMemberModel $groupMemberModel)
    {
        $this->personModel = $personModel;
        $this->groupModel = $groupModel;
        $this->groupMemberModel = $groupMemberModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->groupModel->findRow($id);

            $data = $row->toArray();
            $data['members'] = $row->related('jun_group2member.group_id')->where('active', 1)->fetchPairs('id', 'person_id');
            $data['former_members'] = $row->related('jun_group2member.group_id')->where('active', 0)->fetchPairs('id', 'person_id');

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/ArtistForm.latte');
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
        $form->addMultiSelect('former_members', 'Former Members', $this->personModel->fetchAllSelectBox());

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $members = $data['members'];
        $formerMembers = $data['former_members'];
        unset($data['members']);
        unset($data['former_members']);

        $id = $this->groupModel->save($data);

        $this->groupMemberModel->findBy('group_id', $id)->delete();
        foreach ($members as $member)
        {
            $this->groupMemberModel->insert(array(
                'person_id' => $member,
                'group_id' => $id
            ));
        }
        foreach ($formerMembers as $member)
        {
            $this->groupMemberModel->insert(array(
                'person_id' => $member,
                'group_id' => $id,
                'active' => 0
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
