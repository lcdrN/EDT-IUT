<?php

class Groupe {
	private $numero;
	private $sousGroupe;
	private $promo;

	function getNumero(){
		return $this->numero;
	}

	function setNumero($numero){
		$this->numero = $numero;
	}
	
	function getSousGroupe(){	
		return $this->sousGroupe;
	}

	function setSousGroupe($sousGroupe){
		$this->sousGroupe = $sousGroupe;
	}

	function getPromo(){
		return $this->promo;
	}

	function setPromo($promo){
		$this->promo = $promo;
	}

	function toString(){
		// if ($this->numero == '') {
		// 	return 'promo'.$this->promo;
		// } else {
		// 	return 'promo'.$this->promo.'g'.$this->numero;
		// }
		return $this->numero;
		
	}






}

?>