<?php
require_once '../../config.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['displaySend'])) {
    $sql = "SELECT * FROM `oasis` ";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    $select = ' 
                <label for="oasis">Oasis</label>
                <select class="form-control" id="oasis" style="    background-color:white">';
    foreach ($result as $key => $oasis) {
        $nom = $oasis['nom_oasis'];
        $id = $oasis['id_oasis'];
        $select .= '<option value=' . $id . '>' . $nom . '</option>';
    }
    $select .= '</select>';
    echo $select;
} else {
    $response['status'] = 200;
}
//Show ressources_eau
if (isset($_POST['datailsId'])) {
    $id = $_POST['datailsId'];
    $sql = "SELECT * FROM `ressources_eau` WHERE `id_ressource_eau`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $ressources_eau) {
        $response = $ressources_eau;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
