<?php
// ajax_register.php

header('Content-Type: application/json');
include('../database/connection.php');
include('../head.php');

$response = [
  'success' => false,
  'errors' => [
    'name' => '',
    'email' => '',
    'phone' => '',
    'password' => '',
    'confirm_password' => '',
    'general' => ''
  ],
  'redirect' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';

  // Валидация
  if (empty($name)) $response['errors']['name'] = 'Пожалуйста, введите имя';

  if (empty($email)) {
    $response['errors']['email'] = 'Пожалуйста, введите email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['errors']['email'] = 'Некорректный формат email';
  } else {
    $stmt = $database->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) $response['errors']['email'] = 'Пользователь с таким email уже существует';
  }

  if (empty($phone)) $response['errors']['phone'] = 'Пожалуйста, введите телефон';

  if (empty($password)) {
    $response['errors']['password'] = 'Пожалуйста, введите пароль';
  } elseif (strlen($password) < 6) {
    $response['errors']['password'] = 'Пароль должен содержать минимум 6 символов';
  }

  if ($password !== $confirm_password) {
    $response['errors']['confirm_password'] = 'Пароли не совпадают';
  }

  // Если нет ошибок - регистрируем
  if (empty(array_filter($response['errors']))) {
    try {
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
      $stmt = $database->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
      $stmt->execute([$name, $email, $phone, $hashedPassword]);

      $_SESSION['user'] = [
        'id' => $database->lastInsertId(),
        'name' => $name,
        'email' => $email,
        'phone' => $phone
      ];

      $response['success'] = true;
      $response['redirect'] = './'; // Или другую страницу после успешной регистрации
    } catch (PDOException $e) {
      $response['errors']['general'] = 'Ошибка при регистрации: ' . $e->getMessage();
    }
  }
}

echo json_encode($response);
exit();
