<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];

    if (empty($title)) {
        echo "Обнаружены пустые поля";
    } else {
        $sql = "INSERT INTO categories (title) VALUES ('$title')";
        $stmt = $database->query($sql);
        header('Location: ./?page=admin');
    }
}
?>


<main>
    <section id="categories" class="container mt-40">
        <form style="flex:1" method="post" class="form-wrapper mt-40">
            <h2 style="margin:.5rem 0">Создать категорию</h2>
            <div>

                <input type="text" name="title" placeholder="Название" required>
                <button class="btn btn-main" type="submit">Создать</button>
            </div>
        </form>
    </section>
</main>