<?php
$name = 'root';
$dbname = 'kursach3k';
$password = '';
$host = 'localhost';

try {
  $database = new PDO("mysql:host=$host;dbname=$dbname", $name, $password);
} catch (PDOException $e) {
  die("Ошибка подключения к БД: " . $e->getMessage());
}
