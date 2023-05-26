<?php
require_once 'config.php';
include("./inc/headerFR.php");
require_once BL . 'functions/validate.php';
require_once BL . 'functions/db.php';


if (isset($_SESSION['user'])) {
    header("location:" . BURL . 'index.php');
    // die('yes');
}



if (isset($_POST['login'])) {
    // die('yes');
    $email = $_POST['email'];
    // die($email);
    $password = $_POST['password'];

    if (check_empty($email) && check_empty($password)) {
        if (valid_email($email)) {
            // try {
            $sql = "SELECT * FROM `users` WHERE `email` = :email";
            // var_dump($sql);
            $query = $pdo->prepare($sql);
            $query->bindParam(":email", $_POST["email"]);
            $query->execute();
            // var_dump($query);
            $user = $query->fetch(PDO::FETCH_ASSOC);
            // var_dump($user);
            if ($user) {
                $check_pass = password_verify($password, $user['password']);
                if ($check_pass) {
                    $_SESSION["user"] = [
                        "nom" => $user["nom"],
                        "type" => $user["type"]
                    ];
                    if ($_SESSION['user']["type"] == 'admin') {
                        header("location:" . BURLA . 'index.php');
                    } else {
                        header("location:" . BURL . 'index.php');
                    }
                } else {
                    $error_message = "password est incorrect";
                }
            } else {
                //check password
                $error_message = "Email introuvable";

                //end check password
            }
        } else {
            return $error_message = "E-mail incorrect";
        }
    } else {
        $error_message = "Email ou Mot de passe est vide ";
    }
}
?>
<main id="register">
    <div class="container-fluid h-100">
        <div class="div-center">
            <div class="content">
                <h3>Connexion</h3>
                <hr />
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
                    <?php require BL . 'functions/messages.php' ?>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Address Email </label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mot de passe</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3 col-12 text-center" name="login">Connecter</button>
                    <hr />
                    <a href="<?php echo BURL . 'inscription.php'; ?>" class="btn btn-link">Signup</a>
                    <a href="<?php echo BURL . 'forgetPassword.php'; ?>" class="btn btn-link">Mot de passe oublier </a>
                </form>
            </div>
        </div>
        <!-- </div> -->
    </div>
</main>