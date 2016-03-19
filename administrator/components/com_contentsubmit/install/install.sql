CREATE TABLE IF NOT EXISTS `#__contentsubmit_config` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM;