<?php
session_start();
require_once 'db_functions.php';

// Получаем параметр сортировки
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_desc';

// Формируем SQL запрос в зависимости от выбранной сортировки
$sql = "SELECT p.*, u.name as username, u.img_url as user_avatar,
        (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as like_count
        FROM posts p 
        JOIN users u ON p.user_id = u.id";

switch ($sort) {
    case 'popular':
        $sql .= " ORDER BY like_count DESC, p.created_at DESC";
        break;
    case 'date_asc':
        $sql .= " ORDER BY p.created_at ASC";
        break;
    case 'date_desc':
    default:
        $sql .= " ORDER BY p.created_at DESC";
        break;
}

$posts = dbSelect($sql);

// Получаем лайки текущего пользователя если он авторизован
$user_likes = [];
if (isset($_SESSION['user_id'])) {
    $likes_sql = "SELECT post_id FROM likes WHERE user_id = ?";
    $user_likes_result = dbSelect($likes_sql, [$_SESSION['user_id']]);
    foreach ($user_likes_result as $like) {
        $user_likes[$like['post_id']] = true;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
    m[i].l=1*new Date();
    for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
    k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
 
    ym(99735202, "init", {
         clickmap:true,
         trackLinks:true,
         accurateTrackBounce:true,
         webvisor:true
    });
 </script>
 <noscript><div><img src="https://mc.yandex.ru/watch/99735202" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
 <!-- /Yandex.Metrika counter -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Галерея</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_gallerey.css">
    <link rel="stylesheet" href="./css/like_styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="./assets/style_header.css">
</head>

<body>
    <?php require 'assets/preloader.php'; ?>
    
    <header>
        <nav>
            <div class="logo">
                <a href="./index.php"><img src="./image/logo.svg" alt="logotip saita"></a>
            </div>
            <ul class="head">
                <li><a href="./index.php">Главная страница</a></li>
                <li><a href="./story.php">История</a></li>
                <li><a href="./character.php">Персонажи</a></li>
                <li><a href="./gallerey.php" class="active">Галерея</a></li>
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

    <section class="header_mini">
        <div class="img_header2">
            <h1>Галерея</h1>
        </div>
    </section>

    <div class="filter-container">
        <button class="filter-button <?= $sort === 'date_desc' ? 'active' : '' ?>" 
                onclick="window.location.href='?sort=date_desc'">
            Сначала новые
        </button>
        <button class="filter-button <?= $sort === 'date_asc' ? 'active' : '' ?>" 
                onclick="window.location.href='?sort=date_asc'">
            Сначала старые
        </button>
        <button class="filter-button <?= $sort === 'popular' ? 'active' : '' ?>" 
                onclick="window.location.href='?sort=popular'">
            По популярности
        </button>
    </div>

    <div class="carts">
        <?php if (empty($posts)): ?>
            <p class="no-posts">Пока нет опубликованных постов. Будьте первым!</p>
        <?php else: 
            foreach ($posts as $post): ?>
                <div class="series-cart">
                    <a href="post.php?id=<?= $post['id'] ?>" class="post-link">
                        <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="post image" class="series-image" />
                        <div class="series-info">
                            <div class="user-inf">
                                <img src="<?= htmlspecialchars($post['user_avatar'] ?: './image/default-avatar.jpg') ?>" 
                                     alt="user avatar" 
                                     class="default-avatar">
                                <h2 class="series-number"><?= htmlspecialchars($post['username']) ?></h2>
                            </div>
                            <p class="series-title"><?= htmlspecialchars($post['description']) ?></p>
                        </div>
                    </a>
                    <div class="interaction-bar">
                        <button class="like-button <?= isset($user_likes[$post['id']]) ? 'liked' : '' ?>" 
                                data-post-id="<?= $post['id'] ?>"
                                <?= !isset($_SESSION['user_id']) ? 'disabled title="Войдите, чтобы ставить лайки"' : '' ?>>
                            <svg class="heart-icon" viewBox="0 0 24 24">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="like-count"><?= $post['like_count'] ?? 0 ?></span>
                        </button>
                    </div>
                </div>
        <?php endforeach;
        endif; ?>
    </div>

    <?php require 'assets/footer.php' ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const likeButtons = document.querySelectorAll('.like-button');
            
            likeButtons.forEach(button => {
                if (!button.disabled) {
                    button.addEventListener('click', async function(e) {
                        e.preventDefault();
                        const postId = this.dataset.postId;
                        
                        try {
                            const response = await fetch('likes.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: `post_id=${postId}`
                            });
                            
                            const data = await response.json();
                            
                            if (data.success) {
                                // Обновляем количество лайков
                                this.querySelector('.like-count').textContent = data.likeCount;
                                
                                // Переключаем класс liked
                                if (data.action === 'liked') {
                                    this.classList.add('liked');
                                } else {
                                    this.classList.remove('liked');
                                }
                            } else {
                                alert(data.message || 'Произошла ошибка');
                            }
                        } catch (error) {
                            console.error('Error:', error);
                            alert('Произошла ошибка при обработке запроса');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>