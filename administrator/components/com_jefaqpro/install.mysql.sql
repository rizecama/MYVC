CREATE TABLE IF NOT EXISTS `#__je_faq` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `questions` longtext NOT NULL,
  `answers` longtext NOT NULL,
  `catid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `posted_by` varchar(200) NOT NULL,
  `posted_date` datetime NOT NULL,
  `posted_email` varchar(100) NOT NULL,
  `ordering` int(11) NOT NULL DEFAULT '1',
  `hits` int(11) NOT NULL,
  `remote_ip` varchar(200) NOT NULL,
  `state` tinyint(3) unsigned NOT NULL,
  `email_status` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store faqs';

CREATE TABLE IF NOT EXISTS `#__je_faq_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) NOT NULL,
  `alias` varchar(255) NOT NULL,
  `state` tinyint(3) NOT NULL,
  `ordering` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `image_position` varchar(50) NOT NULL,
  `introtext` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store categories' ;

CREATE TABLE IF NOT EXISTS `#__je_faq_responses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `faqid` int(11) NOT NULL,
  `catid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `response_yes` int(11) NOT NULL,
  `response_no` int(11) NOT NULL,
  `remote_ip` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store Responses from the Users' ;

CREATE TABLE IF NOT EXISTS `#__je_faq_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `show_title` tinyint(3) NOT NULL,
  `introtext` tinyint(3) NOT NULL,
  `show_image` tinyint(3) NOT NULL,
  `show_form` tinyint(3) NOT NULL,
  `show_reguser` tinyint(3) NOT NULL,
  `show_author` tinyint(3) NOT NULL,
  `show_date` tinyint(3) NOT NULL,
  `show_captcha` tinyint(4) NOT NULL,
  `show_hits` tinyint(3) NOT NULL,
  `allow_reg` tinyint(3) NOT NULL,
  `show_response` tinyint(3) NOT NULL,
  `footer_text` tinyint(3) NOT NULL,
  `user_email` tinyint(3) NOT NULL,
  `admin_email` tinyint(3) NOT NULL,
  `emailid` varchar(200) NOT NULL,
  `themes` int(11) NOT NULL,
  `cat_perpage` int(11) NOT NULL,
  `resize` tinyint(3) NOT NULL,
  `image_width` int(11) NOT NULL,
  `image_height` int(11) NOT NULL,
  `date_format` varchar(100) NOT NULL,
  `group` varchar(100) NOT NULL,
  `sorting` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store Global Settings' ;

CREATE TABLE IF NOT EXISTS `#__je_faq_themes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `themes` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='Used to Store themes' ;
