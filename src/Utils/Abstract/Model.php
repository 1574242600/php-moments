<?php

namespace Utils\Abstract;

use Medoo\Medoo;

abstract class Model
{
    protected Medoo $db;

    public function __construct(Medoo &$db)
    {
        $this->db = $db;
    }
}
