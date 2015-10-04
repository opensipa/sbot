-- Aggiornamento del 04 ottobre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 04 ottobre 2015, altrimenti basta usare telegram_base.sql
-- Applica in sequenza 1_update.sql, 2_update.sql
--
-- Apply the patch 2_update.sql only not first installation. Or installation is antecedent at 04/10/2015
-- Apply in sequence 1_update.sql, 2_update.sql

ALTER TABLE `message_send` ADD `MessageID` INT(11) NULL DEFAULT NULL AFTER `Signature`;
ALTER TABLE `message_send` ADD `utenti_messageID` INT NULL DEFAULT NULL AFTER `MessageID`;