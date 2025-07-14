<?php
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Ошибка запроса');
}

$id = $_GET['id'];

// Получаем полную информацию о товаре одним запросом
$sql = "SELECT products.*, 
            manufacturers.name AS manufacturer_name,
            colors.name AS color_name,
            socket_types.name AS socket_type_name,
            categories.title AS category_title
        FROM products
        LEFT JOIN manufacturers ON products.manufacturer_id = manufacturers.id
        LEFT JOIN colors ON products.color_id = colors.id
        LEFT JOIN socket_types ON products.socket_type_id = socket_types.id
        LEFT JOIN categories ON products.category_id = categories.id
        WHERE products.id = :id";

$stmt = $database->prepare($sql);
$stmt->execute([':id' => $id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC); // Используем fetch(), так как нужна одна запись

if (!$product) {
    die('Продукт не найден');
}

// Добавление в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['user_id'])) { // Используем $_SESSION вместо $USER
        $product_id = $_POST['product_id'] ?? 0;
        if ($product_id > 0) {
            $user_id = $_SESSION['user_id'];

            // Используем подготовленные запросы для всех операций
            $checkSql = "SELECT id, count FROM carts WHERE product_id = :product_id AND user_id = :user_id";
            $stmt = $database->prepare($checkSql);
            $stmt->execute([':product_id' => $product_id, ':user_id' => $user_id]);
            $existing = $stmt->fetch();

            if ($existing) {
                $newCount = $existing['count'] + 1;
                $updateSql = "UPDATE carts SET count = :count WHERE id = :id";
                $stmt = $database->prepare($updateSql);
                $stmt->execute([':count' => $newCount, ':id' => $existing['id']]);
            } else {
                $insertSql = "INSERT INTO carts (product_id, user_id, count) VALUES (:product_id, :user_id, 1)";
                $stmt = $database->prepare($insertSql);
                $stmt->execute([':product_id' => $product_id, ':user_id' => $user_id]);
            }

            header('Location: ./?page=cart');
            exit();
        }
    } else {
        header('Location: ./?page=login');
        exit();
    }
}

?>
<div class="card-page container mt-40">
    <div class="card-page-title">
        <h2><?= $product['title'] ?></h2>
    </div>
    <div class="card-page-content mt-40">
        <img src="<?= $product['image'] ?>" alt="" class="card-image">
        <div class="card-page-col">
            <p class="col-title">
                Характеристики
            </p>
            <table class="chars">
                <tr>
                    <td>Производитель</td>
                    <td><?= htmlspecialchars($product['manufacturer_name']) ?></td>
                </tr>
                <tr>
                    <td>Цвет</td>
                    <td><?= htmlspecialchars($product['color_name']) ?></td>
                </tr>
                <tr>
                    <td>Цоколь</td>
                    <td><?= htmlspecialchars($product['socket_type_name']) ?></td>
                </tr>
                <tr>
                    <td>Мощность</td>
                    <td><?= $product['power'] ?>W</td>
                </tr>
            </table>
        </div>
        <div class="card-page-col">
            <div class="card-page-price">
                <div class="sale-price">
                    <p class="fake-price"><?= number_format($product['price'] * 1.2, 0, '', ' ') ?> ₽</p>
                    <span>
                        <p class="price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</p>
                        <div class="percent">-20%</div>
                    </span>
                </div>
                <p>
                    Казань, <br>самовывоз от 3 дней
                </p>
            </div>



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

    <div class="card-page-content mt-40">
        <div class="card-page-col">

            <h2 class="card-page-title">
                Описание
            </h2>
            <p style="margin-top: 10px;"><?= $product['description'] ?></p>
        </div>
    </div>
</div>