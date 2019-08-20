<?php
/* Programme : MainFr.php
* Description : Ecran d'ouverture du système de gestion
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-14
*/
include('connect.inc');
 
function decode_session($session_string){
    $current_session = session_encode();
    foreach ($_SESSION as $key => $value){
        unset($_SESSION[$key]);
    }
    session_decode($session_string);
    $restored_session = $_SESSION;
    foreach ($_SESSION as $key => $value){
        unset($_SESSION[$key]);
    }
    session_decode($current_session);
    return $restored_session;
}

 
echo "<html>
	<head>
		<title>Detail SESSION</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
	</head>
<body bgcolor='#FFFFFF' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0'>
	<table width='100%' cellpadding='0' cellspacing='2' border='1' valign=top >
		<tr>
			<td align=left nowrap>";
 	if( isset( $_GET['id']) ) {
 		$_GET['id'] = CleanUp($_GET['id']);
 		$Data = read ($_GET['id']); 
		$Tab = decode_session($Data);
		foreach ($Tab as $key => $value){
        echo $key.' = '.$value.'<br>';
    	}

 /* 		if( $ptr = strtok( $Data, "|" ) ) {
 			do {
 				echo $ptr; // Description
 				$ptr = strtok( ";{" );
 				if( $ptr[0] == 'a' ) { // es-ce un tableau
 					echo '</td></tr>';
 					do {
 						echo '<tr><td align=left nowrap>';
 						$ptr = strtok( ";" );
 						echo $ptr;
 						echo '</td><td  align=left nowrap>';
 						$ptr = strtok( ";" );
 						echo $ptr;
  						echo '</td></tr>';
					} while( !($ptr = strtok( "}" )) );
					echo '<tr><td align=left nowrap>';
  				}
 				else { // Pas un tableau
 					echo '</td><td  align=left nowrap>';
 					echo $ptr.'<br>';
 					echo '</td></tr>';
 					echo '<tr><td align=left nowrap>';
 				}
 			} while( $ptr = strtok( "|" ) );
 				
 		} // Si quelque chose dans Datat
 		else
 			echo 'ID Invalide = '.$_GET['id'];
*/
	} // Si id passé en parametre
	else 
 			echo 'Aucun ID Fourni';
	
	echo '
			</td>
		</tr>
	</table>
</body>
</html>';
 
?>