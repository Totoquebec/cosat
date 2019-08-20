<?php
/* Programme : ConsulteClient.php
* Description : Programme de consultation de client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 		  	  Date : 2007-01-30
*/
include('connect.inc');
// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("cat_messen.inc");
			break;
	case "SPANISH":	include("cat_messsp.inc");
			break;
	default:	include("cat_messfr.inc");

} // switch SLangue


function AfficherErreur($texteMsg)
{ 
global $TabId,$TabMessGen, $id, $parent, $TitParent, $ordre, $fr, $en, $sp, $Markup, $online, $handle;

	$NewMessage = $texteMsg;
	unset($EN_AJOUT);
	unset($EN_RECHERCHE);
   $EN_CONSULTE = 1;
	include("catalogue_form.inc");
	exit();
} // Affiche Erreur

switch( @$_GET['do'] ) {
  case "Modif": 	 // ***** Modifier ***** 
						extract($_POST,EXTR_OVERWRITE);	 
						$sql =  "UPDATE $mysql_base.catalogue SET parent='$parent', ordre='$ordre', fr='$fr',"; 
						$sql .=  " en='$en', sp='$sp', Markup='$Markup', online='$online' WHERE id = '$id'";
						//AfficherErreur( $sql );
						$result = mysql_query( $sql, $handle);
						if( !$result ) {
							$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
							AfficherErreur( $Mess );
						}
						$aujourdhui = date("Y-m-d H:i:s");
						$Mess = "Modification du catalogue $id";
  						Suivi_log($Mess, $id);
						
		    			$sql = "SELECT ".$_SESSION['langue']." FROM $mysql_base.catalogue WHERE id = $parent;";
						$result = mysql_query( $sql, $handle );
						if( $result && mysql_num_rows($result) ) {
							$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
							$TitParent = $ligne[$_SESSION['langue']];
						}
						unset($EN_AJOUT);
						unset($EN_RECHERCHE );
						$EN_CONSULTE = 1;
						include("catalogue_form.inc");
						break;
  case "detruit"  :
						$sql = "DELETE FROM $mysql_base.catalogue WHERE id = '".@$_GET['id']."'";
						$result = mysql_query( $sql, $handle);
						if( !$result ) {
							$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
							AfficherErreur( $Mess );
						} // Si pas réussi
						$aujourdhui = date("Y-m-d h:i:s");
						$Message = "Destruction du catalogue ".@$_GET['id'];
						$sql = "INSERT INTO login ( NomLogin, DateLogin, Operation )
						VALUES ('".$_SESSION['NomLogin']."','$aujourdhui', '$Message')";
						$result = mysql_query( $sql );
						if( !$result ) {
							$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
							AfficherErreur( $Mess );
						} // Si pas réussi
						header( "Location: catalogue_recherche.php");
						break;
					
  default :  	   	
						unset($EN_AJOUT);
                	unset($EN_RECHERCHE );
                 	$EN_CONSULTE = 1;
						include("catalogue_form.inc");
		   		   break;
}

?>

