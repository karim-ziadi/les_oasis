<?php
require_once 'config.php';
include("./inc/headerFR.php");
require_once BL . 'functions/validate.php';
require_once BL . 'functions/db.php';
if (isset($_SESSION['user'])) {
    header("location:" . BURL . 'index.php');
    // die('yes');
}
//verifier le formulaire
if (!empty($_POST)) {
    //formulaire envoyer
    //verifier que tous les champs rquis son remplis
    if (
        isset(
            $_POST["nom"],
            $_POST["prenon"],
            $_POST["email"],
            $_POST["password"]
        )
        && !empty($_POST["nom"])
        && !empty($_POST["prenon"])
        && !empty($_POST["email"])
        && !empty($_POST["password"])
    ) {
        //formulaire est complet
        //On recuper les données en les protégeant
        $nom = strip_tags($_POST["nom"]);
        $prenon = strip_tags($_POST["prenon"]);
        if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            die("email est un correct");
        }
        // hasher le mtp
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        // die($password);
        //Ajoutez ici tous les 
        $checkEmail = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $email = $_POST['email'];
        $checkEmail->bindParam("email", $email);
        $checkEmail->execute();
        if ($checkEmail->rowCount() > 0) {
            die("Email est deja existe");
        } else {
            try {
                $sql = "INSERT INTO `users`(`nom` , `prenon`,`email`,`password`,`security_code`) VALUES (:nom, :prenon, :email, '$password',:security_code)";
                // enregistrer en DB
                $query = $pdo->prepare($sql);
                $query->bindValue(":nom", $nom, PDO::PARAM_STR);
                $query->bindValue(":prenon", $prenon, PDO::PARAM_STR);
                $query->bindValue(":email", $_POST["email"], PDO::PARAM_STR);
                $securityCode = md5(date("h:i:s"));
                $query->bindValue(":security_code", $securityCode);
                $query->execute();
                //recupérer l'id du nouvel utilisateur pour
                $id = $pdo->lastInsertId();
                // die($id);
                //email & MTP correct
                session_start();
                // var_dump($_SESSION);

                //stocke les information de l'utilisateur dans le session
                $_SESSION["user"] = [
                    "id" => $id,
                    "nom" => $nom,
                    "prenon" => $prenon,
                    "prenon" => $_POST["email"],
                    "type" => $user["type"],
                ];
                // var_dump('session' . $_SESSION);
                header("Location: login.php");
            } catch (PDOException $e) {
                die("La inscrit a échoué: " . $e->getMessage());
            }
        }
    } else {
        die("le formulaire est incomplet");
    }
}
?>
<main id="register">
    <div class="container-fluid h-100">
        <div class="div-center">
            <div class="content">
                <h3>Inscription</h3>
                <hr />
                <form method="POST">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenon">Prénom</label>
                        <input type="text" name="prenon" id="prenon" class="form-control" placeholder="Prénom" required>
                    </div>

                    <div class="form-group">
                        <label for="email1">Email address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Email" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-2">M'inscrire</button>
                    <hr />
                    <div class="row">
                        <a href="<?php echo BURL . 'logout.php'; ?>" class="btn btn-link" name="login.index">J'ai un compte</a>
                        <a href="<?php echo BURL . 'forgetPassword.php'; ?>" class="btn btn-link">Mot de passe oublier </a>
                    </div>


                </form>
            </div>
        </div>
        <!-- </div> -->
    </div>
</main>