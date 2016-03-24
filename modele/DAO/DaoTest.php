<?php
require_once "Dao.php";

class DaoTest extends PHPUnit_Framework_TestCase
{

/* Fonction after*/
    /* Scenario nominal*/
        public function testAfterNominal0(){
            $this->assertEquals("Matière : Cult. & Com.3", after("DESCRIPTION:","DESCRIPTION:Matière : Cult. & Com.3"));
        }
        
        public function testAfterNominal1(){
            $this->assertEquals(", consectetur adipiscing elit", after("amet","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testAfterNominal2(){
            $this->assertEquals("", after("elit","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
    /* Scenario Exceptionels*/  
        public function testAfterExceptionel0(){
            $this->assertEquals("", after("DESCRIPTION:","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testAfterExceptionel1(){
            $this->assertEquals("", after("DESCRIPTION:",""));
        }
/* * * * */

/* Fonction before*/
    /* Scenario nominal*/
        public function testBeforeNominal0(){
            $this->assertEquals("", before("DESCRIPTION:","DESCRIPTION:Matière : Cult. & Com.3"));
        }
        
        public function testBeforeNominal1(){
            $this->assertEquals("Lorem ipsum dolor sit ", before("amet","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testBeforeNominal2(){
            $this->assertEquals("Lorem ipsum dolor sit amet, consectetur adipiscing ", before("elit","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
    /* Scenario Exceptionels*/  
        public function testBeforeExceptionel0(){
            $this->assertEquals("", before("DESCRIPTION:","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testBeforeExceptionel1(){
            $this->assertEquals("", before("DESCRIPTION:",""));
        }
/* * * * */

/* Fonction between*/
    /* Scenario nominal*/
        public function testBetweenNominal0(){
            $this->assertEquals("Matière ", between("DESCRIPTION:",":","DESCRIPTION:Matière : Cult. & Com.3"));
        }
        
        public function testBetweenNominal1(){
            $this->assertEquals(" ipsum dolor sit amet, consectetur adipiscing ", between("Lorem","elit","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testBetweenNominal2(){
            $this->assertEquals("", between("elit","adipiscing ","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
    /* Scenario Exceptionels*/  
        public function testBetweenExceptionel0(){
            $this->assertEquals("", between("DESCRIPTION:","ipsum","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testBetweenExceptionel1(){
            $this->assertEquals("", between("ipsum","ipsum","Lorem ipsum dolor sit amet, consectetur adipiscing elit"));
        }
        
        public function testBetweenExceptionel2(){
            $this->assertEquals("", between("DESCRIPTION:","ipsum",""));
        }
/* * * * */

/* Fonction getUrlForm*/
    /* Scenario nominal*/
        public function testGetUrlFormNominal0(){
            $dao = new Dao();
            $oracle = "https://edt.univ-nantes.fr/iut_nantes/g3178.ics";
            $this->assertEquals($oracle, $dao->getUrlForm("Groupe 1"));
        }
        
        public function testGetUrlFormNominal1(){
            $dao = new Dao();
            $oracle = "https://edt.univ-nantes.fr/iut_nantes/g3164.ics";
            $this->assertEquals($oracle, $dao->getUrlForm("INFO1G1TP2"));
        }
        
    /* Scenario Exceptionels*/  
        public function testGetUrlFormExceptionel0(){
            $dao = new Dao();
            $this->assertEquals("", $dao->getUrlForm("fff"));
        }
        
        public function testGetUrlFormExceptionel1(){
            $dao = new Dao();
            $this->assertEquals("", $dao->getUrlForm(""));
        }

/* * * * */

/* Fonction getGroupesCSV*/
    /* Scenario nominal*/
        public function testGetGroupesCSVNominal0(){
            $oracle = array("Groupe 1",
                        "Groupe 2",
                        "Groupe 3",
                        "INFO2G4",
                        "GEAALT",
                        "GEA2MOC",
                        "INFO1G1",
                        "INFO2",
                        "INFO1",
                        "INFO1G1TP1", 
                        "INFO1G1TP2", 
                );
            $dao = new Dao();
            $this->assertEquals($oracle, $dao->getGroupesCSV());
        }
        
        

/* * * * */
}