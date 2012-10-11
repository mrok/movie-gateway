SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA `movie_gateway` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ;
USE `movie_gateway` ;

-- -----------------------------------------------------
-- Table `customer`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `customer` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(245) NOT NULL ,
  `username` VARCHAR(75) NOT NULL ,
  `password` VARCHAR(48) NOT NULL ,
  PRIMARY KEY (`id`) ,
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `movies`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `movies` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `filename` VARCHAR(245) NOT NULL ,
  `when` DATETIME NOT NULL ,
  `tags` TEXT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

ALTER TABLE `movies` COLLATE = utf8_general_ci , ADD COLUMN `customer_id` INT(10) UNSIGNED NOT NULL  AFTER `id` ,
  ADD CONSTRAINT `fk_movies_customer`
  FOREIGN KEY (`customer_id` )
  REFERENCES `customer` (`id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk_movies_customer_idx` (`customer_id` ASC);

INSERT INTO `customer` (`name`, `username`, `password`) VALUES ('customer1', 'test', '84f83f37999fa3424fe23a3e2d218070385c625c75a25d09');

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
