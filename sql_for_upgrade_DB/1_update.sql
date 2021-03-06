-- Aggiornamento del 01 ottobre 2015 da applicare ad una installazione già presente
-- 
-- Questo aggiornamento è da applicare solo se avete fatto una installazione
-- di Sbot prima del 01 ottobre 2015, altrimenti basta usare telegram_base.sql
--
-- Apply the patch 1_update.sql only not first installation. Or installation is antecedent at 01/10/2015

ALTER TABLE `utenti_message` ADD `ID` INT(11) NOT NULL FIRST;
UPDATE `utenti_message` SET `ID` = `Message`;
ALTER TABLE `utenti_message` ADD PRIMARY KEY (`ID`);
ALTER TABLE `utenti_message` CHANGE `ID` `ID` INT(11) NOT NULL AUTO_INCREMENT;

--
-- Update table admin with name/surname user
--
ALTER TABLE `admins` ADD `signature` VARCHAR(255) NULL AFTER `password`;
ALTER TABLE `admins` ADD `level` VARCHAR(25)  NULL AFTER `signature`;
ALTER TABLE `admins` ADD UNIQUE(`username`);


--
-- Update table message send with name/surname user to send
--
ALTER TABLE `message_send` ADD `Signature` VARCHAR(255) NULL AFTER `Text`;