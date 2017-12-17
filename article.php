<?php
session_start();

require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
require_once 'config/connexion.inc.php';

include 'includes/header.inc.php';

if ($is_connect == TRUE)
    if (isset($_POST['submit'])) {
        //print_r($_POST);
       // print_r($_FILES);

        if ($_FILES['image']['error'] == 0 || isset($id_article) != "") {

            $notification = 'Aucune notification';
            $_SESSION['notification_result'] = FALSE;
           $date_du_jour = date("Y-m-d"); // création date 

            if (!empty($_POST['titre']) AND !empty($_POST['texte'])) {

                $publie = isset($_POST['publie']) ? $_POST['publie'] : 0;
                $modif = isset($_GET['action']) ? $_GET['action'] : "ajouter";
               
                if ($modif == "ajouter") {

                     $insert = "INSERT INTO articles (titre, texte, date, publie)" // a modifier update si modif
                            . "VALUES (:titre, :texte, :date, :publie)";
                    /* @var $bdd PDO */
                    $sth = $bdd->prepare($insert);
                    $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                    $sth->bindValue(':date', $date_du_jour, PDO::PARAM_STR);
                    $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
              
                     } else {
                         $update = "UPDATE articles "
                            . "SET titre = :titre, "
                            . "texte = :texte, "
                            . "publie = :publie "
                            . "WHERE id = :id_article";

                    /* @var $bdd PDO */
                    $sth = $bdd->prepare($update);
                    $sth->bindValue(':titre', $_POST['titre'], PDO::PARAM_STR);
                    $sth->bindValue(':texte', $_POST['texte'], PDO::PARAM_STR);
                    $sth->bindValue(':publie', $publie, PDO::PARAM_BOOL);
                    $sth->bindValue(':id_article', $_POST['id_article'], PDO::PARAM_INT);
               
                     }

                if ($sth->execute() == TRUE) {
                    //if avec un test, si 1 erreur redirection catch, sinon execution du try
                    $id_article = $bdd->lastInsertId(); //renommer l'image

                    $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    /*
                      $tab_extension = array ('jpg','png','jpeg');
                      $result_extension_image = in_array($extension, $tab_extension);


                     */
                    move_uploaded_file($_FILES['image']['tmp_name'], 'img/' . $id_article . '.' . $extension); //traitement de l'image on pousse l'image dans un dossier avec un nom précis


                    $notification = '<strong>Votre article est inséré...</strong>';
                    $_SESSION['notification_result'] = TRUE;
                } else {
                    $notification = '<strong>Une erreur est surevenue lors le l\'insertion de l\'article dans la base de données...</strong>';
                    $_SESSION['notification_result'] = FALSE;
                }
            } else {
                $notification = '<strong>Veuillez renseigner les champs obligatoires</strong>';
                $_SESSION['notification_result'] = FALSE;
            }
        } else {
            $notification = '<strong>Une erreur est survenue lors du traitement de votre image...</strong>';

            $_SESSION['notification_result'] = FALSE;
        }

        $_SESSION['notification'] = $notification;

        header('Location: index.php');
        exit();
    } else {

        $id_article = isset($_GET['id_article']) ? $_GET['id_article'] : ""; //GET PASSE OU RECUPERE LES PARAMETRES DANS L'URL 
        $action = isset($_GET['action']) ? $_GET['action'] : "ajouter"; //si action url existe pas, ajouter par défaut

        if ($action == "modifier") {

            $select2 = "SELECT * FROM articles where id = :id_article";

            $sth2 = $bdd->prepare($select2);
            $sth2->bindValue(':id_article', $id_article, PDO::PARAM_INT);


            if ($sth2->execute() == TRUE) {
                $tab_result2 = $sth2->fetch(PDO::FETCH_ASSOC);
                $titre = $tab_result2['titre'];
                $texte = $tab_result2['texte'];
                $publie = $tab_result2['publie'];
            }
        } else {
            
        }



        include 'includes/header.inc.php';
        ?>
        <!-- Page Content -->
        <form action="article.php" method="post" enctype="multipart/form-data" id="form_article">
            <div class="container">

                <div class="form-group">
                    <div class="col-lg-12  text-center"> <p>
        <?php
        if ($is_connect == TRUE) {
            ?>
                            <div class="alert alert-info" role="alert">
                                Connecté en tant que <?= $nom_connect; ?> <?= $prenom_connect; ?> 
                            </div>
            <?php
        }
        ?>

                        <?php if (isset($_GET['action']) == "modifier") { ?>
                            <h1 class="mt-5">Modifier un article </h1> 
                            <?php
                        } else {
                            ?>

                            <h1 class="mt-5">Ajouter un article </h1> 

            <?php
        }
        ?>

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
                                <label for="titre">Titre</label>

        <?php if (isset($titre)) { ?>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de votre article" value=" <?= isset($titre) ? $titre : "" ?>"  >
                                <?php } else { ?>
                                    <input type="text" class="form-control" id="titre" name="titre" placeholder="Titre de votre article">
                                <?php }
                                ?>


                            </div>
                        </div>
                        <input type ="hidden" value="<?= $id_article ?>" name="id_article">
                        <div class="form-group">
                            <div class="col-md ">
                                <label for="contenu">Article</label>
                                <textarea class="form-control" id="texte" name="texte" placeholder="Texte de votre article" rows="5"  ><?= isset($texte) ? $texte : "" ?></textarea>
                            </div>
                        </div>


        <?php if (isset($id_article)) { ?>
                            <img class="card-img-top" src="img/<?= $id_article ?>.jpg" style = "width:15rem;"   >

                        <?php } else { ?>


                        <?php } ?>

                        <div class="form-group">
                            <input type="file" class="form-control-file" id="image" name="image" aria-describedby="fileHelp">
                        </div>




                        <div class="form-check">
                            <label for ="checkbox" class="form-check-label">
        <?php if (isset($publie) == 1) { ?>
                                    <input type="checkbox" checked class="form-check-input" id="publie" name="publie" value="1">
                                <?php } else { ?>
                                    <input type="checkbox" class="form-check-input" id="publie" name="publie" value="1">
                                <?php } ?>
                                Publié ?
                            </label>
                        </div>










                        <div  for ="submit" class="btn-group" >
        <?php if (isset($_GET['action']) == "modifier") { ?>
                                <button type="submit" class="btn btn-primary" id="submit" name="submit" value="modifier">Modifier un article </button>
                                <?php
                                $update = "UPDATE articles SET titre = :titre, texte = :texte, publie = :publie WHERE id = :id_article";
                            } else {
                                ?>
                                <button type="submit" class="btn btn-primary" id="submit" name="submit" value="ajouter">Ajouter un article </button>
                                <?php
                            }
                            ?>
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
    } else {
    echo' vous devez etre connecte...';
}
?>

