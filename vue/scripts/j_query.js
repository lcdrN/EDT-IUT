$(document).ready( function() {
    
    $(".td").css("backgroundColor", $.cookie("TD"));
	$("tg-y0wm").css("backgroundColor", $.cookie("TP"));
	$("amphi").css("backgroundColor", $.cookie("Amphi"));
	$("ds").css("backgroundColor", $.cookie("DS"));
    $("tg-4wtr").css("backgroundColor", $.cookie("Projet"));
    
    
   $("#color").click( function() {
       
      $.cookie('TD', $("#couleurTD").val() , { expires: 60 });
      $.cookie('TP', $("#couleurTP").val() , { expires: 60 });
      $.cookie('Amphi', $("#couleurAmphi").val() , { expires: 60 });
      $.cookie('DS', $("#couleurDS").val() , { expires: 60 });
      $.cookie('Projet', $("#couleurProjet").val() , { expires: 60 });
     
   });
   

   
   
   
   

   
   
   
   
/*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
   if ( $.cookie("prof") == "checked" ) {
       $(".prof_print").css("display","block");
   } else {
       $(".prof_print").css("display","none");
   }
   

   $("#affprof").click( function() {
       
      if (  $.cookie('prof') == "checked" ) {
           $.cookie('prof', "uncheck", { expires: 60 });
           $(".prof_print").css("display","none");
       } else {
           $.cookie('prof', "checked", { expires: 60 });
           $(".prof_print").css("display","block");
       }
   });
   
/*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
   if ( $.cookie("salle") == "checked" ) {
       $(".salle_print").css("display","block");
   } else {
       $(".salle_print").css("display","none");
   }
   
   $("#affsalle").click( function() {
       
      if (  $.cookie('salle') == "checked" ) {
           $.cookie('salle', "uncheck", { expires: 60 });
            $(".salle_print").css("display","none");
       } else {
           $.cookie('salle', "checked", { expires: 60 });
           $(".salle_print").css("display","block");
       }
   });
  /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    if ( $.cookie("matiere") == "checked" ) {
       $(".nom_matiere_print").css("display","block");
   } else {
       $(".nom_matiere_print").css("display","none");
   }
   
   $("#affmatiere").click( function() {
       
      if (  $.cookie('matiere') == "checked" ) {
           $.cookie('matiere', "uncheck", { expires: 60 });
           $(".nom_matiere_print").css("display","none");
       } else {
           $.cookie('matiere', "checked", { expires: 60 });
           $(".nom_matiere_print").css("display","block");
       }
   });
/*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
   if ( $.cookie("heure") == "checked" ) {
       $(".heure_print").css("display","block");
   } else {
       $(".heure_print").css("display","none");
   }
   
   $("#affheure").click( function() {
       
      if (  $.cookie('heure') == "checked" ) {
           $.cookie('heure', "uncheck", { expires: 60 });
           $(".heure_print").css("display","none");
       } else {
           $.cookie('heure', "checked", { expires: 60 });
           $(".heure_print").css("display","block");
       }
   });
/*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    if ( $.cookie("type") == "checked" ) {
       $(".type_print").css("display","block");
   } else {
       $(".type_print").css("display","none");
   }
   
   $("#afftype").click( function() {
       
      if (  $.cookie('type') == "checked" ) {
           $.cookie('type', "uncheck", { expires: 60 });
           $(".type_print").css("display","none");
       } else {
           $.cookie('type', "checked", { expires: 60 });
           $(".type_print").css("display","block");
       }
   });
 /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    if ( $.cookie("groupe") == "checked" ) {
       $(".groupe_print").css("display","block");
   } else {
       $(".groupe_print").css("display","none");
   }
   
   $("#affgroupe").click( function() {
       
      if (  $("#affgroupe").prop("checked")  ) {
           $.cookie('groupe', "uncheck", { expires: 60 });
        //   $(".groupe_print").css("display","none");
       } else {
           $.cookie('groupe', "checked", { expires: 60 });
        //   $(".groupe_print").css("display","block");
       }
       console.log("cookie:"+$.cookie('groupe'));
   });
    
});