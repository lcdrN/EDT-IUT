<?php

require_once'iCalendar2/SG_iCal.php';
require_once 'PHPExcel/IOFactory.php';
require_once __DIR__.'/../Bean/Cours.php';
require_once __DIR__.'/../Bean/Groupe.php';
require_once __DIR__.'/../Bean/Promo.php';

/** DAO
 *  Data Acces Object. Classe qui permet d'acceder aux donnees
 *  des ICS.
 *  Cette classe contient un tableau de cours en attribut afin 
 *  de parser l'ics une seule fois.
 *  Cette classe utilise:
 * 		-le parser iCalendar2 afin de parser l'ics.
 * 		-PHPExcel afin lire les fichiers xls.
 *  
 */
class Dao {


	private $tab_cours = array();
	private $ICS ;

	public function setICS($string) {
		$this->ICS = $this->getUrlForm($string);
	}

/*0 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

	/** Fonction qui remplis un tableau de cours.
	 *  Utilise icalendar.
	 */
	public function getCours(){
		
		/* Parse l'ics*/
		$nb = 0;
		$tab = array();
		$ical = new SG_iCalReader($this->ICS);
		$query = new SG_iCal_Query();

		$evts = $ical->getEvents();

		$data = array();
		if ( !is_array($evts) ) {
			echo "ERREUR, d'initialisation des evenements.";
			echo '<br>$evts= '.$evts;
		}
		foreach($evts as $id => $ev) {
			$jsEvt = array(
				"id" => ($id+1),
				"title" => $ev->getProperty('summary'),
				"start" => $ev->getStart(),
				"end"   => $ev->getEnd(),
				"allDay" => $ev->isWholeDay(),
				"location" => $ev->getProperty('location'),
				"description" => $ev->getProperty('description')
			);

			



			if (isset($ev->recurrence)) {
				$count = 0;
				$start = $ev->getStart();
				$freq = $ev->getFrequency();
				if ($freq->firstOccurrence() == $start)
					$data[] = $jsEvt;
				while (($next = $freq->nextOccurrence($start)) > 0 ) {
					if (!$next or $count >= 1000) break;
					$count++;
					$start = $next;
					$jsEvt["start"] = $start;
					$jsEvt["end"] = $start + $ev->getDuration();

					$data[] = $jsEvt;
				}
			} else
			
			$data[] = $jsEvt;

				
			

			$String2 = htmlentities($jsEvt["description"], ENT_QUOTES, "UTF-8");
			$String = nl2br($String2);

			$sum = htmlentities($jsEvt["title"], ENT_QUOTES, "UTF-8");
			$sum2 = nl2br($sum);

			
			
			$Matiere = between('Mati&egrave;re : ','<br />', $String);
			$prof = between('Personnel : ', '<br />', $String);
			$promo = between('Groupe : ','Groupe ', $String);

			$tmp = between('Groupe :','Salle ', $String);

			$sous_groupe = rtrim(trim(stripslashes(after('-',$tmp))));
			if ($sous_groupe == "" ) {
				$sous_groupe = "0";
			}

			$tabGroupe = array();
			$promo = trim($promo);
			
			$tmp_groupe = between('Groupe :', 'Salle', $String2); //--> 'INFO 2 Groupe 2\, INFO 2 Groupe 3'
			// echo $tmp.'<br/>';
			$tmp_tab = explode(",", $tmp_groupe);


			foreach ($tmp_tab as $g ) {
					if (strpos($g, 'TP') !== FALSE) {
						$tmp = between("TP ","-",$String2);
					} else {
						$tmp = after($promo.' Groupe ',$g);
						$tmp = trim(stripslashes($tmp)); // Enlève antislash et les espaces					
						if($tmp == ""){
							$tmp = "0";
						}
					}
					array_push($tabGroupe, $tmp);

			
				
			}

			

			$type = before(' -', $sum2);
			$salle = between('Salle : ', '<br />', $String);
			$date_debut = $jsEvt['start'];
			$date_fin = $jsEvt['end'];
			
			$date = new DateTime('@'.$date_debut);


			/* Instancie les BEANs*/
			$cours = new Cours();
			$cours->setDateDebut($date_debut);
			$cours->setMatiere($Matiere);
			$cours->setDateFin($date_fin);
			$cours->setType($type);
			$cours->setProf($prof);
			$cours->setSalle($salle);

			foreach ($tabGroupe as $g) {
				
				$Groupe = new Groupe();
				$Groupe->setSousGroupe($sous_groupe[0]);
				$Groupe->setNumero($g);
				$Groupe->setPromo($promo); 
				$cours->setGroupe($Groupe);
			}

			$cours->setId();
				

			$tab[$nb++] = $cours;
			sort($tab); // Noé

			array_push($this->tab_cours, $cours);
		}
	}
	
/*1 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		/**
		*	Methode qui retourne tous les groupes présent dans un tableau de cours donnée
		*	@return Un tableau associatif de groupes
		*
		*/
		function getGroupes($tabCours){
			$tab_groupe = array();
			foreach ($tabCours as $cours) {
				foreach ($cours->getGroupe() as $g) {
					$tab_groupe[$g->getNumero()] = $g;
					
				}
			}
			sort($tab_groupe);
			return $tab_groupe;
		}
/*2 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/


		/**
		*	Methode qui retourne tous les groupes présent dans l'ics
		*	@return Un tableau associatif de groupes
		*
		*/
		function getGroupes2(){


			$tab_groupe = array();
			foreach ($this->tab_cours as $cours) {
				foreach ($cours->getGroupe() as $g) {
					$tab_groupe[$g->getNumero()] = $g;
					
				}
			}
			return $tab_groupe;
		}
/*3 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		

		/**
		*	Methode qui retourne les cours de l'ics selon la date du debut.
		*	Prend les cours a partir de la date debut compris + 6 jours (inclus)
		*	@param date -> 'y-m-d H:i:s'
		*	@return Un tableau de cours
		*/
		function getCoursDate($jour_debut){
			$tab_cours = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('Y-m-d H:i:s'));
			$jour_fin->add(new DateInterval('P6D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {

					array_push($tab_cours,$cours);
				}
			}
			return $tab_cours;
			
		}


/*4 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		/**
		*	Methode qui retourne les cours de la journee de l'ics selon la date du debut.
		*	Prend les cours de la journee 
		*	@param date -> 'm-d H:i:s'
		*	@return Un tableau de cours
		*/
		function getCoursDateJournee($jour_debut){
			$tab_cours = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('Y-m-d H:i:s'));
			$jour_fin->add(new DateInterval('P1D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {

					array_push($tab_cours,$cours);
				}
			}
			sort($tab_cours);
			return $tab_cours;
			
		}
		
/*5 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/


		/**
		*	Methode qui retourne les cours de la journee de l'ics selon la date du debut et le groupe.
		*	Prend le premier jour de la semaine en parametre ainsi que le groupe
		*	@param date -> 'm-d H:i:s'
		*   @param groupe
		*	@return Un tableau de cours
		*/
		function getCoursDateJourneeGroupe($jour_debut, $groupe){
			$tab_cours = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('Y-m-d H:i:s'));
			$jour_fin->add(new DateInterval('P1D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {
					foreach ($cours->getGroupe() as $g) {
						if ($g->getNumero() == $groupe && $g->getSousGroupe() == "0") {
							array_push($tab_cours, $cours);
						}
					}
				}
			}
			return $tab_cours;
			
		}
		
/*6 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/


		/**
		*	Methode qui retourne les cours de la journee de l'ics selon la date du debut et le 1er sous-groupe.
		*	Prend le premier jour de la semaine en parametre ainsi que le sous-groupe
		*	@param date -> 'm-d H:i:s'
		*   @param sous_groupe
		*	@return Un tableau de cours
		*/
		function getCoursDateJourneeSousGroupe($jour_debut, $groupe){
			$tab_cours = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('Y-m-d H:i:s'));
			$jour_fin->add(new DateInterval('P1D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {
					foreach ($cours->getGroupe() as $g) {
							if ($g->getSousGroupe() == "1" && $g->getNumero() == $groupe) {
								array_push($tab_cours, $cours);
							}
					}
				}
			}
			return $tab_cours;
			
		}


/*7		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/


		/**
		*	Methode qui retourne les cours de la journee de l'ics selon la date du debut et le 2eme sous-groupe.
		*	Prend le premier jour de la semaine en parametre ainsi que le sous-groupe
		*	@param date -> 'm-d H:i:s'
		*   @param sous_groupe
		*	@return Un tableau de cours
		*/
		function getCoursDateJourneeSousGroupeBis($jour_debut, $groupe){
			$tab_cours = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('Y-m-d H:i:s'));
			$jour_fin->add(new DateInterval('P1D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {
					foreach ($cours->getGroupe() as $g) {
							if ($g->getSousGroupe() == "2" && $g->getNumero() == $groupe) {
								array_push($tab_cours, $cours);
							}
					}
				}
			};
			return $tab_cours;
			
		}
/*8 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		/**
		*	Methode qui retourne les cours de la journee de l'ics selon la date du debut et le groupe.
		*	Prend le premier jour de la semaine en parametre ainsi que le groupe
		*	@param date -> 'm-d H:i:s'
		*   @param groupe
		*	@return Un tableau de cours
		*/
		function getCoursDateJourneeGroupeBis($jour_debut, $groupe){
			$tab_cours = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('Y-m-d H:i:s'));
			$jour_fin->add(new DateInterval('P1D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {
					foreach ($cours->getGroupe() as $g) {
						if ($g->getNumero() == $groupe || $g->getNumero() == "0") {
							array_push($tab_cours, $cours);
						}
					}
				}
			}
			return $tab_cours;
			
		}


/*8 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		/**
		*	Methode qui retourne le cour precedent
		*	@param cours Objet de type cour
		*	@return un cour
		*/
		function getCourPrecedent($cours){

			$ret = new DateTime($cours->getDateDeb()->format('Y-m-d H:i:s'));
			$ret->setTime(9, 0, 0);

			foreach ($cours->getGroupe() as $groupe) {

				$date = $cours->getDateDeb();
				$tab_cours = $this->getCoursDateJourneeGroupeBis($date->format('Y-m-d'), $groupe->getNumero());
				$tab_cours2 = $this->getCoursDateJourneeGroupe($date->format('Y-m-d'), "0");
				$tab3 = array_merge($tab_cours, $tab_cours2);
				sort($tab3);

				for($i=0;$i<count($tab3);$i++) {
					if($tab3[$i]->getDateFin() < $date ){
						$ret = $tab3[$i]->getDateFin();
					}
				}
			}
			return $ret;

		}

/*9 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		/**
		*	Methode qui retourne la taille en nombre de colonne d'un cour.
		*	Prend un cour en parametre
		*	@param cours Objet cour
		*	@return entier 
		*/
		function getTailleRowspan($cours){

			$ret = "2";

			foreach ($cours->getGroupe() as $groupe) {
				if($groupe->getSousGroupe() != "0"){
					return "1";
				}

				$date = $cours->getDateDeb();
				$tab_cours = $this->getCoursDateJourneeGroupe($date->format('Y-m-d'), $groupe->getNumero());
				//$tab_cours2 = $this->getCoursDateJourneeGroupe($date->format('Y-m-d'), "0");
				//$tab3 = array_merge($tab_cours, $tab_cours2);
				sort($tab_cours);

				for($i=0;$i<count($tab_cours);$i++) {
					if($tab_cours[$i]->getDateFin() < $date && !$this->tmp($tab_cours[$i]) ){
						return "1";
					}
				}
			}
			return $ret;

		}
/*10 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		/**
		*	Methode qui retourne un booleen, si il ya pas presence du sous groupe 0 dans le cour
		*	Prend un cour en parametre
		*	@param cours Objet cour
		*	@return booleen Vrai si le cour ne contient pas le sous-groupe 0 
		*/
		function tmp($cours){
			$tmp = true;
			foreach ($cours->getGroupe() as $groupe) {
				if($groupe->getSousGroupe() != "0"){
					$tmp = false;
				}
			}
			return $tmp;
		}


/*11 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		/**
		*	Methode qui retourne les cours du groupe et des sous-groupes associes, de la journee.
		*	Prend un jour en parrametre de type string
		*	@param date -> 'm-d H:i:s'
		*   @param groupe
		*	@return un tableau de cours 
		*/
		function getGroupeSousGroupe($journee, $groupe){
			$tab_coursGroupe = $this->getCoursDateJourneeGroupe($journee, $groupe);
			$tab_coursSousGroupe = $this->getCoursDateJourneeSousGroupe($journee, $groupe);


			$mix = array_merge($tab_coursGroupe, $tab_coursSousGroupe);
			return $mix;
			
		}
		
		
/*12 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		/**
		*	Methode qui retourne les cours de l'ics selon un groupe.
		*	Prend les cours a partir de la date debut compris + 6 jours (inclus)
		*	@param date	'd-m-d H:i:s'
		*	@param groupe numero du groupe
		*	@return Un tableau de cours
		*/
		function getCoursGroupe($jour_debut, $groupe) {

			$tab_cours_gp = array();
			$jour_debut = new DateTime($jour_debut);
			$jour_fin = new DateTime($jour_debut->format('d-m-Y H:i:s'));
			$jour_fin->add(new DateInterval('P6D'));

			foreach ($this->tab_cours as $cours) {
				$date_debut = $cours->getDateDeb();
				foreach ($cours->getGroupe() as $grp) {
					if ( $grp->getNumero() == $groupe ) {
						if ( $date_debut >= $jour_debut && $date_debut <= $jour_fin ) {
							array_push($tab_cours_gp,$cours);
						}
					}
				}
				
			}
			return $tab_cours_gp;
			
		}
		
/*13 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		
		/**
		*	Methode qui retourne les etudiants d'un groupe.
		*	@param promo
		*	@param groupe numero du groupe
		*	@return Un tableau de d'etudiants array(array("nom","prenom"))
		*/		
		function getEtudiants($promo, $groupe)
		{
			try {
				$tab_Etu = array();
				$file_name = $this->getFeuilleAbsGroupe($promo);
				// var_dump( $promo);
				$objPHPExcel = PHPExcel_IOFactory::load("modele/DAO/data/".$file_name);
				$sheet = $objPHPExcel->getSheet(0);
				$lastRow = ($objPHPExcel->getActiveSheet()->getHighestRow()-6);
				$tmp = array("","");
	
				
			     for ($j =7; $j < ($lastRow); $j++) {
			     	//echo '</br>-'.$j.' - '.$sheet->getCellByColumnAndRow(1,$j);
			     	if ( $sheet->getCellByColumnAndRow(3,$j) == $groupe) {
				     	$tmp[0] = $sheet->getCellByColumnAndRow(1,$j);
				     	$tmp[1] = $sheet->getCellByColumnAndRow(2,$j);
				     	array_push($tab_Etu,$tmp);
				     }
			     }
				
				return $tab_Etu;
			} catch (Exception $e) {
				return NULL;
			}
		}
/*14 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		
		/**
		*	Methode qui teste si la promo est contenu dans le fichier,
		*   contenant les chemin des feuilles d'absensces
		*	@param promo
		*	@return booleen Vrai si promo est contenu dans le fichie
		*/
		function fichierPromoExist ($promo) {
			$fic = fopen("modele/DAO/data/feuilleABS.csv", "r");
			$boolean = false;
			while($tab = fgetcsv($fic,1024,',') )
			{	
				if ( $tab[0] == $promo ) {
					$boolean = true;
				}
			}	
			return $boolean;
		}
/*15 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/


		/**
		*	Methode qui retourne l'url de l'ics d'un groupe
		*	@param groupe
		*	@return url l'url de l'ics associe au groupe
		*/
		function getUrlForm($groupe) {
			$url = "";
			$fic = fopen("modele/DAO/data/form.csv", "r");
			while($tab = fgetcsv($fic,1024,',') )
			{	
				if ( $tab[0] == $groupe ) {
					$url = $tab[1];
				}
			}	
			return $url;
		}
/*16 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		
		/**
		*	Methode qui ajoute une promo, et le lien du fichier contenant les etudiants dans le fichier feuilleABS.csv
		*	@param promo la promo
		* 	@param chemin_fichier le chemin du fichier
		*/
		function ajoutPromoCsv($promo, $chemin_fichier) {
			$lines = file("modele/DAO/data/feuilleABS.csv");
			// var_dump($lines);
			$exist = false;
			foreach ($lines as $line) {
				if ( explode(",", $line)[0] == $promo ) {
					$exist = true;
					$line = explode(",", $line)[0] . $chemin_fichier.'.xls';
					foreach ($lines as $fields) {
					    file_put_contents("modele/DAO/data/feuilleABS.csv", $fields."\n", FILE_APPEND );
					}
				}
			}
			if ( !$exist) {
				$lines = array();
				array_push($lines, ($promo. ',' .$chemin_fichier.".xls") );
				
				foreach ($lines as $fields) {
				    file_put_contents("modele/DAO/data/feuilleABS.csv", $fields."\n", FILE_APPEND );
				}
			}
			
		}
/*17 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		
		/**
		*	Methode qui retourne tous les groupes contenu dans le fichier form.csv ( fichier contenant les urls des ics)
		* 	@return un tableau de groupe (string)
		*/
		function getGroupesCSV() {
			$tab_grp = array();
			$fic = fopen("modele/DAO/data/form.csv", "r");
			while($tab = fgetcsv($fic,1024,',') )
			{	
				array_push($tab_grp, $tab[0]);
			}	
			return $tab_grp;
		}
/*18 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		
		
		/**
		*	Methode qui retourne tous les groupes contenu dans le fichier feuilleABS.csv ( fichier contenant les chemins des feuille d'abs)
		* 	@return un tableau de groupe (string)
		*/
		function getGroupeFeuilleAbs() {
			$tab_grp = array();
			$fic = fopen("modele/DAO/data/feuilleABS.csv", "r");
			while($tab = fgetcsv($fic,1024,',') )
			{	
				array_push($tab_grp, $tab[0]);
			}	
			return $tab_grp;
		}
/*19		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
		
		/**
		*	Methode qui retourne le chemin du fichier des feuilles d'abs
		* 	@param promo la promo souhaitee
		*   @return chemin le chemin de la feuille contenant les noms des etudiants
		*/
		function getFeuilleAbsGroupe($promo) {
			$fic = fopen("modele/DAO/data/feuilleABS.csv", "r");
			$return = "";
			while($tab = fgetcsv($fic,1024,',') )
			{	
				if ( $promo == $tab[0]) {
					$return = $tab[1];
				}
			}
			// var_dump($return);
			return $return;
		}
/*20 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/

		/**
		*	Methode qui retourne les groupes d'une promo, contenu dans les fichiers d'absences
		* 	@param nom_fichier le nom du fichier
		*   @return tableau un tableau de groupe (string)
		*/
		function getGroupeXLS($file_name)
		{
			$tab_groupe = array();
			$objPHPExcel = PHPExcel_IOFactory::load("modele/DAO/data/".$file_name);
			$sheet = $objPHPExcel->getSheet(0);
			$lastRow = ($objPHPExcel->getActiveSheet()->getHighestRow()-6);
			$tmp = array("","");

			
		     for ($j =7; $j < ($lastRow); $j++) {
		     	
			     	$tmp = $sheet->getCellByColumnAndRow(3,$j)->getValue();
			     	array_push($tab_groupe,$tmp);
			     
		     }
			
			return array_unique($tab_groupe);
		}


/*21 		*		*		*		*		*		*		*		*		*		*		*		*		*		*		*/
	
}

	/**
	*	Methode qui permettent le découpage de chaines de carateres
	*/

	function after ($s, $inthat)
    {
        if (!is_bool(strpos($inthat, $s)))
        return substr($inthat, strpos($inthat,$s)+strlen($s));
    }

	function before ($s, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $s));
    }

	function between($s, $that, $inthat)
    {
        return before ($that, after($s, $inthat));
    }




?>