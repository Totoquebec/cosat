<?php
/* Programme : ProspectDetruit.php
* Description : Programme pour effacer un prospect.
* Auteur : Denis L�veill� 	 		  Date : 2004-01-01
*/
include("var_extra.inc");
// l'usager est-il autoris�
if( @$auth != "yes") {
   	header( "Location: login.php");
   	exit();
}
include("varcie.inc");
// Es-ce que l'usager � la priorit� pour acc�der cette fonction
if( @$Prio > $PrioDetruit ) {
   	header( "Location: mainfr.php?Mess='Acc�s Interdit !'");
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

if( isset($D�truire) ) { 
  echo "LeCode=$choix<br>";
   
// Connection au serveur
  $connection = mysql_connect( $host, $user, $password)
   	or die( "Connection impossible au serveur");
  $db = mysql_select_db( $database, $connection )
    or die("La base de donn�es ne peut �tre s�lectionn�e");
	
  $sql = "DELETE FROM contact WHERE NoContact = '$choix'";
  echo "Requ�te : $sql";
  $result = mysql_query( $sql );
  if( $result == 0 ) {
       	$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
		AfficherErreur( $Mess );
  } // Si pas r�ussi
  if( mysql_affected_rows() > 0 )
	AfficherErreur( "D�truit R�USSI" );
  else
	AfficherErreur( "D�truit INVALIDE" );
  echo "
  </body>\n
  </html>\n
  ";	
}
else {
   	header( "Location: mainfr.php");
}

?>

