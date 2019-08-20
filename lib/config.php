<?php
// **********************************************************************************************
// **********************************************************************************************
if (!defined('DIR_BASE')) 
	define('DIR_BASE', dirname( dirname( __FILE__ ) ) . '/');
//echo "DIRBASE =".DIR_BASE."<br/>";
include_once( DIR_BASE."/lib/var.inc");
include_once( DIR_BASE."/lib/varcie.inc");
/*include_once( DIR_BASE.'/monweb/var/classfilemap.inc' ); 

if ( !isset($SUPRESS_AUTOLOADER) ) {
     require_once(DIR_BASE."/monweb/var/autoloader.inc");
     $_autoloader = unserialize(file_get_contents(DIR_BASE."/monweb/var/classmap.ser")); // $entr_url."/var/classmap.ser"));
     $_autoloader->registerAutoload();
}*/

error_reporting(E_ALL);
ini_set('display_errors', 1);
// **********************************************************************************************
// ***** INCLUSION DES LIBRAIRIES
include('library.inc');


// **********************************************************************************************
// ***** DEFINITION DE DIFFERENTE VARIABLE DE SESSION
if( !isset($_SESSION['NomLogin']) ) {
	$_SESSION['auth']  = 'N';
	$_SESSION['Prio']  = 10;
	$_SESSION['NoContact'] = 0;
	$_SESSION['NomLogin'] = "WEBUSER";
	$_SESSION['MLeRobot'] = false;
	$_SESSION['NoID'] = 0;
	$_SESSION['AUCPT'] = 0;
	$_SESSION['basket'] = array();
}
$ip = get_ip(); 
	
//echo "langue ".$_SESSION['langue']."<br>";
/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
/*	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/

// **********************************************************************************************
// ***** DETECTION DE LA LANGUE

if( isset($_GET['langue']) && $_GET['langue'] != "" ) {
	switch( $_GET['langue'] ) {
		case "English":		$_SESSION['langue'] = "en";
					break;	
		case "Français":			
		default:		$_SESSION['langue'] = "fr";
					break;	
	} // switch
} // Si langue change

if( !isset($_SESSION['langue']) || !strlen($_SESSION['langue']) ) {
	if( isset($_SERVER["HTTP_ACCEPT_LANGUAGE"]) ) {
		$langs=explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
	   	if( !strncmp ( $langs[0], "sp", 2 ) )
			$_SESSION['langue'] = "sp"; 
		elseif(!strncmp ( $langs[0], "en", 2 ))
			$_SESSION['langue'] = "en";
		else
			$_SESSION['langue']="fr";
	} // Si la variable est disponible
	else
		$_SESSION['langue']="fr";
}

//echo 'langue : '.$_SESSION['langue']."<br>";

// **********************************************************************************************
// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	$_SESSION['SLangue'] = "ENGLISH";
			break;
	case "sp" : 	$_SESSION['SLangue'] = "SPANISH";
			break;
	default : 	$_SESSION['SLangue'] = "FRANÇAIS";

} // switch SLangue

// **********************************************************************************************
// ***** CHOIX DE LA DEVISE PAR DEFAUT
if( !isset( $_SESSION['devise'] ) )
	$_SESSION['devise'] = "CAD";
//echo 'devise : '.$_SESSION['devise']."<br>";

// **********************************************************************************************
// ------ CONNEXION A LA BD --
if( !isset($mabd) ){

	$mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
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
					Erreur :  ".mysqli_connect_error()."</b>
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
		$Action = ""; //$info;
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
			default : 	
					$Mess = sprintf("Il semble y avoir un problème de <i>CONNECT</i> à la base de données %s<br><br>Il y a probablement trop d'usager sur le site<br>",$database);
					$Top = "***** PAGE D'ERREUR *****";
					$Action .= " S.V.P. Veuillez patienter et réessayer plus tard.";
					break;
		} // switch SLangue
	
		Message_Erreur( $Top, $Mess, $Action );
		exit();
//		die(mysql_errno()." = ".$mabd->error);
	}
	
	/* Change la base de données en "world" */
	if( !$mabd->select_db($database) ) { 
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
	//	or die($mabd->error);
	}
} // Si handle de la bd defini

//echo "BD Init<br>";

/* Modification du jeu de résultats en utf8 */
if (!$mabd->set_charset("utf8")) {
    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
    exit();
} 


// **********************************************************************************************
// ***** CHARGEMENT DES PARAMETRES
$param = get_params();
//echo "Params Init<br>";

$LargeAchat =  $param['largeur_achat'];
$Large = $param['largeur_affichage'];
$Enligne = $param['alignement'];

$txt = textes($_SESSION['langue']);
//echo "textes Init<br>";

$TabMessGen = Langue($_SESSION['langue']);
//echo "TabMessGen Init<br>";

$TabLangue = array(
	"fr"=>"Français",
	"en"=>"English",
);

//CheckRobot();
?>