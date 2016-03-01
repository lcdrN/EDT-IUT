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
 	    $this->afficheSelect();
 	    $this->vue->afficheFoot();
    }
    
    function afficheSelect(){
        $grp = $this->dao->getGroupesCSV();
        $this->vue->genererOption($grp);
	     
	}
}

?>