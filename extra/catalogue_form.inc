 <?php
/* Programme : ClientForm.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
 * Auteur : Denis Léveillé 	 		  Date : 2004-01-01
 * MAJ : Denis Léveillé 	 			  Date : 2007-01-31
*/

// mysql_close($handle);
?>
<html>
<head>
<?php 
 if( isset($EN_AJOUT) ) echo $TabId[1];
 if( isset($EN_RECHERCHE) ) echo $TabId[2];
 if( isset($EN_CONSULTE) ) echo $TabId[3]; 
 

?>
</head>
<link title='hermesstyle' href='styles/stylegen.css' type='text/css' rel='stylesheet' />
<!-- script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script -->
<script language='javascript1.2' src="js/mm_menu.js"></script>
<?php
switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
				break;
		case "SPANISH" :echo "<script language='JavaScript1.2' src='js/ldmenusp.js'></script>\n";
				break;
		default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
}
?>
<body bgcolor="#A2E8E8" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:pageonload()">
<script language='JavaScript1.2'>mmLoadMenus();</script>
<?php
  if( isset($EN_AJOUT) ) echo "<form name=CatForm action='catalogue_ajout.php?do=new' method='post'>";
  if( isset($EN_RECHERCHE) ) echo "<form name=CatForm action='catalogue_recherche.php?do=rech' method='post'>"; 
  if( isset($EN_CONSULTE) ) echo "<form name=CatForm action='catalogue_consulte.php?do=Modif' method='post'>";
?>
<table width="100%" height="90%" border="0" cellspacing="0" cellpadding="0">
    <tr>
   	<td colspan="2" bgcolor="#6666FF" align="center">
      	<font color="white" size="+1">
         <b><?php echo $TabId[5] ?></b></font>
      </td>
   </tr>
   <tr>
      <td align=right><b><?php echo $TabId[6] ?>&nbsp;</b></td>
      <td><input type="text" name="id" size="5" value="<?=$id?>"
          <?php
         	if( isset($EN_CONSULTE) || isset($EN_AJOUT) )
					echo "class='inputvoid' onFocus='this.blur()'";
				echo " maxlength='5'>";
		  ?>
      	  &nbsp;&nbsp;&nbsp;
          <b><?php echo $TabId[7] ?>&nbsp;</b>
          <input type="text" name="parent" size="4" value="<?=$parent?>" maxlength="4">
      	  &nbsp;&nbsp;&nbsp;
          <input type="text" name="TitParent" value="<?=$TitParent?>" size="30" class='inputvoid' onFocus='this.blur()'>
          &nbsp;&nbsp;
          <b><?php echo $TabId[8] ?>&nbsp;</b>
          <input type="text" name="ordre" size="4" value="<?=$ordre?>" maxlength="4">
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[9] ?>&nbsp;</b></td>
      <td><input type="text" name="fr" size="60" value="<?=$fr?>" maxlength="100" />
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[10] ?>&nbsp;</b></td>
      <td><input type="text" name="en" size="60" value="<?=$en?>" maxlength="100" />
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[11] ?>&nbsp;</b></td>
      <td><input type="text" name="sp" size="60" value="<?=$sp?>" maxlength="100" />
      </td>
   </tr>
   <tr>
      <td size="5" align=right><b><?php echo $TabId[12] ?>&nbsp;</b></td>
      <td><input type="text" name="Markup" size="6" value="<?=$Markup?>" maxlength="6" />
          &nbsp;&nbsp;
			<b><?php echo $TabId[13] ?>&nbsp;</b>
         <select name="online" size="1">
         <option value="1" <?php if( $online == 1 ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
         <option value="0" <?php if( $online == 0 ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
         </select>
      </td>
   </tr>
   <tr>
       <td colspan="2" align="center">
<?php
			if( isset($EN_AJOUT) ) 
				echo "<input type='submit' name='Commande' value='$TabId[39]'>&nbsp;"; // Ajouter
			if( isset($EN_RECHERCHE) ) {
				echo "<input type='submit' name='Commande' value='$TabId[40]'>&nbsp;"; // Rechercher
			} // EN RECHERCHE
			if( isset($EN_CONSULTE) ) {
				echo "<input type='submit' name='Commande' value='$TabId[41]'>&nbsp;"; // Modifier
				echo "&nbsp;&nbsp;<input type='button' name='Commande' value='Produits' onClick='ListProd($id)'>"; // Detruire
//			if( @$_SESSION['Prio'] < $PrioAnnule )  
				echo "&nbsp;&nbsp;<input type='button' name='Commande' value='$TabId[48]' onClick='ConfirmeDet()'>"; // Detruire
			}
?>
       </td>
   </tr>
   <tr>
       <td colspan="2" bgcolor="#6666FF" align="center">
          <font color="white" size="+1">
          <?php 
		    if( isset($EN_AJOUT) ) echo "<b>$TabId[49]</b>"; 
            if( isset($EN_RECHERCHE) ) echo "<b>$TabId[50]</b>"; 
            if( isset($EN_CONSULTE) ) echo "<b>$TabId[51]</b>"; 
		  ?> 
          </font>
       </td>
   </tr>
</table>
</form>

<script LANGUAGE="javascript">

function ListProd(No) {
		    str = 'cat_prod_lstframe.php?NoCat=' + No;
		 	open(str,'_blank',
             'left=10,top=10,height=250,width=500,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
} // Ajout Photo

function ConfirmeDet() {
		  if( window.confirm('<?=$TabMessGen[7]?>') )
		  	  open('catalogue_consulte.php?do=detruit&id=<?=$id?>','_self' );
	  return;
} // ConfirmeDet

function ImprimePage() {
	window.print();
} // ImprimePage

function pageonload() {
      document.CatForm.id.focus();
	<?php
 		 if( isset($EN_AJOUT) ) 
		   echo "window.status = '$TabId[70]';\r\n";
 		 if( isset($EN_RECHERCHE) ) 
		   echo "window.status = '$TabId[71]';\r\n";
          if( isset($NewMessage) ) {
	    	echo "window.alert(\"$NewMessage\");";
          	unset( $NewMessage );
          };
     ?>
	 return;
} // pageonload

</script>

</body>
</html>