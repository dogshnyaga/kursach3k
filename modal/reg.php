<?php
// register.php
session_start();

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $phone = trim($_POST['phone'] ?? '');
  $password = $_POST['password'] ?? '';
  $confirm_password = $_POST['confirm_password'] ?? '';

  // Валидация
  if (empty($name)) $errors['name'] = 'Пожалуйста, введите имя';

  if (empty($email)) {
    $errors['email'] = 'Пожалуйста, введите email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'Некорректный формат email';
  } else {
    try {
      $stmt = $database->prepare("SELECT id FROM users WHERE email = ?");
      $stmt->execute([$email]);
      if ($stmt->fetch()) $errors['email'] = 'Пользователь с таким email уже существует';
    } catch (PDOException $e) {
      $errors['database'] = 'Ошибка при проверке email';
    }
  }

  if (empty($phone)) $errors['phone'] = 'Пожалуйста, введите телефон';
  if (empty($password)) $errors['password'] = 'Пожалуйста, введите пароль';
  elseif (strlen($password) < 6) $errors['password'] = 'Пароль должен содержать минимум 6 символов';
  if ($password !== $confirm_password) $errors['confirm_password'] = 'Пароли не совпадают';

  // Регистрация
  if (empty($errors)) {
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

      $success = true;
    } catch (PDOException $e) {
      $errors['database'] = 'Ошибка при регистрации';
    }
  }
}
?>

<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" data-modal="registerModal">&times;</span>
    <form action="" method="POST" class="form-wrapper">
      <h1>Регистрация</h1>

      <?php if ($success): ?>
        <div class="success">Регистрация прошла успешно!</div>
      <?php elseif (isset($errors['database'])): ?>
        <div class="error"><?= $errors['database'] ?></div>
      <?php endif; ?>

      <div>
        <legend>Имя</legend>
        <input type="text" name="name" placeholder="Иван Иванов" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        <?php if (isset($errors['name'])): ?>
          <div class="error"><?= $errors['name'] ?></div>
        <?php endif; ?>

        <legend>Почта</legend>
        <input type="text" name="email" placeholder="yourmail@domen.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        <?php if (isset($errors['email'])): ?>
          <div class="error"><?= $errors['email'] ?></div>
        <?php endif; ?>

        <legend>Телефон</legend>
        <input type="text" name="phone" placeholder="+7 (000) 000 00 00" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
        <?php if (isset($errors['phone'])): ?>
          <div class="error"><?= $errors['phone'] ?></div>
        <?php endif; ?>
      </div>
      <div>
        <legend>Введите пароль</legend>
        <input type="password" name="password" placeholder="Пароль">
        <?php if (isset($errors['password'])): ?>
          <div class="error"><?= $errors['password'] ?></div>
        <?php endif; ?>

        <legend>Повторите пароль</legend>
        <input type="password" name="confirm_password" placeholder="Пароль">
        <?php if (isset($errors['confirm_password'])): ?>
          <div class="error"><?= $errors['confirm_password'] ?></div>
        <?php endif; ?>
      </div>
      <div>
        <button type="submit" class="btn btn-main">Зарегистрироваться</button>
      </div>
      <div>
        <legend>Уже есть аккаунт?</legend>
        <button type="button" class="btn btn-no-fill" id="switchToLogin">Войти</button>
      </div>
    </form>
  </div>
</div>