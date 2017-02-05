<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => 'pgsql:host=192.168.0.4;port=5432;dbname=test',
    'username' => 'test',
    'password' => 'secret',
    'charset' => 'utf8',
    'schemaMap' => [
        'pgsql' => [
            'class' => \yii\db\pgsql\Schema::class,
            'defaultSchema' => 'public'
        ],
    ],
];
