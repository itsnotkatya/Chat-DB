CREATE TABLE IF NOT EXISTS `User` (
    `id` int(10) NOT NULL auto_increment,
    `login` varchar(10) NOT NULL,
    `password` varchar(10) NOT NULL,
    PRIMARY KEY ('id')
    );