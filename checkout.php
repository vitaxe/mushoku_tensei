<?php
session_start();
require 'db_functions.php';

// Проверка: корзина не пуста
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

$cartItems = [];
$total = 0;

// Получение товаров
$pdo = dbConnect();
$ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
$stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
$cartItems = $stmt->fetchAll();

foreach ($cartItems as $item) {
    $quantity = $_SESSION['cart'][$item['id']]['quantity'];
    $total += $item['price'] * $quantity;
}

// Обработка оформления заказа
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    if ($name && $phone) {
        // В реальности: сохранить заказ в БД
        $_SESSION['cart'] = []; // очищаем корзину
        header('Location: thank-you.php');
        exit;
    } else {
        $error = "Пожалуйста, заполните все поля.";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Оформление заказа | Roxy</title>
    <link rel="stylesheet" href="./css/style_cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Оформление заказа</h2>

    <?php if (!empty($error)): ?>
        <div class="error-message">
            <?= $error ?>
        </div>
    <?php endif; ?>

    <ul>
        <?php foreach ($cartItems as $item): ?>
            <li>
                <strong><?= htmlspecialchars($item['name']) ?></strong>
                <p>Количество: <?= $_SESSION['cart'][$item['id']]['quantity'] ?></p>
                <p>Стоимость: <?= number_format($item['price'] * $_SESSION['cart'][$item['id']]['quantity'], 0, '', ' ') ?> ₽</p>
            </li>
        <?php endforeach; ?>
    </ul>

    <div class="total">
        <h3>Итого к оплате: <?= number_format($total, 0, '', ' ') ?> ₽</h3>
    </div>

    <form method="POST">
        <label>
            Ваше имя
            <input type="text" name="name" required placeholder="Введите ваше имя">
        </label>

        <label>
            Номер телефона
            <input type="text" name="phone" required placeholder="Введите номер телефона">
        </label>

        <button type="submit" class="checkout-btn">Подтвердить заказ</button>
    </form>

    <a href="cart.php">← Вернуться в корзину</a>
</body>
</html>