-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Mar 30, 2023 alle 23:26
-- Versione del server: 10.4.25-MariaDB
-- Versione PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `5ai_concil_dbecommerce`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `addresses`
--

CREATE TABLE `addresses` (
  `ID` int(11) NOT NULL,
  `Address` varchar(64) NOT NULL,
  `ZIPcode` varchar(9) NOT NULL,
  `Country` varchar(64) NOT NULL,
  `City` varchar(64) NOT NULL,
  `Province` varchar(64) NOT NULL,
  `ShippingDefault` tinyint(1) DEFAULT NULL,
  `PaymentDefault` tinyint(1) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `categories`
--

CREATE TABLE `categories` (
  `ID` int(11) NOT NULL,
  `Type` varchar(254) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `contains`
--

CREATE TABLE `contains` (
  `ArticleID` int(11) NOT NULL,
  `CartID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `includes`
--

CREATE TABLE `includes` (
  `WishListID` int(11) NOT NULL,
  `ArticleID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `OrderDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `DeliveryDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `ShippingCost` float NOT NULL,
  `PaymentAddressID` int(11) NOT NULL,
  `ShippingAddressID` int(11) NOT NULL,
  `PaymentMethodID` int(11) NOT NULL,
  `CartID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `payment_methods`
--

CREATE TABLE `payment_methods` (
  `ID` int(11) NOT NULL,
  `Method` enum('PayPal','Credit Card','Debit Card') NOT NULL,
  `Email` varchar(64) DEFAULT NULL,
  `CardHolder` varchar(64) DEFAULT NULL,
  `CardNumber` varchar(16) DEFAULT NULL,
  `ExpirationDate` varchar(7) DEFAULT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `Title` varchar(254) NOT NULL,
  `Description` text NOT NULL,
  `Seller` varchar(254) NOT NULL,
  `State` enum('New','Used') NOT NULL,
  `Price` float NOT NULL,
  `Discount` int(3) NOT NULL DEFAULT 0,
  `Quantity` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `reviews`
--

CREATE TABLE `reviews` (
  `ID` int(11) NOT NULL,
  `ArticleID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Title` varchar(50) NOT NULL,
  `Stars` enum('1','2','3','4','5') NOT NULL,
  `Content` text NOT NULL,
  `Date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `shopping_cart`
--

CREATE TABLE `shopping_cart` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `ID` int(11) NOT NULL,
  `FirstName` varchar(32) NOT NULL,
  `LastName` varchar(32) NOT NULL,
  `E-mail` varchar(64) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Indirizzo` varchar(64) NOT NULL,
  `BirthDate` date NOT NULL,
  `PhoneNumber` varchar(12) NOT NULL,
  `Seller` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struttura della tabella `wishlist`
--

CREATE TABLE `wishlist` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`);

--
-- Indici per le tabelle `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `contains`
--
ALTER TABLE `contains`
  ADD PRIMARY KEY (`ArticleID`,`CartID`),
  ADD KEY `CartContains` (`CartID`);

--
-- Indici per le tabelle `includes`
--
ALTER TABLE `includes`
  ADD PRIMARY KEY (`WishListID`,`ArticleID`),
  ADD KEY `ArticleID` (`ArticleID`);

--
-- Indici per le tabelle `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `PaymentAddress` (`PaymentAddressID`),
  ADD KEY `PaymentMethod` (`PaymentMethodID`),
  ADD KEY `ShippingAddress` (`ShippingAddressID`),
  ADD KEY `CartOrder` (`CartID`) USING BTREE;

--
-- Indici per le tabelle `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserPaymentMethod` (`UserID`);

--
-- Indici per le tabelle `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProductCategoryID` (`CategoryID`);

--
-- Indici per le tabelle `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ReviewProductID` (`ArticleID`),
  ADD KEY `ReviewUserID` (`UserID`);

--
-- Indici per le tabelle `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ShoppingCartUserID` (`UserID`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- Indici per le tabelle `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `WishListUserID` (`UserID`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `addresses`
--
ALTER TABLE `addresses`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `categories`
--
ALTER TABLE `categories`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `payment_methods`
--
ALTER TABLE `payment_methods`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `reviews`
--
ALTER TABLE `reviews`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `shopping_cart`
--
ALTER TABLE `shopping_cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT per la tabella `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Limiti per la tabella `contains`
--
ALTER TABLE `contains`
  ADD CONSTRAINT `CartContains` FOREIGN KEY (`CartID`) REFERENCES `shopping_cart` (`ID`);

--
-- Limiti per la tabella `includes`
--
ALTER TABLE `includes`
  ADD CONSTRAINT `includes_ibfk_1` FOREIGN KEY (`ArticleID`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `includes_ibfk_2` FOREIGN KEY (`WishListID`) REFERENCES `wishlist` (`ID`);

--
-- Limiti per la tabella `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `Cart` FOREIGN KEY (`CartID`) REFERENCES `shopping_cart` (`ID`),
  ADD CONSTRAINT `PaymentAddress` FOREIGN KEY (`PaymentAddressID`) REFERENCES `addresses` (`ID`),
  ADD CONSTRAINT `PaymentMethod` FOREIGN KEY (`PaymentMethodID`) REFERENCES `payment_methods` (`ID`),
  ADD CONSTRAINT `ShippingAddress` FOREIGN KEY (`ShippingAddressID`) REFERENCES `addresses` (`ID`);

--
-- Limiti per la tabella `payment_methods`
--
ALTER TABLE `payment_methods`
  ADD CONSTRAINT `UserPaymentMethod` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Limiti per la tabella `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `ProductCategoryID` FOREIGN KEY (`CategoryID`) REFERENCES `categories` (`ID`);

--
-- Limiti per la tabella `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `ReviewProductID` FOREIGN KEY (`ArticleID`) REFERENCES `products` (`ID`),
  ADD CONSTRAINT `ReviewUserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Limiti per la tabella `shopping_cart`
--
ALTER TABLE `shopping_cart`
  ADD CONSTRAINT `ShoppingCartUserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);

--
-- Limiti per la tabella `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `WishListUserID` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
