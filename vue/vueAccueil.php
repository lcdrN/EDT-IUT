<?php


class vueAccueil {

	 
	function __construct(){

	}

	function affiche(){
		include 'static/accueil.html';
		$this->selectSemaine();
		include 'static/accueilFoot.html';
		
	}

	function selectSemaine() {
		echo '<div class="select">
					<td>Choisissez la semaine: </td>
					<td><select name="date" id="date" class="imput">';
		$week = date('W');
		for ($i=34; $i < 54; $i++) { 
			if ($i == $week) {
			echo "<option selected value=\"".$i."\">Semaine ".$i."</option>";
			}
			else
				echo "<option value=\"".$i."\">Semaine ".$i."</option>";
		}
		for ($i=1; $i < 34; $i++) { 
			if ($i == $week) {
			echo "<option selected value=\"".$i."\">Semaine ".$i."</option>";
			}
			else
				echo "<option value=\"".$i."\">Semaine ".$i."</option>";
		}
		echo '</select></td></td></div>';

	}
}



?>