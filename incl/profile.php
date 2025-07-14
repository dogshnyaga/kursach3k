<?php

// Получение данных пользователя из БД
$user_id = $_SESSION['user_id'];
$stmt = $database->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="profile-page container mt-40">
    <div class="profile-head">
        <div class="profile-info">
            <div class="info-row">
                <p class="info-label">ФИО:</p>
                <p class="info-value"><?= htmlspecialchars($user['name']) ?></p>
            </div>
            <div class="info-row">
                <p class="info-label">Телефон:</p>
                <p class="info-value"><?= htmlspecialchars($user['phone']) ?></p>
            </div>
            <div class="info-row">
                <p class="info-label">Email:</p>
                <p class="info-value"><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <button onclick="location.href='./?page=edit-profile'" class="btn btn-no-fill">Редактировать</button>
            <button class="btn btn-no-fill red-no-fill" onclick="location.href='?exit'">Выйти</button>
        </div>
    </div>

    <div class="profile-tabs">
        <p class="tab active">Мои действующие заказы</p>
        <p class="tab">История заказов</p>
        <p class="tab">Запросить скидку</p>
    </div>

    <form method="POST" class="mailing-settings">
        <p class="setting-title">Настройки рассылки</p>
        <div class="setting-option">
            <input class="filter-option" type="checkbox" id="mailing-sales" name="mailing_sales">
            <label for="mailing-sales">Я хочу получать письма с акциями</label>
        </div>
        <div class="setting-option">
            <input class="filter-option" type="checkbox" id="mailing-news" name="mailing_news">
            <label for="mailing-news">Я хочу получать письма с новостями</label>
        </div>
        <div class="setting-option">
            <input class="filter-option" type="checkbox" id="personal-offers" name="personal_offers">
            <label for="personal-offers">Присылать личные предложения в сообщения</label>
        </div>
        <button type="submit" class="btn btn-no-fill">Сохранить настройки</button>
    </form>
</div>