<?php
session_start();
require './config.php';

// Получение ID товара из URL
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Получение информации о товаре
$query = "SELECT * FROM products WHERE id = $product_id";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

// Если товар не найден, перенаправляем на страницу магазина
if (!$product) {
    header('Location: shop.php');
    exit;
}

// Добавление товара в корзину
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] = ['quantity' => 1];
    } else {
        $_SESSION['cart'][$product_id]['quantity']++;
    }
    header('Location: cart.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?> | Магазин</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_product.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/style_header.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <a href="./index.php"><img src="./image/logo.svg" alt="Логотип сайта"></a>
            </div>
            <ul class="head">
                <li><a href="./index.php">Главная страница</a></li>
                <li><a href="./story.php">История</a></li>
                <li><a href="./character.php">Персонажи</a></li>
                <li><a href="./gallerey.php">Галерея</a></li>
                <li><a href="./shop.php" class="active">Магазин</a></li>
                <li><a href="./book.php">Книги</a></li>
            </ul>
            <div class="account">
                <a href="./account.php"><img src="./image/account.svg" alt="Аккаунт"></a>
            </div>
        </nav>
    </header>

    <div class="bottom-nav">
        <a href="./book.php" class="nav-item"><img src="./image/book-icon.svg" alt="Книги"><span>Книги</span></a>
        <a href="./story.php" class="nav-item"><img src="./image/story-icon.svg" alt="История"><span>История</span></a>
        <a href="./index.php" class="nav-item logo-center"><img src="./image/logo.svg" alt="Логотип"></a>
        <a href="./shop.php" class="nav-item"><img src="./image/shop-icon.svg" alt="Магазин"><span>Магазин</span></a>
        <a href="./account.php" class="nav-item"><img src="./image/account-icon.svg" alt="Аккаунт"><span>Аккаунт</span></a>
    </div>

    <div class="bottom-nav">
        <a href="./book.php" class="nav-item"><img src="./image/book-icon.svg" alt="Книги"><span>Книги</span></a>
        <a href="./story.php" class="nav-item"><img src="./image/story-icon.svg" alt="История"><span>История</span></a>
        <a href="./index.php" class="nav-item logo-center"><img src="./image/logo.svg" alt="Логотип"></a>
        <a href="./shop.php" class="nav-item"><img src="./image/shop-icon.svg" alt="Магазин"><span>Магазин</span></a>
        <a href="./account.php" class="nav-item"><img src="./image/account-icon.svg" alt="Аккаунт"><span>Аккаунт</span></a>
    </div>

    <div class="product-container">
        <div class="product-image">
            <img src="<?= htmlspecialchars($product['image_url']) ?>" 
                 alt="<?= htmlspecialchars($product['name']) ?>">
        </div>
        
        <div class="product-info">
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            
            <div class="product-price">
                <span class="price"><?= number_format($product['price'], 0, '', ' ') ?> ₽</span>
            </div>

            <div class="product-description">
                <h2>Описание</h2>
                <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            </div>

            <form method="POST" class="add-to-cart-form">
                <input type="hidden" name="add_to_cart" value="1">
                <button type="submit" class="add-to-cart-btn">Добавить в корзину</button>
            </form>

            <a href="shop.php" class="back-to-shop">← Вернуться в магазин</a>
        </div>
    </div>

    <?php require './assets/footer.php'; ?>
    <div class="indent"></div>
</body>
</html> 