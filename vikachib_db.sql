-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 20 2025 г., 13:49
-- Версия сервера: 8.0.34-26-beget-1-1
-- Версия PHP: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `vikachib_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `books`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books` (
  `id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `books`
--

INSERT INTO `books` (`id`, `title`, `description`, `image_url`, `link`) VALUES
(1, '1 том', 'Рассказывает о человеке, который, умерший в возрасте 34 лет, перерождается в фантастическом мире. Он решает начать новую жизнь, полную возможностей, избавившись от своей прежней беспомощности. В новой жизни он становится Рудиусом Грейратом — младенцем с памятью о предыдущей жизни. Обладая умом и знаниями, которые он накопил в прошлом, Рудиус решает воспользоваться шансом, чтобы стать лучшим человеком и освоить магию, которая существует в этом мире. Том знакомит с его первыми шагами в этом мире, его стремлением к саморазвитию и открытию новых горизонтов.', 'https://sun9-6.userapi.com/impg/c857424/v857424040/4fe9f/tMCIyk0lQ_A.jpg?size=1118x1600&quality=96&sign=fc07f562e0e34408bb9bbc2ff984c7d8&type=album', 'https://xn--80ac9aeh6f.xn--p1ai/reinkarnaciya-bezrabotnogo-istoriya-o-priklyucheniyah-v-drugom-mire/tom-1-glava-0'),
(3, '2 том', 'Продолжает адаптироваться к жизни в новом мире. Он активно изучает магию, обучается у мастеров и становится всё более уверенным в своих силах. В этот период Рудиус встречает новых персонажей, включая свою учительницу, Эрис, а также сталкивается с различными трудностями и опасностями, которые испытывают его на прочность. Книга также раскрывает больше деталей о его прошлом, о сложных отношениях с родителями и друзьями, а также о его стремлении создать свой собственный путь в жизни, несмотря на его прежние ошибки. Второй том углубляет эмоциональную сторону истории и продолжает исследовать тему роста и самопознания.', 'https://sun9-66.userapi.com/impg/c857424/v857424040/4fea9/fBhkQNv_OiU.jpg?size=1121x1600&quality=96&sign=cbc8607258c3ac9b92e8a13fec6d793c&type=album', 'https://xn--80ac9aeh6f.xn--p1ai/reinkarnaciya-bezrabotnogo-istoriya-o-priklyucheniyah-v-drugom-mire/tom-2-glava-1'),
(4, '3 том', 'В третьем томе «Реинкарнация безработного» главный герой Рудеус Грейрат продолжает своё развитие как маг и наставник. Он сталкивается с новыми вызовами, включая обучение молодых магов и участие в политических интригах.\r\nТом раскрывает его внутренние конфликты и новые способности, а также углубляет отношения с друзьями и семьёй. Рудеус стремится защитить мир от надвигающихся угроз и укрепить своё влияние в магическом сообществе.', 'https://sun9-56.userapi.com/impg/c857424/v857424040/4feb2/SfDZqIgVR9k.jpg?size=721x1024&quality=96&sign=a059819e227c69bfacd5d9234369d6e4&type=album', 'https://xn--80ac9aeh6f.xn--p1ai/reinkarnaciya-bezrabotnogo-istoriya-o-priklyucheniyah-v-drugom-mire/tom-3-glava-1'),
(5, '4 том', 'В четвёртом томе «Реинкарнация безработного» главный герой, Рудеус Грейрат, продолжает своё путешествие по новому миру. Он сталкивается с новыми вызовами и врагами, включая таинственные организации и могущественных противников.\r\nРудеус развивает свои способности, учится новым навыкам и стремится защитить своих близких. В томе раскрываются его внутренние конфликты и новые романтические линии, углубляющие его отношения с окружающими.\r\nСюжет включает в себя элементы приключений, магии и политических интриг, сохраняя динамику и напряжённость повествования.', 'https://sun9-65.userapi.com/impg/c857424/v857424040/4febb/CCWJl2s7I40.jpg?size=700x995&quality=96&sign=b3233abbe7460dd6934d7bd651fb3328&type=album', 'https://ranobes.com/chapters/reincarnation-of-the-unemployed/84741-tom-4-nachalnye-illjustracii.html'),
(6, '5 том', 'В пятом томе «Реинкарнация безработного» главный герой, Рудеус Грейрат, продолжает своё путешествие по миру, сталкиваясь с новыми вызовами и врагами. Он стремится укрепить свои позиции и защитить близких, используя свои знания и навыки, приобретённые в прошлой жизни.\r\nВ этом томе раскрываются новые аспекты его характера и способностей, а также углубляются отношения с друзьями и союзниками. Рудеус сталкивается с интригами и заговорами, раскрывая тайны, которые могут изменить его судьбу и повлиять на будущее мира.\r\nТом полон напряжённых сражений, политических интриг и личных открытий, которые держат читателя в напряжении до самого конца.', 'https://sun9-66.userapi.com/impg/c857424/v857424040/4fec5/dyHOTJ2KDgc.jpg?size=1512x2151&quality=96&sign=660fdec38f4365e200b92ba7ad2b125a&type=album', 'https://ranobes.com/chapters/reincarnation-of-the-unemployed/84753-tom-5-nachalnye-illjustracii.html');

-- --------------------------------------------------------

--
-- Структура таблицы `gallery_posts`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `gallery_posts`;
CREATE TABLE `gallery_posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `gallery_posts`
--

INSERT INTO `gallery_posts` (`id`, `user_id`, `image`, `description`, `created_at`) VALUES
(1, 1, 'uploads/image1.jpg', 'Моя первая картинка', '2025-02-12 14:58:19');

-- --------------------------------------------------------

--
-- Структура таблицы `likes`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `post_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `post_id`, `created_at`) VALUES
(8, 17, 4, '2025-06-09 10:10:25'),
(10, 1, 4, '2025-06-10 08:42:40'),
(11, 1, 8, '2025-06-12 12:56:50'),
(12, 18, 4, '2025-06-14 13:38:03'),
(13, 18, 9, '2025-06-14 13:38:04'),
(14, 18, 1, '2025-06-14 13:38:07'),
(15, 18, 8, '2025-06-14 13:38:10'),
(17, 18, 10, '2025-06-14 13:38:22'),
(18, 1, 10, '2025-06-14 13:39:49'),
(19, 1, 9, '2025-06-14 13:39:50');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `customer_name` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `status` enum('processing','shipped','in-transit','completed') NOT NULL DEFAULT 'processing',
  `order_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `customer_name`, `phone`, `status`, `order_date`) VALUES
(1, 1, 2, 1, 'Admin', '+7 (908) 309-31-49', 'in-transit', '2025-06-03 21:37:29'),
(3, 1, 5, 1, 'Admin', '+7 (908) 309-31-49', 'processing', '2025-06-03 21:38:49'),
(5, 1, 3, 1, 'Admin', '+7 (908) 309-31-49', 'completed', '2025-06-05 16:03:21'),
(6, 1, 2, 1, 'Admin', '+7 (908) 309-31-49', 'shipped', '2025-06-05 18:35:25'),
(7, 5, 5, 1, 'meuu', '+7 (908) 309-31-49', 'processing', '2025-06-05 20:47:27'),
(8, 1, 3, 1, 'Admin', '+7 (908) 309-31-49', 'processing', '2025-06-08 11:09:21'),
(9, 5, 2, 1, 'meuu', '+7 (967) 474-42-60', 'completed', '2025-06-09 04:34:47'),
(10, 17, 5, 1, 'Jezzi', '+7 (987) 122-91-11', 'processing', '2025-06-09 10:08:00'),
(11, 17, 6, 1, 'Jezzi', '+7 (987) 122-91-11', 'processing', '2025-06-09 10:08:00'),
(12, 1, 2, 2, 'Admin', '+7 (908) 309-31-49', 'shipped', '2025-06-10 07:35:56'),
(13, 1, 3, 2, 'Admin', '+7 (908) 309-31-49', 'processing', '2025-06-10 07:35:56');

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `user_id`, `image_url`, `description`, `created_at`) VALUES
(1, 1, 'uploads/posts/6841e6c5a2744.jpg', 'это мой первый рисунок ', '2025-06-05 18:49:43'),
(2, 1, 'uploads/posts/6841e94ccdf09.jpg', 'Потратил НА этот РИСУНОК пол года!!!', '2025-06-05 19:00:30'),
(3, 5, 'uploads/posts/6841ee2936aa6.jpg', '', '2025-06-05 19:21:15'),
(4, 5, 'uploads/posts/6841efbe91882.jpg', 'milie', '2025-06-05 19:28:00'),
(8, 1, 'uploads/posts/684ace887de6a.jpg', 'все в сборе', '2025-06-12 12:56:40'),
(9, 18, 'uploads/posts/684d7aba4209d.jpg', 'сделала косплей на Рокси', '2025-06-14 13:35:54'),
(10, 18, 'uploads/posts/684d7ae178dda.jpg', 'Сильфи', '2025-06-14 13:36:33'),
(12, 18, 'uploads/posts/684d7b86b31de.jpg', 'огврпо ывып оыварп ыр повыопр выо ыоврп оыврпор ыврп воырпоырЛдрп вырф аорпоырв ааоп рывоарпо рваопр аофрп выроарп овар полрва опрваорп оварпткфдРПЫ ЛОВРКАОПР ЫРПЫОПРОР ФЛ АПРЫВАОРП АВОРП ЛЫВОКАРП ГКРОА МОИФЫАЖОПР ФЖВДЛАПР РПКГРКО ФМДШАЫВЛПР КГРПОФУДАЛОПР КФУРГРП АФЖОВПРФЫОЖ', '2025-06-14 13:39:18');

-- --------------------------------------------------------

--
-- Структура таблицы `products`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` text,
  `price` decimal(10,2) DEFAULT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `products`
--

INSERT INTO `products` (`id`, `name`, `image_url`, `price`, `description`, `created_at`) VALUES
(1, 'Воительница Эрис', 'https://sun9-55.userapi.com/impg/aXxnUQfrzLAJhrK7YSOqrZfOsF2r1NNaBvXU-g/0M6cjMQE3iA.jpg?size=300x300&quality=95&sign=2105dc71067ae62b93586e3e92ec4377&type=album', '6000.00', 'Фигурка выполнена в масштабе 1/7 и изготовлена из высококачественного ПВХ. Особое внимание уделено деталям брони, плаща и меча, а также выразительной мимике Эрис. Она станет отличным дополнением вашей коллекции и ярким акцентом в любом интерьере.', '2025-06-03 17:28:21'),
(2, 'Футболка с Рокси', 'https://sun9-28.userapi.com/impg/NJYlAvQ7HYdXmd-xyuYPjPonVbAp3REX4ej4jQ/KBIi4tdpg8U.jpg?size=300x300&quality=95&sign=56a3f2d0dcd4d15160e3aefc559c13a6&type=album', '2000.00', 'Дизайн вдохновлён классическим стилем аниме: Рокси изображена в своём культовом магическом наряде с фирменной шляпой и серьёзным, но добрым взглядом. Принт нанесён методом прямой цифровой печати, что обеспечивает высокую чёткость и стойкость рисунка даже после множества стирок.\r\n\r\nХарактеристики:\r\n\r\nМатериал: 100% хлопок (премиум качества)\r\n- Цвет: базовый чёрный / белый / по выбору\r\n- Доступные размеры: XS – XXL\r\n- Унисекс-крой — подойдёт всем\r\n- Мягкий, дышащий материал\r\n- Устойчивый к выцветанию принт', '2025-06-03 17:38:28'),
(3, 'Виноградовый напиток с Рокси', 'https://sun9-36.userapi.com/impg/QOh3Vdck1PTue0KVzDZk9A07PWZbsF3lX7HUBg/IRUprUV53_E.jpg?size=300x300&quality=95&sign=58ce6a7903230c4fb59747d8e5b88f0b&type=album', '1200.00', 'Лёгкий, прохладный и искристый, этот напиток подарит тебе заряд бодрости и напомнит, что даже в обычном дне можно найти немного волшебства.\r\n\r\nОсобенности:\r\n- Объём: 330 мл\r\n- Вкус: насыщенный виноград, с лёгкой кислинкой\r\n- Без кофеина\r\n- Безалкогольный\r\n- Красочная коллекционная упаковка с Рокси\r\n- Подходит для вегетарианцев', '2025-06-03 17:40:45'),
(4, '1 том манги', 'https://sun9-20.userapi.com/impg/1RYL6oR2y_fJHiKWUSF7lQ4ldTLGhnu5F4ST9w/mHqpoRmsPu4.jpg?size=300x300&quality=95&sign=2307bc7759e342b38fa47c365f6afc12&type=album', '800.00', 'В первом томе мы знакомимся с детством Рудиуса, его магическими способностями, талантливой наставницей Рокси и первыми шагами на пути к великому приключению. Это начало захватывающего и трогательного путешествия о взрослении, искуплении и поиске смысла жизни.\r\n\r\nХарактеристики:\r\n- Жанр: фэнтези, исекай, драма, приключения\r\n- Автор: Rifujin na Magonote\r\n- Художник: Yuka Fujikawa\r\n- Формат: 192 страницы, чёрно-белая печать\r\n- Язык: русский\r\n- Мягкая обложка', '2025-06-03 17:45:19'),
(5, '2 том манги', 'https://sun9-49.userapi.com/impg/7aXMCEB0-DVdyDbNMRGRcQP8kKnIUiqQB5IlTg/9mtPUxJjnlM.jpg?size=300x300&quality=95&sign=9eb6e19f26e183005cfb13439a1b9d11&type=album', '800.00', 'Во 2-м томе Рудиус сталкивается с реальностью мира за пределами родного дома, заводит новых друзей (и не только), а также начинает обучать благородную, но вспыльчивую девочку по имени Эрис. Их отношения начинаются… с ударов и криков — и именно так зарождаются легенды.\r\n\r\nХарактеристики:\r\n- Жанр: фэнтези, исекай, приключения, драма\r\n- Автор: Rifujin na Magonote\r\n- Художник: Yuka Fujikawa\r\n- Объём: около 190 стр., ч/б\r\n- Язык: русский \r\n- Формат: мягкая обложка, стандарт манги', '2025-06-03 17:49:47'),
(6, '3 том манги', 'https://sun9-51.userapi.com/impg/1WFvZbwbwNVFHcHiynRG2weOQwswnorTBAXHPA/4-pfZljf1Wo.jpg?size=300x300&quality=95&sign=762d5a7f9054d6d7fab101d082267201&type=album', '800.00', 'В 3-м томе начинается совершенно новая глава истории: Рудиус и Эрис оказываются в демоническом регионе, где их ждёт встреча с загадочным и могущественным Руиджердом — воином племени Супардов. Смогут ли они объединиться, чтобы вернуться домой? И что скрывает этот суровый мир, где доверие — редкость, а сила решает всё?\r\n\r\nХарактеристики:\r\n- Жанр: исекай, фэнтези, драма, приключения\r\n- Автор: Rifujin na Magonote\r\n- Художник: Yuka Fujikawa\r\n- Объём: ~190 страниц, чёрно-белая печать\r\n- Язык: русский\r\n- Формат: стандарт манги, мягкая обложка', '2025-06-03 17:58:03');

-- --------------------------------------------------------

--
-- Структура таблицы `stories`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `stories`;
CREATE TABLE `stories` (
  `id` int NOT NULL,
  `episode_number` varchar(50) DEFAULT NULL,
  `video_url` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `stories`
--

INSERT INTO `stories` (`id`, `episode_number`, `video_url`) VALUES
(1, '1 серия', 'https://vkvideo.ru/video_ext.php?oid=-221125211&id=456247687&hash=04925392489a38b4'),
(2, '2 серия', 'https://vkvideo.ru/video_ext.php?oid=-221125211&id=456247693&hash=6363d8c168e31836'),
(3, '3 серия', 'https://vkvideo.ru/video_ext.php?oid=-221125211&id=456247692&hash=dde59f09f546b55a'),
(4, '4 серия', 'https://vkvideo.ru/video_ext.php?oid=-221125211&id=456247691&hash=a0f70071c1286b41'),
(5, '5 серия', 'https://vkvideo.ru/video_ext.php?oid=-221125211&id=456247685&hash=8ba355c3dbb54426');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--
-- Создание: Июн 08 2025 г., 10:20
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_birthday` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `img_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `background_img_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `role` enum('user','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `created_at`, `name`, `email`, `description`, `date_birthday`, `password`, `img_url`, `background_img_url`, `role`) VALUES
(1, '2025-02-04 21:00:00', 'Admin', 'asd@asd.asd', 'Я АДМИНИСТРАТОР ЭТОГО САЙТА', NULL, '$2y$10$v.pC/BkP3oIw6RK0dS5DYOs9yuIGGBgLTaU9HWgJ1q3l4aOE1RMBi', 'uploads/194658b553c255ecd8d96d85f642e27b.jpg', '', 'admin'),
(5, '2025-02-08 21:00:00', 'meuu', 'qwe@qwe.qwe', 'всем привки я фанатка', NULL, '$2y$10$fMPWnYqTTxxLQGlrY.j7SuBW/LVD/YwzGXqbVmtH4CDhK.Arli5Lu', 'uploads/5b0c05afa709277a3ab4f38297a54598.jpg', '', 'user'),
(14, '2025-06-08 10:28:28', 'Max123', 'nshxhx62@gmail.com', NULL, NULL, '$2y$10$AH/VOnG.2WZor9XENuEameBJqMVl4Tkmi1tJ49CaEdZ1nVfvtxxtS', NULL, NULL, 'user'),
(16, '2025-06-09 00:51:43', 'Serega', 'sergeysamuraynig@gmail.com', NULL, NULL, '$2y$10$qPkj6AQ2rbXW7sNfJ8dKi.NAMd5yI7tF.PsNXvi32vmcpCiHGJsGC', NULL, NULL, 'user'),
(17, '2025-06-09 10:06:33', 'Jezzi', 'sergeysamuraynigg@gmail.com', NULL, NULL, '$2y$10$U//30nNV67ZklPxYKjE3hOSVmj.Jdo1mi40UEQ7/onOjuysPbj6IO', NULL, NULL, 'user'),
(18, '2025-06-14 13:34:54', '111', 'vikachr19@gmail.com', '', NULL, '$2y$10$m2xdmpV8Tdvbnc8z/K0xQODxs0zmiEmUTAduZ1XPX2l6PsAW3AiNS', 'uploads/e497ad7a1c92940913452df986d4380f.jpg', NULL, 'user'),
(19, '2025-06-17 12:14:13', 'sanyagay', 'sanyapornosex@mail.ru', '', NULL, '$2y$10$EO/eHa1kGgyfL86KL1vnKeKavdftBMRiDtHsCG0MLFDUBiBltyO3u', 'uploads/IMG_4575.jpeg', NULL, 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `gallery_posts`
--
ALTER TABLE `gallery_posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`post_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `gallery_posts`
--
ALTER TABLE `gallery_posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT для таблицы `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT для таблицы `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `gallery_posts`
--
ALTER TABLE `gallery_posts`
  ADD CONSTRAINT `gallery_posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
