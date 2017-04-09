<?php

namespace App\Component;

class RatingForm extends BaseComponent
{
    /** @var \App\Model\EntityModel */
    protected $model;

    /** @var \App\Model\RatingModel */
    protected $ratingModel;

    public function __construct(
        \App\Model\EntityModel $model,
        \App\Model\RatingModel $ratingModel)
    {
        $this->model= $model;
        $this->ratingModel = $ratingModel;
    }

    public function render($entityId = 0, $ratingId = 0)
    {
        if ($ratingId)
        {
            $this['form']->setDefaults($this->ratingModel->findRow($ratingId));
        }
        elseif ($entityId)
        {
            $this['form']->setDefaults(array("entity_id" => $entityId));
        }

        $this->template->setFile(__DIR__ . '/RatingForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $userId = $this->presenter->getUser()->getId();

        $entities = $this->presenter->getAction() === 'rate' ?
            $this->model->getNotRated($userId)->fetchPairs('id', 'original_title') :
            $this->model->getRated($userId)->fetchPairs('id', 'original_title');

        $form = new \Nette\Application\UI\Form();
        $form->addHidden('id');
        $form->addSelect("entity_id", 'Entity', $entities)
            ->setPrompt("Select Entity")
            ->setRequired();
        $rating = $form->addRadioList('value', 'Rating', array_combine(range(10, 0, -1), range(10, 0, -1)))
            ->setRequired();
        $rating->getContainerPrototype()->id = 'rating';
        $rating->getSeparatorPrototype()->setName(null);
        $form->addTextArea('note', 'Note');
        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();
        $data['user_id'] = $this->presenter->user->getId();
        $data['date'] = date('Y-m-d');

        $this->ratingModel->save($data);

        $this->presenter->flashMessage('Rating successfully saved.', 'success');
        $this->presenter->redirect("Entity:view", array('id' => $data["entity_id"]));
    }
}