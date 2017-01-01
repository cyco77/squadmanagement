ALTER TABLE #__squad ADD description longtext NOT NULL;
ALTER TABLE #__squad ADD ismanagementsquad tinyint(4) NOT NULL DEFAULT '0';

ALTER TABLE #__squad_league ADD shortname varchar(255) NOT NULL;

ALTER TABLE #__squad_member ADD memberstate int(11) NOT NULL; 
ALTER TABLE #__squad_member ADD joinusdescription longtext NULL;

ALTER TABLE #__squad_member_additional_info ADD description longtext NULL;

ALTER TABLE #__squad_opponent ADD contact varchar(255) NOT NULL;
ALTER TABLE #__squad_opponent ADD contactemail varchar(1000) NOT NULL;

ALTER TABLE #__squad_war ADD state int(11) NOT NULL;
ALTER TABLE #__squad_war ADD challengedescription longtext NULL;