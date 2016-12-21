<?php

namespace App\Component;

final class MovieForm extends EntityForm
{
    protected $movieDirectorModel;
    protected $movieActorModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\MovieDirectorModel $movieDirectorModel,
        \App\Model\MovieActorModel $movieActorModel)
    {
        $this->model = $movieModel;
        $this->movieDirectorModel = $movieDirectorModel;
        $this->movieActorModel = $movieActorModel;
    }

    public function render($id = 0)
    {
        if ($id)
        { 
            $row = $this->model->findRow($id);
            
            $data = $row->toArray();
            $data['director'] = $row->related('movie2director.movie_id')->fetchPairs('id', 'person_id');
            $data['actor'] = $row->related('movie2actor.movie_id')->fetchPairs('id', 'person_id');

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $person = $this->personModel->fetchSelectBox();

        $form->addHidden('id');
        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addText('year', 'Year')
            ->addRule($form::INTEGER, 'Year must be number')
            ->addRule($form::LENGTH, 'Year must be exactly 4 digit long.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/
        $form->addMultiSelect('director', 'Directors', $person)
            ->setRequired();
        $form->addMultiSelect('actor', 'Actors', $person);

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        /*$file = $data['poster'];
        if($file->isOk() && $file->isImage())
        {
            $dest = MovieModel::FILE_DIR.\Nette\Utils\Strings::random(20);
            $file->move(getcwd().$dest);
            $data['poster_file'] = $dest;
        }*/

        $movieId = $this->model->save(array(
            'id' => isset($data['id']) ? $data['id'] : 0,
            'original_title' => $data['original_title'],
            'english_title' => $data['english_title'],
            'czech_title' => $data['czech_title'],
            'year' => $data['year'],
            'description' => $data['description'],
        ));

        $this->movieDirectorModel->findBy('movie_id', $movieId)->delete();
        foreach ($data['director'] as $person)
        {
            $this->movieDirectorModel->insert(array(
                'movie_id' => $movieId,
                'person_id' => $person
            ));
        }

        $this->movieActorModel->findBy('movie_id', $movieId)->delete();
        foreach ($data['actor'] as $person)
        {
            $this->movieActorModel->insert(array(
                'movie_id' => $movieId,
                'person_id' => $person
            ));
        }

        $this->flashMessage('Movie successfully saved.', 'success');
        if ($this->presenter->getAction() == 'add')
        {
            $this->presenter->redirect("Movie:rate", array('id' => $movieId));
        }
        $this->presenter->redirect('Movie:view', array('id' => $movieId));
    }
}
