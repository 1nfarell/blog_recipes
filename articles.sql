-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Авг 27 2022 г., 18:36
-- Версия сервера: 8.0.29
-- Версия PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `database`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int NOT NULL,
  `title` longtext CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb3 COLLATE utf8_general_ci NOT NULL,
  `text` text CHARACTER SET utf8mb3 COLLATE utf8_general_ci,
  `portion` tinyint DEFAULT NULL,
  `id_image` int NOT NULL,
  `id_categories` int NOT NULL,
  `id_username` int DEFAULT NULL,
  `views` int DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `description`, `text`, `portion`, `id_image`, `id_categories`, `id_username`, `views`, `date`) VALUES
(133, 'Классическая шарлотка', 'Классическая шарлотка. Важное сладкое блюдо советской и постсоветской истории. Легкое, пышное тесто, максимум яблочной начинки — у шарлотки всегда был образ приятного, простого и при этом лакомого и диетического блюда. Яблоки настоятельно рекомендуем взять из кислых сортов — вроде антоновки. Их можно класть как сырыми, так и предварительно слегка карамелизованными на сковородке. И сахара лучше не жалеть. Он магическим образом распределяется в нужном количестве в тесте, а излишки образуют сладкую корочку.', 'Разогреть духовку. Отделить белки от желтков. Белки взбить в крепкую пену с щепоткой соли, постепенно добавляя сахар. \r\nПродолжать взбивать, добавляя по одному желтки, затем разрыхлитель и муку. Тесто по консистенции должно напоминать сметану. \r\nСмазать противень растительным маслом. Вылить половину теста на противень, разложить равномерно нарезанные дольками яблоки, залить второй половиной теста. \r\nПоместить противень в разогретую духовку. 3 минуты подержать при температуре 200 градусов, затем убавить до 180 и выпекать 20-25 минут.', NULL, 87, 10, 2, NULL, '2022-08-27 17:40:51');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
