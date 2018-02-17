<?php
/**
 * Created by PhpStorm.
 * User: Betrancourt Valentin
 * Date: 17/02/2018
 * Time: 18:51
 */

class Database
{

    private $connection;

    public function __construct()
    {

// Initialisation de la base de données en PDO et créations des tables

        $dbHost = "localhost";
        $dbBd = "Clicker";
        $dbPass = "";
        $dbLogin = "root";
        $url = 'mysql:host=' . $dbHost . ';dbname=' . $dbBd;
        $this->connection = new PDO($url, $dbLogin, $dbPass);
        $this->createDataBase();

    }


    private function createDatabase()
    {

        $this->connection->exec(' USE Clicker;
                        
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

    }


    private function checkNicknameValidity($nickname) {
        if (3>=strlen($nickname) || strlen($nickname)>=10) return false;
        else return true;
    }

    /**
     * Vérifie si un mot de passe est valide

     * @param string $password Mot de passe à vérifier.
     * @return boolean True si le mot de passe est valide, false sinon.
     */

    private function checkPasswordValidity($password) {
        if (3>=strlen($password) || strlen($password)>=10) return false;
        else return true;
    }

    /**
     * Vérifie la disponibilité d'un pseudonyme.
     *
     * @param string $nickname Pseudonyme à vérifier.
     * @return boolean True si le pseudonyme est disponible, false sinon.
     */

    private function checkNicknameAvailability($nickname) {
        //On récupère tous les champs 'nickname' de la table 'users'
        //Sous forme de tableau
        $res = $this->connection->query('SELECT nickname FROM users;');
        $nicknames = $res->fetch(PDO::FETCH_ASSOC);
        if ($nicknames != '') {
            if (in_array($nickname, $nicknames)) return false;
        }
        return true;
    }

    /**
     * Vérifie qu'un couple (pseudonyme, mot de passe) est correct.
     *
     * @param string $nickname Pseudonyme.
     * @param string $password Mot de passe.
     * @return boolean True si le couple est correct, false sinon.
     */
    public function checkPassword($nickname, $password) {
        $res = $this->connection->query('SELECT nickname, password FROM users WHERE nickname ="'.$nickname.'";');
        $login = $res->fetch(PDO::FETCH_ASSOC);
        if ($nickname == $login['nickname'] && $password == $login['password']) return true;
        else return false;
    }

}


