<?php

/**
 *  Classe qui permet de creer la vue 
 *  generant la feuille d'absence.
 * 
 */
class vueAbsence {

	 
	function __construct(){

	}

	

	function head() {
		include "static/absence.html";
	}
	
	/** Fonction qui affiche un tableau representant une feuille d'absence.
	 *  Parcour tous les cours de la periode passe en paremetre selon le
	 *  groupe passe en parametre. 
	 * 
	 */
	function tableau(){
		
		/* Selon la methode de passage de parametre POST ou GET on recupere
		   le groupe et la date passee en parametre.						
		*/
		if (isset($_POST['groupe'])){
			
			if (strpos($_POST['groupe'], ':') !== FALSE) {
			    $groupe = urldecode(explode(":",$_POST['groupe'])[1]);
				$promo = explode(":",$_POST['groupe'])[0];
			} else {
			    // header("location:index.php");
			    $groupe = $_POST['groupe'];
			    $promo = $_POST['groupe'];
			}
			$date = $_POST["date"];
		} else {
			if (strpos($_GET['ics'], ':') !== FALSE) {
				$groupe = urldecode( explode(":",$_GET['ics'])[1]);
				$promo =  explode(":", urldecode($_GET['ics']))[0];
			} else {
			    // header("location:index.php");
			    $groupe = $_GET['ics'];
			    $promo = $_GET['ics'];
			}
			$date = $_GET["semaine"];
		}
		/* On instancie un DAO afin de recuperer les donnees*/
		$dao = new Dao();
		// var_dump($group);
		$dao->setICS($groupe); 	// Indique pour quelle groupe.
		$dao->getCours();		// Le DAO recupere les cours associe a partir de l'ics.

		/* Calcul des dates*/
		$tmpdate = new DateTime();
		$tmpdate->setISOdate("2016", $date);
		$periode = $tmpdate->format("y-m-d");
		$periodeObject = new DateTime($periode." 08:00:00");
		$tabMod = array();
		$tabEtu = array(array());

		$tabjours = array("Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi" );

		$tabDate["Lundi"] = new DateTime($periode);
		$tabDate["Mardi"] = $tabDate["Lundi"]->add( new DateInterval('P1D'));
		$tabDate["Mercredi"] = $tabDate["Lundi"]->add( new DateInterval('P2D'));
		$tabDate["Jeudi"] = $tabDate["Lundi"]->add( new DateInterval('P3D'));
		$tabDate["Vendredi"] = $tabDate["Lundi"]->add( new DateInterval('P4D'));

		/* Recupere tous les cours*/
		foreach ($dao->getCoursDate($periode) as $cours) {
			array_push($tabMod, $cours->getMatiere());
		}
		
		/* recupere les etudiants*/
		$tabEtu = $dao->getEtudiants($promo,$groupe);
		
		
		/* Affiche la table */
		$html = "";
		$html = $html .'<p>'.$groupe.'</br>'.$tmpdate->format("d-m-y").'</p>';
		$html = $html .'<body>';

		$html = $html . '<table style="width:50%">';
		$html = $html . '<tr class="trHead">';
		$html = $html .	'<th id="headEtu" ><div></div></th><th id="headEtu" ><div></div></th>';

		foreach($tabMod as $mod ) {
				$html = $html . '<th class="rotate" ><div><span>'. $mod.'</span></div></th>';
			}


			
		    
		$html = $html .' </tr>';

		$html = $html .' <tr><th>Nom</th><th>Prenom</th>';
		$i=0;
		foreach($tabjours as $jour ) { 
			$tmp = new DateTime($periodeObject->format('y-m-d h:i:s'));
			$tmp ->add(new DateInterval('P'.$i.'D'));
			$nbDate = $dao->getCoursDateJournee($tmp->format('y-m-d h:i:s'));
			$html = $html .	'<th colspan="'.count($nbDate).'" class="jour">' .$jour.'</th>';
			$i=$i+1;
		}
		$html = $html .' </tr>';
		 
		  $j = 0;
		  foreach($tabEtu as $etu ) {
			  if ( $j % 2 == 1 ){
				$html = $html . '<tr>
				<td class="etu">'.$etu[0].'</td>'.'<td class="etu">'.$etu[1].'</td>';
			  } else {
				  $html = $html . '<tr class="gris">
				  <td class="etu" >'.$etu[0].'</td>'.'<td class="etu">'.$etu[1].'</td>';
			  }
			for($i=0; $i<count($tabMod); $i++) {
				$html = $html . '<td></td>';
			}
		    $j++;
		  $html = $html . '</tr>';
		  }
		  
		$html = $html . '<tr > <td colspan=2 id="nbAbs" >Nombre d\'absences</td>';
	    foreach($tabMod as $mod ) {
			$html = $html . '<td class="sign" ></td>';
	 	}

	  	$html = $html . '</tr>';
		$html = $html . '<tr> <td colspan=2 id="sign"> Signature</td>';
		foreach($tabMod as $mod ) {
			$html = $html . '<td class="sign" ></td>';
		}
		$html = $html . '</tr>';

		  
		 
		$html = $html .'</table>';
		$html = $html .'</body>';
		$html = $html .'</page>';
		$html = $html .'</html>';


		echo $html;
	}


	/** Fonction qui affiche des liens pour
	 *  tous les groupes de la promo.
	 */
	function tableauPromo($promo, $groupes) {
		include 'static/absencePromo.html';
		foreach ($groupes as $g) {
			echo "</br>"; 
			echo '<a href="index.php?ics='.urlencode($promo.':'.$g).'&semaine=8" target="_blank" ><input class="suiv_pre" type="button" value="'.$g.'"/> <a/>';
		}
		include 'static/absencePromoFoot.html';
	}
	

}