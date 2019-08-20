<?php
/* Programme : LienForm.inc
* Description : Affichage de la page des Liens. Celui-ci présente un
* 		formulaire pour saisir les informations permettant d'ajouter
* 		de détruire ou de consulter les liens.
*/
/* include("var.inc");
 include("lstenum.inc");
 $connection = mysql_connect( $host, $user, $password)
   		or die( "Connection impossible au serveur");
 $db = mysql_select_db( $database, $connection )
        	or die("La base de données ne peut être sélectionnée");*/
 $Option = get_enums("pgliens", "Langue");
 $LeType = get_enums("pgliens", "Type");
 $LeTarget =  get_enums("pgliens", "Target"); 
?>
<html>
<head>
<title>Ajout d'un Lien</title>

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
<body bgcolor="#C0C0FF" onload="javascript:pageonload()">
<script language='JavaScript1.2'>mmLoadMenus();</script>
<form action="lienajout.php?do=new" method="post">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td colspan="4" bgcolor="#9999FF" align="center">
         <font color="white" size="+1">
         <b>SYSTÈME DE TRAITEMENT DES LIENS</b></font>
      </td>
   </tr>
   <tr>
	   <td align=right><b>NoLien&nbsp;</b></td>
       <td><input type="text" name="NoLien" size="4"
                  value="<?php echo @$NoLien ?>" onFocus='this.blur()'
                  maxlength="0">
       </td>
   </tr>
   <tr>
       <td align=right><b>Type&nbsp;</b></td>
       <td>
          <select name="Type" size="1">
<?php
//       if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
//           echo "<option value='' SELECTED >";
  for($i=0;$i<sizeof($LeType);$i++) {
    echo "<option value='".$LeType[$i]."' ";
	if( $i == 1 ) echo " SELECTED";
    echo " >".$LeType[$i];
  }  ?>
          </select>
   </tr>
   <tr>
		<td align=right><b>Description&nbsp;</b></td>
       	<td><input type="text" name="Description" size="75"
        		   value="<?php echo @$Description ?>"
            	   maxlength="255">
       </td>
   </tr>
   <tr>
		<td align=right><b>URL&nbsp;</b></td>
       	<td><input type="text" name="URLLien" size="75"
        		   value="<?php echo @$URLLien ?>"
            	   maxlength="255">
       </td>
   </tr>
   <tr>
       <td align=right><b>Target&nbsp;</b></td>
       <td>
          <select name="Target" size="1">
<?php
//       if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
//           echo "<option value='' SELECTED >";
  for($i=0;$i<sizeof($LeTarget);$i++) {
    echo "<option value='".$LeTarget[$i]."' ";
	if( $i == 1 ) echo " SELECTED";
    echo " >".$LeTarget[$i];
  }  ?>
          </select>
   </tr>
    <tr>
      <td align=right><b>DateCréé&nbsp;</b></td>
      <td><input type="text" name="DateCréé" size="10"
                 value="<?php echo @$DateCréé ?>" onFocus='this.blur()'
                 maxlength="0">
		</td>	
   </tr>
   <tr>
       <td align=right><b>Langue&nbsp;</b></td>
       <td>
          <select name="Langue" size="1">
<?php
//       if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
//           echo "<option value='' SELECTED >";
  for($i=0;$i<sizeof($Option);$i++) {
    echo "<option value='".$Option[$i]."' ";
	if( $i == 1 ) echo " SELECTED";
    echo " >".$Option[$i];
  }  ?>
          </select>
   </tr>
   <tr>
      <td colspan="4" align="center">
         <input type="submit" name="Commande" value="Ajouter">
	     <input type="submit" name="Quitter" value="Quitter" onClick="QuitterPage()">
      </td>
   </tr>
   <tr>
      <td colspan="4" bgcolor="#9999FF" align="center">
      	 <font color="white" size="+1">
		 <b>AJOUT D'UN LIEN</b>
         </font>
      </td>
   </tr>
</table>
</form>


<script language="javascript">

function QuitterPage() {
	close();
} // QuitterPage

function pageonload() {
	<?php
          if( isset($NewMessage) ) {
	    	echo "	alert(\"$NewMessage\"); ";
          	unset( $NewMessage );
          }
        ?>
}

</script>

</body>
</html>
