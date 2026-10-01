<?php
try {
    $dsn = 'mysql:dbname=test;host=127.0.0.1';
    $userdb = 'root';
    $passworddb = '';
    $conn = new PDO($dsn, $userdb, $passworddb);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    var_dump($e);
}
