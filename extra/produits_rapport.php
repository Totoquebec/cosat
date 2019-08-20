<?php
/* Fichier : PRODUIT_RAPPORT
 * Description : 	Page de support du logiciel qui permet la création l'indexation
 *						La modification des variables du logiciel.
 * Auteur : Denis Léveillé 	 		  Date : 2007-11-19
*/
// Début de la session
include('connect.inc');

?>

<html>
<head>
<title>Page de RAPPORT</title>
</head>
<script language='javascript1.2' src="javafich/mm_menu.js"></script>
<script language='javascript1.2' src="javafich/disablekeys.js"></script>

<?php
 switch( @$_SESSION['SLangue'] ) {
 	case "ENGLISH" : echo
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenuen.js'></SCRIPT>";
		 		 	 break;
	case "SPANISH" : echo  
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenusp.js'></SCRIPT>";
		 	  		 break;
		 default : 	 echo  
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenufr.js'></SCRIPT>";

 }
?>
<body bgcolor="#6666FF" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0">
<script language='JavaScript1.2'>mmLoadMenus();</script>
<base target=MAIN>
<h2 bgcolor="#28CACA" align="center" style="margin-top: 5">PAGE DE RAPPORT PRODUIT</h2>
<p align="center">
This is a prototype page of <?php echo $NomPGM ?>.<br>
Please be CAUTION when using it.<br>
<div align="center">
<p align=center>
<form action="mainfr.php" method="post">
	<input type="button" value="Product List All" onClick='ToutProduitList()'>
	<br><br>
	<input type="button" value="Modify Product Code" onClick='ModifCode()'>
	<br><br>
	<input type="button" value="Load Customer" onClick='LoadCli()'>
	
</form>
</p>
<form action="mainfr.php" method="post">
	<input type="submit" value="Quitter">
</form>
</div>
<br>
	<div align="center"><font size="-1">
	<?php echo $TabMessGen[1] ?>
	<a href="mailto: <?php echo hexentities($AdrWebmestre) ?>?subject=Page Web <?php echo $NomCie ?>"><?php echo $TabMessGen[2] ?></a>
	</font></div>
	<p align="center" valign="bottom"><font size="1">
	<?php echo $TabMessGen[8] ?>		 
	<?php echo $TabMessGen[3] ?>		 
	<?php echo $NomCie ?>
	<?php echo $TabMessGen[4] ?>		  
	</p>
 
<script language="javascript">

function ToutProduitList() {
	open("produit_tot_lst.php","_self",
    "status=no,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no" );
}

function ModifCode() {
	open("change_prod.php","_self",
    "status=no,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no" );
}

function LoadCli() {
	open("client_load.php","_self",
    "status=no,toolbar=no,menubar=no,location=no,scrollbars=yes,resizable=no" );
}

addKeyEvent();

</script>
<script language='JavaScript1.2' src='javafich/blokclick.js'></script>

</body>
</html>

