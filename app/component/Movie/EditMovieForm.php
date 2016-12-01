<?php

namespace App\Component;

use Nette\Forms\Form;

class EditMovieForm extends BaseFormComponent
{
    protected $personModel;
    protected $movieModel;

    public function __construct(
        \App\Model\PersonModel $directorModel,
        \App\Model\MovieModel $movieModel)
    {
        $this->personModel = $directorModel;
        $this->movieModel = $movieModel;
    }

    public function render($id = 1)
    {
        $this['form']->setDefaults($this->movieModel->findRow($id));

        parent::render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $directors = $this->personModel->fetchSelectBox();

        $form->addHidden('id');
        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addText('year', 'Year')
            ->addRule(Form::INTEGER, 'Year must be number')
            ->setRequired();
        $form->addTextArea('description', 'Description')
            ->setOption('description', 'IMDB has nice short descriptions.');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/

        $form->addSelect('director_id', 'Director', $directors)
            ->setHtmlId('input_director')
            ->setPrompt('Select director');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $id = $this->movieModel->save($data);

        $this->flashMessage('Movie details successfully updated.', 'success');
        $this->presenter->redirect('Movie:view', array('id' => $id));
    }
}