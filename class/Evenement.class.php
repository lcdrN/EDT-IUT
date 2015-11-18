<?php 


	class Evenement{

		private $id;
		private $date_debut;
		private $matiere;
		private $date_fin;
		private $type_cour;
		private $prof;
		private $promo;
		private $groupe;
		private $sous_groupe;
		private $salle;


		function __construct($date_debut, $matiere, $date_fin, $type, $prof, $promo, $groupe, $sous_groupe, $salle){
			$this->date_debut = new DateTime("@".$date_debut);
			$this->date_debut->add(new DateInterval('PT1H'));
			$this->matiere = $matiere;
			$this->date_fin = new DateTime('@'.$date_fin);
			$this->type_cour = $type;
			$this->date_fin->add(new DateInterval('PT1H'));
			$this->prof = $prof;
			$this->promo = $promo;
			$this->groupe = $groupe;
			$this->sous_groupe = $sous_groupe;
			$this->salle = $salle;
			$this->id = $this->date_debut->format('Y-m-d H:i:s') . $groupe;
		}


		function afficher(){
			return ($this->matiere . "<br>" . $this->prof . "<br> INFO " . $this->promo . " Groupe :" . $this->groupe ."-" . $this->sous_groupe . "<br>". $this->salle);
		}


		function getDateDeb(){
			return $this->date_debut;
		}

		function getTypeCour(){
			return $this->type_cour;
		}




	}