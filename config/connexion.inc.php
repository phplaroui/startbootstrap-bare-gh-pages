<?php
$is_connect = FALSE;



if (isset($_COOKIE['sid']) AND !empty($_COOKIE['sid'])) { //Vérification du cookie 
    
    $select = "SELECT COUNT(*) as nb_sid, nom, prenom FROM utilisateurs WHERE sid = :sid"; //selection dans la bdd + selection du champ sid
    
   /* @var $bdd PDO */
   $sth = $bdd->prepare($select); //préparation de la bdd
   $sth->bindValue(':sid', $_COOKIE['sid'], PDO::PARAM_STR); //associe une valeur à un parametre
   
   $sth->execute();
   
   $tab_result = $sth->fetch(PDO::FETCH_ASSOC); // Récupère la ligne suivante d'un jeu de résultats PDO
   //print_r($tab_result);
   
   if($tab_result['nb_sid'] >0 ){
       $is_connect = TRUE;
       $nom_connect = $tab_result['nom'];
       $prenom_connect = $tab_result['prenom'];
   }
}
?>
