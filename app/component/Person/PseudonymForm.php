<?php

namespace App\Component;

final class PseudonymForm extends BaseComponent
{
    /** @var \App\Model\PersonModel */
    protected $personModel;

    public function __construct(
        \App\Model\PersonModel $personModel)
    {
        $this->personModel = $personModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->personModel->findRow($id);

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
        $form->addSelect('person_id', 'Pseudonym of', $this->personModel->fetchSelectBox())
            ->setPrompt('Select person')
            ->setRequired();

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $id = $this->personModel->save($form->getValues());

        $this->presenter->flashMessage('Pseudonym successfully saved.', 'success');

        if ($this->presenter->isAjax())
        {
            $this->presenter->redrawControl('flash');
            return;
        }

        $this->presenter->redirect('Pseudonym:view', array('id' => $id));
    }
}
