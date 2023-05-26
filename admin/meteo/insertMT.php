<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';

extract($_POST);


if (
    isset($_POST['temperature_moyenne'])
    && isset($_POST['vitesse_vent'])
    && isset($_POST['humidite_relative'])
    && isset($_POST['pluviometrie'])
    && isset($_POST['oasis'])
) {
    if (
        check_empty($_POST['temperature_moyenne'])
        && check_empty($_POST['humidite_relative'])
        && check_empty($_POST['pluviometrie'])
        && check_empty($_POST['vitesse_vent'])
        && check_empty($_POST['oasis'])
    ) {
        $sql = "INSERT INTO `meteo`(pluviometrie, vitesse_vent, temperature_moyenne, humidite_relative, id_oasis) VALUES (:pluviometrie,:vitesse_vent,:temperature_moyenne,:humidite_relative,:id_oasis)";
        // var_dump($sql);
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":humidite_relative", $_POST["humidite_relative"]);
        $query->bindParam(":pluviometrie", $_POST["pluviometrie"]);
        $query->bindParam(":temperature_moyenne", $_POST["temperature_moyenne"]);
        $query->bindParam(":vitesse_vent", $_POST["vitesse_vent"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->execute();
    } else {
        die('empty');
    }
} else {
    die('nn');
}
