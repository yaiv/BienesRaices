-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: bienesraices_crud
-- ------------------------------------------------------
-- Server version	8.0.40

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
-- Table structure for table `propiedades`
--

DROP TABLE IF EXISTS `propiedades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `propiedades` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(45) DEFAULT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `imagen` varchar(200) DEFAULT NULL,
  `descripcion` longtext,
  `habitaciones` int DEFAULT NULL,
  `wc` int DEFAULT NULL,
  `estacionamiento` int DEFAULT NULL,
  `creado` date DEFAULT NULL,
  `vendedores_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_propiedades_vendedores_idx` (`vendedores_id`),
  CONSTRAINT `fk_propiedades_vendedores` FOREIGN KEY (`vendedores_id`) REFERENCES `vendedores` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb3;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `propiedades`
--

LOCK TABLES `propiedades` WRITE;
/*!40000 ALTER TABLE `propiedades` DISABLE KEYS */;
INSERT INTO `propiedades` VALUES (26,'Mirador Azul',12000000.00,'4d1bc751101eafd41c1bd903a60d06a4.jpg','Ubicada en una colina con vistas espectaculares, Mirador Azul es un hogar diseñado para admirar los paisajes sin límites. Su amplio balcón y grandes ventanales permiten que el cielo y el mar se conviertan en parte de la decoración. La casa está construida con líneas modernas y una estructura abierta, maximizando la sensación de amplitud y libertad. Los tonos claros de las paredes y la decoración minimalista refuerzan la sensación de calma y relajación. ',5,9,4,'2025-05-13',1),(27,'Hacienda del Lago',15000000.00,'52257d0bb4847b16ff3b13738c7209e7.jpg','Con vistas a un lago sereno, Hacienda del Lago es una residencia que transmite calma y elegancia. Su diseño clásico, inspirado en las antiguas haciendas mexicanas, incluye muros de piedra, patios interiores con fuentes y corredores con arcos que conducen a jardines frondosos. El agua es el elemento central de esta casa, ya que su ubicación privilegiada permite a los residentes disfrutar de la brisa suave y del reflejo del sol en la superficie del lago. ',5,6,3,'2025-05-13',2),(36,'Refugio Estelar',2900000.00,'f506f7c5ff86e65c2a31b899dd227b1c.jpg','Si alguna vez soñaste con una casa que te permitiera contemplar las estrellas sin obstáculos, Refugio Estelar es el lugar ideal. Ubicada en una zona apartada, lejos de las luces de la ciudad, esta residencia ofrece vistas panorámicas del cielo nocturno. Su terraza principal tiene telescopios para quienes disfrutan de la astronomía, y su iluminación interior está diseñada para crear un ambiente suave y relajante al caer la noche. ',4,5,3,'2025-05-15',1),(37,'Casa Aurora',3800000.00,'c88129f72b9a6e14fd806bd357318faf.jpg','Un hogar lleno de luz y energía positiva, donde cada amanecer se refleja en sus amplios ventanales y espacios abiertos. La armonía entre el diseño moderno y los elementos naturales crea una atmósfera cálida y acogedora. En su interior, la luz dorada del sol entra suavemente, iluminando cada rincón con calidez. Su arquitectura combina líneas elegantes con materiales orgánicos como madera y piedra, brindando una sensación de paz y equilibrio. El jardín, con sus flores vibrantes y caminos sinuosos, invita a la contemplación y el descanso, convirtiéndola en el lugar ideal para empezar cada día con inspiración.',3,4,2,'2025-05-15',2),(38,'Villa Esmeralda',1680000.00,'780a69b69fa37943478b14a514bd7a7c.jpg','Rodeada por exuberantes jardines, Villa Esmeralda es un refugio de serenidad en medio del ajetreo diario. Sus amplios ventanales enmarcan la vista de paisajes verdes y la frescura de la vegetación. Cada espacio ha sido diseñado para equilibrar lujo y comodidad, con muebles de madera tallada y detalles en tonos suaves que complementan la naturaleza que la rodea. En las noches, la iluminación tenue crea un ambiente íntimo y relajante, perfecto para disfrutar de una velada tranquila. La terraza exterior, con su fuente de agua y cómodos asientos, permite apreciar la belleza del entorno mientras se disfruta de la brisa nocturna.',4,2,1,'2025-05-15',1),(39,'Hacienda Solana',1880000.00,'e34fb78f97ba2b744a3929f02cf96cd2.jpg','Esta impresionante casa con estilo colonial ofrece una combinación de tradición y elegancia. Los muros de piedra y los techos altos evocan la historia de las grandes haciendas, mientras que su interior está decorado con detalles artesanales que le dan un carácter único. En su patio central, una fuente de piedra antigua fluye suavemente, creando un ambiente relajante. Los pasillos con arcos y las puertas de madera maciza transportan a otra época, mientras que el mobiliario rústico añade un toque acogedor. Rodeada de naturaleza y con vistas despejadas del horizonte, Hacienda Solana es el lugar ideal para quienes buscan conectar con la esencia del pasado sin renunciar al confort moderno.',4,5,2,'2025-05-15',2),(40,'Refugio del Bosque',4200000.00,'390b7f3e83ecee6aeeb6f48fab000aff.jpg','Escondida entre árboles centenarios, esta casa es un santuario de tranquilidad y conexión con la naturaleza. Su diseño arquitectónico se integra perfectamente con el entorno, utilizando materiales ecológicos y colores naturales para complementar el paisaje. Dentro, los espacios abiertos y las paredes de madera transmiten calidez y confort. Cada ventana ofrece una vista diferente del bosque, permitiendo que la luz se filtre suavemente entre las hojas. En la parte exterior, los senderos de piedra conducen a rincones mágicos, como una pequeña cabaña de lectura o una fogata rodeada de cómodos asientos. Es el lugar perfecto para desconectarse del ruido urbano y respirar el aire puro de la naturaleza.',5,6,3,'2025-05-15',2),(41,'Loft Urban Pulse',2500000.00,'175fff6b720cca176a20d412474915bc.jpg','Este espacio abierto y dinámico está diseñado para quienes buscan un ambiente moderno y funcional. Con techos altos, paredes de ladrillo expuesto y vigas metálicas, el departamento tiene un aire industrial que se complementa con muebles minimalistas y elementos de madera cálida. La cocina integrada y la distribución flexible permiten aprovechar cada rincón sin perder comodidad. La vista a las calles vibrantes añade un toque de energía, ideal para quienes disfrutan la vida urbana y la creatividad sin límites.',3,2,1,'2025-05-15',1);
/*!40000 ALTER TABLE `propiedades` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-05-15 23:07:07
