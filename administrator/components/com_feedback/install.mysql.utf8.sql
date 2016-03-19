-- feedback
-- Copyright © 2010 Mertonium. All rights reserved.
-- License: GNU/GPL
--
-- feedback table(s) definition
--
--
CREATE TABLE IF NOT EXISTS `#__feedback` (
	`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`submitter_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`submitter_email` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`submitter_id` INT NOT NULL DEFAULT '0',
	`submitted_ts` DATETIME NOT NULL ,
	`url` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`browser` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`browser_version` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`feedback` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`operating_system` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`screen_resolution` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`user_agent` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
	`script_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
	`referer` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MYISAM DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE `#__feedback`
CHANGE `submitter_name` `submitter_name` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
CHANGE `feedback` `feedback` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;