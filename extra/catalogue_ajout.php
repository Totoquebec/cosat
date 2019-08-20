<?php
/* Programme : AjoutClient.php
* Description : Programme d'ajout de client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
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
	unset($EN_CONSULTE);
	unset($EN_RECHERCHE);
	$EN_AJOUT = 1;
	include("catalogue_form.inc");
	exit();
} // Affiche Erreur

switch( @$_GET['do'] ) {
   case "new"	:	extract($_POST,EXTR_OVERWRITE);	 
			$sql =  "INSERT INTO $mysql_base.catalogue SET parent='$parent', ordre='$ordre', fr='$fr', en='$en', sp='$sp',"; 
			$sql .=  "Markup='$Markup', online='$online';";
//						AfficherErreur( $sql );
			if( !mysql_query($sql, $handle) ) {
			   $Mess = "ERREUR Catalogue ".mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			}
			$NoId = mysql_insert_id( $handle);
			include( "catalogue_ok.inc");
 	  		break;	
	default :	$id = $TitParent = $fr = $en = $sp = "";
			$parent = 0;
			$ordre = 1;
			$Markup = 1.00;
			$online = 1;
			unset($EN_CONSULTE);
			unset($EN_RECHERCHE);
			$EN_AJOUT = 1;
	  		include( "catalogue_form.inc");
	  		break;
}

?>
                                                                    
