<?php

$user_id = $USER['id'];

$sql = "SELECT c.id, p.title, p.price, p.image, c.count
        FROM carts c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = $user_id";
$result = $database->query($sql)->fetchAll();

$sql2 = "SELECT SUM(p.price * c.count) AS sum
FROM carts c
JOIN products p ON c.product_id = p.id
WHERE c.user_id = $user_id";
$sum = $database->query($sql2)->fetch();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['increment'])) {

  $cart_id = $_POST['cart_id'];
  $sql = "UPDATE carts SET count = count + 1 WHERE id = $cart_id";
  $database->query($sql);
  header('Location: ./?page=cart');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['decrement'])) {
  $count = $_POST['count'];
  $cart_id = $_POST['cart_id'];
  if ($count > 1) {
    $sql = "UPDATE carts SET count = count - 1 WHERE id = $cart_id";
    $database->query($sql);
    header('Location: ./?page=cart');
  } else {
    $sql = "DELETE FROM carts WHERE id = $cart_id";
    $database->query($sql);
    header('Location: ./?page=cart');
  }
}
?>

<!-- Cart -->
<section id="cart" class="container mt-40">
  <h2 class="section-title">Корзина</h2>
  <?php if (!empty($result)): ?>
    <?php foreach ($result as $cart): ?>
      <div class="cart-item">
        <img src="<?= $cart['image'] ?>" alt="" style="width:80px;height:80px;object-fit:cover;border-radius:6px">
        <div style="flex: 1">
          <p class="card-title"><?= $cart['title'] ?></p>
          <p class="card-description">
          <p><?= number_format($cart['price'], 0, '', ' ') ?> ₽</p>
          </p>
        </div>

        <div class="cart-wrapper" style="display: flex; align-items: center;gap: 10px;">
          <form action="" method="post">
            <input type="hidden" name="count" value="<?= $cart['count'] ?>">
            <input type="hidden" name="cart_id" value="<?= $cart['id'] ?>">
            <input type="submit" value="-" class="btn btn-no-fill" name="decrement">
          </form>
          <p style="font-size: 20px; margin: 0 10px"><?= $cart['count'] ?></p>
          <form action="" method="post">
            <input type="hidden" name="cart_id" value="<?= $cart['id'] ?>">
            <input type="submit" value="+" class="btn btn-no-fill" name="increment">
          </form>
        </div>
      </div>
    <?php endforeach; ?>
    <div style="text-align:right">
      <button class="btn btn-main">Оформить заказ</button>
    </div>

    <p class="cart-summary">Итого: <?= number_format($sum['sum'], 0, '', ' ') ?> ₽</p>

  <?php else: ?>
    <p>
      у вас корзина пустая
    </p>
  <?php endif; ?>
</section>