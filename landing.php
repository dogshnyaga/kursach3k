<?php
$sql = "SELECT * FROM products LIMIT 4";
$stmt = $database->query($sql);
$products = $stmt->fetchAll();


$sql = "SELECT * FROM products 
ORDER BY id DESC 
LIMIT 4;";
$stmt = $database->query($sql);
$last_products = $stmt->fetchAll();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show'])) {
}
?>


<!-- Секция для светильников на фоне -->
<section class="unified-banner container">
  <!-- Баннер с фоном -->
  <div class="banner container">
    <h1 class="title-banner">
      Подбери <span class="highlight">освещение</span> <br>
      для своего дома
    </h1>
    <p class="desc">
      У нас большой ассортимент <br><span class="highlight">светильников</span> для любого <br> интерьера, под
      любые
      нужды.
    </p>
    <button class="btn btn-no-fill" id="btnBanner"
      onclick="javascript:location.href='./?page=catalog'">Перейти к покупкам →</button>
  </div>
</section>

<!-- Main с флексом -->
<main>
  <!-- преимущества -->
  <div class="advantages-block container">
    <p class="title">Преимущества</p>
    <div class="cards">
      <div class="card-advantages-block">
        <img src="assets/ico/refund.svg" alt="" class="infographic">
        <div class="vertical-gap-auto">
          <p class="advantage-title">Возврат товара</p>
          <p class="advantage-desc">Мы напрямую представляем производителей</p>
        </div>
      </div>
      <div class="card-advantages-block">
        <img src="assets/ico/delivery.svg" alt="" class="infographic">
        <div class="vertical-gap-auto">
          <p class="advantage-title">Бесплатная доставка</p>
          <p class="advantage-desc">Доставка светильников за 5 рабочих дней в любой город РФ</p>
        </div>
      </div>
      <div class="card-advantages-block">
        <img src="assets/ico/garanty.svg" alt="" class="infographic">
        <div class="vertical-gap-auto">
          <p class="advantage-title">Гарантия качества</p>
          <p class="advantage-desc">Мы тщательно проверяем каждый товар на брак</p>
        </div>
      </div>
    </div>
  </div>

  <!-- каталог -->
  <div class="catalog-block container">
    <p class="title">Каталог</p>
    <!--Контейнер с карточками-->
    <div class="cards">
      <?php foreach ($products as $product): ?>
        <div class="card" onclick="javascript:location.href='./?page=product&id=<?= $product['id'] ?>'">
          <img src="<?= $product['image'] ?>" alt="" class="card-cover">
          <!-- информация о товаре  -->
          <div class="card-content">
            <!-- название с описанием -->
            <div class="card-text">
              <p class="card-title"><?= $product['title'] ?></p>
              <p class="card-desc">
                <?= $product['description'] ?>
              </p>
            </div>
            <!-- цена и кнопка-->
            <div class="card-price-cart">
              <p class="price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</p>

              <?php if (isset($USER['role'])) : ?>
                <form action="" method="post">
                  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                  <input type="submit" value="В корзину" class="btn btn-main btn-cart" name="add_to_cart">
                </form>
              <?php else: ?>
                <button type="button" class="btn btn-main btn-cart-noreg"
                  onclick="alert('Для добавления товара в корзину необходимо авторизоваться')">
                  В корзину
                </button>
              <?php endif ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="btn-wrapper">
      <button class="btn btn-no-fill" onclick="javascript:location.href='./?page=catalog'">Перейти к
        покупкам →</button>
    </div>

  </div>

  <!-- популярные товары -->
  <div class="catalog-block container">
    <p class="title">Популярные товары</p>
    <!--Контейнер с карточками-->
    <div class="cards">

      <?php foreach ($last_products as $product): ?>
        <div class="card" onclick="location.href='./?page=product&id=<?= $product['id'] ?>'">
          <img src="<?= $product['image'] ?>" alt="" class="card-cover">
          <!-- информация о товаре  -->
          <div class="card-content">
            <!-- название с описанием -->
            <div class="card-text">
              <p class="card-title"><?= $product['title'] ?></p>
              <p class="card-desc">
                <?= $product['description'] ?>
              </p>
            </div>
            <!-- цена и кнопка-->
            <div class="card-price-cart">
              <p class="price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</p>

              <?php if (isset($USER['role'])) : ?>
                <form action="" method="post">
                  <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                  <input type="submit" value="В корзину" class="btn btn-main btn-cart" name="add_to_cart">
                </form>
              <?php else: ?>
                <button type="button" class="btn btn-main btn-cart"
                  onclick="alert('Для добавления товара в корзину необходимо авторизоваться'); showLoginModal();">
                  В корзину
                </button>
              <?php endif ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="btn-wrapper">
      <button class="btn btn-no-fill" onclick="javascript:location.href='.?page=catalog'">Перейти к
        покупкам →</button>
    </div>

  </div>

  <div class="reviews-block container">
    <p class="title">Отзывы</p>
    <div class="reviews">
      <button class="btn btn-slider" id="slider-btn-prev">
        <svg width="35" height="18" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M33.5 10.5H35V7.5H33.5V10.5ZM0.5 9L15.5 17.6603V0.339746L0.5 9ZM33.5 7.5L14 7.5V10.5L33.5 10.5V7.5Z"
            fill="white" />
        </svg>
      </button>

      <div class="feedback-card active">
        <img src="assets/img/products/review.png" alt="" class="fb-cover">
        <div class="fb-profile">
          <img src="assets/img/pfp.png" alt="" class="pfp">
          <div class="fb-person-info">
            <h2 class="name">Арслан Энкеев</h2>
            <p class="city">Казань</p>
          </div>
          <div class="rating">
            <h2 class="rated">5.0</h2>
          </div>
        </div>
        <div class="fb-text">
          <h2 class="fb-title">Хороший магазин с большим выбором.</h2>
          <p class="fb-message">Заказывал настольную лампу и потолочный светильник – остался в полном
            восторге! Товары пришли в целости, упаковка надёжная, а качество на высоте. Порадовало,ле
            что есть как бюджетные варианты, так и дизайнерские модели. Обязательно вернусь за
            новыми покупками!</p>
        </div>
      </div>

      <div class="feedback-card active">
        <img src="assets/img/products/review1.png" alt="" class="fb-cover">
        <div class="fb-profile">
          <img src="assets/img/pfp1.png" alt="" class="pfp">
          <div class="fb-person-info">
            <h2 class="name">Андрей Шершнев</h2>
            <p class="city">Екатеринбург</p>
          </div>
          <div class="rating">
            <h2 class="rated">4.5</h2>
          </div>
        </div>
        <div class="fb-text">
          <h2 class="fb-title">Очень доволен покупкой! </h2>
          <p class="fb-message">
            Магазин предлагает огромный ассортимент светильников, ламп и других
            товаров для освещения на любой вкус и бюджет. Качество продукции отличное, цены
            адекватные, а доставка быстрая. Отдельное спасибо консультантам – помогли подобрать
            идеальный вариант для гостиной. Рекомендую!
          </p>
        </div>
      </div>

      <div class="feedback-card">
        <img src="assets/img/products/review2.png" alt="" class="fb-cover">
        <div class="fb-profile">
          <img src="assets/img/pfp2.png" alt="" class="pfp">
          <div class="fb-person-info">
            <h2 class="name">Мария Иванова</h2>
            <p class="city">Москва</p>
          </div>
          <div class="rating">
            <h2 class="rated">5.0</h2>
          </div>
        </div>
        <div class="fb-text">
          <h2 class="fb-title">Отличное качество и сервис</h2>
          <p class="fb-message">
            Покупала люстру для спальни - очень довольна! Качество на высоте, доставили быстрее, чем
            обещали.
            Консультант помог с выбором и дал полезные советы по уходу. Цены приемлемые для такого
            качества.
            Обязательно буду рекомендовать ваш магазин друзьям!
          </p>
        </div>
      </div>

      <div class="feedback-card">
        <img src="assets/img/products/review.png" alt="" class="fb-cover">
        <div class="fb-profile">
          <img src="assets/img/pfp3.png" alt="" class="pfp">
          <div class="fb-person-info">
            <h2 class="name">Дмитрий Петров</h2>
            <p class="city">Санкт-Петербург</p>
          </div>
          <div class="rating">
            <h2 class="rated">4.0</h2>
          </div>
        </div>
        <div class="fb-text">
          <h2 class="fb-title">Хороший магазин, но есть нюансы</h2>
          <p class="fb-message">
            Заказывал несколько светильников для офиса. Качество хорошее, но один из товаров пришел с
            небольшим
            дефектом. Служба поддержки оперативно решила вопрос, заменили без проблем. В целом
            впечатление
            положительное, но контроль качества можно улучшить.
          </p>
        </div>
      </div>

      <button class="btn btn-slider" id="slider-btn-next">
        <svg width="35" height="18" viewBox="0 0 35 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M1.5 7.5H0V10.5H1.5V7.5ZM34.5 9L19.5 0.339746V17.6603L34.5 9ZM1.5 10.5H21V7.5H1.5V10.5Z"
            fill="white" />
        </svg>
      </button>
    </div>
  </div>


  <!-- рассылка -->
  <div class="mail-block container">
    <div class="fill-block-content vertical-gap-auto">
      <div>
        <p class="block-title">Для самых светлых идей!</p>
        <p class="mail-desc">Будьте в курсе акций, новых товаров и новостей на нашем сайте</p>
      </div>

      <div>
        <form action="">
          <p>Ваша почта:</p>
          <span class="input-row">
            <input type="mail" class="mail-input" name="mail" id="mail"
              placeholder="yourmail@domen.com">
            <button type="submit" class="btn btn-main">Отправить</button>
          </span>

        </form>

      </div>
    </div>
    <img src="assets/img/car.png" alt="" class="mail-cover">
  </div>

  <!-- контакты и карта -->
  <div class="map-block container" id="contacts">
    <div class="fill-block-content vertical-gap-auto">
      <p class="block-title">Нас легко найти!</p>
      <div class="links">
        <a href="https://g.co/kgs/EZTSG13">г. Казань, Ул. Нурихана Фаттаха 21\1</a>
        <a href="tel:+78437641012">+7(843) 764 10 12</a>
        <a href="mailto:mail@lumen.ru">mail@lumen.ru</a>
      </div>
      <div class="media-links">

        <a href="https://media.tenor.com/K2bnpusQYIMAAAAe/silly-cat.png">
          <svg width="52" height="50" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_54_277)">
              <path
                d="M2.38986 25C2.38986 12.2951 13.131 2 26.3899 2C39.6472 2 50.3899 12.2951 50.3899 25C50.3899 37.7049 39.6487 48 26.3899 48C13.1326 48 2.38986 37.7049 2.38986 25Z"
                stroke="white" stroke-width="2" />
              <path
                d="M37.3228 17.6436L33.8973 32.9139C33.6441 33.9966 32.9628 34.259 32.0121 33.7495L26.7944 30.1115L24.2777 32.4044C24.0004 32.6668 23.7647 32.8897 23.2261 32.8897L23.5964 27.8658L33.2658 19.6014C33.6872 19.2511 33.1728 19.0524 32.6167 19.4027L20.6664 26.5194L15.5159 24.9985C14.397 24.6648 14.3714 23.94 15.7516 23.4305L35.874 16.0896C36.8085 15.7711 37.6244 16.3048 37.3215 17.6423L37.3228 17.6436Z"
                fill="white" />
            </g>
            <defs>
              <clipPath id="clip0_54_277">
                <rect width="51" height="50" fill="white" transform="translate(0.694916)" />
              </clipPath>
            </defs>
          </svg>
        </a>
        <a href="https://media.tenor.com/K2bnpusQYIMAAAAe/silly-cat.png">
          <svg width="52" height="50" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_54_281)">
              <path
                d="M2.38986 25C2.38986 12.2951 13.131 2 26.3899 2C39.6472 2 50.3899 12.2951 50.3899 25C50.3899 37.7049 39.6487 48 26.3899 48C13.1326 48 2.38986 37.7049 2.38986 25Z"
                stroke="white" stroke-width="2" />
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M40.3119 19.1511C40.5194 18.4881 40.3119 18 39.3181 18H36.0369C35.202 18 34.817 18.4214 34.6082 18.8864C34.6082 18.8864 32.9395 22.7673 30.5758 25.2881C29.8108 26.0191 29.4633 26.2511 29.0458 26.2511C28.8371 26.2511 28.5234 26.0191 28.5234 25.3549V19.1511C28.5234 18.3546 28.2934 18 27.5984 18H22.4385C21.9172 18 21.6035 18.3691 21.6035 18.7201C21.6035 19.4741 22.786 19.649 22.9072 21.7716V26.3834C22.9072 27.3949 22.716 27.5783 22.2985 27.5783C21.186 27.5783 18.4798 23.6792 16.8736 19.2179C16.5624 18.3497 16.2474 18 15.4086 18H12.1249C11.1875 18 11 18.4214 11 18.8864C11 19.7146 12.1124 23.8286 16.1811 29.2698C18.8936 32.9855 22.7122 35 26.1909 35C28.2771 35 28.5346 34.5531 28.5346 33.7821V30.9734C28.5346 30.0785 28.7321 29.9 29.3933 29.9C29.8808 29.9 30.7146 30.1331 32.662 31.9242C34.887 34.048 35.2532 35 36.5057 35H39.7869C40.7243 35 41.1943 34.5531 40.9243 33.6691C40.6268 32.79 39.5644 31.5138 38.1557 29.9996C37.3907 29.1374 36.2432 28.2085 35.8944 27.7434C35.4082 27.1472 35.547 26.8813 35.8944 26.3506C35.8944 26.3506 39.8944 20.9762 40.3106 19.1511H40.3119Z"
                fill="white" />
            </g>
            <defs>
              <clipPath id="clip0_54_281">
                <rect width="51" height="50" fill="white" transform="translate(0.694916)" />
              </clipPath>
            </defs>
          </svg>
        </a>
      </div>
    </div>
    <div class="img-container">
      <img src="assets/img/map-image.png" alt="">
    </div>
  </div>
</main>