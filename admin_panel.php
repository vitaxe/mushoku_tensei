<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db_functions.php';

$userId = $_SESSION['user_id'];

// Получаем информацию о пользователе
$sql = "SELECT role FROM users WHERE id = :id LIMIT 1";
$rows = dbSelect($sql, [':id' => $userId]);

if (empty($rows) || $rows[0]['role'] !== 'admin') {
    header("Location: account.php"); // Если пользователь не админ, перенаправляем на его аккаунт
    exit;
}

// Получаем список пользователей
$sqlUsers = "SELECT id, name, email, role FROM users";
$users = dbSelect($sqlUsers);

// Получаем список книг
$sqlBooks = "SELECT id, title, description FROM books";
$books = dbSelect($sqlBooks);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <!-- Подключение Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJr+MQX0r4HU2v8wP5g8cFf8Xg+7JfbT0OryhpmVEn7E5Cxw6cxH2kmYfqJb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php"><img src="./image/logo.svg" alt="логотип сайта" height="40"></a>
                
                <!-- Навигационное меню -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="add-books.php">Добавить книгу</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Управление пользователями</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-story.php">Добавить серию</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add_product.php">Добавить товар</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add-orders.php">Обработка заказов</a>
                    </li>
                </ul>

                <div class="account">
                    <a href="./account.php"><img src="./image/account.svg" alt="аккаунт" height="30"></a>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5">
        <h1 class="mb-4">Панель администратора </h1>

        <!-- Управление пользователями -->
        <section class="users-section mb-5">
            <h2>Управление пользователями</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Имя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                            <td>
                                <!-- Пример действий: изменить роль или удалить пользователя -->
                                <a href="edit_user.php?id=<?= $user['id'] ?>" class="btn btn-primary btn-sm">Редактировать</a>
                                <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Управление книгами -->
        <section class="books-section mb-5">
            <h2>Управление книгами</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['description']) ?></td>
                            <td>
                                <a href="add-books.php?id=<?= $book['id'] ?>" class="btn btn-primary btn-sm">Редактировать</a>
                                <a href="delete_book.php?id=<?= $book['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </main>

    <!-- Подключение Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-kaGbzmYw7ANz4j5A5y9auOZgh09e8JtZv5eZlbFi0Xw+x+TvvRA0tGZ7ZRtA5nD6" crossorigin="anonymous"></script>
</body>

</html>
