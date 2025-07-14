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
} else {
    die('Ошибка запроса');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    if (!empty($delete_id)) {
        unlink($product['image']);
        $sql = "DELETE FROM products WHERE id =:id";
        $stmt = $database->prepare($sql);
        $stmt->bindParam(':id', $delete_id);

        if ($stmt->execute()) {
            header("Location: ./");
            exit;
        } else {
            echo 'Ошибка удаления';
        }
    }
}
?>

<main>
    <!-- Delete Product -->
    <section id="delete-product" class="container mt-40">
        <div class="form-wrapper">
            <h2 class="section-title">Удаление продукта "<?= $product['title'] ?>"</h2>
            <div>

                <button class="btn btn-no-fill" onclick="location.href='./?page=show&sid=<?= $product['id'] ?>'">Отмена</button>
                <form action="" method="post" style="width: 100%;" class="">
                    <input type="hidden" name="delete_id" value="<?= $product['id'] ?>">
                    <button class="btn btn-no-fill red-no-fill"
                        onclick="return confirm('Вы действительно хотите удалить?')">
                        Удалить продукт
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>