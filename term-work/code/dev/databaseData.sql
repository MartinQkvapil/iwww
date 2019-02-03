SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `mydb` ;

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`uzivatel`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`uzivatel` ;

CREATE TABLE IF NOT EXISTS `mydb`.`uzivatel` (
  `iduzivatel` INT NOT NULL AUTO_INCREMENT,
  `jmeno` VARCHAR(45) NOT NULL,
  `prijmeni` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `datum pridani` DATE NOT NULL,
  `roleUzivatele` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`iduzivatel`),
  UNIQUE INDEX `iduzivatel_UNIQUE` (`iduzivatel` ASC) ,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`udalost`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`udalost` ;

CREATE TABLE IF NOT EXISTS `mydb`.`udalost` (
  `idudalost` INT NOT NULL AUTO_INCREMENT,
  `nazev` VARCHAR(45) NOT NULL,
  `uzivatel_iduzivatel` INT NOT NULL,
  PRIMARY KEY (`idudalost`),
  INDEX `fk_udalost_uzivatel1_idx` (`uzivatel_iduzivatel` ASC),
  CONSTRAINT `fk_udalost_uzivatel1`
    FOREIGN KEY (`uzivatel_iduzivatel`)
    REFERENCES `mydb`.`uzivatel` (`iduzivatel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`mistnost`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`mistnost` ;

CREATE TABLE IF NOT EXISTS `mydb`.`mistnost` (
  `idmistnost` INT NOT NULL,
  `nazev` VARCHAR(45) NULL,
  PRIMARY KEY (`idmistnost`),
  UNIQUE INDEX `idmistnost_UNIQUE` (`idmistnost` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`detail_udalosti`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`detail_udalosti` ;

CREATE TABLE IF NOT EXISTS `mydb`.`detail_udalosti` (
  `iddetail_udalosti` INT NOT NULL AUTO_INCREMENT,
  `datum` DATE NOT NULL,
  `popis` VARCHAR(45) NOT NULL,
  `pocet_listku` INT NOT NULL,
  `cenalistku` INT NOT NULL,
  `udalost_idudalost` INT NOT NULL,
  `uzivatel_iduzivatel` INT NOT NULL,
  `mistnost_idmistnost` INT NOT NULL,
  PRIMARY KEY (`iddetail_udalosti`),
  INDEX `fk_detail_udalosti_udalost1_idx` (`udalost_idudalost` ASC),
  INDEX `fk_detail_udalosti_uzivatel1_idx` (`uzivatel_iduzivatel` ASC),
  INDEX `fk_detail_udalosti_mistnost1_idx` (`mistnost_idmistnost` ASC),
  CONSTRAINT `fk_detail_udalosti_udalost1`
    FOREIGN KEY (`udalost_idudalost`)
    REFERENCES `mydb`.`udalost` (`idudalost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detail_udalosti_uzivatel1`
    FOREIGN KEY (`uzivatel_iduzivatel`)
    REFERENCES `mydb`.`uzivatel` (`iduzivatel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_detail_udalosti_mistnost1`
    FOREIGN KEY (`mistnost_idmistnost`)
    REFERENCES `mydb`.`mistnost` (`idmistnost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`listek`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`listek` ;

CREATE TABLE IF NOT EXISTS `mydb`.`listek` (
  `idfaktura` INT NOT NULL,
  `pocetlistku` INT NOT NULL,
  `datum` DATE NOT NULL,
  `nazevUdalosti` VARCHAR(45) NULL,
  `zaplaceno` VARCHAR(45) NOT NULL,
  `uzivatel_iduzivatel` INT NOT NULL,
  `detail_udalosti_iddetail_udalosti` INT NOT NULL,
  PRIMARY KEY (`idfaktura`),
  UNIQUE INDEX `idfaktura_UNIQUE` (`idfaktura` ASC),
  INDEX `fk_faktura_uzivatel1_idx` (`uzivatel_iduzivatel` ASC),
  INDEX `fk_faktura_detail_udalosti1_idx` (`detail_udalosti_iddetail_udalosti` ASC),
  CONSTRAINT `fk_faktura_uzivatel1`
    FOREIGN KEY (`uzivatel_iduzivatel`)
    REFERENCES `mydb`.`uzivatel` (`iduzivatel`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_faktura_detail_udalosti1`
    FOREIGN KEY (`detail_udalosti_iddetail_udalosti`)
    REFERENCES `mydb`.`detail_udalosti` (`iddetail_udalosti`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`vybaveni`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `mydb`.`vybaveni` ;

CREATE TABLE IF NOT EXISTS `mydb`.`vybaveni` (
  `idvybaveni` INT NOT NULL,
  `mistnost_idmistnost` INT NOT NULL,
  UNIQUE INDEX `idvybaveni_UNIQUE` (`idvybaveni` ASC),
  PRIMARY KEY (`idvybaveni`),
  INDEX `fk_vybaveni_mistnost1_idx` (`mistnost_idmistnost` ASC),
  CONSTRAINT `fk_vybaveni_mistnost1`
    FOREIGN KEY (`mistnost_idmistnost`)
    REFERENCES `mydb`.`mistnost` (`idmistnost`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;


--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `price` double NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `created`, `modified`) VALUES
(1, 'Basketball', 'A ball used in the NBA.', 49.99, '2015-08-02 12:04:03', '2015-08-06 06:59:18'),
(3, 'Gatorade', 'This is a very good drink for athletes.', 1.99, '2015-08-02 12:14:29', '2015-08-06 06:59:18'),
(4, 'Eye Glasses', 'It will make you read better.', 6, '2015-08-02 12:15:04', '2015-08-06 06:59:18'),
(5, 'Trash Can', 'It will help you maintain cleanliness.', 3.95, '2015-08-02 12:16:08', '2015-08-06 06:59:18'),
(6, 'Mouse', 'Very useful if you love your computer.', 11.35, '2015-08-02 12:17:58', '2015-08-06 06:59:18'),
(7, 'Earphone', 'You need this one if you love music.', 7, '2015-08-02 12:18:21', '2015-08-06 06:59:18'),
(8, 'Pillow', 'Sleeping well is important.', 8.99, '2015-08-02 12:18:56', '2015-08-06 06:59:18');



create table users
(
	id int auto_increment
		primary key,
	email varchar(55) null,
	username varchar(55) null,
	password varchar(64) null,
	description text null,
	created datetime default CURRENT_TIMESTAMP not null
);

