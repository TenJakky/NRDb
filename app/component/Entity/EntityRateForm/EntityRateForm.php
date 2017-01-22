<?php

namespace App\Component;

abstract class EntityRateForm extends BaseComponent
{
    /** @var \App\Model\BaseEntityModel */
    protected $model;

    /** @var \App\Model\BaseRatingModel */
    protected $ratingModel;

    public function render($entityId = 0, $ratingId = 0)
    {
        $pName = $this->presenter->getName();
        $pname = lcfirst($pName);

        if ($ratingId)
        {
            $this['form']->setDefaults($this->ratingModel->findRow($ratingId));
        }
        elseif ($entityId)
        {
            $this['form']->setDefaults(array("{$pname}_id" => $entityId));
        }

        $this->template->pname = $pname;
        $this->template->setFile(__DIR__.'/EntityRateForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $pName = $this->presenter->getName();
        $pname = lcfirst($pName);

        $userId = $this->presenter->getUser()->getId();

        $entities = $this->presenter->getAction() === 'rate' ?
            $this->model->getNotRated($userId)->fetchPairs('id', 'original_title') :
            $this->model->getRated($userId)->fetchPairs('id', 'original_title');

        $form = new \Nette\Application\UI\Form();
        $form->addHidden('id');
        $form->addSelect("{$pname}_id", $pName, $entities)
            ->setPrompt("Select {$pname}")
            ->setRequired();
        $rating = $form->addRadioList('rating', 'Rating', array_combine(range(10, 0, -1), range(10, 0, -1)))
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
        $pName = $this->presenter->getName();
        $pname = lcfirst($pName);

        $data = $form->getValues();
        $data['user_id'] = $this->presenter->user->getId();
        $data['date'] = date('Y-m-d');

        $this->ratingModel->save($data);

        $this->presenter->flashMessage('Rating successfully saved.', 'success');
        $this->presenter->redirect("{$pName}:view", array('id' => $data["{$pname}_id"]));
    }
}