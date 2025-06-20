<?php
session_start();

require_once 'auth_functions.php';
require_once 'db_functions.php';

$errorMessage   = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $loginResult = loginUser($email, $password);
    if ($loginResult['success']) {
        $_SESSION['user_id'] = $loginResult['user_id'];
        header("Location: account.php");
        exit;
    } else {
        $errorMessage = $loginResult['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <link rel="stylesheet" href="./css/style_auth.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./fonts/fonts.css">
</head>


<body>
    <div class="container">
        <div class="logo-full">
            <a href="./index.php"> <img src="./image/logo-full.svg" class="logo-full"> </a>
        </div>

        <!-- Навигация вкладок -->
        <div class="tabs">
            <div class="tab" id="login-tab" onclick="switchTab('login')">Вход</div>
            <div class="tab" id="register-tab" onclick="switchTab('register')">Регистрация</div>
            <div class="tab-indicator" id="tab-indicator"></div>
        </div>

        <!-- Форма входа -->
        <form method="post" action="login.php" class="form-container">
            <div class="form-group">
                <input type="email" name="email" id="login-email" placeholder="Email или никнейм">
            </div>
            <div class="form-group">
                <input type="password" name="password" id="login-password" placeholder="Пароль">
            </div>
            <button type="submit">Войти</button>
        </form>
    </div>

    <script>
        function switchTab(tab) {
            const tabIndicator = document.getElementById('tab-indicator');
            if (tab === 'login') {
                tabIndicator.style.transform = 'translateX(0)';
            } else if (tab === 'register') {
                tabIndicator.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    window.location.href = 'register.php';
                }, 300);
            }
        }

        // Установка полоски по умолчанию
        document.addEventListener('DOMContentLoaded', () => {
            const tabIndicator = document.getElementById('tab-indicator');
            tabIndicator.style.transform = 'translateX(0)'; // Полоска под "Вход"
        });

        // Эффект фона
        document.addEventListener('mousemove', (e) => {
            const {
                clientX: x,
                clientY: y
            } = e;
            const width = window.innerWidth;
            const height = window.innerHeight;

            const xPercent = (x / width) * 100;
            const yPercent = (y / height) * 100;

            const background = document.getElementById('background');
            background.style.background = `linear-gradient(120deg, hsl(${xPercent}, 70%, 60%), hsl(${yPercent}, 70%, 60%))`;
        });
    </script>
</body>

</html>