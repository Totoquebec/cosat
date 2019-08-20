<?php
/* Programme : RechercheClient.php
* Description : Programme de recherche de client.
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
	unset($EN_AJOUT);
	unset($EN_CONSULTE);
	$EN_RECHERCHE = 1;
	include("catalogue_form.inc");
	exit();
} // Affiche Erreur


switch( @$_GET['do'] ) {
	case "rech"	: 
			$Ok = $Ok2 = 0;
    		$sql = "SELECT * FROM $mysql_base.catalogue WHERE ";
			
			foreach($_POST as $clé => $valeur ) {
				switch( $clé ){
					case "id":	if( strlen($valeur) ) {
												stripslashes( $valeur );
												$$clé = strip_tags( trim( $valeur ) );
												// es-ce une cle alphabetique
												// Oui - alors ancienne cle 
													if( $Ok ) {
														$sql .= " AND ";
														$Ok2 = 2;
													}
													else
														$Ok = 2;
													$sql .= "id = '$valeur'";
												}
											break;
					case "parent":		if( strlen($valeur) ) {
												$$clé = strtoupper( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 4;
												}
												else
													$Ok = 4;
												$sql .= "parent = '$valeur'";
											}
											break;
					case "fr":	if( strlen($valeur) ) {
												$$clé = strtoupper( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 6;
												}
												else
													$Ok = 6;
												$sql .= "fr LIKE '$valeur%'";
											}
											break;
					case "en":		if( strlen($valeur) ) {
												$$clé = strtoupper( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 7;
												}
												else
													$Ok = 7;
												$sql .= "en LIKE '$valeur%'";
											}
											break;
					case "sp":	if( strlen($valeur) ) {
												$$clé = strtoupper( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 8;
												}
												else
													$Ok = 8;
												$sql .= "sp LIKE '$valeur%'";
											}
											break;
					default :	     break;
					
				} //switch
			} // for each
			
			if( $Ok ) {
				$sql .= " LIMIT 500";
				//$Mess = "Sql = ".$sql;
				//AfficherErreur($Mess);
				extract($_POST,EXTR_OVERWRITE);			   
				
				$result = mysql_query( $sql, $handle );
				if( $result == 0 )
					AfficherErreur( $TabMessGen[32].mysql_errno().": ".mysql_error() );
				elseif (  mysql_num_rows($result) == 0 ) {
					AfficherErreur( $TabMessGen[50] );
				}
				$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
				extract($ligne);
    			$sql = "SELECT ".$_SESSION['langue']." FROM $mysql_base.catalogue WHERE id = $parent;";
				$result = mysql_query( $sql, $handle );
				if( $result && mysql_num_rows($result) ) {
					$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
					$TitParent = $ligne[$_SESSION['langue']];
				}
				
				unset($EN_AJOUT);
				unset($EN_RECHERCHE);
				$EN_CONSULTE = 1;
				include("catalogue_form.inc");
				break;
			} // Si une requête
			else
				AfficherErreur( "Requête INVALIDE. Corrigez S.V.P.");
			break;
   case "trouve": if( isset( $_GET['choix'] ) ) {
                     $sql = " SELECT * FROM $mysql_base.catalogue WHERE id = '".$_GET['choix']."'";
                     $result = mysql_query( $sql );
                     if( $result == 0 )
								AfficherErreur( "ERREUR : ".mysql_errno().": ".mysql_error() );
                     elseif (  mysql_num_rows($result) == 0 ) {
                        AfficherErreur( "Identification du catalogue INVALIDE." );
                     }
                     else {
                        $ligne = mysql_fetch_array($result,MYSQL_ASSOC);
                        extract($ligne);
				    			$sql = "SELECT ".$_SESSION['langue']." FROM $mysql_base.catalogue WHERE id = $parent;";
								$result = mysql_query( $sql, $handle );
								if( $result && mysql_num_rows($result) ) {
									$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
									$TitParent = $ligne[$_SESSION['langue']];
								}
                   	} // else resultat disponible
							unset($EN_AJOUT);
							unset($EN_RECHERCHE);
							$EN_CONSULTE = 1;
                     include("catalogue_form.inc");
                     break;
                  }
	default :	$id = $parent = $TitParent = $ordre = $fr = $en = $sp = $Markup = $online = "";
		  		  	unset($EN_AJOUT);
		unset($EN_CONSULTE);
		$EN_RECHERCHE = 1;
		include( "catalogue_form.inc");
		break;
} // switch

?>

