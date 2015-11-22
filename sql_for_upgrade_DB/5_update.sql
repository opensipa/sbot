-- Aggiornamento del 17 ottobre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 17 ottobre 2015, altrimenti basta usare telegram_base.sql
-- Applica 5_update.sql
--
-- Apply the patch 5_update.sql only not first installation. Or installation is antecedent at 17/10/2015
-- Apply 5_update.sql

ALTER TABLE `utenti_message` CHANGE `Archive` `Archive` TINYINT(1) NULL DEFAULT '1';
ALTER TABLE `message_send` CHANGE `Archive` `Archive` TINYINT(1) NULL DEFAULT '1';
ALTER TABLE `admins` CHANGE `level` `level` varchar(25) DEFAULT 'admin';
