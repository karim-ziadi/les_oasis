<?php
require_once '../../config.php';
if (isset($_POST['deleteSend'])) {
    $id = $_POST['deleteSend'];
    $sql = "DELETE  FROM `cultures` where `id_culture`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
}
