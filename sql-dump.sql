-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 22 2020 г., 00:26
-- Версия сервера: 5.6.41
-- Версия PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `opencart2`
--

-- --------------------------------------------------------

--
-- Структура таблицы `oc_opt`
--

CREATE TABLE `oc_opt` (
  `id` int(11) NOT NULL,
  `type` int(1) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `manufacturer_id` int(11) DEFAULT NULL,
  `meta_title` text,
  `meta_description` text,
  `meta_keywords` text,
  `h1` text,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `oc_opt`
--

INSERT INTO `oc_opt` (`id`, `type`, `category_id`, `manufacturer_id`, `meta_title`, `meta_description`, `meta_keywords`, `h1`, `description`) VALUES
(1, 1, 20, 0, 'meta-tag title', 'meta-description', 'meta-keywords', 'tag h1', '&lt;p&gt;Description&lt;/p&gt;');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `oc_opt`
--
ALTER TABLE `oc_opt`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `oc_opt`
--
ALTER TABLE `oc_opt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
