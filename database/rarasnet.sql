-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
-- -----------------------------------------------------
-- Schema reder036_webservice
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema reder036_webservice
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `reder036_webservice` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`medications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`medications` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `active_principle` VARCHAR(45) NULL COMMENT '',
  `pharmacology` VARCHAR(255) NULL COMMENT '',
  `reference_path` VARCHAR(45) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`signs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`signs` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `description` VARCHAR(5000) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `frequency` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 3358
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `mydb`.`signs_images`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`signs_images` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `path` VARCHAR(255) NULL COMMENT '',
  `file_name` VARCHAR(45) NULL COMMENT '',
  `signs_id` INT(11) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_signs_images_signs_idx` (`signs_id` ASC)  COMMENT '',
  CONSTRAINT `fk_signs_images_signs`
    FOREIGN KEY (`signs_id`)
    REFERENCES `reder036_webservice`.`signs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`specialties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`specialties` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(45) NULL COMMENT '',
  `cbo` VARCHAR(45) NULL COMMENT 'Identificador da especialidade',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`protocols`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`protocols` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `document` VARCHAR(50) NULL COMMENT 'Documento que cria o protocolo',
  `name` VARCHAR(45) NULL COMMENT 'Nome do arquivo PDF que contém o protocolo completo',
  `path_pdf` VARCHAR(255) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`disorders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`disorders` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(120) CHARACTER SET 'utf8' NOT NULL COMMENT '',
  `orphanumber` INT(8) NULL COMMENT '',
  `expertlink` VARCHAR(150) CHARACTER SET 'utf8' NULL COMMENT '',
  `disorder_type` VARCHAR(30) CHARACTER SET 'utf8' NOT NULL COMMENT '',
  `description` VARCHAR(10000) CHARACTER SET 'utf8' NULL COMMENT '',
  `references` VARCHAR(5000) NULL COMMENT '',
  `protocols_id` INT(10) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_disorders_protocols1_idx` (`protocols_id` ASC)  COMMENT '',
  CONSTRAINT `fk_disorders_protocols1`
    FOREIGN KEY (`protocols_id`)
    REFERENCES `reder036_webservice`.`protocols` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 9211
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `mydb`.`medications_has_disorders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`medications_has_disorders` (
  `medications_id` INT(10) NOT NULL COMMENT '',
  `disorders_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`medications_id`, `disorders_id`)  COMMENT '',
  INDEX `fk_medications_has_disorders_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  INDEX `fk_medications_has_disorders_medications1_idx` (`medications_id` ASC)  COMMENT '',
  CONSTRAINT `fk_medications_has_disorders_medications1`
    FOREIGN KEY (`medications_id`)
    REFERENCES `mydb`.`medications` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_medications_has_disorders_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `reder036_webservice` ;

-- -----------------------------------------------------
-- Table `reder036_webservice`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '',
  `login` VARCHAR(32) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `password` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `email` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `tipo_usuario_id` INT(11) NULL COMMENT '',
  `nome` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `sobrenome` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `cpf` INT(11) NULL COMMENT '',
  `dtnascimento` DATE NULL COMMENT '',
  `sexo` TINYINT(1) NULL COMMENT '',
  `estado` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `cidade` VARCHAR(125) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `cep` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `telefone` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `facebook` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `twitter` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `pai` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `mae` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `raca` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `emailcheckcode` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `passwordchangecode` VARCHAR(128) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `disable` TINYINT(1) NULL COMMENT 'Disable/enable account',
  `expire_account` DATE NULL COMMENT '',
  `created` DATETIME NULL COMMENT '',
  `updated` DATETIME NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 51
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`icds`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`icds` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `icd` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 103
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`treatment_centers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`treatment_centers` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `abbreviation` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `address` VARCHAR(60) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `number` INT(11) NULL COMMENT '',
  `complement` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `postal_code` VARCHAR(8) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `neighborhood` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `city` VARCHAR(45) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `state` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `cep` INT(10) NULL COMMENT '',
  `contact1` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `contact2` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `ddd` VARCHAR(6) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `phone_number` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `general_number` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `extension` VARCHAR(5) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT 'Ramal',
  `email` VARCHAR(30) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `site` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `latitude` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `longitude` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `cnes` VARCHAR(45) NULL COMMENT 'Cadastro Nacional de Estabelecimentos de Saúde',
  `open24` TINYINT(1) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 88
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`mortality`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`mortality` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `year` INT(4) NOT NULL COMMENT '',
  `amount` INT(10) NOT NULL COMMENT '',
  `disorders_id` INT(10) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_mortality_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  CONSTRAINT `fk_mortality_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 39
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`professionals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`professionals` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `surname` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `active` TINYINT(1) NULL COMMENT '1 - ativo, 0 - não ativo',
  `crm` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `city` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `uf` VARCHAR(2) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `email` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `profession` VARCHAR(40) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `telephone` VARCHAR(15) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `ddd` VARCHAR(6) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `facebook` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `twitter` VARCHAR(50) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  UNIQUE INDEX `facebook` (`facebook` ASC, `twitter` ASC)  COMMENT '')
ENGINE = MyISAM
AUTO_INCREMENT = 16
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`references`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`references` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `source` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `reference` VARCHAR(20) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  `maprelation` VARCHAR(100) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '')
ENGINE = InnoDB
AUTO_INCREMENT = 20331
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`synonymous`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`synonymous` (
  `id` INT(10) NOT NULL AUTO_INCREMENT COMMENT '',
  `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_general_ci' NULL COMMENT '',
  `disorders_id` INT(10) NULL COMMENT '',
  PRIMARY KEY (`id`)  COMMENT '',
  INDEX `fk_synonymous_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  CONSTRAINT `fk_synonymous_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 4066
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`professionals_has_specialties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`professionals_has_specialties` (
  `professionals_id` INT(10) NOT NULL COMMENT '',
  `specialties_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`professionals_id`, `specialties_id`)  COMMENT '',
  INDEX `fk_professionals_has_specialties_specialties1_idx` (`specialties_id` ASC)  COMMENT '',
  INDEX `fk_professionals_has_specialties_professionals_idx` (`professionals_id` ASC)  COMMENT '')
ENGINE = MyISAM
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`icds_has_disorders`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`icds_has_disorders` (
  `icds_id` INT(10) NOT NULL COMMENT '',
  `disorders_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`icds_id`, `disorders_id`)  COMMENT '',
  INDEX `fk_icds_has_disorders_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  INDEX `fk_icds_has_disorders_icds1_idx` (`icds_id` ASC)  COMMENT '',
  CONSTRAINT `fk_icds_has_disorders_icds1`
    FOREIGN KEY (`icds_id`)
    REFERENCES `reder036_webservice`.`icds` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_icds_has_disorders_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`disorders_has_signs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`disorders_has_signs` (
  `disorders_id` INT(10) NOT NULL COMMENT '',
  `signs_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`disorders_id`, `signs_id`)  COMMENT '',
  INDEX `fk_disorders_has_signs_signs1_idx` (`signs_id` ASC)  COMMENT '',
  INDEX `fk_disorders_has_signs_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  CONSTRAINT `fk_disorders_has_signs_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_disorders_has_signs_signs1`
    FOREIGN KEY (`signs_id`)
    REFERENCES `reder036_webservice`.`signs` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`disorders_has_references`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`disorders_has_references` (
  `disorders_id` INT(10) NOT NULL COMMENT '',
  `references_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`disorders_id`, `references_id`)  COMMENT '',
  INDEX `fk_disorders_has_references_references1_idx` (`references_id` ASC)  COMMENT '',
  INDEX `fk_disorders_has_references_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  CONSTRAINT `fk_disorders_has_references_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_disorders_has_references_references1`
    FOREIGN KEY (`references_id`)
    REFERENCES `reder036_webservice`.`references` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`treatment_centers_has_professionals`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`treatment_centers_has_professionals` (
  `treatment_centers_id` INT(10) NOT NULL COMMENT '',
  `professionals_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`treatment_centers_id`, `professionals_id`)  COMMENT '',
  INDEX `fk_treatment_centers_has_professionals_professionals1_idx` (`professionals_id` ASC)  COMMENT '',
  INDEX `fk_treatment_centers_has_professionals_treatment_centers1_idx` (`treatment_centers_id` ASC)  COMMENT '',
  CONSTRAINT `fk_treatment_centers_has_professionals_treatment_centers1`
    FOREIGN KEY (`treatment_centers_id`)
    REFERENCES `reder036_webservice`.`treatment_centers` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_treatment_centers_has_professionals_professionals1`
    FOREIGN KEY (`professionals_id`)
    REFERENCES `reder036_webservice`.`professionals` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `reder036_webservice`.`disorders_has_specialties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `reder036_webservice`.`disorders_has_specialties` (
  `disorders_id` INT(10) NOT NULL COMMENT '',
  `specialties_id` INT(10) NOT NULL COMMENT '',
  PRIMARY KEY (`disorders_id`, `specialties_id`)  COMMENT '',
  INDEX `fk_disorders_has_specialties_specialties1_idx` (`specialties_id` ASC)  COMMENT '',
  INDEX `fk_disorders_has_specialties_disorders1_idx` (`disorders_id` ASC)  COMMENT '',
  CONSTRAINT `fk_disorders_has_specialties_disorders1`
    FOREIGN KEY (`disorders_id`)
    REFERENCES `reder036_webservice`.`disorders` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_disorders_has_specialties_specialties1`
    FOREIGN KEY (`specialties_id`)
    REFERENCES `mydb`.`specialties` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
COLLATE = utf8mb4_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
