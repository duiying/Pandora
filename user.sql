CREATE DATABASE IF NOT EXISTS `pandora`;

USE `pandora`;

CREATE TABLE IF NOT EXISTS `user` (
    id INT(11) NOT NULL AUTO_INCREMENT,
    name VARCHAR(50),
    age INT(11),
    PRIMARY KEY(id)
);

INSERT INTO `user` (name, age) VALUES('duiying', 18), ('wangyaxian', 23);