<?php

// **********************************************************************************************
// ***** DETECTION DES ROBOTS
$ip = get_ip(); 

if( isset($_SESSION['isRobot']) ) { 
	// on s'envoie un mail contenant l'adresse IP du visiteur (il s'agit peut être d'un vrai moteur de recherche) 
	$domaine = @gethostbyaddr($ip) or ($domaine = 'IP non résolue');
	if (isset($_SESSION['isAspi'])) { 
		$sujet = 'Un Aspirateur sur mon site';
		$Type = 'Aspirateur';
		if( !InfoBannie( $ip ) ) {
			$sql =  "INSERT INTO $mysql_base.badbot SET IP='$ip', UserAgent='$HTTP_USER_AGENT', Hote='$domaine', Date = '$Now';";
			$result = mysql_query( $sql, $handle );
		}
	} // Si un aspirateur   
	else {
		$sujet = 'Un Robot sur mon site';
		$Type = 'Robot';
	} // Sinon un simple robot
	           
	$info = "<font size='4'><b>Un $Type a été choppé sur mon site</b><br/><br/>
			Son IP : <b>$ip</b><br/><br/>
			User Agent : <b>$HTTP_USER_AGENT</b><br>
			Domaine : <b>$domaine</b></font>"; 
	
	AlloWebmaster( $sujet, $info );
	// on bloque l'affichage 
	if (isset($_SESSION['isAspi'])) { 
		echo "
		<html>
			<head>
			<title>Hi ! ROBOT !!!!!!</title>
			</head>
			<body>
				<p align='center'>
					<marquee bgcolor='#FFFF00' height='60'>
						<font color='#000000' size='6' face='verdana'>C'EST PAS BEAU LES ASPIRATEURS !!!</font>
					</marquee>
				</p>		
			</body>
		</html>"; 
		exit();
	}

}  // Si Un Robot actif
?>