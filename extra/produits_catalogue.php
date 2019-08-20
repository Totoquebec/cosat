<?php
//include('lib/config.php');
include('connect.inc');
$Langue = $_SESSION['langue'];
?>
<html>
<head>
<meta http-equiv="Content-Language" content="fr-ca">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Choix Catalogue</title>
</head>
<link title='hermesstyle' href="styles/styleprod.css" type='text/css' rel='stylesheet' />
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
<body bgcolor="#8DFFA0" >
<script language='JavaScript1.2'>mmLoadMenus();</script>
<form method="POST" action="produits_pdf.php" target='_blank' >
<table border="1" width="100%" id="table1">
	<tr>
		<td colspan="3" bgcolor="#26FE5E" align="center">
			<font color="white" size="+1">
		   <b>CATALOGFUE</b></font>
		</td>
	</tr>
	<tr>
		<td>
		<p align="right">LANGUE&nbsp;</td>
		<td>
			<p align="left">
				<label for="fr">Français</label>
					<input type="radio" value="fr" name="Langue" <?php if( $Langue == "fr" ) echo "checked"; ?> id="fr">&nbsp;&nbsp;&nbsp;&nbsp; 
				<label for="en">Anglais</label>
					<input type="radio" value="en" name="Langue" <?php if( $Langue == "en" ) echo "checked"; ?> id="en">&nbsp;&nbsp;&nbsp;&nbsp; 
				<label for="sp">Espagnol</label>
					<input type="radio" value="sp" name="Langue" <?php if( $Langue == "sp" ) echo "checked"; ?> id="sp">
		</td>
	</tr>
	<tr>
		<td>
			<p align="right">TRI DES CATÉGORIE&nbsp;</td>
		<td>
			<p align="cleft">
				<label for="cat_ordre">Ordre</label>
					<input type="radio" name="tri_cat" value="ordre" checked id="cat_ordre">&nbsp;&nbsp;&nbsp; 
				<label for="cat_alpha">Alphabétique</label>
					<input type="radio" name="tri_cat" value="alpha" id="cat_alpha">
		</td>
	</tr>
	<tr>
		<td>
			<p align="right">TRI DES PRODUIT&nbsp;</td>
		<td>
			<p align="left">
				<label for="num">Numéro Inventaire</label>
					<input type="radio" name="prod" value="id" checked id="num">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="code">Code Produit</label>
					<input type="radio" name="prod" value="Code" id="code">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="title">Titre</label>
					<input type="radio" name="prod" value="titre" id="title">
		</td>
	</tr>
	<tr>
		<td>
			<p align="right">STATUS&nbsp;</td>
		<td>
			<p align="left">
				<label for="oui">En Ligne</label>
					<input type="radio" name="status" value="1" checked id="oui">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="non">Pas en ligne</label>
					<input type="radio" name="status" value="0" id="non">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="tous">Tous</label>
					<input type="radio" name="status" value="2" id="tous">
		</td>
	</tr>
	<tr>
		<td>
			<p align="right">IMAGE&nbsp;</td>
		<td>
			<p align="left">
				<label for="im_oui">Avec image</label>
					<input type="radio" name="AvecImage" value="oui"  checked id="im_oui">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="im_non">Sans image</label>
					<input type="radio" name="AvecImage" value="non" id="im_non">
		</td>
	</tr>
	<tr>
		<td>
			<p align="right">MODE DU PFD&nbsp;</td>
		<td>
			<p align="left">
				<label for="affiche">Afficher à l'écran</label>
					<input type="radio" name="pdf_mod" value="I" checked  id="affiche">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="sav_ser">Enregistrer sur le serveur</label>
					<input type="radio" name="pdf_mod" value="F" id="sav_ser">&nbsp;&nbsp;&nbsp;&nbsp;
				<label for="sav_desk">Enregistrer sur l'ordinateur</label>
					<input type="radio" name="pdf_mod" value="D" id="sav_desk">
			</td>
	</tr>
   <tr>
       <td colspan="3" bgcolor="#26FE5E" align="center">
          <font color="white" size="+1">
          TEST
          </font>
       </td>
   </tr>
</table>
<p align="center">
<input type="submit" value="Envoyer" name="B1"></p>
</p>
		</form>
</body>

</html>