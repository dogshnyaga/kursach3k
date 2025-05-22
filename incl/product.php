<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = 'SELECT * FROM products WHERE id = :id';
    $stmt = $database->prepare($sql);
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();
    if (!$product) {
        echo 'Продукт не найден';
    }
    $sql2 = "SELECT c.title
    FROM categories c
    JOIN products p ON c.id = p.category_id
    WHERE p.id = :id";
    $stmt = $database->prepare($sql2);
    $stmt->execute([':id' => $id]);
    $category = $stmt->fetch();
} else {
    die('Ошибка запроса');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart']))
    if (isset($USER['role'])) {
        $user_id = $USER['id'];
        $checkSql = "SELECT id, count FROM carts WHERE product_id = $id AND user_id = $user_id";
        $existing = $database->query($checkSql)->fetch();

        if ($existing) {
            $newCount = $existing['count'] + 1;
            $updateSql = "UPDATE carts SET count = $newCount WHERE id = {$existing['id']}";
            $database->query($updateSql);
        } else {
            $insertSql = "INSERT INTO carts (product_id, user_id, count) VALUES ($id, $user_id, 1)";
            $database->query($insertSql);
        }
        header('Location: ./?page=cart');
        exit();
    } else {
        header('Location: ./?page=login');
    }
?>
<div class="card-page container mt-40">
    <div class="card-page-title">
        <h2>Подвесная люстра Maytoni Rim</h2>
        <div class="rating-card-page">
            <div class="stars">
                <img src="../assets/ico/rated.svg" alt="">
                <img src="../assets/ico/rated.svg" alt="">
                <img src="../assets/ico/rated.svg" alt="">
                <img src="../assets/ico/rated.svg" alt="">
                <img src="../assets/ico/rated.svg" alt="">
            </div>

            <p class="little-gray-text">Отзывы(26)</p>
        </div>
    </div>
    <div class="card-page-content">
        <img src="../assets/img/products/1.png" alt="" class="card-image">
        <div class="card-page-col">
            <p class="col-title">
                Характеристики
            </p>
            <table class="chars">
                <tr>
                    <td>Артикул</td>
                    <td><br>MOD058PL-L32WK</td>
                </tr>
                <tr>
                    <td>Производитель</td>
                    <td><br>Maytoni (Германия)</td>
                </tr>
                <tr>
                    <td>Коллекция</td>
                    <td>Rim</td>
                </tr>
                <tr>
                    <td>Высота (мм)</td>
                    <td>275</td>
                </tr>
                <tr>
                    <td>Ширина (мм)</td>
                    <td>600</td>
                </tr>
                <tr>
                    <td>Цвет</td>
                    <td>Серебрянный</td>
                </tr>
                <tr>
                    <td>Цветовая температура (К)</td>
                    <td>3000-4000</td>
                </tr>
                <tr>
                    <td>Яркость, Лм</td>
                    <td>2850</td>
                </tr>
            </table>
        </div>
        <div class="card-page-col">
            <div class="card-page-price">
                <div class="sale-price">
                    <p class="fake-price">50 000₽</p>
                    <span>
                        <p class="price">39 000₽</p>
                        <div class="percent">-20%</div>
                    </span>
                </div>
                <p>
                    Казань, <br>самовывоз от 3 дней
                </p>
            </div>
            <button type="button" class="btn btn-main">
                + Добавить в корзину
            </button>
        </div>
    </div>
</div>

</html>