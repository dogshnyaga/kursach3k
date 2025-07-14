<?php
$sql = "SELECT * FROM categories";
$result_categories = $database->query($sql)->fetchAll();
$sql = "SELECT * FROM colors";
$result_colors = $database->query($sql)->fetchAll();
$sql = "SELECT * FROM manufacturers";
$result_manufacturer = $database->query($sql)->fetchAll();
$sql = "SELECT * FROM socket_types";
$result_socket = $database->query($sql)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $color_id = $_POST['color_id'];
    $manufacturer_id = $_POST['manufacturer_id'];
    $socket_type_id = $_POST['socket_type_id'];
    $power = $_POST['power'];
    $category_id = $_POST['category_id'];

    if (empty($title) || empty($price) || empty($description)) {
        echo 'Обязательные поля не заполнены';
    } else {
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES['image']['tmp_name'];
            $name = basename($_FILES['image']['name']);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $newName = uniqid() . '.' . $extension;
            $newDirection = 'assets/img/' . $newName;

            if (move_uploaded_file($tmpName, $newDirection)) {
                $image = $newDirection;

                $sql = "INSERT INTO products SET
                        `title`=:title,
                        `description`=:description,
                        `price`=:price,
                        `image`=:image,
                        `category_id`=:category_id,
                        `color_id`=:color_id,
                        `manufacturer_id`=:manufacturer_id,
                        `socket_type_id`=:socket_type_id,
                        `power`=:power";

                $stmt = $database->prepare($sql);
                $stmt->bindParam(':title', $title);
                $stmt->bindParam(':price', $price);
                $stmt->bindParam(':description', $description);
                $stmt->bindParam(':image', $image);
                  $stmt->bindParam(':category_id', $category_id);
                $stmt->bindParam(':color_id', $color_id);
                $stmt->bindParam(':manufacturer_id', $manufacturer_id);
                $stmt->bindParam(':socket_type_id', $socket_type_id);
                $stmt->bindParam(':power', $power);

                if ($stmt->execute()) {
                    header("Location: ./?page=admin");
                    exit();
                } else {
                    include('404.php');
                }
            } else {
                echo "Ошибка загрузки изображения";
                exit();
            }
        } else {
            echo 'Необходимо загрузить изображение';
        }
    }
}
?>

<main>
    <!-- Create Product -->
    <section id="create-product" class="container mt-40">
        <form method="post" enctype="multipart/form-data" class="form-wrapper">
            <h2 class="section-title">Создание продукта</h2>
            <div>
                <input type="text" name="title" placeholder="Название" required>
                <textarea name="description" placeholder="Описание товара" required></textarea>
                <input type="number" name="price" placeholder="Цена" required>
                <div class="input-with-unit">
                    <input type="number" name="power" placeholder="Мощность">
                    <span class="unit">Вт</span>
                </div>
                <select name="category_id" class="" style="min-height: 40px;" required>
                    <option value="">-- Выберите категорию --</option>
                    <?php foreach ($result_categories as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['title'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="manufacturer_id" class="" style="min-height: 40px;" required>
                    <option value="">-- Выберите производителя --</option>
                    <?php foreach ($result_manufacturer as $manufacturer): ?>
                        <option value="<?= $manufacturer['id'] ?>">
                            <?= $manufacturer['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="color_id" class="" style="min-height: 40px;">
                    <option value="">-- Выберите цвет --</option>
                    <?php foreach ($result_colors as $color): ?>
                        <option value="<?= $color['id'] ?>">
                            <?= $color['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <select name="socket_type_id" class="" style="min-height: 40px;" required>
                    <option value="">-- Выберите тип сокета --</option>
                    <?php foreach ($result_socket as $socket): ?>
                        <option value="<?= $socket['id'] ?>">
                            <?= $socket['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="file" name="image" class="btn" required>
                <button class="btn btn-main" type="submit">Создать продукт</button>
            </div>
        </form>
    </section>
</main>