<?php
/* Programme : Erreur.inc
* Description : Ecran permettant d'indiqué qu'une erreur est survenur
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
*/
include("varcie.inc");
 switch( @$_SESSION['SLangue'] ) {
 		 case "ENGLISH" : include("varmessen.inc");
		 		 	 break;
		 case "ENGLISH" : include("varmesssp.inc");
		 	  		 break;
		 default : 	 include("varmessfr.inc");

 }
?>
<html>
<head>
<title><?php echo $TabMessGen[12] ?></title>
</head>
<SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
<SCRIPT language=JavaScript1.2 src='javafich/mm_menu.js'></SCRIPT>
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

<body bgcolor="#0DC4C4" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:pageonload()">
  <SCRIPT language=JavaScript1.2>mmLoadMenus();</SCRIPT>
  <BASE TARGET=MAIN>
  <table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
   	<td align="center" valign="top">
      	<p style="margin-top: 10pt">
      	<img src="gifs/courrier.gif" alt="Courrier Hermes" height="139" width="191">
         <p align="center" valign="bottom"><font size="+2">
         <?php echo $TabMessGen[13] ?></font><br>
		 </p>
      </td>
   </tr>
   <tr>
   	<td align="center" valign="top">
   	   	<input type="button" name="Commande" value="<?php echo $TabMessGen[14] ?>" onClick='QuitterPage()'><br>
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
		<?php echo $TabMessGen[8] ?>		 
		<?php echo $TabMessGen[3] ?>		 
		<?php echo $NomCie ?>
		<?php echo $TabMessGen[4] ?>		  
		</p>
      </td>
   </tr>
  </table>

<SCRIPT LANGUAGE="javascript">
		function QuitterPage() {
              close();
		  	  open("mainfr.php","_self" );
		} // QuitterPage

		 function pageonload() {
	<?php
		 	if( isset($NewMessage) ) {
		  	  	  echo "window.alert(\"$NewMessage\");";
          	 	  unset( $NewMessage );
         	};
     ?>
	       return;
	 	 } // pageonload
		 
		 addKeyEvent();

</SCRIPT>
<SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT>
</body>
</html>
