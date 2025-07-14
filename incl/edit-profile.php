<?php
// Получаем данные текущего пользователя
if (!isset($USER['id'])) {
    header("Location: ./?page=login");
    exit();
}

$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $database->prepare($sql);
$stmt->execute([':id' => $USER['id']]);
$user = $stmt->fetch();

if (!$user) {
    echo 'Пользователь не найден';
    exit();
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Валидация
    if (empty($name)) {
        $errors['name'] = 'Имя обязательно';
    }

    if (empty($email)) {
        $errors['email'] = 'Email обязателен';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Некорректный email';
    }

    // Проверка старого пароля, если пытаются изменить пароль
    if (!empty($new_password)) {
        if (empty($old_password)) {
            $errors['old_password'] = 'Введите текущий пароль';
        } elseif (!password_verify($old_password, $user['password'])) {
            $errors['old_password'] = 'Неверный текущий пароль';
        }

        if ($new_password !== $confirm_password) {
            $errors['confirm_password'] = 'Пароли не совпадают';
        } elseif (strlen($new_password) < 6) {
            $errors['new_password'] = 'Пароль должен быть не менее 6 символов';
        }
    }

    // Если ошибок нет - обновляем данные
    if (empty($errors)) {
        $update_data = [
            ':id' => $USER['id'],
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone
        ];

        $sql = "UPDATE users SET 
                name = :name,
                email = :email,
                phone = :phone";

        // Если указан новый пароль - добавляем его к обновлению
        if (!empty($new_password)) {
            $sql .= ", password = :password";
            $update_data[':password'] = password_hash($new_password, PASSWORD_DEFAULT);
        }

        $sql .= " WHERE id = :id";

        $stmt = $database->prepare($sql);

        if ($stmt->execute($update_data)) {
            $_SESSION['success'] = 'Данные успешно обновлены';
            header("Location: ./?page=profile");
            exit();
        } else {
            $errors['db'] = 'Ошибка при обновлении данных';
        }
    }
}
?>

<main>
    <section id="edit-profile" class="container mt-40">
        <form method="post" class="form-wrapper">
            <h2 class="section-title">Редактирование профиля</h2>

            <?php if (!empty($errors['db'])): ?>
                <div class="error"><?= $errors['db'] ?></div>
            <?php endif; ?>

            <div>
                <label>Имя</label>
                <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
                <?php if (!empty($errors['name'])): ?>
                    <div class="error"><?= $errors['name'] ?></div>
                <?php endif; ?>

                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                <?php if (!empty($errors['email'])): ?>
                    <div class="error"><?= $errors['email'] ?></div>
                <?php endif; ?>

                <label>Телефон</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">

                <h3>Смена пароля</h3>

                <label>Текущий пароль</label>
                <input type="password" name="old_password">
                <?php if (!empty($errors['old_password'])): ?>
                    <div class="error"><?= $errors['old_password'] ?></div>
                <?php endif; ?>

                <label>Новый пароль</label>
                <input type="password" name="new_password">
                <?php if (!empty($errors['new_password'])): ?>
                    <div class="error"><?= $errors['new_password'] ?></div>
                <?php endif; ?>

                <label>Подтвердите новый пароль</label>
                <input type="password" name="confirm_password">
                <?php if (!empty($errors['confirm_password'])): ?>
                    <div class="error"><?= $errors['confirm_password'] ?></div>
                <?php endif; ?>

                <button type="submit" class="btn btn-main">Сохранить изменения</button>
            </div>
        </form>
    </section>
</main>