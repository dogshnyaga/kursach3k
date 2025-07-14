<?php
include('database/connection.php');
include('head.php');
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Люмен | Магазин товаров для освещения</title>
    <link rel="stylesheet" href="assets/style/style.css">
    <link rel="shortcut icon" href="assets/ico/favicon.svg" type="image/x-icon">
    <script src="assets/js/main.js" defer></script>
</head>


<body>
    <?php
    include('blocks/header.php');
    if (isset($_GET['page'])) {
        echo '<div class="header-room"> </div>';
    }
    ?>

    <main>
        <?php
        if (!isset($_SESSION['user_id'])) {
            include('modal/login.php');
            include('modal/reg.php');
        }

        if (isset($_GET['page'])) {
            $page = $_GET['page'];
            $requireAuth = in_array($page, ['profile', 'cart']);
            $requireAdmin = in_array($page, ['admin', 'create-category', 'create-product', 'edit-category', 'edit-product', 'edit-profile', 'delete-category', 'delete-product']);

            if ($requireAuth && !isset($_SESSION['user_id'])) {
                include('incl/404.php');
                exit;
            }

            if ($requireAdmin && (!isset($_SESSION['user_id']) || $USER['role'] !== 'admin')) {
                include('incl/404.php');
                exit;
            }

            switch ($page) {
                case 'product';
                    include('incl/product.php');
                    break;

                case 'profile';
                    include('incl/profile.php');
                    break;

                case 'catalog';
                    include('incl/catalog.php');
                    break;

                case 'cart';
                    include('incl/cart.php');
                    break;

                case 'admin';
                    include('incl/admin.php');
                    break;

                case 'create-category':
                    include('incl/create-category.php');
                    break;

                case 'create-product':
                    include('incl/create-product.php');
                    break;

                case 'delete-category':
                    include('incl/delete-category.php');
                    break;

                case 'delete-product':
                    include('incl/delete-product.php');
                    break;

                case 'edit-category':
                    include('incl/edit-category.php');
                    break;

                case 'edit-product':
                    include('incl/edit-product.php');
                    break;

                case 'edit-profile':
                    include('incl/edit-profile.php');
                    break;

                case 'about':
                    include('incl/about.php');
                    break;

                default:
                    include('incl/404.php');
                    exit;
            }
        } else {
            include('landing.php');
        }
        ?>
    </main>
    <?php include('blocks/footer.php');
    ?>


</body>

</html>