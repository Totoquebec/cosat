<?php
include('connect.inc');

// Es-ce que l'usager à la priorité pour accéder cette fonction
if( @$_SESSION['Prio'] > $PrioModif ){
	header( "Location: mainfr.php");
	exit();
} // Si pas access autorisé


echo "
	<html>
	<head>
		<title>$TabMessGen[69]</title>
	<link title='hermesstyle' href='styles/stylegen.css' type='text/css rel=stylesheet'>
	</head>
	<script language='javascript1.2' src='javafich/mm_menu.js'></script>";
//	<script language='javascript1.2' src='javafich/disablekeys.js'></script>
//	<script language='javascript1.2' src='javafich/blokclick.js'></script>";
//	<script language='JavaScript1.2'>addKeyEvent();</script>
	 switch( $_SESSION['SLangue'] ) {
	 	case "ENGLISH" : echo
			 	  	    "<script language='javascript1.2' src='javafich/ldmenuen.js'></script>\r\n";
			 		 	 break;
		case "SPANISH" : echo  
			 	  	    "<script language='javascript1.2' src='javafich/ldmenusp.js'></script>\r\n";
			 	  		 break;
			 default : 	 echo  
			 	  	    "<script language='javascript1.2' src='javafich/ldmenufr.js'></script>\r\n";
	
	 }
	echo "
	<body bgcolor='#D8D8FF'>
	<script language='JavaScript1.2'>mmLoadMenus();</script>";
//	<Center>'.$TabMessGen[366].'</center>
echo '
	<table border="1" width="99%" height="98%" id="table1" align="center">
	<tr>
		<td colspan="2" height="6%">
		<Center>'.$TabMessGen[366].'</center>
			<iframe name="traducteur" src="text_trad_google.php" width="0" height="0">
				Votre navigateur ne prend pas en charge les cadres insérés ou est actuellement configuré pour ne pas les afficher.
			</iframe>
		
		</td>
	</tr>	
	<tr>
		<td width="30%">
			<iframe name="text_choix" src="text_choix.php" height="100%" align="center" marginwidth=1 marginheight=1 border=0 frameborder=0>
				Votre navigateur ne prend pas en charge les cadres insérés ou est actuellement configuré pour ne pas les afficher.
			</iframe>
		</td>
		<td width="70%">
			<iframe name="text_form" src="text_form.php" width="100%" height="100%" align="center" marginwidth=1 marginheight=1 border=0 frameborder=0>
				Votre navigateur ne prend pas en charge les cadres insérés ou est actuellement configuré pour ne pas les afficher.
			</iframe>
		</td>
	</tr>

</table>';
?>
</body>
</html>