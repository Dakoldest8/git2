-- MySQL dump 10.13  Distrib 8.0.43, for Win64 (x86_64)
--
-- Host: localhost    Database: cards
-- ------------------------------------------------------
-- Server version	8.0.43

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cards` (
  `card_id` int NOT NULL AUTO_INCREMENT,
  `card_name` varchar(100) NOT NULL,
  `card_type` varchar(50) NOT NULL,
  `attribute` varchar(50) NOT NULL,
  `stars` tinyint unsigned DEFAULT NULL,
  `atk` int unsigned DEFAULT NULL,
  `def` int unsigned DEFAULT NULL,
  `description` text,
  `rarity` varchar(50) NOT NULL,
  `release_date` date NOT NULL,
  PRIMARY KEY (`card_id`),
  CONSTRAINT `chk_stars` CHECK (((`stars` is null) or (`stars` between 0 and 18)))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cards`
--

LOCK TABLES `cards` WRITE;
/*!40000 ALTER TABLE `cards` DISABLE KEYS */;
INSERT INTO `cards` VALUES (1,'Dark Magician','Monster','Dark',7,2500,2100,'The ultimate wizard in terms of attack and defense.','UR','1999-03-08'),(2,'Blue-Eyes White Dragon','Monster','Light',8,3000,2500,'This legendary dragon is a powerful engine of destruction.','UR','1999-03-08'),(3,'Red-Eyes Black Dragon','Monster','Dark',7,2400,2000,'A ferocious dragon with a deadly attack.','SR','1999-03-10'),(4,'Mystical Space Typhoon','Spell','None',NULL,NULL,NULL,'Destroys one spell/trap card on the field.','R','2000-05-12'),(5,'Mirror Force','Trap','None',NULL,NULL,NULL,'Destroys all attack position monsters your opponent controls.','UR','2000-06-01'),(6,'Exodia the Forbidden One','Monster','Dark',3,1000,1000,'Collect all five pieces to win the duel.','UR','1999-04-01'),(7,'Summoned Skull','Monster','Dark',6,2500,1200,'A fiend with dark powers for confusing the enemy.','SR','1999-03-15'),(8,'Pot of Greed','Spell','None',NULL,NULL,NULL,'Draw 2 cards from your deck.','R','1999-03-20'),(9,'Celtic Guardian','Monster','Earth',4,1400,1200,'A warrior with high defense.','C','1999-03-22'),(10,'Time Wizard','Monster','Light',2,500,400,'A wizard that can manipulate time.','R','1999-03-25');
/*!40000 ALTER TABLE `cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `deck_cards`
--

DROP TABLE IF EXISTS `deck_cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `deck_cards` (
  `deck_id` int NOT NULL,
  `card_id` int NOT NULL,
  `quantity` tinyint unsigned NOT NULL DEFAULT '1',
  `card_role` varchar(50) DEFAULT NULL,
  `note` text,
  PRIMARY KEY (`deck_id`,`card_id`),
  KEY `fk_deck_cards_card` (`card_id`),
  CONSTRAINT `fk_deck_cards_card` FOREIGN KEY (`card_id`) REFERENCES `cards` (`card_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_deck_cards_deck` FOREIGN KEY (`deck_id`) REFERENCES `decks` (`deck_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `chk_quantity` CHECK ((`quantity` between 1 and 60))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `deck_cards`
--

LOCK TABLES `deck_cards` WRITE;
/*!40000 ALTER TABLE `deck_cards` DISABLE KEYS */;
INSERT INTO `deck_cards` VALUES (1,1,3,'Main Deck','Starter'),(1,4,2,'Spell','Typhoon support'),(1,6,1,'Main Deck','Exodia piece'),(2,2,3,'Main Deck','Power dragons'),(2,7,2,'Main Deck','Fiend backup'),(3,3,2,'Main Deck','Aggro dragon'),(3,9,3,'Main Deck','Warrior backup'),(4,5,2,'Trap','Mirror Force backup'),(4,8,2,'Spell','Draw support'),(5,9,2,'Main Deck','Celtic Guardian'),(5,10,2,'Main Deck','Time Wizard fun'),(6,1,2,'Main Deck','Dark Magician backup'),(6,6,1,'Main Deck','Exodia piece'),(7,2,2,'Main Deck','Blue Eyes backup'),(7,3,2,'Main Deck','Red Eyes backup'),(8,5,1,'Trap','Mirror Force'),(8,8,2,'Spell','Pot of Greed'),(9,4,2,'Spell','Mystical Space Typhoon'),(9,8,3,'Spell','Pot of Greed'),(10,2,1,'Extra Deck','Extra copy');
/*!40000 ALTER TABLE `deck_cards` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `decks`
--

DROP TABLE IF EXISTS `decks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `decks` (
  `deck_id` int NOT NULL AUTO_INCREMENT,
  `deck_name` varchar(100) NOT NULL,
  `player_id` int NOT NULL,
  `theme` varchar(100) NOT NULL,
  `creation_date` date NOT NULL,
  `format` varchar(50) NOT NULL,
  PRIMARY KEY (`deck_id`),
  KEY `fk_decks_player` (`player_id`),
  CONSTRAINT `fk_decks_player` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `decks`
--

LOCK TABLES `decks` WRITE;
/*!40000 ALTER TABLE `decks` DISABLE KEYS */;
INSERT INTO `decks` VALUES (1,'Yugi\'s Dark Deck',1,'Dark Spellcaster','2023-01-02','Standard'),(2,'Kaiba\'s Dragon Deck',2,'Dragon Power','2023-01-04','Standard'),(3,'Joey\'s Warrior Deck',3,'Warrior Boost','2023-01-06','Standard'),(4,'Mai\'s Harpie Deck',4,'Harpie Storm','2023-01-08','Standard'),(5,'Tea\'s Life Deck',5,'Support','2023-01-10','Standard'),(6,'Bakura\'s Evil Deck',7,'Dark Control','2023-01-14','Standard'),(7,'Mokuba\'s Blue Deck',8,'Dragon Allies','2023-01-16','Standard'),(8,'Pegasus\' Toon Deck',9,'Toon Madness','2023-01-18','Standard'),(9,'Maximillion\'s Mill Deck',10,'Mill Strategy','2023-01-20','Standard'),(10,'Kaiba\'s Extra Deck',2,'Extra Dragons','2023-01-21','Advanced');
/*!40000 ALTER TABLE `decks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `players`
--

DROP TABLE IF EXISTS `players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `players` (
  `player_id` int NOT NULL AUTO_INCREMENT,
  `player_name` varchar(100) NOT NULL,
  `age` tinyint unsigned NOT NULL,
  `region` varchar(100) NOT NULL,
  `rank` varchar(50) NOT NULL,
  `join_date` date NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`player_id`),
  UNIQUE KEY `email` (`email`),
  CONSTRAINT `chk_age` CHECK ((`age` between 5 and 120))
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `players`
--

LOCK TABLES `players` WRITE;
/*!40000 ALTER TABLE `players` DISABLE KEYS */;
INSERT INTO `players` VALUES (1,'Yugi Muto',16,'JP','Master','2023-01-01','yugi@example.com'),(2,'Seto Kaiba',17,'JP','Master','2023-01-03','kaiba@example.com'),(3,'Joey Wheeler',16,'NA','Gold','2023-01-05','joey@example.com'),(4,'Mai Valentine',17,'EU','Platinum','2023-01-07','mai@example.com'),(5,'Tea Gardner',16,'JP','Silver','2023-01-09','tea@example.com'),(6,'Tristan Taylor',17,'NA','Bronze','2023-01-11','tristan@example.com'),(7,'Bakura Ryou',16,'JP','Diamond','2023-01-13','bakura@example.com'),(8,'Mokuba Kaiba',14,'JP','Gold','2023-01-15','mokuba@example.com'),(9,'Pegasus',45,'EU','Master','2023-01-17','pegasus@example.com'),(10,'Maximillion',30,'EU','Platinum','2023-01-19','maximillion@example.com');
/*!40000 ALTER TABLE `players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournament_players`
--

DROP TABLE IF EXISTS `tournament_players`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tournament_players` (
  `tournament_id` int NOT NULL,
  `player_id` int NOT NULL,
  `deck_id` int DEFAULT NULL,
  `placement` int unsigned DEFAULT NULL,
  `match_wins` int unsigned NOT NULL DEFAULT '0',
  `match_losses` int unsigned NOT NULL DEFAULT '0',
  `points` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tournament_id`,`player_id`),
  KEY `fk_tp_player` (`player_id`),
  KEY `fk_tp_deck` (`deck_id`),
  CONSTRAINT `fk_tp_deck` FOREIGN KEY (`deck_id`) REFERENCES `decks` (`deck_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `fk_tp_player` FOREIGN KEY (`player_id`) REFERENCES `players` (`player_id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT `fk_tp_tournament` FOREIGN KEY (`tournament_id`) REFERENCES `tournaments` (`tournament_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournament_players`
--

LOCK TABLES `tournament_players` WRITE;
/*!40000 ALTER TABLE `tournament_players` DISABLE KEYS */;
INSERT INTO `tournament_players` VALUES (1,1,1,1,3,0,9),(1,2,2,2,2,1,6),(1,3,3,3,1,2,3),(1,4,4,4,0,3,0),(2,5,5,1,3,0,9),(2,6,6,2,2,1,6),(2,7,7,3,1,2,3),(2,8,8,4,0,3,0),(3,9,9,1,3,0,9),(3,10,10,2,2,1,6);
/*!40000 ALTER TABLE `tournament_players` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tournaments`
--

DROP TABLE IF EXISTS `tournaments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tournaments` (
  `tournament_id` int NOT NULL AUTO_INCREMENT,
  `tournament_name` varchar(100) NOT NULL,
  `location` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `format` varchar(50) NOT NULL,
  `prize_pool` decimal(10,2) NOT NULL DEFAULT '0.00',
  `total_players` int unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`tournament_id`),
  CONSTRAINT `chk_dates` CHECK ((`end_date` >= `start_date`))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tournaments`
--

LOCK TABLES `tournaments` WRITE;
/*!40000 ALTER TABLE `tournaments` DISABLE KEYS */;
INSERT INTO `tournaments` VALUES (1,'Summer Showdown','New York','2023-06-01','2023-06-03','Standard',1000.00,8),(2,'Autumn Clash','Los Angeles','2023-09-10','2023-09-12','Advanced',1500.00,8),(3,'Winter Brawl','Chicago','2023-12-01','2023-12-03','Speed Duel',800.00,8);
/*!40000 ALTER TABLE `tournaments` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-03-20 13:08:32
