<?

require_once "controleur_accueil.php";
require_once "controleur_edt.php";
require_once "controleur_absence.php";

class routeur {

	private $ctrl_accueil;
	private $ctrl_edt;
	private $ctrl_abs;

	function __construct(){
		
		$this->ctrl_accueil = new controleurAccueil();
		$this->ctrl_edt = new controleurEDT();
		$this->ctrl_abs = new ControleurAbsence();

	}
		// else  else {
		// 	$this->ctrl_accueil->affiche();
		// }

	function router_requete() {
		// echo $_POST["groupe"];
		// echo $_POST["date"];
		if ( isset($_GET["ics"]) && isset($_GET["semaine"])) {
				$this->ctrl_abs->affiche();
		}
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
		
			
		} else {
			$this->ctrl_accueil->affiche();
		}
					
				
					
				
					
		
	}
}



?>