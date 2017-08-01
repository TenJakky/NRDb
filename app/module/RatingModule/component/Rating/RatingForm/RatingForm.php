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

    public function attached($presenter)
    {
        parent::attached($presenter);

        $presenter->addStyle('/scss/dist/ratingForm.css');
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addHidden('control', $this->getPresenter()->getParameter('control'));

        $rating = $form->addRadioList('value', 'Rating', array_combine(range(10, 0, -1), range(10, 0, -1)))
            ->setRequired();
        $rating->getContainerPrototype()->id = 'rating';
        $rating->getSeparatorPrototype()->setName(null);

        $form->addTextArea('note', 'Note');
        $form->addSubmit('submit', 'Submit');

        if ($this->getPresenter()->getAction() === 'editRating')
        {
            $form->setDefaults($this->ratingModel->findRow($this->getPresenter()->getId()));
            $form->addSubmit('remove', 'Remove rating');
        }

        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();
        $data['date'] = date('Y-m-d');
        $data['user_id'] = $this->getPresenter()->user->getId();

        $controlName = $data['control'];
        unset($data['control']);

        switch ((string) $this->getPresenter()->getAction())
        {
            case 'rate':
                $data['entity_id'] = $this->getPresenter()->getId();
                $row = $this->ratingModel->save($data);
                $this->getPresenter()->flashMessage('Rating successfully saved.', 'success');
                break;
            case 'editRating':
                $row = $this->ratingModel->findRow($this->getPresenter()->getId());
                if ($form->isSubmitted()->getName() === 'remove')
                {
                    $row->delete();
                    $this->getPresenter()->flashMessage('Rating successfully removed.', 'success');
                    break;
                }
                $row->update($data);
                $this->getPresenter()->flashMessage('Rating successfully updated.', 'success');
                break;
            default: return;
        }

        switch ((string) $controlName)
        {
            case 'entityList':
            case 'recentEntitySmallList':
            case 'topEntitySmallList':
            case 'notRatedEntitySmallList':
                $redraw = [$controlName, $row->entity_id]; break;
            default:
                $redraw = [$controlName];
        }

        $this->getPresenter()->forward('Entity:closeFancy', $redraw);
    }
}
