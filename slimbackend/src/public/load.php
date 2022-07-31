#!/usr/bin/env php
<?php

require_once '/home/atwine/nickson/Work/Vue/octagon/slimbackend/vendor/autoload.php';

use OAuth2\Storage\Pdo as PdoStorage;

// Create a pdo object(Connect to database and store oauthclients)

$pdo = new \PDO('sqlite:' . __DIR__ . '/slim_oauth2.db');
$storage = new PdoStorage($pdo);
foreach (explode(';', $storage->getBuildSql()) as $statement) {
    $result = $pdo->exec($statement);
}

// set up clients
$sql = 'INSERT INTO oauth_clients (client_id, client_secret, scope, redirect_uri) VALUES (?, ?, ?, ?)';
$pdo->prepare($sql)->execute(['octagon', 'secret', null, '/receive-code']);
$pdo->prepare($sql)->execute(['employee', 's3cr3t', null, null]);