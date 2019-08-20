<?php
/* Programme : MSForm.inc
* Description : Affichage de la page des USAGERS. Celui-ci présente un
* 		formulaire pour saisir les informations permettant d'ajouter
* 		de détruire ou de consulter les usagers.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
*/
	$Option = get_enums("secur", "Langue");
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
<head>
<title>
<?php 
 if( isset($EN_AJOUT) ) echo $TabMessSecur[12];
 if( isset($EN_RECHERCHE) ) echo $TabMessSecur[16];
 if( isset($EN_CONSULTE) ) echo $TabMessSecur[14]; 
?>
</title>
<!-- link href="styles/stylegen.css" type='text/css' rel='stylesheet' -->
</head>
<script language='javascript1.2' src='js/disablekeys.js'></script>
<script language='javascript1.2' src='js/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script>
<body bgcolor="#C0C0FF" onload="javascript:pageonload()">
<?php
  if( isset($EN_AJOUT) ) echo "<form name=Securite action='msajout.php?do=new' method='post'>";
  if( isset($EN_RECHERCHE) ) echo "<form name=Securite action='msajout.php?do=new' method='post'>"; 
  if( isset($EN_CONSULTE) ) echo "<form name=Securite action='msconsult.php' method='post'>";
?>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td colspan="4" bgcolor="#9999FF" align="center">
         <font color="white" size="+1">
         <b>
<?php 
 if( isset($EN_AJOUT) ) echo $TabMessSecur[13];
 if( isset($EN_RECHERCHE) ) echo $TabMessSecur[17];
 if( isset($EN_CONSULTE) ) echo $TabMessSecur[15]; 
?>
		 </b></font>
      </td>
   </tr>
   <tr>
	   <td align='right'><b>Login&nbsp;</b></td>
       <td><input type="text" name="NomLogin" size="20" value="<?php echo @$NomLogin ?>"
<?php
        	if( isset($EN_CONSULTE)  )
				echo "class='inputvoid' onFocus='this.blur()'";
			echo "maxlength='20'>";
?>
       </td>
   </tr>
<?php
  if( isset($EN_AJOUT)  ) {
   echo "<tr>
		<td align='right'><b>Mot de passe&nbsp;</b></td>
       	<td><input type='password' name='mPasse' size='20' value='".@$mPasse."' maxlength='20'></td>
   </tr>";
  }
?>
   <tr>
      <td align='right'><b>Priorité&nbsp;</b></td>
      <td><input type="text" name="Priorite" size="2" value="<?php echo @$Priorite ?>"
<?php
         	if( isset($EN_CONSULTE) && ( @$_SESSION['Prio'] > $PrioMaitre ) )
					echo "class='inputvoid' onFocus='this.blur()'";
				echo "maxlength='2'>";
?>
		<td>	
   </tr>
   <tr>
       	<td align='right'><b>Client&nbsp;</b></td>
      	<td><input type="text" name="NoClient" size="10" value="<?php echo @$NoClient ?>"
<?php
         	if( isset($EN_CONSULTE)  )
					echo "class='inputvoid' onFocus='this.blur()'";
				echo " maxlength='10'>";
?>
		<td>	
   </tr>
   <tr>
       	<td align='right'><b>Création&nbsp;</b></td>
      	<td><input type="text" name="Creation" size=10 value="<?php echo @$Creation ?>" class='inputvoid' onFocus='this.blur()' maxlength=0>
		</td>	
   </tr>
   <tr>
       <td align='right'><b>Langue&nbsp;</b></td>
       <td>
          <select name="Langue" size="1">
<?php
       if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
           echo "<option value='' SELECTED >";
  for($i=0;$i<sizeof($Option);$i++) {
    echo "<option value='".$Option[$i]."' ";
    if( $Langue == $Option[$i] ) echo " SELECTED";
    echo " >".$Option[$i];
  }  
?>
          </select>
   </tr>
<?php
  if( isset($EN_CONSULTE)  ) {
?>	<tr>
		<td align='right'><b>Reset mot passe&nbsp;</b></td>
       	<td>
        <select name='Acces' size=1>
         	<option value='OUI' <?php if( $Acces == 'OUI' ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
         	<option value='NON' <?php if( $Acces == 'NON' ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
         </select>
		</td>
   </tr>
<?php
  }
?>
  <tr>
      <td colspan="4" align="center">
<?php 
 if( isset($EN_AJOUT) ) echo "<input type='submit' name='Commande' value='Ajouter'>";
 if( isset($EN_RECHERCHE) ) echo "<input type='submit' name='Commande' value='Recherche'>";
 if( isset($EN_CONSULTE) ) echo "<input type='submit' name='Commande' value='Modifier'>"; 

 echo "<input type='button' name='Quitter' value='$TabMessGen[14]'  onClick='QuitterPage()'>";
?>
         
      </td>
   </tr>
   <tr>
      <td colspan="4" bgcolor="#9999FF" align="center">
      	 <font color="white" size="+1">
		 <b>
<?php 
 if( isset($EN_AJOUT) ) echo $TabMessSecur[13];
 if( isset($EN_RECHERCHE) ) echo $TabMessSecur[17];
 if( isset($EN_CONSULTE) ) echo $TabMessSecur[15]; 
?>
		 </b>
         </font>
      </td>
   </tr>
</table>
</form>

<script language="javascript">

	function QuitterPage() {
		close();
		open("mainfr.php","_self" );
	} // QuitterPage
	
	function pageonload() {
		document.Securite.NomLogin.focus();
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