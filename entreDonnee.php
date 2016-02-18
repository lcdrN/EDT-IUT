<?php
require_once __DIR__."/modele/DAO/Dao.php";
$dao = new Dao();
$dao->setICS("INFO2G2");
$dao->getCours();
// $tab_g = $dao->getGroupes2();
$tab_c = $dao->getCoursGroupe("2016-02-01 08:00:00", 'Groupe 2');

// $str = 'coucou petite xxxx';
// str_repl
// $dao1 = new Dao();
// $dao1->setICS("INFO1G1");
// $dao1->getCours();

// echo 'Groupes:';
// foreach ($tab_g as $g) {
// 	echo '<br/>-'.$g->getNumero().'   - '.$g->getSousGroupe();
// }
// echo '<br/>';
// echo '<br/>Cours g1:';
// foreach ($tab_c as $c) {
// 	echo '<br/>-'.$c->getID().' '.$c->getMatiere() .'    '.$c->getSousGroupe();
// }

// echo '<br/>';
// echo '<br/>Cours g1:';
// foreach ($dao1->getCoursDate("2016-02-01 08:00:00") as $c) {
// 	echo '<br/>-'.$c->getID().' '.$c->getMatiere();
// }

// echo '<br/>-----------------------------------------------------';
// echo '<br/>Sous groupe g1:';
// foreach ($dao1->getCoursDate("2016-02-01 08:00:00") as $c) {
// 	$g = $c->getGroupe();
// 	foreach ($g as $g_) {
// 		echo '<br/>-'.$g_->getNumero();
// 		$sg = $g_->getTabSousGroupe();
// 		echo '<br/>-'.gettype($sg).'  '.count($sg);
// 	}
	
// 	// echo '<br/>-'.$sg->getNumero();
// }


// $tab = array();
// $tmp_groupe = "coucou,petite,peruche";
// $f = substr_count($tmp_groupe,',');
// for ($i=0; $i < $f; $i++) { 
// 	$tmp = explode(',', $tmp_groupe);
// 	array_push($tab, $tmp[0]);
// 	array_push($tab, $tmp[1]);
// 	$tmp = $tmp[1];
// }

// foreach($tab as $g) {
// 	echo '<br/>'.$g;
// }



// echo '// Groupes de l ics';
// $groupes = $dao->getGroupes();
// foreach ($groupes as $groupe) {
// 	echo '<br/>'.$groupe->toString();
// }
// echo '<br/> // promos de l ics';
// $promos = $dao->getPromo();
// foreach ($promos as $promo) {
// 	echo '<br/>'.$promo;
// }

// echo '<br/> // Cours a partir du 18/01/2016 8h';
// $cours = $dao->getCoursDate("2016-01-18 08:00:00");
// foreach ($cours as $c) {
// 	echo '<br/>'.$c->getDateDeb()->format('Y-m-d H:i:s');
// 	echo '        dureToInt:    ' . $c->getDureeToInt();
// }



// echo '<br/> // Groupe de promo info2';
// $groupes = $dao->getGroupePromo("info2");
// foreach ($groupes as $g) {
// 	echo $g->toString().'|';
// }

// echo '<br/> // Cours du groupe 2 du "2016-01-18 08:00:00"';
// $groupes = $dao->getCoursGroupe("2016-01-18 08:00:00","promo2g2");
// foreach ($groupes as $g) {
// 	echo $g->toString().'|';
// }

// echo '<br/> // Cours de promo 2 du "2016-01-18 08:00:00"';
// $groupes = $dao->getCoursPromo("2016-01-18 08:00:00","promo2g2");
// foreach ($groupes as $g) {
// 	echo $g->toString().'|';
// }

// $tabGroupe = array();
// $tmp_groupe = between($promo.'Groupe ', 'Salle', $String2);
			
			
			
// if (substr($tmp_groupe,0,1) == ':') { // Si c'est une Promo
// 	array_push($tabGroupe, "0");
// 	}
// else if ( strlen($tmp_groupe) > 2 ) {
// 	while ( strlen($tmp_groupe) > 2) {	// Si il ya d'autres groupes

// 		if (ctype_digit(substr($tmp_groupe, 0))) {		// dans le format: 2, Info 2 groupe 3....

// 			array_push($tabGroupe, substr($tmp_groupe, 0));

// 			$groupeTmp = between(' '.$groupeTmp.', '.$promo.'Groupe ', 'Salle', $String2);
			
// 		} else {
// 			$groupeTmp = "";
// 			array_push($tabGroupe, "Alternance");
// 		}
// 	}
		
// } else {
// 	array_push($tabGroupe, trim($tmp_groupe));
// }





?>


