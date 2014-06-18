-- phpMyAdmin SQL Dump
-- version 2.11.11.3
-- http://www.phpmyadmin.net
--
-- Host: 50.63.244.189
-- Generation Time: Jun 17, 2014 at 06:47 PM
-- Server version: 5.0.96
-- PHP Version: 5.1.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `revsheets`
--

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `fileID` varchar(100) NOT NULL,
  `active` int(11) default '1',
  `title` varchar(50) default NULL,
  `description` text,
  `subject` varchar(50) default NULL,
  `date` varchar(150) default NULL,
  `testDate` varchar(100) default NULL,
  `dump` longtext,
  `dl` bigint(255) NOT NULL default '0',
  `rating` int(11) default NULL,
  `groupID` varchar(100) default NULL,
  `ext` varchar(10) NOT NULL,
  `userID` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groupMembers`
--

CREATE TABLE `groupMembers` (
  `username` varchar(50) NOT NULL,
  `groupID` varchar(100) NOT NULL,
  `groupName` varchar(100) NOT NULL,
  `admin` tinyint(4) NOT NULL,
  `userID` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `name` varchar(100) NOT NULL,
  `dateCreated` varchar(100) NOT NULL,
  `groupID` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ratings`
--

CREATE TABLE `ratings` (
  `ratingID` int(11) NOT NULL auto_increment,
  `sheetID` int(11) NOT NULL,
  `rating` int(1) NOT NULL,
  `ip` varchar(25) NOT NULL,
  PRIMARY KEY  (`ratingID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=175 ;

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `name` varchar(100) NOT NULL,
  `groupID` varchar(100) NOT NULL,
  `sheetCount` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` varchar(100) NOT NULL,
  `name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `last_login` varchar(50) NOT NULL,
  `active` tinyint(1) NOT NULL default '1',
  `locked` tinyint(1) NOT NULL,
  `date` varchar(50) NOT NULL,
  `siteTheme` varchar(100) NOT NULL default 'Original',
  PRIMARY KEY  (`userID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;
