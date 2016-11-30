<?php

namespace App\Component;

use App\Model\MovieModel;
use Nette\Forms\Form;

class MovieForm extends BaseFormComponent
{
    protected $directorModel;
    protected $moviesModel;
    protected $countryModel;
    protected $ratingMovieModel;

    public function __construct(
        \App\Model\DirectorModel $directorModel,
        \App\Model\MovieModel $moviesModel,
        \App\Model\CountryModel $countryModel,
        \App\Model\RatingMovieModel $ratingMovieModel)
    {
        $this->directorModel = $directorModel;
        $this->moviesModel = $moviesModel;
        $this->countryModel = $countryModel;
        $this->ratingMovieModel = $ratingMovieModel;
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $directors = $this->directorModel->fetchSelectBox();
        $countries = $this->countryModel->findAll()->fetchPairs('id', 'name');

        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addText('year', 'Year')
            ->addRule(Form::INTEGER, 'Year must be number')
            ->setRequired();
        $form->addTextArea('description', 'Description')
            ->setOption('description', 'IMDB has nice short descriptions.');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/

        $form->addSelect('director_id', 'Director', $directors)
            ->setHtmlId('input_director')
            ->setPrompt('Select director')
            ->setOption('description', 'If your director is not in this list, please fill the details below.');
        $form->addText('name', 'Director name')
            ->addConditionOn($form['director_id'], Form::BLANK)
                ->setRequired();
        $form->addText('surname', 'Director surname')
            ->addConditionOn($form['director_id'], Form::BLANK)
                ->setRequired();
        $form->addSelect('country_id', 'Director nationality', $countries)
            ->setPrompt('Select nationality')
            ->addConditionOn($form['director_id'], Form::BLANK)
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

        /*$file = $data['poster'];
        if($file->isOk() && $file->isImage())
        {
            $dest = MovieModel::FILE_DIR.\Nette\Utils\Strings::random(20);
            $file->move(getcwd().$dest);
            $data['poster_file'] = $dest;
        }*/

        $rating = array();
        $rating['rating'] = $data['rating'];
        $rating['user_id'] = $this->presenter->user->id;
        $rating['note'] = $data['note'];

        if (!isset($data['director_id']))
        {
            $director = $this->directorModel->insert(array('name'=>$data['name'], 'surname'=>$data['surname'], 'country_id'=>$data['country_id']));
            $data['director_id'] = $director->id;
        }

        unset($data['note']);
        unset($data['name']);
        unset($data['poster']);
        unset($data['surname']);
        unset($data['country_id']);
        unset($data['rating']);

        $movie = $this->moviesModel->insert($data);

        $rating['movie_id'] = $movie->id;
        $this->ratingMovieModel->insert($rating);

        $this->flashMessage('Movie successfully saved.', 'success');
        $this->presenter->redirect('Movie:view', array('id' => $movie->id));
    }
}
