<?php
session_start();

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once 'db_functions.php';
require_once 'config.php';

$userId = $_SESSION['user_id'];

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

// Обработка изменения статуса заказа
$successMessage = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['new_status'];
    
    $updateSql = "UPDATE orders SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("si", $newStatus, $orderId);
    
    if ($stmt->execute()) {
        $successMessage = "Статус заказа успешно обновлен!";
    } else {
        $error = "Ошибка при обновлении статуса заказа.";
    }
    $stmt->close();
}

// Получаем список всех заказов с информацией о пользователях и товарах
$sqlOrders = "SELECT o.*, u.name as user_name, u.email as user_email, 
              p.name as product_name, p.price, p.image_url 
              FROM orders o 
              JOIN users u ON o.user_id = u.id 
              JOIN products p ON o.product_id = p.id 
              ORDER BY o.order_date DESC";
$result = $conn->query($sqlOrders);
$orders = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
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
        <h1 class="mb-4">Обработка заказов</h1>

        <?php if ($successMessage): ?>
            <div class="alert alert-success"><?= htmlspecialchars($successMessage) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <section class="orders-section">
            <h2 class="h3 mb-4">Все заказы</h2>
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Товар</th>
                        <th>Покупатель</th>
                        <th>Телефон</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th>Дата заказа</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?= htmlspecialchars($order['id']) ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($order['image_url']) ?>" alt="<?= htmlspecialchars($order['product_name']) ?>" 
                                     style="width: 50px; height: 50px; object-fit: cover;" class="me-2">
                                <?= htmlspecialchars($order['product_name']) ?>
                            </td>
                            <td>
                                <?= htmlspecialchars($order['customer_name']) ?><br>
                                <small class="text-muted"><?= htmlspecialchars($order['user_email']) ?></small>
                            </td>
                            <td><?= htmlspecialchars($order['phone']) ?></td>
                            <td><?= htmlspecialchars($order['quantity']) ?></td>
                            <td><?= htmlspecialchars(number_format($order['price'] * $order['quantity'], 2)) ?> ₽</td>
                            <td><?= htmlspecialchars(date('d.m.Y H:i', strtotime($order['order_date']))) ?></td>
                            <td>
                                <span class="badge <?= getStatusBadgeClass($order['status']) ?>">
                                    <?= htmlspecialchars(getStatusText($order['status'])) ?>
                                </span>
                            </td>
                            <td>
                                <form method="POST" class="d-inline">
                                    <input type="hidden" name="order_id" value="<?= $order['id'] ?>">
                                    <select name="new_status" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>В обработке</option>
                                        <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Отправлен</option>
                                        <option value="in-transit" <?= $order['status'] === 'in-transit' ? 'selected' : '' ?>>В пути</option>
                                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Доставлен</option>
                                    </select>
                                    <button type="submit" name="update_status" class="btn btn-primary btn-sm ms-2">
                                        Обновить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="9" class="text-center">Заказов пока нет.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
// Вспомогательные функции для отображения статуса
function getStatusBadgeClass($status) {
    switch ($status) {
        case 'processing':
            return 'bg-warning text-dark';
        case 'shipped':
            return 'bg-info text-dark';
        case 'in-transit':
            return 'bg-primary';
        case 'completed':
            return 'bg-success';
        default:
            return 'bg-secondary';
    }
}

function getStatusText($status) {
    switch ($status) {
        case 'processing':
            return 'В обработке';
        case 'shipped':
            return 'Отправлен';
        case 'in-transit':
            return 'В пути';
        case 'completed':
            return 'Завершён';
        default:
            return 'Неизвестно';
    }
}
?> 