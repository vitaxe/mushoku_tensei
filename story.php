<?php
require 'db_functions.php'; // Подключение к БД

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
    <title>Истории</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_story.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/style_header.css"> 
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
                <li><a href="./story.php" class="active">История</a></li>
                <li><a href="./character.php">Персонажи</a></li>
                <li><a href="./gallerey.php">Галерея</a></li>
                <li><a href="./shop.php">Магазин</a></li>
                <li><a href="./book.php">Книги</a></li>
            </ul>
            <div class="account">
                <a href="./account.php"><img src="./image/account.svg" alt="account"></a>
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
            <h1>История</h1>
        </div>
    </section>

    <div class="carts">
        <?php
        // Получаем все серии из базы
        $result = $conn->query("SELECT * FROM stories ORDER BY id ASC");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $episodeNumber = htmlspecialchars($row['episode_number']);
                $videoUrl = htmlspecialchars($row['video_url']);

                echo '
                <section class="series-cart">
                    <iframe 
                        class="series-iframe"
                        src="' . $videoUrl . '"
                        width="640" 
                        height="360" 
                        frameborder="0" 
                        allowfullscreen 
                        allow="autoplay; encrypted-media; fullscreen; picture-in-picture">
                    </iframe>
                    <div class="series-info">
                        <h2 class="series-number">' . $episodeNumber . '</h2>
                    </div>
                </section>
                ';
            }
        } else {
            echo '<p style="color:#E4BB88; font-size:18px;">Серии пока не добавлены.</p>';
        }
        ?>
    </div>

    <?php require 'assets/footer.php'; ?>

    <div class="indent"></div>
</body>

</html>
