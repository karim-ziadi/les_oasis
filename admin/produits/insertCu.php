<?php
require_once '../../config.php';
require_once BL . 'functions/validate.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
extract($_POST);


if (
    isset($_POST['nom'])
    && isset($_POST['prix'])
    && isset($_POST['periode_recolte'])
    && isset($_POST['description'])
    && isset($_POST['rendement_moyen'])
    && isset($_POST['oasis'])
    && isset($_POST['utilisation'])



) {
    if (
        check_empty($_POST['nom'])
        && check_empty($_POST['prix'])
        && check_empty($_POST['periode_recolte'])
        && check_empty($_POST['description'])
        && check_empty($_POST['rendement_moyen'])
        && check_empty($_POST['utilisation'])
        && check_empty($_POST['oasis'])



    ) {
        $sql = "INSERT INTO `produits` (nom_produit , description,rendement_moyen,periode_recolte,prix,id_oasis,utilisation) VALUES (:nom_produit ,:description,:rendement_moyen,:periode_recolte , :prix ,:id_oasis,:utilisation)";
        // var_dump($sql);
        $query = $pdo->prepare($sql);
        var_dump($query);

        $query->bindParam(":nom_produit", $_POST["nom"]);
        $query->bindParam(":description", $_POST["description"]);
        $query->bindParam(":rendement_moyen", $_POST["rendement_moyen"]);
        $query->bindParam(":periode_recolte", $_POST["periode_recolte"]);
        $query->bindParam(":prix", $_POST["prix"]);
        $query->bindParam(":utilisation", $_POST["utilisation"]);
        $query->bindParam(":id_oasis", $_POST["oasis"]);
        $query->execute();
    } else {
        die('empty');
    }
} else {
    die('nn');
}
