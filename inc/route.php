<?php

require_once "model/Database.inc.php";

$db = new Database();
if ($db->getSessionLogin() === null) {
    require 'login.php';
} else {
    require "/clicker.php";
}


