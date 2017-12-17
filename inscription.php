<?php
session_start();

require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'includes/fonctions.inc.php';
require_once 'config/connexion.inc.php';
include 'includes/header.inc.php';



if (isset($_POST['submit'])) {
    //print_r($_POST);


        $notification = 'Aucune notification';
        $_SESSION['notification_result'] = FALSE;


        if (!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['email']) AND !empty($_POST['mdp'])) {

            $insert = "INSERT INTO utilisateurs (nom, prenom, email, mdp)"
                    . "VALUES (:nom, :prenom, :email, :mdp)";
            

            /* @var $bdd PDO */
            $sth = $bdd->prepare($insert);
            $sth->bindValue(':nom', $_POST['nom'], PDO::PARAM_STR);
            $sth->bindValue(':prenom', $_POST['prenom'], PDO::PARAM_STR);
            $sth->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
            $sth->bindValue(':mdp', cryptPassword($_POST['mdp']), PDO::PARAM_BOOL);

            if ($sth->execute() == TRUE) {
                
                $notification = '<strong>Votre êtes inscrit</strong>';
                $_SESSION['notification_result'] = TRUE;
            } else {
                $notification = '<strong>Une erreur est surevenue lors de votre inscription ...</strong>';
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            $notification = '<strong>Veuillez renseigner les champs obligatoires</strong>';
            $_SESSION['notification_result'] = FALSE;
        }
    

    $_SESSION['notification'] = $notification;

    header('Location: inscription.php');
    exit();
} else {

    include 'includes/header.inc.php';
    ?>
<!-- Page Content -->
<form action="inscription.php" method="post" enctype="multipart/form-data" id="form_article">
    <div class="container">
        <div class="form-group">
            <div class="col-lg-12  text-center"> 
                <h1 class="mt-5">Inscription </h1> <p>
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
                <div class="form-group">
                    <div class="col-md">
                        <label for="titre">Nom de l'utilisateur :</label>
                        <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md">
                        <label for="titre">Prenom de l'utilisateur :</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Votre Prenom"  >
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md">
                        <label for="titre">Email :</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="xyz@exemple.com"  >
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md">
                        <label for="titre">Mot de passe :</label>
                        <input type="password" class="form-control" id="mdp" name="mdp" placeholder="Saisissez un mot de passe"  >
                    </div>
                </div>


                <div  for ="submit" class="btn-group" >
                    <button type="submit" class="btn btn-primary" id="submit" name="submit">Ajouter l'utilisateur</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <?php
    include 'includes/footer.inc.php';
}
    ?>

