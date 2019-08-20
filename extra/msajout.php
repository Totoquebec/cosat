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

// Es-ce que l'usager � la priorit� pour acc�der cette fonction
if( @$_SESSION['Prio'] > $PrioModif ){
   		header( "Location: mainfr.php?Mess='Acc�s Interdit !'");
   		exit();

} // Si pas access autoris�

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
//include("var.inc");
include("varcie.inc");
global $NomLogin,$mPasse,$Priorite,$Creation,$Langue,$NoClient, $Acces, $TabMessSecur, $TabMessGen;
	$NewMessage = $texteMsg;
	$EN_AJOUT = 1;
	include("msform.inc");
	exit();
}


switch( @$_GET['do'] ) {
	case "new":	extract($_POST,EXTR_OVERWRITE);	
			foreach($_POST as $cl� => $valeur ) {
				switch( $cl� ){
      				  case "Login" : if( !strlen( $valeur ) ||
							!preg_match("/[0-9A-Za-z�����������]{1,20}$/",
							stripslashes( $valeur ) ) ) {
							AfficherErreur( "{$NomChamps[$cl�]} incorrecte ou absente");
						}
                        			break;
      				  case "mPasse":if( !preg_match("/[0-9A-Za-z' �����������-]{1,20}$/",
							stripslashes( $valeur ) ) ) {
							AfficherErreur( "{$NomChamps[$cl�]} incorrecte ou absente. Corrigez S.V.P.");
						}
                        			break;
      				  case "Montant":if( !preg_match("/[0-9]{1,2}/", $valeur ) ||
      			     				($valeur < $Prio ) ){
                          					AfficherErreur( "{$NomChamps[$cl�]} incorrect ou absent. Corrigez S.V.P.");
      						 } // if Montant
      				  default :	 break;
					
				} //switch
			} // for each
			
				$sql = "SELECT * FROM $database.secur WHERE NomLogin='$NomLogin'";
				$result = mysql_query( $sql, $handle )
					or die("Impossible d'ex�cuter la requ�te");
				
				$num = mysql_num_rows( $result );
				if( $num > 0 ) {	// Le nom de login est trouv�
					AfficherErreur( "$Login est d�j� utilis�. Choisissez un autre identificateur");
				}
				else{
					$Creation = date("Y-m-d");
					$Noclient = 0;
					$md5pass = md5($mPasse);
					$sql = "INSERT INTO $database.secur ( NomLogin, mPasse, Priorite, Creation, Langue, NoClient )";
					$sql .= " VALUES('$NomLogin', '$md5pass', '$Priorite', '$Creation', '$Langue', '$NoClient')";                  
				
					if( !mysql_query($sql, $handle ) ) {
						$Mess ="ERREUR : ".mysql_errno()." : ".mysql_error();
						AfficherErreur( $Mess );
					}
					$NewMessage = "Ajout r�ussi";
				}
				
	default :
				$NomLogin = "";
				$mPasse = "";
				$Priorite = 10;
				$Creation = date("Y-m-d");
				$Langue = "FRAN�AIS";
				$NoClient = 0;        	  	  
				$EN_AJOUT = 1;
				include( "msform.inc");
				break;
}

?>

