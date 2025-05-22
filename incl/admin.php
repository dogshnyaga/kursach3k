<?php
$sql = 'SELECT * FROM products WHERE 1=1';

$stmt = $database->query($sql);
$products = $stmt->fetchAll();


$sql2 = "SELECT * FROM categories";
$categories = $database->query($sql2)->fetchAll();
?>

<main>
    <div class="profile-page container mt-40">

        <!-- Admin Panel -->
        <section id="admin" class="container">
            <div style="margin-bottom: 20px;">
                <a href=".?page=create-category" class="btn btn-no-fill
                ">Создать категорию</a>
                <a href="./?page=create-product" class="btn btn-no-fill
                ">Создать продукт</a>
            </div>
            <div>
                <div>
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
                                        <a href="./?page=edit-category&id=<?= $category['id'] ?>" class="btn btn-no-fill
                                        ">Изменить</a>
                                        <a href="./?page=delete-category&id=<?= $category['id'] ?>" class="btn btn-no-fill red-no-fill"
                                            style="background:var(--accent)">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div>
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
                                        <a href="./?page=edit-product&id=<?= $product['id'] ?>" class="btn btn-no-fill
                                        ">Изменить</a>
                                        <a href="./?page=delete-product&id=<?= $product['id'] ?>" class="btn btn-no-fill red-no-fill" style="background:var(--accent)">Удалить</a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
                <div>
                    <h3>Заказы</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Фио заказчика</th>
                                <th>Общая цена</th>
                                <th>Статус</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Альберт Рашитов</td>
                                <td>₽1 200</td>
                                <td>Выполнено</td>
                                <td>
                                    <form action="" method="post"><select name="" id="">
                                            <option value="">Выполнено</option>
                                            <option value="">Отказано</option>
                                        </select>
                                        <input type="submit" class="btn btn-no-fill" value="Изменить">

                                    </form>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Альберт Рашитов</td>
                                <td>₽1 200</td>
                                <td>Выполнено</td>
                                <td>
                                    <form action="" method="post"><select name="">
                                            <option value="">Выполнено</option>
                                            <option value="">Отказано</option>
                                        </select>
                                        <input type="submit" class="btn btn-no-fill" value="Изменить">

                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    </div>
</main>