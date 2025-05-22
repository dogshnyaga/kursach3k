<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Люмен | Магазин товаров для освещения</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="shortcut icon" href="assets/ico/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../assets/style/style.css">
    <script src="../assets/js/main.js" defer></script>
</head>

<body>
    <div class="container">
        <header class="" id="fixedHeader">
            <div class="logo"><a href="../index.html"><img src="../assets/ico/logo.svg" alt=""></a></div>
            <input type="checkbox" id="burger">
            <label for="burger">
                <span class="span-burger">

                </span>
            </label>
            <nav class="nav-links">
                <a href="index.html">Главная</a>
                <a href="incl/catalog.html">Каталог</a>
                <a href="">О нас</a>
                <div class="">
                    <button class="btn btn-main" id="openModalLogin">
                        <img src="assets/ico/profile.svg" alt="">
                        Войти
                    </button>
                    <button class="btn btn-main" id="openModalReg">
                        <img src="assets/ico/profile.svg" alt="">
                        Регистрация
                    </button>
                </div>
            </nav>
        </header>
    </div>

    <!-- Модальное окно -->
    <div id="loginModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <form action="" class="form-wrapper">
                <h1>Вход</h1>
                <div>
                    <legend>Введите почту</legend>
                    <input type="text" placeholder="yourmail@domen.com">
                </div>
                <div>
                    <legend>Введите пароль</legend>
                    <input type="password" name="" id="" placeholder="Пароль">

                </div>
                <div>
                    <button type="submit" class="btn btn-main">Войти</button>
                </div>
                <div>
                    <legend>Войти с помощью</legend>
                    <button class="btn btn-no-fill">Google</button>
                    <button type="button" class="btn btn-main" id="switchToRegister">Регистрация</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Модальное окно -->
    <div id="registerModal" class="modal">
        <div class="modal-content">
            <span class="close-btn">&times;</span>
            <form action="" class="form-wrapper">
                <h1>Регистрация</h1>
                <div>
                    <legend>Почта</legend>
                    <input type="text" placeholder="yourmail@domen.com">
                </div>
                <div>
                    <legend>Телефон</legend>
                    <input type="text" placeholder="+7 (000) 000 00 00 ">
                </div>
                <div>
                    <legend>Введите пароль</legend>
                    <input type="password" name="" id="" placeholder="Пароль">
                    <legend>Повторите пароль</legend>
                    <input type="password" name="" id="" placeholder="Пароль">
                </div>
                <div>
                    <button type="submit" class="btn btn-main">Войти</button>
                </div>
                <div>
                    <legend>Войти с помощью</legend>
                    <button class="btn btn-no-fill">Google</button>
                    <button type="button" class="btn btn-main" id="switchToLogin">Вход</button>
                </div>
            </form>
        </div>
    </div>


    <main>
        <div class="profile-page container mt-120">
            <div class="filter-section">
                <a href="index.html">Главная</a><br>
                <a href="incl/admin.html">Админ-панель</a><br>
                <a href="incl/catalog.html">Каталог</a><br>
                <a href="incl/product.html">Карточка товара</a><br>
                <a href="incl/profile.html">Профиль пользователя</a><br>

            </div>

        </div>
    </main>

</body>

</html>