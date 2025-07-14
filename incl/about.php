<body>
  <!-- Секция "О компании" -->
  <section class="about-section container">
    <div class="about-content">
      <h1 class="title">О компании Люмен</h1>
      <div class="about-grid">
        <div class="about-text">
          <p class="about-desc">
            Магазин светильников "Люмен" - это современная компания, специализирующаяся на продаже качественных осветительных приборов для дома и офиса.
            Мы работаем на рынке с 2010 года и за это время заслужили доверие тысяч клиентов по всей России.
          </p>
          <p class="about-desc">
            Наша миссия - освещать ваш дом теплом и уютом, предлагая только лучшие решения для любого интерьера.
            Мы тщательно отбираем каждый товар в нашем ассортименте, чтобы вы могли быть уверены в качестве и долговечности.
          </p>
          <div class="stats">
            <div class="stat-item">
              <span class="stat-number">13+</span>
              <span class="stat-label">лет на рынке</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">5000+</span>
              <span class="stat-label">довольных клиентов</span>
            </div>
            <div class="stat-item">
              <span class="stat-number">100+</span>
              <span class="stat-label">брендов</span>
            </div>
          </div>
        </div>
        <div class="about-image">
          <img src="assets/img/about-showroom.jpg" alt="Наш шоу-рум в Казани" class="about-img">
        </div>
      </div>
    </div>
  </section>

  <!-- Наши ценности -->
  <section class="values-section container">
    <h2 class="title">Наши ценности</h2>
    <div class="values-cards">
      <div class="value-card">
        <svg xmlns="http://www.w3.org/2000/svg" class="value-icon" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ai ai-CircleCheck">
          <path d="M8 12.5l3 3 5-6"></path>
          <circle cx="12" cy="12" r="10"></circle>
        </svg>
        <h3 class="value-title">Качество</h3>
        <p class="value-desc">
          Мы тщательно проверяем каждый светильник перед поставкой и работаем только с проверенными производителями.
        </p>
      </div>
      <div class="value-card">
        <svg xmlns="http://www.w3.org/2000/svg" class="value-icon" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ai ai-Edit">
          <path d="M16.474 5.408l2.118 2.117m-.756-3.982L12.109 9.27a2.118 2.118 0 0 0-.58 1.082L11 13l2.648-.53c.41-.082.786-.283 1.082-.579l5.727-5.727a1.853 1.853 0 1 0-2.621-2.621z"></path>
          <path d="M19 15v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3"></path>
        </svg>
        <h3 class="value-title">Клиентский сервис</h3>
        <p class="value-desc">
          Наши консультанты помогут подобрать идеальное освещение для любого помещения и ответят на все вопросы.
        </p>
      </div>
      <div class="value-card">
        <svg xmlns="http://www.w3.org/2000/svg" class="value-icon" width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="ai ai-StatisticUp">
          <path d="M3 3v16a2 2 0 0 0 2 2h16"></path>
          <path d="M7 14l4-4 4 4 6-6"></path>
          <path d="M18 8h3v3"></path>
        </svg>
        <h3 class="value-title">Инновации</h3>
        <p class="value-desc">
          Мы следим за новинками рынка и всегда предлагаем современные и технологичные решения.
        </p>
      </div>
    </div>
  </section>


  <!-- Контакты (можно использовать ваш существующий блок) -->
  <div class="map-block container">
    <div class="fill-block-content vertical-gap-auto">
      <p class="block-title">Нас легко найти!</p>
      <div class="links">
        <a href="https://g.co/kgs/EZTSG13">г. Казань, Ул. Нурихана Фаттаха 21\1</a>
        <a href="tel:+78437641012">+7(843) 764 10 12</a>
        <a href="mailto:mail@lumen.ru">mail@lumen.ru</a>
      </div>
      <div class="media-links">
        <a href="#">
          <svg width="52" height="50" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Ваш SVG для соцсетей -->
          </svg>
        </a>
        <a href="#">
          <svg width="52" height="50" viewBox="0 0 52 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <!-- Ваш SVG для соцсетей -->
          </svg>
        </a>
      </div>
    </div>
    <div class="img-container">
      <img src="assets/img/map-image.png" alt="Карта с расположением магазина">
    </div>
  </div>
</body>

</html>

<style>
  /* Стили для страницы "О нас" */
  .about-section {
    padding: 80px 0;
  }

  .about-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
  }

  .about-desc {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 20px;
  }

  .about-img {
    width: 100%;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  }

  .stats {
    display: flex;
    gap: 30px;
    margin-top: 40px;
  }

  .stat-item {
    text-align: center;
  }

  .stat-number {
    display: block;
    font-size: 36px;
    font-weight: 700;
    color: var(--primary);
  }

  .stat-label {
    font-size: 16px;
    color: var(--text);
  }

  /* Стили для раздела ценностей */

  .values-cards {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 40px;
  }

  .value-card {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
  }

  .value-icon {
    height: 60px;
    width: 60px;
    margin-bottom: 20px;
    color: #F97400;
  }

  .value-title {
    font-size: 22px;
    margin-bottom: 15px;
    color: var(--dark);
  }

  .value-desc {
    font-size: 16px;
    line-height: 1.5;
    color: var(--text);
  }

  /* Стили для раздела команды */
  .team-section {
    padding: 80px 0;
  }

  .team-members {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 30px;
    margin-top: 40px;
  }

  .team-member {
    text-align: center;
  }

  .member-photo {
    width: 200px;
    height: 200px;
    border-radius: 50%;
    object-fit: cover;
    margin-bottom: 20px;
    border: 5px solid var(--primary);
  }

  .member-name {
    font-size: 20px;
    margin-bottom: 5px;
  }

  .member-position {
    font-size: 16px;
    color: var(--primary);
    margin-bottom: 15px;
    font-weight: 500;
  }

  .member-bio {
    font-size: 14px;
    line-height: 1.5;
  }

  /* Стили для раздела процесса работы */
  .workflow-section {
    padding: 60px 0;
    background-color: var(--darkBackground);
    color: white;
  }

  .workflow-steps {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-top: 40px;
  }

  .workflow-step {
    background: rgba(255, 255, 255, 0.1);
    padding: 30px;
    border-radius: 20px;
    text-align: center;
  }

  .step-number {
    display: inline-block;
    width: 50px;
    height: 50px;
    background: var(--primary);
    border-radius: 50%;
    line-height: 50px;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
  }

  .step-title {
    font-size: 20px;
    margin-bottom: 15px;
  }

  .step-desc {
    font-size: 14px;
    line-height: 1.5;
  }

  @media (max-width: 768px) {

    .about-grid,
    .values-cards,
    .team-members,
    .workflow-steps {
      grid-template-columns: 1fr;
    }

    .stats {
      flex-direction: column;
      gap: 20px;
    }
  }
</style>