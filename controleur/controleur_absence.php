<?php

require_once __DIR__."/../vue/vueAbsence.php";

class ControleurAbsence{


private $vue;
 
 public function __construct(){
 	$this->vue = new vueAbsence();
 }

 function affiche(){

 	if ( isset($_POST["groupe"]))  {
 		$groupe  = $_POST["groupe"];
 	} else {
 		$groupe  = $_GET["ics"];
 	}
 	if (  $groupe == "INFO2")  {

 		$dao = new Dao();
		$dao->setICS($groupe);
		$dao->getCours();
		// $groupes = $dao->getGroupes2();
		$groupes = $dao->getGroupeXLS();
		
		$this->vue->head();
		$this->vue->tableauPromo($groupes);
		

 	} else {
 		$this->vue->head();
		$this->vue->tableau();
 	}
 	
 }
}

?>