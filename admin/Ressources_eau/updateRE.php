<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['culId'])) {
    $id = $_POST['culId'];
    $sql = "SELECT * FROM `ressources_eau` where `id_ressource_eau`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $reseau) {
        $response = $reseau;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenDataRE'])) {
    if (
        check_empty($_POST['source_eau'])
        && check_empty($_POST['utilisation_eau'])
        && check_empty($_POST['qualite_eau'])
        && check_empty($_POST['quantite_eau'])
        && check_empty($_POST['oasis'])

    ) {
        $id = $_POST['hiddenDataRE'];
        // var_dump($id);

        $sql = "UPDATE `ressources_eau` SET  qualite_eau=:qualite_eau,source_eau=:source_eau,utilisation_eau=:utilisation_eau,id_oasis=:id_oasis , quantite_eau=:quantite_eau  WHERE `id_ressource_eau`=$id";
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":qualite_eau", $_POST["qualite_eau"]);
        $query->bindParam(":source_eau", $_POST["source_eau"]);
        $query->bindParam(":utilisation_eau", $_POST["utilisation_eau"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->bindParam(":quantite_eau", $_POST["quantite_eau"]);

        $query->execute();
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
