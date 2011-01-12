
CREATE TABLE IF NOT EXISTS `#__nooku_languages` (
    `nooku_language_id` SERIAL,
    `name` VARCHAR( 150 ) NOT NULL COMMENT 'The language name',
    `native_name` VARCHAR( 150 ) NOT NULL COMMENT 'The native language name',
    `iso_code` VARCHAR( 8 ) NOT NULL COMMENT 'The ISO Language codes',
    `alias` VARCHAR( 255 ) NOT NULL COMMENT 'Language alias',
    `created_date` DATETIME NOT NULL COMMENT 'Date the Language was Created',
    `operations` TINYINT NOT NULL DEFAULT 14 COMMENT 'Operations that can be performand on the language',
    `enabled` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Language Enabled State',
 	`image` VARCHAR( 255 ) NOT NULL DEFAULT '' COMMENT 'Custom flag image for the language',
 	`ordering` BIGINT UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Ordering for the languages' 
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Content Languages';

CREATE TABLE IF NOT EXISTS `#__nooku_tables` (
    `nooku_table_id` SERIAL,
    `table_name` VARCHAR( 150 ) NOT NULL COMMENT 'The table name of the translatable table',
    `unique_column` VARCHAR( 150 ) NOT NULL COMMENT 'The unique column name for the table',
    `title_column` VARCHAR( 150 ) NOT NULL COMMENT 'The title column name for the table',
    `enabled` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Table Enabled State'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Content Tables';

CREATE TABLE IF NOT EXISTS `#__nooku_translators` (
    `nooku_translator_id` SERIAL,
    `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'The translator user id',
    `enabled` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Language Enabled State',
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Language Translators';

CREATE TABLE IF NOT EXISTS `#__nooku_nodes` (
    `nooku_node_id` SERIAL ,
    `iso_code` VARCHAR( 8 ) NOT NULL COMMENT 'The language of the item',
    `table_name` VARCHAR( 150 ) NOT NULL COMMENT 'The table name of the item',
    `row_id` BIGINT UNSIGNED NOT NULL COMMENT 'The id of the item',
    `title` VARCHAR( 255 ) NOT NULL COMMENT 'The title of the item',
    `created` DATETIME NOT NULL COMMENT 'The created date of the item',
    `created_by` BIGINT UNSIGNED NOT NULL COMMENT 'The user who created the item',
    `modified` DATETIME NOT NULL COMMENT 'The modified date of the item',
    `modified_by` BIGINT UNSIGNED NOT NULL COMMENT 'The user who modified the item',
    `status` SMALLINT NOT NULL DEFAULT 0 COMMENT 'The status of an item',
    `original` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'True if the item is the original item',
    `deleted` TINYINT(1) NOT NULL DEFAULT 0 COMMENT 'True if the item is deleted',
    `params` TEXT NOT NULL DEFAULT '',
    `lft` BIGINT UNSIGNED NOT NULL NOT NULL DEFAULT 0,
    `rgt` BIGINT UNSIGNED NOT NULL NOT NULL DEFAULT 0
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Nodes';

CREATE TABLE IF NOT EXISTS `#__nooku_metadata` (
    `nooku_metadata_id` SERIAL ,
    `nooku_node_id` BIGINT UNSIGNED NOT NULL COMMENT 'The id of the node',
    `description` TEXT NOT NULL COMMENT 'Metadata description',
	`keywords` TEXT NOT NULL COMMENT 'Metadata keywords',
	`author` VARCHAR( 255 ) NOT NULL COMMENT 'Metadata author',
	UNIQUE KEY `nooku_node_id` (`nooku_node_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Metadata';
