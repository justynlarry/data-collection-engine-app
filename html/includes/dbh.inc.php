<?php

//string = type of db:host;db name
$dsn = 'mysql:host=' . genenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
];

// Try catch block, tries to catch errors
try {
    $pdo = new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'), $options);

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}