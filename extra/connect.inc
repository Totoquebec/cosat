<?php
include('var_extra.inc');
// Inclusion des variables
include("varcie.inc");

// l'usager est-il autorisé
if( @$_SESSION['auth'] != "yes" && !isset($InLog) ) {
      // Non. alors n'a pas utilisé le chemin du login
  		header( "Location: login.php?log=out");
		exit();
}

//	$script = "<script language=javascript>";
//	$script .= "	window.alert(\"Session EXPIRÉE\"); ";
//	$script .= "	close(); ";
//	$script .= "</script>\n";

// ------ CONNEXION A LA BD --
if( !isset($handle) ){
	$handle = mysql_connect($mysql_host, $mysql_user, $mysql_pass, true) 
		or die(mysql_errno().":".mysql_error());
	mysql_select_db($mysql_base, $handle) 
		or die(mysql_error());
} // Si handle de la bd defini

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	$_SESSION['langue'] = 'en';
			break;
/*	case "SPANISH":	$_SESSION['langue'] = 'sp';
			break;*/
	default:	$_SESSION['langue'] = 'fr';

} // switch SLangue

// **** Choix de la langue de travail ****
 switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH" :include("varmessen.inc");
	 		break;
/*	case "SPANISH"  :include("varmesssp.inc");
	 	  	break;*/
	default : 	include("varmessfr.inc");

 } // switch SLangue

// **********************************************************************************************
// ***** INCLUSION DES LIBRAIRIES
require_once('../lib/library_general_lib.inc');
require_once('../lib/library_monnaie_lib.inc');
require_once('../lib/library_general_divers.inc');
require_once('../lib/library_general_insert.inc');
require_once('../lib/library_general_select.inc');
require_once('../lib/library_general_update.inc');
require_once('../lib/library_get_lib.inc');
$ip = get_ip(); 

$txt = textes($_SESSION['langue']);
$TabMessGen = Langue($_SESSION['langue']);

// **********************************************************************************************
// ***** CHARGEMENT DES PARAMETRES
$param = get_params();
$LargeAchat =  $param['largeur_achat'];
$Large = $param['largeur_affichage'];
$Enligne = $param['alignement'];
$_SESSION['devise'] = 'CAD';

?>