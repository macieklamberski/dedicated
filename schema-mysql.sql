# Dump of table langs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `langs`;

CREATE TABLE `langs` (
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `langs` (`name`, `code`, `position`)
VALUES
	('Polski','pl',2),
	('English','en',1);


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `key` varchar(255) DEFAULT NULL,
  `value` text,
  `default` text,
  `editable` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`key`, `value`, `default`, `editable`)
VALUES
	('project_name','','Project\'s name', 0),
	('site_title','','Project\'s name', 1),
	('site_description','',NULL, 1),
	('site_keywords','',NULL, 1),
	('site_default_lang','','pl', 1),
	('admin_password','',NULL, 1),
	('admin_default_lang','','pl', 1);


# Dump of table translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `translations`;

CREATE TABLE `translations` (
  `lang_id` varchar(255) DEFAULT NULL,
  `editable` tinyint(1) DEFAULT NULL,
  `key` varchar(255) DEFAULT NULL,
  `value` varchar(1000) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;