CREATE TABLE `pol_banner` LIKE `police_zone`.`pol_banner`;
INSERT `pol_banner` SELECT * FROM `police_zone`.`pol_banner`;

CREATE TABLE `pol_bannerclient` LIKE `police_zone`.`pol_bannerclient`;
INSERT `pol_bannerclient` SELECT * FROM `police_zone`.`pol_bannerclient`;

CREATE TABLE `pol_bannertrack` LIKE `police_zone`.`pol_bannertrack`;
INSERT `pol_bannertrack` SELECT * FROM `police_zone`.`pol_bannertrack`;

CREATE TABLE `pol_categories` LIKE `police_zone`.`pol_categories`;
INSERT `pol_categories` SELECT * FROM `police_zone`.`pol_categories`;

CREATE TABLE `pol_components` LIKE `police_zone`.`pol_components`;
INSERT `pol_components` SELECT * FROM `police_zone`.`pol_components`;

CREATE TABLE `pol_contact_details` LIKE `police_zone`.`pol_contact_details`;
INSERT `pol_contact_details` SELECT * FROM `police_zone`.`pol_contact_details`;

CREATE TABLE `pol_content` LIKE `police_zone`.`pol_content`;
INSERT `pol_content` SELECT * FROM `police_zone`.`pol_content`;

CREATE TABLE `pol_content_frontpage` LIKE `police_zone`.`pol_content_frontpage`;
INSERT `pol_content_frontpage` SELECT * FROM `police_zone`.`pol_content_frontpage`;

CREATE TABLE `pol_content_rating` LIKE `police_zone`.`pol_content_rating`;
INSERT `pol_content_rating` SELECT * FROM `police_zone`.`pol_content_rating`;

CREATE TABLE `pol_core_acl_aro` LIKE `police_zone`.`pol_core_acl_aro`;
INSERT `pol_core_acl_aro` SELECT * FROM `police_zone`.`pol_core_acl_aro`;

CREATE TABLE `pol_core_acl_aro_groups` LIKE `police_zone`.`pol_core_acl_aro_groups`;
INSERT `pol_core_acl_aro_groups` SELECT * FROM `police_zone`.`pol_core_acl_aro_groups`;

CREATE TABLE `pol_core_acl_aro_map` LIKE `police_zone`.`pol_core_acl_aro_map`;
INSERT `pol_core_acl_aro_map` SELECT * FROM `police_zone`.`pol_core_acl_aro_map`;

CREATE TABLE `pol_core_acl_aro_sections` LIKE `police_zone`.`pol_core_acl_aro_sections`;
INSERT `pol_core_acl_aro_sections` SELECT * FROM `police_zone`.`pol_core_acl_aro_sections`;

CREATE TABLE `pol_core_acl_groups_aro_map` LIKE `police_zone`.`pol_core_acl_groups_aro_map`;
INSERT `pol_core_acl_groups_aro_map` SELECT * FROM `police_zone`.`pol_core_acl_groups_aro_map`;

CREATE TABLE `pol_core_log_items` LIKE `police_zone`.`pol_core_log_items`;
INSERT `pol_core_log_items` SELECT * FROM `police_zone`.`pol_core_log_items`;

CREATE TABLE `pol_core_log_searches` LIKE `police_zone`.`pol_core_log_searches`;
INSERT `pol_core_log_searches` SELECT * FROM `police_zone`.`pol_core_log_searches`;

CREATE TABLE `pol_groups` LIKE `police_zone`.`pol_groups`;
INSERT `pol_groups` SELECT * FROM `police_zone`.`pol_groups`;

CREATE OR REPLACE VIEW `pol_jce_groups` AS
    SELECT * FROM `police_zone`.`pol_jce_groups`;

CREATE OR REPLACE VIEW `pol_jce_plugins` AS
    SELECT * FROM `police_zone`.`pol_jce_plugins`;

CREATE TABLE `pol_menu` LIKE `police_zone`.`pol_menu`;
INSERT `pol_menu` SELECT * FROM `police_zone`.`pol_menu`;

CREATE TABLE `pol_menu_types` LIKE `police_zone`.`pol_menu_types`;
INSERT `pol_menu_types` SELECT * FROM `police_zone`.`pol_menu_types`;

CREATE TABLE `pol_messages` LIKE `police_zone`.`pol_messages`;
INSERT `pol_messages` SELECT * FROM `police_zone`.`pol_messages`;

CREATE TABLE `pol_messages_cfg` LIKE `police_zone`.`pol_messages_cfg`;
INSERT `pol_messages_cfg` SELECT * FROM `police_zone`.`pol_messages_cfg`;

CREATE TABLE `pol_migration_backlinks` LIKE `police_zone`.`pol_migration_backlinks`;
INSERT `pol_migration_backlinks` SELECT * FROM `police_zone`.`pol_migration_backlinks`;

CREATE TABLE `pol_modules` LIKE `police_zone`.`pol_modules`;
INSERT `pol_modules` SELECT * FROM `police_zone`.`pol_modules`;

CREATE TABLE `pol_modules_menu` LIKE `police_zone`.`pol_modules_menu`;
INSERT `pol_modules_menu` SELECT * FROM `police_zone`.`pol_modules_menu`;

CREATE TABLE `pol_newsfeeds` LIKE `police_zone`.`pol_newsfeeds`;
INSERT `pol_newsfeeds` SELECT * FROM `police_zone`.`pol_newsfeeds`;

CREATE TABLE `pol_plugins` LIKE `police_zone`.`pol_plugins`;
INSERT `pol_plugins` SELECT * FROM `police_zone`.`pol_plugins`;

CREATE TABLE `pol_poll_data` LIKE `police_zone`.`pol_poll_data`;
INSERT `pol_poll_data` SELECT * FROM `police_zone`.`pol_poll_data`;

CREATE TABLE `pol_poll_date` LIKE `police_zone`.`pol_poll_date`;
INSERT `pol_poll_date` SELECT * FROM `police_zone`.`pol_poll_date`;

CREATE TABLE `pol_poll_menu` LIKE `police_zone`.`pol_poll_menu`;
INSERT `pol_poll_menu` SELECT * FROM `police_zone`.`pol_poll_menu`;

CREATE TABLE `pol_polls` LIKE `police_zone`.`pol_polls`;
INSERT `pol_polls` SELECT * FROM `police_zone`.`pol_polls`;

CREATE TABLE `pol_sections` LIKE `police_zone`.`pol_sections`;
INSERT `pol_sections` SELECT * FROM `police_zone`.`pol_sections`;

CREATE OR REPLACE VIEW `pol_session` AS
    SELECT * FROM `police_zone`.`pol_session`;

CREATE TABLE `pol_stats_agents` LIKE `police_zone`.`pol_stats_agents`;
INSERT `pol_stats_agents` SELECT * FROM `police_zone`.`pol_stats_agents`;

CREATE TABLE `pol_templates_menu` LIKE `police_zone`.`pol_templates_menu`;
INSERT `pol_templates_menu` SELECT * FROM `police_zone`.`pol_templates_menu`;

CREATE TABLE `pol_users` LIKE `police_zone`.`pol_users`;
INSERT `pol_users` SELECT * FROM `police_zone`.`pol_users`;

CREATE OR REPLACE VIEW `pol_users_logs` AS
    SELECT * FROM `police_zone`.`pol_users_logs`;

CREATE TABLE `pol_weblinks` LIKE `police_zone`.`pol_weblinks`;
INSERT `pol_weblinks` SELECT * FROM `police_zone`.`pol_weblinks`;