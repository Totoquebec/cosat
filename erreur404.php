<?php
include('lib/config.php');

$result=1;
$Image=0;

if( !empty($mabd) && isset($_SERVER["REMOTE_ADDR"]) ){
	if( ($Nbr = SauveIP( $ip )) >= 4 ) {
		$_SESSION['isRobot'] = true;  
		$_SESSION['isAspi'] = 4;  
		CheckRobot();
		// un retour vers le site  
		header('Location: index.php'); 
	}
	
}

if (isset($_SERVER['SCRIPT_URI']) && preg_match('|^http|',$_SERVER['SCRIPT_URI'])) {
	$direction = $_SERVER['SCRIPT_URI'];
	if (preg_match("'images'", $_SERVER['SCRIPT_URI'])) 
		$Image = 1;
	if (preg_match("'produit_big_picture'", $_SERVER['SCRIPT_URI'])) 
		$Image = 1;
}
else {
	/**
	* $_SERVER['SCRIPT_URI'] seems to be unavilable in some PHP
	* installs, and $_SERVER['REQUEST_URI'] and $_SERVER['PHP_SELF']
	* have been known to sometimes have the same issue.
	* Thanks to Todd Beverly for helping out with this one. :)
	* @see http://wordpress.org/support/topic/129814?replies=27#post-605423
	*/
	$direction = sprintf( 'http%s://%s%s', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : ''),$_SERVER['HTTP_HOST'],
	  (isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI'] : $_SERVER["SCRIPT_NAME"].'?'.$_SERVER['QUERY_STRING']) );
}


if( ($result == 1) && !$Image ) {
	$sujet="ERREUR 404 sur $entr_url"; 
	
	if( empty($_SERVER["HTTP_REFERER"] ))
		$provenance="Pas de lien intermédiaire, connexion directe";
	else
		$provenance=$_SERVER["HTTP_REFERER"] ; 

//*				Session : <b>".session_id()."</b>&nbsp;$Nbr<br>
	
	$info = "<font size='4'>Une erreur 404 s'est produite sur<br>$entr_url.</font>
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
    			Type de requête : ".@$REQUEST_METHOD."
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

}


echo
"<html>
	<head>
		<title>$NomCie - $TelCie</title>
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<meta name='robots' content='noindex,nofollow'>
		<link href='$entr_url/css/style.css' rel='stylesheet' type='text/css'>
	</head>
<body STYLE='topmargin=16px' >
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='4' cellspacing='0' align='center' border='1' >		
		<tr>
			<td>
				<p align='center'><font size='5'><b><em>".$TabMessGen[202]." 404</em></b></font></p>";
echo 			"<p align='center'><font size='3' color='#FF0000'>".$TabMessGen[404]."</strong></font><br>
				<u><font color='#0000FF'><a href='".$entr_url."' target='_self'>
				".$entr_url."/</a></font></u></p>";
echo 			"<p align='center'><strong><font size='2'>".
				$TabMessGen[1404]." : $direction
				</font></strong></p>
				<p align='center'><strong><a href='javascript:history.back()'>".$TabMessGen[203]."</a></strong></p><br>
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