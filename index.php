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
    <title>Главная страница</title>
    <link rel="stylesheet" href="./fonts/fonts.css">
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500&family=Mak:wght@700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="assets/style_header.css"> 
        
    <meta name="description" content="Откройте для себя мир аниме Mushoku Tensei. 
    Узнайте все о персонажах, сюжете, рецензиях и последних новостях о популярном аниме-сериале. 
    Присоединяйтесь к обсуждениям и следите за новыми выпусками!">

</head>

<body>
    <?php require 'assets/preloader.php'; ?>

    <T123>
        <header>
            <nav>
                <div class="logo">
                    <a href="./index.php"><img src="./image/logo.svg" alt="logotip saita"></a>
                </div>
                <ul class="head">
                    <li><a href="./index.php" class="active">Главная страница</a></li>
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

        <section class="hero">
            <div class="img_fon">
                <img src="./image/log_full_widh.svg" class="log_full_widh" alt=class="log_full_widh" />
            </div>
            <div class="scroll-downs">
                <div class="field">
                    <div class="mouse"></div>
                </div>
            </div>
            <video autoplay muted loop alt="1image">
                <source src="./image/video23.mp4" />
            </video>
        </section>


        <section class="shopmin">
            <div class="shop">
                <div class="add1">
                    <a href="./shop.php">
                        <img src="./image/add1.svg" alt="leave" class="disk">
                    </a>
                </div>
                <div class="add2">
                    <a href="https://www.youtube.com/watch?v=kQ5Zfgpirwc">
                        <img src="./image/add2.svg" alt="leave" class="disk">
                    </a>
                </div>
            </div>
        </section>

        <section class="story">
            <div class="story-content">
                <h1>История</h1>
                <h2>Реинкарнация безработного: История о приключениях в другом мире</h2>
                <p>34-летний безработный спасает группу подростков от смерти под колёсами грузовика, однако погибает
                    сам. Он
                    перерождается в волшебном мире под именем Рудеус Грейрат. Сохранив знания и опыт, он клянется вести
                    полноценную жизнь и не повторять свои прошлые ошибки.</p>
                <p>Новые родители считают его, одаренного магической силой и разумом взрослого человека, гением, и
                    вскоре
                    Рудеус начинает учиться у могущественных воинов. Но, несмотря на его невинную внешность, парень
                    по-прежнему извращенный отаку, который мечтает наконец начать встречаться с девушкой.</p>
                <button class="details-btn">Подробнее</button>
            </div>
        </section>


        <section class="messag">
            <div class="mess-content">
                <h1>Рассылка</h1>
                <form id="newsletterForm" class="mass-all">
                    <div class="name">
                        <label>Имя</label>
                        <input type="text" id="userName" required>
                    </div>
                    <div class="mail">
                        <label>Электронная почта</label>
                        <input type="text" id="userEmail" required>
                    </div>
                    <div class="check-all">
                        <input type="checkbox" class="check-box" id="consent" required>
                        <label for="consent">Разрешение на маркетинг: Я даю свое согласие на то,
                            чтобы со мной связывались по электронной почте,
                            используя информацию, которую я предоставил в этой форме,
                            для новостей, обновлений и маркетинга. </label>
                    </div>
                    <button type="submit" class="seend">Отправить</button>
                </form>
            </div>
        </section>

        <!-- Popup -->
        <div id="popup" class="popup">
            <div class="popup-content">
                <h3>Спасибо за подписку!</h3>
                <p>Рассылка будет приходить на почту: <span id="subscribedEmail"></span></p>
                <button onclick="closePopup()" class="popup-close">✕</button>
            </div>
        </div>
        
        <?php
            require 'assets/footer.php'
        ?>

    </T123>

    <script>
        function toggleSidebar() {
            var sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('open');
        }
    </script>
    
    <script src="./js/smoothScroll.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/smoothscroll/1.4.10/SmoothScroll.min.js"
        integrity="sha256-huW7yWl7tNfP7lGk46XE+Sp0nCotjzYodhVKlwaNeco=" crossorigin="anonymous"></script>

    <script>
        SmoothScroll({
            // Время скролла 400 = 0.4 секунды
            animationTime: 800,
            // Размер шага в пикселях 
            stepSize: 75,

            // Дополнительные настройки:

            // Ускорение 
            accelerationDelta: 30,
            // Максимальное ускорение
            accelerationMax: 2,

            // Поддержка клавиатуры
            keyboardSupport: true,
            // Шаг скролла стрелками на клавиатуре в пикселях
            arrowScroll: 50,

            // Pulse (less tweakable)
            // ratio of "tail" to "acceleration"
            pulseAlgorithm: true,
            pulseScale: 4,
            pulseNormalize: 1,

            // Поддержка тачпада
            touchpadSupport: true,
        })
    </script>

    <script src="./js/load.js"></script>

    <!-- Newsletter Form Script -->
    <script>
        document.getElementById('newsletterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('userEmail').value;
            const name = document.getElementById('userName').value;
            
            // Display the email in the popup
            document.getElementById('subscribedEmail').textContent = email;
            
            // Show the popup
            document.getElementById('popup').classList.add('show');
            
            // Reset the form
            this.reset();
        });

        function closePopup() {
            document.getElementById('popup').classList.remove('show');
        }
    </script>

    <script>
        function showPopup(email) {
            document.getElementById('subscribedEmail').textContent = email;
            document.getElementById('popup').style.display = 'block';
            setTimeout(() => {
                closePopup();
            }, 5000); // Закрыть через 5 секунд
        }

        function closePopup() {
            const popup = document.getElementById('popup');
            popup.style.opacity = '0';
            popup.style.transform = 'translateY(100%)';
            setTimeout(() => {
                popup.style.display = 'none';
                popup.style.opacity = '1';
                popup.style.transform = 'translateY(0)';
            }, 300);
        }
    </script>
</body>

</html>