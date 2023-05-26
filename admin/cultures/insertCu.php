<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';

extract($_POST);


if (
    isset($_POST['nom'])
    && isset($_POST['irrigation_utilisee'])
    && isset($_POST['periode_recolte'])
    && isset($_POST['description'])
    && isset($_POST['rendement_moyen'])
    && isset($_POST['oasis'])


) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['irrigation_utilisee'])
        && check_empty($_POST['periode_recolte'])
        && check_empty($_POST['description'])
        && check_empty($_POST['rendement_moyen'])
        && check_empty($_POST['oasis'])


    ) {
        $sql = "INSERT INTO `cultures` (nom_culture , description,rendement_moyen,periode_recolte,irrigation_utilisee,id_oasis) VALUES (:nom_culture ,:description,:rendement_moyen,:periode_recolte , :irrigation_utilisee ,:id_oasis)";
        // var_dump($sql);
        $query = $pdo->prepare($sql);
        // var_dump($query);

        $query->bindParam(":nom_culture", $_POST["nom"]);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":rendement_moyen", $_POST["rendement_moyen"]);
        $query->bindParam(":periode_recolte", $_POST["periode_recolte"]);
        $query->bindParam(":irrigation_utilisee", $_POST["irrigation_utilisee"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->execute();
    } else {
        die('empty');
    }
} else {
    die('nn');
}
