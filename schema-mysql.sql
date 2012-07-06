# Dump of table langs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `langs`;

CREATE TABLE `langs` (
  `code`      varchar(255) NOT NULL,
  `name`      varchar(255),
  `order`     int(11),
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
  `key`       varchar(255) NOT NULL,
  `value`     text,
  `default`   text,
  `editable`  tinyint(1),
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `settings` (`key`, `default`, `editable`)
VALUES
  ('project_name',       'Project name', 0),
  ('site_default_lang',  'pl',           1),
  ('site_title',         'Project name', 1),
  ('site_description',   '',             1),
  ('site_keywords',      '',             1),
  ('cms_default_lang',   'pl',           1);


# Dump of table i18n
# ------------------------------------------------------------

DROP TABLE IF EXISTS `i18n`;

CREATE TABLE `i18n` (
  `lang_code` varchar(255) NOT NULL,
  `key`       varchar(255) NOT NULL,
  `label`     varchar(255),
  `category`  varchar(255),
  `value`     varchar(1000),
  `editable`  tinyint(1),
  PRIMARY KEY (`lang_id`, `key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Dump of table forgots
# ------------------------------------------------------------

CREATE TABLE `forgots` (
  `id`         int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id`    int(11) DEFAULT NULL,
  `hash`       varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;