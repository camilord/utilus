DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(64) NOT NULL,
  `password` varchar(128) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `users` VALUES(1, 'johnny', 'e014b0ce1ce21279abf3675e9dbd2b1bf846e5d8', 'Johny Bravo', '2018-05-20 13:53:17');
INSERT INTO `users` VALUES(2, 'camilo', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Camilo Lozano III', '2018-05-20 13:55:40');
INSERT INTO `users` VALUES(3, 'sidharta', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Sidharta Bachtiar', '2018-05-20 13:55:40');
INSERT INTO `users` VALUES(4, 'benny', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Ben Smith', '2018-05-20 13:55:41');
INSERT INTO `users` VALUES(5, 'john', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'John Paler', '2018-05-20 13:55:41');
INSERT INTO `users` VALUES(6, 'kianbomba', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Kian Nguyen', '2018-05-20 13:55:41');
INSERT INTO `users` VALUES(7, 'mikey', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Michael Mylvaganam', '2018-05-20 13:55:41');
INSERT INTO `users` VALUES(8, 'bowen', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Bowen Luo', '2018-05-20 13:55:41');
INSERT INTO `users` VALUES(9, 'ben.e', 'c9b359951c09c5d04de4f852746671ab2b2d0994', 'Ben Eichler', '2018-05-20 13:55:41');