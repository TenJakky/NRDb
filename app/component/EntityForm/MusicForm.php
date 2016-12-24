<?php

namespace App\Component;

final class MusicForm extends EntityForm
{
	protected $musicInterpretModel;

    public function __construct(
        \App\Model\MusicModel $musicModel,
        \App\Model\MusicInterpretModel $musicInterpretModel)
    {
        $this->model = $musicModel;
        $this->musicInterpretModel = $musicInterpretModel;
    }

    public function render($id = 0)
    {
        if ($id)
        { 
            $row = $this->model->findRow($id);

            $data = $row->toArray();
            $data['person'] = $row->related('jun_music2interpret.music_id')
                ->where('jun_music2interpret.person_id NOT', null)
                ->where('person.type', 'person')
                ->fetchPairs('id', 'person_id');
            $data['pseudonym'] = $row->related('jun_music2interpret.music_id')
                ->where('jun_music2interpret.person_id NOT', null)
                ->where('person.type', 'pseudonym')
                ->fetchPairs('id', 'person_id');
            $data['group'] = $row->related('jun_music2interpret.music_id')->where('group_id NOT', null)->fetchPairs('id', 'group_id');

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $person = $this->personModel->fetchSelectBox();
        $pseudonym = $this->personModel->fetchPseudonymSelectBox();
        $band = $this->personGroupModel->fetchSelectBox();

        $form->addHidden('id');
        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('year', 'Year')
            ->addRule($form::INTEGER, 'Year must be number')
            ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/
        $form->addMultiSelect('person', 'Interpret person', $person);
        $form->addMultiSelect('pseudonym', 'Interpret pseudonym', $pseudonym);
        $form->addMultiSelect('group', 'Interpret band', $band);

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
            $dest = MusicModel::FILE_DIR.\Nette\Utils\Strings::random(20);
            $file->move(getcwd().$dest);
            $data['poster_file'] = $dest;
        }*/

        $musicId = $this->model->save(array(
            'id' => isset($data['id']) ? $data['id'] : 0,
            'original_title' => $data['original_title'],
            'year' => $data['year'],
            'description' => $data['description'],
        ));

        $this->musicInterpretModel->findBy('music_id', $musicId)->delete();
        foreach ($data['person'] as $person)
        {
            $this->musicInterpretModel->insert(array(
                'music_id' => $musicId,
                'person_id' => $person
            ));
        }
        foreach ($data['pseudonym'] as $pseudonym)
        {
            $this->musicInterpretModel->insert(array(
                'music_id' => $musicId,
                'person_id' => $pseudonym
            ));
        }
        foreach ($data['group'] as $band)
        {
            $this->musicInterpretModel->insert(array(
                'music_id' => $musicId,
                'group_id' => $band
            ));
        }

        $this->flashMessage('Recording successfully saved.', 'success');
        if ($this->presenter->getAction() == 'add')
        {
            $this->presenter->redirect("Music:rate", array('id' => $musicId));
        }
        $this->presenter->redirect('Music:view', array('id' => $musicId));
    }
}