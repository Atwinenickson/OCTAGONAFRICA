<?php

require 'vendor/autoload.php';



$pdo = new PDO('sqlite:/home/atwine/nickson/Work/Vue/octagon/slimbackend/db/users.sqlite3');
if ($pdo != null)
    echo 'Connected to the SQLite database successfully!';
else
    echo 'Whoops, could not connect to the SQLite database!';

$result = $pdo ->query("SELECT * FROM users");

foreach($result as $row)
{
    print $row['lastname'] . "\n";
}

?>