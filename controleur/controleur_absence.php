<?php

require_once __DIR__."/../vue/vueAbsence.php";
require_once __DIR__."/../modele/DAO/Dao.php";

class ControleurAbsence{


private $vue;
 
 public function __construct(){
 	$this->vue = new vueAbsence();
 	$this->dao = new Dao();
 }

 function affiche(){
 	
 	if (isset($_GET["ajoutListe"])) {
 		$this->vue->ajoutListe();
 		
 	} else if ( isset($_POST["groupe"]))  {
 		if ( strpos($_POST["groupe"], ':') !== FALSE) {
 			$groupe  = explode(":",$_POST["groupe"])[1];
 			$promo = explode(":",$_POST["groupe"])[0];
		} else {
	    	$groupe = "";
 			$promo = $_POST["groupe"];
		}
 		
 		
 	} else {
 		if ( strpos($_GET["ics"], ':') !== FALSE) {
 			$groupe  = explode(":",$_GET["ics"])[1];
 			$promo = explode(":",$_GET["ics"])[0];
		} else {
	    	$groupe = "";
 			$promo = $_GET["ics"];
		}
		    
  	}
 	
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