<?php
require_once '../../config.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['displaySend'])) {
    $sql = "SELECT * FROM `villes` ";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    $select = ' 
                <label for="ville">Ville</label>
                <select class="form-control" id="ville" style="    background-color:white">';
    foreach ($result as $key => $vill) {
        $nom = $vill['nom_ville'];
        $id = $vill['id_ville'];
        $select .= '<option value=' . $id . '>' . $nom . '</option>';
    }
    $select .= '</select>';
    echo $select;
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//Show oasis
if (isset($_POST['datailsId'])) {
    $id = $_POST['datailsId'];
    $sql = "SELECT * FROM `oasis` WHERE `id_oasis`=$id";
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
