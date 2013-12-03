SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`user_table`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`user_table` (
  `user_id` INT NOT NULL ,
  `username` VARCHAR(45) NOT NULL ,
  `firstname` VARCHAR(45) NULL ,
  `lastname` VARCHAR(45) NULL ,
  `password` VARCHAR(45) NULL ,
  PRIMARY KEY (`user_id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`list_table`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`list_table` (
  `list_id` INT NOT NULL ,
  `user_id` INT NOT NULL ,
  `list_name` VARCHAR(45) NULL ,
  `date_created` DATETIME NULL ,
  PRIMARY KEY (`list_id`) ,
  INDEX `user_id_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_user_id`
    FOREIGN KEY (`user_id` )
    REFERENCES `mydb`.`user_table` (`user_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`list_content`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `mydb`.`list_content` (
  `list_id` INT NOT NULL ,
  `stock_id` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`list_id`, `stock_id`) ,
  INDEX `fk_list_id_idx` (`list_id` ASC) ,
  CONSTRAINT `fk_list_id`
    FOREIGN KEY (`list_id` )
    REFERENCES `mydb`.`list_table` (`list_id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `mydb` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;

