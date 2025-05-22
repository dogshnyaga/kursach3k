<?php
if (isset($_GET['id']) && !empty($_GET['id'])) {
  $id = $_GET['id'];
  $sql = 'SELECT * FROM categories WHERE id = :id';
  $stmt = $database->prepare($sql);
  $stmt->execute([':id' => $id]);
  $category = $stmt->fetch();
  if (!$category) {
    echo 'Продукт не найден';
  }
} else {
  die('Ошибка запроса');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
  $delete_id = $_POST['delete_id'];
  if (!empty($delete_id)) {
    $sql = "DELETE FROM categories WHERE id =:id";
    $stmt = $database->prepare($sql);
    $stmt->bindParam(':id', $delete_id);

    if ($stmt->execute()) {
      header("Location: ./?page=admin");
      exit;
    } else {
      echo 'Ошибка удаления';
    }
  }
}
?>

<main>
  <!-- Delete category -->
  <section id="delete-product" class="container">
    <h2 class="section-title">Удаление категории «<?= $category['title'] ?>»</h2>
    <div style="display: flex;gap: 1.5rem;">
      <button class="btn" onclick="location.href='./?page=admin'">Отмена</button>
      <form action="" method="post" style="width: 100%;">
        <input type="hidden" name="delete_id" value="<?= $category['id'] ?>">
        <button class="btn" onclick="return confirm('Вы действительно хотите удалить?')" style="background:var(--accent)">Удалить категорию</button>
      </form>
    </div>
  </section>
</main>