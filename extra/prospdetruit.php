<?php
/* Programme : ProspectDetruit.php
* Description : Programme pour effacer un prospect.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
*/
include("var_extra.inc");
// l'usager est-il autorisé
if( @$auth != "yes") {
   	header( "Location: login.php");
   	exit();
}
include("varcie.inc");
// Es-ce que l'usager à la priorité pour accéder cette fonction
if( @$Prio > $PrioDetruit ) {
   	header( "Location: mainfr.php?Mess='Accès Interdit !'");
   	exit();

}

function AfficherErreur($texteMsg)
{ 
	$script = "<script language=javascript>";
	$script .= "	window.alert(\"$texteMsg\"); ";
	$script .= "	close(); ";
	$script .= "</script>\n";
	echo $script;
	exit();
}

echo "
<html>\n
<head>\n
<title>Destruction d'un prospect</title>\n
</head>\n
<body bgcolor='#D8D8FF'>\n";

if( isset($Détruire) ) { 
  echo "LeCode=$choix<br>";
   
// Connection au serveur
  $connection = mysql_connect( $host, $user, $password)
   	or die( "Connection impossible au serveur");
  $db = mysql_select_db( $database, $connection )
    or die("La base de données ne peut être sélectionnée");
	
  $sql = "DELETE FROM contact WHERE NoContact = '$choix'";
  echo "Requête : $sql";
  $result = mysql_query( $sql );
  if( $result == 0 ) {
       	$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
		AfficherErreur( $Mess );
  } // Si pas réussi
  if( mysql_affected_rows() > 0 )
	AfficherErreur( "Détruit RÉUSSI" );
  else
	AfficherErreur( "Détruit INVALIDE" );
  echo "
  </body>\n
  </html>\n
  ";	
}
else {
   	header( "Location: mainfr.php");
}

?>

