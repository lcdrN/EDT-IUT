<?php

require_once "controleur_accueil.php";
require_once "controleur_edt.php";
require_once "controleur_absence.php";
require_once "controleur_ajout.php";

/** Routeur
 *  Classe qui permet de rediriger les vues
 * selon les choix de l'utilisateur.
 */
class routeur {

	private $ctrl_accueil;
	private $ctrl_edt;
	private $ctrl_abs;

	function __construct(){
		
		$this->ctrl_accueil = new controleurAccueil();
		$this->ctrl_edt = new controleurEDT();
		$this->ctrl_abs = new ControleurAbsence();
		$this->ctrl_ajout = new ControleurAjout();

	}
		
		
	/** Fonction apellee a chaque chargement d'index.html
	 *  Traite les donnes passees en GET et POST afin d'afficher 
	 *  les vues correspondantes.
	 * 
	 */
	function router_requete() {
		
		
		/* Si GET[ajoutListe] est positionnee, on affiche la vue correspondant a l'ajout de liste*/
		if ( isset($_GET["ajoutListe"])) {
			$this->ctrl_ajout->affiche();
		} 
		
		/* Sinon si un fichie est positionnee, on le traite*/
		else if ( isset( $_POST["upload"]) ) {
				$this->ctrl_ajout->upload();
		}
		/* Sinon si un groupe et une semaine est possitionee en GET, on affiche edt*/
		else if ( isset($_GET["ics"]) && isset($_GET["semaine"])) {
				$this->ctrl_abs->affiche();
		}
		
		/* Sinon si un groupe et une semaine est possitionee en POST, on affiche edt ou abs selon le POST[abs] ou POST[edt]*/
		else if ( isset($_POST["abs"] )){
			//echo '<br>aff ABS';
			if ( isset($_POST["groupe"]) && isset($_POST["date"])) {	
				
				$this->ctrl_abs->affiche();
			}  else {
				$this->ctrl_accueil->affiche();
			}
			
		} else if (isset($_POST["edt"])) {
			
			if ( isset($_POST["groupe"]) && isset($_POST["date"])) {
				
				$this->ctrl_edt->affiche();
			}
		
		/* Sinon on affiche l'accueil*/
		} else {
			$this->ctrl_accueil->affiche();
		}
					
				
					
				
					
		
	}
}



?>