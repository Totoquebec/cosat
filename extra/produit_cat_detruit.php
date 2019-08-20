<?php
/* Programme : ServiceDetruit.php
* Description : Programme pour effacer un service
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-24
*/
include('connect.inc');

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
<title>Destruction d'un lien catalogue</title>
</head>
<body bgcolor="#B2B2FF">
<?php 
  echo "LeCode=".@$_GET['choix']."<br>"; 
?>
<?php
	
$sql = "DELETE FROM $mysql_base.catalogue_produits WHERE id_catalogue='".@$_GET['choix']."' AND id_produit  = '".@$_GET['NoProd']."'";
echo "Requête : $sql";
$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
       	$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
		AfficherErreur( $Mess );
} // Si pas réussi

	$script = "<script language=javascript>";
	$script .= "	close(); ";
	$script .= "</script>\n";
	echo $script;
	exit();

?>
</body>
</html>

