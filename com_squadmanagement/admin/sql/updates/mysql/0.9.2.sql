CREATE  TABLE IF NOT EXISTS `#__squad_appointment` (
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

ALTER TABLE `#__squad_member_additional_info` 
ADD COLUMN `fromdate` DATE NOT NULL AFTER `description` , 
ADD COLUMN `dues` DECIMAL(10,2) NULL DEFAULT 0 AFTER `fromdate` ,
ADD COLUMN `payedto` DATE NOT NULL NULL AFTER `dues`;
