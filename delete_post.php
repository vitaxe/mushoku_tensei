<?php
session_start();
require_once 'db_functions.php';

// Проверка авторизации
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// Получение ID поста
$postId = $_POST['post_id'] ?? null;
if (!$postId) {
    http_response_code(400);
    echo json_encode(['error' => 'Post ID is required']);
    exit;
}

try {
    // Проверяем, принадлежит ли пост пользователю
    $sql = "SELECT image_url FROM posts WHERE id = :post_id AND user_id = :user_id";
    $params = [
        ':post_id' => $postId,
        ':user_id' => $_SESSION['user_id']
    ];
    
    $post = dbSelect($sql, $params);
    
    if (empty($post)) {
        http_response_code(403);
        echo json_encode(['error' => 'You can only delete your own posts']);
        exit;
    }

    // Удаляем файл изображения
    $imageUrl = $post[0]['image_url'];
    if (file_exists($imageUrl)) {
        unlink($imageUrl);
    }

    // Удаляем запись из базы данных
    $sql = "DELETE FROM posts WHERE id = :post_id AND user_id = :user_id";
    dbQuery($sql, $params);
    
    echo json_encode([
        'success' => true,
        'message' => 'Post deleted successfully'
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to delete post: ' . $e->getMessage()]);
    exit;
} 