<?php
require_once '../../config.php';
if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
if (isset($_POST['deleteSend'])) {
    $id = $_POST['deleteSend'];
    $sql = "DELETE  FROM `oasis` where `id_oasis`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
}
