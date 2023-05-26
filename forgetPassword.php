<?php
require_once 'config.php';
include("./inc/headerFR.php");
require_once BL . 'functions/validate.php';
require_once BL . 'functions/db.php';


if (isset($_SESSION['user'])) {
    header("location:" . BURL . 'index.php');
    // die('yes');
}



if (isset($_POST['next'])) {
    // die('yes');
    $email = $_POST['email'];
    // die($email);

    if (check_empty($email)) {
        if (valid_email($email)) {
            $sql = "SELECT * FROM `users` WHERE `email` = :email";
            $query = $pdo->prepare($sql);
            $query->bindParam(":email", $_POST["email"]);
            $query->execute();
            $user = $query->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                require_once 'mail.php';
                $mail->addAddress($email);
                $mail->Subject = "Reset de passe oublié";
                $mail->Body = '
                Mot de passe oublié
                <br>
                ' . '<a href="' . BURL . 'forgetPassword.php?email=' . $_POST["email"] .
                    '&code=' . $user['security_code'] . '">' . BURL . '/forgetPassword.php?email=' . $_POST["email"] .
                    '&code=' . $user['security_code'] . '</a>';

                $mail->setFrom("karim.dev.js.2021@gmail.com", "LesOasis");
                $mail->send();
                $success_message = "Email Envoyer!";
            } else {
                $error_message = "E-mail pas trouve";
            }
        } else {
            $error_message = "E-mail incorrect";
        }
    } else {
        $error_message = "Email est vide ";
    }
}
//MOT PASS
if (isset($_POST['pass'])) {
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $updatePassword = $pdo->prepare("UPDATE `users` SET `password` 
   = :password WHERE `email` = :email");
    // var_dump($_GET["email"]);

    $updatePassword->bindParam("email", $_GET["email"]);
    $updatePassword->bindParam("password", $password);
    $updatePassword->execute();
    // var_dump($updatePassword);
    // $user = $updatePassword->fetch(PDO::FETCH_ASSOC);


    if ($updatePassword->execute()) {
        $success_message = "Password updated successfully";
        // return die($_GET["email"]);:
        // return var_dump($updatePassword);
    } else {
        $error_message = "Problem to update";
    }
}
?>
<main id="register">
    <div class="container-fluid h-100">
        <div class="div-center">
            <div class="content">
                <h3>Mot de passe oublié </h3>
                <hr />
                <?php if (!isset($_GET['code'])) : ?>
                    <form method="POST">
                        <?php require BL . 'functions/messages.php' ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Entrer votre address email </label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" name="email">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 col-12 text-center" name="next">Suivante</button>
                        <hr />
                        <div class="row d-flex justify-content-center">
                            <a href="<?php echo BURL . 'login.php'; ?>" class="btn btn-link col-3">Connexion</a>
                            <a href="<?php echo BURL . 'inscription.php'; ?>" class="btn btn-link col-3">Inscription </a>
                        </div>

                    </form>
                <?php elseif (isset($_GET['code']) && isset($_GET['email'])) : ?>
                    <form method="POST">
                        <?php require BL . 'functions/messages.php' ?>
                        <div class="form-group">
                            <label for="exampleInputEmail1 " class="text-danger fw-bolder">Nouvaux password : </label>
                            <input type="password" class="form-control" id="exampleInputEmail1" placeholder="password" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3 col-12 text-center flex" name="pass">Suivante</button>
                        <hr />
                        <div class="row d-flex justify-content-center">
                            <a href="<?php echo BURL . 'login.php'; ?>" class="btn btn-link col-3">Connexion</a>
                            <a href="<?php echo BURL . 'inscription.php'; ?>" class="btn btn-link col-3">Inscription </a>
                        </div>
                    </form>
                <?php endif ?>

            </div>
        </div>
        <!-- </div> -->
    </div>
</main>