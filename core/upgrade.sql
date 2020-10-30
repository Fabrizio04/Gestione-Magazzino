-- Script per migrazione dalla versione 1.2 a 1.3
-- Per le nuove installazioni, usare sempre gestione_magazzino_db.sql

ALTER TABLE `etichette` ADD `magaz_tag` TEXT NOT NULL AFTER `campo`;