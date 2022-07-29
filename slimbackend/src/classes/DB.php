<?php

class DB
{
  
    public function connect()
    {
        $conn = new PDO('sqlite:/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/db/user.sqlite3');;
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
    }
}