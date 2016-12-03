<?php

namespace App\Component;

use Nette\Forms\Form;

class EditMovieForm extends BaseFormComponent
{
    protected $personModel;
    protected $movieModel;
    protected $movieDirectorModel;

    public function __construct(
        \App\Model\PersonModel $directorModel,
        \App\Model\MovieModel $movieModel,
        \App\Model\MovieDirectorModel $movieDirectorModel)
    {
        $this->personModel = $directorModel;
        $this->movieModel = $movieModel;
        $this->movieDirectorModel = $movieDirectorModel;
    }

    public function render($id = 0)
    {
        $row = $this->movieModel->findRow($id);

        $data = $row->toArray();
        $data['director'] = $row->related('movie2director.movie_id')->fetchPairs('id', 'person_id');

        $this['form']->setDefaults($data);

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
            ->addRule(Form::MIN_LENGTH, 'Year must be at least 4 digit long.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description')
            ->setOption('description', 'IMDB has nice short descriptions.');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/

        $form->addMultiSelect('director', 'Director', $directors);

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $this->movieDirectorModel->findBy('movie_id', $data['id'])->delete();
        foreach($data['director'] as $person)
        {
            $this->movieDirectorModel->insert(array('person_id' => $person, 'movie_id' => $data['id']));
        }
        unset($data['director']);

        $id = $this->movieModel->save($data);

        $this->flashMessage('Movie details successfully updated.', 'success');
        $this->presenter->redirect('Movie:view', array('id' => $id));
    }
}