<?php

require_once __DIR__."/../vue/vueAjout.php";
require_once __DIR__."/../modele/DAO/Dao.php";

class ControleurAjout{


    private $vue;
    private $dao;

    public function __construct(){
     	$this->vue = new vueAjout();
     	$this->dao = new Dao();
    }

    function affiche(){
        $this->vue->afficheHead();
 	  //  $this->afficheSelect();
 	    $this->vue->afficheFoot();
    }
    
    function afficheSelect(){
        $grp = $this->dao->getGroupesCSV();
        $this->vue->genererOption($grp);
	     
	}
	
	function upload() {
	    /*Traitement du fichier*/
	    var_dump($_FILES);
	    var_dump($_POST["promo"]);
	    if (move_uploaded_file ( $_FILES["listeEtu"]["tmp_name"] , 'modele/DAO/data/'.$_FILES["listeEtu"]["name"] ) ) {
	        echo "<h3>Liste ajoutée.</h3>";
	        $promo = explode('.',$_FILES["listeEtu"]["name"])[0];
	        $this->dao->ajoutPromoCsv($_POST["promo"],$promo);
	    }
	    
	    
	    /*                     */
	    
	    $this->affiche();
	    
	}
}

?>