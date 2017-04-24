<?php

namespace App\Model;

final class LogLoginModel extends BaseModel
{
    public $tableName = 'log_login';

    public function showCaptcha(string $address)
    {
        $row = $this->getTable()
            ->select('result')
            ->where("ip_address = INET6_ATON('$address')")
            ->order('id DESC')
            ->limit(1)
            ->fetch();

        return $row ? ($row->result === 'failure') : false;
    }
}
