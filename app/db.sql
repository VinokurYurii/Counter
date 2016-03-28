-- phpMyAdmin SQL Dump
-- version 3.3.7deb7
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Окт 16 2014 г., 18:05
-- Версия сервера: 5.1.73
-- Версия PHP: 5.3.28-1~dotdeb.0

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `education`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_group` int,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL unique,
  `password` CHAR(64) NOT NULL,
  `solt` CHAR(10) NOT NULL,
  `role` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `bill_types`(
  `id` int not null auto_increment primary key,
  `parent_id` int not null default 0,
  `has_child` boolean not null default false,
  `type` varchar(100) not null,
  `comment` text not null,
  `owner_group_id` int not NULL
  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;

CREATE TABLE IF NOT EXISTS `bill_species`(
  `id` int not null auto_increment primary key,
  `type_id` int not null,
  `species` varchar(100) not null,
  `comment` text not null default '',
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  `amount` float(10,2) NOT NULL,
  `owner_id` int not NULL
  ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ;
