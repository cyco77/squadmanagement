CREATE TABLE IF NOT EXISTS `#__squad_award` (
  `id` INT(11) NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(255) NOT NULL ,
  `squadid` INT NOT NULL ,  `awarddate` datetime NULL ,
  `place` INT NULL ,
  `url` VARCHAR(2000) NULL ,
  `imageurl` VARCHAR(2000) NULL ,
  `description` LONGTEXT NULL , 
  `ordering` VARCHAR(11) NULL ,
  `published` TINYINT NULL DEFAULT '1' ,
  PRIMARY KEY (`id`) )ENGINE=MyISAM;