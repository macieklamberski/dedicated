# Dump of table langs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `langs`;

CREATE TABLE `langs` (
  `code` varchar(255) NOT NULL,
  `name` varchar(255),
  `order` int(11),
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `langs` (`name`, `code`, `position`)
VALUES
  ('Polski',  'pl', 2),
  ('English', 'en', 1);


# Dump of table settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `key` varchar(255) NOT NULL,
  `value` text,
  `default` text,
  `editable` tinyint(1),
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`key`, `default`, `editable`)
VALUES
  ('project_name',       'Project name', 0),
  ('site_default_lang',  'pl',           1),
  ('site_title',         'Project name', 1),
  ('site_description',   '',             1),
  ('site_keywords',      '',             1),
  ('admin_default_lang', 'pl',           1);


# Dump of table translations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `i18n`;

CREATE TABLE `i18n` (
  `lang_code` varchar(255) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` varchar(1000),
  `editable` tinyint(1),
  PRIMARY KEY (`lang_id`, `key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;