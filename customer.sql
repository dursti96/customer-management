CREATE TABLE `customer` (
  `CompanyName` varchar(128) NOT NULL,
  `ContactPerson` varchar(128) NOT NULL,
  `PhoneNr` varchar(16) NOT NULL,
  `CreatedBy` varchar(128) NOT NULL,
  `CreatedAt` datetime NOT NULL,
  `LastEdit` datetime NOT NULL
)

ALTER TABLE `customer`
  ADD PRIMARY KEY (`ContactPerson`),
  ADD KEY `CreatedBy` (`CreatedBy`);
  
ALTER TABLE `customer`
  ADD CONSTRAINT `customer` FOREIGN KEY (`CreatedBy`) REFERENCES `users` (`usersUid`);
COMMIT;
