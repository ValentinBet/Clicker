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


    private function checkpseudoValidity($pseudo)
    {
        if (3 >= strlen($pseudo) || strlen($pseudo) >= 10) return false;
        else return true;
    }

    /**
     * Vérifie si un mot de passe est valide
     * @param string $password Mot de passe à vérifier.
     * @return boolean True si le mot de passe est valide, false sinon.
     */

    private function checkPasswordValidity($password)
    {
        if (3 >= strlen($password) || strlen($password) >= 10) return false;
        else return true;
    }

    /**
     * Vérifie la disponibilité d'un pseudonyme.
     *
     * @param string $pseudo Pseudonyme à vérifier.
     * @return boolean True si le pseudonyme est disponible, false sinon.
     */

    private function checkpseudoAvailability($pseudo)
    {
        //On récupère tous les champs 'pseudo' de la table 'users'
        //Sous forme de tableau
        $res = $this->connection->query('SELECT pseudo FROM users;');
        $pseudos = $res->fetch(PDO::FETCH_ASSOC);
        if ($pseudos != '') {
            if (in_array($pseudo, $pseudos)) return false;
        }
        return true;
    }

    /**
     * Vérifie qu'un couple (pseudonyme, mot de passe) est correct.
     *
     * @param string $pseudo Pseudonyme.
     * @param string $password Mot de passe.
     * @return boolean True si le couple est correct, false sinon.
     */
    public function checkPassword($pseudo, $password)
    {
        $res = $this->connection->query('SELECT pseudo, password FROM users WHERE pseudo ="' . $pseudo . '";');
        $login = $res->fetch(PDO::FETCH_ASSOC);
        if ($pseudo == $login['pseudo'] && $password == $login['password']) return true;
        else return false;
    }

    public function setSessionLogin($login)
    {
        $_SESSION['login'] = $login;
    }

    public function getSessionLogin() {
        if (isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
        } else $login = null;
        return $login;
    }

    public function addUser($pseudo, $password)
    {

        if ($this->checkpseudoAvailability($pseudo) == false) {
            return "Le pseudo existe déjà.";

        } elseif ($this->checkpseudoValidity($pseudo) == false) {
            return "Le pseudo doit contenir entre 3 et 10 caractères.";

        } elseif ($this->checkPasswordValidity($password) == false) {
            return "Le mot de passe doit contenir entre 3 et 10 caractères.";
        } else {
            $res = $this->connection->exec('INSERT INTO users (pseudo, password) VALUES ("' . $pseudo . '", "' . $password . '" );');
            if ($res) return true;
        }

    }


}


