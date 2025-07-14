<?php

// Проверяем, передан ли ID товара
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: ./?page=admin');
    exit;
}

$product_id = (int)$_GET['id'];

// Получаем данные о товаре из базы данных
$stmt = $database->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: admin_products.php');
    exit;
}

// Получаем списки для выпадающих меню
$categories = $database->query("SELECT id, title FROM categories")->fetchAll(PDO::FETCH_ASSOC);
$manufacturers = $database->query("SELECT id, name FROM manufacturers")->fetchAll(PDO::FETCH_ASSOC);
$colors = $database->query("SELECT id, name FROM colors")->fetchAll(PDO::FETCH_ASSOC);
$sockets = $database->query("SELECT id, name FROM socket_types")->fetchAll(PDO::FETCH_ASSOC);

// Обработка формы
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $power = (int)$_POST['power'];
    $category_id = (int)$_POST['category_id'];
    $manufacturer_id = (int)$_POST['manufacturer_id'];
    $color_id = !empty($_POST['color_id']) ? (int)$_POST['color_id'] : null;
    $socket_type_id = (int)$_POST['socket_type_id'];

    // Валидация данных
    $errors = [];

    if (empty($title)) {
        $errors[] = 'Название товара обязательно для заполнения';
    }

    if (empty($price) || $price <= 0) {
        $errors[] = 'Цена должна быть положительным числом';
    }

    if (empty($category_id)) {
        $errors[] = 'Категория обязательна для выбора';
    }

    if (empty($manufacturer_id)) {
        $errors[] = 'Производитель обязателен для выбора';
    }

    // Если нет ошибок, обновляем товар
    if (empty($errors)) {
        // Обработка загрузки изображения
        $image_path = $product['image']; // Сохраняем старое изображение по умолчанию

        if (!empty($_FILES['image']['name'])) {
            $upload_dir = 'assets/img/products';
            $file_name = basename($_FILES['image']['name']);
            $file_path = $upload_dir . $file_name;
            $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));

            // Проверка типа файла
            $allowed_types = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (in_array($file_type, $allowed_types)) {
                // Удаляем старое изображение, если оно есть
                if (!empty($product['image']) && file_exists($product['image'])) {
                    unlink($product['image']);
                }

                // Загружаем новое изображение
                if (move_uploaded_file($_FILES['image']['tmp_name'], $file_path)) {
                    $image_path = $file_path;
                }
            }
        }

        // Обновляем товар в базе данных
        $stmt = $database->prepare("
            UPDATE products 
            SET title = ?, description = ?, price = ?, power = ?, category_id = ?, 
                manufacturer_id = ?, color_id = ?, socket_type_id = ?, image = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $title,
            $description,
            $price,
            $power,
            $category_id,
            $manufacturer_id,
            $color_id,
            $socket_type_id,
            $image_path,
            $product_id
        ]);

        // Перенаправляем на страницу с товарами
        header('Location: ./?page=admin');
        exit;
    }
}
?>

<main>
    <!-- Edit Product -->
    <section id="edit-product" class="container mt-40">
        <form method="post" enctype="multipart/form-data" class="form-wrapper">
            <h2 class="section-title">Редактирование продукта</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <p><?= htmlspecialchars($error) ?></p>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div>
                <input type="text" name="title" placeholder="Название" value="<?= htmlspecialchars($product['title']) ?>">
                <textarea name="description" placeholder="Описание товара"><?= htmlspecialchars($product['description']) ?></textarea>
                <label for="price">Цена, рубли</label>
                <input type="number" name="price" placeholder="Цена" value="<?= htmlspecialchars($product['price']) ?>">
                <label for="power">Мощность, ватт</label>
                <input style="width: 100%;" type="number" name="power" placeholder="Мощность" value="<?= htmlspecialchars($product['power']) ?>">

                <select name="category_id" class="" style="min-height: 40px;">
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id'] ?>" <?= $category['id'] == $product['category_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['title']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="manufacturer_id" class="" style="min-height: 40px;">
                    <?php foreach ($manufacturers as $manufacturer): ?>
                        <option value="<?= $manufacturer['id'] ?>" <?= $manufacturer['id'] == $product['manufacturer_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($manufacturer['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="color_id" class="" style="min-height: 40px;">
                    <option value="">-- Выберите цвет --</option>
                    <?php foreach ($colors as $color): ?>
                        <option value="<?= $color['id'] ?>" <?= $color['id'] == $product['color_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($color['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <select name="socket_type_id" class="" style="min-height: 40px;">
                    <?php foreach ($sockets as $socket): ?>
                        <option value="<?= $socket['id'] ?>" <?= $socket['id'] == $product['socket_type_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($socket['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <input type="file" name="image" class="btn">
                <?php if (!empty($product['image'])): ?>
                    <div class="current-image">
                        <p>Текущее изображение:</p>
                        <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" style="max-width: 200px;">
                    </div>
                <?php endif; ?>

                <button class="btn btn-main" type="submit">Обновить продукт</button>
            </div>
        </form>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>