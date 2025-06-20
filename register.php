<?php

require_once 'auth_functions.php';
require_once 'db_functions.php';

$successMessage = "";
$errorMessage   = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $password = trim($_POST['pass'] ?? '');
    $repeat_password = trim($_POST['repeat_password'] ?? '');

    $result = registerUser($email, $name, $password, $repeat_password);

    if ($result['success']) {
        $successMessage = $result['message'];
        header("Location: login.php");
    } else {
        $errorMessage = $result['message'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="./css/style_auth.css">
</head>

<body>
    <div class="container">
        <a href="index.php" class="close-btn">&times;</a>
        <div class="logo-full">
            <a href="./index.html"> <img src="./image/logo-full.svg" class="logo-full"> </a>
        </div>

        <!-- Навигация вкладок -->
        <div class="tabs">
            <div class="tab" id="login-tab" onclick="switchTab('login')">Вход</div>
            <div class="tab" id="register-tab" onclick="switchTab('register')">Регистрация</div>
            <div class="tab-indicator" id="tab-indicator"></div>
        </div>

        <?php if ($errorMessage): ?>
            <div class="system-message error">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>

        <!-- Форма регистрации -->
        <form method="post" action="register.php" class="form-container" id="registerForm" novalidate>
            <div class="form-group">
                <input type="text" 
                       name="name" 
                       id="register-login" 
                       placeholder="Логин"
                       required
                       minlength="3"
                       maxlength="30"
                       pattern="[a-zA-Zа-яА-Я0-9_-]+">
                <div class="error-message">Логин должен содержать от 3 до 30 символов</div>
            </div>
            <div class="form-group">
                <input type="email" 
                       name="email" 
                       id="register-email" 
                       placeholder="Email"
                       required>
                <div class="error-message">Введите корректный email адрес</div>
            </div>
            <div class="form-group">
                <input type="password" 
                       name="pass" 
                       id="register-password" 
                       placeholder="Пароль"
                       required
                       minlength="6">
                <div class="error-message">Пароль должен содержать минимум 6 символов</div>
            </div>
            <div class="form-group">
                <input type="password" 
                       name="repeat_password" 
                       id="confirm-password" 
                       placeholder="Подтвердите пароль"
                       required>
                <div class="error-message">Пароли не совпадают</div>
            </div>
            <button type="submit">Зарегистрироваться</button>
        </form>
    </div>

    <script>
        function switchTab(tab) {
            const tabIndicator = document.getElementById('tab-indicator');
            if (tab === 'login') {
                tabIndicator.style.transform = 'translateX(0)';
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 300);
            } else if (tab === 'register') {
                tabIndicator.style.transform = 'translateX(100%)';
            }
        }

        // Установка полоски по умолчанию
        document.addEventListener('DOMContentLoaded', () => {
            const tabIndicator = document.getElementById('tab-indicator');
            tabIndicator.style.transform = 'translateX(100%)'; // Полоска под "Регистрация"

            // Инициализация валидации формы
            const form = document.getElementById('registerForm');
            const loginInput = document.getElementById('register-login');
            const emailInput = document.getElementById('register-email');
            const passwordInput = document.getElementById('register-password');
            const confirmPasswordInput = document.getElementById('confirm-password');

            // Функция валидации поля
            function validateField(input, validationFunction) {
                const formGroup = input.parentElement;
                const isValid = validationFunction(input);
                
                if (isValid) {
                    formGroup.classList.remove('error');
                    formGroup.classList.add('success');
                } else {
                    formGroup.classList.remove('success');
                    formGroup.classList.add('error');
                }
                
                return isValid;
            }

            // Валидация логина
            loginInput.addEventListener('input', () => {
                validateField(loginInput, (input) => {
                    const value = input.value.trim();
                    return value.length >= 3 && value.length <= 30 && /^[a-zA-Zа-яА-Я0-9_-]+$/.test(value);
                });
            });

            // Валидация email
            emailInput.addEventListener('input', () => {
                validateField(emailInput, (input) => {
                    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value.trim());
                });
            });

            // Валидация пароля
            passwordInput.addEventListener('input', () => {
                validateField(passwordInput, (input) => {
                    return input.value.length >= 6;
                });
                // Перепроверяем подтверждение пароля
                if (confirmPasswordInput.value) {
                    validateField(confirmPasswordInput, (input) => {
                        return input.value === passwordInput.value;
                    });
                }
            });

            // Валидация подтверждения пароля
            confirmPasswordInput.addEventListener('input', () => {
                validateField(confirmPasswordInput, (input) => {
                    return input.value === passwordInput.value;
                });
            });

            // Валидация формы при отправке
            form.addEventListener('submit', (e) => {
                e.preventDefault();

                const isLoginValid = validateField(loginInput, (input) => {
                    const value = input.value.trim();
                    return value.length >= 3 && value.length <= 30 && /^[a-zA-Zа-яА-Я0-9_-]+$/.test(value);
                });

                const isEmailValid = validateField(emailInput, (input) => {
                    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value.trim());
                });

                const isPasswordValid = validateField(passwordInput, (input) => {
                    return input.value.length >= 6;
                });

                const isConfirmPasswordValid = validateField(confirmPasswordInput, (input) => {
                    return input.value === passwordInput.value;
                });

                if (isLoginValid && isEmailValid && isPasswordValid && isConfirmPasswordValid) {
                    form.submit();
                }
            });
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