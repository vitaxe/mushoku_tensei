<?php
session_start();
require_once 'db_functions.php';

header('Content-Type: application/json');

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Необходимо войти в систему']);
    exit;
}

// Обработка POST-запроса для переключения лайка
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    $user_id = $_SESSION['user_id'];

    if (!$post_id) {
        echo json_encode(['success' => false, 'message' => 'Неверный ID поста']);
        exit;
    }

    // Проверяем, лайкнул ли уже пользователь этот пост
    $checkSql = "SELECT id FROM likes WHERE user_id = ? AND post_id = ?";
    $existing_like = dbSelect($checkSql, [$user_id, $post_id]);

    if (!empty($existing_like)) {
        // Убираем лайк
        $sql = "DELETE FROM likes WHERE user_id = ? AND post_id = ?";
        $success = dbQuery($sql, [$user_id, $post_id]);
        $action = 'unliked';
    } else {
        // Ставим лайк
        $sql = "INSERT INTO likes (user_id, post_id) VALUES (?, ?)";
        $success = dbQuery($sql, [$user_id, $post_id]);
        $action = 'liked';
    }

    // Получаем обновленное количество лайков
    $countSql = "SELECT COUNT(*) as count FROM likes WHERE post_id = ?";
    $result = dbSelect($countSql, [$post_id]);
    $likeCount = $result[0]['count'];

    echo json_encode([
        'success' => true,
        'action' => $action,
        'likeCount' => $likeCount
    ]);
    exit;
} 