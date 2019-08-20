<?php
/* Programme : MSpassForm.inc
* Description : Affichage de la page de changement de password
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
*/
 $Option = get_enums("secur", "Langue");

?>
<html>
<head>
<title><?php echo $TabMessSecur[28] ?></title>

</head>
<body bgcolor="#C0C0FF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:pageonload()">
<form action="mschps.php?do=ok" method="post">

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td colspan="3" bgcolor="#9999FF" align="center">
         <font color="white" size="+1">
         <b><?php echo $TabMessSecur[20] ?></b></font>
      </td>
   </tr>
   <tr>
      <td colspan="3" align="center">
	  	  <font size="+1">
         <b>Bienvenue <?php echo $Prenom." ".$Nom ?></b>
		  </font>
   </td>
   </tr>
   <tr>
      <td colspan="3" align="center">
         <?php echo $TabMessSecur[23] ?>
      </td>
   </tr>
   <tr>
	   <td align=right><b><?php echo $TabMessSecur[21] ?>&nbsp;</b></td>
       <td><input type="password" name="NewmPass1" size="20" value="<?php echo @$NewmPass1 ?>"
                  maxlength="20" AUTOCOMPLETE = "off">
       </td>
   </tr>
   <tr>
		<td align=right><b><?php echo $TabMessSecur[22] ?>&nbsp;</b></td>
       	<td><input type="password" name="NewmPass2" size="20" value="<?php echo @$NewmPass2 ?>"
            	   maxlength="20" AUTOCOMPLETE = "off">
       </td>
   </tr>
   <tr>
       <td align=right><b><?php echo $TabMessSecur[8] ?>&nbsp;</b></td>
       <td>
          <select name="LaLangue" size="1">
<?php
       if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
           echo "<option value='' SELECTED >";
  for($i=0;$i<sizeof($Option);$i++) {
    echo "<option value='".$Option[$i]."' ";
    if( $LaLangue == $Option[$i] ) echo " SELECTED";
    echo " >".$Option[$i];
  }  ?>
          </select>toto<br>
       <input name="PassCourant" TYPE="hidden" VALUE="<?php echo @$PassCourant ?>">
       <input name="Nom" TYPE="hidden" VALUE="<?php echo @$Nom ?>">
       <input name="Prenom" TYPE="hidden" VALUE="<?php echo @$Prenom ?>">
	   </td>
   </tr>
   <tr>
      <td colspan="3" align="center">
         <input type="submit" name="Commande" value="<?php echo $TabMessGen[27] ?>">
	     <input type="submit" name="Quitter" value="<?php echo $TabMessGen[28] ?>" onClick="QuitterPage()">
      </td>
   </tr>
</table>
</form>


<SCRIPT LANGUAGE="javascript">

function QuitterPage() {
	close();
    open("login.php","_self" );
} // QuitterPage

function pageonload() {
	<?php
          if( isset($NewMessage) ) {
	    	echo "	alert(\"$NewMessage\"); ";
          	unset( $NewMessage );
          }
        ?>
}

function click() {
  if (event.button==2) 
    alert('<?php echo $TabMessGen[5] ?>');
} // click

document.onmousedown=click;

</SCRIPT>


</body>
</html>
