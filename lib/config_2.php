<?php
// **********************************************************************************************
include("./extra/var_extra.inc");
include("./extra/varcie.inc");

// **********************************************************************************************
// ***** INCLUSION DES LIBRAIRIES
require_once('library.php');

// **********************************************************************************************
// ***** DEFINITION DE DIFFERENTE VARIABLE DE SESSION
if( !isset($_SESSION['NomLogin']) ) {
	$_SESSION['local'] = true;
	$_SESSION['auth']  = 'N';
	$_SESSION['Prio']  = 10;
	$_SESSION['NoContact'] = 0;
	$_SESSION['NomLogin'] = "WEBUSER";
	$_SESSION['MLeRobot'] = false;
}
$ip = get_ip(); 

// **********************************************************************************************
// ***** DETECTION DE LA LANGUE
if( isset($_GET['langue']) && $_GET['langue'] != "" ) {
//	echo "yes<br>";
    $_SESSION['langue'] = $_GET['langue'];
}
//else

if( !isset($_SESSION['langue']) || !strlen($_SESSION['langue']) ) {
	if( isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ) {
		$langs=explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	   	if( !strncmp ( $langs[0], "en", 2 ) )
			$_SESSION['langue'] = "en";
		else
			$_SESSION['langue']="fr";
	} // Si la variable est disponible
	else
		$_SESSION['langue']="fr";
}


// **********************************************************************************************
// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	$_SESSION['SLangue'] = "ENGLISH";
			break;
	case "sp" : 	$_SESSION['SLangue'] = "SPANISH";
			break;
	default : 	$_SESSION['SLangue'] = "FRENCH";

} // switch SLangue

// **********************************************************************************************
// ***** CHOIX DE LA DEVISE PAR DEFAUT
if( !isset( $_SESSION['devise'] ) )
	$_SESSION['devise'] = "CAD";

// **********************************************************************************************
// ------ CONNEXION A LA BD --
if( !isset($handle) ){
	$i = 10;
	while( !($handle = mysql_connect($mysql_host, $mysql_user, $mysql_pass, true)) ) {
		$i--;
		if( !$i ) break;
		sleep(5);
	}
	if( !$handle ) { 
		$sujet="ERREUR CONNECT BD sur $entr_url"; 
		
		if( empty($HTTP_REFERER)) { 
			$provenance="Pas de lien intermédiaire, connexion directe"; 
		} 
		else { 
			$provenance=$HTTP_REFERER; 
		} 
		$info = "<font size='4'>Une erreur <b>mysql_connect</b> sur $entr_url.</font>
				</td>
			</tr>
			<tr>
				<td>
					Erreur : ".mysql_errno()." = <b>".mysql_error()."</b>
				</td>
			</tr>
			<tr>
				<td>
					Provenance : <b>$provenance</b><br>
					<font size='2'>Page : $SCRIPT_URI</font>
				</td>
			</tr>
			<tr>
				<td>
					Navigateur : <b>$HTTP_USER_AGENT</b><br>
				</td>
			</tr>
			<tr>
				<td>
					Adresse IP : <b>http://$REMOTE_ADDR</b><br>
				</td>
			</tr>
			<tr>
				<td>
					Nom de domaine : <b>".gethostbyaddr($REMOTE_ADDR)."</b>";
					
		AlloWebmaster( $sujet, $info );
		
		// **** Choix de la langue de travail ****
		switch( $_SESSION['langue'] ) {
			case "en" : 	$Mess = sprintf("There seems to have a <i>CONNECT</i> problem to the database %s<br><br>There are probably too many users on the site",$database);
					$Top = "***** ERROR PAGE *****";
					$Action = "Please be patient and try again later.";
					break;
			case "sp" : 	$Mess = sprintf("Parece haber un problema de <i>connect</ i> en la base de datos %s<br><br>Probablemente hay demasiados usuarios en el sitio<br>",$database);
					$Top = "***** ERROR DE PÁGINA *****";
					$Action = "Por favor, tenga paciencia e inténtelo de nuevo más tarde.";
					break;
			default : 	$Mess = sprintf("Il semble y avoir un problème de <i>CONNECT</i> à la base de données %s<br><br>Il y a probablement trop d'usager sur le site<br>",$database);
					$Top = "***** PAGE D'ERREUR *****";
					$Action = "S.V.P. Veuillez patienter et réessayer plus tard.";
					break;
		} // switch SLangue
	
		Message_Erreur( $Top, $Mess, $Action );
		exit();
//		die(mysql_errno()." = ".mysql_error());
	}
	
	if( !mysql_select_db($mysql_base, $handle) ) { 
		// **** Choix de la langue de travail ****
		switch( $_SESSION['langue'] ) {
			case "en" : 	$Mess = sprintf("There seems to have a <i>SELECT</i> problem to the database %s<br><br>There are probably too many users on the site",$database);
					$Top = "***** ERROR PAGE *****";
					$Action = "Please be patient and try again later.";
					break;
			case "sp" : 	$Mess = sprintf("Parece haber un problemade  <i>select</ i> en la base de datos %s<br><br>Probablemente hay demasiados usuarios en el sitio<br>",$database);
					$Top = "***** ERROR DE PÁGINA *****";
					$Action = "Por favor, tenga paciencia e inténtelo de nuevo más tarde.";
					break;
			default : 	$Mess = sprintf("Il semble y avoir un probleme de <i>SELECT</i> sur la base de données de %s<br><br>Il y a probablement trop d'usager sur le site<br>",$database);
					$Top = "***** PAGE D'ERREUR *****";
					$Action = "S.V.P. Veuillez patienter et réessayer plus tard.";
					break;
		} // switch SLangue
	
		Message_Erreur( $Top, $Mess, $Action );
		exit();
	//	or die(mysql_error());
	}
} // Si handle de la bd defini


// **********************************************************************************************
// ***** CHARGEMENT DES PARAMETRES
$param = get_params();
$LargeAchat =  $param['largeur_achat'];
$Large = $param['largeur_affichage'];
$Enligne = $param['alignement'];

$txt = textes($_SESSION['langue']); // messages
$TabMessGen = Langue($_SESSION['langue']);

CheckRobot();

?>