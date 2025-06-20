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

// Получаем список книг
$sqlBooks = "SELECT id, title, description, image_url, link FROM books";
$books = dbSelect($sqlBooks);

// Добавление или редактирование книги
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_book'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $link = trim($_POST['link']);
    $imageUrl = trim($_POST['image_url']); // Ссылка на изображение
    
    // Валидация
    if (!empty($title) && !empty($description) && !empty($link) && !empty($imageUrl)) {
        if (isset($_POST['book_id']) && $_POST['book_id']) {
            // Если редактируем книгу
            $bookId = (int)$_POST['book_id'];
            $sqlUpdate = "UPDATE books SET title = :title, description = :description, image_url = :image_url, link = :link WHERE id = :id";
            dbQuery($sqlUpdate, [
                ':title' => $title,
                ':description' => $description,
                ':image_url' => $imageUrl,
                ':link' => $link,
                ':id' => $bookId
            ]);
        } else {
            // Если добавляем новую книгу
            $sqlInsert = "INSERT INTO books (title, description, image_url, link) VALUES (:title, :description, :image_url, :link)";
            dbInsert($sqlInsert, [':title' => $title, ':description' => $description, ':image_url' => $imageUrl, ':link' => $link]);
        }
        header("Location: add-books.php"); // Перезагружаем страницу после добавления или редактирования
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля и укажите ссылку на изображение.";
    }
}

// Если редактируем книгу, получаем ее данные
$editBook = null;
if (isset($_GET['id'])) {
    $bookId = (int)$_GET['id'];
    $sqlEdit = "SELECT * FROM books WHERE id = :id LIMIT 1";
    $editBook = dbSelect($sqlEdit, [':id' => $bookId]);
    $editBook = $editBook ? $editBook[0] : null; // Если книга существует, загружаем
}

// Удаление книги
if (isset($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];
    $sqlDelete = "DELETE FROM books WHERE id = :id";
    dbQuery($sqlDelete, [':id' => $deleteId]);
    header("Location: add-books.php"); // Перезагружаем страницу после удаления
    exit;
}
?>



<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить книгу</title>
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
        <h1 class="mb-4"><?= isset($editBook) ? 'Редактировать книгу' : 'Добавить книгу' ?></h1>

        <!-- Форма добавления или редактирования книги -->
        <section class="add-book-form mb-5">
            <h2 class="h3 mb-4"><?= isset($editBook) ? 'Редактировать книгу' : 'Добавить новую книгу' ?></h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="add-books.php" method="POST">
                <?php if (isset($editBook)): ?>
                    <input type="hidden" name="book_id" value="<?= $editBook['id'] ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label for="title" class="form-label">Название книги</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $editBook['title'] ?? '' ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Описание книги</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required><?= $editBook['description'] ?? '' ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Ссылка на изображение обложки</label>
                    <input type="url" class="form-control" id="image_url" name="image_url" value="<?= $editBook['image_url'] ?? '' ?>" placeholder="https://example.com/image.jpg" required>
                </div>
                <div class="mb-3">
                    <label for="link" class="form-label">Ссылка на чтение</label>
                    <input type="url" class="form-control" id="link" name="link" value="<?= $editBook['link'] ?? '' ?>" required>
                </div>
                <button type="submit" class="btn btn-primary" name="add_book"><?= isset($editBook) ? 'Сохранить изменения' : 'Добавить книгу' ?></button>
            </form>
        </section>

        <!-- Управление книгами -->
        <section class="books-section mb-5">
            <h2 class="h3 mb-4">Управление книгами</h2>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Обложка</th>
                        <th>Ссылка на чтение</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($books as $book): ?>
                        <tr>
                            <td><?= htmlspecialchars($book['title']) ?></td>
                            <td><?= htmlspecialchars($book['description']) ?></td>
                            <td><img src="<?= htmlspecialchars($book['image_url']) ?>" alt="Обложка книги" width="100"></td>
                            <td><a href="<?= htmlspecialchars($book['link']) ?>" class="btn btn-info btn-sm" target="_blank">Читать</a></td>
                            <td>
                                <a href="add-books.php?id=<?= $book['id'] ?>" class="btn btn-warning btn-sm">Редактировать</a>
                                <a href="add-books.php?delete_id=<?= $book['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Вы уверены?')">Удалить</a>
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
