<?php
/* Programme : MainFr.php
* Description : Ecran d'ouverture du système de gestion
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-14
*/
include("var_extra.inc");

// l'usager est-il autorisé
if( @$_SESSION['auth'] != "yes") {
	$script = "<script language=javascript>";
	$script .= "	window.alert(\"Session EXPIRÉE\"); ";
	$script .= "	close(); ";
	$script .= "</script>\n";
	echo $script;
	exit();
}

include("varcie.inc");
// **** Choix de la langue de travail ****
 switch( @$_SESSION['SLangue'] ) {
 		 case "ENGLISH" : 
 		 	  			  include("varmessen.inc");
		 		 	  	  break;
		 case "SPANISH" : 
 		 	  			  include("varmesssp.inc");
		 	  			  break;
		 default : 		  
 		 	  			  include("varmessfr.inc");

 } // switch SLangue
 ListUsager(); 
 
?>
