<?php 
require_once "Groupe.php";

	class Cours{

		private $id;
		private $date_debut;
		private $matiere;
		private $date_fin;
		private $type_cour;
		private $prof;
		private $groupe;
		private $salle;


		// function afficher(){
		// 	return ($this->matiere . "<br>" . $this->prof . "<br>" . $this->promo . " Groupe :" . $this->groupe ."-" . $this->sous_groupe . "<br>". $this->salle);
		// }

		function setId(){
			$this->id = $this->date_debut->format('Y-m-d H:i:s');
			foreach ($this->groupe as $g) {
			 	$this->id = $this->id . $g->getNumero();
			 }
		}

		function setSalle($salle){
			$this->salle = $salle;
		}

		function setGroupe($groupe){
			$this->groupe[$groupe->getNumero()] = $groupe;
		}

		function setProf($prof){
			$this->prof = $prof;
		}

		function setDateFin($date_fin){
			$this->date_fin = new DateTime('@'.$date_fin);
			$this->date_fin->add(new DateInterval('PT1H'));
		}

		function setDateDebut($date_deb){
			$this->date_debut = new DateTime("@".$date_deb);
			$this->date_debut->add(new DateInterval('PT1H'));
		}

		function setMatiere($matiere) {
			$this->matiere = $matiere;
		}

		function setType($type) {
			$this->type_cour = $type;
		}

		function getDateDeb(){
			return $this->date_debut;
		}

		function getDateFin(){
			return $this->date_fin;
		}

		function getTypeCour(){
			return $this->type_cour;
		}

		function getMatiere() {
			return $this->matiere;
		}

		function getId() {
			return $this->id;
		}

		function getGroupe() {
			return $this->groupe;
		}

		function getProf(){
			return $this->prof;
		}

		function getSalle(){
			return $this->salle;
		}

		function getDureeToInt(){

			$interval = $this->date_fin->diff($this->date_debut);
			$tmp = (((int)$interval->format('%h'))* 60 + ((int)$interval->format('%i')))/10;
			return $tmp;

			//return $interval->format('h:i');
		}

		function toStringGroupe(){
			$string = "";
			foreach ($this->groupe as $ungroupe) {
				if($ungroupe->getNumero() != "0"){
					$string .= $ungroupe->getNumero();
				}
				else{
					$string .= "PROMO";
				}

				if($ungroupe->getSousGroupe() != "0"){
					$string .= "-".$ungroupe->getSousGroupe()."\n";
				}
			}
			return $string;
		}




	}

function diffCours($cours1, $cours2) {
	if ( $cours1 != null) {
		$interval = $cours2->getDateDeb()->diff($cours1->getDateFin());
		$tmp = (((int)$interval->format('%h'))* 60 + ((int)$interval->format('%i')))/10;
		return $tmp;
	} else {
		return 0;
	}


} 


function diffCoursDate($d1, $d2) {
	if ( $d1 != null) {
		$interval = $d2->diff($d1);
		$tmp = (((int)$interval->format('%h'))* 60 + ((int)$interval->format('%i')))/10;
		return $tmp;
	} else {
		return 0;
	}


} 