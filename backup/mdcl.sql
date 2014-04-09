SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `MDCL` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `MDCL` ;

-- -----------------------------------------------------
-- Table `MDCL`.`Races`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Races` (
  `Race_ID` TINYINT NOT NULL AUTO_INCREMENT ,
  `Race_Name` VARCHAR(16) NULL ,
  PRIMARY KEY (`Race_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Players`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Players` (
  `Player_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Bnet_ID` VARCHAR(45) NULL ,
  `Player_Name` VARCHAR(45) NULL ,
  `Best_Race` TINYINT NULL ,
  `Wins_Lifetime` INT NULL ,
  `Losses_Lifetime` INT NULL ,
  PRIMARY KEY (`Player_ID`) ,
  INDEX `Race_ID_idx` (`Best_Race` ASC) ,
  CONSTRAINT `Players_Race_ID`
    FOREIGN KEY (`Best_Race` )
    REFERENCES `MDCL`.`Races` (`Race_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Patches`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Patches` (
  `Patch_ID` INT NOT NULL AUTO_INCREMENT ,
  `Patch_Version` VARCHAR(45) NULL ,
  `Patch_Date` DATE NULL ,
  `Live` TINYINT(1) NULL ,
  PRIMARY KEY (`Patch_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Maps`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Maps` (
  `Map_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Map_Name` VARCHAR(45) NULL ,
  `Version_#` FLOAT NULL ,
  `Version_Date` DATE NULL ,
  `Map_Size_X` INT NULL ,
  `Map_Size_Y` INT NULL ,
  `Map_Size_Playable_X` INT NULL ,
  `Map_Size_Playable_Y` INT NULL ,
  PRIMARY KEY (`Map_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Modes`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Modes` (
  `Mode_ID` INT NOT NULL AUTO_INCREMENT ,
  `Mode_Name` VARCHAR(45) NULL ,
  `Players_Allowed` INT NULL ,
  `Team_Size` INT NULL ,
  PRIMARY KEY (`Mode_ID`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`MatchData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`MatchData` (
  `Match_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Match_Name` VARCHAR(32) NULL ,
  `Patch_ID` INT NULL ,
  `Match_Date` DATETIME NULL ,
  `Map_ID` BIGINT NULL ,
  `Mode_ID` INT NULL ,
  `Game_Speed` INT NULL ,
  PRIMARY KEY (`Match_ID`) ,
  INDEX `Patch_ID_idx` (`Patch_ID` ASC) ,
  INDEX `Map_ID_idx` (`Map_ID` ASC) ,
  INDEX `Mode_ID_idx` (`Mode_ID` ASC) ,
  CONSTRAINT `MatchData_Patch_ID`
    FOREIGN KEY (`Patch_ID` )
    REFERENCES `MDCL`.`Patches` (`Patch_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `MatchData_Map_ID`
    FOREIGN KEY (`Map_ID` )
    REFERENCES `MDCL`.`Maps` (`Map_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `MatchData_Mode_ID`
    FOREIGN KEY (`Mode_ID` )
    REFERENCES `MDCL`.`Modes` (`Mode_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`PlayerData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`PlayerData` (
  `Entry_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Player_ID` BIGINT NULL ,
  `Match_ID` BIGINT NULL ,
  `Player_Num` INT NULL ,
  `Team_Num` INT NULL ,
  `Color` VARCHAR(45) NULL ,
  `Race_ID` TINYINT NULL ,
  `Lobby_Race_ID` TINYINT NULL ,
  `Controller` VARCHAR(8) NULL ,
  `Handicap` INT NULL ,
  `Start_Location_X` FLOAT NULL ,
  `Start_Location_Y` FLOAT NULL ,
  PRIMARY KEY (`Entry_ID`) ,
  INDEX `Player_ID_idx` (`Player_ID` ASC) ,
  INDEX `Match_ID_idx` (`Match_ID` ASC) ,
  INDEX `Race_ID_idx` (`Race_ID` ASC) ,
  CONSTRAINT `PlayerData_Player_ID`
    FOREIGN KEY (`Player_ID` )
    REFERENCES `MDCL`.`Players` (`Player_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `PlayerData_Match_ID`
    FOREIGN KEY (`Match_ID` )
    REFERENCES `MDCL`.`MatchData` (`Match_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `PlayerData_Race_ID`
    FOREIGN KEY (`Race_ID` )
    REFERENCES `MDCL`.`Races` (`Race_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `PlayerData_Lobby_Race_ID`
    FOREIGN KEY (`Lobby_Race_ID` )
    REFERENCES `MDCL`.`Races` (`Race_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`PeriodicData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`PeriodicData` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Player_Num` BIGINT NULL ,
  `APM` INT NULL ,
  `Average_Minerals_Stockpiled` INT NULL ,
  `Average_Vespene_Stockpiled` INT NULL ,
  `Combat_Efficiency` INT NULL ,
  `Supply_Efficiency` INT NULL ,
  `Damage_Dealt` INT NULL ,
  `Energy_Spent` INT NULL ,
  `Economy_Energy_Available` INT NULL ,
  `Economy_Energy_Total` INT NULL ,
  `Life_Spent` INT NULL ,
  `Damage_Taken` INT NULL ,
  `Shields_Damage_Taken` INT NULL ,
  `Life_Healed` INT NULL ,
  `Shields_Regenerated` INT NULL ,
  `Minerals_Gathered` INT NULL ,
  `Minerals_Collection_Rate` INT NULL ,
  `Minerals_Received` INT NULL ,
  `Minerals_Spent` INT NULL ,
  `Minerals_Traded` INT NULL ,
  `Minerals_Available` INT NULL ,
  `Vespene_Gathered` INT NULL ,
  `Vespene_Collection_Rate` INT NULL ,
  `Vespene_Received` INT NULL ,
  `Vespene_Spent` INT NULL ,
  `Vespene_Traded` INT NULL ,
  `Vespene_Available` INT NULL ,
  `Supply_Used` INT NULL ,
  `Supply_Available` INT NULL ,
  `Supply_Killed` INT NULL ,
  `Supply_Lost` INT NULL ,
  `Army_Size` INT NULL ,
  `Units_Trained` INT NULL ,
  `Units_Trained_Minerals_Spent` INT NULL ,
  `Units_Trained_Vespene_Spent` INT NULL ,
  `Units_Lost` INT NULL ,
  `Units_Lost_Mineral_Value` INT NULL ,
  `Units_Lost_Vespene_Value` INT NULL ,
  `Units_Killed` INT NULL ,
  `Units_Killed_Mineral_Value` INT NULL ,
  `Units_Killed_Vespene_Value` INT NULL ,
  `Worker_Count` INT NULL ,
  `Workers_Trained` INT NULL ,
  `Workers_Lost` INT NULL ,
  `Workers_Killed` INT NULL ,
  `Structures_Built` INT NULL ,
  `Structures_Lost` INT NULL ,
  `Structures_Razed` INT NULL ,
  `Upgrades_Researched` INT NULL ,
  `Upgrades_Mineral_Value` INT NULL ,
  `Upgrades_Minerals_Lost` INT NULL ,
  `Upgrades_Vespene_Value` INT NULL ,
  `Upgrades_Vespene_Lost` INT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Player_#_idx` (`Player_Num` ASC) ,
  CONSTRAINT `PeriodicData_Player_Num`
    FOREIGN KEY (`Player_Num` )
    REFERENCES `MDCL`.`PlayerData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Matches`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Matches` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Player_ID` BIGINT NULL ,
  `Match_ID` BIGINT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Player_ID_idx` (`Player_ID` ASC) ,
  INDEX `Match_ID_idx` (`Match_ID` ASC) ,
  CONSTRAINT `Matches_Player_ID`
    FOREIGN KEY (`Player_ID` )
    REFERENCES `MDCL`.`Players` (`Player_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Matches_Match_ID`
    FOREIGN KEY (`Match_ID` )
    REFERENCES `MDCL`.`MatchData` (`Match_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Abilities`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Abilities` (
  `Ability_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Ability_Name` VARCHAR(45) NULL ,
  `Type` INT NULL ,
  `Race_ID` TINYINT NULL ,
  `Energy_Cost` INT NULL ,
  `Life_Ocst` INT NULL ,
  `Mineral_Cost` INT NULL ,
  `Vespene_Cost` INT NULL ,
  `Patch_ID` INT NULL ,
  PRIMARY KEY (`Ability_ID`) ,
  INDEX `Abilities_Patch_ID` (`Patch_ID` ASC) ,
  INDEX `Abilities_Race_ID` (`Race_ID` ASC) ,
  CONSTRAINT `Abilities_Patch_ID`
    FOREIGN KEY (`Patch_ID` )
    REFERENCES `MDCL`.`Patches` (`Patch_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Abilities_Race_ID`
    FOREIGN KEY (`Race_ID` )
    REFERENCES `MDCL`.`Races` (`Race_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Units`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Units` (
  `Unit_Type` BIGINT NOT NULL AUTO_INCREMENT ,
  `Patch_ID` INT NULL ,
  `Unit_Name` VARCHAR(45) NULL ,
  `Unit_ID` VARCHAR(45) NULL ,
  `Race_ID` TINYINT NULL ,
  `Mineral_Cost` INT NULL ,
  `Vespene_Cost` INT NULL ,
  `Supply_Cost` FLOAT NULL ,
  `Supplies_Made` FLOAT NULL ,
  `Life` INT NULL ,
  `Life_Regen` FLOAT NULL ,
  `Life_Armor` INT NULL ,
  `Shields` INT NULL ,
  `Shield_Regen` FLOAT NULL ,
  `Shield_Armor` INT NULL ,
  `Starting_Energy` INT NULL ,
  `Energy` INT NULL ,
  `Energy_Regen` FLOAT NULL ,
  `Speed` FLOAT NULL ,
  `Creep_Speed` FLOAT NULL ,
  `Acceleration` FLOAT NULL ,
  `Turning_Rate` FLOAT NULL ,
  `Radius` FLOAT NULL ,
  `Mover` VARCHAR(45) NULL ,
  `Footprint` VARCHAR(45) NULL ,
  `Sight_Radius` FLOAT NULL ,
  `Unit_or_Structure` TINYINT(1) NULL ,
  `Summoned` TINYINT(1) NULL ,
  PRIMARY KEY (`Unit_Type`) ,
  INDEX `Patch_ID_idx` (`Patch_ID` ASC) ,
  INDEX `Race_ID_idx` (`Race_ID` ASC) ,
  CONSTRAINT `Units_Patch_ID`
    FOREIGN KEY (`Patch_ID` )
    REFERENCES `MDCL`.`Patches` (`Patch_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Units_Race_ID`
    FOREIGN KEY (`Race_ID` )
    REFERENCES `MDCL`.`Races` (`Race_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`UnitData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`UnitData` (
  `Entry_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Unit_ID` BIGINT NULL ,
  `Unit_Type` BIGINT NULL ,
  `Unit_Owner` BIGINT NULL ,
  `Combat_Efficiency` INT NULL ,
  `Kills` INT NULL ,
  `Kills_Mineral_Value` INT NULL ,
  `Kills_Vespene_Value` INT NULL ,
  PRIMARY KEY (`Entry_ID`) ,
  INDEX `Unit_Owner_idx` (`Unit_Owner` ASC) ,
  INDEX `Unit_Type_idx` (`Unit_Type` ASC) ,
  CONSTRAINT `UnitData_Unit_Owner`
    FOREIGN KEY (`Unit_Owner` )
    REFERENCES `MDCL`.`PlayerData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `UnitData_Unit_Type`
    FOREIGN KEY (`Unit_Type` )
    REFERENCES `MDCL`.`Units` (`Unit_Type` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`Upgrades`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`Upgrades` (
  `Upgrade_ID` BIGINT NOT NULL AUTO_INCREMENT ,
  `Upgrade_Name` VARCHAR(45) NULL ,
  `Type` INT NULL ,
  `Race_ID` TINYINT NULL ,
  `Mineral_Cost` INT NULL ,
  `Vespene_Cost` INT NULL ,
  `Patch_ID` INT NULL ,
  PRIMARY KEY (`Upgrade_ID`) ,
  INDEX `Pathc_ID_idx` (`Patch_ID` ASC) ,
  INDEX `Race_ID_idx` (`Race_ID` ASC) ,
  CONSTRAINT `Upgrades_Patch_ID`
    FOREIGN KEY (`Patch_ID` )
    REFERENCES `MDCL`.`Patches` (`Patch_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Upgrades_Race_ID`
    FOREIGN KEY (`Race_ID` )
    REFERENCES `MDCL`.`Races` (`Race_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`AbilityData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`AbilityData` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Ability_Type` BIGINT NULL ,
  `Unit_ID` BIGINT NULL ,
  `Source_Location_X` FLOAT NULL ,
  `Source_Location_Y` FLOAT NULL ,
  `Target_Location_X` FLOAT NULL ,
  `Target_Location_Y` FLOAT NULL ,
  `Distance_Between_Targets` FLOAT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Ability_Type_idx` (`Ability_Type` ASC) ,
  INDEX `Unit_ID_idx` (`Unit_ID` ASC) ,
  CONSTRAINT `Ability_Type`
    FOREIGN KEY (`Ability_Type` )
    REFERENCES `MDCL`.`Abilities` (`Ability_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Ability_Unit_ID`
    FOREIGN KEY (`Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`ResearchData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`ResearchData` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Progress` INT NULL ,
  `Upgrade_Type` BIGINT NULL ,
  `Unit_ID` BIGINT NULL ,
  `Location_X` FLOAT NULL ,
  `Location_Y` FLOAT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Upgrade_Type_idx` (`Upgrade_Type` ASC) ,
  INDEX `Unit_ID_idx` (`Unit_ID` ASC) ,
  CONSTRAINT `ResearchData_Upgrade_Type`
    FOREIGN KEY (`Upgrade_Type` )
    REFERENCES `MDCL`.`Upgrades` (`Upgrade_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `ResearchData_Unit_ID`
    FOREIGN KEY (`Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`BuildData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`BuildData` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Progress` INT NULL ,
  `Source_Unit_ID` BIGINT NULL ,
  `Location_X` FLOAT NULL ,
  `Location_Y` FLOAT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Source_Unit_ID_idx` (`Source_Unit_ID` ASC) ,
  CONSTRAINT `BuildData_Source_Unit_ID`
    FOREIGN KEY (`Source_Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`BirthData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`BirthData` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Unit_ID` BIGINT NULL ,
  `Location_X` FLOAT NULL ,
  `Location_Y` FLOAT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Unit_ID_idx` (`Unit_ID` ASC) ,
  CONSTRAINT `BirthData_Unit_ID`
    FOREIGN KEY (`Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`DeathData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`DeathData` (
  `Index` BIGINT NOT NULL AUTO_INCREMENT ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Triggering_Unit_ID` BIGINT NULL ,
  `Triggering_Unit_Location_X` FLOAT NULL ,
  `Triggering_Unit_Location_Y` FLOAT NULL ,
  `Killing_Unit_ID` BIGINT NULL ,
  `Killing_Unit_Location_X` FLOAT NULL ,
  `Killing_Unit_Location_Y` FLOAT NULL ,
  `Distance_Between_Units` FLOAT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `Triggering_Unit_ID_idx` (`Triggering_Unit_ID` ASC) ,
  INDEX `Killing_Unit_ID_idx` (`Killing_Unit_ID` ASC) ,
  CONSTRAINT `DeathData_Triggering_Unit_ID`
    FOREIGN KEY (`Triggering_Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `DeathData_Killing_Unit_ID`
    FOREIGN KEY (`Killing_Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `MDCL`.`IdleData`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `MDCL`.`IdleData` (
  `Index` BIGINT NOT NULL ,
  `Event_ID` INT NULL ,
  `Event_Time` FLOAT NULL ,
  `Unit_ID` BIGINT NULL ,
  `Is_Idle` TINYINT(1) NULL ,
  `Location_X` FLOAT NULL ,
  `Location_Y` FLOAT NULL ,
  PRIMARY KEY (`Index`) ,
  INDEX `IdleData_Unit_ID_idx` (`Unit_ID` ASC) ,
  CONSTRAINT `IdleData_Unit_ID`
    FOREIGN KEY (`Unit_ID` )
    REFERENCES `MDCL`.`UnitData` (`Entry_ID` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `MDCL`.`Races`
-- -----------------------------------------------------
START TRANSACTION;
USE `MDCL`;
INSERT INTO `MDCL`.`Races` (`Race_ID`, `Race_Name`) VALUES (1, 'Random');
INSERT INTO `MDCL`.`Races` (`Race_ID`, `Race_Name`) VALUES (2, 'Protoss');
INSERT INTO `MDCL`.`Races` (`Race_ID`, `Race_Name`) VALUES (3, 'Terran');
INSERT INTO `MDCL`.`Races` (`Race_ID`, `Race_Name`) VALUES (4, 'Zerg');
INSERT INTO `MDCL`.`Races` (`Race_ID`, `Race_Name`) VALUES (5, 'Neutral');

COMMIT;

-- -----------------------------------------------------
-- Data for table `MDCL`.`Players`
-- -----------------------------------------------------
START TRANSACTION;
USE `MDCL`;
INSERT INTO `MDCL`.`Players` (`Player_ID`, `Bnet_ID`, `Player_Name`, `Best_Race`, `Wins_Lifetime`, `Losses_Lifetime`) VALUES (1, 'Neutral', 'Neutral', NULL, NULL, NULL);
INSERT INTO `MDCL`.`Players` (`Player_ID`, `Bnet_ID`, `Player_Name`, `Best_Race`, `Wins_Lifetime`, `Losses_Lifetime`) VALUES (2, 'Neutral Hostile', 'Neutral Hostile', NULL, NULL, NULL);

COMMIT;

-- -----------------------------------------------------
-- Data for table `MDCL`.`Modes`
-- -----------------------------------------------------
START TRANSACTION;
USE `MDCL`;
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (1, 'Custom', NULL, NULL);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (2, '1 v 1', 2, 1);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (3, '2 v 2', 4, 2);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (4, '3 v 3', 6, 3);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (5, '4 v 4', 8, 4);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (6, '5 v 5', 10, 5);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (7, '6 v 6', 12, 6);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (8, '7 v 7', 14, 7);
INSERT INTO `MDCL`.`Modes` (`Mode_ID`, `Mode_Name`, `Players_Allowed`, `Team_Size`) VALUES (9, 'Free for All', NULL, NULL);

COMMIT;
