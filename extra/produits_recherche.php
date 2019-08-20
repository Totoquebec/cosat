<?php
/* Programme : Rechercheproduits.php
* Description : Programme de recherche de produits.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
*/
// Début de la session
include('../lib/config.php');

// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("produits_messen.inc");
			break;
	default:	include("produits_messfr.inc");

} // switch SLangue


include("produits_champs.inc");

function AfficherErreur($texteMsg)
{ 
include("produits_global.inc" );

	$NewMessage = $texteMsg;
	unset($EN_AJOUT);
	unset($EN_CONSULTE);
	$EN_RECHERCHE = 1;
	include("produits_form.inc");
	exit();
} // Affiche Erreur


switch( @$_GET['do'] ) {
	case "rech"	: 
			include( "produits_sql.inc");
	//				AfficherErreur( $sql );
			if( $Ok ) { 
				extract($_POST,EXTR_OVERWRITE);			   
				
				$result = $mabd->query($sql);
				if( !$result ) 
					AfficherErreur( $TabMessGen[154].mysql_errno().": ".mysql_error() );
				elseif (  $result->num_rows == 0 ) {
					AfficherErreur( $TabMessGen[42].' '.$sql );
				}
				else {
					if( $result->num_rows > 1 ) {
						header( "Location: produits_lstframe.php?sql=$sql&target=MAIN");
						break;
					}	
					$ligne = $result->fetch_assoc();
					extract($ligne);
					
					unset($EN_AJOUT);
					unset($EN_RECHERCHE);
					$EN_CONSULTE = 1;
					include( "produits_form.inc");
				}
				break;
			} // Si une requête
			else
				AfficherErreur( "Requête INVALIDE. Corrigez S.V.P.");
			break;
   case "trouve": if( isset( $_GET['choix'] ) ) {
                     	$sql = " SELECT * FROM $mysql_base.stock WHERE id = '".$_GET['choix']."'";

			$result = $mabd->query($sql);
			if( !$result ) {
				$Mess = $TabMessGen[34].mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			}
			elseif (  $result->num_rows == 0 ) {
				AfficherErreur( $TabMessGen[41] );
			}
			else {
				$ligne = $result->fetch_assoc();
				extract($ligne);
				$prix_detail = sprintf("%8.2f$",$prix_detail);
				$prix_promo = sprintf("%8.2f$",$prix_promo);
			
			}
			unset($EN_AJOUT);
			unset($EN_RECHERCHE);
			$EN_CONSULTE = 1;
	
			include( "produits_form.inc");
	             	break;
                  }
   case "fouille": 
			include( "produits_sql.inc");
	//				AfficherErreur( $sql );
	
			if( $Ok ) { 
				$result = $mabd->query($sql);
				if( !$result ) 
					$NewMessage = $TabMessGen[154].mysql_errno().":= ".mysql_error();
				elseif(  $result->num_rows == 0 ) {
					$NewMessage = $TabMessGen[42];
				}
				else 
					header( "Location: produits_lstframe.php?sql=$sql&target=_blank");
			} // Si une requête
			else
				$NewMessage = "Requête INVALIDE. Corrigez S.V.P.";
			extract($_POST,EXTR_OVERWRITE);			   
  		  	unset($EN_AJOUT);
         		unset($EN_CONSULTE);
         		$EN_RECHERCHE = 1;
	  		include( "produits_form.inc");
			break;
   case "list": 
	               	$EN_LIST = 1;
	default :
			$id = $titre_fr = $titre_en = $titre_sp = $prix_detail = $prix_promo = $Douane =
			$Code = $Cout = $Markup = $QteStock = $QteVendu = $QteCmd = $QteBO = $QteDOA = $Provenance = $Unité= 
			$weight = $width = $height = $description_fr = $description_en = $description_sp = 
			$description_supplementaire_fr = $description_supplementaire_en =
			$description_supplementaire_sp = $small = $medium = $big = $online = "";
			$Secteur_Limite = $Qte_Max_Livre = "";
			unset($EN_AJOUT);
	               	unset($EN_CONSULTE);
	               	$EN_RECHERCHE = 1;
	   		include( "produits_form.inc");
	   		break;
} // switch

?>

