<?php 
    require_once 'config.php';

if(isset($_SESSION['user']))
    {
        unset($_SESSION["nom"]);
        unset($_SESSION["type"]);
        
        session_destroy();
        header("location:".BURL.'login.php');
        // die('yes');
    }
    else{
        header("location:".BURL.'login.php');
    }


?>