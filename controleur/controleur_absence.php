<?php

require_once __DIR__."/../vue/vueAbsence.php";
require_once __DIR__."/../modele/DAO/Dao.php";


/** ControleurAbsence
 *  Classe qui permet de gerer la vue
 *  de l'absence
 */
class ControleurAbsence{


private $vue;
 
 public function __construct(){
 	$this->vue = new vueAbsence();
 	$this->dao = new Dao();
 }

 function affiche(){
	/* Si GET["ajout"] est possitionne, on affiche la vue pour ajouter/modifier une liste*/
 	if (isset($_GET["ajoutListe"])) {
 		$this->vue->ajoutListe();
 		
	/* Sinon si la date et un groupe est possitionne on affiche la feuille d'absence associe*/

 	} else if ( isset($_POST["groupe"]))  {
 		
 		/*On explose pour recuperer le groupe et la promo*/
 		if ( strpos($_POST["groupe"], ':') !== FALSE) {
 			$groupe  = explode(":",$_POST["groupe"])[1];
 			$promo = explode(":",$_POST["groupe"])[0];
		} else {
	    	$groupe = "";
 			$promo = $_POST["groupe"];
		}
 		
 		
 	} else {
 		 /*On explose pour recuperer le groupe et la promo*/
 		if ( strpos($_GET["ics"], ':') !== FALSE) {
 			$groupe  = explode(":",$_GET["ics"])[1];
 			$promo = explode(":",$_GET["ics"])[0];
		} else {
	    	$groupe = "";
 			$promo = $_GET["ics"];
		}
		    
  	}
 	/* Si le groupe est NULL, c'est une promo, on utilise la vue associe. Sinon on redirige vers l'ajout de liste.*/
 	if ( $groupe == NULL) {
 		
 		$dao = new Dao();
		$dao->setICS($promo);
		$dao->getCours();
		// $groupes = $dao->getGroupes2();
		
		if ( $this->dao->fichierPromoExist($promo) ) {
			$groupes = $dao->getGroupeXLS($dao->getFeuilleAbsGroupe($promo));
			$this->vue->head();
			$this->vue->tableauPromo($promo, $groupes);
		} else {
			header('location:index.php?ajoutListe=true');
		}

 	} else {
 		$this->vue->head();
		$this->vue->tableau();
 	}
 	
 }
}

?>