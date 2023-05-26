<?php

require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
extract($_POST);


if (isset($_POST['Snom']) && isset($_POST['ScodePostal'])) {
    if (check_empty($_POST['Snom']) && check_empty($_POST['ScodePostal'])) {
        $sql = "INSERT INTO `villes` (nom_ville , code_postal) VALUES (:nom_ville,:code_postal)";
        $query = $pdo->prepare($sql);

        $query->bindParam(":nom_ville", $_POST["Snom"]);
        $query->bindParam(":code_postal", $_POST["ScodePostal"]);
        $query->execute();
        $success_message = "Ville est Ajouter";
    } else {
        die('empty');
    }
} else {
    die('nn');
}
