<?php
include('../../config.php');




if (!isset($_SESSION['user']["type"])) {
    header("location:" . BURL . 'login.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php if (isset($pageName)) {
                echo $pageName;
            } ?></title>
    <!-- <link rel="stylesheet" href="../asset/sideBar/sidBar.css"> -->
    <link rel="stylesheet" href="<?php echo ASSETS; ?>sideBar/sidBar.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link href="https://cdn.datatables.net/v/bs4/dt-1.13.4/datatables.min.css" rel="stylesheet" />

</head>

<body id="body-pd">
    <header class="header " id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
        <div class="col-6">
            <div class="input-group ">
                <input type="text" class="form-control" placeholder="Recherche ....">
                <div class="input-group-append">
                    <button class="btn btn-secondary" type="button">
                        <i class='bx bx-search'></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- <div class="header_img"> <img src="https://i.imgur.com/hczKIze.jpg" alt=""> </div> -->
    </header>
    <div class="l-navbar mb-5" id="nav-bar">
        <nav class="nav">
            <div>
                <a href="<?php echo BURLA . 'index.php'; ?>" class="nav_logo text-decoration-none ">
                    <i class='bx bx-layer nav_logo-icon'></i>
                    <span class="nav_logo-name">Les Oasis</span>
                </a>
                <div class="nav_list">
                    <a href="<?php echo BURLA . 'villes/index.php'; ?>" class="nav_link   text-decoration-none <?php if ($pageName == 'villes')  echo "active" ?> ">
                        <i class='bx bx-buildings nav_icon'></i>
                        <span class="nav_name">Villes</span>
                    </a>
                    <a href="<?php echo BURLA . 'oasis/index.php'; ?>" class="nav_link text-decoration-none <?php if ($pageName == 'oasis')  echo "active" ?> ">
                        <i class='bx bx-user nav_icon'></i>
                        <span class="nav_name">Oasis</span>
                    </a>
                    <a href="<?php echo BURLA . 'cultures/index.php'; ?>" class="nav_link text-decoration-none <?php if ($pageName == 'cultures')  echo "active" ?>">
                        <i class='bx bx-book-open nav_icon'></i>
                        <span class="nav_name">Cultures</span>
                    </a>
                    <a href="<?php echo BURLA . 'produits/index.php'; ?>" class="nav_link text-decoration-none <?php if ($pageName == 'produits')  echo "active" ?> ">
                        <i class='bx bxs-parking nav_icon'></i>
                        <span class=" nav_name">Produits</span>
                    </a>
                    <a href="<?php echo BURLA . 'infrastructure/index.php'; ?>" class="nav_link text-decoration-none <?php if ($pageName == 'infrastructure')  echo "active" ?>">

                        <i class='bx bxs-component nav_icon'></i>
                        <span class=" nav_name">Infrastructure</span>
                    </a>
                    <a href="<?php echo BURLA . 'Ressources_eau/index.php'; ?>" class="nav_link text-decoration-none <?php if ($pageName == 'Ressources Eau')  echo "active" ?>">
                        <i class='bx bx-water nav_icon'></i>
                        <span class="nav_name">Ressources_eau</span>
                    </a>
                    <a href="<?php echo BURLA . 'meteo/index.php'; ?>" class="nav_link text-decoration-none <?php if ($pageName == 'Meteo')  echo "active" ?>">
                        <i class='bx bx-sun nav_icon'></i>
                        <span class="nav_name">Meteo</span>
                    </a>
                </div>
            </div>
            <form action="" method="POST">
                <a href="<?php echo BURL . 'logout.php'; ?>" class="nav_link text-decoration-none "> <i class='bx bx-log-out nav_icon'></i> <span class="nav_name">Deconnexion</span> </a>
            </form>
        </nav>
    </div>
    <!--Container Main start-->
    <div class="container">