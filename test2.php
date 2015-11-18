<?php

require_once'iCalendar2/SG_iCal.php';
require_once'class/Evenement.class.php';


$nb=0;
$tab;


$ICS = "https://edt.univ-nantes.fr/iut_nantes/g3145.ics";


$ical = new SG_iCalReader($ICS);
$query = new SG_iCal_Query();

$evts = $ical->getEvents();

$data = array();
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
	$promo = between('INFO ',' ', $String);
	$groupe = after('INFO '.$promo.' ', $sum);
	if(substr($groupe, 0, 1) == 'G'){
	$groupe = after('Groupe ', $groupe);
	$sous_groupe = '0';
	}
	else if(substr($groupe, 0, 1) == 'T'){
	$sous_groupe = after('-', $groupe);
	$groupe = between('TP ', '-', $groupe);
	}
	else{
		$groupe ='0';
		$sous_groupe = '0';
	}

	$type = before(' -', $sum2);
	$salle = between('Salle : ', '<br />', $String);
	$date_debut = $jsEvt['start'];
	$date_fin = $jsEvt['end'];
	
	$date = new DateTime('@'.$date_debut);
	$date2 = new DateTime('2015-11-16 00:00:00.000');
	$date3 = new DateTime('2015-11-21 00:00:00.000');





	if( ($date > $date2) && ($date < $date3) ){
	$evenement = new Evenement($date_debut, $Matiere, $date_fin, $type, $prof, $promo, $groupe, $sous_groupe, $salle);
	//$evenement->afficher();
	$tab[$nb++] = $evenement;
	}
}





sort($tab);


$jour = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi");
$heure = array("8:00 - 9:20", "9:30 - 10:50", "11:00 - 12:20", "12:20 - 13:30", "13:30 - 14:50", "15:00 - 16:20", "16:30 - 17:50");
$compteur =0;
$compteur2= new DateTime('2015-11-16 08:00:00.000');
$compteur3 = new DateTime('2015-11-16 08:00:00.000');;

$html = "<table valign=top border=10px bgcolor=#F78181 style=border-style:solid border-color:black>";
$html= $html . "<tr> <th></th>";
for($z=0;$z<7;$z++){
	$html = $html . "<th style=border-style:solid>". $heure[$z] ."</th>";
}

$nb=0;
$nb2 = 0;
$fin = false;



$html = $html . "<tr style=border-style:solid><th>".$jour[$compteur++]."</th>";

$date5 = new DateTime('2015-11-16 00:00:00.000');

while($nb < count($tab)){

	$nb2 = 0;
	if(isset($tab3)){
		unset($tab3);
	}
	$heure_courante = $tab[$nb]->getDateDeb();

	for($v=$nb;$v<count($tab);$v++){
		if($heure_courante == $tab[$v]->getDateDeb()){
			$tab3[$nb2++] = $tab[$v];
		}
	}
	if($nb < count($tab)){
	$nb = $nb + $nb2;
	}
	else{
		$fin = true;
	}


	if($date5->format('d') == $tab3[0]->getDateDeb()->format('d')){
		$nb_cour_heure = count($tab3);

		$date6 = $tab3[0]->getDateDeb();
		$dteDiff  = $compteur2->diff($date6);
		$date_courante = $tab3[0]->getDateDeb();


		if($dteDiff->format('%h') >= 0){
			for($a=0;$a<$dteDiff->format('%h')-1;$a++){
				$html = $html . "<td></td>";
			}
			$compteur2 = $tab3[0]->getDateDeb();
		}

		if(isset($tab3)){
			if(count($tab3) == 1){
				$html = $html . "<td bgcolor=#F7BE81 style=border-style:solid align=center>". $tab3[0]->afficher() ."</td>";
			}
			else{
				$html = $html . "<td height=100% valign=top style=border-style:solid><table width=100% height=100% style=border-style:solid border-size:5>";
					for($n=0;$n<count($tab3);$n++){
						if($tab3[$n]->getTypeCour() == "Cour"){
							$html = $html . "<tr style=border-bottom:1pt solid black><td style=valign:top bgcolor=#F7BE81 align=center>". $tab3[$n]->afficher() ."</td></tr>";
						}
						else if($tab3[$n]->getTypeCour() == "TD"){
							$html = $html . "<tr style=border-bottom:1pt solid black><td style=valign:top bgcolor=#A9BCF5 align=center>". $tab3[$n]->afficher() ."</td></tr>";
						}
						else if($tab3[$n]->getTypeCour() == "TP"){
							$html = $html . "<tr style=border-bottom:1pt solid black><td style=valign:top bgcolor=#D0A9F5 align=center>". $tab3[$n]->afficher() ."</td></tr>";
						}
					}
				$html = $html . "</table></td>";
				}
		}

	}
	else{
	$compteur2=new DateTime('2015-11-16 08:00:00.000');

	$html = $html . "</tr> <trstyle=border-style:solid> <th style=border-style:solid>".$jour[$compteur++]."</th>";

	$nb_cour_heure = count($tab3);

		$date6 = $tab3[0]->getDateDeb();
		$dteDiff  = $compteur2->diff($date6);
		$date_courante = $tab3[0]->getDateDeb();

		if($dteDiff->format('%h') >= 0){
			for($a=0;$a<$dteDiff->format('%h')-1;$a++){
				$html = $html . "<td style=border-style:solid></td>";
			}
			$compteur2 = $tab3[0]->getDateDeb();
		}
		$date5 = $tab3[0]->getDateDeb();

		if(count($tab3) == 1){
				$html = $html . "<td bgcolor=#F7BE81 style=border-style:solid align=center >". $tab3[0]->afficher() ."</td>";
			}
			else{
				$html = $html . "<td height=100% valign=top><table width=100% height=100% style=border-style:solid>";
					for($n=0;$n<count($tab3);$n++){
						if($tab3[$n]->getTypeCour() == "Cour"){
							$html = $html . "<tr style=border-bottom:1pt solid black><td style=valign:top bgcolor=#F7BE81 align=center style=border-style:solid>". $tab3[$n]->afficher() ."</td></tr>";
						}
						else if($tab3[$n]->getTypeCour() == "TD"){
							$html = $html . "<tr style=border-bottom:1pt solid black><td style=valign:top bgcolor=#A9BCF5 align= center style=border-style:solid>". $tab3[$n]->afficher() ."</td></tr>";
						}
						else if($tab3[$n]->getTypeCour() == "TP"){
							$html = $html . "<tr style=border-bottom:1pt solid black><td style=valign:top bgcolor=#D0A9F5 align=centere style=border-style:solid>". $tab3[$n]->afficher() ."</td></tr>";
						}
					}
		$html = $html . "</table></td>";
		}
	}

}

$html = $html .  "</table>";

echo $html;
?>


<?php

    function after ($this, $inthat)
    {
        if (!is_bool(strpos($inthat, $this)))
        return substr($inthat, strpos($inthat,$this)+strlen($this));
    };

    function after_last ($this, $inthat)
    {
        if (!is_bool(strrevpos($inthat, $this)))
        return substr($inthat, strrevpos($inthat, $this)+strlen($this));
    };

    function before ($this, $inthat)
    {
        return substr($inthat, 0, strpos($inthat, $this));
    };

    function before_last ($this, $inthat)
    {
        return substr($inthat, 0, strrevpos($inthat, $this));
    };

    function between ($this, $that, $inthat)
    {
        return before ($that, after($this, $inthat));
    };

    function between_last ($this, $that, $inthat)
    {
     return after_last($this, before_last($that, $inthat));
    };

// use strrevpos function in case your php version does not include it
function strrevpos($instr, $needle)
{
    $rev_pos = strpos (strrev($instr), strrev($needle));
    if ($rev_pos===false) return false;
    else return strlen($instr) - $rev_pos - strlen($needle);
};
?>





