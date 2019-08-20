<?php
include('lib/config.php');

$result=1;
$Image=0;
$TROP_ERREUR_403 = false;

if( !empty($mabd) && isset($_SERVER["REMOTE_ADDR"]) ){
	if( ($Nbr = SauveIP( $ip )) >= 4 ) {
		$TROP_ERREUR_403 = true;
	}
	
}

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
	$direction = sprintf( 'http%s://%s%s', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 's' : ''),$_SERVER['HTTP_HOST'],
	  (isset($_SERVER['REQUEST_URI'])? $_SERVER['REQUEST_URI'] : $_SERVER["SCRIPT_NAME"].'?'.$_SERVER['QUERY_STRING']) );
}


if( $result == 1 ) {
	
	if( empty($_SERVER["HTTP_REFERER"] ))
		$provenance="Pas de lien intermédiaire, connexion directe";
	else
		$provenance=$_SERVER["HTTP_REFERER"] ; 

	
	$info = "<font size='4'>Une erreur 403 s'est produite sur<br>$entr_url.</font>
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
				Session : <b>".session_id()."</b>&nbsp;$Nbr<br>
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
				
	if( !$TROP_ERREUR_403 ) {
		$sujet="ERREUR 403 sur $entr_url"; 
			
		AlloWebmaster( $sujet, $info );
	} // Si moins de trois fois
	elseif($Nbr === 4) {
		$sujet="TROP ERREUR 403 sur $entr_url"; 
					
		AlloWebmaster( $sujet, $info );
	} // else 403
}

?>