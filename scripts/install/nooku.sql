CREATE TABLE IF NOT EXISTS `pol_nooku_languages` (
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
    
CREATE TABLE IF NOT EXISTS `pol_nooku_tables` (
    `nooku_table_id` SERIAL,
    `table_name` VARCHAR( 150 ) NOT NULL COMMENT 'The table name of the translatable table',
    `unique_column` VARCHAR( 150 ) NOT NULL COMMENT 'The unique column name for the table',
    `title_column` VARCHAR( 150 ) NOT NULL COMMENT 'The title column name for the table',
    `enabled` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Table Enabled State'
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Content Tables';
  
CREATE TABLE IF NOT EXISTS `pol_nooku_translators` (
    `nooku_translator_id` SERIAL,
    `user_id` BIGINT UNSIGNED NOT NULL COMMENT 'The translator user id',
    `enabled` TINYINT(1) NOT NULL DEFAULT 1 COMMENT 'Language Enabled State',
    UNIQUE KEY `user_id` (`user_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Language Translators';
  
CREATE TABLE IF NOT EXISTS `pol_nooku_nodes` (
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
  
CREATE TABLE IF NOT EXISTS `pol_nooku_metadata` (
    `nooku_metadata_id` SERIAL ,
    `nooku_node_id` BIGINT UNSIGNED NOT NULL COMMENT 'The id of the node',
    `description` TEXT NOT NULL COMMENT 'Metadata description',
    `keywords` TEXT NOT NULL COMMENT 'Metadata keywords',
    `author` VARCHAR( 255 ) NOT NULL COMMENT 'Metadata author',
    UNIQUE KEY `nooku_node_id` (`nooku_node_id`)
) ENGINE = MYISAM CHARACTER SET utf8 COLLATE utf8_general_ci COMMENT = 'Nooku Metadata';

INSERT INTO `pol_modules` (`id`,`title`,`content`,`ordering`,`position`,`checked_out`,`checked_out_time`,`published`,`module`,`numnews`,`access`,`showtitle`,`params`,`iscore`,`client_id`,`control`)
VALUES
    (0, 'Nooku', '', 2, 'status', 0, '0000-00-00 00:00:00', 1, 'mod_language_select', 0, 0, 1, 'style=default\nlangformat=name\ndisplay_flag=0\ndisplay_name=1\n\n', 0, 1, '');

INSERT INTO `pol_modules` (`id`,`title`,`content`,`ordering`,`position`,`checked_out`,`checked_out_time`,`published`,`module`,`numnews`,`access`,`showtitle`,`params`,`iscore`,`client_id`,`control`)
VALUES
    (0, 'Nooku', '', 0, 'left', 0, '0000-00-00 00:00:00', 1, 'mod_language_select', 0, 0, 0, 'style=row\nlangformat=name\ndisplay_flag=name\n\n', 0, 0, '');

SET @module_id = LAST_INSERT_ID();

INSERT INTO `pol_modules_menu` (`moduleid`,`menuid`)
VALUES
    (@module_id, 0);

INSERT INTO `pol_components` (`id`,`name`,`link`,`menuid`,`parent`,`admin_menu_link`,`admin_menu_alt`,`option`,`ordering`,`admin_menu_img`,`iscore`,`params`,`enabled`)
VALUES
    (0, 'Nooku', 'option=com_nooku', 0, 0, 'option=com_nooku', 'Nooku', 'com_nooku', 0, 'language', 0, 'primary_language=nl-NL\n', 1);

UPDATE `pol_plugins` SET `published` = '1' WHERE (`element` = 'koowa' OR `element` = 'nooku') AND `folder` = 'system';