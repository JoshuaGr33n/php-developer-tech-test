<?php

namespace App\Repository;

use App\Config\Database;

abstract class BaseRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
