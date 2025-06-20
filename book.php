<?php
require 'db_functions.php'; // Подключение к БД

$books = dbSelect("SELECT * FROM books");
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
    <title>Книги</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_book.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap" rel="stylesheet">
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
                <li><a href="./story.php">История</a></li>
                <li><a href="./character.php">Персонажи</a></li>
                <li><a href="./gallerey.php">Галерея</a></li>
                <li><a href="./shop.php">Магазин</a></li>
                <li><a href="./book.php" class="active">Книги</a></li>
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
            <h1>Книги</h1>
        </div>
    </section>

    <div class="books-container">
        <?php if (!empty($books)): ?>
            <?php foreach ($books as $book): ?>
                <div class="card">
                    <div class="image-container">
                        <img src="<?php echo htmlspecialchars($book['image_url']); ?>" alt="Обложка книги">
                    </div>
                    <div class="content">
                        <h2 class="title"><?php echo htmlspecialchars($book['title']); ?></h2>
                        <p class="description"><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                        <a href="<?php echo htmlspecialchars($book['link']); ?>" class="details-button">Читать</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Книг пока нет.</p>
        <?php endif; ?>
    </div>


    <footer>
        <div class="line">
        </div>
        <div class="logo-full">
            <a href="./index.php"> <img src="./image/logo-full.svg" class="logo-full"> </a>
        </div>
        <div class="peg-sou">
            <div class="sours">
                <img src="./image/vk.svg" class="sours-img">
                <img src="./image/tw.svg" class="sours-img">
                <img src="./image/tg.svg" class="sours-img">
            </div>
            <div class="pegi-info">
                <img src="./image/pegi1.svg" class="pegi1">
                <img src="./image/pegi2.svg" class="pegi2">
            </div>
        </div>
        <div class="panel">
            <p><a href="./index.php">Главная страница </a></p>
            <p><a href="./story.php">История </a></p>
            <p><a href="./character.php">Персонажи </a></p>
            <p><a href="./gallerey.php">Галерея </a></p>
            <p><a href="./shop.php">Магазин </a></p>
            <p><a href="./book.php">Книги </a></p>
        </div>
    </footer>

</body>

</html>