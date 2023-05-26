<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (isset($_POST['culId'])) {
    $id = $_POST['culId'];
    $sql = "SELECT * FROM `infrastructure` where `id_infra`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $infra) {
        $response = $infra;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenDataIN'])) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['type_infra'])
        && check_empty($_POST['etat'])
        && check_empty($_POST['description'])
        && check_empty($_POST['date_construction'])
        && check_empty($_POST['capacite'])
        && check_empty($_POST['oasis'])

    ) {
        $id = $_POST['hiddenDataIN'];
        // var_dump($id);

        $sql = "UPDATE `infrastructure` SET nom_infra=:nom_infra , description=:description,type_infra=:type_infra,etat=:etat,capacite=:capacite ,id_oasis=:id_oasis , date_construction=:date_construction  WHERE `id_infra`=$id";
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":nom_infra", $_POST["nom"]);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":type_infra", $_POST["type_infra"]);
        $query->bindParam(":etat", $_POST["etat"]);
        $query->bindParam(":capacite", $_POST["capacite"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->bindParam(":date_construction", $_POST["date_construction"]);

        $query->execute();
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
