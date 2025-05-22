<?php
$flag = true;

$sql = "SELECT * FROM categories";
$result = $database->query($sql)->fetchAll();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category_id = $_POST['category_id'];


    if (empty($title) || empty($description) || empty($price)) {
        echo "Обнаружены пустые поля";
    } elseif (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $tmpName = $_FILES['image']['tmp_name'];
        $name = basename($_FILES['image']['name']);
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $newName = uniqid() . '.' . $extension;
        $newDirection = 'assets/images/' . $newName;


        if (move_uploaded_file($tmpName, $newDirection)) {
            $sql = "INSERT INTO products (title, price, description, image, category_id) VALUES ('$title', '$price', '$description', '$newDirection', '$category_id')";
            $stmt = $database->query($sql);
            header('Location: ./');
        } else {
            echo 'Ошибка загрузки';
        }
    } else {
        echo 'Нет изображения';
    }
}
?>

<main>
    <!-- Create Product -->
    <section id="create-product" class="container mt-40">
        <form method="post" enctype="multipart/form-data" class="form-wrapper">
            <h2 class="">Создание продукта</h2>
            <div class="">
                <input type="text" placeholder="Название" name="title" required>
                <textarea placeholder="Описание" name="description" required></textarea>
                <input type="number" placeholder="Цена" name="price" required>
                <input class="" type="file" accept="image/*" name="image" required>
                <select name="category_id" id="" class="btn btn-no-fill">
                    <option value="">Выберите категорию</option>
                    <?php foreach ($result as $category): ?>
                        <option value="<?= $category['id'] ?>">
                            <?= $category['title'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn btn-main" type="submit">Создать продукт</button>
            </div>
        </form>
    </section>
</main>