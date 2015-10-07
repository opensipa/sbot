-- Aggiornamento del 07 ottobre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 07 ottobre 2015, altrimenti basta usare telegram_base.sql
-- Applica in sequenza 1_update.sql, 2_update.sql, 3_update.sql
--
-- Apply the patch 3_update.sql only not first installation. Or installation is antecedent at 07/10/2015
-- Apply in sequence 1_update.sql, 2_update.sql, 3_update.sql

ALTER TABLE `message_send` ADD `Archive` BOOLEAN NULL DEFAULT NULL AFTER `utenti_messageID`;
ALTER TABLE `utenti_message` ADD `Archive` BOOLEAN NULL DEFAULT NULL AFTER `Text`;