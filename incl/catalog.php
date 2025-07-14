<?php // Обработка фильтров
$where = [];
$params = [];

// Фильтр по цене (позиционные параметры)
if (isset($_GET['min_price']) && is_numeric($_GET['min_price'])) {
    $where[] = 'price >= ?';
    $params[] = $_GET['min_price'];
}

if (isset($_GET['max_price']) && is_numeric($_GET['max_price'])) {
    $where[] = 'price <= ?';
    $params[] = $_GET['max_price'];
}

// Фильтр по мощности (позиционные параметры)
if (isset($_GET['min_power']) && is_numeric($_GET['min_power'])) {
    $where[] = 'power >= ?';
    $params[] = $_GET['min_power'];
}

if (isset($_GET['max_power']) && is_numeric($_GET['max_power'])) {
    $where[] = 'power <= ?';
    $params[] = $_GET['max_power'];
}
// Обработка фильтра по производителям
if (!empty($_GET['brands'])) {
    $brandIds = array_map('intval', (array)$_GET['brands']);
    $brandIds = array_filter($brandIds);

    if (!empty($brandIds)) {
        $placeholders = implode(',', array_fill(0, count($brandIds), '?'));
        $where[] = "manufacturer_id IN ($placeholders)";
        $params = array_merge($params, $brandIds);
    }
}

// Обработка фильтра по цветам
if (!empty($_GET['colors'])) {
    $colorIds = array_map('intval', (array)$_GET['colors']);
    $colorIds = array_filter($colorIds);

    if (!empty($colorIds)) {
        $placeholders = implode(',', array_fill(0, count($colorIds), '?'));
        $where[] = "color_id IN ($placeholders)";
        $params = array_merge($params, $colorIds);
    }
}

// Обработка фильтра по цоколям
if (!empty($_GET['sockets'])) {
    $socketIds = array_map('intval', (array)$_GET['sockets']);
    $socketIds = array_filter($socketIds);

    if (!empty($socketIds)) {
        $placeholders = implode(',', array_fill(0, count($socketIds), '?'));
        $where[] = "socket_type_id IN ($placeholders)";
        $params = array_merge($params, $socketIds);
    }
}

// Сортировка
$order = 'ORDER BY created_at DESC';
if (!empty($_GET['sort'])) {
    switch ($_GET['sort']) {
        case 'price_asc':
            $order = 'ORDER BY price ASC';
            break;
        case 'price_desc':
            $order = 'ORDER BY price DESC';
            break;
        case 'new':
            $order = 'ORDER BY created_at DESC';
            break;
        case 'popular':
            $order = 'ORDER BY created_at DESC';
            break;
    }
}

// Получаем товары
$sql = "SELECT products.*, 
            manufacturers.name AS manufacturer_name,
            colors.name AS color_name,
            socket_types.name AS socket_type_name
        FROM products
        LEFT JOIN manufacturers ON products.manufacturer_id = manufacturers.id
        LEFT JOIN colors ON products.color_id = colors.id
        LEFT JOIN socket_types ON products.socket_type_id = socket_types.id";

if (!empty($where)) {
    $sql .= " WHERE " . implode(' AND ', $where);
}

if (!empty($order)) {
    $sql .= " $order";
}

$stmt = $database->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(pdo::FETCH_ASSOC);

// Получаем справочники для фильтров
$manufacturers = $database->query("SELECT * FROM manufacturers")->fetchAll();
$colors = $database->query("SELECT * FROM colors")->fetchAll();
$socketTypes = $database->query("SELECT * FROM socket_types")->fetchAll();

// Добавление в корзину

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (isset($USER['role'])) {
        // Обработка добавления в корзину для авторизованного пользователя
        $product_id = $_POST['product_id'] ?? 0;
        if ($product_id > 0) {
            $user_id = $USER['id'];
            $checkSql = "SELECT id, count FROM carts WHERE product_id = $product_id AND user_id = $user_id";
            $existing = $database->query($checkSql)->fetch();

            if ($existing) {
                $newCount = $existing['count'] + 1;
                $updateSql = "UPDATE carts SET count = $newCount WHERE id = {$existing['id']}";
                $database->query($updateSql);
            } else {
                $insertSql = "INSERT INTO carts (product_id, user_id, count) VALUES ($product_id, $user_id, 1)";
                $database->query($insertSql);
            }
            header('Location: ./?page=cart');
            exit();
        }
    }
}
?>
<div class="catalog-page container mt-40">
    <div class="catalog-container">
        <div class="filters">
            <div class="filters-header">
                <h1>Фильтры</h1>
                <button type="button" class="btn-main close-filters">&times;</button>
            </div>
            <form method="get" class="catalog-form" id="catalogFilterForm">
                <input type="hidden" name="page" value="catalog">

                <div class="filter-section">
                    <div class="filter-title">Производитель</div>
                    <?php foreach ($manufacturers as $manufacturer): ?>
                        <div class="filter-option">
                            <label class="checkbox-label">
                                <input type="checkbox" name="brands[]" value="<?= htmlspecialchars($manufacturer['id']) ?>"
                                    <?= (isset($_GET['brands']) && in_array($manufacturer['id'], (array)$_GET['brands'], false)) ? 'checked' : '' ?>
                                    onchange="this.form.submit()">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text"><?= htmlspecialchars($manufacturer['name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="filter-section">
                    <div class="filter-title">Цвет</div>
                    <?php foreach ($colors as $color): ?>
                        <div class="filter-option">
                            <label class="checkbox-label">
                                <input type="checkbox" name="colors[]" value="<?= htmlspecialchars($color['id']) ?>"
                                    <?= (isset($_GET['colors']) && in_array($color['id'], (array)$_GET['colors'], false)) ? 'checked' : '' ?>
                                    onchange="this.form.submit()">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text"><?= htmlspecialchars($color['name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="filter-section">
                    <div class="filter-title">Цоколь</div>
                    <?php foreach ($socketTypes as $type): ?>
                        <div class="filter-option">
                            <label class="checkbox-label">
                                <input type="checkbox" name="sockets[]" value="<?= htmlspecialchars($type['id']) ?>"
                                    <?= (isset($_GET['sockets']) && in_array($type['id'], (array)$_GET['sockets'], false)) ? 'checked' : '' ?>
                                    onchange="this.form.submit()">
                                <span class="checkbox-custom"></span>
                                <span class="checkbox-text"><?= htmlspecialchars($type['name']) ?></span>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="filter-section">
                    <legend>Цена</legend>
                    <div class="price-inputs">
                        <span>от</span>
                        <input class="price-input" type="number" name="min_price" placeholder="1600"
                            value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>"
                            oninput="debouncedSubmit(this.form)">
                        <span>до</span>
                        <input class="price-input" type="number" name="max_price" placeholder="520000"
                            value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>"
                            oninput="debouncedSubmit(this.form)">
                    </div>
                </div>

                <div class="filter-section">
                    <legend>Мощность</legend>
                    <div class="price-inputs">
                        <span>от</span>
                        <input class="price-input" type="number" name="min_power" placeholder="1"
                            value="<?= htmlspecialchars($_GET['min_power'] ?? '') ?>"
                            oninput="debouncedSubmit(this.form)">
                        <span>до</span>
                        <input class="price-input" type="number" name="max_power" placeholder="1000"
                            value="<?= htmlspecialchars($_GET['max_power'] ?? '') ?>"
                            oninput="debouncedSubmit(this.form)">
                    </div>
                </div>

                <button type="button" onclick="location.href='?page=catalog'" class="btn btn-main">⨉ Сбросить фильтры</button>
            </form>

            <script>
                let debounceTimer;

                function debouncedSubmit(form) {
                    clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(() => {
                        form.submit();
                    }, 500);
                }
                document.getElementById('catalogFilterForm').addEventListener('change', function(e) {
                    if (e.target.tagName === 'INPUT' && (e.target.type === 'checkbox' || e.target.type === 'radio')) {
                        this.submit();
                    }
                });
            </script>
        </div>

        <div class="products">
            <div class="card-page-content">
                <form method="get" class="sort-form">
                    <input type="hidden" name="page" value="catalog">
                    <input type="hidden" name="min_price" value="<?= htmlspecialchars($_GET['min_price'] ?? '') ?>">
                    <input type="hidden" name="max_price" value="<?= htmlspecialchars($_GET['max_price'] ?? '') ?>">

                    <select name="sort" class="sorting" onchange="this.form.submit()">
                        <option value="popular" <?= (isset($_GET['sort']) && $_GET['sort'] == 'popular') ? 'selected' : '' ?>>Сначала популярные</option>
                        <option value="price_asc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_asc') ? 'selected' : '' ?>>Сначала дешевые</option>
                        <option value="price_desc" <?= (isset($_GET['sort']) && $_GET['sort'] == 'price_desc') ? 'selected' : '' ?>>Сначала дорогие</option>
                        <option value="new" <?= (isset($_GET['sort']) && $_GET['sort'] == 'new') ? 'selected' : '' ?>>Сначала новые</option>
                    </select>
                </form>
                <button type="button" id="mobile-filters-toggle" class="btn btn-main mobile-only">
                    Фильтры
                </button>
            </div>

            <div class="cards">
                <?php foreach ($products as $product): ?>
                    <div class="card" onclick="location.href='./?page=product&id=<?= $product['id'] ?>'">
                        <img src="../<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['title']) ?>" class="card-cover">
                        <div class="card-content">
                            <div class="card-text">
                                <p class="card-title"><?= htmlspecialchars($product['title']) ?></p>
                                <p class="card-description">Производитель: <?= htmlspecialchars($product['manufacturer_name']) ?></p>
                                <p class="card-description">Цвет: <?= htmlspecialchars($product['color_name']) ?></p>
                                <p class="card-description">Цоколь: <?= htmlspecialchars($product['socket_type_name']) ?></p>
                                <p class="card-description">Мощность: <?= $product['power'] ?>W</p>
                            </div>
                            <div class="card-price-cart">
                                <p class="price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</p>

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
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filtersToggle = document.getElementById('mobile-filters-toggle');
        const filters = document.querySelector('.filters');
        const closeFilters = document.querySelector('.close-filters');

        if (filtersToggle && filters) {
            filtersToggle.addEventListener('click', function() {
                filters.classList.toggle('active');
            });
        }
        // Закрытие фильтров по крестику
        if (closeFilters && filters) {
            closeFilters.addEventListener('click', function() {
                filters.classList.remove('active');
            });
        }
    });
</script>