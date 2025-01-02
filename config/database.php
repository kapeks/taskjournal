<?php

$dbHost = getenv('DB_HOST');
$dbName = getenv('DB_DATABASE');
$dbUser = getenv('DB_USERNAME');
$dbPass = getenv('DB_PASSWORD');

return [
    'db' => [
        'host' => $dbHost,
        'dbname' => $dbName,
        'user' => $dbUser,
        'password' => $dbPass,
    ]
];