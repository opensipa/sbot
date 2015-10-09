-- Aggiornamento del 09 ottobre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 09 ottobre 2015, altrimenti basta usare telegram_base.sql
-- Applica in sequenza 1_update.sql, 2_update.sql, 3_update.sql, 4_update.sql
--
-- Apply the patch 4_update.sql only not first installation. Or installation is antecedent at 09/10/2015
-- Apply in sequence 1_update.sql, 2_update.sql, 3_update.sql, 4_update.sql

ALTER TABLE `utenti_message` CHANGE `Text` `Text` VARCHAR(2048) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL;
ALTER TABLE `utenti_message` ADD `Document` BLOB NULL DEFAULT NULL AFTER `Text`;
ALTER TABLE `utenti_message` ADD `FileName` VARCHAR(255) NULL DEFAULT NULL AFTER `Document`;
ALTER TABLE `utenti_message` ADD `MimeType` VARCHAR(50) NULL DEFAULT NULL AFTER `FileName`;
ALTER TABLE `utenti_message` ADD `FileId` VARCHAR(250) NULL DEFAULT NULL AFTER `MimeType`;
ALTER TABLE `utenti_message` ADD `FileId2` VARCHAR(250) NULL DEFAULT NULL AFTER `FileId`;
ALTER TABLE `utenti_message` ADD `FileSize` int(11) NULL DEFAULT NULL AFTER `FileId2`;
ALTER TABLE `utenti_message` ADD `Width` int(11) NULL DEFAULT NULL AFTER `FileSize`;
ALTER TABLE `utenti_message` ADD `Height` int(11) NULL DEFAULT NULL AFTER `Width`;
