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
    <title>Персонажи</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style_character.css">
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
                <li><a href="./character.php" class="active">Персонажи</a></li>
                <li><a href="./gallerey.php">Галерея</a></li>
                <li><a href="./shop.php">Магазин</a></li>
                <li><a href="./book.php">Книги</a></li>
            </ul>
            <div class="account">
                <a href="./account.php"><img src="./image/account.svg" alt="аккаунт"></a>
            </div>
        </nav>
    </header>

    <div class="sidebar">
        <!-- <a href="#all_character"><img src="./image/character1.jpg" alt="character all"></a> -->
        <a href="#character1"><img src="./image/character1.jpg" alt="character 1"></a>
        <a href="#character2"><img src="./image/character2.jpg" alt="Character 2"></a>
        <a href="#character3"><img src="./image/character3.jpg" alt="Character 3"></a>
        <a href="#character4"><img src="./image/character4.jpg" alt="Character 4"></a>
    </div>

    <div class="all">
        <section id="all_character" class="character">
            <img src="./image/all_character.png" alt="Character 1">
        </section>

        <section id="character1" class="character">
            <img src="./image/1.png" alt="Character 1">
        </section>

        <section id="character2" class="character">
            <img src="./image/2.png" alt="Character 1">
        </section>

        <section id="character3" class="character">
            <img src="./image/3.png" alt="Character 1">
        </section>

        <section id="character4" class="character">
            <img src="./image/4.png" alt="Character 1">
        </section>
    </div>
</body>

</html>