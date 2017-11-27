<?php

namespace App\Model;

final class IntroductionModel extends \Peldax\NetteInit\Model\BaseModel
{
    public $tableName = 'adm_introduction';

    public function getIntroduction()
    {
        return $this->findBy('active', 1)->order('id DESC')->fetch()->text;
    }
}