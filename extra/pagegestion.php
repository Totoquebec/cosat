<?php
/* Programme : PageGestion.php
* Description : Page principal affichant le menu et la page courante dans des frames
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-19
*/
include('../lib/config.php');

if( isset($_GET['langue']) && $_GET['langue'] != '' ) {
	switch( $_GET['langue'] ) {
		case 'en':	$_SESSION['SLangue'] = 'ENGLISH';
				$_SESSION['langue'] = 'en';
				break;	
		default:	$_SESSION['SLangue'] = 'FRENCH';
				$_SESSION['langue'] = 'fr';	 	
				break;
			
	} // switch
   
}


?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=charset=utf-8"/>
	<meta name="description" content="Page de gestion <?=$NomCie ?>" >
	<title><?=$NomCie ?></title>
	<meta name="Author" content="Denis Léveillé">
<base target='_top'>
</head>

<frameset rows="102,*" framespacing='0' border='0' frameborder='0'>
	<frame name='TOPMENU' src='topmenu.php' scrolling='no' marginwidth=0 marginheight=0 noresize>
	<frame name='MAIN' src="mainfr.php" marginwidth='0' marginheight='0' frameborder='0'>
</frameset>
</html>