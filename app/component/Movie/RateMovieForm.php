<?php

namespace App\Component;

class RateMovieForm extends BaseFormComponent
{
    protected $movieModel;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\MovieModel $movieModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        $this->movieModel = $movieModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function render($movieId = 0, $ratingId = 0)
    {
        if ($ratingId)
        {
            $rating = $this->ratingMovieModel->findRow($ratingId);
            if (!$rating || $rating->user_id != $this->presenter->getUser()->getId())
            {
                $this->presenter->flashMessage('You cannot edit this rating.', 'failure');
                $this->presenter->redirect('Movie:default');
            }
            $this['form']->setDefaults($rating);
        }
        elseif ($movieId)
        {
            if (!$this->movieModel->findRow($movieId))
            {
                $this->presenter->flashMessage('Movie not found.', 'failure');
                $this->presenter->redirect('Movie:default');
            }
            $this['form']->setDefaults(array('movie_id' => $movieId));
        }

        parent::render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        if ($this->presenter->getAction() == 'rate')
        {
            $movies = $this->movieModel->query(
                "select 
                movies.id,
                movies.original_title
                from movies
                left join ratings_movie on movies.id = ratings_movie.movie_id and ratings_movie.user_id = 1
                where ratings_movie.user_id is null"
            )->fetchPairs('id', 'original_title');
        }
        else
        {
            $movies = $this->movieModel->query(
                "select 
                movies.id,
                movies.original_title
                from movies
                left join ratings_movie on movies.id = ratings_movie.movie_id and ratings_movie.user_id = 1
                where ratings_movie.user_id = 1"
            )->fetchPairs('id', 'original_title');
        }

        $form->addHidden('id');
        $form->addSelect('movie_id', 'Movie', $movies)
            ->setPrompt('Select movie')
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
        $data = $form->getValues();
        $data['user_id'] = $this->presenter->user->getId();

        $this->ratingMovieModel->save($data);

        $this->presenter->flashMessage('Rating successfully saved.', 'success');
        $this->presenter->redirect('Movie:view', array('id' => $data['movie_id']));
    }
}