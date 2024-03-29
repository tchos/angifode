-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2022 at 01:05 PM
-- Server version: 8.0.30-0ubuntu0.20.04.2
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `angifode_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `organismes`
--

CREATE TABLE `organismes` (
  `id` int NOT NULL,
  `libelle_org` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `region` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fax` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone1` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telephone2` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ville` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quartier` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sigle` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `siege` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bp` varchar(32) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `site_web` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `organismes`
--

INSERT INTO `organismes` (`id`, `libelle_org`, `region`, `fax`, `telephone1`, `telephone2`, `email`, `ville`, `quartier`, `sigle`, `siege`, `bp`, `site_web`) VALUES
(1, 'CHAMBRE D\'AGRICULTURE DES PECHES, DE L\'ELEVAGE ET DES FORETS DU CAMEROUN', 'CENTRE', '', '222230977', '243231960', 'chambredagriculturep@yahoo.com', 'CENTRE-VILLE', 'CAPEF', 'PARC REPIQUET (YAOUNDE)', '287', 'www.capef.cm\r', NULL),
(2, 'MISSION DE REGULATION DES APPROVISIONNEMENT DES PRODUITS DE GRANDES CONSOMMATION', 'CENTRE', '', '22234145', '22264146', 'mirap_cm@yahoo.fr', '', 'MIRAP', 'YAOUND?', '12584', '\r', NULL),
(3, 'COMMUNAUTE URBAINE DE BAFOUSSAM', 'OUEST', '', '233441562', '233441168', 'cubafoussam@gmail.com', 'TAMDJA', 'CUB', 'BAFOUSSAM', '995', 'www.cubafoussam.cm\r', NULL),
(4, 'PORT AUTONOME DE KRIBI', 'SUD', '222462104', '222462100', '', 'contact@pak.cm', 'QUARTIER ADMINISTRATIF', 'PAK', 'KRIBI', '', 'www.pak.cm\r', NULL),
(5, 'INSTITUT DE RECHERHCE AGRICOLE POUR LE DEVELOPPEMENT', 'CENTRE', '222223362', '222232644', '222225924', 'irad@irad.cm', 'NKOLBISSON', 'IRAD', 'YAOUNDE', '2123 YAOUNDE', 'www.irad.cm\r', NULL),
(6, 'BUREAU NATIONAL DE L\'ETAT CIVIL', 'CENTRE', '', '2 22 22 63 44', '', '', 'AVENUE CHURCHILL', 'BUNEC', 'YAOUNDE', '15317 YAOUNDE', 'www.bunec.cm\r', NULL),
(7, 'HOPITAL GYNECO-OBSTETRIQUE ET PEDIATRIQUE DE YAOUNDE', 'CENTRE', '', '', '', '', 'NGOUSSO', 'HGPOY', 'YAOUNDE', '', '\r', NULL),
(8, 'INSTITUT DES RELATIONS INTERNATIONALES', 'CENTRE', '222318999', '222310305', '', 'www.incuy2.net', 'OBILI', 'IRIC', 'YAOUNDE', '1637 YAOUNDE', 'www.incuy2.net\r', NULL),
(9, 'PROJET D\'APPUI A LA GESTION DE LA QUALITE DANS LA PRODUCTION DU CACAO ET DES CAFES', 'CENTRE', '', '696481848', '671630566', 'elomasaa@yahoo.fr', 'ETOUG-EBE', 'PAGQ2C', 'ETOUG-EBE', '', '\r', NULL),
(10, 'COMITE DE GESTION DE L\'ASSISTANCE FAO/PAM', 'CENTRE', '', '2221200346', '222200349', 'cgfaopam@yahoo.fr', 'DJOUNGOLO', 'CG/FAO/PAM', 'YAOUNDE', '1639 YAOUNDE', '\r', NULL),
(11, 'SOCIETE DE RECOUVREMENT DES CREANCES DU CAMEROUN', 'CENTRE', '222233833', '222223739', '222220911', 'srccentral@gmail.com', 'RUE DU MFOUNDI', 'SRC', 'YAOUNDE', '11991', '\r', NULL),
(12, 'AGENCE NATIONALE D\'INVESTIGATION FINANCIERE', 'CENTRE', '222221681', '22221681', '', 'contactanif.com', 'CENTRE ADMINISTRATIF', 'ANIF', 'YAOUNDE', '6709 YAOUNDE', 'www.anif.com\r', NULL),
(13, 'PROJET D\'INVESTISSEMENT ET DE DEVELOPPEMENT DES MARCHES AGRICOLES', 'CENTRE', '', '673388441', '683894639', 'rdma_2014@yahoo.fr', 'BASTOS', 'PIDMA', 'YAOUNDE', '15038', 'www.pidma.com\r', NULL),
(14, 'AGENCE DE RADIOPROTECTION', 'CENTRE', '222203370', '222203371', '', '', 'LAC', 'ANRP', 'YAOUNDE', '33732', '\r', NULL),
(15, 'CAISSE NATIONALE DE PREVOYANCE SOCIALE', 'CENTRE', '', '222224601', '', 'cnps.cameroun@cnps.com', 'PLACE DE L\'INDEPENDANCE', 'CNPS', 'YAOUNDE', '441 YAOUNDE', 'www.cnps.com\r', NULL),
(16, 'CAMEROON CIVIL AVIATION AUTHAURITY', 'CENTRE', '222303362', '222303090', '222302692', 'contact@ccaa.aero', 'MVAN', 'CCAA', 'YAOUNDE', '6998', 'www.ccaa.aero\r', NULL),
(17, 'OFFICE DU BACCALAUREAT DU CAMEROUN', 'CENTRE', '222305566', '22225969', '223055567', 'officebaccam@obc.com', 'MVAN', 'OBC', 'YAOUNDE', '13904 YAOUNDE', 'www.obc.com\r', NULL),
(18, 'CHAMBRE D\'AGRICULTURE', 'CENTRE', '', '222230977', '243231960', 'chambredagriculturep@yahoo.fr', 'CENTRE-VILLE', 'CAPEF', 'PARC REPIQUET', '287', 'www.capef.cm\r', NULL),
(19, 'CONSEIL D\'APPUI A LA REALISATION DES CONTRATS DE PARTENARIAT', 'CENTRE', '222217985', '222218107', '', 'info@ppp.cameroun.cm', 'BASTOS', 'CARPA', 'ANCIEN IMMEUBLE CAMTEL (BASTOS)', '33745', '\"www.ppp.ca', 'eroun.cm\"\r'),
(20, 'AGENCE DES NORMES ET DE LA QUALITE', 'CENTRE', '', '22206368', '697328527', 'contract@anorcameroun.info', 'BASTOS', 'ANOR', 'YAOUNDE-BASTOS', '14966', 'www.anorcameroun.info\r', NULL),
(21, 'CONSEIL CONSTITUTIONNEL', 'CENTRE', '', '222217017', '222217016', 'constitutionalcouncil@yahoo.com', 'PALAIS DE CONGRES (TSINGA)', 'CCC', 'YAOUNDE', '33773', '\r', NULL),
(22, 'SOCIETE NATIONALE DE TRANSPORT DE L \'ELECTRICITE', 'CENTRE', '', '657104307', '699523434', 'pierre.nouteyi@sonatrel.com', 'BASTOS', 'SONATREL', 'YAOUNDE', '16102 YAOUNDE', '\r', NULL),
(23, 'MISSION D\'?TUDE POUR L\'AM?NAGEMENT DE L\'OC?AN', 'SUD', '', '222461510', '', 'infosmeao.cm', 'QUARTIE ADMINISTRATIF', 'MEAO', 'KRIBI', '74 KRIBI', 'www.meao.cm\r', NULL),
(24, 'UNIVERSIT? INTER-?TATS CONGO-CAMEROUN', 'SUD', '', '222478287', '', '', '', 'UIECC', 'SANGMELIMA', '174', 'www.uiecc.cm\r', NULL),
(25, 'COMMUNAUT? URBAINE D\'?BOLOWA', 'SUD', '', '', '', '', 'EBOLOWA', 'CUE', 'EBOLOWA', '108 EBOLOWA', '\r', NULL),
(26, 'HOPITAL DE R?F?RENCE DE SANGM?LIMA', 'SUD', '', '222475003', '222475000', '', 'BITOM', 'HRS', 'SANGMELIMA', '890 SANGMELIMA', 'www.horesa.cm\r', NULL),
(27, 'INSTITUT SUP?RIEUR DE MANAGEMENT PUBLIC', 'CENTRE', '', '674646400', '677826242', '', 'NYLON-BASTOS', 'ISMP', 'YAOUNDE', '1280 YAOUNDE', 'www.ismp.cm\r', NULL),
(28, 'MISSION D\'AMENAGEMENT ET DE GESTION DES ZONES INDUSTRIELLES', 'CENTRE', '222318440', '', '', 'magzicameroun@yahoo.fr', '', 'MAGZI', 'YAOUNDE', '1431', 'www.magzicameroun.com\r', NULL),
(29, 'AGENCE DU SERVICE CIVIQUE NATIONAL DE PARTICIPATION AU DEVELOPPEMENT', '', '', '', '', '', '', 'ASCNPD', '', '', '\r', NULL),
(30, 'INSTITUT NATIONAL DE LA STATITIQUE', 'CENTRE', '222232437', '222220445', '', 'contact@star.cm', 'QUARTIER DU LAC', 'INS', 'YAOUNDE', '', '\r', NULL),
(31, 'CENTRE PASTEUR DU CAMEROUN', 'CENTRE', '222231564', '222231015', '222231803', 'cpc@pasteur-yaounde.org', '', 'CPC', 'YAOUNDE', '1274', 'www.pasteur-yaounde.org\r', NULL),
(32, 'AGENT NATIONALE D\'APPUI AU DEVELOPEMENT FORESTIER', 'CENTRE', '222215350', '222210393', '222210393', 'anafor.anafor@yahoo.com', '', 'ANAFOR', 'YAOUNDE', '1341', 'www.anafor.cm\r', NULL),
(33, 'PALAIS DE CONGRES', 'CENTRE', '', '', '', '', 'TSINGA', 'PC', 'YAOUNDE', '', '\r', NULL),
(34, 'ECOLE NATIONALE D\'ADMINISTRATION ET DE MAGISTRATURE', 'CENTRE', '', '', '', '', 'CENTRE VILLE', 'ENAM', 'YAOUNDE', '', '\r', NULL),
(35, 'SOCIETE NATIONALE DE RAFFINAGE', 'SUD-OUEST', '233332188', '233332238', '233332239', '', 'CAPE LIMBOH', 'SONARA', 'CAPE LIMBOH-LIMBE', '365', '\r', NULL),
(36, 'LIMBE NAUTICAL ARTS AND FISHERIES INSTITUTE', 'SUD-OUEST', '', '243808117', '243808116', 'linafilimbe@yahoo.com', '', 'LINAFI', 'LIMBE', '485', '\r', NULL),
(37, 'SOUTH WEST DEVELOPMENT AUTHORITY', 'SUD-OUEST', '', '', '', '', '', 'SOWEDA', 'BUEA', '', '\r', NULL),
(38, 'GENERAL CERTIFICATE OF EDUCATION BOARD', 'SUD-OUEST', '233322114', '677615664', '', '', '', 'GCE BOARD', 'BUEA', '', '\r', NULL),
(39, 'BUREAU CENTRAL DES RECENSEMENTS ET DES ETUDES DE POPULATION', 'CENTRE', '222203071', '', '', 'contact@bucrep.cm', '', 'BUCREP', 'YAOUNDE', '', '\r', NULL),
(40, 'SOCIETE D\'EXPANSION DE MODERNISATION DE RIZICULTURE ', 'EXTREME-NORD', '', '', '', '', '', 'SEMRY', 'YAGOUA', '', '\r', NULL),
(41, 'CAMEROON RADIO TELEVISION', 'CENTRE', '', '', '', '', '', 'CRTV', 'YAOUNDE', '', '\r', NULL),
(42, 'MISSION D\'AMENAGEMENT ET D\'EQUIPEMENT DES TERRAINS URBAINS ET RURAUX', 'CENTRE', '222233190', '222223113', '222222102', '', '', 'MAETUR', 'YAOUNDE', '', 'www.maetur-cameroun.com\r', NULL),
(43, 'INSTITUT NATIONAL DE LA JEUNESSE ET DES SPORT', 'CENTRE', '222227298', '222330835', '222320835', 'secretariat.direction@injs-yaounde.org', 'NGOA EKELE', 'INJS', 'YAOUNDE-CAMEROUN', '1016 YAOUNDE', '\r', NULL),
(44, 'MISSION DE PROMOTION DES MATERIAUX LOCAUX', 'CENTRE', '222223720', '222229445', '', 'contact@mipromalo.cm', 'NKOLBIKOK', 'MIPROMALO', 'YAOUNDE', '2396 YAOUNDE', '\r', NULL),
(45, 'LABORATOIRE NATIONAL DE GENIE CIVIL', 'CENTRE', '222302455', '222303006', '222303007', 'info@labogenie.cm', 'EKOUNOU', 'LABOGENIE', 'EKOUNOU-YAOUNDE', '349 YAOUNDE', 'www.labogenie.com\r', NULL),
(46, 'SOCIETE DE DEVELOPPEMENT DU CACAO', 'CENTRE', '222 30 33 95', '222 30 45 44', '222 30 35 95', '', 'MVAN', 'SODECAO', 'YAOUNDE', '1651', '\r', NULL),
(47, 'CENTRE NATIONAL D\'ETUDE ET D\'EXPERIMENTATION DU MACHINISME AGRICOLE', 'CENTRE', '', '222223354', '', 'ceneema@gmail.com', '', 'CENEEMA', 'YAOUNDE', '1040 YAOUNDE', '\r', NULL),
(48, 'CENTRE PASTEUR', 'NORD', '', '222272222', '', 'ngambi@pasteur-yaounde.org', 'KOLLERE', 'CPC-AG', 'GAROUA', '921 YAOUNDE', 'www.pasteur-yaounde.org\r', NULL),
(49, 'OFFICE CEREALIER', 'NORD', '', '656355725', '675217762', 'officecerealier@yahoo.fr', 'PLATEAU', 'OC', 'GAROUA', '298 GAROUA', '\r', NULL),
(50, 'COMITE INTERREGIONAL DE  LUTTE CONTRE LA SECHERESSE', 'N', '222272495', '222272495', '', 'erlsinfos@yahoo.fr', 'PLATEAU', 'CILSN', 'GAROUA', '', '\r', NULL),
(51, 'UNITE DE TRAITEMENT AGRICOL PAR VOIE AERIENNE', 'NORD', '', '', '', '', 'AEROPORT', 'UTVA', 'GAROUA', '', '\r', NULL),
(52, 'COMMUNAUTE URBAINE DE NGAOUNDERE', 'ADAMAOUA', '', '', '', '', 'ADMINISTRATIF', 'CU', 'NGAOUNDERE', '', '\r', NULL),
(53, 'ECOLE NATIONALE D\'HOTELLERIE ET DU TOURISME', 'ADAMAOUA', '', '', '', '', 'MONT NDERE', 'ENAHT', 'NGAOUNDERE', '', '\r', NULL),
(54, 'ECOLE DE FAUNE', 'NORD', '222273135', '222273135', '', 'ecoledefaune@yahoo.fr', 'PLATEAU', 'EFG', 'GAROUA', '271 GAROUA', '\r', NULL),
(55, 'CAMEROON NATIONAL ASSOCIATION FOR FAMILY WELFARE', 'NORD', '', '', '', '', 'ROUMDE-ADJIA', 'CAMNAFAW', 'GAROUA', '', '\r', NULL),
(56, 'COMMUNAUTE URBAINE DE GAROUA', 'NORD', '222271149', '222271149', '222271472', '', 'CENTRE ADMINISTRATIF', 'CUG', 'PLATEAU', '113', '\r', NULL),
(57, 'LABORATOIRE NATIONAL VETERINAIRE', 'NORD', '', '', '', 'lanavet@lanavet.com', 'BOCKLE', 'LANAVET', 'GAROUA', '503', 'www.lanavet.com\r', NULL),
(58, 'CAISSE DE DEVELOPPEMENT DE L\'ELEVAGE POUR LE NORD', 'NORD', '', '222272115', '222272134', 'cedengaroua@yahoo.fr', '', 'CDEN', 'GAROUA', '936 GAROUA', '\r', NULL),
(59, 'MISSION D\'ETUDES POUR L\'AMENAGEMENT ET LE DEVELOPPEMENT', 'NORD', '', '222271495', '222273118', '', 'ADMINISTRATIF', 'MEADEN', 'GAROUA', '17', '\r', NULL),
(60, 'MISSION DE DEVELOPPEMENT INTEGRE DES MONTS MANDARA', 'EXTREME-NORD', '', '222455013', '699663949', 'midimacm@yahoo.fr', 'TACHR HAMAN GAWAR', 'MIDIMA', 'MOKOLO', '114 MOKOLO', '\r', NULL),
(61, 'COMMUNAUTE URBAINE DE MAROUA', 'EXTREME-NORD', '', '693634008', '676055088', 'procurement37@gmail.com', 'PITOARE', 'CUM', 'MAROUA 1ER', '38 MAROUA', '\r', NULL),
(62, 'SOCIETE DE DEVELOPPEMENT DE COTON AU CAMEROUN', 'NORD', '', '222271080', '222271727', 'sodecoton@sodecoton.cm', 'MAROUARE', 'SODECOTON', 'GAROUA', '302', '\r', NULL),
(63, 'COMMISSION TECHNIQUE DE REHABILITATION', 'CENTRE', '22232143', '', '22223816', '', 'AVENUE FOCH', 'CTR', 'YAOUNDE', '13854', 'ctr.cm\r', NULL),
(64, 'COMITE TECHNIQUE DE SUIVI DES PROGRAMMES ECONOMIQUE', 'CENTRE', '22222751', '22235244', '', 'amartiofr@yohoo.fr', 'AVENUE FOCH', 'CTS', 'YAOUNDE', '13127', '\r', NULL),
(65, 'COMMUNAUTE URBAINE DE YAOUNDE', 'CENTRE', '222220721', '222231112', '', '', 'HIPPODROME', 'CUY', 'YAOUNDE', '1', '\r', NULL),
(66, 'COMITE NATIONAL OLYMPIQUE ET SPORTIF DU CAMEROUN', 'CENTRE', '222212206', '222212205', '222212206', 'camrosc3@yahoo.com', 'NKOL ETON', 'CNOSC', 'NKOL ETON', '528', 'www3cnosc.org\r', NULL),
(67, 'IMPRIMERIE NATIONALE', 'CENTRE', '', '', '', '', 'QUARTIER ADMINISTRATIF', 'IN', 'YAOUNDE', '1603', '\r', NULL),
(68, 'SOCIETE DE DEVELOPPEMENT ET D\'EXPLOITATION DES PRODUCTIONS ANIMALES', 'CENTRE', '', '22200810', '', 'infosodepa.com', 'AVENUE-FOE', 'SODEPA', 'YAOUNDE', '1410', 'www3sodepa.com\r', NULL),
(69, 'CENTRE NATIONAL DE REHABILITATION DES PERSONNES HANDICAPEES', 'CENTRE', '', '', '', 'cnrhyaounde@yahoo.fr', 'ETOUG EBE', 'CNRPH', 'YAOUNDE', '1586 YAOUNDE', '\r', NULL),
(70, 'COMITE NATIONAL DE DEVELOPPEMENT DES TECHNOLOGIES', 'CENTRE', '222222509', '222222509', '', 'cndt-mineru@yahoo.fr', 'NGOA-EKELLE', 'CNDT', 'YAOUNDE', '1457', 'www.cndtcameroun.cm\r', NULL),
(71, 'CAISSE DE D?VELOPPEMENT DE L\' ELEVAGE DU NORD-OUEST', 'NORD OUEST', '233362616', '233361440', '233362516', 'cdenobola@yahoo.com', 'VETERINARY JUNCTION', 'CDENO', 'BAMENDA', '399 BAMENDA', 'www.cdeno.com\r', NULL),
(72, 'CAMEROON WATER UTILITIES CORPORATION', 'LITTORAL', '233437270', '243429684', '243437269', 'infos@camwater.cm', '', 'CW', 'DOUALA', '524', '\r', NULL),
(73, 'CHAMBRE DE COMMERCE D\'INDUSTRIE DES MINES ET DE L\'ARTISANAT', 'LITTORAL', '33425596', '33426787', '33429881', 'siege@ccima.net', '', 'CCIMA', 'DOUALA', '4011', '\r', NULL),
(74, 'CHANTIER NAVAL ET INDUSTRIEL DU CAMEROUN', 'LITTORAL', '33406199', '33403488', '33401560', 'enquiries@cnicyard.com', '', 'CNIC', 'DOUALA', '2389', 'www.cnicyard.com\r', NULL),
(75, 'CAISSE DE DEVELOPPEMENT DE LA PECHE MARITIME', 'LITTORAL', '', '', '', '', '', 'CDPM', 'DOUALA', '', '\r', NULL),
(76, 'COTONNIERE INDUSTRIELLE DU CAMEROUN', 'LITTORAL', '33407431', '33406215', '', 'cicam10@yahoo.fr', '', 'CICAM', 'DOUALA', '7012', '\r', NULL),
(77, 'MISSION DE DEVELOPPEMENT DE LA PECHE, ARTISANALE ET MARITIME', 'LITTORAL', '233424064', '233424033', '', '', '', 'MIDEPECAM', 'DOUALA', '121', '\r', NULL),
(78, 'OFFICE NATIONAL DES ZONES FRANCHES INDUSTRIELLES', 'LITTORAL', '233433317', '233433343', '233433344', 'onzfi@onzfi.org', '', 'ONZFI', 'DOUALA', '925', 'www.onzfi.org\r', NULL),
(79, 'CELLULE D\'APPLUI A LA MAITRISE D\'OUVRAGE DU PROJET HYDROELETRIQUE DE MEMVE\'ELE', '', '', '', '', '', '', 'CAPM', '', '', '\r', NULL),
(80, 'COMMUNAUTE URBAINE D\'EDEA', 'LITTORAL', '', '', '', '', '', 'CUED', 'EDEA', '', '\r', NULL),
(81, 'AGENCE POUR LA SECURITE DE LA NAVIGATION AERIENNE', 'LITTORAL', '233427117', '233423551', '233424848', '', '', 'ASECNA', 'DOUALA', '4063 DOUALA', '\r', NULL),
(82, 'PORT AUTONOME DE DOUALA', 'LITTORAL', '2', '2,37233E+11', '', '', '', 'PAD', 'DOUALA', '4020', '\r', NULL),
(83, 'SOCIETE CAMEROUNAISE DES DEPOTS PETROLIERS', 'LITTORAL', '233404796', '233405445', '233403832', '', '', 'SCDP', 'DOUALA', '2271', '\r', NULL),
(84, 'CAMEROON POSTAL SERVICES', 'CENTRE', '22228648', '22220114', '', '', 'BOULEVARD DU 20 MAI YAOUNDE', 'CAMPOST', 'YAOUNDE', '14411', 'www.campost.cm\r', NULL),
(85, 'AYABA HOTEL', 'NORD', '5387KN', '233362271', '233025932', 'ayabahotel@yahoo.comk', 'OLDJOUN', 'A H', 'BAMENDA', '515', 'www.ayaba hotel.com\r', NULL),
(86, 'UPPER NOUN VALLEY DEVELOPMENT  AUTHORITY', 'NORD OUEST', '', '691798372', '', 'unvdandop@yahoo.com', 'MILE 25', 'U N V D A', 'NDOP', 'DUMA ALLPHONSIUS NUKNI', '\r', NULL),
(87, 'BAMENDA CITY LOUNCIL', 'NORD OUEST', '', '33361267', '', 'info.bamenda', 'MULAND', 'BCC', 'BAMENDA', '495 BAMENDA', 'www bamenda city email.com\r', NULL),
(88, 'CREDIT FONCIER DU CAMEROUN', 'CENTRE', '', '', '', '', '', 'CFC', 'YAOUNDE', '', '\r', NULL),
(89, 'AGENCE DE REGULATION DU SECTEUR DE L\'ELETRICITE', 'CENTRE', '222211014', '222211012', '222211013', 'arsel@arsel-cm.org', 'BASTOS', 'ARSEL', 'PRES DE L\'EGLISE ORTHODOXE', '6064', 'www.arsel.org\r', NULL),
(90, 'SOCIETE DE PRESSE ET D\'EDITION DU CAMEROUN', 'CENTRE', '2222303108', '222303108', '677410582', '', 'NDAMVOUT', 'SOPECAM', 'YAOUNDE', '1218', 'www.sopecam.cm\r', NULL),
(91, 'COMMISSION NATIONALE POUR LA PROMOTION DU BILINGUISME MULTICULTURALISME', 'CENTRE', '', '699513414', '699331623', '', 'MVOG ADA', 'CNPBM', 'YAOUNDE', '1893', '\r', NULL),
(92, 'CAMEROON TELECOMMUNICATIONS', 'CENTRE', '222272990', '222271955', '', '', '', 'CAMTEL', 'YAOUNDE', '27', 'www.camtel.cm\r', NULL),
(93, 'MISSION DE DEVELOPPEMENT DU NORD -OUEST', 'NORD-OUEST', '233361665C', '677764586', '233361007', '', 'BAMENDA', 'MIDENO', 'BAMENDA', '1116', '\r', NULL),
(94, 'COMMISSION TECHNIQUE DE PRIVATISATION ET DES LIQUIDATIONS', 'CENTRE', '22235108', '22235108', '22239750', '', 'IMMEUBLE SNI', 'CTPL', 'YAOUNDE', '7044', '\r', NULL),
(95, 'CENTRE NATIONAL D\'EDUCATION', 'CENTRE', '', '223234012', '', '', 'NGOA EKELLE', 'CNE', 'CNE', '1721', '\r', NULL),
(96, 'FONDS SEMENCIER', 'CENTRE', '', '', '', '', '', 'FS', 'YAOUNDE', '', '\r', NULL),
(97, 'AEROPORTS DU CAMEROUN', 'LITTORAL', '233 431 705', '233 420 722', '233 433 218', '', 'BALI', 'ADC', 'DOUALA', '405', 'mediaplus@mediapluscam.com\r', NULL),
(98, 'CONSEIL NATIONAL DES CHARGEURS DU CAMEROUN', 'LITTORAL', '333437017', '333436767', '', 'info@cncc-cam.org', '', 'CNCC', 'DOUALA', '1588 DOUALA', 'www.cncc-cam.org\r', NULL),
(99, 'CAMAIR-CO', 'LITTORAL', '233422030', '233505550', '', 'info@camair-co.net', '', 'CAMAIR-CO', 'DOUALA', '4852 DOUALA', 'www.camair-co.net\r', NULL),
(100, 'FONDS SPECIAL D\'EQUIPEMENT ET D\'INTERVENTION INTERCOMMUNALE', '', '', '', '', 'NULL', '', 'FEICOM', '', 'NULL', 'null\r', NULL),
(101, 'PROGRAMME D\'ACCOMPAGNEMENT SOCIO-ECONOMIQUE DE MEMVE\'ELE', 'CENTRE', '', '699100186', '', '', 'OMNISPORT', 'PASEM', 'YAOUNDE', '', '\r', NULL),
(102, 'REPRESENTATION CAMEROUNAISE EN BELGIQUE', '', '', '', '', '', '', 'AMBASSADE DE BELGIQUE', 'BELGIQUE', '', '\r', NULL),
(103, 'AGENCE UNIVERSITAIRE DE LA FRANCOPHONIE EN AFRIQUE CENTRALE ET GRANDS LACS', 'CENTRE', '', '', '', '', '', 'AUF', '', '', '\r', NULL),
(104, 'CAISSE DE STABILISATION DES PRIX DES HYDROCARBURES', '', '', '', '', '', '', 'CSPH', '', '', '\r', NULL),
(105, 'AGENCE DE REGULATION DES TELECOMMUNICATIONS', '', '', '', '', '', '', 'ART', '', '', '\r', NULL),
(106, 'CENTRALE NATIONALE D\'APPROVISIONNEMENT EN MEDICAMENTS ET CONSOMMABLES MEDICAUX ESSENTIELS', '', '', '', '', '', '', 'CENAME', '', '', '\r', NULL),
(107, 'FONDS DE DEVELOPPEMENT DES FILIERES CACAO ET CAFE', '', '', '', '', '', '', 'FODECC', '', '', '\r', NULL),
(108, 'FONDS NATIONAL DE L\'EMPLOI', '', '', '', '', '', '', 'FNE', '', '', '\r', NULL),
(109, 'AGENCE NATIONALE DES TECHNOLOGIES DE L\'INFORMATION ET DE LA COMMUNICATION', '', '', '', '', '', '', 'ANTIC', '', '', '\r', NULL),
(110, 'AGENCE DE REGULATION DES MARCHES PUBLICS', '', '', '', '', '', '', 'ARPM', '', '', '\r', NULL),
(111, 'CENTRE INTERNATIONAL DE REFERENCE CHANTAL BIYA', '', '', '', '', '', '', 'CIRCB', '', '', '\r', NULL),
(112, 'HOPITAL GENERAL DE DOUALA', '', '', '', '', '', '', 'HGD', '', '', '\r', NULL),
(113, 'HOPITAL GENERAL DE YAOUNDE', '', '', '', '', '', '', 'OGY', '', '', '\r', NULL),
(114, 'ACADEMIE NATIONALE DE FOOTBALL', '', '', '', '', '', '', 'ANAFOOT', '', '', '\r', NULL),
(115, 'AGENCE D\'ELECTRIFICATION RURALE', '', '', '', '', '', '', 'AER', '', '', '\r', NULL),
(116, 'AGENCE DE PROMOTION DES INVESTISSEMENTS', '', '', '', '', '', '', 'API', '', '', '\r', NULL),
(117, 'AGENCE DE PROMOTION DES PETITES ET MOYENNES ENTREPRISES', '', '', '', '', '', '', 'APME', '', '', '\r', NULL),
(118, 'AGENCE DE PROMOTION DES ZONES ECONOMIQUES', '', '', '', '', '', '', 'APZE', '', '', '\r', NULL),
(119, 'AUTORITE PORTUAIRE NATIONALE', '', '', '', '', '', '', 'APN', '', '', '\r', NULL),
(120, 'CAISSE AUTONOME D\'AMORTISSEMENT', '', '', '', '', '', '', 'CAA', '', '', '\r', NULL),
(121, 'CENTRE HOSPITALIER DE RECHERCHE ET D\'APPLICATION EN CHIRURGIE ENDOSCOPIQUE ET DE REPRODUCTION HUMAINE', '', '', '', '', '', '', 'CHRACERH', '', '', '\r', NULL),
(122, 'CENTRE HOSPITALIER UNIVERSITAIRE', '', '', '', '', '', '', 'CHU', '', '', '\r', NULL),
(123, 'COMPAGNIE CAMEROUNAISE DE L\'ALUMINIUM', '', '', '', '', '', '', 'ALUCAM', '', '', '\r', NULL),
(124, 'COMMISSION NATIONALE ANTI-CORRUPTION', '', '', '', '', '', '', 'CONAC', '', '', '\r', NULL),
(125, 'ECOLE INTERNATIONALE DES FORCES DE SECURITE', '', '', '', '', '', '', 'EIFORCES', '', '', '\r', NULL),
(126, 'SOCIETE NATIONALE DES HYDROCARBURES', '', '', '', '', '', '', 'SNH', '', '', '\r', NULL),
(127, 'CAMEROON DEVELOPMENT CORPORATION', '', '', '', '', '', '', 'CDC', '', '', '\r', NULL),
(128, 'ECOLE NATIONALE SUPERIEURE DES POSTES, DES TELECOMMUNICATIONS ET DES TECHNOLOGIES DE L\'INFORMATION ET DE LA COMMUNICATION', '', '', '', '', '', '', 'SUP\'PTIC', '', '', '\r', NULL),
(129, 'ECOLE NATIONALE SUPERIEURE DES TRAVAUX PUBLICS', '', '', '', '', '', '', 'ENSTP', '', '', '\r', NULL),
(130, 'FONDS ROUTIER', '', '', '', '', '', '', 'FR', '', '', '\r', NULL),
(131, 'HOPITAL GYNECO-OBSTETRIQUE ET PEDIATRIQUE DE DOUALA', '', '', '', '', '', '', 'HGOPD', '', '', '\r', NULL),
(132, 'HOPITAL GYNECO-OBSTETRIQUE ET PEDIATRIQUE DE YAOUNDE', '', '', '', '', '', '', 'HGOPY', '', '', '\r', NULL),
(133, 'INSTITUT DE RECHERCHE GEOLOGIQUE ET MINIERE', '', '', '', '', '', '', 'IRGM', '', '', '\r', NULL),
(134, 'INSTITUT DE RECHERCHE MEDICALE ET D\'ETUDES DES PLANTES MEDICINALES', '', '', '', '', '', '', 'IRMPM', '', '', '\r', NULL),
(135, 'INSTITUT NATIONAL DE CARTOGRAPHIE', '', '', '', '', '', '', 'INC', '', '', '\r', NULL),
(136, 'ELECTRICITY DEVELOOPMENT CORPORATION', '', '', '', '', '', '', 'EDC', '', '', '\r', NULL),
(137, 'LABORATOIRE NATIONAL D\'ANALYSE ET DE CONTROLE DE LE QUALITE DES MEDICAMENTS', '', '', '', '', '', '', 'LANACOME', '', '', '\r', NULL),
(138, 'PAMOL PLANTATIONS PLC', '', '', '', '', '', '', 'PPPLC', '', '', '\r', NULL),
(139, 'NATIONAL SCHOOL OF LOCAL ADMINISTRATION', '', '', '', '', '', '', 'NASLA', '', '', '\r', NULL),
(140, 'CAMEROON PULIC-EXPANSION', '', '', '', '', '', '', 'CPE', '', '', '\r', NULL),
(141, 'OBSERVATOIRE NATIONAL SUR LES CHANGEMENTS CLIMATIQUES', '', '', '', '', '', '', 'ONCC', '', '', '\r', NULL),
(142, 'OFFICE NATIONAL DES ANCIENS COMBATTANTS', '', '', '', '', '', '', 'ONAC', '', '', '\r', NULL),
(143, 'MEKIN HYDROELECTRIC DEVELOPMENT CORPORATION', '', '', '', '', '', '', 'HYDRO-MEKIN', '', '', '\r', NULL),
(144, 'PARC NATIONAL DE MATERIEL DE GENIE CIVIL', '', '', '', '', '', '', 'MATGENIE', '', '', '\r', NULL),
(145, 'SOCIETE ALUMINIUM DE BASSA', '', '', '', '', '', '', 'ALUBASSA', '', '', '\r', NULL),
(146, 'SOCIETE IMMOBILIERE DU CAMEROUN', '', '', '', '', '', '', 'SIC', '', '', '\r', NULL),
(147, 'SOCIETE NATIONALE DE TRANSPORT ET DE TRANSIT DU CAMEROUN', '', '', '', '', '', '', 'CAMTAINER', '', '', '\r', NULL),
(148, 'SOCIETE NATIONALE D\'INVESTISSEMENT', '', '', '', '', '', '', 'SNI', '', '', '\r', NULL),
(149, 'OFFICE NATIONAL DU CACAO ET DU CAFE', '', '', '', '', '', '', 'ONC&C', '', '', '\r', NULL),
(150, 'HEVEA CAMEROUN', 'SUD', '233428141', '222460736', '233427564', 'hevecamsa@halcyonagri.com', '', 'HEVECAM', 'NYE\'ETE-KRIBI', '174 KRIBI', 'www.hevecam.com\r', NULL),
(151, 'BANQUE CAMEROUNAISE DES PETITES ET MOYENNES ENTREPRISES', '', '', '', '', '', '', 'BC-PME', '', '', '\r', NULL),
(152, 'ECOLE SOCIETE NATIONALE DE RAFFINAGE', '', '', '', '', '', '', 'ECOLE SONARA', '', '', '\r', NULL),
(153, 'AES-SOCIETE NATIONALE D\'ELECTRICITE', '', '', '', '', '', '', 'AES-SONEL', '', '', '\r', NULL),
(154, 'THE ENERGY OF CAMEROON', '', '', '', '', '', '', 'ENEO', '', '', '\r', NULL),
(155, 'BUREAU DE MISE A NIVEAU DES ENTREPRISE', 'CENTRE', '', '222208823', '', 'bmn_cmr@yahoo.fr', 'NLONGKAK', 'BMN', 'YAOUNDE', '', '\r', NULL),
(156, 'CAMEROON WATER UTILITIES CORPORATION', 'LITTORAL', '33437270', '33429684', '699683701', '', '', 'CAMWATER', 'DOUALA', '524', '\r', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `organismes`
--
ALTER TABLE `organismes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `organismes`
--
ALTER TABLE `organismes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
