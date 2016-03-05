<?php

require_once __DIR__."/../vue/vueAccueil.php";

class ControleurAccueil{


private $vue;
 
 public function __construct(){
 	$this->vue = new vueAccueil();
 }

 function affiche(){
 	$this->vue->affiche();
 }
 
 function initCookies(){


  setcookie("TD","#81BEF7", strtotime( '+60 days' ));
  setcookie("TP", "#567567", strtotime( '+60 days' ));
  setcookie("Amphi", "#A9F5F2", strtotime( '+60 days' ));
  setcookie("DS", "#FF9980", strtotime( '+60 days' ));
  setcookie("Projet", "#000000", strtotime( '+60 days' ));

   setcookie("prof", "checked", strtotime( '+60 days' ));
   setcookie("salles", "checked", strtotime( '+60 days' ));
   setcookie("matieres", "checked", strtotime( '+60 days' ));
   setcookie("heure", "checked", strtotime( '+60 days' ));
   setcookie("type", "checked", strtotime( '+60 days' ));
   setcookie("groupe", "checked", strtotime( '+60 days' ));
   setcookie("police", "12px", strtotime( '+60 days' ));
   
   
 }
}

?>