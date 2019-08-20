<?php
/* Programme : login_form.inc
* Description : Affichage de la page de login. Celle-ci présente deux
*					  formulaire : le premier pour saisir un nom de login
*					  existant et le mot de passe associé ; la seconde pour
*					  saisir les informations permettant de s'enregistrer
*					  en tant que nouveau client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-03-23
*/

?>
<html>
<head>
<?php echo $TabId[1] ?>
</head>
<script language='JavaScript1.2' src="js/disablekeys.js"></script>
<body bgcolor="#9a8bb4" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:pageonload()">
<base target='_top'>
<table border="0" cellspacing="5" cellpadding="0">
  <tr>
	<td colspan="3" bgcolor="#6666FF" align="center">
      	  <font color="white" size="+10">
          <b><?php echo $TabId[2] ?></b></font>
        </td>
  </tr>
  <tr>
	<td width="33%" valign="top" align=center>
           <!-- pour le login des membres -->
          <form name='LoginForm' action="login.php?do=login&Lang=<?php echo $_GET['Lang'] ?>" method="post">
            <table border="0">
            <tr>
            	<td align="center"><b><?php echo $TabId[4] ?></b></td>
            </tr>
            <tr>
            	<td align="center">
                  <input type="text" name="NomUtilisateur" size="20" value="<?php echo @$_REQUEST['NomUtilisateur'] ?>" maxsize="20">
                 </td>
            </tr>
            <tr>
            	<td align="center"><b><?php echo $TabId[5] ?></b></td>
            </tr>
            <tr>
            	<td align="center">
                  <input type="password" name="MotDePasse" size="20" maxsize="20"></td>
            </tr>
            <tr>
            	<td align="center">
                  <input type="checkbox" name="remember"/>
		  <font size="2">Rappelle-toi de moi!</font>
		</td>
            </tr>
            <tr>
            	<td align="center" colspan="3"><br>
            	  <input type="submit" name="log" value="<?php echo $TabId[6] ?>">
            	</td>
            </tr>
            <tr>
            	<td align="center" colspan="3"><br>
                  <input type="button" name="bye" value="<?php echo $TabId[7] ?>" onClick="Sortie()">
            	</td>
            </tr>
         </table>
        </form>
      </td>
 </tr>
  <tr>
	<td colspan="3" bgcolor="#6666FF" align="center">
      	  &nbsp;
        </td>
  </tr>
</table>
<div align="center"><font size="-1">
<?php echo $TabMessGen[1] ?>
<a href="mailto:<?php echo hexentities($AdrWebmestre) ?>?subject=Page Web <?php echo $NomCie ?>"><?php echo $TabMessGen[2] ?></a>
</font></div>
<p align="center" valign="bottom"><font size="1">
<?php echo $TabMessGen[8] ?>		 
<?php echo $TabMessGen[3] ?>		 
<?php echo $NomCie ?>
<?php echo $TabMessGen[4] ?>		  
</p>
		 
<script language='javascript'>

  // Si window contains child windows 
if (top.frames.length!=0) {
    if (window.location.href.replace)
        top.location.replace(self.location.href);
    else
        top.location.href=self.document.href;
}


function Sortie() {
	close();
} // Sortie

function pageonload() {
//	window.resizeTo(763, 545);
      document.LoginForm.NomUtilisateur.focus();

<?php
	if( isset($NewMessage) ) {
		echo "window.alert(\"$NewMessage\");";
		unset( $NewMessage );
	};
?>
	 return;
}

addKeyEvent();

</script>
<script language=JavaScript1.2 src="js/blokclick.js"></script>
</body>
</html>
