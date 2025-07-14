<?php
$sql = 'SELECT * FROM products WHERE 1=1';

$stmt = $database->query($sql);
$products = $stmt->fetchAll();


$sql2 = "SELECT * FROM categories";
$categories = $database->query($sql2)->fetchAll();

// Получение данных пользователя из БД
$user_id = $_SESSION['user_id'];
$stmt = $database->prepare("SELECT name, email, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<main>
    <div class="profile-page container mt-40">

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
        <!-- Admin Panel -->
        <section id="admin" class="container">
            <div style="margin-bottom: 20px;" class="mt-40">
                <a href=".?page=create-category" class="btn btn-no-fill
                ">Создать категорию</a>
                <a href="./?page=create-product" class="btn btn-no-fill
                ">Создать продукт</a>
            </div>
            <div>
                <div class="mt-40">
                    <h3>Категории</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?= $category['id'] ?></td>
                                    <td><?= $category['title'] ?></td>
                                    <td>
                                        <button onclick="location.href='./?page=edit-category&id=<?= $category['id'] ?>'" class="btn btn-no-fill">Изменить</button>
                                        <button onclick="location.href='./?page=delete-category&id=<?= $category['id'] ?>'" class="btn btn-no-fill red-no-fill">Удалить</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div class="mt-40">
                    <h3>Продукты</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Название</th>
                                <th>Цена</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?= $product['id'] ?></td>
                                    <td><?= $product['title'] ?></td>
                                    <td>₽<?= $product['price'] ?></td>
                                    <td>
                                        <button onclick="location.href='./?page=edit-product&id=<?= $product['id'] ?>'" class="btn btn-no-fill">Изменить</button>
                                        <button onclick="location.href='./?page=delete-product&id=<?= $product['id'] ?>'" class="btn btn-no-fill red-no-fill">Удалить</button>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</main>