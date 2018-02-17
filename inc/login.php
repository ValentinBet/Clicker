<?php
session_start();

    include '/form/loginform.php';
if (isset($_POST['signUpLogin']) && isset($_POST['signUpPassword']) && isset($_POST['signUpPassword2'])) {
    $username = $_POST['signUpLogin'];
    $password = $_POST['signUpPassword'];
    $password2 = $_POST['signUpPassword2'];
    if ($password !== $password2) {
        echo ("Le mot de passe et sa confirmation sont différents.");
    } else {


    }
}

