 <?php
/* Programme : ClientForm.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
 * Auteur : Denis Léveillé 	 		  Date : 2004-01-01
 * MAJ : Denis Léveillé 	 			  Date : 2007-01-31
*/

?>

<html>
<head>
<?php 
 if( isset($EN_AJOUT) ) echo $TabId[1];
 if( isset($EN_CONSULTE) ) echo $TabId[3]; 
?>

<link href="styles/stylegen.css" type='text/css' rel='stylesheet'>
</head>
<script language='JavaScript1.2' src='javafich/disablekeys.js'></script>

<body bgcolor="#A2E8E8" onload="javascript:pageonload()">

<?php
  if( isset($EN_AJOUT) ) echo "<form name=DeviseForm action='monnaiemodif.php?do=new' method='post'>";
  if( isset($EN_CONSULTE) ) echo "<form name=DeviseForm action='monnaiemodif.php?do=consulte&IdDev=$Devise' method='post'>";
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
   	<td colspan="2" bgcolor="#6666FF" align="center">
      	<font color="white" size="+1">
         <b><?php echo $TabId[5] ?></b></font>
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[6] ?>&nbsp;</b></td>
      <td><input type="text" name="Devise" size="4"
	  			 value="<?php echo @$Devise ?>"
          <?php
         	if( isset($EN_CONSULTE)  )
				echo "class='inputvoid' onFocus='this.blur()' maxlength='0'>";
			else
				echo "maxlength='4'>";
		  ?>
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[11] ?>&nbsp;</b>
 		  <input type="text" name="Symbole" size="4" value="<?php echo @$Symbole ?>" maxlength="4">
      </td>
   </tr>
    <tr>
      <td align=right><b><?php echo $TabId[7] ?>&nbsp;</b></td>
      <td><input type="text" name="TxVenteUS" size="8" value="<?php echo @$TxVenteUS ?>" maxlength="8">
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[13] ?>&nbsp;</b>
          <input type="text" name="NTauxVente" size="8" value="<?php echo @$NTauxVente ?>" maxlength="0" onFocus='this.blur()'>
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[10] ?>&nbsp;</b></td>
      <td><input type="text" name="TxAchatUS" size="8" value="<?php echo @$TxAchatUS  ?>" maxlength="8">
     	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[13] ?>&nbsp;</b>
          <input type="text" name="NTauxAchat" size="8" value="<?php echo @$NTauxAchat ?>" maxlength="0" onFocus='this.blur()'>
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[8] ?>&nbsp;</b></td>
       <td>
         <select name="Transfert" size="1">
         <option value="OUI" <?php if( $Transfert == "OUI" ) echo 'SELECTED' ?>>OUI
         <option value="NON" <?php if( $Transfert == "NON" ) echo 'SELECTED' ?>>NON
         </select>
         &nbsp;&nbsp;
         <b><?php echo $TabId[9] ?>&nbsp;</b>
         <select name="Paiement" size="1">
         <option value="OUI" <?php if( $Paiement == "OUI" ) echo 'SELECTED' ?>>OUI
         <option value="NON" <?php if( $Paiement == "NON" ) echo 'SELECTED' ?>>NON
         </select>
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[12] ?>&nbsp;</b></td>
      <td><input type="text" name="Commentaire" size="50" value="<?php echo @$Commentaire  ?>"  maxlength="50">
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[14] ?>&nbsp;</b></td>
      <td><input type="text" name="Frais" size="50" value="<?php echo @$Frais  ?>" maxlength="50">
      </td>
   </tr>
   <tr>
       <td colspan="2" align="center">
          <?php
           if( isset($EN_AJOUT) ) echo "<input type='submit' name='Commande' value='$TabId[39]'>&nbsp;"; //Ajouter
           if( isset($EN_CONSULTE) ) {
   	   		 echo "<input type='submit' name='Commande' value='$TabId[41]'>&nbsp;"; // Modifier
   	   		 echo "<input type='button' name='Commande' value='$TabId[46]' onClick='ImprimePage()'>&nbsp;"; // Imprimer
   	   		 echo "<input type='submit' name='Commande' value='$TabId[36]'>&nbsp;"; //Quitter
	 		 if( @$_SESSION['Prio'] < 3 )  
	 	 	 	 echo "<br>&nbsp;&nbsp;<input type='button' name='Commande' value='$TabId[48]' onClick='ConfirmeDet()'>";
           }
         ?>
       </td>
   </tr>
   <tr>
       <td colspan="2" bgcolor="#6666FF" align="center">
          <font color="white" size="+1">
          <?php 
		    if( isset($EN_AJOUT) ) echo "<b>$TabId[49]</b>"; 
            if( isset($EN_CONSULTE) ) echo "<b>$TabId[51]</b>"; 
		  ?> 
          </font>
       </td>
   </tr>
</table>
</form>

<script language="javascript">
function ConfirmeDet() {
<?php 
	  if( @$_SESSION['Prio'] < 3 ) {
	  	echo "  
		  if( window.confirm('$TabMessGen[7]') ){
		  	  open(\"monnaiemodif.php?do=detruit&IdDev=$Devise\",\"_self\" );
		  }
		";
	  }
	  else {
	    echo "
			 window.alert(\"$TabMessGen[6]\");
		";
	  };
?>
	  return;
} // ConfirmeDet

function ImprimePage() {
	window.print();
} // ImprimePage

function pageonload() {
	<?php
 		 if( isset($EN_AJOUT) ) 
		   echo "window.status = '$TabId[70]';";
          if( isset($NewMessage) ) {
	    	echo "
				window.alert(\"$NewMessage\"); 
			";
          	unset( $NewMessage );
          };
     ?>
	 return;
} // pageonload
		addKeyEvent();

</script>
<script language='JavaScript1.2' src='javafich/blokclick.js'></script>

</body>
</html>