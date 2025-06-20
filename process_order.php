<?php
session_start();
require_once 'db_functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['cart'])) {
    $userId = $_SESSION['user_id'];
    
    // Проверяем наличие контактных данных
    if (empty($_POST['customer_name']) || empty($_POST['phone'])) {
        $_SESSION['error_message'] = 'Пожалуйста, заполните все контактные данные';
        header('Location: confirm_order.php');
        exit;
    }

    $customerName = trim($_POST['customer_name']);
    $phone = trim($_POST['phone']);

    // Валидация телефона
    if (!preg_match('/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $phone)) {
        $_SESSION['error_message'] = 'Пожалуйста, введите корректный номер телефона';
        header('Location: confirm_order.php');
        exit;
    }
    
    try {
        foreach ($_SESSION['cart'] as $productId => $item) {
            $sql = "INSERT INTO orders (user_id, product_id, quantity, customer_name, phone) 
                    VALUES (:user_id, :product_id, :quantity, :customer_name, :phone)";
            $params = [
                ':user_id' => $userId,
                ':product_id' => $productId,
                ':quantity' => $item['quantity'],
                ':customer_name' => $customerName,
                ':phone' => $phone
            ];
            
            dbQuery($sql, $params);
        }
        
        // Очищаем корзину после успешного оформления заказа
        unset($_SESSION['cart']);
        
        // Перенаправляем на страницу аккаунта с сообщением об успехе
        $_SESSION['success_message'] = 'Заказ успешно оформлен! Мы свяжемся с вами в ближайшее время.';
        header('Location: account.php');
        exit;
        
    } catch (Exception $e) {
        $_SESSION['error_message'] = 'Произошла ошибка при оформлении заказа. Пожалуйста, попробуйте позже.';
        header('Location: confirm_order.php');
        exit;
    }
} else {
    header('Location: cart.php');
    exit;
} 