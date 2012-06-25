DROP TABLE IF EXISTS `pol_session`;

CREATE OR REPLACE VIEW `pol_session` AS
    SELECT * FROM `police_default`.`pol_session`;

DROP TABLE IF EXISTS `pol_users_logs`;

CREATE OR REPLACE VIEW `pol_users_logs` AS
    SELECT * FROM `police_default`.`pol_users_logs`;

DROP TABLE IF EXISTS `pol_jce_groups`;
CREATE OR REPLACE VIEW `pol_jce_groups` AS
    SELECT * FROM `police_default`.`pol_jce_groups`;

DROP TABLE IF EXISTS `pol_jce_plugins`;
CREATE OR REPLACE VIEW `pol_jce_plugins` AS
    SELECT * FROM `police_default`.`pol_jce_plugins`;