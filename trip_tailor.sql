-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3307:3307
-- Generation Time: Oct 20, 2024 at 12:51 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trip_tailor`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `AdminID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attraction`
--

CREATE TABLE `attraction` (
  `AttractionID` int(11) NOT NULL,
  `AttractionName` varchar(100) DEFAULT NULL,
  `AttractionType` varchar(100) DEFAULT NULL,
  `ActivityType` varchar(100) DEFAULT NULL,
  `EntryFee` decimal(10,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `DestinationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attraction`
--

INSERT INTO `attraction` (`AttractionID`, `AttractionName`, `AttractionType`, `ActivityType`, `EntryFee`, `Description`, `DestinationID`) VALUES
(1, 'Kufri', 'Hill', 'Adventure', 100.00, 'A beautiful hilltop in Shimla', 1),
(2, 'Pangong Lake', 'Lake', 'Sightseeing', 50.00, 'A high-altitude lake with stunning views.', 1),
(3, 'Nubra Valley', 'Valley', 'Adventure', 100.00, 'A scenic valley offering sand dunes and monasteries.', 1),
(4, 'Magnetic Hill', 'Hill', 'Adventure', 20.00, 'A gravity-defying hill, a must-visit in Ladakh.', 1),
(5, 'Baga Beach', 'Beach', 'Water Sports', 0.00, 'A popular beach with water sports and nightlife.', 2),
(6, 'Basilica of Bom Jesus', 'Church', 'Sightseeing', 50.00, 'A UNESCO heritage site known for its Baroque architecture.', 2),
(7, 'Dudhsagar Waterfalls', 'Waterfall', 'Trekking', 100.00, 'One of India\'s tallest waterfalls.', 2),
(8, 'Alleppey Houseboat', 'Backwater', 'Cruising', 3000.00, 'Houseboat tours through serene backwaters.', 3),
(9, 'Vembanad Lake', 'Lake', 'Boating', 200.00, 'A scenic lake perfect for boating and fishing.', 3),
(10, 'Kumarakom Bird Sanctuary', 'Sanctuary', 'Bird Watching', 100.00, 'A paradise for bird lovers in Kerala.', 3),
(11, 'Amber Fort', 'Fort', 'Historical Tour', 200.00, 'A grand fort offering beautiful architecture and views.', 4),
(12, 'Hawa Mahal', 'Palace', 'Sightseeing', 50.00, 'The Palace of Winds with its unique facade.', 4),
(13, 'Jantar Mantar', 'Monument', 'Astronomical Study', 100.00, 'An astronomical observatory built by Maharaja Jai Singh II.', 4),
(14, 'Lakshman Jhula', 'Bridge', 'Adventure', 0.00, 'A famous suspension bridge across the Ganges River.', 5),
(15, 'Triveni Ghat', 'Ghat', 'Religious', 0.00, 'A sacred ghat for bathing and religious ceremonies.', 5),
(16, 'Neer Garh Waterfall', 'Waterfall', 'Trekking', 20.00, 'A scenic waterfall located on a trekking route.', 5),
(17, 'Taj Mahal', 'Monument', 'Historical Tour', 250.00, 'The iconic white marble mausoleum.', 6),
(18, 'Agra Fort', 'Fort', 'Historical Tour', 150.00, 'A UNESCO World Heritage site.', 6),
(19, 'Mehtab Bagh', 'Garden', 'Sightseeing', 50.00, 'A garden offering stunning views of the Taj Mahal.', 6),
(20, 'Solang Valley', 'Valley', 'Adventure', 200.00, 'A beautiful valley offering skiing and paragliding.', 7),
(21, 'Rohtang Pass', 'Mountain Pass', 'Adventure', 500.00, 'A high-altitude pass with snow-covered peaks.', 7),
(22, 'Hadimba Temple', 'Temple', 'Religious', 20.00, 'A wooden temple dedicated to Goddess Hadimba.', 7),
(23, 'Kashi Vishwanath Temple', 'Temple', 'Religious', 0.00, 'One of the most famous Hindu temples.', 8),
(24, 'Dashashwamedh Ghat', 'Ghat', 'Religious', 0.00, 'A prominent ghat for Ganga Aarti ceremonies.', 8),
(25, 'Sarnath', 'Historical Site', 'Sightseeing', 50.00, 'The site where Buddha gave his first sermon.', 8),
(26, 'City Palace', 'Palace', 'Historical Tour', 300.00, 'A royal palace complex with museums and courtyards.', 9),
(27, 'Lake Pichola', 'Lake', 'Boating', 200.00, 'A picturesque lake offering boat rides.', 9),
(28, 'Jagdish Temple', 'Temple', 'Religious', 50.00, 'A large Hindu temple dedicated to Lord Vishnu.', 9),
(29, 'Abbey Falls', 'Waterfall', 'Trekking', 100.00, 'A scenic waterfall in a lush forest.', 10),
(30, 'Raja\'s Seat', 'Viewpoint', 'Sightseeing', 20.00, 'A popular spot for panoramic views of the hills.', 10),
(31, 'Dubare Elephant Camp', 'Sanctuary', 'Animal Interaction', 300.00, 'An elephant training camp offering interaction with elephants.', 10),
(32, 'Mall Road', 'Shopping Street', 'Shopping', 0.00, 'A popular shopping street in Shimla.', 11),
(33, 'Jakhoo Temple', 'Temple', 'Religious', 50.00, 'A temple dedicated to Lord Hanuman, situated on Jakhoo Hill.', 11),
(34, 'The Ridge', 'Public Square', 'Sightseeing', 0.00, 'A large open space offering stunning views of the mountains.', 11),
(35, 'Radhanagar Beach', 'Beach', 'Water Sports', 0.00, 'One of the most beautiful beaches in Asia.', 12),
(36, 'Cellular Jail', 'Monument', 'Historical Tour', 50.00, 'A colonial prison used during India\'s freedom struggle.', 12),
(37, 'Ross Island', 'Island', 'Sightseeing', 100.00, 'An abandoned island known for its ruins.', 12),
(38, 'Tiger Hill', 'Viewpoint', 'Sightseeing', 50.00, 'A famous viewpoint offering panoramic views of the Himalayas.', 13),
(39, 'Batasia Loop', 'Train Route', 'Sightseeing', 20.00, 'A scenic railway loop with a war memorial.', 13),
(40, 'Padmaja Naidu Zoological Park', 'Zoo', 'Wildlife Viewing', 100.00, 'A zoological park home to various endangered species.', 13),
(41, 'Golden Temple', 'Temple', 'Religious', 0.00, 'The holiest Sikh shrine.', 14),
(42, 'Jallianwala Bagh', 'Memorial', 'Historical Tour', 0.00, 'A memorial to the victims of the Jallianwala Bagh massacre.', 14),
(43, 'Wagah Border', 'Border', 'Patriotic Event', 0.00, 'The ceremonial border closing between India and Pakistan.', 14),
(44, 'Jaisalmer Fort', 'Fort', 'Historical Tour', 200.00, 'A massive sandstone fort housing an entire city.', 15),
(45, 'Sam Sand Dunes', 'Desert', 'Camel Safari', 500.00, 'Experience the Thar Desert on a camel safari.', 15),
(46, 'Patwon Ki Haveli', 'Heritage House', 'Sightseeing', 100.00, 'A collection of five havelis with intricate carvings.', 15),
(47, 'Botanical Garden', 'Garden', 'Sightseeing', 50.00, 'A well-maintained garden with a variety of flora.', 16),
(48, 'Ooty Lake', 'Lake', 'Boating', 100.00, 'A man-made lake offering boat rides.', 16),
(49, 'Doddabetta Peak', 'Mountain', 'Trekking', 20.00, 'The highest peak in the Nilgiri mountains.', 16),
(50, 'Mysore Palace', 'Palace', 'Historical Tour', 200.00, 'A royal palace known for its grand architecture.', 17),
(51, 'Brindavan Gardens', 'Garden', 'Sightseeing', 50.00, 'A famous garden with musical fountains.', 17),
(52, 'Chamundi Hill', 'Temple', 'Religious', 100.00, 'A hilltop temple dedicated to Goddess Chamundeshwari.', 17),
(53, 'Vivekananda Rock Memorial', 'Monument', 'Sightseeing', 50.00, 'A memorial situated on a rock island.', 18),
(54, 'Kanyakumari Beach', 'Beach', 'Sightseeing', 0.00, 'A rocky beach known for its sunset and sunrise views.', 18),
(55, 'Thiruvalluvar Statue', 'Monument', 'Sightseeing', 50.00, 'A giant statue of the famous Tamil poet.', 18),
(56, 'Kandariya Mahadeva Temple', 'Temple', 'Historical Tour', 100.00, 'A famous temple known for its intricate carvings.', 19),
(57, 'Lakshmana Temple', 'Temple', 'Historical Tour', 100.00, 'A beautifully preserved temple with carvings.', 19),
(58, 'Raneh Falls', 'Waterfall', 'Trekking', 50.00, 'A waterfall located in a canyon near Khajuraho.', 19),
(59, 'Great Rann of Kutch', 'Desert', 'Festival', 0.00, 'The largest salt desert in the world.', 20),
(60, 'Kala Dungar', 'Hill', 'Trekking', 20.00, 'The highest point in Kutch offering panoramic views.', 20),
(61, 'Kutch Museum', 'Museum', 'Sightseeing', 50.00, 'A museum showcasing the history and culture of Kutch.', 20),
(62, 'Tulsi Manas Mandir', 'Temple', 'Religious', 0.00, 'A beautiful temple dedicated to Lord Rama.', 21),
(63, 'Kedar Ghat', 'Ghat', 'Religious', 0.00, 'A serene ghat on the banks of the Ganges.', 21),
(64, 'Ramnagar Fort', 'Fort', 'Historical Tour', 100.00, 'A fort that houses a museum showcasing the royal family of Varanasi.', 21),
(65, 'Virupaksha Temple', 'Temple', 'Historical Tour', 50.00, 'A UNESCO World Heritage site known for its intricate carvings.', 22),
(66, 'Vijaya Vittala Temple', 'Temple', 'Historical Tour', 100.00, 'Famous for its stone chariot and musical pillars.', 22),
(67, 'Hampi Bazaar', 'Market', 'Shopping', 0.00, 'A vibrant market with handicrafts and souvenirs.', 22),
(68, 'Elephant Falls', 'Waterfall', 'Sightseeing', 20.00, 'A stunning three-tiered waterfall.', 23),
(69, 'Living Root Bridges', 'Natural Wonder', 'Trekking', 100.00, 'Unique bridges made from the roots of trees.', 23),
(70, 'Ward\'s Lake', 'Lake', 'Sightseeing', 50.00, 'A beautiful lake surrounded by gardens.', 23),
(71, 'Kodaikanal Lake', 'Lake', 'Boating', 100.00, 'A star-shaped lake ideal for boating.', 24),
(72, 'Coaker\'s Walk', 'Trail', 'Sightseeing', 20.00, 'A scenic walkway offering panoramic views of the valley.', 24),
(73, 'Pillar Rocks', 'Rock Formation', 'Sightseeing', 50.00, 'Three giant rock pillars offering breathtaking views.', 24),
(74, 'Naini Lake', 'Lake', 'Boating', 100.00, 'A picturesque lake surrounded by mountains.', 25),
(75, 'Snow View Point', 'Viewpoint', 'Sightseeing', 20.00, 'A viewpoint offering views of the Himalayas.', 25),
(76, 'Naina Devi Temple', 'Temple', 'Religious', 0.00, 'A temple dedicated to Goddess Naina Devi.', 25),
(77, 'Tea Gardens', 'Plantation', 'Sightseeing', 0.00, 'Beautiful tea gardens with breathtaking views.', 26),
(78, 'Attukal Waterfalls', 'Waterfall', 'Trekking', 20.00, 'A scenic waterfall ideal for trekking.', 26),
(79, 'Eravikulam National Park', 'National Park', 'Wildlife Viewing', 100.00, 'A park known for its endangered Nilgiri Tahr.', 26),
(80, 'Ram Jhula', 'Bridge', 'Sightseeing', 0.00, 'A famous iron suspension bridge over the Ganges.', 27),
(81, 'Parmarth Niketan', 'Ashram', 'Yoga', 0.00, 'An ashram offering yoga and meditation classes.', 27),
(82, 'Shivpuri', 'Village', 'Adventure', 200.00, 'A village known for river rafting and camping.', 27),
(83, 'Mysore Zoo', 'Zoo', 'Wildlife Viewing', 100.00, 'One of the oldest zoos in India.', 28),
(84, 'St. Philomena\'s Church', 'Church', 'Sightseeing', 50.00, 'One of the largest churches in India.', 28),
(85, 'Mysore Dasara', 'Festival', 'Cultural', 0.00, 'An annual festival showcasing Mysore\'s culture.', 28),
(86, 'Auroville', 'Community', 'Sightseeing', 0.00, 'An experimental township dedicated to peace and sustainability.', 29),
(87, 'Promenade Beach', 'Beach', 'Sightseeing', 0.00, 'A beautiful beach ideal for evening strolls.', 29),
(88, 'Sri Aurobindo Ashram', 'Ashram', 'Spiritual', 0.00, 'A well-known spiritual center in Pondicherry.', 29),
(89, 'MG Marg', 'Shopping Street', 'Shopping', 0.00, 'A popular pedestrian street lined with shops and eateries.', 30),
(90, 'Tsomgo Lake', 'Lake', 'Sightseeing', 100.00, 'A glacial lake surrounded by snow-capped mountains.', 30),
(91, 'Nathula Pass', 'Mountain Pass', 'Adventure', 500.00, 'A high mountain pass on the Indo-China border.', 30),
(92, 'Cellular Jail', 'Historical Site', 'Sightseeing', 100.00, 'A colonial prison with historical significance.', 31),
(93, 'Neil Island', 'Island', 'Beach', 0.00, 'A peaceful island known for its pristine beaches.', 31),
(94, 'Radhanagar Beach', 'Beach', 'Water Sports', 0.00, 'Rated as one of the best beaches in Asia.', 31),
(95, 'Khardung La', 'Mountain Pass', 'Adventure', 200.00, 'One of the highest motorable roads in the world.', 32),
(96, 'Nubra Valley', 'Valley', 'Adventure', 100.00, 'A valley known for its scenic beauty and sand dunes.', 32),
(97, 'Shanti Stupa', 'Stupa', 'Sightseeing', 20.00, 'A beautiful white dome-shaped stupa.', 32),
(98, 'Nilgiri Mountain Railway', 'Train Ride', 'Sightseeing', 50.00, 'A UNESCO World Heritage train ride through hills.', 33),
(99, 'Doddabetta Peak', 'Peak', 'Trekking', 20.00, 'The highest peak in the Nilgiri Mountains.', 33),
(100, 'Ooty Rose Garden', 'Garden', 'Sightseeing', 50.00, 'A beautiful garden with a variety of roses.', 33),
(101, 'Sam Sand Dunes', 'Desert', 'Camel Safari', 500.00, 'Experience camel rides at sunset.', 34),
(102, 'Patwon Ki Haveli', 'Heritage House', 'Sightseeing', 100.00, 'A complex of havelis with intricate architecture.', 34),
(103, 'Desert National Park', 'National Park', 'Wildlife Viewing', 200.00, 'Home to unique desert wildlife.', 34),
(104, 'City Palace', 'Palace', 'Historical Tour', 200.00, 'The royal residence with museums.', 35),
(105, 'Jal Mahal', 'Palace', 'Sightseeing', 50.00, 'A stunning palace in the middle of a lake.', 35),
(106, 'Nahargarh Fort', 'Fort', 'Sightseeing', 100.00, 'A fort offering panoramic views of Jaipur.', 35),
(107, 'Jagannath Temple', 'Temple', 'Religious', 0.00, 'A significant Hindu temple dedicated to Lord Jagannath.', 36),
(108, 'Puri Beach', 'Beach', 'Sightseeing', 0.00, 'A famous beach known for its golden sands.', 36),
(109, 'Chilika Lake', 'Lake', 'Wildlife Viewing', 50.00, 'A brackish water lagoon known for bird watching.', 36),
(110, 'McLeod Ganj', 'Town', 'Sightseeing', 0.00, 'The residence of the Dalai Lama.', 37),
(111, 'Bhagsu Waterfall', 'Waterfall', 'Trekking', 20.00, 'A beautiful waterfall surrounded by lush greenery.', 37),
(112, 'Namgyal Monastery', 'Monastery', 'Spiritual', 0.00, 'The largest Tibetan monastery outside Tibet.', 37),
(113, 'Abbey Falls', 'Waterfall', 'Trekking', 20.00, 'A scenic waterfall located in a coffee plantation.', 38),
(114, 'Dubare Elephant Camp', 'Sanctuary', 'Animal Interaction', 300.00, 'An elephant training camp offering interaction with elephants.', 38),
(115, 'Nisargadhama', 'Island', 'Sightseeing', 50.00, 'An island on the Kaveri River with beautiful landscapes.', 38),
(116, 'Ajanta Caves', 'Caves', 'Historical Tour', 250.00, 'A UNESCO World Heritage site known for ancient rock-cut caves.', 39),
(117, 'Ellora Caves', 'Caves', 'Historical Tour', 250.00, 'Famous for its monumental caves and intricate sculptures.', 39),
(118, 'Bibi Ka Maqbara', 'Tomb', 'Historical Tour', 100.00, 'A beautiful tomb often called the Mini Taj Mahal.', 39),
(119, 'Nathula Pass', 'Mountain Pass', 'Adventure', 500.00, 'A high mountain pass on the Indo-China border.', 40),
(120, 'Khecheopalri Lake', 'Lake', 'Sightseeing', 100.00, 'A sacred lake surrounded by lush forests.', 40),
(121, 'Yuksom', 'Village', 'Trekking', 20.00, 'A gateway to Kanchenjunga, ideal for trekking.', 40),
(122, 'Kandariya Mahadeva Temple', 'Temple', 'Historical Tour', 100.00, 'A UNESCO World Heritage site known for its sculptures.', 41),
(123, 'Lakshmana Temple', 'Temple', 'Historical Tour', 100.00, 'A beautifully preserved temple dedicated to Lord Vishnu.', 41),
(124, 'Raneh Falls', 'Waterfall', 'Trekking', 50.00, 'A waterfall known for its picturesque scenery.', 41),
(125, 'Mehrangarh Fort', 'Fort', 'Historical Tour', 100.00, 'A massive fort with a museum and stunning views.', 42),
(126, 'Jaswant Thada', 'Mausoleum', 'Sightseeing', 50.00, 'A beautiful marble cenotaph built in memory of Maharaja Jaswant Singh II.', 42),
(127, 'Umaid Bhawan Palace', 'Palace', 'Sightseeing', 200.00, 'A royal palace that is now a luxury hotel.', 42),
(128, 'Varkala Beach', 'Beach', 'Sightseeing', 0.00, 'A beach famous for its cliffs and natural springs.', 43),
(129, 'Sivagiri Mutt', 'Ashram', 'Spiritual', 0.00, 'A pilgrimage center founded by Sree Narayana Guru.', 43),
(130, 'Janardhana Swami Temple', 'Temple', 'Religious', 0.00, 'An ancient temple dedicated to Lord Vishnu.', 43),
(131, 'Solang Valley', 'Valley', 'Adventure', 200.00, 'Famous for skiing and paragliding activities.', 44),
(132, 'Hadimba Temple', 'Temple', 'Religious', 0.00, 'A temple surrounded by cedar forests.', 44),
(133, 'Rohtang Pass', 'Mountain Pass', 'Adventure', 200.00, 'A high mountain pass offering breathtaking views.', 44),
(134, 'Alleppey Beach', 'Beach', 'Sightseeing', 0.00, 'A beautiful beach known for its backwaters.', 45),
(135, 'Backwaters', 'Waterbody', 'Boat Ride', 500.00, 'Experience the scenic beauty of Kerala backwaters.', 45),
(136, 'Karakkad Boat Race', 'Event', 'Cultural', 100.00, 'A famous boat race held during Onam.', 45),
(137, 'Western Group of Temples', 'Temple', 'Historical Tour', 100.00, 'Famous for its erotic sculptures and intricate architecture.', 46),
(138, 'Eastern Group of Temples', 'Temple', 'Historical Tour', 100.00, 'Known for its unique artistic style.', 46),
(139, 'Dijuli Waterfall', 'Waterfall', 'Trekking', 50.00, 'A serene waterfall ideal for picnics.', 46),
(140, 'Om Beach', 'Beach', 'Sightseeing', 0.00, 'A beach known for its unique Om shape.', 47),
(141, 'Kudle Beach', 'Beach', 'Sightseeing', 0.00, 'A tranquil beach ideal for relaxation.', 47),
(142, 'Mahabaleshwar Temple', 'Temple', 'Religious', 0.00, 'An ancient temple dedicated to Lord Shiva.', 47),
(143, 'Sarthana Nature Park', 'Park', 'Wildlife Viewing', 50.00, 'A beautiful park ideal for nature lovers.', 48),
(144, 'Dutch, English, and Persian Cemetery', 'Cemetery', 'Historical Tour', 0.00, 'A historic cemetery with beautiful architecture.', 48),
(145, 'Surat Castle', 'Fort', 'Historical Tour', 100.00, 'A fort built in the 1500s to protect the city.', 48),
(146, 'Sabarmati Ashram', 'Ashram', 'Cultural', 0.00, 'A historic ashram associated with Mahatma Gandhi.', 49),
(147, 'Akshardham Temple', 'Temple', 'Religious', 0.00, 'A modern temple complex showcasing traditional architecture.', 49),
(148, 'Kankaria Lake', 'Lake', 'Sightseeing', 50.00, 'A popular lake with recreational activities.', 49),
(149, 'City Palace', 'Palace', 'Historical Tour', 200.00, 'A beautiful palace complex with museums.', 50),
(150, 'Lake Pichola', 'Lake', 'Boat Ride', 50.00, 'A picturesque lake with boat rides available.', 50),
(151, 'Jaisamand Lake', 'Lake', 'Sightseeing', 100.00, 'A beautiful artificial lake surrounded by hills.', 50);

-- --------------------------------------------------------

--
-- Table structure for table `destination`
--

CREATE TABLE `destination` (
  `DestinationID` int(11) NOT NULL,
  `DestinationName` varchar(100) DEFAULT NULL,
  `DestinationType` varchar(100) DEFAULT NULL,
  `DestinationLocation` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `destination`
--

INSERT INTO `destination` (`DestinationID`, `DestinationName`, `DestinationType`, `DestinationLocation`) VALUES
(1, 'Shimla', 'Hill Station', 'Himachal Pradesh'),
(2, 'Leh-Ladakh', 'Adventure', 'Jammu & Kashmir'),
(3, 'Goa', 'Beach', 'Goa'),
(4, 'Kerala Backwaters', 'Nature', 'Kerala'),
(5, 'Jaipur', 'Heritage', 'Rajasthan'),
(6, 'Rishikesh', 'Spiritual', 'Uttarakhand'),
(7, 'Agra', 'Heritage', 'Uttar Pradesh'),
(8, 'Manali', 'Hill Station', 'Himachal Pradesh'),
(9, 'Varanasi', 'Religious', 'Uttar Pradesh'),
(10, 'Udaipur', 'Cultural', 'Rajasthan'),
(11, 'Coorg', 'Hill Station', 'Karnataka'),
(12, 'Shimla', 'Hill Station', 'Himachal Pradesh'),
(13, 'Andaman & Nicobar', 'Beach', 'Andaman Islands'),
(14, 'Darjeeling', 'Hill Station', 'West Bengal'),
(15, 'Amritsar', 'Religious', 'Punjab'),
(16, 'Jaisalmer', 'Desert', 'Rajasthan'),
(17, 'Ooty', 'Hill Station', 'Tamil Nadu'),
(18, 'Mysore', 'Cultural', 'Karnataka'),
(19, 'Kanyakumari', 'Beach', 'Tamil Nadu'),
(20, 'Khajuraho', 'Heritage', 'Madhya Pradesh'),
(21, 'Rann of Kutch', 'Desert', 'Gujarat'),
(22, 'Hampi', 'Historical', 'Karnataka'),
(23, 'Munnar', 'Hill Station', 'Kerala'),
(24, 'Lakshadweep', 'Beach', 'Lakshadweep Islands'),
(25, 'Gangtok', 'Hill Station', 'Sikkim'),
(26, 'Auroville', 'Spiritual', 'Tamil Nadu'),
(27, 'Bhubaneswar', 'Religious', 'Odisha'),
(28, 'Rameswaram', 'Religious', 'Tamil Nadu'),
(29, 'Mount Abu', 'Hill Station', 'Rajasthan'),
(30, 'Puri', 'Beach', 'Odisha'),
(31, 'Lonavala', 'Hill Station', 'Maharashtra'),
(32, 'Kodaikanal', 'Hill Station', 'Tamil Nadu'),
(33, 'Sundarbans', 'Nature', 'West Bengal'),
(34, 'Kaziranga', 'Nature', 'Assam'),
(35, 'Varkala', 'Beach', 'Kerala'),
(36, 'Haridwar', 'Spiritual', 'Uttarakhand'),
(37, 'Mahabalipuram', 'Heritage', 'Tamil Nadu'),
(38, 'Bodh Gaya', 'Spiritual', 'Bihar'),
(39, 'Elephanta Caves', 'Heritage', 'Maharashtra'),
(40, 'Ranikhet', 'Hill Station', 'Uttarakhand'),
(41, 'Bandipur National Park', 'Wildlife', 'Karnataka'),
(42, 'Cherrapunji', 'Nature', 'Meghalaya'),
(43, 'Kalimpong', 'Hill Station', 'West Bengal'),
(44, 'Bhimtal', 'Hill Station', 'Uttarakhand'),
(45, 'Ranthambore', 'Wildlife', 'Rajasthan'),
(46, 'Ellora Caves', 'Heritage', 'Maharashtra'),
(47, 'Orchha', 'Heritage', 'Madhya Pradesh'),
(48, 'Tawang', 'Hill Station', 'Arunachal Pradesh'),
(49, 'Kullu', 'Hill Station', 'Himachal Pradesh'),
(50, 'Spiti Valley', 'Adventure', 'Himachal Pradesh'),
(51, 'Gulmarg', 'Adventure', 'Jammu & Kashmir');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `ExpenseID` int(11) NOT NULL,
  `DestinationID` int(11) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `costamount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`ExpenseID`, `DestinationID`, `category`, `costamount`) VALUES
(1, 1, 'Accommodation', 5000.00),
(2, 1, 'Accommodation', 15000.00),
(3, 1, 'Travel', 15000.00),
(4, 2, 'Accommodation', 12000.00),
(5, 2, 'Travel', 13000.00),
(6, 3, 'Accommodation', 10000.00),
(7, 3, 'Travel', 10000.00),
(8, 4, 'Accommodation', 8000.00),
(9, 4, 'Travel', 7000.00),
(10, 5, 'Accommodation', 5000.00),
(11, 5, 'Travel', 5000.00),
(12, 6, 'Accommodation', 7000.00),
(13, 6, 'Travel', 5000.00),
(14, 7, 'Accommodation', 10000.00),
(15, 7, 'Travel', 10000.00),
(16, 8, 'Accommodation', 4000.00),
(17, 8, 'Travel', 4000.00),
(18, 9, 'Accommodation', 10000.00),
(19, 9, 'Travel', 8000.00),
(20, 10, 'Accommodation', 8000.00),
(21, 10, 'Travel', 7000.00),
(22, 11, 'Accommodation', 7000.00),
(23, 11, 'Travel', 7000.00),
(24, 12, 'Accommodation', 20000.00),
(25, 12, 'Travel', 15000.00),
(26, 13, 'Accommodation', 6000.00),
(27, 13, 'Travel', 6000.00),
(28, 14, 'Accommodation', 5000.00),
(29, 14, 'Travel', 5000.00),
(30, 15, 'Accommodation', 9000.00),
(31, 15, 'Travel', 7000.00),
(32, 16, 'Accommodation', 8000.00),
(33, 16, 'Travel', 7000.00),
(34, 17, 'Accommodation', 6000.00),
(35, 17, 'Travel', 6000.00),
(36, 18, 'Accommodation', 5000.00),
(37, 18, 'Travel', 5000.00),
(38, 19, 'Accommodation', 8000.00),
(39, 19, 'Travel', 6000.00),
(40, 20, 'Accommodation', 10000.00),
(41, 20, 'Travel', 10000.00),
(42, 21, 'Accommodation', 5000.00),
(43, 21, 'Travel', 6000.00),
(44, 22, 'Accommodation', 6000.00),
(45, 22, 'Travel', 7000.00),
(46, 23, 'Accommodation', 20000.00),
(47, 23, 'Travel', 20000.00),
(48, 24, 'Accommodation', 7000.00),
(49, 24, 'Travel', 8000.00),
(50, 25, 'Accommodation', 5000.00),
(51, 25, 'Travel', 4000.00),
(52, 26, 'Accommodation', 6000.00),
(53, 26, 'Travel', 6000.00),
(54, 27, 'Accommodation', 5000.00),
(55, 27, 'Travel', 6000.00),
(56, 28, 'Accommodation', 7000.00),
(57, 28, 'Travel', 7000.00),
(58, 29, 'Accommodation', 5000.00),
(59, 29, 'Travel', 5000.00),
(60, 30, 'Accommodation', 4000.00),
(61, 30, 'Travel', 5000.00),
(62, 31, 'Accommodation', 6000.00),
(63, 31, 'Travel', 6000.00),
(64, 32, 'Accommodation', 10000.00),
(65, 32, 'Travel', 10000.00),
(66, 33, 'Accommodation', 8000.00),
(67, 33, 'Travel', 9000.00),
(68, 34, 'Accommodation', 7000.00),
(69, 34, 'Travel', 8000.00),
(70, 35, 'Accommodation', 4000.00),
(71, 35, 'Travel', 6000.00),
(72, 36, 'Accommodation', 6000.00),
(73, 36, 'Travel', 7000.00),
(74, 37, 'Accommodation', 4000.00),
(75, 37, 'Travel', 5000.00),
(76, 38, 'Accommodation', 3000.00),
(77, 38, 'Travel', 5000.00),
(78, 39, 'Accommodation', 5000.00),
(79, 39, 'Travel', 6000.00),
(80, 40, 'Accommodation', 10000.00),
(81, 40, 'Travel', 10000.00),
(82, 41, 'Accommodation', 8000.00),
(83, 41, 'Travel', 10000.00),
(84, 42, 'Accommodation', 7000.00),
(85, 42, 'Travel', 7000.00),
(86, 43, 'Accommodation', 5000.00),
(87, 43, 'Travel', 8000.00),
(88, 44, 'Accommodation', 10000.00),
(89, 44, 'Travel', 7000.00),
(90, 45, 'Accommodation', 8000.00),
(91, 45, 'Travel', 7000.00),
(92, 46, 'Accommodation', 5000.00),
(93, 46, 'Travel', 6000.00),
(94, 47, 'Accommodation', 10000.00),
(95, 47, 'Travel', 10000.00),
(96, 48, 'Accommodation', 7000.00),
(97, 48, 'Travel', 6000.00),
(98, 49, 'Accommodation', 12000.00),
(99, 49, 'Travel', 13000.00),
(100, 50, 'Accommodation', 10000.00),
(101, 50, 'Travel', 12000.00);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `FeedbackID` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `Rating` int(11) DEFAULT NULL,
  `DestinationID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`FeedbackID`, `Description`, `Rating`, `DestinationID`) VALUES
(1, 'Amazing place to visit!', 5, 1),
(2, 'Amazing experience at this hill station!', 5, 1),
(3, 'Not worth the visit, too crowded.', 2, 2),
(4, 'Beautiful beach, loved every moment.', 4, 3),
(5, 'Great cultural experience and nice people.', 5, 4),
(6, 'Expensive but worth it for the scenery.', 4, 5),
(7, 'Average place, could be better.', 3, 6),
(8, 'Wonderful hiking trails, would recommend!', 5, 7),
(9, 'The city has so much to offer, enjoyed it!', 4, 8),
(10, 'Disappointed with the cleanliness of the area.', 2, 9),
(11, 'A fantastic getaway, relaxing and fun!', 5, 10);

-- --------------------------------------------------------

--
-- Table structure for table `itinerary`
--

CREATE TABLE `itinerary` (
  `ItineraryID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL,
  `DestinationID` int(11) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itinerary`
--

INSERT INTO `itinerary` (`ItineraryID`, `UserID`, `DestinationID`, `StartDate`, `EndDate`) VALUES
(1, 1, 1, '2025-01-01', '2025-01-07'),
(2, 2, 2, '2025-01-10', '2025-01-15'),
(3, 3, 3, '2025-01-05', '2025-01-10'),
(4, 4, 4, '2025-01-12', '2025-01-20'),
(5, 5, 5, '2025-01-15', '2025-01-22'),
(6, 6, 6, '2025-02-01', '2025-02-05'),
(7, 7, 7, '2025-02-10', '2025-02-14'),
(8, 8, 8, '2025-02-12', '2025-02-18'),
(9, 9, 9, '2025-02-15', '2025-02-22'),
(10, 10, 10, '2025-03-01', '2025-03-07');

-- --------------------------------------------------------

--
-- Table structure for table `itineraryattraction`
--

CREATE TABLE `itineraryattraction` (
  `ItineraryID` int(11) NOT NULL,
  `AttractionID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `itineraryattraction`
--

INSERT INTO `itineraryattraction` (`ItineraryID`, `AttractionID`) VALUES
(1, 1),
(1, 2),
(1, 3),
(2, 4),
(2, 5),
(3, 6),
(3, 7),
(3, 8),
(4, 9),
(4, 10),
(5, 11),
(5, 12),
(6, 13),
(6, 14),
(7, 15),
(7, 16),
(8, 17),
(8, 18),
(9, 19),
(9, 20),
(10, 21),
(10, 22);

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `ReportID` int(11) NOT NULL,
  `Description` text DEFAULT NULL,
  `TotalSpent` decimal(10,2) DEFAULT NULL,
  `ItineraryID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `report`
--

INSERT INTO `report` (`ReportID`, `Description`, `TotalSpent`, `ItineraryID`) VALUES
(1, 'Spent a week in the hills, amazing views and experiences!', 12000.00, 1),
(2, 'Explored the city, enjoyed shopping and food.', 8000.00, 2),
(3, 'Relaxed at the beach, great weather!', 5000.00, 3),
(4, 'Cultural trip, learned a lot about the history.', 15000.00, 4),
(5, 'Adventure activities, thrilling experience!', 20000.00, 5),
(6, 'A refreshing getaway from the city.', 7000.00, 6),
(7, 'Nature walk and photography, very fulfilling.', 10000.00, 7),
(8, 'Had a great time with family, visited multiple attractions.', 9500.00, 8),
(9, 'Culinary tour, sampled the best local dishes!', 6000.00, 9),
(10, 'Charming place with lots to do, enjoyed every moment.', 11000.00, 10);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Email` varchar(100) DEFAULT NULL,
  `Password` varchar(100) DEFAULT NULL,
  `Phone` varchar(100) DEFAULT NULL,
  `age` int(11) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `Pref_DestinationType` varchar(100) DEFAULT NULL,
  `Pref_ActivityType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`UserID`, `Name`, `Email`, `Password`, `Phone`, `age`, `gender`, `Pref_DestinationType`, `Pref_ActivityType`) VALUES
(1, 'John Doe', 'john@example.com', 'password123', '1234567890', 30, 'Male', 'Hill Station', 'Adventure'),
(2, 'John Doe', 'john@example.com', 'password123', '1234567890', 28, 'Male', 'Hill Station', 'Adventure'),
(3, 'Jane Smith', 'jane@example.com', 'password123', '0987654321', 25, 'Female', 'Metro City', 'Shopping'),
(4, 'Alice Brown', 'alice@example.com', 'password123', '1122334455', 30, 'Female', 'Hill Station', 'Relaxation'),
(5, 'Bob Johnson', 'bob@example.com', 'password123', '2233445566', 35, 'Male', 'Metro City', 'Adventure'),
(6, 'Charlie Davis', 'charlie@example.com', 'password123', '3344556677', 22, 'Male', 'Hill Station', 'Hiking'),
(7, 'Eve Adams', 'eve@example.com', 'password123', '4455667788', 27, 'Female', 'Metro City', 'Cultural'),
(8, 'David Wilson', 'david@example.com', 'password123', '5566778899', 40, 'Male', 'Hill Station', 'Nature'),
(9, 'Fiona Clark', 'fiona@example.com', 'password123', '6677889900', 29, 'Female', 'Metro City', 'Adventure'),
(10, 'George Walker', 'george@example.com', 'password123', '7788990011', 31, 'Male', 'Hill Station', 'Shopping'),
(11, 'Hannah Lee', 'hannah@example.com', 'password123', '8899001122', 24, 'Female', 'Metro City', 'Relaxation');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`AdminID`);

--
-- Indexes for table `attraction`
--
ALTER TABLE `attraction`
  ADD PRIMARY KEY (`AttractionID`),
  ADD KEY `attraction_ibfk_1` (`DestinationID`);

--
-- Indexes for table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`DestinationID`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`ExpenseID`),
  ADD KEY `expense_ibfk_1` (`DestinationID`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`FeedbackID`),
  ADD KEY `feedback_ibfk_1` (`DestinationID`);

--
-- Indexes for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD PRIMARY KEY (`ItineraryID`),
  ADD KEY `itinerary_ibfk_1` (`UserID`),
  ADD KEY `itinerary_ibfk_2` (`DestinationID`);

--
-- Indexes for table `itineraryattraction`
--
ALTER TABLE `itineraryattraction`
  ADD PRIMARY KEY (`ItineraryID`,`AttractionID`),
  ADD KEY `itineraryattraction_ibfk_2` (`AttractionID`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`ReportID`),
  ADD KEY `report_ibfk_1` (`ItineraryID`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`UserID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `AdminID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attraction`
--
ALTER TABLE `attraction`
  MODIFY `AttractionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=152;

--
-- AUTO_INCREMENT for table `destination`
--
ALTER TABLE `destination`
  MODIFY `DestinationID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `ExpenseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `FeedbackID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `itinerary`
--
ALTER TABLE `itinerary`
  MODIFY `ItineraryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `ReportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `attraction`
--
ALTER TABLE `attraction`
  ADD CONSTRAINT `attraction_ibfk_1` FOREIGN KEY (`DestinationID`) REFERENCES `destination` (`DestinationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `expense`
--
ALTER TABLE `expense`
  ADD CONSTRAINT `expense_ibfk_1` FOREIGN KEY (`DestinationID`) REFERENCES `destination` (`DestinationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`DestinationID`) REFERENCES `destination` (`DestinationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `itinerary`
--
ALTER TABLE `itinerary`
  ADD CONSTRAINT `itinerary_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `user` (`UserID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itinerary_ibfk_2` FOREIGN KEY (`DestinationID`) REFERENCES `destination` (`DestinationID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `itineraryattraction`
--
ALTER TABLE `itineraryattraction`
  ADD CONSTRAINT `itineraryattraction_ibfk_1` FOREIGN KEY (`ItineraryID`) REFERENCES `itinerary` (`ItineraryID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `itineraryattraction_ibfk_2` FOREIGN KEY (`AttractionID`) REFERENCES `attraction` (`AttractionID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `report_ibfk_1` FOREIGN KEY (`ItineraryID`) REFERENCES `itinerary` (`ItineraryID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
