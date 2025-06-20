<?php
session_start();
require_once 'db_functions.php';

if (!isset($_SESSION['user_id']) || empty($_SESSION['cart'])) {
    header('Location: cart.php');
    exit;
}

// Получение информации о товарах в корзине
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

// Получение информации о пользователе
$userId = $_SESSION['user_id'];
$userQuery = "SELECT name, email FROM users WHERE id = :id";
$user = dbSelect($userQuery, [':id' => $userId])[0];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Подтверждение заказа</title>
    <link rel="stylesheet" href="./css/style_confirm.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="confirm-container">
        <h1>Подтверждение заказа</h1>
        
        <div class="order-summary">
            <h2>Ваш заказ</h2>
            <div class="order-items">
                <?php foreach ($cartItems as $item): ?>
                    <div class="order-item">
                        <img src="<?= htmlspecialchars($item['image_url']) ?>" 
                             alt="<?= htmlspecialchars($item['name']) ?>">
                        <div class="item-details">
                            <h3><?= htmlspecialchars($item['name']) ?></h3>
                            <p class="quantity">Количество: <?= $_SESSION['cart'][$item['id']]['quantity'] ?></p>
                            <p class="price"><?= number_format($item['price'] * $_SESSION['cart'][$item['id']]['quantity'], 0, '', ' ') ?> ₽</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="order-total">
                <h3>Итого к оплате:</h3>
                <p class="total-price"><?= number_format($total, 0, '', ' ') ?> ₽</p>
            </div>
        </div>

        <div class="contact-info">
            <p>После оформления заказа наш менеджер свяжется с вами по телефону для уточнения способа оплаты и деталей доставки.</p>
        </div>

        <form action="process_order.php" method="POST" class="contact-form">
            <h2>Контактные данные</h2>
            <div class="form-group">
                <label for="customer_name">Как к вам обращаться:</label>
                <input type="text" 
                       id="customer_name" 
                       name="customer_name" 
                       value="<?= htmlspecialchars($user['name']) ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="phone">Номер телефона:</label>
                <input type="tel" 
                       id="phone" 
                       name="phone" 
                       pattern="[0-9+\s\-\(\)]*" 
                       placeholder="+7 (___) ___-__-__" 
                       required>
            </div>

            <h2>Адрес доставки</h2>
            <div class="form-group">
                <label for="street">Улица:</label>
                <input type="text" 
                       id="street" 
                       name="street" 
                       placeholder="Название улицы"
                       required>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="house">Дом:</label>
                    <input type="text" 
                           id="house" 
                           name="house" 
                           placeholder="Номер дома"
                           required>
                </div>
                <div class="form-group half">
                    <label for="apartment">Квартира:</label>
                    <input type="text" 
                           id="apartment" 
                           name="apartment" 
                           placeholder="Номер квартиры">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group half">
                    <label for="city">Город:</label>
                    <input type="text" 
                           id="city" 
                           name="city" 
                           placeholder="Название города"
                           required>
                </div>
                <div class="form-group half">
                    <label for="postal_code">Почтовый индекс:</label>
                    <input type="text" 
                           id="postal_code" 
                           name="postal_code" 
                           pattern="[0-9]{6}" 
                           placeholder="123456"
                           required>
                </div>
            </div>

            <div class="form-actions">
                <a href="cart.php" class="back-btn">Вернуться в корзину</a>
                <button type="submit" class="confirm-btn">Подтвердить заказ</button>
            </div>
        </form>
    </div>

    <script>
    // Маска для телефона
    document.getElementById('phone').addEventListener('input', function(e) {
        let x = e.target.value.replace(/\D/g, '')
                           .match(/(\d{0,1})(\d{0,3})(\d{0,3})(\d{0,2})(\d{0,2})/);
        e.target.value = !x[2] ? x[1] : '+7 (' + x[2] + ') ' + (x[3] ? x[3] + '-' : '') 
                                     + (x[4] ? x[4] + '-' : '') + x[5];
    });
    </script>
</body>
</html> 