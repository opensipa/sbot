-- Aggiornamento del 13 ottobre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 13 ottobre 2015, altrimenti basta usare telegram_base.sql
-- Applica in sequenza 1_update.sql, 2_update.sql, 3_update.sql, 4_update.sql, 5_update.sql
--
-- Apply the patch 4_update.sql only not first installation. Or installation is antecedent at 13/10/2015
-- Apply in sequence 1_update.sql, 2_update.sql, 3_update.sql, 4_update.sql, 5_update.sql

ALTER TABLE `utenti_message` CHANGE `Archive` `Archive` TINYINT(1) NULL DEFAULT '1';
ALTER TABLE `message_send` CHANGE `Archive` `Archive` TINYINT(1) NULL DEFAULT '1';
ALTER TABLE `admins` CHANGE `level` `level` archar(25) DEFAULT 'admin';
