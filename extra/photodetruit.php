<?php
/* Programme : CodPDetruit.php
* Description : Programme pour effacer un Code de Prix.
*/
include('var_extra.inc');
include('connect.inc');

// l'usager est-il autorisé
if( $_SESSION['auth'] != "yes") {
   	header( "Location: login.php");
   	exit();
}

include("varcie.inc");

function AfficherErreur($texteMsg)
{ 
//   	header( "Location: mainfr.php");
	$script = "<script language=javascript>";
	$script .= "	window.alert(\"$texteMsg\"); ";
	$script .= "	close(); ";
	$script .= "</script>\n";
	echo $script;
	exit();
}

/*echo "
<html>
<head>
<title>Destruction d'une photo</title>
</head>
<body bgcolor='#C0C0FF'>";
echo "La Photo=".@$_GET['no']." #".@$_POST['chximg']." <br>";*/
  
$sql = " DELETE FROM $mysql_base.photo";
$sql .= " WHERE NoInvent='".$_GET['no']."' AND";	
$sql .= " NoPhoto = '".$_POST['chximg']."'";
//echo "Requête : $sql";
$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
       	$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
		AfficherErreur( $Mess );
} // Si pas réussi


/*if( mysql_affected_rows() > 0 )
	AfficherErreur( "Détruit RÉUSSI" );
else
	AfficherErreur( "Détruit INVALIDE" );
	
echo "</body>
</html>";*/

header( "Location: photoput.php?choix=".$_GET['no'] );

?>
</body>
</html>

