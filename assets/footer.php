    <footer>
        <div class="line">
        </div>
        <div class="logo-full">
            <a href="./index.html"> <img src="./image/logo-full.svg" class="logo-full"> </a>
        </div>
        <div class="peg-sou">
            <div class="sours">
                <a href="https://vk.com" target="_blank" class="social-link">
                    <img src="./image/vk.svg" class="sours-img" alt="VK">
                </a>
                <a href="https://twitter.com" target="_blank" class="social-link">
                    <img src="./image/tw.svg" class="sours-img" alt="Twitter">
                </a>
                <a href="https://t.me" target="_blank" class="social-link">
                    <img src="./image/tg.svg" class="sours-img" alt="Telegram">
                </a>
            </div>
            <div class="pegi-info">
                <img src="./image/pegi1.svg" class="pegi1">
                <img src="./image/pegi2.svg" class="pegi2">
            </div>
        </div>
        <div class="panel">
            <p><a href="./index.html">Главная страница </a></p>
            <p><a href="./story.php">История </a></p>
            <p><a href="./character.html">Персонажи </a></p>
            <p><a href="./gallerey.html">Галерея </a></p>
            <p><a href="./shop.html">Магазин </a></p>
            <p><a href="./book.php">Книги </a></p>
        </div>
    </footer>

<style>
.sours {
    display: flex;
    gap: 15px;
    padding-bottom: 10px;
}

.social-link {
    display: inline-block;
    transition: transform 0.3s ease;
}

.social-link:hover {
    transform: scale(1.1);
}

.sours-img {
    width: 24px;
    height: 24px;
    transition: filter 0.3s ease;
}

.social-link:hover .sours-img {
    filter: brightness(1.2);
}
</style>