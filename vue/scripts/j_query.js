$(document).ready( function() {
    
    $(".td").css("backgroundColor", $.cookie("TD"));
	$(".tg-y0wm").css("backgroundColor", $.cookie("TP"));
	$(".ds").css("backgroundColor", $.cookie("DS"));
    $(".tg-4wtr").css("backgroundColor", $.cookie("Projet"));
    $("td.amphi").css("backgroundColor", $.cookie("Amphi"));
    
   $("#color").click( function() {
       
      $.cookie('TD', $("#couleurTD").val() , { expires: 60 });
      $.cookie('TP', $("#couleurTP").val() , { expires: 60 });
      $.cookie('Amphi', $("#couleurAmphi").val() , { expires: 60 });
      $.cookie('DS', $("#couleurDS").val() , { expires: 60 });
      $.cookie('Projet', $("#couleurProjet").val() , { expires: 60 });
     
   });
   
    $("#prevu").click( function() {
      console.log("cookie prof:"+$.cookie("prof"));
      console.log("cookie salle:"+$.cookie("salle"));
      console.log("cookie heure:"+$.cookie("heure"));
      console.log("cookie matiere:"+$.cookie("matiere"));
      console.log("cookie groupe:"+$.cookie("groupe"));
      console.log("cookie type:"+$.cookie("type"));
      console.log("cookie police:"+$.cookie("police"));

      console.log($("#couleur").css("top"));
      if ( $("#couleur").css("top") < $("#option").css("height") ) {
        $("#couleur").animate({top:"40%"});
      } else {
        $("#couleur").animate({top:"20%"});
      }
      
    });


    

   

   
   
   
   
/*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
   if ( $.cookie("prof") == "checked" ) {
       $(".prof_print").css("display","block");
   } else {
       $(".prof_print").css("display","none");
   }
   

   $("#affprof").click( function() {
       
      if (  $.cookie('prof') == "checked" ) {
           $.cookie('prof', "", { expires: 60 });
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
           $.cookie('salle', "", { expires: 60 });
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
           $.cookie('matiere', "", { expires: 60 });
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
           $.cookie('heure', "", { expires: 60 });
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
           $.cookie('type', "", { expires: 60 });
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
       
      if (  $.cookie('groupe') == "checked"  ) {
           $.cookie('groupe', "", { expires: 60 });
          $(".groupe_print").css("display","none");
       } else {
           $.cookie('groupe', "checked", { expires: 60 });
          $(".groupe_print").css("display","block");
       }
       
   });
   
   /*  *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */
    $(".prof_print").css("font-size", $.cookie("police")+"px");
    $(".salle_print").css("font-size", $.cookie("police")+"px");
    $(".nom_matiere_print").css("font-size", $.cookie("police")+"px");
    $(".heure_print").css("font-size", $.cookie("police")+"px");
    $(".type_print").css("font-size", $.cookie("police")+"px");
    $(".groupe_print").css("font-size", $.cookie("police")+"px");
    
    $("#police-").click( function() {
        var police = parseInt($.cookie("police")) - 1;
        $.cookie("police", police.toString(), { expires: 60 });
       
        $(".prof_print").css("font-size", $.cookie("police")+"px");
        $(".salle_print").css("font-size", $.cookie("police")+"px");
        $(".nom_matiere_print").css("font-size", $.cookie("police")+"px");
        $(".heure_print").css("font-size", $.cookie("police")+"px");
        $(".type_print").css("font-size", $.cookie("police")+"px");
        $(".groupe_print").css("font-size", $.cookie("police")+"px");
   });
   
   $("#police").click( function() {
        var police = parseInt($.cookie("police")) + 1;
        $.cookie("police", police.toString(), { expires: 60 });
       
        $(".prof_print").css("font-size", $.cookie("police")+"px");
        $(".salle_print").css("font-size", $.cookie("police")+"px");
        $(".nom_matiere_print").css("font-size", $.cookie("police")+"px");
        $(".heure_print").css("font-size", $.cookie("police")+"px");
        $(".type_print").css("font-size", $.cookie("police")+"px");
        $(".groupe_print").css("font-size", $.cookie("police")+"px");
   });
    
});


