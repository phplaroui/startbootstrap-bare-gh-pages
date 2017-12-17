<?php

session_start();
require_once 'config/init.conf.php';
require_once 'config/bdd.conf.php';

require_once 'config/connexion.inc.php';
require_once 'includes/fonctions.inc.php';
//Class smarty
require_once 'libs/Smarty.class.php';

//$recherche = !empty($_GET['search']) ? $_GET['search'] : NULL;

$nb_articles_par_page = 2;

$page_courante = isset($_GET['page']) ? $_GET['page'] : 1;

$index = pagination($page_courante, $nb_articles_par_page);

$nb_total_article = nb_total_article_publie($bdd);

$nb_pages = ceil($nb_total_article / $nb_articles_par_page);

/* if ($recherche != NULL) {
  $select = "SELECT id, "
  . "titre, "
  . "texte, "
  . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
  . "FROM articles "
  . "WHERE (titre LIKE :recherche OR texte LIKE :recherche) " //LIKE pour rechercher un mot comme :recherche dans le titre ou dans le texte
  . "AND publie=1 "
  . "ORDER BY date DESC "
  . "LIMIT :index, :nb_articles_par_page"; */
// } else {

$select = "SELECT id, "
        . "titre, "
        . "texte, "
        . "DATE_FORMAT(date, '%d/%m/%Y') as date_fr "
        . "FROM articles "
        . "WHERE publie = :publie "
        . "LIMIT :index, :nb_articles_par_page ;";

//echo $select;
/* @var $bdd PDO */
$sth = $bdd->prepare($select);
$sth->bindValue(':publie', 1, PDO::PARAM_BOOL);
$sth->bindValue(':index', $index, PDO::PARAM_INT);
$sth->bindValue(':nb_articles_par_page', $nb_articles_par_page, PDO::PARAM_INT);
//if ($recherche != NULL) {
//    $sth->bindValue(':recherche', '%' . $recherche . '%', PDO::PARAM_STR);
// }
if ($sth->execute() == TRUE) {
    $tab_articles = $sth->fetchAll(PDO::FETCH_ASSOC); //pousser dans un tableau php
    //print_r($tab_articles);   
} else {
    echo 'une erreur est survenue...';
}


$smarty = new Smarty();

$smarty->setTemplateDir('templates/');
$smarty->setCompileDir('templates_c/');


$smarty->assign('is_connect', $is_connect);
if ($is_connect == TRUE) {
    $smarty->assign('nom_connect', $nom_connect);
    $smarty->assign('prenom_connect', $prenom_connect);
}
$smarty->assign('tab_session', $_SESSION);
$smarty->assign('tab_articles', $tab_articles);
$smarty->assign('nb_pages', $nb_pages);
$smarty->assign('page_courante', $page_courante);


if (isset($_SESSION['notification'])) {
    $notification_result = $_SESSION['notification_result'] == TRUE ? 'alert-success' : 'alert-danger';

    $smarty->assign('notification_result', $notification_result);

    unset($_SESSION['notification']);
    unset($_SESSION['notification_result']);
}

//$smarty->assign('recherche', $recherche);
//** un-comment the following line to show the debug console
//$smarty->debugging = true;
include 'includes/header.inc.php';

$smarty->display('index.tpl');

include 'includes/footer.inc.php';
//}
?>




