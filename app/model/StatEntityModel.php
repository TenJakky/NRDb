<?php

namespace App\Model;

final class StatEntityModel extends \Nepttune\Model\BaseModel
{
    public $tableName = 'stat_entity';

    public function getRatingData()
    {
        return $this->getTable()
            ->select('*, SUM(count) AS total_count, SUM(rating_count) AS total_rating_count')
            ->group('id WITH ROLLUP');
    }
}
