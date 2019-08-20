 <?php
/* Programme : Produits_Form.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
 * Auteur : Denis Léveillé 	 		  Date : 2007-09-04
*/
//$_SESSION['parent'] = 1;

// addcslashes($vars['delim'],METACHARS);

$titre_fr = htmlspecialchars($titre_fr, ENT_QUOTES );
$titre_en = htmlspecialchars($titre_en, ENT_QUOTES );
$titre_sp = htmlspecialchars($titre_sp, ENT_QUOTES );


?>
<html>
<head>
<?php 
 if( isset($EN_AJOUT) ) echo $TabId[1];
 if( isset($EN_RECHERCHE) ) echo $TabId[2];
 if( isset($EN_CONSULTE) ) echo $TabId[3]; 
?>

</head>
<link title='hermesstyle' href="styles/styleprod.css" type='text/css' rel='stylesheet'>
<!--script language='javascript1.2' src='js/disablekeys.js'></script>
<script language='javascript1.2' src='js/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script-->
<script language='javascript1.2' src="js/mm_menu.js"></script>
<?php
switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
				break;
		default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
}
?>
<body bgcolor="#8DFFA0" onload="javascript:pageonload()">
<script language='JavaScript1.2'>mmLoadMenus();</script>

<?php
  	if( isset($EN_AJOUT) ) echo "<form name='ProduitsForm' action='produits_ajout.php?do=new' method='post'>";
  	if( isset($EN_CONSULTE) ) echo "<form name='ProduitsForm' action='produits_consulte.php?do=consulte&NoId=$id' method='post' enctype='multipart/form-data'>";
	if( isset($EN_LIST) ) 
  		echo "<form name='ProduitsForm' action='produits_recherche.php?do=fouille' method='post'>"; 
  	elseif( isset($EN_RECHERCHE) ) 
	  echo "<form name='ProduitsForm' action='produits_recherche.php?do=rech' method='post'>"; 
?>

			<table cellpadding='4' width='100%' align='center'>
				<tr>
					<td colspan="3" bgcolor="#26FE5E" align="center">
						<font color="white" size="+1">
					   <b><?=$TabId[5] ?></b></font>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<br>
					</td>
				       <td colspan="2" align="center">
				          <?php
						if( isset($EN_AJOUT) ) echo "<input type='submit' name='Commande' value='$TabId[39]'>&nbsp;"; // Ajouter
						if( isset($EN_RECHERCHE) ) {
							echo "<input type='submit' name='Commande' value='$TabId[40]'>&nbsp;"; // Rechercher
//									echo "<input type='button' name='Commande' value='Reset' onClick='ResetClient()'>&nbsp;"; // Reset
						} // EN RECHERCHE
						if( isset($EN_CONSULTE) ) {
//									if( $_SESSION['Prio'] <= $PrioModif ) 
							echo "<input type='submit' name='Commande' value='$TabId[41]'>&nbsp;\n"; // Modifier
	             					echo "<input type='button' name='Photo' value='Photo' onClick='AjoutPhoto($id)'>\n";
	             					echo "<input type='button' name='AjCat' value='Ajout' Catalogue' onClick='AjoutCatalogue($id)'>\n";
	            					echo "<input type='button' name='LstCat'  value='Catalogue' onClick='ListCatalogue($id)'>\n";
							echo "<input type='button' name='Commande' value='$TabId[46]' onClick='ImprimePage()'>&nbsp;";
//									if( $_SESSION['Prio'] < $PrioAnnule )  
							echo "&nbsp;<input type='button' name='Commande' value='$TabId[48]' onClick='ConfirmeDet()'>"; // Detruire
						} // En CONSULTE
				         ?>
				       </td>
				   </tr>
			<tr align=left >
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[6]?> :&nbsp;
						<input type="text" name="id" size="10" value="<?=$id?>" 
<?php
	         if( isset($EN_AJOUT) || isset($EN_CONSULTE) )
					echo "class='inputvoid' onFocus='this.blur()' maxlength='10'>&nbsp;&nbsp;";
				else
					echo " maxlength='10'>&nbsp;&nbsp;";
?>
						&nbsp;&nbsp;
						<?=$TabId[8]?> :&nbsp;
						<input type="text" name="Code" size="12" maxlength='20' value="<?=$Code?>"/>
						&nbsp;&nbsp;
						<?=$TabId[28]?> :&nbsp;
			         <select name="Provenance" size="1" class='s2'>
			         <option value="0" <?php if( $Provenance == 0 ) echo 'SELECTED' ?>>Other
			         <option value="1" <?php if( $Provenance == 1 ) echo 'SELECTED' ?>>Cuba
			         <option value="2" <?php if( $Provenance == 2 ) echo 'SELECTED' ?>>Canada
			         <option value="3" <?php if( $Provenance == 3 ) echo 'SELECTED' ?>>Dominican
			         </select>
						<!-- input type="text" name="Provenance" size="4" maxlength='4' value="<?=$Provenance?>"/ -->
						&nbsp;&nbsp;
						<?=$TabId[26]?> :&nbsp;
						<input type="text" name="Secteur_Limite" size="4" maxlength='4' value="<?=$Secteur_Limite?>"/>
						&nbsp;&nbsp;
						<?=$TabId[27]?> :&nbsp;
						<input type="text" name="Qte_Max_Livre" size="5" maxlength='5' value="<?=$Qte_Max_Livre?>"/>
					</td>
				</tr>
				<tr align=left >
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[9]?> :&nbsp;
						<input type="text" name="titre_fr" size="100" maxlength='200' value='<?=$titre_fr?>'>
					</td>
				</tr>
				<tr align=left > 
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[10]?> :&nbsp;
						<input type="text" name="titre_en" size="100" maxlength='200' value='<?=$titre_en?>'>
					</td>
				</tr>
				<tr align=left >
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[11]?> :&nbsp;
						<input type="text" name="titre_sp" size="100" maxlength='200' value='<?=$titre_sp?>'>
					</td>
				</tr>
				<tr align=left >
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[12]?> :&nbsp;
						<input type="text" name="prix_detail" size="6" maxlength='6' value="<?=$prix_detail?>" >&nbsp;&nbsp;
						<?=$TabId[13]?> :&nbsp;
						<input type="text" name="prix_promo" size="6" maxlength='6' value="<?=$prix_promo?>">&nbsp;&nbsp;
						<?=$TabId[73]?> :&nbsp;
						<input type="text" name="Cout" size="6" maxlength='6' value="<?=$Cout?>" >&nbsp;&nbsp;
						<?=$TabId[74]?> :&nbsp;
						<input type="text" name="Markup" size="6" maxlength='6' value="<?=$Markup?>">
						<?=$TabId[80]?> :&nbsp;
						<input type="text" name="Douane" size="6" maxlength='6' value="<?=$Douane?>">
					</td>
				</tr>
				<tr align=left >
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[14]?> :&nbsp;
						<input type="text" name="weight" size="3" maxlength='6' value="<?=$weight?>">&nbsp;&nbsp;
						<?=$TabId[15]?> :&nbsp;
						<input type="text" name="width" size="3" maxlength='6' value="<?=$width?>">&nbsp;&nbsp;
						<?=$TabId[16]?> :&nbsp;
						<input type="text" name="height" size="3" maxlength='6' value="<?=$height?>">
						<?=$TabId[29]?> :&nbsp;
						<input type="text" name="height" size="3" maxlength='6' value="<?=$height?>">
					</td>
				</tr>
				<tr align=left >
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' colspan='2'>
						<?=$TabId[75]?>:&nbsp;
						<input type="text" name="QteStock" size="6" maxlength='6' vvalue="<?=$QteStock?>">&nbsp;
						<?=$TabId[76]?>:&nbsp;
						<input type="text" name="QteVendu" size="6" maxlength='6' value="<?=$QteVendu?>">&nbsp;
						<?=$TabId[77]?>:&nbsp;
						<input type="text" name="QteCmd" size="6" maxlength='6' value="<?=$QteCmd?>">&nbsp;
						<?=$TabId[78]?>:&nbsp;
						<input type="text" name="QteBO" size="5" maxlength='6' value="<?=$QteBO?>">&nbsp;
						<?=$TabId[79]?>:&nbsp;
						<input type="text" name="QteDOA" size="5" maxlength='6' value="<?=$QteDOA?>">
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' align=left colspan='1'>
						<?=$TabId[17]?>
						<br>
						<textarea name="description_fr" cols='60' rows='4'><?=$description_fr?></textarea>
					</td>
					<td nowrap valign='top' colspan='1'>
                  <?=$TabId[18]?>
						<br>
						<textarea name="description_supplementaire_fr" cols='60' rows='4'><?=$description_supplementaire_fr?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' align=left colspan='1'>
						<?=$TabId[19]?>
						<br>
						<textarea name="description_en" cols='60' rows='4'><?=$description_en?></textarea>
					</td>
					<td nowrap valign='top' colspan='1'>
						<?=$TabId[20]?>
						<br>
						<textarea name="description_supplementaire_en" cols='60' rows='4'><?=$description_supplementaire_en?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<br>
					</td>
					<td nowrap valign='top' align=left colspan='1'>
						<?=$TabId[21]?>
						<br>
						<textarea name="description_sp" cols='60' rows='4'><?=$description_sp?></textarea>
					</td>
					<td nowrap valign='top' colspan='1'>
						<?=$TabId[22]?>
						<br>
						<textarea name="description_supplementaire_sp" cols='60' rows='4'><?=$description_supplementaire_sp?></textarea>
					</td>
				</tr>
				<tr>
					<td>
						&nbsp;<br><br>
					</td>
					<td nowrap valign='top' align=left colspan='2'>
						<?=$TabId[23]?>&nbsp;
						<input type="text" name="small" size="4" maxlength='4' value=<?=$small?>>
						&nbsp;&nbsp;
						<?=$TabId[24]?>&nbsp;
						<input type="text" name="medium" size="4" maxlength='4' value=<?=$medium?>>
						&nbsp;&nbsp;
						<?=$TabId[25]?>&nbsp;
						<input type="text" name="big" size="4" maxlength='4' value=<?=$big?>>
						&nbsp;&nbsp;
						<?=$TabId[7]?> :&nbsp;
			         <select name="online" size="1"/>
			         <option value="1" <?php if( $online == 1 ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
			         <option value="0" <?php if( $online == 0 ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
			         </select>
					</td>
				</tr>
		
 				  <tr>
				   <tr>
				       <td colspan="3" bgcolor="#26FE5E" align="center">
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

<script language="javascript">

function AjoutCatalogue(No) {
		    str = 'produit_cat_ajout.php?NoProd=' + No;
		 	open(str,'_blank',
             'left=10,top=10,height=250,width=500,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
} // Ajout Photo


function ListCatalogue(No) {
		    str = 'produit_cat_lstframe.php?NoProd=' + No;
		 	open(str,'_blank',
             'left=10,top=10,height=250,width=500,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
} // Ajout Photo


function AjoutPhoto(No) {
		    str = 'photoput.php?choix=' + No;
		 	open(str,'_blank',
             'left=10,top=10,height=475,width=350,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
} // Ajout Photo


function ResetProduit() {
//      document.ClientForm.Nom.value = "";
//	  document.ClientForm.NoClient.focus();
} // ResetClient


//Convert the username to uppercase.
function capitalize() {
//		document.ClientForm.Nom.value = document.ClientForm.Nom.value.toUpperCase();
} // capitalize

function ConfirmeDet() {
<?php 
	  if( @$_SESSION['Prio'] < 7) {
	  	echo "  
		  if( window.confirm('$TabMessGen[7]') ){
		  	  open(\"produits_consulte.php?do=detruit&NoId=$id\",\"_self\" );
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
      document.ProduitsForm.id.focus();
	<?php
 		 if( isset($EN_AJOUT) ) 
		   echo "window.status = '$TabId[70]';";
 		 if( isset($EN_RECHERCHE) ) 
		   echo "window.status = '$TabId[71]';";
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
