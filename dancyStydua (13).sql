-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 16 2024 г., 08:48
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `dancyStydua`
--

-- --------------------------------------------------------

--
-- Структура таблицы `comments`
--

CREATE TABLE `comments` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `contant` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `rating` enum('1','2','3','4','5') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('выложить','скрыть') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'скрыть',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `comments`
--

INSERT INTO `comments` (`id`, `id_user`, `contant`, `rating`, `status`, `created_at`, `updated_at`) VALUES
(1, 3, 'Крутое место', '1', 'скрыть', '2024-11-25 08:38:46', '2024-12-02 04:24:56'),
(2, 3, 'все понравилось', '1', 'выложить', '2024-11-28 02:49:38', '2024-11-28 02:49:38'),
(3, 3, 'Самое лучшее место , в которых я была. Вежливый персонал', '4', 'выложить', '2024-11-29 02:46:46', '2024-11-29 02:46:46'),
(4, 3, 'Все хорошо', '5', 'выложить', '2024-11-29 03:27:28', '2024-11-29 03:27:28'),
(5, 3, 'Все хорошо', '5', 'скрыть', '2024-12-13 02:44:22', '2024-12-13 02:44:22');

-- --------------------------------------------------------

--
-- Структура таблицы `directions`
--

CREATE TABLE `directions` (
  `id` int NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `directions`
--

INSERT INTO `directions` (`id`, `name`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(2, 'ХИП ХОП', 'Хип-хоп танец включает в себя множество стилей, таких как брейк-данс, поппинг, локкинг и другие. Танцы часто исполняются под хип-хоп музыку и могут быть как сольными, так и групповыми.', 'photos/1734153591.png', '2024-11-25 04:17:10', '2024-12-14 02:19:51'),
(3, 'contemp', 'это направление в искусстве, которое охватывает широкий спектр стилей, техник и концепций, возникших с середины 20 века до настоящего времени. Оно характеризуется разнообразием форм выражения и стремлением к экспериментам.', 'photos/1734153603.png', '2024-11-26 07:30:47', '2024-12-14 02:20:03'),
(4, 'high heels', 'Это направление развивающее женственность и пластичность', NULL, '2024-12-12 10:46:12', '2024-12-12 10:46:12'),
(5, 'Детские танцы', 'Детские танцы направлены на', 'photos/1734153574.png', '2024-12-14 04:54:24', '2024-12-14 02:19:34'),
(10, 'Латиноамериканские танцы', 'Латиноамериканские танцы — общее название бальных и народных танцев, сформировавшихся на территории Латинской Америки. 4\r\n\r\nХарактерные черты латиноамериканских танцев — энергичные, страстные зажигательные движения и покачивание бёдрами.', 'photos/1734153098.png', '2024-12-14 02:09:53', '2024-12-14 02:19:19'),
(11, 'Народные танцы', 'Народный танец — фольклорный танец, который исполняется в своей естественной среде и имеет определённые традиционные для данной местности движения, ритмы, костюмы.', 'photos/1734320729.png', '2024-12-16 00:45:29', '2024-12-16 00:45:29');

-- --------------------------------------------------------

--
-- Структура таблицы `record`
--

CREATE TABLE `record` (
  `id` int NOT NULL,
  `id_user` int NOT NULL,
  `id_td` int DEFAULT NULL,
  `date_record` date NOT NULL,
  `time_record` time NOT NULL,
  `status` enum('новая','проведена','отменена') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'новая',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `record`
--

INSERT INTO `record` (`id`, `id_user`, `id_td`, `date_record`, `time_record`, `status`, `created_at`, `updated_at`) VALUES
(12, 3, 9, '2024-12-14', '00:00:00', 'отменена', '2024-12-13 01:34:58', '2024-12-13 01:34:58'),
(13, 3, 26, '2024-12-11', '11:00:00', 'новая', '2024-12-13 01:35:12', '2024-12-13 01:35:12'),
(14, 3, 8, '2024-12-03', '10:00:00', 'новая', '2024-12-13 04:38:48', '2024-12-13 04:38:48');

-- --------------------------------------------------------

--
-- Структура таблицы `teacher_directions`
--

CREATE TABLE `teacher_directions` (
  `id` int NOT NULL,
  `id_teacher` int NOT NULL,
  `id_directions` int NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `teacher_directions`
--

INSERT INTO `teacher_directions` (`id`, `id_teacher`, `id_directions`, `created_at`, `updated_at`) VALUES
(1, 3, 2, '2024-11-26 06:31:10', '2024-11-26 06:31:10'),
(8, 3, 2, '2024-12-10 07:57:03', '2024-12-10 07:57:03'),
(10, 4, 3, '2024-12-16 00:37:39', '2024-12-16 00:37:39'),
(11, 7, 3, '2024-12-16 00:37:49', '2024-12-16 00:37:49'),
(12, 7, 4, '2024-12-16 00:37:49', '2024-12-16 00:37:49'),
(13, 8, 10, '2024-12-16 00:38:45', '2024-12-16 00:38:45'),
(14, 9, 2, '2024-12-16 00:39:57', '2024-12-16 00:39:57'),
(15, 9, 5, '2024-12-16 00:39:57', '2024-12-16 00:39:57'),
(16, 10, 2, '2024-12-16 00:41:29', '2024-12-16 00:41:29'),
(17, 10, 5, '2024-12-16 00:41:29', '2024-12-16 00:41:29'),
(18, 10, 10, '2024-12-16 00:41:29', '2024-12-16 00:41:29'),
(20, 11, 2, '2024-12-16 00:43:36', '2024-12-16 00:43:36');

-- --------------------------------------------------------

--
-- Структура таблицы `timings`
--

CREATE TABLE `timings` (
  `id` int NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `id_teacher` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `timings`
--

INSERT INTO `timings` (`id`, `date`, `time`, `created_at`, `updated_at`, `id_teacher`) VALUES
(9, '2024-12-14', '00:00:00', '2024-12-03 02:06:07', '2024-12-03 02:06:07', 3),
(11, '2024-12-29', '10:43:00', '2024-12-03 02:41:25', '2024-12-03 02:41:25', 3),
(12, '2024-12-29', '10:43:00', '2024-12-03 02:41:53', '2024-12-03 02:41:53', 3),
(13, '2024-12-22', '10:46:00', '2024-12-03 02:43:49', '2024-12-03 02:43:49', 6),
(19, '2024-12-01', '13:46:00', '2024-12-03 03:46:59', '2024-12-03 03:46:59', 3),
(20, '2024-11-29', '12:15:28', '2024-12-03 07:16:06', '2024-12-03 07:16:06', 1),
(22, '2024-12-06', '11:30:00', '2024-12-08 09:51:32', '2024-12-08 09:51:32', 3),
(23, '2024-12-07', '15:01:00', '2024-12-08 09:58:45', '2024-12-08 09:58:45', 6),
(24, '2024-12-05', '15:58:00', '2024-12-08 09:59:06', '2024-12-08 09:59:06', 3),
(25, '2024-12-10', '11:30:00', '2024-12-12 12:25:20', '2024-12-12 12:25:20', 3),
(26, '2024-12-11', '11:00:00', '2024-12-13 00:57:29', '2024-12-13 00:57:29', 3),
(27, '2024-12-12', '13:44:00', '2024-12-13 01:41:01', '2024-12-13 01:41:01', 3),
(28, '2024-12-18', '12:00:00', '2024-12-16 00:45:52', '2024-12-16 00:45:52', 7),
(29, '2024-12-19', '12:24:00', '2024-12-16 01:24:40', '2024-12-16 01:24:40', 3),
(30, '2024-12-17', '12:24:00', '2024-12-16 01:24:51', '2024-12-16 01:24:51', 7);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('женщина','мужчина') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `age` date NOT NULL,
  `photo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','user','teacher') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `full_name`, `phone`, `email`, `gender`, `age`, `photo`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'наталья', '89870252334', 'natalya9@mail.ru', 'мужчина', '2024-11-08', NULL, '$2y$10$ezolfS9V8hWQWQrwvy.BGOIj1OXIPm/ZsPdXLkLAJkK8iHhTRELoS', 'admin', '2024-11-22 00:52:57', '2024-11-22 00:52:57'),
(2, 'елена миронова', '89870252334', 'elena@mail.ru', 'женщина', '2024-11-01', NULL, '$2y$10$TKjTGgK48X7UOtdom3TvD.zmK.8jdKOV6M7K2ETdwxw6ePXd0ID/K', 'admin', '2024-11-22 01:08:34', '2024-11-22 02:36:45'),
(3, 'Елена 2', '89870252334', 'mironova.natasha.05@mail.ru', 'женщина', '2024-11-15', 'photos/1734150408.png', '$2y$10$8DK4oNj4N6pWHSwfwc/lu.Xvk8Jo/WIkeCzCjh5HNUMfvcEqXj0mu', 'admin', '2024-11-25 02:17:40', '2024-12-14 01:26:48'),
(4, 'Иванов Федор Михайлович', '89870252334', 'ivan@mail.ru', 'женщина', '2024-11-06', NULL, '$2y$10$GupwlFTbdWRTgTupoOI6keG5ueYLvMWCE0T0yV9q/arxcEFAcwrVG', 'teacher', '2024-11-25 03:26:41', '2024-12-16 00:37:39'),
(7, 'миронова наталья', '89870252334', 'mir13@mail.ru', 'женщина', '2024-12-06', '1734070614.png', '$2y$10$pgBh4vXkDRlccGUbH2bAXuRSfAuYXVtsPzsZwaYEQKdheGMaMYYaS', 'teacher', '2024-12-12 10:45:14', '2024-12-16 00:37:49'),
(8, 'Осипова Наталья Александровна', '89870873473', 'osipova@mail.ru', 'женщина', '2010-03-19', NULL, '$2y$10$K8z9RdPLJgTiFncd7JV3c.faaYt0iHPhOLe5NNSYvrzcCnUoxpEm.', 'teacher', '2024-12-16 00:38:38', '2024-12-16 00:38:45'),
(9, 'Петров Иван Петрович', '89873273237', 'petrov@mail.ru', 'мужчина', '2001-02-16', 'photos/1734321091.png', '$2y$10$rSdCvQWR9vjwi4kc4cPbP.EhJ8rH/ZxA1TXQk2BCFUcVs3OQXaW1O', 'teacher', '2024-12-16 00:39:45', '2024-12-16 00:51:31'),
(10, 'Александров Алексей Анатольевич', '89823627362', 'Alex@mail.ru', 'мужчина', '1996-05-15', 'photos/1734321047.png', '$2y$10$rSdCvQWR9vjwi4kc4cPbP.EhJ8rH/ZxA1TXQk2BCFUcVs3OQXaW1O', 'teacher', '2024-12-16 00:41:22', '2024-12-16 00:50:47'),
(11, 'Миронова Елена', '89870252334', 'mironova.ndfgvatasha.05@mail.ru', 'женщина', '2024-12-06', NULL, '$2y$10$P.C/LaeJYqq7NjUC.sYaROkNp.N/loNFdHzBnKxsU0UblNwGE6are', 'teacher', '2024-12-16 00:42:41', '2024-12-16 00:43:36'),
(12, 'Миронова Елизавета', '89898982374', 'liza@mail.ru', 'женщина', '2024-11-21', NULL, '$2y$10$rSdCvQWR9vjwi4kc4cPbP.EhJ8rH/ZxA1TXQk2BCFUcVs3OQXaW1O', 'user', '2024-12-16 00:48:10', '2024-12-16 00:48:10');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Индексы таблицы `directions`
--
ALTER TABLE `directions`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `record`
--
ALTER TABLE `record`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_td` (`id_td`);

--
-- Индексы таблицы `teacher_directions`
--
ALTER TABLE `teacher_directions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_teacher` (`id_teacher`,`id_directions`),
  ADD KEY `id_diractions` (`id_directions`);

--
-- Индексы таблицы `timings`
--
ALTER TABLE `timings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_teacher` (`id_teacher`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `directions`
--
ALTER TABLE `directions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT для таблицы `record`
--
ALTER TABLE `record`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT для таблицы `teacher_directions`
--
ALTER TABLE `teacher_directions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `timings`
--
ALTER TABLE `timings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `record`
--
ALTER TABLE `record`
  ADD CONSTRAINT `record_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `teacher_directions`
--
ALTER TABLE `teacher_directions`
  ADD CONSTRAINT `teacher_directions_ibfk_1` FOREIGN KEY (`id_directions`) REFERENCES `directions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `teacher_directions_ibfk_2` FOREIGN KEY (`id_teacher`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
