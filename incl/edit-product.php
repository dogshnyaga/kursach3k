<?php
$sql = "SELECT * FROM categories";
$result = $database->query($sql)->fetchAll();

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $database->prepare($sql);
    $stmt->execute([':id' => $id]);
    $product = $stmt->fetch();

    if (!$product) {
        echo 'Товар не найден';
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $category_id = $_POST['category_id'];

        if (empty($title) || empty($price) || empty($description)) {
            echo 'Обязательные поля не заполнены';
        } else {
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                if (file_exists($product['image'])) {
                    unlink($product['image']);
                }

                $tmpName = $_FILES['image']['tmp_name'];
                $name = basename($_FILES['image']['name']);
                $extension = pathinfo($name, PATHINFO_EXTENSION);
                $newName = uniqid() . '.' . $extension;
                $newDirection = 'assets/images/' . $newName;

                if (move_uploaded_file($tmpName, $newDirection)) {
                    $image = $newDirection;
                } else {
                    echo "Ошибка загрузки изображения";
                    exit();
                }
            } else {
                $image = $product['image'];
            }

            $sql = "UPDATE products SET
                    `title`=:title,
                    `description`=:description,
                    `price`=:price,
                    `image`=:image,
                    `category_id`=:category_id
                    WHERE id=:id";

            $stmt = $database->prepare($sql);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':description', $description);
            $stmt->bindParam(':image', $image);
            $stmt->bindParam(':category_id', $category_id);
            $stmt->bindParam(':id', $_GET['id']);

            if ($stmt->execute()) {
                header("Location: ./?page=show&id=" . $product['id']);
                exit();
            } else {
                include('404.php');
            }
        }
    }
} else {
    echo 'нет айди';
    exit();
}
?>

<main>
    <!-- Edit Product -->
    <section id="edit-product" class="container mt-40">
        <form method="post" enctype="multipart/form-data" class="form-wrapper">
            <h2 class="section-title">Редактирование продукта</h2>
            <div>
                <input type="text" name="title" placeholder="Название" value="<?= $product['title'] ?>">
                <textarea name="description" placeholder="Описание товара"><?= $product['description'] ?></textarea>
                <input type="number" name="price" placeholder="Цена" value="<?= $product['price'] ?>">
                <select name="category_id" class="" style="min-height: 40px;">
                    <?php foreach ($result as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['title'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <input type="file" name="image" class="btn">
                <button class="btn btn-main" type="submit">Обновить продукт</button>
            </div>
        </form>
    </section>
</main>