<?php

require_once 'config.php';

// Подключаемся к БД
function dbConnect()
{
    global $db_host, $db_name, $db_user, $db_pass, $db_charset;

    $dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset";

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die('Ошибка подключения к БД: ' . $e->getMessage());
    }
}

// Чтобы выбрать какие-то поля из таблицы
function dbSelect($sql, $params = [])
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

// Чтобы менять что-то (update, delete, create)
function dbQuery($sql, $params = [])
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
}

// Вставка данных в таблицу (например, для добавления новой книги)
function dbInsert($sql, $params = [])
{
    $pdo = dbConnect();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $pdo->lastInsertId(); // Возвращаем ID последней вставленной записи
}

function dbUpdate($sql, $params = []) {
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        return $stmt->execute($params);
    } catch (PDOException $e) {
        error_log("Database update error: " . $e->getMessage());
        return false;
    }
}
