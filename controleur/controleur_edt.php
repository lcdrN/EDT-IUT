<?php


require_once __DIR__."/../vue/vueEDT.php";
require_once __DIR__."/../modele/DAO/Dao.php";
require_once __DIR__."/../modele/Bean/Groupe.php";
require_once __DIR__."/../modele/Bean/Cours.php";

class controleurEDT{


private $vue;
private $dao;
 
 public function __construct(){
 	$this->vue = new vueEDT();
 	$this->dao = new Dao();
 }

 function affiche(){
	$this->dao->setICS(urldecode($_POST['groupe']));
	$this->dao->getCours();

	
			

	$edt = $this->genererEDT($_POST['date']);
	$edtApercu = $this->genererTableEdt($edt);
	 // echo '*'.($edtBis).($edt).'*';
	$this->vue->setApercu( $edtApercu);
	$this->vue->afficher($this->vue->genererEnTetes());
 	$this->vue->afficher($edt);
 }

function genererJourGroupe($jour, $groupe){
	
 	//Récupère les cours du jour du groupe (x+x.1 et x.2)
 	$cours = $this->dao->getGroupeSousGroupe($jour->format("Y-m-d h:i:s"), $groupe);
	$coursG2 = $this->dao->getCoursDateJourneeSousGroupeBis($jour->format("Y-m-d h:i:s"), $groupe);
 	$html = "";
	if($groupe != "0"){
 	$cours = array_merge($cours, $this->dao->getGroupeSousGroupe($jour->format("Y-m-d h:i:s"), "0"));
 	}
 	else{
 		return "";
 	}
	//On range les tableaux
	sort($cours);
	sort($coursG2);
	//On définit la date du cour précédent
	$date_cour_precedent = new DateTime($jour->format("Y-m-d H:i:s"));
	$date_cour_precedent->setTime(9, 0, 0);

	//Pour chaque cour du groupe X et X.1
	foreach ($cours as $uncour) {

		//Si une différence de temps entre le cour précédent et $uncour 
		if(diffCoursDate($date_cour_precedent, $uncour->getDateDeb()) > 0){
			$html .= $this->vue->genererEspaceCour(diffCoursDate($date_cour_precedent, $uncour->getDateDeb()), $this->dao->getTailleRowspan($uncour));
		}
		//On affiche le cour
		$html .= $this->vue->genererUnCour($uncour);
		$date_cour_precedent = $uncour->getDateFin();
	}
	$html .="</tr>";

	//Si il y a des cours du groupe X.2
	if(!empty($coursG2)){
		$html .= "<tr>";
		//On récupère la date du cour précédent
		$date_cour_precedent = $this->dao->getCourPrecedent($coursG2[0]);
		//Pour chaque cours
		foreach ($coursG2 as $uncour) {
			$date_cour_precedent = $this->dao->getCourPrecedent($uncour);
			if(diffCoursDate($date_cour_precedent, $uncour->getDateDeb()) > 0){
				echo $uncour->getProf()." ".$date_cour_precedent->format("Y-m-d H:i:s")."<br>";
				$html .= $this->vue->genererEspaceCour(diffCoursDate($date_cour_precedent, $uncour->getDateDeb()), $this->dao->getTailleRowspan($uncour));
			}
		//On affiche le cour
		$html .= $this->vue->genererUnCour($uncour);
		$date_cour_precedent = $uncour->getDateFin();	
		}
		$html .="</tr>";
	}
	else{
		$html .= "<tr></tr>";
	}

	return $html;

}



function genererUnJour($jour){

	$html = array(); 
	//On récupère tout les groupes
	$groupes = $this->dao->getGroupes($this->dao->getCoursDateJournee($jour->format("Y-m-d H:i:s")));
	if(count($groupes) == 1 && $groupes[0]->getNumero() == "0"){
		$groupes[0]->setNumero("1");
	} 
	//Pour chaque groupes on genère le code html
	foreach ($groupes as $ungroupe) {
		if($ungroupe->getNumero() != 0) {
			$html[$ungroupe->getNumero()]= $this->genererJourGroupe($jour, $ungroupe->getNumero());
		}
	}
	return $html;
}


function genererSemaine($date){
	$html = array();

	for($i=0; $i<5; $i++){
		$html[$i] = $this->genererUnJour($date);
		$date->add(new DateInterval("P1D"));
	}

	return $html;
}


function genererEDT($numero_semaine){
	$jours = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"];

	//On récupère la semaine a afficher et on en déduit la premier jour de la semaine
	$date = new Datetime();
	$date->setISOdate("2016", $numero_semaine);
	$date->setTime(8, 0, 0);
	$html ="";
	// $html = $this->vue->genererEnTetes();

	$jours_semaine = $this->genererSemaine($date);

	for($i=0; $i<5; $i++){
		$html .= "<tr><td class=tg-c3cn rowspan=".(count($jours_semaine[$i])*2)."><div class=jour>".$jours[$i]."<br>".$date->format("d/m/Y")."</div></td>";
		foreach ($jours_semaine[$i] as $unjour) {
			$html .= $unjour;
		}
		$date->add(new DateInterval('P1D'));
	}

	return $html;

}

function genererTableEdt( $edt){
	$crenaux = ["8:00 - 9:20", "9:30 - 10:50", "11:00 - 12:20", "12:30 - 13:20", "13:30 - 14:50", "15:00 - 16:20",  "16:30 - 17:50", "18:00 - 19:20", "19:30 - 20:50", "17:00 - 18:00", "18:00 - 19:00"];
	$html = "<table class=tg><tr><th class=tg-c3cn>Heures</th>";

	for($i=0; $i<11; $i++){
			$html .= "<th class=tg-c3cn colspan=8>".$crenaux[$i]."</th>";
		}

	$html .= "</tr>";
	$html .= $edt .'</table>';

	$html = str_replace('<table class=tg>', '<table class="tg_print">"', $html);
	$html = str_replace('class=tg-c3cn', 'class="tg-c3cn_print"', $html);
	$html = str_replace('class=td', 'class="td_print"', $html);
	$html = str_replace('class=amphi', 'class="amphi_print"', $html);
	$html = str_replace('class=tg-jbrh', 'class="tg-jbrh_print"', $html);
	$html = str_replace('class=tg-y0wm', 'class="tg-y0wm_print"', $html);

		$html = str_replace('class=nom_matiere', 'class="nom_matiere_print"', $html);
		$html = str_replace('class=prof', 'class="prof_print"', $html);
		$html = str_replace('class=salle', 'class="salle_print"', $html);
		$html = str_replace('class=groupe', 'class="groupe_print"', $html);
		$html = str_replace('class=heure', 'class="heure_print"', $html);
		$html = str_replace('class=type', 'class="type_print"', $html);

	// $html = str_replace('REMM', 'hey', $html);


	return $html;
}






}

?>