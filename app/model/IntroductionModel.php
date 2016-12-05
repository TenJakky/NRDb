<?php

namespace App\Model;

class IntroductionModel extends BaseModel
{
    public $tableName = 'introduction';

    public function getIntroduction()
    {
        return $this->findBy('active', 1)->order('id DESC')->fetch()->text;
    }
}