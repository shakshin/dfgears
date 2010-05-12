-- phpMyAdmin SQL Dump
-- version 2.11.8.1deb5+lenny4
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Май 12 2010 г., 21:59
-- Версия сервера: 5.0.51
-- Версия PHP: 5.2.6-1+lenny8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- --------------------------------------------------------

--
-- Структура таблицы `objectClasses`
--

CREATE TABLE IF NOT EXISTS `objectClasses` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `alias` varchar(20) collate utf8_unicode_ci NOT NULL,
  `module` varchar(20) collate utf8_unicode_ci NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `module` (`module`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `objects`
--

CREATE TABLE IF NOT EXISTS `objects` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `alias` varchar(20) collate utf8_unicode_ci NOT NULL,
  `class` int(11) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `alias` (`alias`),
  KEY `class` (`class`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

