<?php
/*
Codes Traduction 
200 Correct 
202 Correct 
301 Déplacé définitivement 
302 Déplacé temporairement 
400 Mauvaise requête 
401 Non autorisé 
402 Accès payant 
403 Interdit 
404 Introuvable 
405 Méthode non supportée 
407 Authentification proxy exigée 
408 Lenteur du réseau 
409 Conflit 
500 Erreur du serveur 
501 Programme absent 
502 Mauvaise passerelle 
503 Service indisponible 
504 La passerelle met trop de temps à répondre 
505 Version HTTP non reconnue 
*/

include('lib/config.php');

$result=1;
$erreur = CleanUp($_GET['id']);

if( $erreur == 403 ) {
	if( isset($handle) && isset($_SERVER["REMOTE_ADDR"]) ){
		if( ($Nbr = SauveIP( $ip )) >= 4 ) {
			$TROP_ERREUR_403 = true;
		}
		
	}
} // si un 403
else
	$TROP_ERREUR_403 = false;

if (isset($_SERVER['SCRIPT_URI']) && preg_match('|^http|',$_SERVER['SCRIPT_URI'])) {
	$direction = $_SERVER['SCRIPT_URI'];
}
else {
	/**
	* $_SERVER['SCRIPT_URI'] seems to be unavilable in some PHP
	* installs, and $_SERVER['REQUEST_URI'] and $_SERVER['PHP_SELF']
	* have been known to sometimes have the same issue.
	* Thanks to Todd Beverly for helping out with this one. :)
	* @see http://wordpress.org/support/topic/129814?replies=27#post-605423
	*/
	$direction = sprintf( 'http%s://%s%s',(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : ''),$_SERVER['HTTP_HOST'],
	  (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI']: $_SERVER["SCRIPT_NAME"].'?'.$_SERVER['QUERY_STRING']) );
}

if( $result == 1 ) {
	if( !$TROP_ERREUR_403 ) {
		
		if( empty($_SERVER["HTTP_REFERER"] ))
			$provenance="Pas de lien intermédiaire, connexion directe";
		else
			$provenance=$_SERVER["HTTP_REFERER"] ; 
	 
		$info = "<font size='4'>Une erreur $erreur s'est produite sur le site<br>$entr_url.</font>
				</td>
			</tr>
			<tr>
				<td>
					Provenance : <b>$provenance</b><br>
					<font size='2'>Page : $direction</font><br>
					<font size='2'>URI : ".$_SERVER["REQUEST_URI"]."</font>
				</td>
			</tr>
			<tr>
				<td>
					Navigateur : <b>".$_SERVER["HTTP_USER_AGENT"]."</b><br>
				</td>
			</tr>
			<tr>
				<td>
					Session : <b>".session_id()."</b><br>
				</td>
			</tr>
			<tr>
				<td>
					Adresse IP : <b><a href='http://whois.domaintools.com/".$_SERVER["REMOTE_ADDR"]."'>".$_SERVER["REMOTE_ADDR"]."</a></b><br>
				</td>
			</tr>
			<tr>
				<td>
					Nom de domaine : <b>".gethostbyaddr($_SERVER["REMOTE_ADDR"])."</b>";
					
		AlloWebmaster( $sujet, $info );
	} // Si moins de trois fois
	
}

echo
"<html>
	<head>
		<title>Cosat Informatique - (450) 530-3353</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='robots' content='noindex,nofollow'>
		<link href='$entr_url/css/style.css' rel='stylesheet' type='text/css'>
	</head>
<body STYLE='topmargin=16px' >
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='4' cellspacing='0' align='center' border='1' >		
		<tr>
			<td>
				<p align='center'><font size='5'><b><em>".$TabMessGen[202]." $erreur</em></b></font></p>";
echo 			"<p align='center'><font size='3' color='#FF0000'>".$TabMessGen[$erreur]."</strong></font><br>
				<u><font color='#0000FF'><a href='".$entr_url."' target='_self'>".$entr_url."/</a></font></u></p>";
echo 			"<p align='center'><strong><font size='2'>".
				$TabMessGen[$erreur+1000]." : $direction
				</font></strong></p>
				
			</td>
	  	</tr>
		<tr>
			<td>
				Date : $Now
			</td>
	  	</tr>
	</table>
</body>
</html>";
?>