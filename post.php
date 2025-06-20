<?php
session_start();
require_once 'db_functions.php';

$postId = $_GET['id'] ?? null;
if (!$postId) {
    header('Location: gallerey.php');
    exit;
}

// Получаем информацию о посте
$sql = "SELECT p.*, u.name as username, u.img_url as user_avatar 
        FROM posts p 
        JOIN users u ON p.user_id = u.id 
        WHERE p.id = :post_id";
$post = dbSelect($sql, [':post_id' => $postId]);

if (empty($post)) {
    header('Location: gallerey.php');
    exit;
}

$post = $post[0];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            for (var j = 0; j < document.scripts.length; j++) {
                if (document.scripts[j].src === r) {
                    return;
                }
            }
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(99735202, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/99735202" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр поста</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_gallerey.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
    <style>
        .post-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .post-image {
            width: 100%;
            max-height: 600px;
            object-fit: contain;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .post-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
        }

        .user-info {
            flex-grow: 1;
        }

        .username {
            font-size: 18px;
            font-weight: 500;
            margin: 0;
            color: #333;
        }

        .post-date {
            font-size: 14px;
            color: #666;
            margin: 5px 0 0 0;
        }

        .post-description {
            font-size: 16px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            white-space: pre-wrap;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            padding: 10px 20px;
            background-color: #f0f0f0;
            color: #333;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.2s;
        }

        .back-button:hover {
            background-color: #e0e0e0;
        }

        @media (max-width: 768px) {
            .post-container {
                margin: 20px;
                padding: 15px;
            }

            .post-image {
                max-height: 400px;
            }

            .username {
                font-size: 16px;
            }

            .post-description {
                font-size: 14px;
            }
        }

        .username-link {
            text-decoration: none;
            color: inherit;
            transition: color 0.2s;
        }

        .username-link:hover {
            color: #666;
        }
    </style>
</head>

<body>

    <div class="post-container">
        <a href="./gallerey.php" class="back-button">← Назад к галерее</a>
        
        <img src="<?= htmlspecialchars($post['image_url']) ?>" alt="post image" class="post-image">
        
        <div class="post-header">
            <img src="<?= htmlspecialchars($post['user_avatar'] ?: './image/default-avatar.jpg') ?>" 
                 alt="user avatar" 
                 class="user-avatar">
            <div class="user-info">
                <a href="<?= isset($_SESSION['user_id']) && $post['user_id'] == $_SESSION['user_id'] ? 'account.php' : 'user_profile.php?id=' . $post['user_id'] ?>" class="username-link">
                    <h2 class="username"><?= htmlspecialchars($post['username']) ?></h2>
                </a>
                <p class="post-date">
                    <?= date('d F Y в H:i', strtotime($post['created_at'])) ?>
                </p>
            </div>
        </div>
        
        <p class="post-description"><?= htmlspecialchars($post['description']) ?></p>
    </div>

    <?php require 'assets/footer.php' ?>
</body>

</html> 