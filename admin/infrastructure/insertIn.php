<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';

extract($_POST);


if (
    isset($_POST['nom'])
    && isset($_POST['type_infra'])
    && isset($_POST['etat'])
    && isset($_POST['description'])
    && isset($_POST['date_construction'])
    && isset($_POST['oasis'])
    && isset($_POST['capacite'])



) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['type_infra'])
        && check_empty($_POST['etat'])
        && check_empty($_POST['description'])
        && check_empty($_POST['date_construction'])
        && check_empty($_POST['capacite'])
        && check_empty($_POST['oasis'])



    ) {
        $sql = "INSERT INTO `infrastructure` (nom_infra , description,date_construction,etat,type_infra,id_oasis,capacite) VALUES (:nom_infra ,:description,:date_construction,:etat , :type_infra ,:id_oasis,:capacite)";
        // var_dump($sql);
        $query = $pdo->prepare($sql);
        var_dump($query);

        $query->bindParam(":nom_infra", $_POST["nom"]);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":date_construction", $_POST["date_construction"]);
        $query->bindParam(":etat", $_POST["etat"]);
        $query->bindParam(":type_infra", $_POST["type_infra"]);
        $query->bindParam(":capacite", $_POST["capacite"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->execute();
    } else {
        die('empty');
    }
} else {
    die('nn');
}
