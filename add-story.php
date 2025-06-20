<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db_functions.php';

$userId = $_SESSION['user_id'];

$sql = "SELECT role FROM users WHERE id = :id LIMIT 1";
$rows = dbSelect($sql, [':id' => $userId]);

if (empty($rows) || $rows[0]['role'] !== 'admin') {
    header("Location: account.php");
    exit;
}

// Обработка формы добавления серии
$successMessage = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_story'])) {
    require 'config.php';

    $episode = trim($_POST['episode_number']);
    $videoUrl = trim($_POST['video_url']);

    if ($episode !== '' && $videoUrl !== '') {
        $stmt = $conn->prepare("INSERT INTO stories (episode_number, video_url) VALUES (?, ?)");
        $stmt->bind_param("ss", $episode, $videoUrl);
        $stmt->execute();
        $stmt->close();

        $successMessage = "Серия успешно добавлена!";
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}

// Получим список всех серий для таблицы
$sqlStories = "SELECT id, episode_number, video_url FROM stories ORDER BY episode_number ASC";
$stories = dbSelect($sqlStories);

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
        <h1 class="mb-4">Добавить новую серию</h1>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="add-story-form mb-5">
            <form action="add-story.php" method="POST" novalidate>
                <div class="mb-3">
                    <label for="episode_number" class="form-label">Номер серии</label>
                    <input type="text" class="form-control" id="episode_number" name="episode_number" required>
                </div>
                <div class="mb-3">
                    <label for="video_url" class="form-label">Ссылка на видео</label>
                    <input type="url" class="form-control" id="video_url" name="video_url" required placeholder="https://example.com/video.mp4">
                </div>
                <button type="submit" name="add_story" class="btn btn-primary">Добавить серию</button>
            </form>
        </section>

        <section class="stories-section">
            <h2 class="h3 mb-4">Все серии</h2>
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Номер серии</th>
                        <th>Ссылка на видео</th>
                        <th>Просмотр</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stories as $story): ?>
                        <tr>
                            <td><?= htmlspecialchars($story['episode_number']) ?></td>
                            <td><?= htmlspecialchars($story['video_url']) ?></td>
                            <td><a href="<?= htmlspecialchars($story['video_url']) ?>" target="_blank" class="btn btn-info btn-sm">Смотреть</a></td>
                            <td>
                                <!-- Здесь можно добавить кнопки для редактирования/удаления, если нужно -->
                                <!-- Например, кнопка удаления с подтверждением -->
                                <a href="delete_story.php?id=<?= $story['id'] ?>" onclick="return confirm('Вы уверены, что хотите удалить эту серию?')" class="btn btn-danger btn-sm">Удалить</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($stories)): ?>
                        <tr>
                            <td colspan="4" class="text-center">Серий пока нет.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
