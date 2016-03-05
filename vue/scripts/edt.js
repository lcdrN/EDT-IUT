function init()
{
	var police = 12;
	document.getElementById('police').addEventListener("click",policePlus)
	document.getElementById('police-').addEventListener("click",policeMoins)


	var Prof = document.getElementById("affprof");
	var Salle = document.getElementById("affsalle");
	var Matiere = document.getElementById("affmatiere");
	var Groupe = document.getElementById("affgroupe");
	var Heure = document.getElementById("affheure");
	var Type = document.getElementById("afftype");

	var salles = document.getElementsByClassName("salle_print");
	var nom_matiere = document.getElementsByClassName("nom_matiere_print");
	var enseignants = document.getElementsByClassName("prof_print");
	var groupes = document.getElementsByClassName("groupe_print");
	var heures = document.getElementsByClassName("heure_print");
	var types = document.getElementsByClassName("type_print");

	var tableEdt = document.getElementsByClassName("tg_print");


/*	var boolP= ( $.cookie("prof") == "checked");
	var boolS= ( $.cookie("salle") == "checked");
	var boolM= ( $.cookie("matiere") == "checked");
	var boolG= ( $.cookie("groupe") == "checked");
	var boolH= ( $.cookie("heure") == "checked");
	var boolT= ( $.cookie("type") == "checked");*/

	var boolAperçu = false;

	var boutonPrevu = document.getElementById("prevu");
	var divPrevu = document.getElementById("div_prevu");
	var tableEdt = document.getElementById("tableEdt");
	var fieldset = document.getElementById("fieldset");

	var boutonColor = document.getElementById("color");
	var couleurTD = document.getElementById("couleurTD");
	var couleurTP = document.getElementById("couleurTP");
	var couleurAmphi = document.getElementById("couleurAmphi");
	var couleurProjet = document.getElementById("couleurProjet");
	var couleurDS = document.getElementById("couleurDS");

	var TD = document.getElementsByClassName("td");
	var TP = document.getElementsByClassName("tg-y0wm");
	var Amphi = document.getElementsByClassName("amphi");
	var Projet = document.getElementsByClassName("tg-4wtr");
	var DS = document.getElementsByClassName("ds");



	/*Prof.addEventListener("click", cacherEns);
	function cacherEns()
	{

		if(boolP == true)
		{
			for (var i = 0; i < enseignants.length; i++)
				{					
					enseignants[i].style.display="none";
				};
			boolP=false;
		}
		else
		{
			for (var i = 0; i < enseignants.length; i++)
				{
					enseignants[i].style.display="block";
	
					
				};
			boolP=true;
		}		
	}

	Salle.addEventListener("click", cacherSalle);
	function cacherSalle()
	{

		if(boolS == true)
		{
			for (var i = 0; i < salles.length; i++)
				{
					salles[i].style.display="none";
				};
			boolS=false;
		}
		else
		{
			for (var i = 0; i < salles.length; i++)
				{
					salles[i].style.display="block";
				};
			boolS=true;
		}		
	}

	Matiere.addEventListener("click", cacherMatiere);
	function cacherMatiere()
	{

		if(boolM == true)
		{
			for (var i = 0; i < nom_matiere.length; i++)
				{
					nom_matiere[i].style.display="none";
				};
			boolM=false;
		}
		else
		{
			for (var i = 0; i < nom_matiere.length; i++)
				{
					nom_matiere[i].style.display="block";
				};
			boolM=true;
		}		
	}

	Heure.addEventListener("click", cacherHeure);
	function cacherHeure()
	{

		if(boolH == true)
		{
			for (var i = 0; i < heures.length; i++)
				{
					heures[i].style.display="none";
				};
			boolH=false;
		}
		else
		{
			for (var i = 0; i < heures.length; i++)
				{
					heures[i].style.display="block";
				};
			boolH=true;
		}		
	}

	Groupe.addEventListener("click", cacherGroupe);
	function cacherGroupe()
	{

		if(boolG == true)
		{
			for (var i = 0; i < groupes.length; i++)
				{
					groupes[i].style.display="none";
				};
			boolG=false;
		}
		else
		{
			for (var i = 0; i < groupes.length; i++)
				{
					groupes[i].style.display="block";
				};
			boolG=true;
		}		
	}

	Type.addEventListener("click", cacherType);
	function cacherType()
	{

		if(boolT == true)
		{
			for (var i = 0; i < types.length; i++)
				{
					types[i].style.display="none";
				};
			boolT=false;
		}
		else
		{
			for (var i = 0; i < types.length; i++)
				{
					types[i].style.display="block";
				};
			boolT=true;
		}		
	}*/

	boutonPrevu.addEventListener("click", popup);
	function popup()
	{
		if (boolAperçu)
		{
			divPrevu.style.visibility = "hidden";
			boutonPrevu.style.backgroundColor = "#71AFD9";
			boutonPrevu.blur();
			tableEdt.style.display ="block";
			fieldset.style.display = "none";
			tableEdt.style.height="auto";
			boolAperçu = false;

			
		}
		else
		{
			divPrevu.style.visibility = "visible";
			divPrevu.style.height="auto";
			document.getElementById("prevu").style.backgroundColor = "#91C0DF";
			boutonPrevu.blur();
			fieldset.style.display = "block";
			tableEdt.style.display ="none";
			boolAperçu = true;
		};
	}

	function policePlus()
	{
		police = police +1;
		// hauteur = hauteur +5;
		for (var i = 0 ; i < salles.length; i++)
		{

			salles[i].style.fontSize =  police+"px";
			nom_matiere[i].style.fontSize =  police+"px";
			enseignants[i].style.fontSize =  police+"px";
			groupes[i].style.fontSize =  police+"px";
			heures[i].style.fontSize =  police+"px";
			types[i].style.fontSize =  police+"px";
		};
	}

	function policeMoins()
	{
		police = police -1;
		for (var i = 0 ; i < salles.length; i++) {
			salles[i].style.fontSize =  police+"px";
			nom_matiere[i].style.fontSize =  police+"px";
			enseignants[i].style.fontSize =  police+"px";
			groupes[i].style.fontSize =  police+"px";
			heures[i].style.fontSize =  police+"px";
			types[i].style.fontSize =  police+"px";
			// tableEdt[i].style.fontSize =  salles.style.fontSize + 1;
		
		};
	}

	boutonColor.addEventListener("click", changerCouleur);
	function changerCouleur()
	{
		for (var i = 0; i < TD.length; i++) {
			TD[i].style.backgroundColor = couleurTD.value;
		};
		

		for (var i = 0; i < TP.length; i++) {
			TP[i].style.backgroundColor = couleurTP.value;
		};

		for (var i = 0; i < Amphi.length; i++) {
			Amphi[i].style.backgroundColor = couleurAmphi.value;
		};

		for (var i = 0; i < DS.length; i++) {
			DS[i].style.backgroundColor = couleurDS.value;
		};

		for (var i = 0; i < Projet.length; i++) {
			Projet[i].style.backgroundColor = couleurProjet.value;
		};
	}
}

