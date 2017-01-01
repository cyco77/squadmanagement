
CREATE TABLE IF NOT EXISTS `#__squad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `catid` INTEGER NOT NULL DEFAULT '0',
  `members` text,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(4) NOT NULL DEFAULT '1',
  `shortname` varchar(100) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `ismanagementsquad` tinyint(4) NOT NULL DEFAULT '0',
  `squadleader` INT(11) NOT NULL,   
  `waradmin` INT(11) NULL,   
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__squad_appointment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `squadid` INT NOT NULL ,
  `subject` varchar(255) NOT NULL,
  `body` varchar(1000) NOT NULL,
  `type` INT NOT NULL DEFAULT 0 ,
  `startdatetime` DATETIME NOT NULL ,
  `enddatetime` DATETIME NULL ,
  `duration` INT NOT NULL ,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',  
  PRIMARY KEY (`id`) 
 ) ENGINE=MyISAM;
 
 CREATE TABLE IF NOT EXISTS `#__squad_appointment_member` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `userid` INT NOT NULL ,
  `appointmentid` INT NOT NULL ,
  `state` INT NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) 
  ) ENGINE=MyISAM;
  
CREATE TABLE `#__squad_bankitem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `itemdatetime` datetime NOT NULL,
  `subject` varchar(255) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `amount` decimal(10,2) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',    
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;

CREATE TABLE  IF NOT EXISTS `#__squad_league` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `logo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',
  `shortname` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `squadid` varchar(255) NOT NULL,
  `role` text NOT NULL,
  `memberstate` int(11) NOT NULL,
  `joinusdescription` longtext NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_member_additional_field` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `tabid` int(11) NOT NULL,
  `fieldname` varchar(45) NOT NULL,
  `fieldtype` varchar(45) NOT NULL DEFAULT 'text',
  `maxlength` int(11) DEFAULT NULL,
  `icon` varchar(255) NOT NULL,
  `showinprofile` tinyint(4) NOT NULL DEFAULT '1',
  `showinlist` tinyint(4) NOT NULL DEFAULT '0',
  `ordering` int(11) DEFAULT NULL,
  `published` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_member_additional_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `displayname` VARCHAR (255) NOT NULL,
  `steamid` VARCHAR (255) NULL,
  `imageurl` text,
  `description` longtext NULL,
  `fromdate` DATE NOT NULL,
  `dues` DECIMAL(10,2) NULL DEFAULT 0,
  `payedto` DATE NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_member_additional_tab` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `ordering` int(11) NOT NULL,
  `published` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_opponent` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `contactemail` varchar(1000) NOT NULL DEFAULT '',
  `logo` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',  
  `published` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_war` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wardatetime` datetime NOT NULL,
  `state` int(11) NOT NULL,
  `squadid` int(11) NOT NULL,
  `opponentid` int(11) NOT NULL,
  `leagueid` int(11) NOT NULL,
  `matchlink` varchar(255) DEFAULT NULL,
  `lineup` varchar(255) DEFAULT NULL,
  `lineupopponent` varchar(255) DEFAULT NULL,
  `score` varchar(255) DEFAULT NULL,
  `scoreopponent` varchar(255) DEFAULT NULL,
  `result` varchar(255) DEFAULT NULL,
  `resultscreenshot` longtext,
  `description` longtext,
  `challengedescription` longtext,
  `createdby` int(11) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS `#__squad_war_round` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warid` int(11) NOT NULL,
  `map` varchar(255) DEFAULT NULL,
  `mapimage` longtext,
  `score` varchar(255) DEFAULT NULL,
  `score_opponent` varchar(255) DEFAULT NULL,
  `screenshot` longtext,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__squad_war_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `warid` int(11) NOT NULL,
  `memberid` int(11) NOT NULL,
  `position` varchar(255) DEFAULT NULL,
  `comment` varchar(1000) DEFAULT NULL,
  `state` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `#__squad_award` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `squadid` INT NOT NULL ,
  `awarddate` datetime NULL ,
  `place` INT NULL ,
  `url` VARCHAR(2000) NULL ,
  `imageurl` VARCHAR(2000) NULL ,
  `description` LONGTEXT NULL ,
  `ordering` VARCHAR(11) NULL ,
  `published` TINYINT NULL DEFAULT '1' ,
  PRIMARY KEY (`id`) 
)ENGINE=MyISAM;

