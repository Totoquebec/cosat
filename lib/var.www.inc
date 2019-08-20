<?php
$host="localhost";
$database="cosatbi_cosat";
$user="cosatbi_siteweb";
$password="3965berri";

// Configuration MySQL
$mysql_host = "localhost";  // laisser à localhost par défaut
$mysql_base = "cosatbi_cosat";  // le nom de la base de données
$mysql_user = "cosatbi_siteweb";  // le nom d'usager
$mysql_pass = "3965berri";  // son mot de passe 

//if( isset( $_GET['sid'] ) ) { 
//	session_id($_GET['sid']);
//} 

// Début de la session
require_once("sessionsave.inc");

/***********************************************************************
// DEBUT  - Code en cas de probleme

$acces_hermes = "http://www.antillas-express.com/extra";

function destroy ($id) {  

   return(1); 

} // destroy

$time = 3600;
session_set_cookie_params($time);

session_start();
// FIN  - Code en cas de probleme
***********************************************************************/

$_SESSION['local'] = 0;
// Désactiver le rapport d'erreurs 
error_reporting(0);
//error_reporting(E_ALL );


?>