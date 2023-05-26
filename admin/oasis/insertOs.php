<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
extract($_POST);


if (
    isset($_POST['nom'])
    && isset($_POST['latitude'])
    && isset($_POST['longitude'])
    && isset($_POST['superficie'])
    && isset($_POST['population'])
    && isset($_POST['alltitude'])
    && isset($_POST['acces_eau'])
    && isset($_POST['type_oasis'])
    && isset($_POST['ville'])
) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['latitude'])
        && check_empty($_POST['longitude'])
        && check_empty($_POST['superficie'])
        && check_empty($_POST['population'])
        && check_empty($_POST['alltitude'])
        && check_empty($_POST['acces_eau'])
        && check_empty($_POST['ville'])
        && check_empty($_POST['type_oasis'])
    ) {
        $sql = "INSERT INTO `oasis` (nom_oasis , latitude,longitude,superficie,population,altitude,acces_eau ,type_oasis,id_ville ) VALUES (:nom_oasis ,:latitude,:longitude,:superficie , :population ,:altitude ,:acces_eau ,:type_oasis,:id_ville )";
        // var_dump($sql);
        $query = $pdo->prepare($sql);
        // var_dump($query);

        $query->bindParam(":nom_oasis", $_POST["nom"]);
        $query->bindParam(":latitude", $_POST["latitude"]);
        $query->bindParam(":longitude", $_POST["longitude"]);
        $query->bindParam(":superficie", $_POST["superficie"]);
        $query->bindParam(":population", $_POST["population"]);
        $query->bindParam(":altitude", $_POST["alltitude"]);
        $query->bindParam(":acces_eau", $_POST["acces_eau"]);
        $query->bindParam(":type_oasis", $_POST["type_oasis"]);
        $query->bindParam(":id_ville", $_POST["ville"]);
        $query->execute();
        $success_message = "Ville est Ajouter";
    } else {
        die('empty');
    }
} else {
    die('nn');
}
