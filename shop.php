<?php
session_start();
require './config.php';

// Подсчет количества товаров в корзине
$cartItemsCount = 0;
$cartTotal = 0;
if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $item) {
        $cartItemsCount += $item['quantity'];
    }
}

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

$products = [];
if (mysqli_num_rows($result) > 0) {
    while ($product = mysqli_fetch_assoc($result)) {
        $products[] = $product;
    }
}

$hits = array_slice($products, 0, 3);
$others = array_slice($products, 3);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
        ym(99735202, "init", {
            clickmap:true,
            trackLinks:true,
            accurateTrackBounce:true,
            webvisor:true
        });
    </script>
    <noscript><div><img src="https://mc.yandex.ru/watch/99735202" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
    <!-- /Yandex.Metrika counter -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Магазин</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_shop.css">
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

    <section class="header_mini">
        <div class="img_header2">
            <h1>Магазин</h1>
        </div>
    </section>

    <section class="slider-container">
        <div class="slider">
            <div class="slides">
                <div class="slide"><img src="./image/merch1.jpg" alt="Мерч 1"></div>
                <div class="slide"><img src="./image/merch2.jpg" alt="Мерч 2"></div>
                <div class="slide"><img src="./image/merch3.jpg" alt="Мерч 3"></div>
            </div>
        </div>
    </section>

    <div class="hits-container">
        <h2 class="hits-title">Хиты продаж</h2>
        <div class="products">
            <?php foreach ($hits as $product): ?>
                <div class="product-item">
                    <a href="product.php?id=<?= $product['id'] ?>" class="product-link">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <p><?= htmlspecialchars($product['name']) ?></p>
                        <h1 class="price"><?= htmlspecialchars($product['price']) ?>р</h1>
                    </a>
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="buy-button">Купить</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php if (!empty($others)): ?>
        <div class="products">
            <?php foreach ($others as $product): ?>
                <div class="product-item">
                    <a href="product.php?id=<?= $product['id'] ?>" class="product-link">
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <p><?= htmlspecialchars($product['name']) ?></p>
                        <h1 class="price"><?= htmlspecialchars($product['price']) ?>р</h1>
                    </a>
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                        <button type="submit" class="buy-button">Купить</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php require 'assets/footer.php'; ?>

    <div class="cart-badge">
        <a href="cart.php" class="cart-icon">
            <img src="./image/path_to_cart_icon.svg" alt="Корзина">
            <?php if ($cartItemsCount > 0): ?>
                <span class="cart-count"><?= $cartItemsCount ?></span>
            <?php endif; ?>
        </a>
        <?php if ($cartItemsCount > 0): ?>
            <div class="cart-preview">
                <h3>Корзина (<?= $cartItemsCount ?>)</h3>
                <div class="cart-preview-items">
                    <?php
                    $cartItems = [];
                    if (!empty($_SESSION['cart'])) {
                        $ids = implode(',', array_map('intval', array_keys($_SESSION['cart'])));
                        $cartQuery = "SELECT * FROM products WHERE id IN ($ids)";
                        $cartResult = mysqli_query($conn, $cartQuery);
                        while ($item = mysqli_fetch_assoc($cartResult)) {
                            $quantity = $_SESSION['cart'][$item['id']]['quantity'];
                            $cartTotal += $item['price'] * $quantity;
                    ?>
                        <div class="preview-item">
                            <img src="<?= htmlspecialchars($item['image_url']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div class="preview-item-info">
                                <p class="preview-item-name"><?= htmlspecialchars($item['name']) ?></p>
                                <p class="preview-item-price"><?= $quantity ?> × <?= number_format($item['price'], 0, '', ' ') ?> ₽</p>
                            </div>
                        </div>
                    <?php
                        }
                    }
                    ?>
                </div>
                <div class="cart-preview-total">
                    <span>Итого:</span>
                    <span><?= number_format($cartTotal, 0, '', ' ') ?> ₽</span>
                </div>
                <a href="cart.php" class="view-cart-btn">Перейти в корзину</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="indent"></div>

    <script>
        let currentIndex = 0;
        const slides = document.querySelector('.slider');
        const totalSlides = document.querySelectorAll('.slide').length;

        function showNextSlide() {
            currentIndex++;
            if (currentIndex >= totalSlides) {
                currentIndex = 0;
            }
            slides.style.transform = `translateX(-${currentIndex * 100}%)`;
        }

        setInterval(showNextSlide, 5000);
    </script>
</body>
</html>