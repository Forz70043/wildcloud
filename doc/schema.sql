------------------------------
--  TABLE STRUCTURE
-----------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL UNIQUE,
    `email` varchar(100) NOT NULL UNIQUE,
    `password` varchar(255) NOT NULL,
    `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `COMPANY`(
	`id` INT(5) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) NOT NULL,
	`piva` varchar(32) DEFAULT NULL,
	`owner` INT(5) NOT NULL,
	`email` varchar(254) DEFAULT '',
	PRIMARY KEY(`id`)
);
ALTER TABLE `COMPANY` ADD FOREIGN KEY(`owner`) REFERENCES `USER`(`id`);

CREATE TABLE `COMPANY-PASS`(
	`id` INT(5) NOT NULL AUTO_INCREMENT,
	`company_id` INT(5) NOT NULL,
	`pass` varchar(255) NOT NULL
);
ALTER TABLE `COMPANY-PASS` ADD FOREIGN KEY(`company_id`) REFERENCES `COMPANY`(`id`);



CREATE TABLE `ROLE`(
	`id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
	`name` varchar(64) NOT NULL,
	`login_success_goto` varchar(512) NOT NULL,
	PRIMARY KEY(`id`)
);

CREATE TABLE `USER_ROLE`(
	`user_id` int(5) NOT NULL,
	`role_id` tinyint(3) NOT NULL
);
ALTER TABLE `USER_ROLE` ADD FOREIGN KEY(`user_id`) REFERENCES `USER`(`id`);
--ALTER TABLE `USER_ROLE` ADD INDEX( `role_id`);
--ALTER TABLE `USER_ROLE` ADD FOREIGN KEY(`role_id`) REFERENCES `ROLE`(`id`);

CREATE TABLE `SYSLOG` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `remote_ip` varchar(15) NOT NULL,
  `forward_ip` varchar(15) NOT NULL,
  `email` varchar(256) NOT NULL,
  `action` varchar(512) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);

CREATE TABLE `SITE`(
	`id` INT(5) NOT NULL AUTO_INCREMENT,
	`name` varchar(128) NOT NULL,
	`address` varchar(255) DEFAULT NULL,
	`cap` int(5) NOT NULL,
	`company_id` INT(5) NOT NULL,
	PRIMARY KEY(`id`)
);

ALTER TABLE `SITE` ADD FOREIGN KEY(`company_id`) REFERENCES `COMPANY`(`id`);
