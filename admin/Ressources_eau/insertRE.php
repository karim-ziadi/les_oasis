<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
extract($_POST);


if (
    isset($_POST['quantite_eau'])
    && isset($_POST['qualite_eau'])
    && isset($_POST['utilisation_eau'])
    && isset($_POST['source_eau'])
    && isset($_POST['oasis'])
) {
    if (
        check_empty($_POST['qualite_eau'])
        && check_empty($_POST['quantite_eau'])
        && check_empty($_POST['utilisation_eau'])
        && check_empty($_POST['source_eau'])
        && check_empty($_POST['oasis'])
    ) {
        $sql = "INSERT INTO `ressources_eau`(source_eau, qualite_eau, quantite_eau, utilisation_eau, id_oasis) VALUES (:source_eau,:qualite_eau,:quantite_eau,:utilisation_eau,:id_oasis)";
        // var_dump($sql);
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":utilisation_eau", $_POST["utilisation_eau"]);
        $query->bindParam(":source_eau", $_POST["source_eau"]);
        $query->bindParam(":quantite_eau", $_POST["quantite_eau"]);
        $query->bindParam(":qualite_eau", $_POST["qualite_eau"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->execute();
    } else {
        die('empty');
    }
} else {
    die('nn');
}
