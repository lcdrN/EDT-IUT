<?php


class vueAbsence {

	 
	function __construct(){

	}

	

	function head() {
		include "static/absence.html";
	}

	function tableau(){
		if (isset($_POST['groupe'])){
			$groupe = urldecode($_POST['groupe']);
			$date = $_POST["date"];
		} else {
			$groupe = urldecode($_GET['ics']);
			$date = $_GET["semaine"];
		}
		$dao = new Dao();
		$dao->setICS($groupe);
		$dao->getCours();


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


		foreach ($dao->getCoursDate($periode) as $cours) {
			array_push($tabMod, $cours->getMatiere());
		}

		$tabEtu = $dao->getEtudiants($groupe);

		
		
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

	function tableauPromo($groupes) {
		include 'static/absencePromo.html';
		foreach ($groupes as $g) {
			echo "</br>";
			echo '<a href="index.php?ics='.urlencode($g).'&semaine=8" target="_blank" >'.$g.' <a/>';
		}
		include 'static/absencePromoFoot.html';
		// echo '<script type="text/javascript">'; //ouverture du javascript
		// for ($i=0; $i<=5; $i++) { // début boucle
		
		// echo "window.open('http://infoweb/~e145634y/edt_projet/edt_n%20%28copie%29/index.php')";
		
		// } // fin boucle
		 
		// echo '</script>'; // fermeture du JS
		
	}
	
	function ajoutListe() {
		include("static/ajoutListe.html");
		
	}
}