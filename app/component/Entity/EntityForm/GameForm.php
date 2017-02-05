<?php

namespace App\Component;

final class GameForm extends EntityForm
{
    protected $gameDeveloperModel;

    public function __construct(
        \App\Model\GameModel $gameModel,
        \App\Model\GameDeveloperModel $gameDeveloperModel)
    {
        $this->model = $gameModel;
        $this->gameDeveloperModel = $gameDeveloperModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->model->findRow($id);

            $data = $row->toArray();
            $data['person'] = $row->related('jun_game2developer.game_id')
                ->where('jun_game2developer.person_id NOT', null)
                ->where('person.type', 'person')
                ->fetchPairs('id', 'person_id');
            $data['pseudonym'] = $row->related('jun_game2developer.game_id')
                ->where('jun_game2developer.person_id NOT', null)
                ->where('person.type', 'pseudonym')
                ->fetchPairs('id', 'person_id');
            $data['group'] = $row->related('jun_game2developer.game_id')->where('group_id NOT', null)->fetchPairs('id', 'group_id');

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
        $form->addMultiSelect('person', 'Developer person', $person);
        $form->addMultiSelect('pseudonym', 'Developer pseudonym', $pseudonym);
        $form->addMultiSelect('group', 'Developer band', $band);

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
            $dest = GameModel::FILE_DIR.\Nette\Utils\Strings::random(20);
            $file->move(getcwd().$dest);
            $data['poster_file'] = $dest;
        }*/

        $gameId = $this->model->save(array(
            'id' => isset($data['id']) ? $data['id'] : 0,
            'original_title' => $data['original_title'],
            'year' => $data['year'],
            'description' => $data['description'],
        ));

        $this->gameDeveloperModel->findBy('game_id', $gameId)->delete();
        foreach ($data['person'] as $person)
        {
            $this->gameDeveloperModel->insert(array(
                'game_id' => $gameId,
                'person_id' => $person
            ));
        }
        foreach ($data['pseudonym'] as $pseudonym)
        {
            $this->gameDeveloperModel->insert(array(
                'game_id' => $gameId,
                'person_id' => $pseudonym
            ));
        }
        foreach ($data['group'] as $band)
        {
            $this->gameDeveloperModel->insert(array(
                'game_id' => $gameId,
                'group_id' => $band
            ));
        }

        $this->flashMessage('Recording successfully saved.', 'success');
        if ($this->presenter->getAction() == 'add')
        {
            $this->presenter->redirect("Game:rate", array('id' => $gameId));
        }
        $this->presenter->redirect('Game:view', array('id' => $gameId));
    }
}
