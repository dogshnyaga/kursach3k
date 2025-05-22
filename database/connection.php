<?php
$name = 'root';
$dbname = 'kursach3k';
$password = '';
$host = 'localhost';

try {
  // Исправлено: mysql:host (без пробела) и dbname вместо dname
  $database = new PDO("mysql:host=$host;dbname=$dbname", $name, $password);
} catch (PDOException $e) {
  die("Ошибка подключения к БД: " . $e->getMessage());
}
