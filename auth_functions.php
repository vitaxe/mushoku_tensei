<?php
require_once 'db_functions.php';

function registerUser($email, $name, $password, $repeat_password)
{
    $result = ['success' => false, 'message' => ''];

    if (empty($email) || empty($name) || empty($password) || empty($repeat_password)) {
        $result['message'] = "Пожалуйста, заполните все поля.";
        return $result;
    }

    if ($password !== $repeat_password) {
        $result['message'] = "Пароли не совпадают!";
        return $result;
    }

    $sqlCheck = "SELECT id FROM users WHERE email = :email LIMIT 1";
    $existing = dbSelect($sqlCheck, [':email' => $email]);
    if (!empty($existing)) {
        $result['message'] = "Пользователь с таким email уже зарегистрирован.";
        return $result;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $sqlInsert = "INSERT INTO users (email, name, password) VALUES (:email, :name, :pass)";
    $rowCount = dbQuery($sqlInsert, [
        ':email' => $email,
        ':name' => $name,
        ':pass'  => $passwordHash
    ]);

    if ($rowCount > 0) {
        $result['success'] = true;
        $result['message'] = "Регистрация прошла успешно!";
    } else {
        $result['message'] = "Ошибка при записи в БД. Попробуйте позже.";
    }

    return $result;
}

function loginUser($email, $password)
{
    $result = ['success' => false, 'message' => ''];

    if (empty($email) || empty($password)) {
        $result['message'] = "Пожалуйста, заполните все поля.";
        return $result;
    }

    $sql = "SELECT id, password FROM users WHERE email = :email LIMIT 1";
    $rows = dbSelect($sql, [':email' => $email]);

    if (empty($rows)) {
        $result['message'] = "Неверный email или пароль.";
        return $result;
    }

    $user = $rows[0];
    $hashedPassword = $user['password'];

    if (!password_verify($password, $hashedPassword)) {
        $result['message'] = "Неверный email или пароль.";
        return $result;
    }

    $result['success'] = true;
    $result['message'] = "Вы успешно вошли!";

    $result['user_id'] = $user['id'];

    return $result;
}
