<?php

namespace \Models;

use \PDO;

class DB
{
  
    public function connect()
    {
        $conn = new PDO('sqlite:/home/atwine/nickson/Work/Vue/octagon/slimbackend/db/users.sqlite3');
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}