<?php
//$host="localhost";
//$user="root";
//$password="";
$database="cosat";

// Configuration MySQL
$mysql_host = "localhost";  // laisser à localhost par défaut
$mysql_user = "root";  // le nom d'usager
$mysql_pass = "";  // son mot de passe
//$mysql_base = "cosat";  // le nom de la base de données

   // Début de la session
require_once(DIR_BASE."/lib/sessionsave.inc");
/***********************************************************************
// DEBUT  - Code en cas de probleme

$acces_hermes = $_SERVER["DOCUMENT_ROOT"]."/cosat/extra";

function destroy ($id) {  

   return(1); 

} // destroy

$time = 3600;
session_set_cookie_params($time);

session_start();
// FIN  - Code en cas de probleme
***********************************************************************/

$_SESSION['local'] = 1;
$HTTP_USER_AGENT = 'Toto/69.0 (compatible; MSIE 6.0; http://tc-n2n.com)';
// Désactiver le rapport d'erreurs 
error_reporting(E_ALL ^ E_DEPRECATED);
?>