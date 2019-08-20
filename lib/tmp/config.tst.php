<?php
include("./extra/var_extra.inc");
echo "host : ".$host."<br>";
include("./extra/varcie.inc");
echo "Cie : ".$NomCie."<br>";

echo $entr_path."<br>".$entr_url."<br>".$entr_www."<br>";
// **********************************************************************************************
// defenir certain service et mode de paiement
//$_SERVICE_ACHAT = 7;
//$_PAIEMENT_CHEQUE = 3;

// **********************************************************************************************
// ***** INCLUSION DES LIBRAIRIES
require_once('library.php');

// **********************************************************************************************
// ***** DEFINITION DE DIFFERENTE VARIABLE DE SESSION
if( !isset($_SESSION['NomLogin']) ) {
	session_register('local');
	session_register('auth'); 
	session_register('NomLogin');
	session_register('Prio');
	session_register('NoContact');
	session_register('SLangue');
	$_SESSION['NomLogin'] = "WEBUSER";
}
echo "Avant IP : <br>";
$ip = get_ip(); 
	
echo "IP : ".$ip."<br>";

// **********************************************************************************************
// ***** DETECTION DE LA LANGUE
if( isset($_GET['langue']) && $_GET['langue'] != "" )
    $_SESSION['langue'] = $_GET['langue'];
elseif( !isset($_SESSION['langue']) || $_SESSION['langue'] == "" ) {
	if( isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ) {
		$langs=explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	   if( !strncmp ( $langs[0], "fr", 2 ) )
			$_SESSION['langue'] = "fr"; 
		elseif(!strncmp ( $langs[0], "en", 2 ))
			$_SESSION['langue'] = "en";
		else
			$_SESSION['langue']="sp";
	} // Si la variable est disponible
}

// **********************************************************************************************
// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	$_SESSION['SLangue'] = "ENGLISH";
						break;
	case "fr" : 	$_SESSION['SLangue'] = "FRENCH";
						break;
	default : 	$_SESSION['SLangue'] = "SPANISH";

} // switch SLangue

echo "Langue : ".$_SESSION['SLangue']."<br>";

// **********************************************************************************************
// ***** CHOIX DE LA DEVISE PAR DEFAUT
if( !isset( $_SESSION['devise'] ) )
	$_SESSION['devise'] = "CAD";

echo "Devise : ".$_SESSION['devise']."<br>";

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
			case "en" : 	$Mess = sprintf("There seems to have a <i>CONNECT</i> problem to the database %s<br><br>There are probably too many users on the site",$mysql_base);
								$Top = "***** ERROR PAGE *****";
								$Action = "Please be patient and try again later.";
								break;
			case "fr" : 	$Mess = sprintf("Il semble y avoir un problème de <i>CONNECT</i> à la base de données %s<br><br>Il y a probablement trop d'usager sur le site<br>",$mysql_base);
								$Top = "***** PAGE D'ERREUR *****";
								$Action = "S.V.P. Veuillez patienter et réessayer plus tard.";
								break;
			default : 		$Mess = sprintf("Parece haber un problema de <i>connect</ i> en la base de datos %s<br><br>Probablemente hay demasiados usuarios en el sitio<br>",$mysql_base);
								$Top = "***** ERROR DE PÁGINA *****";
								$Action = "Por favor, tenga paciencia e inténtelo de nuevo más tarde.";
		
		} // switch SLangue
	
		Message_Erreur( $Top, $Mess, $Action );
		exit();
//		die(mysql_errno()." = ".mysql_error());
	}
	
	if( !mysql_select_db($mysql_base, $handle) ) { 
		// **** Choix de la langue de travail ****
		switch( $_SESSION['langue'] ) {
			case "en" : 	$Mess = sprintf("There seems to have a <i>SELECT</i> problem to the database %s<br><br>There are probably too many users on the site",$mysql_base);
								$Top = "***** ERROR PAGE *****";
								$Action = "Please be patient and try again later.";
								break;
			case "fr" : 	$Mess = sprintf("Il semble y avoir un probleme de <i>SELECT</i> sur la base de données de %s<br><br>Il y a probablement trop d'usager sur le site<br>",$mysql_base);
								$Top = "***** PAGE D'ERREUR *****";
								$Action = "S.V.P. Veuillez patienter et réessayer plus tard.";
								break;
			default : 		$Mess = sprintf("Parece haber un problemade  <i>select</ i> en la base de datos %s<br><br>Probablemente hay demasiados usuarios en el sitio<br>",$mysql_base);
								$Top = "***** ERROR DE PÁGINA *****";
								$Action = "Por favor, tenga paciencia e inténtelo de nuevo más tarde.";
		
		} // switch SLangue
	
		Message_Erreur( $Top, $Mess, $Action );
		exit();
	//	or die(mysql_error());
	}
} // Si handle de la bd defini


// **********************************************************************************************
// ***** CHARGEMENT DES PARAMETRES
/*$__PARAMS = get_params();
$LargeAchat =  $__PARAMS['largeur_achat'];
$Large = $__PARAMS['largeur_affichage'];
$Enligne = $__PARAMS['alignement'];

if( !isset($_SESSION['panier']) ) {
		$_SESSION['panier'] = array();
		$_SESSION['province'] = 2;
}

$param = &$__PARAMS;
$txt = textes($_SESSION['langue']);

CheckRobot();*/

?>