-- Active: 1732923519226@@127.0.0.1@3306@mercado
CREATE DATABASE IF NOT EXISTS `mercado`;
USE `mercado`;

DROP TABLE IF EXISTS `produtos`;

CREATE TABLE IF NOT EXISTS `produtos` (
    `id`           INT                  NOT NULL AUTO_INCREMENT,
    `produto`      VARCHAR(100)         DEFAULT NULL,
    `categoria`    VARCHAR(60)          DEFAULT NULL,
    `estoque`      INT                  DEFAULT NULL CHECK (`estoque` >= 0),
    `estoqueMin`   INT                  DEFAULT NULL CHECK (`estoqueMin` >= 1),
    `situacao`     VARCHAR(60) AS (
        CASE
            WHEN `estoque` = 0 THEN "Fora de estoque"
            WHEN `estoque` <= `estoqueMin`THEN "Pouco em estoque"
            ELSE "Estoque estável"
        END
    ) STORED,
    PRIMARY KEY(`id`)
); 

DROP TABLE IF EXISTS `log`;
CREATE TABLE IF NOT EXISTS `log` (
    `id`           INT                  NOT NULL AUTO_INCREMENT,
    `desc`         VARCHAR(100)         DEFAULT NULL,
    `situacao`     VARCHAR(100)         DEFAULT NULL,
    `dataLog`      TIMESTAMP            NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY(`id`)
);


DROP TRIGGER IF EXISTS `trg_insert_prod`;

DELIMITER $$

CREATE TRIGGER `trg_insert_prod` BEFORE INSERT ON `produtos`
FOR EACH ROW
BEGIN
    INSERT INTO `log` (`desc`,`situacao`) VALUES (CONCAT("Registro de ", new.produto, " realizado com sucesso."), new.`situacao`);
END$$

CREATE TRIGGER `trg_upd_prod` BEFORE UPDATE ON `produtos`
FOR EACH ROW
BEGIN
    IF OLD.`produto`!= NEW.`produto` THEN
        INSERT INTO `log` (`desc`,`situacao`) VALUES (CONCAT("Registro de produto: ", old.produto, " foi alterado para ", new.produto), new.`situacao`);
    END IF;
    IF OLD.`categoria`!= NEW.`categoria` THEN
        INSERT INTO `log` (`desc`,`situacao`) VALUES (CONCAT("Registro de categoria: ", old.categoria, " foi alterado para ", new.categoria), new.`situacao`);
    END IF;
    IF OLD.`estoque`!= NEW.`estoque` THEN
        INSERT INTO `log` (`desc`,`situacao`) VALUES (CONCAT("Registro de estoque: ", old.estoque, " foi alterado para ", new.estoque), new.`situacao`);
    END IF;
    IF OLD.`estoqueMin`!= NEW.`estoqueMin` THEN
        INSERT INTO `log` (`desc`,`situacao`) VALUES (CONCAT("Registro de valor mínimo de estoque: ", old.estoqueMin, " foi alterado para ", new.estoqueMin), new.`situacao`);
    END IF;
END$$

CREATE TRIGGER `trg_insert_del` BEFORE DELETE ON `produtos`
FOR EACH ROW
BEGIN
    INSERT INTO `log` (`desc`) VALUES (CONCAT("Registro de ", old.produto, " foi excluido."));
END$$

DELIMITER ;


SELECT * FROM log;
SELECT * FROM produtos;
