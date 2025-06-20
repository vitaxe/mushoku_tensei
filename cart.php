<?php
session_start();
require 'db_functions.php';

// Инициализируем корзину, если ещё нет
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Обработка POST запросов
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        // Удаление товара из корзины
        $removeId = $_POST['remove'];
        if (isset($_SESSION['cart'][$removeId])) {
            unset($_SESSION['cart'][$removeId]);
        }
    } elseif (isset($_POST['update_quantity'])) {
        // Обновление количества товара
        $productId = $_POST['product_id'];
        $newQuantity = (int)$_POST['quantity'];
        
        if ($newQuantity > 0 && $newQuantity <= 99) {
            $_SESSION['cart'][$productId]['quantity'] = $newQuantity;
        }
    }
}

// Получение товаров из корзины
$cartItems = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $pdo = dbConnect();
    $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($cartItems as $item) {
        $quantity = $_SESSION['cart'][$item['id']]['quantity'];
        $total += $item['price'] * $quantity;
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина</title>
    <link rel="stylesheet" href="./css/style_cart.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <h2>Ваша корзина</h2>
    
    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <p>Корзина пуста</p>
            <a href="shop.php" class="checkout-btn">Перейти в магазин</a>
        </div>
    <?php else: ?>
        <ul>
            <?php foreach ($cartItems as $item): ?>
                <li>
                    <strong><?= htmlspecialchars($item['name']) ?></strong>
                    <p>Цена: <?= number_format($item['price'], 0, '', ' ') ?> ₽</p>
                    <div class="quantity-controls">
                        <form method="POST" class="quantity-form">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <input type="hidden" name="update_quantity" value="1">
                            <label>
                                Количество:
                                <div class="quantity-wrapper">
                                    <button type="button" class="quantity-btn minus" onclick="updateQuantity(this, -1)">−</button>
                                    <input type="number" 
                                           name="quantity" 
                                           value="<?= $_SESSION['cart'][$item['id']]['quantity'] ?>" 
                                           min="1" 
                                           max="99" 
                                           class="quantity-input"
                                           onchange="this.form.submit()">
                                    <button type="button" class="quantity-btn plus" onclick="updateQuantity(this, 1)">+</button>
                                </div>
                            </label>
                        </form>
                        <form method="POST" class="remove-form">
                            <button type="submit" name="remove" value="<?= $item['id'] ?>" class="remove-btn">Удалить</button>
                        </form>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
        
        <div class="cart-total">
            <h3>Итого: <?= number_format($total, 0, '', ' ') ?> ₽</h3>
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="confirm_order.php" class="checkout-btn">Оформить заказ</a>
                <?php else: ?>
                    <div class="auth-message">
                        <p>Для оформления заказа необходимо войти в аккаунт</p>
                        <div class="auth-buttons">
                            <a href="login.php" class="auth-btn login-btn">Войти</a>
                            <a href="register.php" class="auth-btn register-btn">Зарегистрироваться</a>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="error-message">
                <?= htmlspecialchars($_SESSION['error_message']) ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        
        <a href="shop.php">← Вернуться в магазин</a>
    <?php endif; ?>

    <script>
    function updateQuantity(button, change) {
        const input = button.parentNode.querySelector('input[type="number"]');
        const currentValue = parseInt(input.value);
        const newValue = currentValue + change;
        
        if (newValue >= 1 && newValue <= 99) {
            input.value = newValue;
            input.form.submit();
        }
    }
    </script>
</body>
</html>
