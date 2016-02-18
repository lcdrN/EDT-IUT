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
}

?>