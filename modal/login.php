<div id="loginModal" class="modal">
  <div class="modal-content">
    <span class="close-btn" data-modal="loginModal">&times;</span>
    <form id="loginForm" class="form-wrapper">
      
      <h1>Вход</h1>

      <div id="loginGeneralError" class="error-message general-error" style="display: none;"></div>

      <div class="form-group">
        <label for="login_email">Введите почту</label>
        <input type="email" id="login_email" name="email" required>
        <div id="loginEmailError" class="error-message" style="display: none;"></div>
      </div>

      <div class="form-group">
        <label for="login_password">Введите пароль</label>
        <input type="password" id="login_password" name="password" required>
        <div id="loginPasswordError" class="error-message" style="display: none;"></div>
      </div>

      <button type="submit" class="btn btn-main">Войти</button>

      <div class="form-footer">
        <span>Впервые у нас?</span>
        <button type="button" class="btn btn-no-fill" id="switchToRegister">Регистрация</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Скрываем все предыдущие ошибки
    document.getElementById('loginGeneralError').style.display = 'none';
    document.getElementById('loginEmailError').style.display = 'none';
    document.getElementById('loginPasswordError').style.display = 'none';

    // Получаем данные формы
    const formData = new FormData(this);

      fetch('modal/ajax_login.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = data.redirect;
        } else {
          if (data.generalError) {
            const generalError = document.getElementById('loginGeneralError');
            generalError.textContent = data.generalError;
            generalError.style.display = 'block';
          }

          if (data.emailError) {
            const emailError = document.getElementById('loginEmailError');
            emailError.textContent = data.emailError;
            emailError.style.display = 'block';
          }

          if (data.passwordError) {
            const passwordError = document.getElementById('loginPasswordError');
            passwordError.textContent = data.passwordError;
            passwordError.style.display = 'block';
          }
        }
      })
      .catch(error => {
        console.error('Error:', error);
        const generalError = document.getElementById('loginGeneralError');
        generalError.textContent = 'Произошла ошибка при отправке формы';
        generalError.style.display = 'block';
      });
  });
</script>