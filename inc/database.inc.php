<?php


$dbHost = "localhost";
$dbBd = "Clicker";
$dbPass = "";
$dbLogin = "root";
$url = 'mysql:host=' . $dbHost . ';dbname=' . $dbBd;
$pdo = new PDO($url, $dbLogin, $dbPass);


$req = $pdo->prepare(' USE Clicker;
                        
                        CREATE TABLE IF NOT EXISTS users (
							pseudo VARCHAR(20) NOT NULL,
							password VARCHAR(50) NOT NULL,
							PRIMARY KEY (pseudo)
						);
						
						CREATE TABLE IF NOT EXISTS score (
						pseudo VARCHAR(20) NOT NULL,
						score INT(255) NOT NULL,
						PRIMARY KEY (score)
						
						);
						
						ALTER TABLE score ADD CONSTRAINT fk_pseudo FOREIGN KEY (pseudo) REFERENCES users(pseudo);
	');
