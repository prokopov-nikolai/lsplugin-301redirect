
--
-- Table structure for table `prefix_301redirect`
--

CREATE TABLE IF NOT EXISTS `prefix_301redirect` (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  old varchar(255) NOT NULL,
  new varchar(255) NOT NULL,
  active tinyint(1) NOT NULL DEFAULT 1,
  `regexp` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  UNIQUE INDEX old (old)
)
ENGINE = INNODB
AUTO_INCREMENT = 1
AVG_ROW_LENGTH = 3276
CHARACTER SET utf8
COLLATE utf8_general_ci;

-- --------------------------------------------------------