<?php
session_start();
require_once 'db_functions.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$userId = $_SESSION['user_id'];
$description = $_POST['description'] ?? '';

// Проверка загруженного файла
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    echo json_encode(['error' => 'No image uploaded or upload error']);
    exit;
}

$file = $_FILES['image'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

if (!in_array($file['type'], $allowedTypes)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid file type. Only JPG, PNG and GIF are allowed']);
    exit;
}

// Создаем директорию для загрузок, если её нет
$uploadDir = 'uploads/posts/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Генерируем уникальное имя файла
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = uniqid() . '.' . $extension;
$filepath = $uploadDir . $filename;

// Перемещаем загруженный файл
if (!move_uploaded_file($file['tmp_name'], $filepath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to save image']);
    exit;
}

// Сохраняем информацию о посте в базу данных
try {
    $sql = "INSERT INTO posts (user_id, image_url, description) VALUES (:user_id, :image_url, :description)";
    $params = [
        ':user_id' => $userId,
        ':image_url' => $filepath,
        ':description' => $description
    ];
    
    dbInsert($sql, $params);
    
    echo json_encode([
        'success' => true,
        'message' => 'Post created successfully',
        'image_url' => $filepath
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    exit;
}
?> 