<?php
/* Programme : ServiceAjout.php
* Description : Programme d'ajout d'un service offert.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-24
*/
include('connect.inc');

	
function AfficherErreur($texteMsg)
{ global $Service, $Descrip, $PrixMin, $Pays, $Def, $TabMessGen;                  

	$NewMessage = $texteMsg;
	unset($EN_CONSULTE);
	$EN_AJOUT = 1;
	include("cat_lstframe.php?NoProd=".$_GET['NoProd']);
	exit();
}


switch( @$_GET['do'] ) {
   case "new"	:  if( isset( $_GET['choix'] ) ) {
 			$sql = "INSERT INTO $mysql_base.catalogue_produits ( id_catalogue , id_produit )";
			$sql .= " VALUES('".$_GET['choix']."', '".$_GET['NoProd']."' )";                  
  
			$result = mysql_query( $sql, $handle );
			if( $result == 0 ) {
				$Mess = $TabMessGen[34].mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			}
                   }
		   $script = "<script language=javascript>";
		   $script .= "	close(); ";
		   $script .= "</script>\n";
		   echo $script;
						
	default :   //echo "Etape 1";exit;
		    header( "Location: cat_lstframe.php?NoProd=".$_GET['NoProd']);
						//include("cat_lstframe.php?NoProd=".$_GET['NoProd']);
   		    break;
}

?>

