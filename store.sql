-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 08 avr. 2021 à 09:19
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 8.0.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `store`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` char(50) NOT NULL DEFAULT 'divers'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Chaussure'),
(2, 'Vetement'),
(3, 'Livre'),
(4, 'Musique'),
(5, 'Technologie'),
(8, 'Santée');

-- --------------------------------------------------------

--
-- Structure de la table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `ref_cde` char(50) NOT NULL,
  `date` date NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `ref_cde`, `date`, `status`) VALUES
(31, 2, 'cmd16172765952', '2021-04-01', 1),
(32, 1, 'CMD#16172768981', '2021-04-01', 1),
(33, 2, 'CMD#16172864092', '2021-04-01', 1),
(34, 2, 'CMD#16176925332', '2021-04-06', 1);

-- --------------------------------------------------------

--
-- Structure de la table `order_lines`
--

CREATE TABLE `order_lines` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `order_lines`
--

INSERT INTO `order_lines` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(41, 31, 3, 1),
(42, 31, 1, 1),
(43, 31, 4, 2),
(44, 32, 4, 1),
(45, 33, 4, 1),
(46, 33, 7, 1),
(47, 34, 7, 6);

-- --------------------------------------------------------

--
-- Structure de la table `order_status`
--

CREATE TABLE `order_status` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `order_status`
--

INSERT INTO `order_status` (`id`, `name`) VALUES
(1, 'En cours de validation'),
(2, 'Validé'),
(3, 'Expédié'),
(4, 'Livré');

-- --------------------------------------------------------

--
-- Structure de la table `products`
--

CREATE TABLE `products` (
  `id_prod` int(11) NOT NULL,
  `name` char(50) NOT NULL,
  `category_id` int(11) NOT NULL DEFAULT 0,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `unit_price` char(10) NOT NULL DEFAULT '0.00',
  `description` char(255) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `products`
--

INSERT INTO `products` (`id_prod`, `name`, `category_id`, `quantity`, `unit_price`, `description`, `image`) VALUES
(1, 'Jordan 4 white cement (2012)', 1, 2, '345.00', 'Cette paire de jordan est l\'une des paires de chaussures de basket le plus convoitée.', '/Jordan-4-white-cement-2012'),
(2, 'Jordan 1 balvin', 1, 0, '359.99', 'Paire de chaussure avec la silhouette iconique de la Jordan 1 en version très colorée.', '/Jordan-1-balvin'),
(3, 'Yeezy 350 Bred', 1, 35, '310', 'Paire de chaussure de la marque du célèbre Kanye West. Ce modèle est composé d&#39;une base noire avec des inscriptions rouges. Grâce à la technologie Adidas Boost vos pieds seront confortablement à l’intérieur.', '/yeezy-350-bred'),
(4, 'Jordan 4 bred', 1, 1, '345.00', 'Paire de Jordan au couleurs de l&#39;équipe de Michael Jordan, les Chicago Bulls', '/Jordan-4-bred'),
(5, 'SCH - JVLIVS II (Marseille)', 4, 55, '19.99', 'Le dernier album de SCH sortie le 19/03/2021 composé de 19 titres et 2 titres bonus.', '/sch-jvlivs-2-marseille'),
(6, 'SCH - JVLIVS II (Gibraltar)', 4, 45, '19.99', 'Le dernier album de SCH sortie le 19/03/2021 composé de 19 titres et 2 titres bonus.', '/sch-jvlivs-2-gibraltar'),
(7, 'Playstation 5 digital edition', 5, 93, '450', 'La dernière console de Sony, équipée d\'un ssd de dernière génération. Livrée sans lecteur blu-ray', '/playstation-5-digital-edition'),
(8, 'Playstation 5', 5, 15, '550.95', 'La dernière console de Sony, équipée d\'un ssd de dernière génération. Livrée avec un lecteur blu-ray', '/playstation-5'),
(9, 'XboX Series X', 5, 99, '499.99', 'Dernière console de Microsoft. Elle possède un SSD ce qui rends le chargement de tout vos jeux très rapide. Vous pouvez bénéficiez du Xbox GamePass pour accédez à un catalogue de jeux sans les payer.', '/xbox-series-x');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `lastname` char(50) NOT NULL,
  `firstname` char(50) NOT NULL,
  `email` char(100) NOT NULL,
  `password` char(30) NOT NULL,
  `statut_id` int(11) NOT NULL,
  `cart` varchar(1024) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `lastname`, `firstname`, `email`, `password`, `statut_id`, `cart`) VALUES
(1, 'OILLO', 'Sebastien', 'oillosebast@gmail.com', '1234', 1, 'a:0:{}'),
(2, 'oillo', 'Jean-Pierre', 'oillojp@gmail.com', '1234', 2, 'a:0:{}'),
(3, 'OILLO', 'Sébastien', 'oillopatou@yahoo.fr', 'Sebast2711', 2, ''),
(4, 'OILLO', 'Patricia', 'oillopatricia@yahoo.fr', 'Sebast2711+-', 2, '');

-- --------------------------------------------------------

--
-- Structure de la table `user_status`
--

CREATE TABLE `user_status` (
  `id` int(11) NOT NULL,
  `status` char(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `user_status`
--

INSERT INTO `user_status` (`id`, `status`) VALUES
(1, 'admin'),
(2, 'client');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`customer_id`),
  ADD KEY `status` (`status`);

--
-- Index pour la table `order_lines`
--
ALTER TABLE `order_lines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Index pour la table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id_prod`),
  ADD KEY `category_id` (`category_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `statut_id` (`statut_id`);

--
-- Index pour la table `user_status`
--
ALTER TABLE `user_status`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `order_lines`
--
ALTER TABLE `order_lines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT pour la table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `products`
--
ALTER TABLE `products`
  MODIFY `id_prod` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `user_status`
--
ALTER TABLE `user_status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`status`) REFERENCES `order_status` (`id`);

--
-- Contraintes pour la table `order_lines`
--
ALTER TABLE `order_lines`
  ADD CONSTRAINT `order_lines_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_lines_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id_prod`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`statut_id`) REFERENCES `user_status` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
