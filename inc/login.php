<?php
session_start();

include '/form/loginform.php';
require_once '/model/Database.inc.php';


if (isset($_POST['signUpLogin']) && isset($_POST['signUpPassword']) && isset($_POST['signUpPassword2'])) {
    $pseudo = $_POST['signUpLogin'];
    $password = $_POST['signUpPassword'];
    $password2 = $_POST['signUpPassword2'];
    if ($password !== $password2) {
        echo("Le mot de passe et sa confirmation sont différents.");
    } else {
        $db = new Database();
        $res = $db->addUser($pseudo, $password);

        if ($res !== true) {
            echo $res;
        } else {
            $db->setSessionLogin($pseudo);
           echo ("Inscription réussie !");
        }
    }
}

