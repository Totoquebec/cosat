<?php
/* Programme : ConsulteClient.php
* Description : Programme de consultation de client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 		  	  Date : 2007-01-30
*/
include('var_extra.inc');
include('connect.inc');
// l'usager est-il autorisé
if( $_SESSION['auth'] != "yes") {
   	header( "Location: login.php");
   	exit();
}

include("varcie.inc");
// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("varmessen.inc");
							break;
	case "SPANISH":	include("varmesssp.inc");
							break;
	default:				include("varmessfr.inc");

} // switch SLangue

function AfficherErreur($texteMsg)
{ 
include("var_extra.inc");
include("varcie.inc");
global $TabMessGen;
         
	$NewMessage = $texteMsg;
   $sql = "SELECT * FROM $mysql_base.produits_accueil;";

	$result = mysql_query( $sql, $handle );
   if( $result == 0 ) {
      $Mess = $TabMessGen[34].mysql_errno()." lire : ".mysql_error();
      AfficherErreur( $Mess );
   }
   elseif (  mysql_num_rows($result) == 0 ) {
      AfficherErreur( $TabMessGen[41] );
   }
	unset($EN_AJOUT);
	unset($EN_RECHERCHE);
   $EN_CONSULTE = 1;
	include("speciaux_form.inc");
	exit();
}

switch( @$_GET['do'] ) {
					
	case "Modif" : // ***** Modifier ***** 
						extract($_POST,EXTR_OVERWRITE);	 
						for( $i=1; $i<=$NbTrans; $i++ ) {
							// Liste des transactions choisi
							if( isset($Prod[$i]) ) {
								$sql =  "UPDATE $mysql_base.produits_accueil SET id_produit='$Prod[$i]'";  
								$sql .=  " WHERE id = '$Id[$i]'"; 							
//												AfficherErreur( $sql );
								$result = mysql_query( $sql, $handle );
								if( $result == 0 ) {
									$Mess = $TabMessGen[34].mysql_errno()." maj : ".mysql_error();
									AfficherErreur( $Mess );
								}
							} // Si exist
						} // fo nb
  default :  	   $sql = "SELECT * FROM $mysql_base.produits_accueil;";
	
						$result = mysql_query( $sql, $handle );
	               if( $result == 0 ) {
	                  $Mess = $TabMessGen[34].mysql_errno()." lire : ".mysql_error();
	                  AfficherErreur( $Mess );
	               }
	               elseif (  mysql_num_rows($result) == 0 ) {
	                  AfficherErreur( $TabMessGen[41] );
	               }
  						unset($EN_AJOUT);
                  unset($EN_RECHERCHE );
                  $EN_CONSULTE = 1;
   		   		include("speciaux_form.inc");
   		   		break;
}

?>

