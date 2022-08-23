<?php
$host = '127.0.0.1';
$username = 'root';
$password = 'pass';
$db_name = 'testdb';
$dsn = 'mysql:dbname=testdb;host=127.0.0.1';

$pdo = new PDO($dsn, $username, $password);
?>