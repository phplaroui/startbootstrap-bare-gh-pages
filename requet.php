
<?php
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';
include 'includes/header.inc.php';

$sql = "SELECT id, "
       . "titre, "
       . "texte, "
       . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
       . "FROM articles "
       . "WHERE (titre LIKE :recherche OR texte LIKE :recherche) " //LIKE pour rechercher un mot comme :recherche dans le titre ou dans le texte
       . "AND publie=1 "
       . "ORDER BY date DESC "
       . "LIMIT :index, :nb_articles_par_page"; 
       
$sth =  $bdd->prepare($sql);
$sth->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
//fetch assoc et recuperer le foreeach 
//dupliquer la page d'accueil

?>
<!-- Page Content -->
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">A Bootstrap 4 Starter Template</h1>  
            <p class="lead">Complete with pre-defined file paths and responsive navigation!</p>
            <ul class="list-unstyled">
                <li>Bootstrap 4.0.0-beta</li>
                <li>jQuery 3.2.1</li>
            </ul>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <?php
    include 'includes/footer.inc.php';
    ?>
