<?php

namespace App\Component;

use App\Model\MovieModel;
use Nette\Forms\Form;

class MovieForm extends BaseFormComponent
{
    protected $personModel;
    protected $moviesModel;
    protected $countryModel;
    protected $ratingMovieModel;
    protected $movieDirectorModel;

    public function __construct(
        \App\Model\PersonModel $personModel,
        \App\Model\MovieModel $moviesModel,
        \App\Model\CountryModel $countryModel,
        \App\Model\RatingMovieModel $ratingMovieModel,
        \App\Model\MovieDirectorModel $movieDirectorModel)
    {
        $this->personModel = $personModel;
        $this->moviesModel = $moviesModel;
        $this->countryModel = $countryModel;
        $this->ratingMovieModel = $ratingMovieModel;
        $this->movieDirectorModel = $movieDirectorModel;
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $directors = $this->personModel->fetchSelectBox();
        $countries = $this->countryModel->findAll()->fetchPairs('id', 'name');

        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addText('year', 'Year')
            ->addRule(Form::INTEGER, 'Year must be number')
            ->addRule(Form::MIN_LENGTH, 'Year must be at least 4 digit long.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description')
            ->setOption('description', 'IMDB has nice short descriptions.');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/

        $form->addMultiSelect('director', 'Director', $directors)
            ->setOption('description', 'If your director is not in this list, please fill the details below.');
        $form->addText('name', 'Director name')
            ->addConditionOn($form['director'], Form::BLANK)
                ->setRequired();
        $form->addText('surname', 'Director surname')
            ->addConditionOn($form['director'], Form::BLANK)
                ->setRequired();
        $form->addSelect('country_id', 'Director nationality', $countries)
            ->setPrompt('Select nationality')
            ->addConditionOn($form['director'], Form::BLANK)
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

        $movie = $this->moviesModel->insert(array(
            'original_title' => $data['original_title'],
            'english_title' => $data['english_title'],
            'czech_title' => $data['czech_title'],
            'year' => $data['year'],
            'description' => $data['description'],
        ));

        $this->ratingMovieModel->insert(array(
            'rating' => $data['rating'],
            'movie_id' => $movie->id,
            'user_id' => $this->presenter->user->id,
            'note' => $data['note'],
            'date' => date('Y-m-d')
        ));

        if (!empty($data['director']))
        {
            foreach ($data['director'] as $person)
            {
                $this->movieDirectorModel->insert(array(
                    'movie_id' => $movie->id,
                    'person_id' => $person
                ));
            }
        }
        else
        {
            $director = $this->personModel->insert(array(
                'name' => $data['name'],
                'surname'=>$data['surname'],
                'country_id'=>$data['country_id']));

            $movieDirector = array();
            $movieDirector['person_id'] = $director->id;
        }

        $this->flashMessage('Movie successfully saved.', 'success');
        $this->presenter->redirect('Movie:view', array('id' => $movie->id));
    }
}
