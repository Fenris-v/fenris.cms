-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Июн 28 2020 г., 22:22
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `fenris`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `short_desc` text COLLATE utf8_unicode_ci DEFAULT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `author_id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `uri` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `short_desc`, `text`, `author_id`, `date`, `uri`) VALUES
(1, 'Sample blog post', '<p>This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>', '<p>Cum sociis natoque penatibus et magnis <a href=\"#\">dis parturient montes</a>, nascetur ridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet fermentum.</p>\n<blockquote>\n<p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong> ornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>\n</blockquote>\n<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>\n<h2 class=\"cyber\">Heading</h2>\n<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus, porta ac consectetur ac, vestibulum at eros.</p>\n<h3 class=\"cyber\">Sub-heading</h3>\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>\n<pre><code>Example code block</code></pre>\n<p>Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>\n<h3 class=\"cyber\">Sub-heading</h3>\n<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean lacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>\n<ul>\n<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>\n<li>Donec id elit non mi porta gravida at eget metus.</li>\n<li>Nulla vitae elit libero, a pharetra augue.</li>\n</ul>\n<p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra augue.</p>\n<ol>\n<li>Vestibulum id ligula porta felis euismod semper.</li>\n<li>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</li>\n<li>Maecenas sed diam eget risus varius blandit sit amet non magna.</li>\n</ol>\n<p>Cras mattis consectetur purus sit amet fermentum. Sed posuere consectetur est at lobortis.</p>', 1, '2020-06-23 18:40:45', '/post/1'),
(2, 'Another blog post', '<p>This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>', '<p>Cum sociis natoque penatibus et magnis <a href=\"#\">dis parturient montes</a>, nascetur\nridiculus mus. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis\nvestibulum. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet\nfermentum.</p>\n<blockquote>\n<p>Curabitur blandit tempus porttitor. <strong>Nullam quis risus eget urna mollis</strong>\nornare vel eu leo. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>\n</blockquote>\n<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit\namet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>\n<p>Vivamus sagittis lacus vel augue laoreet rutrum faucibus dolor auctor. Duis mollis, est non\ncommodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Morbi leo risus,\nporta ac consectetur ac, vestibulum at eros.</p>', 1, '2020-06-23 18:51:44', '/post/2'),
(3, 'New feature', '<p>This blog post shows a few different types of content that’s supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>', '<p>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Aenean\nlacinia bibendum nulla sed consectetur. Etiam porta sem malesuada magna mollis euismod.\nFusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa\njusto sit amet risus.</p>\n<ul>\n<li>Praesent commodo cursus magna, vel scelerisque nisl consectetur et.</li>\n<li>Donec id elit non mi porta gravida at eget metus.</li>\n<li>Nulla vitae elit libero, a pharetra augue.</li>\n</ul>\n<p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit\namet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>\n<p>Donec ullamcorper nulla non metus auctor fringilla. Nulla vitae elit libero, a pharetra\naugue.</p>', 1, '2020-06-23 18:53:17', '/post/3');

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `roles`
--

INSERT INTO `roles` (`id`, `role`) VALUES
(1, 'Администратор'),
(3, 'Зарегистрированный пользователь'),
(2, 'Контент менеджер'),
(4, 'Незарегистрированный пользователь');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL DEFAULT 3,
  `password_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `name`, `mail`, `password`, `role_id`, `password_token`, `updated_at`, `created_at`) VALUES
(1, 'admin', 'Николай', 'admin@gmail.com', '$2y$10$eGie3rlU6QZR19xAJNBQ3u1Vg85UXh/uCB3OOmR82.SaAPQEvbtfG', 1, NULL, '2020-06-28 22:20:30', NULL),
(2, 'user', 'Анатолий', 'user@gmail.com', '$2y$10$NHfDnmbyPL5LDg/RPYzkkuOFTVnK5KSwC13LwzTer2nw7OM72Zpy.', 3, NULL, NULL, NULL),
(3, 'manager', 'Виктория', 'manager@gmail.com', '$2y$10$BrgZOT7hOylxmaTewSoPlOfQabv0Yim6kl3pKjwxbDqjfsm5N5/rS', 2, NULL, NULL, NULL);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `articles_uri_uindex` (`uri`),
  ADD KEY `articles_users_id_fk` (`author_id`);

--
-- Индексы таблицы `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `roles_role_uindex` (`role`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_login_uindex` (`login`),
  ADD UNIQUE KEY `users_mail_uindex` (`mail`),
  ADD KEY `users_roles_id_fk` (`role_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_users_id_fk` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_roles_id_fk` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
