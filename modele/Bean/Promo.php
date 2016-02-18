<?php

class Promo {
	private $numero;
	private $tab_Groupe;

	function getNumero(){
		return $this->numero;
	}

	function setNumero($numero){
		$this->numero = $numero;
	}
	
	function getGroupe(){
		return $this->tab_Groupe;
	}

	function setGroupe($tab_Groupe){
		$this->tab_Groupe = $tab_Groupe;
	}

	function toString() {
		return $this->numero;
	}





}

?>