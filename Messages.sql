CREATE TABLE IF NOT EXISTS `Messages` (
    `login` varchar(10) NOT NULL,
    `message` varchar(40),
    `date` datetime,
    PRIMARY KEY ('login')
    );