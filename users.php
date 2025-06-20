<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db_functions.php';
require_once 'config.php';

$userId = $_SESSION['user_id'];

// Проверка роли администратора
$sql = "SELECT role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (empty($user) || $user['role'] !== 'admin') {
    header("Location: account.php");
    exit;
}

// Обработка удаления пользователя
$successMessage = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user'])) {
    $userIdToDelete = $_POST['user_id'];
    
    if ($userIdToDelete != $userId) { // Предотвращаем удаление самого себя
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userIdToDelete);
        
        if ($stmt->execute()) {
            $successMessage = "Пользователь успешно удален!";
        } else {
            $error = "Ошибка при удалении пользователя.";
        }
        $stmt->close();
    } else {
        $error = "Вы не можете удалить свой собственный аккаунт!";
    }
}

// Обработка обновления роли пользователя
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_role'])) {
    $userIdToUpdate = $_POST['user_id'];
    $newRole = $_POST['new_role'];
    
    if ($userIdToUpdate != $userId) { // Предотвращаем изменение своей роли
        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $newRole, $userIdToUpdate);
        
        if ($stmt->execute()) {
            $successMessage = "Роль пользователя успешно обновлена!";
        } else {
            $error = "Ошибка при обновлении роли пользователя.";
        }
        $stmt->close();
    } else {
        $error = "Вы не можете изменить свою собственную роль!";
    }
}

// Получение списка всех пользователей
$sqlUsers = "SELECT id, name, email, role, created_at FROM users ORDER BY created_at DESC";
$result = $conn->query($sqlUsers);
$users = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="icon" type="image/svg+xml" href="./image/logo.svg">
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
        <h1 class="mb-4">Управление пользователями</h1>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="users-section">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя пользователя</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th>Дата регистрации</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['id']) ?></td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                    <select name="new_role" class="form-select form-select-sm" 
                                            <?= $user['id'] == $userId ? 'disabled' : '' ?>>
                                        <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>Пользователь</option>
                                        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Администратор</option>
                                    </select>
                                    <?php if ($user['id'] != $userId): ?>
                                        <button type="submit" name="update_role" class="btn btn-primary btn-sm ms-2">
                                            Обновить роль
                                        </button>
                                    <?php endif; ?>
                                </form>
                            </td>
                            <td><?= htmlspecialchars($user['created_at']) ?></td>
                            <td>
                                <?php if ($user['id'] != $userId): ?>
                                    <form method="POST" class="d-inline" onsubmit="return confirm('Вы уверены, что хотите удалить этого пользователя?');">
                                        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                                        <button type="submit" name="delete_user" class="btn btn-danger btn-sm">
                                            Удалить
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="text-center">Пользователей не найдено.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>