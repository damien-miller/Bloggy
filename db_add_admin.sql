DROP TABLE IF EXISTS `blog_members`;

CREATE TABLE `blog_members` (
  `memberID` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`memberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `blog_members` WRITE;
/*!40000 ALTER TABLE `blog_members` DISABLE KEYS */;

INSERT INTO `blog_members` (`memberID`, `username`, `password`, `email`)
VALUES
  (1,'Admin','$2y$10$wJxa1Wm0rtS2BzqKnoCPd.7QQzgu7D/aLlMR5Aw3O.m9jx3oRJ5R2','admin@admin.admin');

/*!40000 ALTER TABLE `blog_members` ENABLE KEYS */;
UNLOCK TABLES;
