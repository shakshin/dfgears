
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Структура таблицы `acl`
--

CREATE TABLE IF NOT EXISTS `acl` (
  `userId` int(10) unsigned NOT NULL,
  `roleId` int(10) unsigned NOT NULL,
  KEY `userId` (`userId`,`roleId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Структура таблицы `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `alias` varchar(50) collate utf8_unicode_ci NOT NULL,
  `fullName` varchar(200) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `fullName` (`fullName`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `login` varchar(50) collate utf8_unicode_ci NOT NULL,
  `password` varchar(200) collate utf8_unicode_ci NOT NULL,
  `fullName` varchar(200) collate utf8_unicode_ci default NULL,
  `email` varchar(200) collate utf8_unicode_ci NOT NULL,
  `active` tinyint(3) unsigned NOT NULL default '0',
  `code` varchar(50) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `fullName` (`fullName`),
  KEY `login` (`login`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;
