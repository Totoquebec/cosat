<?php
/* Programme : MonnaieModif.php
* Description : Programme de modification des taux de change.
* Auteur : Denis Léveillé 	 		  Date : 2007-03-22
*/
include('connect.inc');

// **** Choix de la langue de travail ****
 switch( $_SESSION['SLangue'] ) {
	 case "ENGLISH":include("monnmessen.inc");
	 		break;
	 case "FRENCH" :include("monnmessfr.inc");
	 	  	break;
	 default : 	include("monnmesssp.inc");

 } // switch SLangue


function AfficherErreur($texteMsg)
{ 
global $TxAchatUS,$Transfert,$Paiement,$TxVenteUS,$Symbole,$Commentaire,$Devise,$NTauxVente,$NTauxAchat, $Frais, $TabId, $TabMessGen;
	$NewMessage = $texteMsg;
	unset($EN_AJOUT);
   	$EN_CONSULTE = 1;
	include("monnaieform.inc");
	exit();
}

switch( @$_GET['do'] ) {
  case "detruit"  : 
						
			$sql = "DELETE FROM $database.monnaies WHERE Devise = '".@$_GET['IdDev']."'";
			$result = mysql_query( $sql, $handle );
			if( $result == 0 ) {
				$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			} // Si pas réussi
			$Message = "Destruction de la devise ".$_GET['IdDev'];
							Suivi_log($Message, $_GET['IdDev']);
			header( "Location: monnaielst.php");
			break;
					
  case "consulte":  //AfficherErreur( $Commande );
  	   				switch( @$_POST['Commande'] ) {
                       case "$TabId[41]" : // ***** Modifier ***** 
   					 	if( $_SESSION['Prio'] > 4 )  
							AfficherErreur( $TabMessGen[6] );
						extract($_POST,EXTR_OVERWRITE);	 
						$aujourdhui = date("Y-m-d");
						$sql =  "UPDATE $database.monnaies SET TxVenteUS='$TxVenteUS', Transfert='$Transfert', Paiement='$Paiement',";
						$sql .= " TxAchatUS='$TxAchatUS', Symbole='$Symbole',	Commentaire='$Commentaire', Frais='$Frais', DateMAJ='$aujourdhui'";
						$sql .= " WHERE Devise= '$Devise'";
						
						$result = mysql_query( $sql, $handle );
						if( $result == 0 ) {
							$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
							AfficherErreur( $Mess );
						}
						$Message = "Modification de la devise ".$_GET['IdDev'];
						Suivi_log($Message, $_GET['IdDev']);
						
						$_POST['choix'] = $Devise;
														
                                 		 break;
                       default : 		 header( "Location: monnaielst.php");
                        		 		 break;
   		   			}
  default :  	   	
		$sql = " SELECT * FROM $database.monnaies WHERE Devise = '".$_POST['choix']."'";
		$result = mysql_query( $sql, $handle );
		if( $result == 0 ) {
			$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
			AfficherErreur( $Mess );
		}
		elseif (  mysql_num_rows($result) == 0 ) {
			AfficherErreur( "Identification de la devise INVALIDE." );
		}
		else {
			if( mysql_num_rows($result) > 1 )
				AfficherErreur( "ATTENTION plus d'un record retourné" );
			$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
			extract($ligne);
			if( !isset($NTauxVente) ) {
				$NTauxVente = $TxVenteUS;
				$NTauxAchat = $TxAchatUS;
//									$TxVenteUS = get_TauxVente($Devise);
//									$TxAchatUS = get_TauxAchat($Devise);
				$TxVenteUS = GetNewTaux( "VENTE" ,$Devise, $Frais );
				$TxAchatUS = GetNewTaux( "ACHAT" ,$Devise, $Frais );
			}
			// echo "Tx Vente ".$TxVenteUS." et Achat ".$TxAchatUS;
		} // else resultat disponible
		unset($EN_AJOUT);
		$EN_CONSULTE = 1;
		include( "monnaieform.inc");
		break;
}

?>

