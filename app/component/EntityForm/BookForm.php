<?php

namespace App\Component;

final class BookForm extends EntityForm
{
    protected $bookAuthorModel;

    public function __construct(
        \App\Model\BookModel $bookModel,
        \App\Model\BookAuthorModel $bookAuthorModel)
    {
        $this->model = $bookModel;
        $this->bookAuthorModel = $bookAuthorModel;
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->model->findRow($id);

            $data = $row->toArray();
            foreach($row->related('book2author.book_id') as $author)
            {
                if (isset($author->person_id))
                {
                    $data['person'][] = $author->person_id;
                }
                if (isset($author->pseudonym_id))
                {
                    $data['pseudonym'][] = $author->pseudonym_id;
                }
            }

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $person = $this->personModel->fetchSelectBox();
        $pseudonym = $this->personModel->fetchPseudonymSelectBox();

        $form->addHidden('id');
        $form->addText('original_title', 'Original title')
            ->setRequired();
        $form->addText('english_title', 'English title')
            ->setRequired();
        $form->addText('czech_title', 'Czech title');
        $form->addText('year', 'Year')
            ->addRule($form::INTEGER, 'Year must be number')
            ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4)
            ->setRequired();
        $form->addTextArea('description', 'Description');
        /*$form->addUpload('poster', 'Poster')
            ->addRule(Form::IMAGE, 'Thumbnail must be JPEG, PNG or GIF')
            ->addRule(Form::MAX_FILE_SIZE, 'Maximum file size is 100 kB.', 100 * 1024);*/
        $person = $form->addMultiSelect('person', 'Author person', $person);
        $pseudonym = $form->addMultiSelect('pseudonym', 'Author pseudonym', $pseudonym);
        
        $person->addConditionOn($form['pseudonym'], $form::BLANK)
                ->setRequired();
        $pseudonym->addConditionOn($form['person'], $form::BLANK)
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
        foreach ($data['person'] as $person)
        {
            $this->bookAuthorModel->insert(array(
                'book_id' => $bookId,
                'person_id' => $person
            ));
        }
        foreach ($data['pseudonym'] as $pseudonym)
        {
            $this->bookAuthorModel->insert(array(
                'book_id' => $bookId,
                'pseudonym_id' => $pseudonym
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