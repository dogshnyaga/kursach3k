<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $flag = true;
  $email = $_POST['email'];
  $password = $_POST['password'];
}
?>

<div id="loginModal" class="modal">
  <div class="modal-content">
    <div class="close-btn" data-modal="loginModal">&times;</div>
    <form action="" class="form-wrapper" method="post">
      <h1>Вход</h1>
      <div>
        <legend>Введите почту</legend>
        <input type="text" placeholder="yourmail@domen.com" id="email" name="email">
      </div>
      <div>
        <legend>Введите пароль</legend>
        <input type="password" name="password" id="" placeholder="Пароль" id="password">
        <?php
        if (isset($_POST['password'])) {
          if (empty($password)) {
            echo 'Пароль не введен';
            $flag = false;
          }
        }
        ?>

      </div>
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($flag) {
          $sql = "SELECT * FROM users WHERE email = '$email'";
          $result = $database->query($sql)->fetch();

          if ($result) {
            if (password_verify($password, $result['password'])) {
              $_SESSION['user_id'] = $result['id'];
            } else {
              echo 'Неверный пароль';
              $flag = false;
            }
          } else {
            echo 'Пользователь не найден';
          }
        }
      }
      ?>

      <button type="submit" class="btn btn-main">Войти</button>

      <div>
        <button type="button" class="btn btn-no-fill" id="switchToRegister">Регистрация</button>
      </div>
    </form>
  </div>
</div>