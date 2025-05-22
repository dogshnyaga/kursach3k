<div class="container">
  <header class="" id="fixedHeader">
    <div class="logo"><a href="./"><img src="../assets/ico/logo.svg" alt=""></a></div>
    <input type="checkbox" id="burger">
    <label for="burger">
      <span class="span-burger">

      </span>
    </label>
    <nav class="nav-links">
      <a href="../index.php">Главная</a>
      <a href="../?page=catalog">Каталог</a>
      <a href="">О нас</a>

      <div class="">
        <?php if (!isset($_SESSION['user_id'])): ?>
          <button class="btn btn-main" id="openModalLogin">
            <img src="../assets/ico/profile.svg" alt="">
            Войти
          </button>
          <button class="btn btn-main" id="openModalReg">
            <img src="../assets/ico/profile.svg" alt="">
            Регистрация
          </button>
        <?php else: ?>
          <?php if ($USER['role'] === 'admin'): ?>
            <button class="btn btn-main" onclick="location.href='.?page=admin'">
              Админ панель
            </button>
          <?php endif; ?>
          <button class="btn btn-main" onclick="location.href='.?page=cart'">
            <img src="../assets/ico/cart.svg" alt="">
            Корзина
          </button>
          <?php if ($USER['role'] === 'user'): ?>
            <button class="btn btn-main" onclick="location.href='.?page=profile'">
              <img src="../assets/ico/profile.svg" alt="">
              Профиль
            </button>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </nav>
  </header>
</div>