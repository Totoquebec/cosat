<?php
/* Programme : COLLectionCONSULTation.php
* Description : Programme de consultation des collections
*/
include('connect.inc');

$sql = " SELECT * FROM $database.messages WHERE Langue = 'fr' ";
$result = mysql_query( $sql, $handle );
if( $result != 0 && mysql_num_rows($result) != 0 ) {
	$row = mysql_fetch_row($result);
}
else {
	 header( "Location: mainfr.php?Mess=\"ERREUR-Message_introuvable\"" );
	exit();
}

  unset($EN_AJOUT);
  unset($EN_RECHERCHE );
  unset($EN_CLIENT);
  $EN_CONSULTE = 1;
  include( "textform.inc");


?>

