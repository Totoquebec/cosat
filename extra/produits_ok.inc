<?php
/* Programme : Produits_Ok.php
* Description : page de confirmation d'ajout de client réussi
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-12
*/
// Début de la session
include('connect.inc');

// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("produits_messen.inc");
							break;
	case "FRENCH":		include("produits_messfr.inc");
							break;
	default:				include("produits_messsp.inc");

} // switch SLangue

?>
<html>
<head>
<title><?php echo $TabId[60] ?></title>
</head>
<?php
 switch( @$_SESSION['SLangue'] ) {
 	case "ENGLISH" : echo
		 	  	    "<Script language=JavaScript1.2 src='javafich/ldmenuen.js'></SCRIPT>";
		 		 	 break;
	case "SPANISH" : echo  
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenusp.js'></SCRIPT>";
		 	  		 break;
		 default : 	 echo  
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenufr.js'></SCRIPT>";

 }
?>
<body bgcolor="#9a8bb4" >
  <script language=JavaScript1.2>mmLoadMenus();</script>
  <base target=MAIN>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   	<td align="center" valign="top">
      	<p style="margin-top: 10pt">
      	<img src="gifs/ordi.gif" alt="Courrier Hermes" height="139" width="191">
         <p align="center" valign="bottom">
		 <font size="+2"><?php echo $TabId[61] ?></font>
		 <font size="+4"><?php echo $NoId ?></font><br>
         </p>
      </td>
   </tr>
   <tr>
   	<td align="center" valign="top">
   	   	<input type="submit" name="Commande" value="<?php echo $TabMessGen[14] ?>" onClick=fermepage()>
      </td>
   </tr>
   <tr>
   	<td align="center" valign="top">
		<div align="center"><font size="-1">
		<?php echo $TabMessGen[1] ?>
		<a href="mailto:<?php echo $AdrCourriel ?>?subject=Page Web <?php echo $NomCie ?>">
		<?php echo $TabMessGen[2] ?></a>
		</font></div>
		<p align="center" valign="bottom"><font size="1">
		<?php echo $TabMessGen[3] ?>		 
		<?php echo $NomCie ?>
		<?php echo $TabMessGen[4] ?>		  
		</p>
      </td>
   </tr>
</table>

<script language='javascript'>

function fermepage() {
	 close();	 
	 open("mainfr.php","_self" );
	 return;
} // pageonload


</script>
</body>
</html>