<?php

return
[
    'paths' => [
        'migrations' => '/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/db/migrations',
        'seeds' => '/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        
        'production' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'production_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'development' => [
            'adapter' => 'sqlite',
            'name' => '/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/db/users',
            'charset' => 'utf8',
        ],
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ],

        'octagon' => [
            'adapter' => 'sqlite',
            'name' => '/home/atwine/nickson/Work/Vue/octagon/slimbackend/src/db/user',
            'charset' => 'utf8',
        ],
    ],
    'version_order' => 'creation'
];
