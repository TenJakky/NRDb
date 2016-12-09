<?php

namespace App\Component;

final class BookForm extends EntityForm
{
    protected $bookAuthorModel;

    public function __construct(
        \App\Model\CountryModel $countryModel,
        \App\Model\PersonModel $personModel,
        \App\Model\BookModel $bookModel,
        \App\Model\BookAuthorModel $bookAuthorModel)
    {
        $this->countryModel = $countryModel;
        $this->personModel = $personModel;
        $this->model = $bookModel;
        $this->bookAuthorModel = $bookAuthorModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->model->findRow($id);

            $data = $row->toArray();
            $data['author'] = $row->related('book2author.book_id')->fetchPairs('id', 'person_id');
            $data['actor'] = $row->related('book2actor.book_id')->fetchPairs('id', 'person_id');

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $person = $this->personModel->fetchSelectBox();

        $form->addHidden('id');
        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addText('year', 'Year')
            ->addRule($form::INTEGER, 'Year must be number')
            ->addRule($form::LENGTH, 'Year must be exactly 4 digit long.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/
        $form->addButton('add_person', 'Add new person');
        $form->addMultiSelect('author', 'Authors', $person)
            ->setRequired();

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

        $bookId = $this->model->save(array(
            'id' => isset($data['id']) ? $data['id'] : 0,
            'original_title' => $data['original_title'],
            'english_title' => $data['english_title'],
            'czech_title' => $data['czech_title'],
            'year' => $data['year'],
            'description' => $data['description'],
        ));

        $this->bookAuthorModel->findBy('book_id', $bookId)->delete();
        foreach ($data['author'] as $person)
        {
            $this->bookAuthorModel->insert(array(
                'book_id' => $bookId,
                'person_id' => $person
            ));
        }

        $this->flashMessage('Book successfully saved.', 'success');
        if ($this->presenter->getAction() == 'add')
        {
            $this->presenter->redirect("Book:rate", array('id' => $bookId));
        }
        $this->presenter->redirect('Book:view', array('id' => $bookId));
    }
}