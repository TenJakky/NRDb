<?php

namespace App\Component;

final class RatingForm extends BaseRenderComponent
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

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $rating = $form->addRadioList('value', 'Rating', array_combine(range(10, 0, -1), range(10, 0, -1)))
            ->setRequired();
        $rating->getContainerPrototype()->id = 'rating';
        $rating->getSeparatorPrototype()->setName(null);

        $form->addTextArea('note', 'Note');
        $form->addSubmit('submit', 'Submit');

        if ($this->presenter->getAction() === 'editRating')
        {
            $form->setDefaults($this->ratingModel->findRow($this->presenter->getId()));
            $form->addSubmit('remove', 'Remove rating');
        }

        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();
        $data['date'] = date('Y-m-d');
        $data['user_id'] = $this->presenter->user->getId();

        switch ($this->presenter->getAction())
        {
            case 'rate':
                $data['entity_id'] = $this->presenter->getId(); break;
            case 'editRating':
                $data['id'] = $this->presenter->getId(); break;
            default: return;
        }

        if ($form->isSubmitted()->getName() === 'remove' && $this->presenter->getAction() === 'editRating')
        {
            $this->ratingModel->findRow($this->presenter->getId())->delete();

            $this->presenter->flashMessage('Rating successfully removed.', 'success');
            $this->presenter->redirect('Entity:closeFancy', ['entityList', $data['entity_id']]);
        }

        $row = $this->ratingModel->save($data);

        $this->presenter->flashMessage('Rating successfully saved.', 'success');
        $this->presenter->redirect('Entity:closeFancy', ['entityList', $row->entity_id]);
    }
}
