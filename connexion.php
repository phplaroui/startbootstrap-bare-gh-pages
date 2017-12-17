<?php
session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';
require_once 'includes/fonctions.inc.php';


if (isset($_POST['submit'])) {
    //print_r($_POST);

    $notification = '<strong>Aucune notification</strong>';
    $_SESSION['notification_result'] = FALSE;

    if (!empty($_POST['email']) AND !empty($_POST['mdp'])) {
        $mdp_hash = cryptPassword($_POST['mdp']);
        $select_user = "SELECT email, mdp FROM utilisateurs WHERE email = :email AND mdp = :mdp";
        /* @var $bdd PDO */
        $sth = $bdd->prepare($select_user);
        $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $sth->bindValue(':mdp', $mdp_hash, PDO::PARAM_STR);

        if ($sth->execute() == TRUE) {

            $count = $sth->rowCount();
            if ($count > 0) {
                $sid = sid($_POST['email']);

                $update_sid = "UPDATE utilisateurs SET sid = :sid WHERE email = :email";
                $sth_update = $bdd->prepare($update_sid);
                $sth_update->bindValue(':sid', $sid, PDO::PARAM_STR);
                $sth_update->bindValue(':email', $_POST['email'], PDO::PARAM_STR);

                if ($sth_update->execute() == TRUE) {
                    setcookie('sid', $sid, time() + 86400);
                    $notification = '<strong>Félicitations vous êtes connecté !</strong>';
                    $_SESSION['notification'] = $notification;
                    $_SESSION['notification_result'] = TRUE;
                    header("Location: index.php");
                    exit();
                } else {
                    $notification = '<strong>Une erreur est surevenue lors de votre inscription ...</strong>';
                    $_SESSION['notification_result'] = FALSE;
                }
            } else {
                $notification = '<strong>Email ou mdp pas bon</strong>';
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            $notification = '<strong>Une erreur est surevenue lors de votre inscription ...</strong>';
            $_SESSION['notification_result'] = FALSE;
        }
    } else {

        $notification = '<strong>Veuillez renseigner les champs obligatoires</strong>';
        $_SESSION['notification_result'] = FALSE;
    }

    $_SESSION['notification'] = $notification;
    header('Location: connexion.php');
} else {

    include 'includes/header.inc.php';
    ?>
    <form action="connexion.php" method="post" enctype="multipart/form-data" id="form_connexion">
        <?php
                    if (isset($_SESSION['notification'])) {
                        $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';
                        ?>

                        <div class="alert <?= $notification_result ?> alert-dismissible fade show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <?= $_SESSION['notification']; ?>

                        </div>
                        <?php
                        unset($_SESSION['notification']);
                        unset($_SESSION['notification_result']);
                    }
                    ?>
        <div class="container">
            <div class="form-group">
                <div class="col-lg-12  text-center"> 
                    <h1 class="mt-5">Connexion </h1> 
                    
                    <div class="form-group">
                        <div class="col-md">
                            <label for="titre">Email :</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="xyz@exemple.com" required >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md">
                            <label for="titre">Mot de passe :</label>
                            <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Mot de passe de l'utilisateur" required >
                        </div>
                    </div>


                    <div  for ="submit" class="btn-group" >
                        <button type="submit" class="btn btn-primary" id="submit" name="submit">Se connecter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/popper/popper.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="js/dist/jquery.validate.min.js"></script>
        <script src="js/dist/localization/messages_fr.min.js"></script>
        
        
        <script>
        $(document).ready(function () {
            $("#form_connexion").validate();
        });
        </script>
        
    <?php
    include 'includes/footer.inc.php';
}
?>

