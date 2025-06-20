
<!-- session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = (int)$_POST['product_id'];

    if (isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$productId] = ['quantity' => 1];
    }
}

header('Location: shop.php');
exit; -->


<?php
session_start();
require_once 'config.php';

// Проверка, был ли отправлен ID товара
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];

    // Получение информации о товаре из базы данных
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Если товар найден, добавляем в корзину
    if ($product = $result->fetch_assoc()) {
        // Создаём массив корзины, если его ещё нет
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Если товар уже есть в корзине — увеличиваем количество
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'image_url' => $product['image_url'],
                'quantity' => 1
            ];
        }

        // Переход обратно в магазин
        header("Location: shop.php");
        exit;
    } else {
        echo "Товар не найден.";
    }

    $stmt->close();
} else {
    echo "Неверный запрос.";
}
