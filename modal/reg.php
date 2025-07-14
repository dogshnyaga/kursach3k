<div id="registerModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" data-modal="registerModal">&times;</span>
    <form id="registerForm" class="form-wrapper">
      <h1>Регистрация</h1>

      <div id="registerGeneralError" class="error-message general-error" style="display: none;"></div>
      <div id="registerSuccess" class="success-message" style="display: none;">Регистрация прошла успешно!</div>

      <div class="form-group">
        <label for="register_name">Имя</label>
        <input type="text" id="register_name" name="name" required>
        <div id="registerNameError" class="error-message" style="display: none;"></div>
        <label for="register_email">Почта</label>
        <input type="email" id="register_email" name="email" required>
        <div id="registerEmailError" class="error-message" style="display: none;"></div>
        <label for="register_phone">Телефон</label>
        <input type="tel" id="register_phone" name="phone" required>
        <div id="registerPhoneError" class="error-message" style="display: none;"></div>
      </div>

      <div class="form-group">
        <label for="register_password">Пароль</label>
        <input type="password" id="register_password" name="password" required>
        <div id="registerPasswordError" class="error-message" style="display: none;"></div>
        <label for="register_confirm_password">Повторите пароль</label>
        <input type="password" id="register_confirm_password" name="confirm_password" required>
        <div id="registerConfirmPasswordError" class="error-message" style="display: none;"></div>
      </div>

      <div class="form-group">

        <button type="submit" class="btn btn-main">Зарегистрироваться</button>
        <small>Регистрируясь вы соглашаетесь с <a style="color: #F97400;" href="https://drive.google.com/uc?export=download&id=1KHYByAgzbssaoits4Hr_lrDdnqPmmQn4">пользовательским соглашением</a></small>
      </div>
      <div class="form-footer">
        <span>Уже есть аккаунт?</span>
        <button type="button" class="btn btn-no-fill" id="switchToLogin">Войти</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.getElementById('registerForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Скрываем все предыдущие сообщения об ошибках и успехе
    document.getElementById('registerGeneralError').style.display = 'none';
    document.getElementById('registerSuccess').style.display = 'none';
    document.getElementById('registerNameError').style.display = 'none';
    document.getElementById('registerEmailError').style.display = 'none';
    document.getElementById('registerPhoneError').style.display = 'none';
    document.getElementById('registerPasswordError').style.display = 'none';
    document.getElementById('registerConfirmPasswordError').style.display = 'none';

    // Получаем данные формы
    const formData = new FormData(this);

    // Отправляем AJAX-запрос
    fetch('modal/ajax_register.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          // Успешная регистрация
          document.getElementById('registerSuccess').style.display = 'block';
          // Перенаправляем через 1.5 секунды
          setTimeout(() => {
            window.location.href = data.redirect;
          }, 1500);
        } else {
          // Показываем общую ошибку, если есть
          if (data.errors.general) {
            const generalError = document.getElementById('registerGeneralError');
            generalError.textContent = data.errors.general;
            generalError.style.display = 'block';
          }

          // Показываем ошибки для каждого поля
          if (data.errors.name) {
            const nameError = document.getElementById('registerNameError');
            nameError.textContent = data.errors.name;
            nameError.style.display = 'block';
          }

          if (data.errors.email) {
            const emailError = document.getElementById('registerEmailError');
            emailError.textContent = data.errors.email;
            emailError.style.display = 'block';
          }

          if (data.errors.phone) {
            const phoneError = document.getElementById('registerPhoneError');
            phoneError.textContent = data.errors.phone;
            phoneError.style.display = 'block';
          }

          if (data.errors.password) {
            const passwordError = document.getElementById('registerPasswordError');
            passwordError.textContent = data.errors.password;
            passwordError.style.display = 'block';
          }

          if (data.errors.confirm_password) {
            const confirmPasswordError = document.getElementById('registerConfirmPasswordError');
            confirmPasswordError.textContent = data.errors.confirm_password;
            confirmPasswordError.style.display = 'block';
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        const generalError = document.getElementById('registerGeneralError');
        generalError.textContent = 'Произошла ошибка при отправке формы';
        generalError.style.display = 'block';
      });
  });
</script>