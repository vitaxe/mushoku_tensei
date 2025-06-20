<?php
session_start();
require_once 'config.php'; // Подключение к базе данных

// Проверка, если пользователь не авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Получение данных пользователя
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $description = $_POST['description'] ?? '';
    $password = $_POST['password'] ?? '';

    // Обработка аватара
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $avatar = $_FILES['avatar'];
        $avatar_filename = 'uploads/' . basename($avatar['name']);
        
        // Проверка на существование папки и создание её, если необходимо
        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        // Перемещение файла в папку
        if (move_uploaded_file($avatar['tmp_name'], $avatar_filename)) {
            // Обновление данных о аватаре в базе данных
            $stmt = $conn->prepare("UPDATE users SET img_url = ? WHERE id = ?");
            $stmt->bind_param("si", $avatar_filename, $user_id);
            $stmt->execute();
        } else {
            echo "Ошибка загрузки аватара: не удалось переместить файл.";
        }
    }

    // Обработка пароля
    if ($password) {
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $password_hash, $user_id);
        $stmt->execute();
    }

    // Обновление других данных
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssi", $username, $email, $description, $user_id);
    $stmt->execute();

    // Перенаправление после успешного обновления
    header("Location: account.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактирование профиля</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_editing.css">
    <link rel="stylesheet" href="./assets/style_header.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="./index.php"><img src="./image/logo.svg" alt="логотип сайта"></a>
            </div>
            <ul class="head">
                <li><a href="./index.php">Главная страница</a></li>
                <li><a href="./story.php">История</a></li>
                <li><a href="./character.php">Персонажи</a></li>
                <li><a href="./gallerey.php">Галерея</a></li>
                <li><a href="./shop.php">Магазин</a></li>
                <li><a href="./book.php">Книги</a></li>
            </ul>
            <div class="account">
                <a href="./account.php"><img src="./image/account.svg" alt="аккаунт"></a>
            </div>
        </nav>
    </header>

    <div class="bottom-nav">
        <a href="./book.php" class="nav-item">
            <img src="./image/book-icon.svg" alt="Книги">
            <span>Книги</span>
        </a>
        <a href="./story.php" class="nav-item">
            <img src="./image/story-icon.svg" alt="История">
            <span>История</span>
        </a>
        <a href="./index.php" class="nav-item logo-center">
            <img src="./image/logo.svg" alt="Логотип">
        </a>
        <a href="./shop.php" class="nav-item">
            <img src="./image/shop-icon.svg" alt="Магазин">
            <span>Магазин</span>
        </a>
        <a href="./account.php" class="nav-item">
            <img src="./image/account-icon.svg" alt="Аккаунт">
            <span>Аккаунт</span>
        </a>
    </div>

    <!-- Форма редактирования профиля -->
    <section class="edit-profile">
        <h2>Редактировать профиль</h2>
        <div class="edit-profile-content">
            <form action="editing.php" method="POST" enctype="multipart/form-data">
                <label for="username">Имя:</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['name']); ?>">

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>">

                <label for="description">Описание:</label>
                <textarea id="description" name="description" rows="4" placeholder="Введите описание"><?= htmlspecialchars($user['description']); ?></textarea>

                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" placeholder="Введите новый пароль">

                <!-- Загрузка аватарки -->
                <label for="avatar">Аватар:</label>
                <input type="file" id="avatar" name="avatar" accept="image/*">
                <div class="image-preview">
                    <?php if ($user['img_url']): ?>
                        <img src="<?= htmlspecialchars($user['img_url']); ?>" alt="Предварительный просмотр аватара">
                    <?php endif; ?>
                </div>

                <button type="submit" class="save-btn">Сохранить изменения</button>
            </form>
        </div>
    </section>

    <?php
    require 'assets/footer.php'
    ?>

</body>

</html>
