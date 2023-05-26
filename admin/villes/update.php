<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['updateId'])) {
    $id = $_POST['updateId'];
    $sql = "SELECT * FROM `villes` where `id_ville`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $vill) {
        $response = $vill;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenData'])) {
    if (check_empty($_POST['nameVille']) && check_empty($_POST['codeVille'])) {
        $id = $_POST['hiddenData'];
        $nom = $_POST['nameVille'];
        $code = $_POST['codeVille'];

        $sql = "UPDATE `villes` SET nom_ville=:nom_ville , code_postal=:code_postal WHERE `id_ville`=$id";
        $query = $pdo->prepare($sql);
        $query->bindParam(':nom_ville', $nom);
        $query->bindParam(':code_postal', $code);
        $query->execute();
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
