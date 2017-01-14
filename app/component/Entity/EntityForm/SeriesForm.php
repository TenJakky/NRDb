<?php

namespace App\Component;

final class SeriesForm extends EntityForm
{
    protected $seriesDirectorModel;
    protected $seriesActorModel;

    public function __construct(
        \App\Model\SeriesModel $seriesModel,
        \App\Model\SeriesDirectorModel $seriesDirectorModel,
        \App\Model\SeriesActorModel $seriesActorModel)
    {
        $this->model = $seriesModel;
        $this->seriesDirectorModel = $seriesDirectorModel;
        $this->seriesActorModel = $seriesActorModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $this['form']->setDefaults($this->model->findRow($id));
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addHidden('id');
        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addSelect('active', 'Status', array(0 => 'Finished', 1 => 'Running'))
            ->setDefaultValue(1);
        $form->addTextArea('description', 'Description');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $seriesId = $this->model->save($data);

        $this->flashMessage('Series successfully saved.', 'success');
        if ($this->presenter->getAction() == 'add')
        {
            $this->presenter->redirect("Series:rate", array('id' => $seriesId));
        }
        $this->presenter->redirect('Series:view', array('id' => $seriesId));
    }
}
