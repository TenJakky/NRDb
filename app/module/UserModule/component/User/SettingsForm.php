<?php

namespace App\Component;

final class SettingsForm extends BaseRenderComponent
{
    protected $userModel;
    protected $countryModel;

    public function __construct(\App\Model\Authenticator $userModel, \App\Model\CountryModel $countryModel)
    {
        $this->userModel = $userModel;
        $this->countryModel = $countryModel;
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();
        $form->addProtection('Security token has expired, please submit the form again.');

        $form->addText('name', 'Name');
        $form->addText('surname', 'Surname');
        $form->addRadioList('gender', 'Gender', array('male'=>'Male', 'female'=>'Female'));
        $form->addSelect('country_id', 'Nationality', $this->countryModel->fetchSelectBox());
        $form->addTextArea('description', 'Description');
        $form->addText('per_page', 'Number of items per page');
        $form->addText('per_page_small', 'Number of items in small lists');

        $form->addSubmit('submit', 'Submit');

        $form->setDefaults($this->userModel->findRow($this->getPresenter()->getUser()->getId()));
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $values = $form->getValues();
        $values['id'] = $this->getPresenter()->getUser()->getId();

        $this->userModel->save($values);

        $this->getPresenter()->getUser()->getIdentity()->per_page = $values['per_page'];
        $this->getPresenter()->getUser()->getIdentity()->per_page_small = $values['per_page_small'];

        $this->getPresenter()->flashMessage('Settings were successfully saved.', 'success');
        $this->getPresenter()->redirect(':User:Profile:view', $values['id']);
    }
}
