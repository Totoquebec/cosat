<?php
/* Programme : AjoutClient.php
* Description : Programme d'ajout de client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
*/
include('connect.inc');

// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("produits_messen.inc");
							break;
	case "FRENCH":		include("produits_messfr.inc");
							break;
	default:				include("produits_messsp.inc");

} // switch SLangue

function AfficherErreur($texteMsg)
{ 
include("var_extra.inc");
include("varcie.inc");
include("produits_global.inc" );
	$NewMessage = $texteMsg;
	unset($EN_RECHERCHE);
	unset($EN_CONSULTE);
	$EN_AJOUT = 1;
	include( "produits_form.inc");
	exit();
}


switch( @$_GET['do'] ) {
   case "new"	: // ***** Ajouter *****
   		  $NoId = insert_stock( $_POST );
   		  if( !$NoId ) {
   		  	extract($_POST,EXTR_OVERWRITE); 
   		  	AfficherErreur("Ajout Invalide");
   		  }
		  include( "produits_ok.inc");
		  break;	
	default:						
		$id = $titre_fr = $titre_en = $titre_sp = $prix_detail = $prix_promo = $Douane =
		$Code = $Cout = $Markup = $QteStock = $QteVendu = $QteCmd = $QteBO = $QteDOA = $Unité = 
		$weight = $width = $height = $description_fr = $description_en = $description_sp = 
		$description_supplementaire_fr = $description_supplementaire_en =
		$description_supplementaire_sp = $Secteur_Limite = "";
		$small = $medium = $big =  1;
		$Qte_Max_Livre = 12;
		$online = 1;
		$Provenance = 2;
		unset($EN_RECHERCHE);
		unset($EN_CONSULTE);
		$EN_AJOUT = 1;
		include( "produits_form.inc");
		break;
}

?>
                                                                    
