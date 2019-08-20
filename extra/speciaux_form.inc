<?php
/* Programme : speciaux_form.inc
* Description : Affichage du contenu de la table des spéciaux .
* Auteur : Denis Léveillé 	 		  Date : 2007-11-09

*/
?>
<html>
<head>
	<title><?=$TabMessGen[69]?></title>
<link title='hermesstyle' href="styles/stylegen.css" type='text/css' rel='stylesheet'>
</head>
<!--script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script-->
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
<body bgcolor="#D8D8FF" onload="javascript:pageonload()">
<script language='JavaScript1.2'>mmLoadMenus();</script>
<form name='special' action='speciaux_consulte.php?do=Modif' method='post'>
	<input name='NbTrans' TYPE='hidden' VALUE='<?=mysql_num_rows($result)?>'>
  <table width="100%" height="100%" border="1" cellspacing="0" cellpadding="0">
   <tr>
      <td colspan="6" bgcolor="#7CDFDF" align="center">
         <font color="black" size="+1">
         <b>LISTES DES SPÉCIAUX</b></font>
      </td>
   </tr>
<?php
	echo "<tr align=center>";
	for( $i=1; $i <= mysql_num_rows($result); $i++ ) {
		$row = mysql_fetch_row($result);
		echo "<td>&nbsp;
				</td";
		echo "<td>
					<b>Produit # $i&nbsp;:</b>&nbsp;&nbsp;
					<input type='text' name='Prod[$i]' size='4' value='$row[1]' maxlength='4'>
					<input name='Id[$i]' TYPE='hidden' VALUE='$row[0]'>
				</td";
		if( $i && !($i % 3 ) ) {
  			echo "</tr>";
         echo "<tr align=center>";
		}
	} // for i < nombre de rangé
	echo "</tr>";
?>
   <tr>
      <td colspan="6" align="center">
			<input type='submit' name='Commande' value='<?=$TabMessGen[18]?>'>
         
      </td>
   </tr>
   <tr>
      <td colspan="6" bgcolor="#7CDFDF" align="center">
      	 <font color="black" size="+1">
<?php  echo "<b>".$TabMessGen[69]."</b>"; ?>
         </font>
      </td>
   </tr>
  </table>
</form>


<script language="javascript">
function pageonload() {
	<?php
          if( isset($NewMessage) ) {
	    	echo "	alert(\"$NewMessage\"); ";
          	unset( $NewMessage );
          }
        ?>
}

addKeyEvent();

</script>
<script language=javascript1.2 src='js/blokclick.js'></script>

</body>
</html>
