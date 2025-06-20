<?php
session_start();
require_once 'db_functions.php';

$userId = $_GET['id'] ?? null;

// Если пользователь авторизован и пытается посмотреть свой профиль,
// перенаправляем его на account.php
if (isset($_SESSION['user_id']) && $userId == $_SESSION['user_id']) {
    header('Location: account.php');
    exit;
}

// Если ID не указан, перенаправляем на галерею
if (!$userId) {
    header('Location: gallerey.php');
    exit;
}

// Получаем информацию о пользователе
$sql = "SELECT id, name, img_url, description, created_at, email, role FROM users WHERE id = :user_id";
$user = dbSelect($sql, [':user_id' => $userId]);

if (empty($user)) {
    header('Location: gallerey.php');
    exit;
}

$user = $user[0];
$isOwnProfile = false; // Всегда false, так как свой профиль теперь открывается в account.php

// Получаем все посты пользователя
$sql = "SELECT p.*, u.name as username, u.img_url as user_avatar 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.user_id = :user_id 
        ORDER BY p.created_at DESC";
$posts = dbSelect($sql, [':user_id' => $userId]);

// Получаем историю заказов пользователя (только для своего профиля)
$orders = [];
if ($isOwnProfile) {
    $ordersSql = "SELECT o.*, p.name as product_name, p.price, p.image_url 
                  FROM orders o 
                  JOIN products p ON o.product_id = p.id 
                  WHERE o.user_id = :user_id 
                  ORDER BY o.order_date DESC";
    $orders = dbSelect($ordersSql, [':user_id' => $userId]);

    // Группируем заказы по дате
    $groupedOrders = [];
    foreach ($orders as $order) {
        $date = date('Y-m-d', strtotime($order['order_date']));
        if (!isset($groupedOrders[$date])) {
            $groupedOrders[$date] = [];
        }
        $groupedOrders[$date][] = $order;
    }
}
?>
<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isOwnProfile ? 'Личный кабинет' : 'Профиль ' . htmlspecialchars($user['name']) ?></title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_account.css">
    <link rel="stylesheet" href="./assets/style_header.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <nav>
            <div class="logo">
                <a href="./index.php"><img src="./image/logo.svg" alt="логотип сайта"></a>
            </div>
            <ul class="head">
                <li><a href="./index.php">Главная страница</a></li>
                <li><a href="./story.php">История</a></li>
                <li><a href="./character.php">Персонажи</a></li>
                <li><a href="./gallerey.php">Галерея</a></li>
                <li><a href="./shop.php">Магазин</a></li>
                <li><a href="./book.php">Книги</a></li>
            </ul>
            <div class="account">
                <a href="./account.php"><img src="./image/account.svg" alt="аккаунт"></a>
            </div>
        </nav>
    </header>

    <div class="bottom-nav">
        <a href="./book.php" class="nav-item">
            <img src="./image/book-icon.svg" alt="Книги">
            <span>Книги</span>
        </a>
        <a href="./story.php" class="nav-item">
            <img src="./image/story-icon.svg" alt="История">
            <span>История</span>
        </a>
        <a href="./index.php" class="nav-item logo-center">
            <img src="./image/logo.svg" alt="Логотип">
        </a>
        <a href="./shop.php" class="nav-item">
            <img src="./image/shop-icon.svg" alt="Магазин">
            <span>Магазин</span>
        </a>
        <a href="./account.php" class="nav-item">
            <img src="./image/account-icon.svg" alt="Аккаунт">
            <span>Аккаунт</span>
        </a>
    </div>

    <main class="account-page">
        <section class="profile">
            <div class="profile-background" id="current-background"></div>
            <div class="profile-header">
                <img src="<?= htmlspecialchars($user['img_url'] ?: './image/default-avatar.jpg') ?>" 
                     alt="Аватар пользователя" 
                     class="profile-avatar" 
                     id="current-avatar">
                <h1 id="username-display"><?= htmlspecialchars($user['name']) ?></h1>
            </div>
            <div class="profile-details">
                <?php if ($isOwnProfile): ?>
                    <p><strong>Email: </strong> <?= htmlspecialchars($user['email']) ?></p>
                <?php endif; ?>
                <p><strong>Дата регистрации: </strong> <?= explode(" ", htmlspecialchars($user['created_at']))[0] ?></p>
                <p><strong>Описание: </strong> <span id="user-description"><?= htmlspecialchars($user['description'] ?? "") ?></span></p>
            </div>
            <?php if ($isOwnProfile): ?>
                <div class="profile-actions">
                    <a href="editing.php"><button class="edit-btn">Редактировать профиль</button></a>
                    <button class="logout-btn" onclick="logout()">Выйти</button>
                    
                    <?php if ($user['role'] === 'admin'): ?>
                        <a href="admin_panel.php"><button class="edit-btn">Панель администратора</button></a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- Раздел Мои посты -->
        <section class="my-posts">
            <h2><?= $isOwnProfile ? 'Мои посты' : 'Посты пользователя' ?></h2>
            
            <?php if ($isOwnProfile): ?>
                <!-- Форма создания поста -->
                <div class="create-post-form" id="createPostForm" style="display: none;">
                    <form action="upload_post.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="postImage">Изображение:</label>
                            <input type="file" id="postImage" name="image" accept="image/*" required>
                            <div id="imagePreview"></div>
                        </div>
                        <div class="form-group">
                            <label for="postDescription">Описание:</label>
                            <textarea id="postDescription" name="description" rows="4"></textarea>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="submit-post">Опубликовать</button>
                            <button type="button" class="cancel-post" onclick="togglePostForm()">Отмена</button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <!-- Список постов пользователя -->
            <div class="posts-list" id="posts-list">
                <?php if (empty($posts)): ?>
                    <p><?= $isOwnProfile ? 'У вас пока нет постов.' : 'У пользователя пока нет постов.' ?></p>
                <?php else: 
                    foreach ($posts as $post): ?>
                        <div class="post-item" data-post-id="<?= $post['id'] ?>">
                            <div class="post-content">
                                <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="Пост" class="post-image">
                                <div class="post-info">
                                    <p class="post-description"><?= htmlspecialchars($post['description']) ?></p>
                                    <div class="post-footer">
                                        <span class="post-date"><?= date('d.m.Y H:i', strtotime($post['created_at'])) ?></span>
                                        <?php if ($isOwnProfile): ?>
                                            <button class="delete-post-btn" onclick="deletePost(<?= $post['id'] ?>)">
                                                <img src="./image/delete-icon.svg" alt="Удалить" class="delete-icon">
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php endforeach;
                endif; ?>
            </div>
            <?php if ($isOwnProfile): ?>
                <button class="add-post-btn" onclick="togglePostForm()">Добавить новый пост</button>
            <?php endif; ?>
        </section>

        <?php if ($isOwnProfile): ?>
            <!-- Раздел История покупок (только для своего профиля) -->
            <section class="my-posts">
                <h2>История покупок</h2>
                <?php if (empty($groupedOrders)): ?>
                    <div class="empty-history">
                        <p>У вас пока нет покупок</p>
                        <a href="shop.php" class="shop-link">Перейти в магазин</a>
                    </div>
                <?php else: ?>
                    <?php foreach ($groupedOrders as $date => $dayOrders): ?>
                        <div class="order-group">
                            <h3 class="order-date"><?= date('d.m.Y', strtotime($date)) ?></h3>
                            <div class="orders-list">
                                <?php foreach ($dayOrders as $order): ?>
                                    <div class="order-item">
                                        <img src="<?= htmlspecialchars($order['image_url']) ?>" 
                                             alt="<?= htmlspecialchars($order['product_name']) ?>" 
                                             class="order-image">
                                        <div class="order-details">
                                            <h4><?= htmlspecialchars($order['product_name']) ?></h4>
                                            <p class="order-quantity">Количество: <?= $order['quantity'] ?></p>
                                            <p class="order-price">
                                                <?= number_format($order['price'] * $order['quantity'], 0, '', ' ') ?> ₽
                                            </p>
                                        </div>
                                        <div class="order-status">
                                            <span class="status-badge <?= $order['status'] ?>">
                                                <?= $order['status'] === 'completed' ? 'Доставлен' : 
                                                   ($order['status'] === 'processing' ? 'В обработке' : 
                                                   ($order['status'] === 'shipped' ? 'Отправлен' : 'В пути')) ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        <?php endif; ?>
    </main>

    <?php require 'assets/footer.php' ?>

    <script>
        const logout = () => document.location = 'logout.php';
        
        // Функция переключения формы создания поста
        const togglePostForm = () => {
            const form = document.getElementById('createPostForm');
            const postsList = document.getElementById('posts-list');
            if (form.style.display === 'none') {
                form.style.display = 'block';
                postsList.style.display = 'none';
            } else {
                form.style.display = 'none';
                postsList.style.display = 'block';
            }
        };

        // Функция удаления поста
        const deletePost = async (postId) => {
            if (!confirm('Вы уверены, что хотите удалить этот пост?')) {
                return;
            }

            try {
                const formData = new FormData();
                formData.append('post_id', postId);

                const response = await fetch('delete_post.php', {
                    method: 'POST',
                    body: formData
                });

                const result = await response.json();

                if (result.success) {
                    // Удаляем пост из DOM
                    const postElement = document.querySelector(`[data-post-id="${postId}"]`);
                    if (postElement) {
                        postElement.remove();
                    }
                } else {
                    alert('Ошибка при удалении поста');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Произошла ошибка при удалении поста');
            }
        };

        // Предварительный просмотр изображения
        document.getElementById('postImage')?.addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            const file = e.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; margin-top: 10px;">`;
                }
                reader.readAsDataURL(file);
            } else {
                preview.innerHTML = '';
            }
        });
    </script>
</body>
</html> 