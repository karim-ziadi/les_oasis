<?php
require_once '../../config.php';
if (isset($_POST['deleteSend'])) {
    $id = $_POST['deleteSend'];
    $sql = "DELETE  FROM `infrastructure` where `id_infra`=$id";
    $query = $pdo->prepare($sql);
    $query->execute();
}
