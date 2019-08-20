<?php
/* Programme : MSChangPass.php
* Description : Programme pour changer le password d'un usager.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
*/
include('connect.inc');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("msmessen.inc");
			break;
	case "FRENCH":	include("msmessfr.inc");
			break;
	default:	include("msmesssp.inc");
} // switch SLangue

	
function AfficherErreur($texteMsg)
{ 
global $do,$NewmPass1,$NewmPass2,$LaLangue, $Nom, $Prenom, $SLangue, $TabMessGen, $TabMessSecur;
include("var.inc");
include("varcie.inc");

	$NewMessage = $texteMsg;
	unset($do);
	$EN_AJOUT = 1;
	include("mspassform.inc");
	exit();
}


switch( @$_GET['do'] ) {
   case "ok"	: 	extract($_POST,EXTR_OVERWRITE);
			if( strlen( $NewmPass1 ) < 5 )
				AfficherErreur( $TabMessSecur[25] );
			if( strcmp($NewmPass1,$NewmPass2) )
				AfficherErreur( $TabMessSecur[26] );
			if( !ereg ("[0-9A-Za-z' ÉÈËÀÂÎÏÔÙÜÁÃÅÆÌÍÕÓÒÑçÇéèêëàâîïôùüáãåæìíðñòóõ-]{1,20}$", $NewmPass1 ) )
				AfficherErreur( $TabMessSecur[24] );
			if( !strcmp($NewmPass1,$PassCourant) )
				AfficherErreur( $TabMessSecur[27] );
			$Aujourdhui = date("Y-m-d");
			$md5pass = md5($mPasse);
			$sql =  "UPDATE $database.secur SET mPasse=$md5pass, Langue='$LaLangue',";
			$sql .= " Creation='$Aujourdhui', Acces='OUI' WHERE NomLogin = '".$_SESSION['NomLogin']."'";
			//	  									AfficherErreur( $sql );
			$result = mysql_query( $sql, $handle );
			if( $result == 0 ) {
				$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			}
			header( "Location: login.php");
	  		break;				  		  				  		 
	default :
			$sql = " SELECT * FROM $database.secur WHERE NomLogin = '".$_SESSION['NomLogin']."'";
			$result = mysql_query( $sql, $handle );
			if( ($result != 0) && (mysql_num_rows($result) != 0)  ){
				$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
				extract($ligne);
				$PassCourant = $mPasse;
				$Prenom = "";
				$Nom = $_SESSION['NomLogin'];
			/*            			 $sql = " SELECT Nom, Prenom FROM client WHERE NoClient = '".$_SESSION['NoContact']."'";
			if( $result != 0 )
			if( mysql_num_rows($result) != 0 ) {
			$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
			extract($ligne);
			}*/
				$NewmPass1 = "";
				$NewmPass2 = "";
				$LaLangue = $_SESSION['SLangue'];
				$EN_AJOUT = 1;
				include( "mspassform.inc");
			}
			else
				header( "Location: login.php");
	  		break;
}

?>

