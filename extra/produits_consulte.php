<?php
/* Programme : ConsulteClient.php
* Description : Programme de consultation de client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 		  	  Date : 2007-01-30
*/
// Début de la session
include('connect.inc');

// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("produits_messen.inc");
							break;
	case "FRENCH":		include("produits_messfr.inc");
							break;
	default:				include("produits_messsp.inc");

} // switch SLangue

include("produits_champs.inc");

function AfficherErreur($texteMsg)
{ 
include("var_extra.inc");
include("varcie.inc");
include("produits_global.inc" );
         
	$NewMessage = $texteMsg;
	unset($EN_AJOUT);
	unset($EN_RECHERCHE);
   $EN_CONSULTE = 1;
	include("produits_form.inc");
	exit();
}

/*	foreach($_POST as $clé => $valeur ) 
		echo $clé." : ".$valeur."<br>";
exit;*/

switch( @$_GET['do'] ) {
  case "detruit"  : 
			$sql = "DELETE FROM $mysql_base.stock WHERE id = ".$_GET['NoId'];
			$result = mysql_query( $sql, $handle );
			if( $result == 0 )
				AfficherErreur( $TabMessGen[34].mysql_errno().": ".mysql_error() );
			header( "Location: produits_recherche.php");
			break;
					
  case "consulte":  
  	   		switch( @$_POST['Commande'] ) {
                       		case "$TabId[41]" : // ***** Modifier ***** 
                       					update_stock( $_POST );
							extract($_POST,EXTR_OVERWRITE);	 
                       					header( "Location: produits_recherche.php?do=trouve&choix=$id");
							extract($_POST,EXTR_OVERWRITE);	
							exit(); 
	                                 		break;
                       		default : 		extract($_POST,EXTR_OVERWRITE);
					   		header( "Location: produits_recherche.php");
                        		 		break;
   		   	}
                   	
  default :  	   	unset($EN_AJOUT);
                   	unset($EN_RECHERCHE );
                    	$EN_CONSULTE = 1;
   		   	include("produits_form.inc");
   		   	break;
}

?>

