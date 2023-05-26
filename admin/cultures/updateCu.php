<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (isset($_POST['culId'])) {
    $id = $_POST['culId'];
    $sql = "SELECT * FROM `cultures` where `id_culture`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $culture) {
        $response = $culture;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenDataCU'])) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['irrigation_utilisee'])
        && check_empty($_POST['periode_recolte'])
        && check_empty($_POST['description'])
        && check_empty($_POST['rendement_moyen'])
        && check_empty($_POST['oasis'])
    ) {
        $id = $_POST['hiddenDataCU'];
        // var_dump($id);

        $sql = "UPDATE `cultures` SET nom_culture=:nom_culture , description=:description,rendement_moyen=:rendement_moyen,periode_recolte=:periode_recolte,irrigation_utilisee=:irrigation_utilisee ,id_oasis=:id_oasis  WHERE `id_culture`=$id";
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":nom_culture", $_POST["nom"]);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":rendement_moyen", $_POST["rendement_moyen"]);
        $query->bindParam(":periode_recolte", $_POST["periode_recolte"]);
        $query->bindParam(":irrigation_utilisee", $_POST["irrigation_utilisee"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->execute();
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
