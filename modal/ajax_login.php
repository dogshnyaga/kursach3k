<?php
// ajax_login.php - отдельный файл для обработки AJAX-запроса

include('../database/connection.php');
include('../head.php');

header('Content-Type: application/json');

// Инициализация переменных для ошибок
$errors = [
  'emailError' => '',
  'passwordError' => '',
  'generalError' => '',
  'success' => false
];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
  $hasErrors = false;

  // Валидация email
  if (empty($_POST['email'])) {
    $errors['emailError'] = 'Пожалуйста, введите email';
    $hasErrors = true;
  } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $errors['emailError'] = 'Некорректный формат email';
    $hasErrors = true;
  }

  // Валидация пароля
  if (empty($_POST['password'])) {
    $errors['passwordError'] = 'Пожалуйста, введите пароль';
    $hasErrors = true;
  }

  if (!$hasErrors) {
    // Проверка пользователя в базе данных
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $database->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $errors['success'] = true;
      $errors['redirect'] = './';
    } else {
      $errors['generalError'] = 'Неверный email или пароль';
    }
  }
}

echo json_encode($errors);
exit();
