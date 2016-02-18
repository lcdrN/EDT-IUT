<?php
require_once'iCalendar2/SG_iCal.php';
require_once 'PHPExcel/IOFactory.php';
require_once __DIR__.'/../Bean/Cours.php';
require_once __DIR__.'/../Bean/Groupe.php';
require_once __DIR__.'/../Bean/Promo.php';
$objPHPExcel = PHPExcel_IOFactory::load("etu.xls");
			 
			$sheet = $objPHPExcel->getSheet(0);
			$lastRow = $objPHPExcel->getActiveSheet()->getHighestRow();
			echo 'Taille row:'.($lastRow-7);
			
			
			for($i = 1; $i < 3; $i++ ) {
			     for ($j =7; $j < ($lastRow-7); $j++) {
			     	echo '</br>-'.$i.'.'.$j.' - '.$sheet->getCellByColumnAndRow($i,$j);
			     }
			}


			


?>