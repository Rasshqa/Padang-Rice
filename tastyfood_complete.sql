/*M!999999\- enable the sandbox mode */ 

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*M!100616 SET @OLD_NOTE_VERBOSITY=@@NOTE_VERBOSITY, NOTE_VERBOSITY=0 */;
DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES
(1,'Administrator','admin@padangrice.com','$2y$12$REheeQmoCArDlcZd13j72.hi7lQneYXnfHzps30P/IMdk8UDFQcyy',NULL,'2026-10-08 18:38:32','2026-10-08 18:38:32');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint(20) NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `chat_messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `chat_messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` char(36) NOT NULL,
  `conversation_id` bigint(20) unsigned NOT NULL,
  `sender_id` bigint(20) unsigned NOT NULL,
  `sender_type` enum('user','admin','system') NOT NULL DEFAULT 'user',
  `message` text NOT NULL,
  `message_type` enum('text','system') NOT NULL DEFAULT 'text',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chat_messages_uuid_unique` (`uuid`),
  KEY `chat_messages_conversation_id_index` (`conversation_id`),
  KEY `chat_messages_sender_id_index` (`sender_id`),
  KEY `chat_messages_created_at_index` (`created_at`),
  KEY `chat_messages_is_read_index` (`is_read`),
  KEY `chat_messages_conversation_id_is_read_index` (`conversation_id`,`is_read`),
  CONSTRAINT `chat_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `chat_messages` DISABLE KEYS */;
INSERT INTO `chat_messages` VALUES
(1,'e91b8eda-da82-4d94-9077-3a4d42e9c9b3',1,0,'system','Pesanan #ORD1791484791 telah dibuat.','system',0,NULL,'2026-10-08 18:39:51','2026-10-08 18:39:51'),
(3,'c05a66fe-6142-477d-a8c9-9b95e22ac79f',1,0,'system','Pesanan #ORD1791484837 telah dibuat.','system',0,NULL,'2026-10-08 18:40:37','2026-10-08 18:40:37'),
(4,'e6d51d49-2ecd-4b43-a584-71e40232bedd',1,0,'system','Pesanan #ORD1791484857 telah dibuat.','system',0,NULL,'2026-10-08 18:40:57','2026-10-08 18:40:57'),
(5,'900c7bc9-c5c5-4613-a064-607ce2846b83',2,2,'user','hi','text',1,'2026-10-08 19:02:03','2026-10-08 19:01:19','2026-10-08 19:02:03'),
(6,'25bd2f95-c21d-40eb-b3d6-c48a3651f379',1,0,'system','Status pesanan #ORD1791484857 diubah menjadi Dikonfirmasi.','system',0,NULL,'2026-10-08 19:02:49','2026-10-08 19:02:49'),
(7,'79675256-c010-4488-9208-3952b7e0f916',1,0,'system','Status pesanan #ORD1791484857 diubah menjadi Diproses.','system',0,NULL,'2026-10-08 19:02:53','2026-10-08 19:02:53'),
(8,'de6ca4b3-aca6-48a8-95ef-112d3c8bd9fe',1,0,'system','Status pesanan #ORD1791484857 diubah menjadi Siap.','system',0,NULL,'2026-10-08 19:02:55','2026-10-08 19:02:55'),
(9,'3cebcd44-7692-4c5c-811d-88235dd5aea3',1,0,'system','Status pesanan #ORD1791484857 diubah menjadi Selesai.','system',0,NULL,'2026-10-08 19:02:57','2026-10-08 19:02:57'),
(10,'beec44fe-e15e-4077-8a31-4e820a9d6cd6',1,0,'system','Status pesanan #ORD1791484857 diubah menjadi Dibatalkan.','system',0,NULL,'2026-10-08 19:02:58','2026-10-08 19:02:58'),
(11,'328b8b41-5779-4f0a-aa65-ec7ca37bab45',2,0,'system','Pesanan #PR-20261009-0001 telah dibuat.','system',0,NULL,'2026-10-09 00:20:47','2026-10-09 00:20:47'),
(12,'fe4bd709-87e6-4c5a-977b-85fa8d8b487a',2,0,'system','Pesanan #PR-20261009-0002 telah dibuat.','system',0,NULL,'2026-10-09 00:24:19','2026-10-09 00:24:19'),
(13,'b871e7e3-a3d9-4154-8355-f662586a4edb',2,0,'system','Pesanan #PR-20261009-0003 telah dibuat.','system',0,NULL,'2026-10-09 00:35:10','2026-10-09 00:35:10'),
(14,'534a4567-1fed-4a40-8642-f52791f27be6',2,0,'system','Status pesanan #PR-20261009-0003 diubah menjadi Dikonfirmasi.','system',0,NULL,'2026-10-09 00:41:27','2026-10-09 00:41:27'),
(15,'7f25c75d-6d4b-4344-a95f-c7b1f260b798',2,0,'system','Status pesanan #PR-20261009-0003 diubah menjadi Siap.','system',0,NULL,'2026-10-09 00:41:33','2026-10-09 00:41:33'),
(16,'14011288-4ec4-48e4-aac5-1c4afc6359f7',2,0,'system','Status pesanan #PR-20261009-0003 diubah menjadi Selesai.','system',0,NULL,'2026-10-09 00:41:40','2026-10-09 00:41:40'),
(17,'ac47e225-52e8-447a-9b2e-706044a45056',2,0,'system','Status pesanan #PR-20261009-0003 diubah menjadi Selesai (Diterima User).','system',0,NULL,'2026-10-09 00:48:16','2026-10-09 00:48:16'),
(18,'f6e257ef-0a05-4536-b463-bc7beaf883dc',2,0,'system','Status pesanan #PR-20261009-0003 diubah menjadi Dalam Pengiriman / Selesai (Admin).','system',0,NULL,'2026-10-09 00:49:56','2026-10-09 00:49:56'),
(19,'8fba9ac6-f0e0-4b8a-973b-dbf1a23ff159',2,0,'system','Pesanan #PR-20261009-0004 telah dibuat.','system',0,NULL,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(20,'3986fd97-bc73-4e51-970f-cbc14f82cd32',2,0,'system','Status pesanan #PR-20261009-0004 diubah menjadi Dibatalkan.','system',0,NULL,'2026-10-09 01:12:00','2026-10-09 01:12:00'),
(21,'af49e057-41a6-414d-bf94-b7e0cbd9051f',2,0,'system','Status pesanan #PR-20261009-0004 diubah menjadi Dalam Pengiriman / Selesai (Admin).','system',0,NULL,'2026-10-09 01:12:02','2026-10-09 01:12:02'),
(22,'fd68f07b-fd22-4b2d-b472-84eff207fc52',2,0,'system','Status pesanan #PR-20261009-0004 diubah menjadi Menunggu Konfirmasi.','system',0,NULL,'2026-10-09 01:12:04','2026-10-09 01:12:04'),
(23,'32e939b3-bb83-451f-a9c5-de03497e64ff',2,0,'system','Pesanan #PR-20261009-0005 telah dibuat.','system',0,NULL,'2026-10-09 01:17:16','2026-10-09 01:17:16'),
(24,'91b92d54-8198-44ef-b320-5c0ea55ebfbb',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Dikonfirmasi.','system',0,NULL,'2026-10-09 01:17:55','2026-10-09 01:17:55'),
(25,'aa9fd8d2-ed82-416b-aa99-62a82f8c588a',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Diproses.','system',0,NULL,'2026-10-09 01:17:57','2026-10-09 01:17:57'),
(26,'3184382a-2b0a-4082-b565-b1b4478d6868',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Dalam Pengiriman / Selesai (Admin).','system',0,NULL,'2026-10-09 01:17:59','2026-10-09 01:17:59'),
(27,'1f535aa0-6879-4564-b798-8a13d09f279d',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Siap.','system',0,NULL,'2026-10-09 01:18:01','2026-10-09 01:18:01'),
(28,'762c96ad-695a-42dd-abd6-4f8bdee4801d',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Dalam Pengiriman / Selesai (Admin).','system',0,NULL,'2026-10-09 01:18:06','2026-10-09 01:18:06'),
(29,'a55c7e44-a8a5-4af2-865e-af1973204c64',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Diproses.','system',0,NULL,'2026-10-09 01:18:11','2026-10-09 01:18:11'),
(30,'c5581453-d3c6-4d27-852b-34d21c95383e',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Dikonfirmasi.','system',0,NULL,'2026-10-09 01:18:14','2026-10-09 01:18:14'),
(31,'326f9712-c5d5-4e73-ab6d-4f44f7dfb406',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Diproses.','system',0,NULL,'2026-10-09 01:18:15','2026-10-09 01:18:15'),
(32,'1adaccf3-66ae-45b6-aef3-d06a5d464599',2,0,'system','Status pesanan #PR-20261009-0005 diubah menjadi Siap.','system',0,NULL,'2026-10-09 01:18:16','2026-10-09 01:18:16'),
(33,'149e37fb-21f4-49af-b0bb-51f2e9af57ee',2,0,'system','Pesanan #PR-20261009-0006 telah dibuat.','system',0,NULL,'2026-10-09 01:29:02','2026-10-09 01:29:02'),
(34,'2b8d89bc-575c-4b72-acfd-af5dbf475e0a',2,0,'system','Status pesanan #PR-20261009-0006 diubah menjadi Dikonfirmasi.','system',0,NULL,'2026-10-09 01:29:40','2026-10-09 01:29:40'),
(35,'00778b84-959a-4791-879c-6990d16ca14b',2,0,'system','Pesanan #PR-20261009-0007 telah dibuat.','system',0,NULL,'2026-10-09 02:01:12','2026-10-09 02:01:12');
/*!40000 ALTER TABLE `chat_messages` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `order_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('open','closed') NOT NULL DEFAULT 'open',
  `last_message_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `conversations_order_id_foreign` (`order_id`),
  KEY `idx_conversations_user` (`user_id`),
  KEY `idx_conversations_last_msg` (`last_message_at`),
  KEY `idx_conversations_status` (`status`),
  CONSTRAINT `conversations_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE SET NULL,
  CONSTRAINT `conversations_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
INSERT INTO `conversations` VALUES
(1,1,1,'open','2026-10-08 19:02:58','2026-10-08 18:39:51','2026-10-08 19:02:58'),
(2,2,5,'open','2026-10-09 02:01:12','2026-10-08 19:01:16','2026-10-09 02:01:12'),
(3,3,NULL,'open','2026-10-08 19:35:02','2026-10-08 19:35:02','2026-10-08 19:35:02');
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `galleries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `galleries` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `galleries` DISABLE KEYS */;
INSERT INTO `galleries` VALUES
(1,'Gallery 1','assets/ASET/nasipadang-1.jpg','Beautiful food photography','food','active',0,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(2,'Gallery 2','assets/ASET/nasipadang-2.jpg','Beautiful food photography','food','active',1,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(3,'Gallery 3','assets/ASET/nasipadang-3.jpg','Beautiful food photography','food','active',2,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(4,'Gallery 4','assets/ASET/nasipadang-4.jpg','Beautiful food photography','food','active',3,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(5,'Gallery 5','assets/ASET/nasipadang-5.jpg','Beautiful food photography','food','active',4,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(6,'Gallery 6','assets/ASET/nasipadang-6.jpg','Beautiful food photography','food','active',5,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(7,'Gallery 7','assets/ASET/nasipadang-7.jpg','Beautiful food photography','food','active',6,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(8,'Gallery 8','assets/ASET/nasipadang-8.jpg','Beautiful food photography','food','active',7,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(9,'Gallery 9','assets/ASET/nasipadang-9.jpg','Beautiful food photography','food','active',8,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(10,'Gallery 10','assets/ASET/nasipadang-10.jpg','Beautiful food photography','food','active',9,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(11,'Gallery 11','assets/ASET/nasipadang-11.jpg','Beautiful food photography','food','active',10,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(12,'Gallery 12','assets/ASET/nasipadang-12.jpg','Beautiful food photography','food','active',11,'2026-10-08 18:38:33','2026-10-08 18:38:33');
/*!40000 ALTER TABLE `galleries` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint(5) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `menus` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category` enum('nasi','lauk','sayur','minuman') NOT NULL DEFAULT 'lauk',
  `available` tinyint(1) NOT NULL DEFAULT 1,
  `order_count` int(11) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES
(1,'Rendang Daging','Daging sapi empuk dengan bumbu rempah khas Minang',25000,'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400','lauk',1,1,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(2,'Gulai Ayam','Ayam dengan kuah gulai santan yang gurih',18000,'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?w=400','lauk',1,1,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(3,'Dendeng Balado','Dendeng sapi kering dengan sambal balado pedas',22000,'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=400','lauk',1,7,0,'2026-10-08 18:38:33','2026-10-09 02:01:12'),
(4,'Gulai Ikan Kakap','Ikan kakap segar dalam kuah gulai kuning',20000,'https://images.unsplash.com/photo-1580959375944-6f57f0c2e398?w=400','lauk',1,1,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(5,'Ayam Pop','Ayam goreng pucat khas Padang yang gurih',19000,'https://images.unsplash.com/photo-1626082927389-6cd097cdc6ec?w=400','lauk',1,6,0,'2026-10-08 18:38:33','2026-10-09 02:01:12'),
(6,'Sambal Hijau','Sambal cabai hijau dengan ikan teri',8000,'https://images.unsplash.com/photo-1596797038530-2c107229654b?w=400','sayur',1,0,0,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(7,'Gulai Cubadak','Nangka muda masak gulai santan',10000,'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=400','sayur',1,1,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(8,'Gulai Daun Singkong','Daun singkong berkuah santan pedas',9000,'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=400','sayur',1,1,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(9,'Terong Balado','Terong goreng dengan sambal balado',10000,'https://images.unsplash.com/photo-1607532941433-304659e8198a?w=400','sayur',1,0,0,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(10,'Nasi Putih','Nasi putih pulen',5000,'https://images.unsplash.com/photo-1536304993881-ff6e9eefa2a6?w=400','nasi',1,1,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(11,'Es Teh Manis','Teh manis dingin segar',5000,'https://images.unsplash.com/photo-1558160074-4d7d8bdf4256?w=400','minuman',1,2,0,'2026-10-08 18:38:33','2026-10-09 01:29:02'),
(12,'Es Jeruk','Jus jeruk segar dengan es',7000,'https://images.unsplash.com/photo-1600271886742-f049cd451bba?w=400','minuman',1,2,0,'2026-10-08 18:38:33','2026-10-09 00:57:17'),
(13,'Teh Talua','Teh khas Padang dengan kuning telur',12000,'https://images.unsplash.com/photo-1564890369478-c89ca6d9cde9?w=400','minuman',1,0,0,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(14,'Air Mineral','Air mineral botol 600ml',4000,'https://images.unsplash.com/photo-1523362628745-0c100150b504?w=400','minuman',1,5,0,'2026-10-08 18:38:33','2026-10-09 02:01:12');
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_01_01_000001_create_tastyfood_tables',1),
(5,'2025_01_02_000001_create_menus_tables',1),
(6,'2026_10_06_082723_add_popular_count_to_menus_table',1),
(7,'2026_10_06_082756_add_location_to_orders_table',1),
(8,'2026_10_07_100001_add_phone_and_role_to_users_table',1),
(9,'2026_10_07_100002_add_user_id_to_orders_table',1),
(10,'2026_10_07_100003_create_payment_methods_table',1),
(11,'2026_10_07_100004_create_payments_table',1),
(12,'2026_10_08_154256_create_conversations_table',1),
(13,'2026_10_08_154257_create_messages_table',1),
(14,'2026_10_09_004740_add_completed_to_status_in_orders_table',2),
(16,'2026_10_09_032322_update_orders_status_enum_add_in_transit',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `content` text NOT NULL,
  `author` varchar(255) NOT NULL,
  `status` enum('draft','published') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES
(1,'APA SAJA MAKANAN KHAS NUSANTARA?','apa-saja-makanan-khas-nusantara','assets/ASET/nasipadang-hero.jpg','Makanan khas Nusantara sangat beragam, dari Sabang sampai Merauke. Setiap daerah memiliki cita rasa unik yang diwariskan turun temurun. Nasi Padang, rendang, soto, gado-gado, dan sate adalah beberapa contoh kuliner Indonesia yang terkenal hingga mancanegara. Kekayaan rempah Nusantara membuat setiap hidangan memiliki aroma dan rasa yang khas.','Admin','published','2026-10-08 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(2,'RESEP RENDANG AUTENTIK','resep-rendang-autentik-2','assets/ASET/nasipadang-1.jpg','Rendang adalah masakan daging bercita rasa pedas yang menggunakan campuran berbagai bumbu dan rempah-rempah. Masakan ini dihasilkan dari proses memasak yang dipanaskan berulang-ulang dengan santan kelapa.','Admin','published','2026-10-08 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(3,'SEJARAH NASI PADANG','sejarah-nasi-padang-3','assets/ASET/nasipadang-2.jpg','Nasi Padang berasal dari Sumatera Barat dan kini menjadi salah satu kuliner Indonesia yang paling terkenal. Cita rasanya yang kaya rempah dan cara penyajiannya yang unik menjadi daya tarik tersendiri.','Admin','published','2026-10-07 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(4,'GULAI IKAN KHAS MINANG','gulai-ikan-khas-minang-4','assets/ASET/nasipadang-3.jpg','Gulai ikan adalah masakan berkuah santan dengan rempah-rempah pilihan. Ikan yang digunakan biasanya ikan laut segar yang dimasak dengan bumbu khas Minangkabau hingga meresap sempurna.','Admin','published','2026-10-06 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(5,'DENDENG BALADO PEDAS','dendeng-balado-pedas-5','assets/ASET/nasipadang-4.jpg','Dendeng balado adalah daging sapi yang diiris tipis, dikeringkan, kemudian digoreng dan dicampur dengan sambal balado yang pedas. Cocok sebagai lauk atau cemilan.','Admin','published','2026-10-05 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(6,'SAMBAL HIJAU KHAS PADANG','sambal-hijau-khas-padang-6','assets/ASET/nasipadang-5.jpg','Sambal hijau terbuat dari cabai hijau besar yang diulek dengan bawang dan tomat. Rasanya pedas segar dengan aroma cabai hijau yang khas, sempurna menemani nasi hangat.','Admin','published','2026-10-04 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(7,'SATE PADANG KUAH KUNING','sate-padang-kuah-kuning-7','assets/ASET/nasipadang-6.jpg','Sate Padang berbeda dari sate lainnya karena menggunakan kuah kuning kental dari tepung beras dan bumbu rempah. Dagingnya empuk dengan cita rasa gurih pedas yang menggugah selera.','Admin','published','2026-10-03 18:38:33','2026-10-08 18:38:33','2026-10-08 18:38:33');
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `menu_id` bigint(20) unsigned DEFAULT NULL,
  `menu_name` varchar(255) NOT NULL,
  `menu_price` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_menu_id_foreign` (`menu_id`),
  CONSTRAINT `order_items_menu_id_foreign` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE SET NULL,
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` VALUES
(1,5,5,'Ayam Pop',19000,1,19000,'2026-10-09 00:20:47','2026-10-09 00:20:47'),
(2,5,3,'Dendeng Balado',22000,1,22000,'2026-10-09 00:20:47','2026-10-09 00:20:47'),
(3,5,14,'Air Mineral',4000,1,4000,'2026-10-09 00:20:47','2026-10-09 00:20:47'),
(4,5,12,'Es Jeruk',7000,1,7000,'2026-10-09 00:20:47','2026-10-09 00:20:47'),
(5,6,14,'Air Mineral',4000,1,4000,'2026-10-09 00:24:19','2026-10-09 00:24:19'),
(6,7,3,'Dendeng Balado',22000,1,22000,'2026-10-09 00:35:10','2026-10-09 00:35:10'),
(7,7,5,'Ayam Pop',19000,1,19000,'2026-10-09 00:35:10','2026-10-09 00:35:10'),
(8,8,5,'Ayam Pop',19000,1,19000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(9,8,14,'Air Mineral',4000,1,4000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(10,8,12,'Es Jeruk',7000,1,7000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(11,8,11,'Es Teh Manis',5000,1,5000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(12,8,2,'Gulai Ayam',18000,1,18000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(13,8,3,'Dendeng Balado',22000,1,22000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(14,8,7,'Gulai Cubadak',10000,1,10000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(15,8,8,'Gulai Daun Singkong',9000,1,9000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(16,8,4,'Gulai Ikan Kakap',20000,1,20000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(17,8,10,'Nasi Putih',5000,1,5000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(18,8,1,'Rendang Daging',25000,1,25000,'2026-10-09 00:57:17','2026-10-09 00:57:17'),
(19,9,5,'Ayam Pop',19000,1,19000,'2026-10-09 01:17:16','2026-10-09 01:17:16'),
(20,9,3,'Dendeng Balado',22000,2,44000,'2026-10-09 01:17:16','2026-10-09 01:17:16'),
(21,10,5,'Ayam Pop',19000,1,19000,'2026-10-09 01:29:02','2026-10-09 01:29:02'),
(22,10,14,'Air Mineral',4000,1,4000,'2026-10-09 01:29:02','2026-10-09 01:29:02'),
(23,10,3,'Dendeng Balado',22000,1,22000,'2026-10-09 01:29:02','2026-10-09 01:29:02'),
(24,10,11,'Es Teh Manis',5000,1,5000,'2026-10-09 01:29:02','2026-10-09 01:29:02'),
(25,11,14,'Air Mineral',4000,1,4000,'2026-10-09 02:01:12','2026-10-09 02:01:12'),
(26,11,5,'Ayam Pop',19000,1,19000,'2026-10-09 02:01:12','2026-10-09 02:01:12'),
(27,11,3,'Dendeng Balado',22000,1,22000,'2026-10-09 02:01:12','2026-10-09 02:01:12');
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `order_number` varchar(255) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(255) NOT NULL,
  `delivery_method` enum('pickup','delivery') NOT NULL DEFAULT 'pickup',
  `delivery_address` text DEFAULT NULL,
  `status` enum('pending','confirmed','preparing','ready','in_transit','delivered','completed','cancelled') NOT NULL DEFAULT 'pending',
  `subtotal` int(11) NOT NULL,
  `delivery_fee` int(11) NOT NULL DEFAULT 0,
  `total` int(11) NOT NULL,
  `notes` text DEFAULT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_user_id_foreign` (`user_id`),
  CONSTRAINT `orders_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
INSERT INTO `orders` VALUES
(1,1,'ORD1791484791','Customer Test','customer@test.com','081234567890','delivery','Test Address','pending',50000,10000,60000,NULL,NULL,NULL,'2026-10-08 18:39:51','2026-10-08 18:39:51'),
(3,1,'ORD1791484837','Customer Test','customer@test.com','081234567890','delivery','Test Address','pending',50000,10000,60000,NULL,NULL,NULL,'2026-10-08 18:40:37','2026-10-08 18:40:37'),
(4,1,'ORD1791484857','Customer Test','customer@test.com','081234567890','delivery','Test Address','cancelled',50000,10000,60000,NULL,NULL,NULL,'2026-10-08 18:40:57','2026-10-08 19:02:58'),
(5,2,'PR-20261009-0001','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','pickup',NULL,'pending',52000,0,52000,NULL,NULL,NULL,'2026-10-09 00:20:47','2026-10-09 00:20:47'),
(6,2,'PR-20261009-0002','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','pickup',NULL,'pending',4000,0,4000,NULL,NULL,NULL,'2026-10-09 00:24:19','2026-10-09 00:24:19'),
(7,2,'PR-20261009-0003','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','delivery','Gegerkalong, Sukasari, Bandung City, West Java, 40154, Indonesia','delivered',41000,33250,74250,NULL,-6.8648960,107.5904512,'2026-10-09 00:35:10','2026-10-09 00:49:56'),
(8,2,'PR-20261009-0004','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','delivery','Gegerkalong, Sukasari, Bandung City, West Java, 40154, Indonesia','pending',144000,0,144000,NULL,-6.8648960,107.5904512,'2026-10-09 00:57:17','2026-10-09 01:12:04'),
(9,2,'PR-20261009-0005','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','delivery','Gegerkalong, Sukasari, Bandung City, West Java, 40154, Indonesia','ready',63000,33250,96250,NULL,-6.8648960,107.5904512,'2026-10-09 01:17:16','2026-10-09 01:18:16'),
(10,2,'PR-20261009-0006','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','delivery','Gegerkalong, Sukasari, Bandung City, West Java, 40154, Indonesia','confirmed',50000,33250,83250,NULL,-6.8648960,107.5904512,'2026-10-09 01:29:02','2026-10-09 01:29:40'),
(11,2,'PR-20261009-0007','Rashqa Andrean Fitrah Sulaeman_SMKN 1 CIANJUR_1130','rashqaandrean@gmail.com','085723894370','delivery','Gegerkalong, Sukasari, Bandung City, West Java, 40154, Indonesia','pending',45000,33250,78250,NULL,-6.8648960,107.5904512,'2026-10-09 02:01:12','2026-10-09 02:01:12');
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `payment_methods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payment_methods` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` enum('bank_transfer','qr_payment','e_wallet','cash') NOT NULL DEFAULT 'bank_transfer',
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(255) DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `payment_methods` DISABLE KEYS */;
INSERT INTO `payment_methods` VALUES
(1,'BCA','bank_transfer','Padang Rice','1234567890',NULL,'Transfer ke rekening BCA dan upload bukti pembayaran',1,'2026-10-08 18:38:33','2026-10-08 18:38:33',NULL),
(2,'Mandiri','bank_transfer','Padang Rice','9876543210',NULL,'Transfer ke rekening Mandiri dan upload bukti pembayaran',1,'2026-10-08 18:38:33','2026-10-08 18:38:33',NULL),
(3,'QRIS','qr_payment',NULL,NULL,'payment-qr-codes/KDGJw8aOGqPoDrXupwkPb2wjIXMhn2VoEdcfKcmI.png','Scan QR Code dan upload bukti pembayaran',1,'2026-10-08 18:38:33','2026-10-09 01:16:39',NULL),
(4,'DANA','e_wallet',NULL,'081234567890',NULL,'Transfer ke DANA 081234567890 dan upload bukti',1,'2026-10-08 18:38:33','2026-10-08 18:38:33',NULL),
(5,'OVO','e_wallet',NULL,'081234567890',NULL,'Transfer ke OVO 081234567890 dan upload bukti',1,'2026-10-08 18:38:33','2026-10-08 18:38:33',NULL);
/*!40000 ALTER TABLE `payment_methods` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) unsigned NOT NULL,
  `payment_method_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `amount` int(11) NOT NULL,
  `status` enum('unpaid','waiting_verification','paid','rejected','expired') NOT NULL DEFAULT 'unpaid',
  `proof_image` varchar(255) DEFAULT NULL,
  `user_notes` text DEFAULT NULL,
  `rejection_reason` text DEFAULT NULL,
  `verified_by` bigint(20) unsigned DEFAULT NULL,
  `verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payments_order_id_foreign` (`order_id`),
  KEY `payments_payment_method_id_foreign` (`payment_method_id`),
  KEY `payments_user_id_foreign` (`user_id`),
  KEY `payments_verified_by_foreign` (`verified_by`),
  CONSTRAINT `payments_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `payments_payment_method_id_foreign` FOREIGN KEY (`payment_method_id`) REFERENCES `payment_methods` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_verified_by_foreign` FOREIGN KEY (`verified_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES
(1,4,1,1,60000,'paid','payment-proofs/CH9bI9DrfTJJSaOJTir4QDZWssVUXi0UAmP8s1BQ.jpg',NULL,NULL,1,'2026-10-08 19:02:49','2026-10-08 18:40:57','2026-10-08 19:02:49'),
(2,6,3,2,4000,'unpaid',NULL,NULL,NULL,NULL,NULL,'2026-10-09 00:29:05','2026-10-09 00:29:05'),
(3,7,1,2,74250,'paid','payment-proofs/GBoUU74xuS4CofzEbRwTLMVjeDXkeEfmpVi8bmJT.jpg',NULL,NULL,1,'2026-10-09 00:41:27','2026-10-09 00:38:37','2026-10-09 00:41:27'),
(4,8,4,2,144000,'waiting_verification','payment-proofs/NaSJMmyMrtpfqiUm8AaEwg3gO0VRdLgSQ4BfNiOZ.webp',NULL,NULL,NULL,NULL,'2026-10-09 00:57:22','2026-10-09 00:57:27'),
(5,9,3,2,96250,'paid','payment-proofs/LVg3iLE0Yj0aMapKdjgdZWFUsIfM11fol8wEJdEn.jpg',NULL,NULL,1,'2026-10-09 01:17:55','2026-10-09 01:17:20','2026-10-09 01:17:55'),
(6,10,4,2,83250,'paid','payment-proofs/S3ijChGqCV0RoOItZ2FazhooyF7WjobxhfojeZUv.jpg',NULL,NULL,1,'2026-10-09 01:29:40','2026-10-09 01:29:08','2026-10-09 01:29:40'),
(7,11,3,2,78250,'waiting_verification','payment-proofs/g6sQdJKJaFyXoJetV31w5kYy90L04Qn14xLHHvtj.jpg',NULL,NULL,NULL,NULL,'2026-10-09 02:01:18','2026-10-09 02:01:23');
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES
('6oinNK12E6KjkyNzmFg7ZtvFNBEvuHpdGtmV3twa',2,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36','eyJfdG9rZW4iOiJNYlM5SGtZTUhSaVNDVEVaY29YejhKZ0lnQnYxRkpzclZTWGFBQ0NRIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwXC9wcm9maWxlIiwicm91dGUiOiJwcm9maWxlLnNob3cifSwiX2ZsYXNoIjp7Im9sZCI6W10sIm5ldyI6W119LCJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MiwicGFzc3dvcmRfaGFzaF93ZWIiOiI3YjU0NWY3ZTZjNWU0MWViYzI1ZjhhOWQyN2NjNTg0YmY3YzUwM2ZkYmJlNmI2NzM0M2ZiYjNhYjg2Zjc4MGE2IiwidXJsIjpbXSwibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI6MSwicGFzc3dvcmRfaGFzaF9hZG1pbiI6IjRjNDg3MGU1NzM1MWU4MmIxM2ExMTA3ZjY3ODFjMmI0ZGU0MmMzYTE1YTEzN2NiZjcwMzU2MGQxNTE0ZTNmOWMifQ==',1791511105),
('t6yayJ4d8JPXCjmmdbhsTwNIg3auIWeFc3JAHezS',2,'127.0.0.1','Mozilla/5.0 (iPhone; CPU iPhone OS 18_5 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/18.5 Mobile/15E148 Safari/604.1','eyJfdG9rZW4iOiJNNUYyaHdCV29walN2QVNVUUdnOE9aNFNVSkVEY0RvUzZyb1BEdGhNIiwiX2ZsYXNoIjp7Im5ldyI6W10sIm9sZCI6W119LCJfcHJldmlvdXMiOnsidXJsIjoiaHR0cDpcL1wvbG9jYWxob3N0OjgwMDBcL2FwaVwvY2hhdFwvMlwvbWVzc2FnZXMiLCJyb3V0ZSI6ImNoYXQubWVzc2FnZXMifSwibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiOjIsInBhc3N3b3JkX2hhc2hfd2ViIjoiN2I1NDVmN2U2YzVlNDFlYmMyNWY4YTlkMjdjYzU4NGJmN2M1MDNmZGJiZTZiNjczNDNmYmIzYWI4NmY3ODBhNiJ9',1791511316),
('wntAsHXIHZjVVYf9NpJAeNl8ao9F2yD4MRcAD8b7',NULL,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Code/1.138.0 Chrome/148.0.7778.280 Electron/42.10.0 Safari/537.36','eyJfdG9rZW4iOiIzS2o2VG45YWpTaWxBMVNwNVJneWdTR21EM2lRM29zRlRFSzV1amRCIiwiX3ByZXZpb3VzIjp7InVybCI6Imh0dHA6XC9cLzEyNy4wLjAuMTo4MDAwIiwicm91dGUiOiJob21lIn0sIl9mbGFzaCI6eyJvbGQiOltdLCJuZXciOltdfX0=',1791511104);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_setting_key_unique` (`setting_key`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'site_name','PADANG RICE','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(2,'site_description','Restoran Padang Rice menyajikan hidangan khas Minangkabau dengan cita rasa autentik. Nikmati kelezatan rendang, gulai, sambal hijau, dan berbagai menu Padang lainnya yang menggugah selera.','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(3,'email','padangrice@gmail.com','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(4,'phone','+62 812 3456 7890','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(5,'location','Kota Bandung, Jawa Barat','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(6,'contact_latitude','-6.9175','2026-10-08 18:38:33','2026-10-08 18:38:33'),
(7,'contact_longitude','107.6191','2026-10-08 18:38:33','2026-10-08 18:38:33');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'customer',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT, @@AUTOCOMMIT=0;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,'Customer Test','customer@test.com','081234567890','customer',NULL,'$2y$12$JKKBA4nb12311resQU3pD.IVg1hYVm49l7VQhgZbBdCuBYdk4if2q',NULL,'2026-10-08 18:38:33','2026-10-08 18:38:33'),
(2,'Rashqa Andrean Fitrah Sulaeman','rashqaandrean@gmail.com','085723894370','customer',NULL,'$2y$12$DF/HKaT/.BeI6RwdB5mIqOtL.er8ZJMx5LpTluiIxl1s6495CkDjW','WfMl6bUhpP40DZtSpgp1lMsaMie7PvOiq4kRYwJO4CgvwgpY3jFTb9tNpqDj','2026-10-08 19:01:10','2026-10-09 01:50:37'),
(3,'rashqa Andrean','rashqaanti8@gmail.com','085723894370','customer',NULL,'$2y$12$qnfJA1.ugnBCA/fOYu5V/OwwM1MILVxW6odgAFFl2Ldg.Dam16SgS',NULL,'2026-10-08 19:33:28','2026-10-08 19:33:28');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
COMMIT;
SET AUTOCOMMIT=@OLD_AUTOCOMMIT;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*M!100616 SET NOTE_VERBOSITY=@OLD_NOTE_VERBOSITY */;

