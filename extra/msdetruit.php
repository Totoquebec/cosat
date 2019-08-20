<?php
/* Programme : MCRPDetruit.php
* Description : Programme pour effacer un compte-client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
*/
include('connect.inc');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("msmessen.inc");
			break;
	case "SPANISH":	include("msmesssp.inc");
			break;
	default:	include("msmessfr.inc");
} // switch SLangue


function AfficherErreur($texteMsg)
{ 
	$script = "<script language=javascript>";
	$script .= "	window.alert(\"$texteMsg\"); ";
	$script .= "	close(); ";
	$script .= "</script>\n";
	echo $script;
	exit();
}

?>
<html>
<head>
<title>Destruction Compte-client</title>
</head>
<body bgcolor="#C0C0FF">
<?php 
  echo "NomUsg=".@$_POST['choix']."<br>"; 
  if( $_POST['choix'] == 'oper' )
	AfficherErreur( "Cet usager ne peut être détruit !" );
?>
<?php
$sql = "DELETE FROM $database.secur WHERE NomLogin = '".@$_POST['choix']."'";
echo "Requête : $sql";
$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
      $Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
		AfficherErreur( $Mess );
} // Si pas réussi
if( mysql_affected_rows() > 0 )
	AfficherErreur( "Détruit RÉUSSI" );
else
	AfficherErreur( "Détruit INVALIDE" );

?>
</body>
</html>

