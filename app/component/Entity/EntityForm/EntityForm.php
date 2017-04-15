<?php

namespace App\Component;

final class EntityForm extends BaseComponent
{
    /** @var \App\Model\EntityModel */
    protected $entityModel;

    /** @var \App\Model\ArtistModel */
    protected $artistModel;

    /** @var \App\Model\ArtistEntityModel */
    protected $artistEntityModel;

    /** @var \Nette\Database\Connection */
    protected $connection;

    public function __construct(
        \App\Model\EntityModel $entityModel,
        \App\Model\ArtistModel $artistModel,
        \App\Model\ArtistEntityModel $artistEntityModel,
        \Nette\Database\Connection $connection)
    {
        $this->entityModel = $entityModel;
        $this->artistModel = $artistModel;
        $this->artistEntityModel = $artistEntityModel;
        $this->connection = $connection;
    }

    public function createComponent($name, array $args = null)
    {
        if ($name === 'form')
        {
            return $this->createComponentForm();
        }

        $form = parent::createComponent($name, $args);

        $form['form']->getElementPrototype()->addClass('ajax');
        $form['form']->onSuccess[] = [$this, 'redrawSnippets'];
    
        return $form;
    }

    public function redrawSnippets()
    {
        $this->redrawControl('formSnippet');
        $this->redrawControl('artistFormSnippet');
    }

    public function render($id = 0)
    {
        if ($id)
        {
            $row = $this->entityModel->findRow($id);
            $data = $row->toArray();

            foreach (\App\Enum\TypeToRole::ROLES[$row->type] as $role)
            {
                $data[$role] = $row
                    ->related('jun_artist2entity')
                    ->where('role', $role)
                    ->fetchPairs('id', 'artist_id');
            }

            $this['form']->setDefaults($data);
        }

        $this->template->setFile(__DIR__.'/EntityForm.latte');
        $this->template->render();
    }

    public function createComponentForm()
    {
        $form = new \Nette\Application\UI\Form();

        $form->addHidden('id');

        $form->addRadioList('type', 'Type', $this->presenter->locale['entity'])
            ->setDefaultValue($this->presenter->type)
            ->setRequired()
            ->addCondition($form::EQUAL, 'movie')
                ->toggle('titleSection')
                ->toggle('langSection')
                ->toggle('yearSection')
                ->toggle('movieSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'series')
                ->toggle('titleSection')
                ->toggle('langSection')
                ->toggle('seriesSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'season')
                ->toggle('seasonSection')
                ->toggle('yearSection')
                ->toggle('movieSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'book')
                ->toggle('titleSection')
                ->toggle('langSection')
                ->toggle('yearSection')
                ->toggle('bookSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'music')
                ->toggle('titleSection')
                ->toggle('yearSection')
                ->toggle('musicSection')
            ->endCondition()
            ->addCondition($form::EQUAL, 'game')
                ->toggle('titleSection')
                ->toggle('yearSection')
                ->toggle('gameSection')
            ->endCondition();

        $form->addText('original_title', 'Original title')
            ->setRequired();

        $form->addText('english_title', 'English title')
            ->addConditionOn($form['type'], $form::EQUAL, ['movie', 'series', 'book'])
                ->setRequired();
        $form->addText('czech_title', 'Czech title');

        $form->addCheckbox('series_active', 'Active')
            ->addConditionOn($form['type'], $form::EQUAL, 'series')
                ->setRequired();

        $form->addSelect('series_id', 'Series', $this->entityModel->fetchSeriesSelectBox())
            ->addConditionOn($form['type'], $form::EQUAL, 'season')
                ->setRequired();
        $form->addText('season_number', 'Season number')
            ->addConditionOn($form['type'], $form::EQUAL, 'season')
                ->setRequired();

        $form->addText('year', 'Year')
            ->addConditionOn($form['type'], $form::EQUAL, ['movie', 'season', 'book', 'music', 'game'])
                ->setRequired()
            ->addCondition($form::FILLED)
                ->addRule($form::INTEGER, 'Year must be integer.')
                ->addRule($form::MAX_LENGTH, 'Year cannot be longer than 4 digits.', 4);

        $artists = $this->artistModel->fetchSelectBox();

        $form->addMultiSelect('director', 'Director', $artists)
            ->setAttribute('placeholder', 'Choose directors')
            ->addConditionOn($form['type'], $form::EQUAL, ['movie', 'season'])
                ->setRequired();
        $form->addMultiSelect('actor', 'Actor', $artists)
            ->setAttribute('placeholder', 'Choose actors');

        $form->addMultiSelect('author', 'Writer', $artists)
            ->setAttribute('placeholder', 'Choose writers')
            ->addConditionOn($form['type'], $form::EQUAL, 'book')
                ->setRequired();

        $form->addMultiSelect('interpret', 'Interpret', $artists)
            ->setAttribute('placeholder', 'Choose interprets')
            ->addConditionOn($form['type'], $form::EQUAL, 'music')
                ->setRequired();

        $form->addMultiSelect('developer', 'Developer', $artists)
            ->setAttribute('placeholder', 'Choose developers')
            ->addConditionOn($form['type'], $form::EQUAL, 'game')
                ->setRequired();

        $form->addTextArea('description', 'Description');

        $form->addSubmit('submit', 'Submit');
        $form->onSuccess[] = [$this, 'formSubmitted'];

        return $form;
    }

    public function formSubmitted(\Nette\Application\UI\Form $form)
    {
        $data = $form->getValues();

        $this->connection->beginTransaction();

        if ($data['id'])
        {
            $this->artistEntityModel->findBy('entity_id', $data['id'])->delete();
        }

        switch ($data['type'])
        {
            default:
            case 'movie':
            case 'book':
                $id = $this->entityModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'original_title' => $data['original_title'],
                    'english_title' => $data['english_title'],
                    'czech_title' => $data['czech_title'],
                    'year' => $data['year'],
                    'description' => $data['description']
                ]);
                break;
            case 'series':
                $id = $this->entityModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'original_title' => $data['original_title'],
                    'english_title' => $data['english_title'],
                    'czech_title' => $data['czech_title'],
                    'series_active' => $data['series_active'],
                    'description' => $data['description']
                ]);
                break;
            case 'season':
                $id = $this->entityModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'series_id' => $data['series_id'],
                    'season_number' => $data['season_number'],
                    'year' => $data['year'],
                    'description' => $data['description']
                ]);
                break;
            case 'music':
            case 'game':
                $id = $this->entityModel->save([
                    'id' => $data['id'],
                    'type' => $data['type'],
                    'original_title' => $data['original_title'],
                    'year' => $data['year'],
                    'description' => $data['description']
                ]);
                break;
        }

        foreach (\App\Enum\TypeToRole::ROLES[$data['type']] as $role)
        {
            foreach ($data[$role] as $artist)
            {
                $this->artistEntityModel->insert(array(
                    'entity_id' => $id,
                    'artist_id' => $artist,
                    'role' => $role
                ));
            }
        }

        $this->connection->commit();

        $this->presenter->flashMessage('Entity successfully saved.', 'success');

        if ($this->presenter->isAjax())
        {
            $this->presenter->redrawControl('flash');
            return;
        }

        $this->presenter->redirect('Entity:rate', array('id' => $id));
    }
}
