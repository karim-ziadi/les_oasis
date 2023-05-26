<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (isset($_POST['culId'])) {
    $id = $_POST['culId'];
    $sql = "SELECT * FROM `meteo` where `id_meteo`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $meteo) {
        $response = $meteo;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenDataRE'])) {
    if (
        check_empty($_POST['temperature_moyenne'])
        && check_empty($_POST['humidite_relative'])
        && check_empty($_POST['pluviometrie'])
        && check_empty($_POST['vitesse_vent'])
        && check_empty($_POST['oasis'])

    ) {
        $id = $_POST['hiddenDataRE'];
        // var_dump($id);
        $sql = "UPDATE `meteo` SET  pluviometrie=:pluviometrie,temperature_moyenne=:temperature_moyenne,	humidite_relative=:humidite_relative,id_oasis=:id_oasis , vitesse_vent=:vitesse_vent  WHERE `id_meteo`=$id";
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":pluviometrie", $_POST["pluviometrie"]);
        $query->bindParam(":temperature_moyenne", $_POST["temperature_moyenne"]);
        $query->bindParam(":humidite_relative", $_POST["humidite_relative"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->bindParam(":vitesse_vent", $_POST["vitesse_vent"]);

        $query->execute();
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
