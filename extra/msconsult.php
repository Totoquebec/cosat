<?php
/* Programme : MSAjout.php
* Description : Programme d'ajout d'un usager.
* Auteur : Denis L�veill� 	 		  Date : 2004-01-01
* MAJ : Denis L�veill� 	 			  Date : 2007-02-27
*/
include('connect.inc');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("msmessen.inc");
			break;
	case "SPANISH":	include("msmesssp.inc");
			break;
	default:	include("msmessfr.inc");
} // switch SLangue


$NomChamps = array(
	"Login"=>"Identification (Login)",
    	"mPasse"=>"Mot de passe",
	"Priorite"=>"Priorit� de l'usager",
	"Creation"=>"Date de cr�ation",
	"Langue"=>"Langue utilis�",
	"NoClient"=>"No du client",
	"Acces"=>"D�ja acc�der"
	);
	
function AfficherErreur($texteMsg)
{ 
include("var.inc");
include("varcie.inc");
global $NomLogin,$mPasse,$Priorite,$Creation,$Langue,$NoClient, $Acces, $TabMessSecur, $TabMessGen;
	$NewMessage = $texteMsg;
	unset($EN_AJOUT);
	$EN_CONSULTE = 1;
	include("mslstusg.php");
	exit();
}


switch( @$_POST['Commande'] ) {


	case $TabMessGen[102] : // Transaction
				$sql = " SELECT * FROM $database.secur WHERE NomLogin = '".$_POST['choix']."'";
				if( !($result = mysql_query( $sql, $handle )) || !mysql_num_rows( $result ) ) {
					$Message = mysql_errno()." Consultation USAGER ". mysql_error();
					AfficherErreur($Message);
				}			   
//						$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
//						extract($ligne);
				header( "Location: loginlst.php?NomLog=".$_POST['choix']);
				break;
	case $TabMessGen[27] : // Changer
				$sql = " SELECT * FROM $database.secur WHERE NomLogin = '".$_POST['choix']."'";
				if( !($result = mysql_query( $sql, $handle )) || !mysql_num_rows( $result ) ) {
					$Message = mysql_errno()." Consultation USAGER ". mysql_error();
					AfficherErreur($Message);
				}			   
				$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
				extract($ligne);
				unset($EN_AJOUT);
				$EN_CONSULTE = 1;
				include( "msform.inc");
				break;
	case "Modifier" : // Changer
				extract($_POST,EXTR_OVERWRITE);	
				$sql = "UPDATE $database.secur SET Langue='$Langue',Acces='$Acces' WHERE NomLogin = '$NomLogin'";
				if( !mysql_query($sql, $handle ) ) {
					$Mess ="ERREUR : ".mysql_errno()." : ".mysql_error();
					AfficherErreur( $Mess );
				}
				AfficherErreur("Modification r�ussi");
				break;
	case $TabMessGen[26]: /* detruire */ 
				if( $_POST['choix'] == 'oper' )
					AfficherErreur( "Cet usager ne peut �tre d�truit !" );
				$sql = "DELETE FROM $database.secur WHERE NomLogin = '".@$_POST['choix']."'";
				$result = mysql_query( $sql, $handle );
				if( $result == 0 ) {
					$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
					AfficherErreur( $Mess );
				} // Si pas r�ussi
				header( "Location: mslstusg.php?NewMessage='Detruit r�ussi'" );
				
				break;					
	default :	   
				$sql = " SELECT * FROM $database.secur WHERE NomLogin = '".$_SESSION['NomLogin']."'";
				if( !($result = mysql_query( $sql, $handle )) || !mysql_num_rows( $result ) ) {
					$Message = mysql_errno()." Consultation USAGER ". mysql_error();
					AfficherErreur($Message);
				}			   
				$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
				extract($ligne);
				unset($EN_AJOUT);
				$EN_CONSULTE = 1;
				include( "msform.inc");
   		  		break;
}

?>

