<?php


class vueAjout {
   

	 function __construct() {
	     
	 }
	 
	 function afficheHead() {
	     include("static/ajoutListe.html");
	 }
	 
	 function afficheFoot() {
	     include("static/ajoutListeFoot.html");
	 }
	 
	 function genererOption($grp) {
	 echo 
	   "<form> <select>";
	   foreach ($grp as $g) {
	       echo '<option value="'.$g.'">'.$g.'</option>';
	   }
	   echo 
	   "</select> </form>";
	 }
	
}