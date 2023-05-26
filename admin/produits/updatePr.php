<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['culId'])) {
    $id = $_POST['culId'];
    $sql = "SELECT * FROM `produits` where `id_produit`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);
    $response = array();
    foreach ($result as $key => $produit) {
        $response = $produit;
    }
    echo json_encode($response);
} else {
    $response['status'] = 200;
    $response['message'] = "ville ne pas trouve";
}
//update query
if (isset($_POST['hiddenDataPR'])) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['utilisation'])
        && check_empty($_POST['periode_recolte'])
        && check_empty($_POST['description'])
        && check_empty($_POST['rendement_moyen'])
        && check_empty($_POST['oasis'])
        && check_empty($_POST['prix'])

    ) {
        $id = $_POST['hiddenDataPR'];
        // var_dump($id);

        $sql = "UPDATE `produits` SET nom_produit=:nom_produit , description=:description,rendement_moyen=:rendement_moyen,periode_recolte=:periode_recolte,utilisation=:utilisation ,id_oasis=:id_oasis , prix=:prix  WHERE `id_produit`=$id";
        $query = $pdo->prepare($sql);
        // var_dump($query);
        $query->bindParam(":nom_produit", $_POST["nom"]);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":rendement_moyen", $_POST["rendement_moyen"]);
        $query->bindParam(":periode_recolte", $_POST["periode_recolte"]);
        $query->bindParam(":utilisation", $_POST["utilisation"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->bindParam(":prix", $_POST["prix"]);

        $query->execute();
        $response['status'] = 200;
    } else {
        $response['status'] = false;
    }
}
