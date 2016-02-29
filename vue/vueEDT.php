<?php
require_once __DIR__."/../modele/DAO/Dao.php";
require_once __DIR__."/../modele/Bean/Groupe.php";
require_once __DIR__."/../modele/Bean/Cours.php";

class vueEDT {

	private $tableApercu ;

	function setApercu($p) {
		$this->tableApercu = $p;
	}

	function genererUnCour($uncour){

		$bool = 0;
		foreach ($uncour->getGroupe() as $groupe) {
			if($groupe->getSousGroupe() == "0"){
				$bool = 1;
			}
		}

		if($uncour->getTypeCour() == "TP" && $bool == 1){
				$class = "tg-y0wm rowspan=2";
			}
			else if($uncour->getTypeCour() == "TP"){
				$class = "tg-y0wm rowspan=1";
			}
			else if($uncour->getTypeCour() == "TD"){
				$class = "td rowspan=2";
			}
			else if($uncour->getTypeCour() == "DS=TD"){
				$class = "ds rowspan=2";
			}
			else if($uncour->getTypeCour() == "Cours"){
				$class = "amphi rowspan=2";
			}
			else if($uncour->getMatiere() == "Projet Tut." && $bool == 1){
				$class = "td rowspan=2";
			}
			else if($uncour->toStringGroupe() == "PROMO"){
				$class = "None rowspan=2";
			}
			else{
				$class = "tg-4wtr rowspan=1";
			}

		return "<td class=".$class." colspan=".$uncour->getDureeToInt()." width=".$uncour->getDureeToInt()."><div class=nom_matiere>".$uncour->getMatiere()."</div> <div class=prof >".$uncour->getProf()."</div> \n <div class=salle >".$uncour->getSalle()."</div>\n <div class=type>".$uncour->getTypeCour()."</div> \n <div class=heure>".$uncour->getDateDeb()->format("H:i")." - ".$uncour->getDateFin()->format("H:i")."</div> \n <div class=groupe>".$uncour->toStringGroupe()."</div></td>";
	}

	function genererEspaceCour($diff, $row){
		return "<td class=tg-jbrh rowspan=".$row." colspan=".$diff." width=".$diff."0></td>";
	}

	function genererEnTetes(){
		$crenaux = ["8:00 - 9:00", "9:00 - 10:00", "10:00 - 11:00", "11:00 - 12:00", "12:00 - 13:00", "13:00 - 14:00",  "14:00 - 15:00", "15:00 - 16:00", "16:00 - 17:00", "17:00 - 18:00", "18:00 - 19:00"];
		$jour = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"];
		include ('static/edtHead.html');
		$precedent = $_POST['date']-1;
		$suivant = $_POST['date']+1;
		$groupe_decode = urldecode($_POST['groupe']);
		$html ="<div id=div_prevu >".$this->tableApercu."</div>



		<div class=edt id=tableEdt>
			<ul>
			  <li><a href=index.php>Accueil</a></li>
			  <li><a class=active>EDT</a></li>
			  <li><a href=#contact>Contact</a></li>
			  <li><a href=#about>About</a></li>
			  <li><a href=index.php?ics=".urlencode($_POST['groupe'])."&semaine=".$_POST['date']." target=_blank> Feuille Absence </a>
			</ul>
		<h1 text-align=center>".$groupe_decode." Semaine ".$_POST['date']."</h1>
		<table id=boutons>
<tr>

	<td>
		<form method=post  action=index.php>
		<input type=hidden name=groupe value=".urlencode(urldecode($_POST['groupe']))." />
		<input type=hidden name=date value=".$precedent." />
		<input type=hidden name=edt value=true />
		<input class=suiv_pre type=submit value='Semaine Precedente' />
		</form>
	<td/>

	<td>
		<form method=post  action=index.php>
		<input type=hidden name=groupe value=".urlencode(urldecode($_POST['groupe']))." />
		<input type=hidden name=date value=".$suivant." />
		<input type=hidden name=edt value=true />
		<input class=suiv_pre type=submit value='Semaine Suivante' />
		</form>
	<td/>
	<td>
		<form method=post  action=index.php>
		
		</form>
	<td/>

<tr/>
</table>
		<table class=tg><tr><th class=tg-c3cn>Heures</th>";

		for($i=0; $i<11; $i++){
			$html .= "<th class=tg-c3cn colspan=6>".$crenaux[$i]."</th> ";
		}

		$html .= "</tr>";

		return $html;
	}

function afficher($html){
	echo $html;
}




	function affiche2() {

$dao = new Dao();
$dao->setICS(urldecode($_POST['groupe']));
$dao->getCours();

$precedent = $_POST['date']-1;
$suivant = $_POST['date']+1;
$groupe_decode = urldecode($_POST['groupe']);


$crenaux = ["8:00 - 9:00", "9:00 - 10:00", "10:00 - 11:00", "11:00 - 12:00", "12:00 - 13:00", "13:00 - 14:00",  "14:00 - 15:00", "15:00 - 16:00", "16:00 - 17:00", "17:00 - 18:00", "18:00 - 19:00"];
$jour = ["Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi"];

include ('static/edtHead.html');

$html = "

<div class=edt id=tableEdt ><h1 text-align=center>".$groupe_decode." Semaine ".$_POST['date']."</h1>


<table id=boutons>
<tr>
<form method=post  action=index.php>
<td>
	
	<input type=hidden name=groupe value=".urlencode(urldecode($_POST['groupe']))." />
	<input type=hidden name=date value=".$precedent." />
	<input type=hidden name=edt value=true />
	<input class=suiv_pre type=submit value='Semaine Precedenteeeeeeeee' />
	
<td/>

<td>

	<input type=hidden name=groupe value=".urlencode(urldecode($_POST['groupe']))." />
	<input type=hidden name=date value=".$suivant." />
	<input type=hidden name=edt value=true />
	<input class=suiv_pre type=submit value='Semaine Suivante' />
	
<td/>
<td>	
<a href=index.php?ics=".urlencode($_POST['groupe'])."&semaine=".$_POST['date']." target=_blank> <input class=suiv_pre type=button value=FeuilleAbsence> </a>
<td/>
</form>
<tr/>
</table>






<table class=tg><tr><th class=tg-c3cn>Heures</th>";

for($i=0; $i<11; $i++){
	$html .= "<th class=tg-c3cn colspan=6>".$crenaux[$i]."</th> ";
}

$html .= "</tr>";




for($j=0; $j<5; $j++){

	$tab_courzero = array();
	$journee = new DateTime();
	$journee->setISOdate("2016", $_POST['date']);
	$journee->setTime(8, 0, 0);

	//$courpre = new DateTime("2016-02-15 08:00:00");

	//Noé
	$nbGroupes = count($dao->getGroupes($dao->getCoursDate($journee->format("Y-m-d h:i:s"))));


	if(isset($dao->getGroupes($dao->getCoursDate($journee->format("Y-m-d h:i:s")))[0]) && $dao->getGroupes($dao->getCoursDate($journee->format("Y-m-d h:i:s")))[0]->getNumero() == "1"){
		$nbGroupes++;
	}
	//

	$html .= "<td class=tg-c3cn rowspan=".($nbGroupes*2-1).">".$jour[$j]."</td>";


foreach ($dao->getGroupes($dao->getCoursDate($journee->format("Y-m-d h:i:s"))) as $ungroupe){

	// echo $ungroupe->getNumero();

	$journee = new DateTime();
	$journee->setISOdate("2016", $_POST['date']);
	$journee->setTime(8, 0, 0);

	$courpre = new DateTime();
	$courpre->setISOdate("2016", $_POST['date']);
	$courpre->setTime(9, 0, 0);

	if($j > 0){
		$cours = $dao->getGroupeSousGroupe($journee->add(new DateInterval("P".$j."D"))->format("Y-m-d h:i:s"), $ungroupe->getNumero());
		$coursG2 = $dao->getCoursDateJourneeSousGroupeBis($journee->format("Y-m-d h:i:s"), $ungroupe->getNumero());
		$courpre = $courpre->add(new DateInterval("P".$j."D"));
	}
	else{
		$cours = $dao->getGroupeSousGroupe($journee->format("Y-m-d h:i:s"), $ungroupe->getNumero());
		$coursG2 = $dao->getCoursDateJourneeSousGroupeBis($journee->format("Y-m-d h:i:s"), $ungroupe->getNumero());
	}

	$cours = array_merge($cours, $tab_courzero);
	sort($cours);
	sort($coursG2);


	if($ungroupe->getNumero() == "0"){
		$tab_courzero = $cours;
	}

	else{

		$html .="<tr>";

		foreach ($cours as $c) {

			if($c->getTypeCour() == "TP"){
				$class = "tg-y0wm rowspan=1";
			}
			else if($c->getTypeCour() == "TD"){
				$class = "td rowspan=2";
			}
			else if($c->getTypeCour() == "DS=TD"){
				$class = "ds rowspan=2";
			}
			else if($c->getTypeCour() == "Cours"){
				$class = "amphi rowspan=2";
			}
			else{
				$class = "tg-4wtr rowspan=1";
			}

			//var_dump($dao->getCoursDateJourneeSousGroupe($journee->format("Y-m-d h:i:s"), "1"));

			if(diffCoursDate($courpre, $c->getDateDeb()) > 0){
				$html .= "<td class=tg-jbrh colspan=".diffCoursDate($courpre, $c->getDateDeb())." width=".diffCoursDate($courpre, $c->getDateDeb())."0></td>";
			}


			$html .= "<td class=".$class." colspan=".$c->getDureeToInt()." width=".$c->getDureeToInt()."><div class=nom_matiere>".$c->getMatiere()."</div> <div class=prof >".$c->getProf()."</div> \n <div class=salle >".$c->getSalle()."</div>\n</td>";
			$courpre = $c->getDateFin();
		}
		$html .= "</tr>";


	if(!empty($coursG2)) {

		$courpre = $dao->getCourPrecedent($coursG2[0]);
	

		$html .= "<tr>";
		foreach ($coursG2 as $c2) {

			if($c2->getTypeCour() == "TP"){
					$class = "tg-y0wm";
				}
				else if($c2->getTypeCour() == "TD"){
					$class = "td rowspan=2";
				}
				else if($c2->getTypeCour() == "Cours"){
					$class = "amphi rowspan=2";
				}
				else{
					$class = "tg-4wtr rowspan=2";
				}


				if(diffCoursDate($courpre, $c2->getDateDeb()) > 0){
					$html .= "<td class=tg-jbrh colspan=".diffCoursDate($courpre, $c2->getDateDeb())." width=".diffCoursDate($courpre, $c2->getDateDeb())."0></td>";
				}


				$html .= "<td class=".$class." colspan=".$c2->getDureeToInt()." width=".$c2->getDureeToInt()."><div class=nom_matiere>".$c2->getMatiere()."</div> <div class=prof >".$c2->getProf()."</div> \n <div class=salle >".$c2->getSalle()."</div>\n</td>";
				$courpre = $c2->getDateFin();
		}
		$html .= "</tr>";
	}
	else{
		$html .= "<tr></tr>";
	}
	}
}

 }



	






// echo '<div id="div_prevu"></div>';
//echo $html;

	}


	

}





//echo preg_replace('#[^0-9]#', null, "fef 5 erf e fe 7 v687645 ");




/*


echo '// Groupes de l ics';
$groupes = $dao->getGroupes();
foreach ($groupes as $groupe) {
	echo '<br/>'.$groupe->toString();
}
echo '<br/> // promos de l ics';
$promos = $dao->getPromo();
foreach ($promos as $promo) {
	echo '<br/>'.$promo;
}

echo '<br/> // Cours a partir du 18/01/2016 8h';
$cours = $dao->getCoursDate("2016-01-18 08:00:00");
foreach ($cours as $c) {
	echo '<br/>'.$c->format('Y-m-d H:i:s');
}



echo '<br/> // Groupe de promo info2';
$groupes = $dao->getGroupePromo("info2");
foreach ($groupes as $g) {
	echo $g->toString().'|';
}

echo '<br/> // Cours du groupe 2 du "2016-01-18 08:00:00"';
$groupes = $dao->getCoursGroupe("2016-01-18 08:00:00","promo2g2");
foreach ($groupes as $g) {
	echo $g->toString().'|';
}

// echo '<br/> // Cours de promo 2 du "2016-01-18 08:00:00"';
// $groupes = $dao->getCoursPromo("2016-01-18 08:00:00","promo2g2");
// foreach ($groupes as $g) {
// 	echo $g->toString().'|';
// }

*/


?>


