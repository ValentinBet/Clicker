<?php
session_start();

include '/form/loginform.php';


// TODO: A CHANGER -> LUTILISATEUR DOIT APRES ETRE INSCRIT NE PLUS VOIR LE FORMULAIRE DINSCRIPTION
// TODO: A CHANGER -> LES ROUTES SONT MAL FAITES
// TODO: A FAIRE -> SECURISER LA CONNEXION EN SHA256 SUR LA BDD
// TODO: A FAIRE -> CREE UNE PAGE DE LOGIN
// TODO: A FAIRE -> CREE UNE INTERACTION AJAX POUR LE CLICKER


if (isset($_POST['signUpLogin']) && isset($_POST['signUpPassword']) && isset($_POST['signUpPassword2'])) {
    $pseudo = $_POST['signUpLogin'];
    $password = $_POST['signUpPassword'];
    $password2 = $_POST['signUpPassword2'];
    if ($password !== $password2) {
        echo("Le mot de passe et sa confirmation sont différents.");
    } else {

        $res = $db->addUser($pseudo, $password);

        if ($res !== true) {
            echo $res;
        } else {
            $db->setSessionLogin($pseudo);
           echo ("Inscription réussie !");
           require 'route.php';
        }
    }
}

