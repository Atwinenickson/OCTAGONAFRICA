<?php

require 'vendor/autoload.php';



$pdo = new \PDO("sqlite:" .db/phpsqlite.db);
if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
else
    echo 'Whoops, could not connect to the SQLite database!';

