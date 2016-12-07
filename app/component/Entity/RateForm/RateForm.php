<?php

namespace App\Component;

abstract class RateForm extends BaseComponent
{
    /** @var \App\Model\BaseEntityModel */
    protected $model;

    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    public function render($entityId = 0, $ratingId = 0)
    {
        $Name = $this->presenter->getName();
        $name = lcfirst($Name);

        if ($ratingId)
        {
            $rating = $this->ratingModel->findRow($ratingId);
            if (!$rating || $rating->user_id != $this->presenter->getUser()->getId())
            {
                $this->presenter->flashMessage('You cannot edit this rating.', 'failure');
                $this->presenter->redirect("{$Name}:default");
            }
            $this['form']->setDefaults($rating);
        }
        elseif ($entityId)
        {
            if (!$this->model->findRow($entityId))
            {
                $this->presenter->flashMessage("{$Name} not found.", 'failure');
                $this->presenter->redirect("{$Name}:default");
            }
            $this['form']->setDefaults(array("{$name}_id" => $entityId));
        }

        $this->template->setFile(__DIR__.'/RateForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $Name = $this->presenter->getName();
        $name = lcfirst($Name);

        $userId = $this->presenter->getUser()->getId();
        if ($this->presenter->getAction() == 'rate')
        {
            $entities = $this->model->getNotRated($userId)->fetchPairs('id', 'original_title');
        }
        else
        {
            $entities = $this->model->getRated($userId)->fetchPairs('id', 'original_title');
        }

        $form = new \Nette\Application\UI\Form();
        $form->addHidden('id');
        $form->addSelect("{$name}_id", $Name, $entities)
            ->setPrompt("Select {$name}")
            ->setRequired();
        $form->addSelect('rating', 'Rating', array_combine(range(0, 10, 1), range(0, 10, 1)))
            ->setPrompt('Select rating')
            ->setRequired();
        $form->addTextArea('note', 'Note');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $Name = $this->presenter->getName();
        $name = lcfirst($Name);

        $data = $form->getValues();
        $data['user_id'] = $this->presenter->user->getId();
        $data['date'] = date('Y-m-d');

        $this->ratingModel->save($data);

        $this->presenter->flashMessage('Rating successfully saved.', 'success');
        $this->presenter->redirect("{$Name}:view", array('id' => $data["{$name}_id"]));
    }
}