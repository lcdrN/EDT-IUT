<?php

require_once __DIR__."/../vue/vueAbsence.php";

class ControleurAbsence{


private $vue;
 
 public function __construct(){
 	$this->vue = new vueAbsence();
 }

 function affiche(){

 	$this->vue->head();
	$this->vue->tableau();
 }
}

?>