<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['oasisId'])) {
    $id = $_POST['oasisId'];
    $sql = "SELECT * FROM `oasis` where `id_oasis`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $oasis) {
        $response = $oasis;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenDataOS'])) {
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
        $id = $_POST['hiddenDataOS'];
        $nom = $_POST['nom'];
        $latitude = $_POST['latitude'];
        $longitude = $_POST['longitude'];
        $superficie = $_POST['superficie'];
        $population = $_POST['population'];
        $alltitude = $_POST['alltitude'];
        $acces_eau = $_POST['acces_eau'];
        $ville = $_POST['ville'];
        $type_oasis = $_POST['type_oasis'];
        $sql = "UPDATE `oasis` SET nom_oasis=:nom_oasis , latitude=:latitude,longitude=:longitude,superficie=:superficie,population=:population,altitude=:altitude,acces_eau=:acces_eau ,type_oasis=:type_oasis,id_ville=:id_ville  WHERE `id_oasis`=$id";
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
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
