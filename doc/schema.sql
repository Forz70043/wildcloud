------------------------------
--  TABLE STRUCTURE
-----------------------------

CREATE TABLE `USER`(
    `id` int(5) NOT NULL AUTO_INCREMENT,
    `email` VARCHAR(256) NOT NULL,
    PRIMARY KEY(`id`)
);

CREATE TABLE `PASS`(
    `id` int(5) NOT NULL AUTO_INCREMENT,
    `user_id` int(5) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    PRIMARY KEY(`id`)
);

ALTER TABLE `PASS` ADD FOREIGN KEY(`user_id`) REFERENCES `USER`(`id`);