<?php
// Конфигурация для подключения к базе данных
$db_host = 'localhost';
$db_name = 'db_anime';
$db_user = 'root';
$db_pass = '';
$db_charset = 'utf8';

// Создание соединения с базой данных
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Проверка соединения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Установка кодировки
$conn->set_charset($db_charset);
?>
