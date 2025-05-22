<?php

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM categories WHERE id = :id";
    $stmt = $database->prepare($sql);
    $stmt->execute([':id' => $id]);
    $category = $stmt->fetch();

    if (!$category) {
        echo 'Категория не найдена';
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $title = $_POST['title'];
        $category_id = $_POST['category_id'];

        if (empty($title)) {
            echo 'Обязательные поля не заполнены';
        } else
            $sql = "UPDATE categories SET
                    `title`=:title 
                    WHERE id=:id";

        $stmt = $database->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':id', $_GET['id']);

        if ($stmt->execute()) {
            header("Location: ./?page=admin");
            exit();
        } else {
            include('404.php');
        }
    }
} else {
    echo 'нет айди';
    exit();
} ?>

<main>
    <section id="categories" class="container mt-40">
        <div class="form-wrapper">
            <form style="flex:1" method="POST">
                <h3 style="margin:.5rem 0">Редактировать категорию</h3>
                <div class="mt-40">
                    <input type="text" placeholder="Новое название" name="title" value="<?= $category['title'] ?>" required>
                    <button class="btn btn-no-fill" type="submit">Обновить категорию</button>
                </div>
            </form>
        </div>
    </section>
</main>