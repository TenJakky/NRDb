<?php

namespace App\Component;

final class SeasonForm extends EntityForm
{
    /** @var \App\Model\SeasonDirectorModel */
    protected $seasonDirectorModel;

    /** @var \App\Model\SeasonActorModel */
    protected $seasonActorModel;

    /** @var \App\Model\SeriesModel */
    protected $seriesModel;

    public function __construct(
        \App\Model\SeasonModel $seasonModel,
        \App\Model\SeasonDirectorModel $seasonDirectorModel,
        \App\Model\SeasonActorModel $seasonActorModel,
        \App\Model\SeriesModel $seriesModel)
    {
        $this->model = $seasonModel;
        $this->seasonDirectorModel = $seasonDirectorModel;
        $this->seasonActorModel = $seasonActorModel;
        $this->seriesModel = $seriesModel;
    }

    public function render($seasonId = 0, $seriesId = 0)
    {
        if ($seasonId)
        {
            $row = $this->model->findRow($seasonId);

            $data = $row->toArray();
            $data['director'] = $row->related('jun_season2director.season_id')->fetchPairs('id', 'person_id');
            $data['actor'] = $row->related('jun_season2actor.season_id')->fetchPairs('id', 'person_id');

            $this['form']->setDefaults($data);
        }
        elseif ($seriesId)
        {
            $this['form']->setDefaults(array('series_id' => $seriesId));
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $person = $this->personModel->fetchSelectBox();

        $form->addHidden('id');
        $form->addSelect('series_id', 'Series', $this->seriesModel->getTable()->fetchPairs('id', 'original_title'))
            ->setRequired();
        $form->addText('number', 'Season number')
            ->addRule($form::INTEGER, 'Input must contain number.')
            ->setRequired();
        $form->addText('year', 'Year')
            ->addRule($form::INTEGER, 'Year must be number')
            ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description');
        $form->addMultiSelect('director', 'Directors', $person);
        $form->addMultiSelect('actor', 'Actors', $person);

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $seasonId = $this->model->save(array(
            'id' => isset($data['id']) ? $data['id'] : 0,
            'series_id' => $data['series_id'],
            'number' => $data['number'],
            'year' => $data['year'],
            'description' => $data['description'],
        ));

        $this->seasonDirectorModel->findBy('season_id', $seasonId)->delete();
        foreach ($data['director'] as $person)
        {
            $this->seasonDirectorModel->insert(array(
                'season_id' => $seasonId,
                'person_id' => $person
            ));
        }

        $this->seasonActorModel->findBy('season_id', $seasonId)->delete();
        foreach ($data['actor'] as $person)
        {
            $this->seasonActorModel->insert(array(
                'season_id' => $seasonId,
                'person_id' => $person
            ));
        }

        $this->flashMessage('Season successfully saved.', 'success');
        if ($this->presenter->getAction() === 'add')
        {
            $this->presenter->redirect("Season:rate", array('id' => $seasonId));
        }
        $this->presenter->redirect('Season:view', array('id' => $seasonId));
    }
}
