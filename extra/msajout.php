<?php
/* Programme : MSAjout.php
* Description : Programme d'ajout d'un usager.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
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

// Es-ce que l'usager à la priorité pour accéder cette fonction
if( @$_SESSION['Prio'] > $PrioModif ){
   		header( "Location: mainfr.php?Mess='Accès Interdit !'");
   		exit();

} // Si pas access autorisé

$NomChamps = array(
	"Login"=>"Identification (Login)",
    	"mPasse"=>"Mot de passe",
	"Priorite"=>"Priorité de l'usager",
	"Creation"=>"Date de création",
	"Langue"=>"Langue utilisé",
	"NoClient"=>"No du client",
	"Acces"=>"Déja accéder"
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
			foreach($_POST as $clé => $valeur ) {
				switch( $clé ){
      				  case "Login" : if( !strlen( $valeur ) ||
							!preg_match("/[0-9A-Za-zéèêëàâîïôùü]{1,20}$/",
							stripslashes( $valeur ) ) ) {
							AfficherErreur( "{$NomChamps[$clé]} incorrecte ou absente");
						}
                        			break;
      				  case "mPasse":if( !preg_match("/[0-9A-Za-z' éèêëàâîïôùü-]{1,20}$/",
							stripslashes( $valeur ) ) ) {
							AfficherErreur( "{$NomChamps[$clé]} incorrecte ou absente. Corrigez S.V.P.");
						}
                        			break;
      				  case "Montant":if( !preg_match("/[0-9]{1,2}/", $valeur ) ||
      			     				($valeur < $Prio ) ){
                          					AfficherErreur( "{$NomChamps[$clé]} incorrect ou absent. Corrigez S.V.P.");
      						 } // if Montant
      				  default :	 break;
					
				} //switch
			} // for each
			
				$sql = "SELECT * FROM $database.secur WHERE NomLogin='$NomLogin'";
				$result = mysql_query( $sql, $handle )
					or die("Impossible d'exécuter la requête");
				
				$num = mysql_num_rows( $result );
				if( $num > 0 ) {	// Le nom de login est trouvé
					AfficherErreur( "$Login est déjà utilisé. Choisissez un autre identificateur");
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
					$NewMessage = "Ajout réussi";
				}
				
	default :
				$NomLogin = "";
				$mPasse = "";
				$Priorite = 10;
				$Creation = date("Y-m-d");
				$Langue = "FRANÇAIS";
				$NoClient = 0;        	  	  
				$EN_AJOUT = 1;
				include( "msform.inc");
				break;
}

?>

