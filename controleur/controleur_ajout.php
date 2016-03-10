<?php

require_once __DIR__."/../vue/vueAjout.php";
require_once __DIR__."/../modele/DAO/Dao.php";


/** ControleurAjout
 *  Classe qui permet de gerer la vue
 *  de l'ajout
 */
class ControleurAjout{


    private $vue;
    private $dao;

    public function __construct(){
     	$this->vue = new vueAjout();
     	$this->dao = new Dao();
    }
	
	/** Fonction qui apelle la vue pour
	 *  afficher le formulaire d'ajout de liste.
	 */
    function affiche(){
        $this->vue->afficheHead();
 	  //  $this->afficheSelect();
 	    $this->vue->afficheFoot();
    }
    
    /**	Fonction qui genere les groupes disponibles
     *  dans le select.
     *  /!\BLOQUE en static a INFO1 et INFO2
     */
    function afficheSelect(){
        $grp = $this->dao->getGroupesCSV();
        $this->vue->genererOption($grp);
	     
	}
	
	
	/** Fonction qui traite le fichier lorsqu'il est positioné.
	 *  Ajoute une ligne dans le csv feuilleABS.csv
	 *  -> GROUPE,FICHIER_GROUPE.xls
	 */
	function upload() {
	    /*Traitement du fichier*/
	    // var_dump($_FILES);
	    // var_dump($_POST["promo"]);
	    if (move_uploaded_file ( $_FILES["listeEtu"]["tmp_name"] , 'modele/DAO/data/'.$_FILES["listeEtu"]["name"] ) ) {
	        echo "<h3>Liste ajoutée.</h3>";
	        $promo = explode('.',$_FILES["listeEtu"]["name"])[0];
	        $this->dao->ajoutPromoCsv($_POST["promo"],$promo);
	    }
	    /* On re affiche la page, car on est pas redirectionnee */
	    $this->affiche();
	    
	}
}

?>