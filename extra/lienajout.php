<?php
/* Programme : LiensAjout.php
* Description : Programme d'ajout des liens
*/

//session_start();
include('connect.inc');

if( @$_SESSION['auth'] != "yes") {
   	header( "Location: login.php");
   	exit();
}

if( @$_SESSION['Prio'] > 2 ) {
   	header( "Location: login.php");
   	exit();

}

//include("var.inc");
//include("varcie.inc");

$NomChamps = array(
	 "NoLien"=>"Num�ro idx du lien",
 	 "Description"=>"Description du lien",
 	 "URLLien"=>"Adresse URL du lien",
	 "DateCr��"=>"Date de cr�ation du lien",
	 "Langue"=>"Langue du lien"
);  
	
function AfficherErreur($texteMsg)
{ global $do,$NoLien,$Description,$URLLien,$DateCr��,$Langue;

	$NewMessage = $texteMsg;
	unset($do);
	$EN_AJOUT = 1;
	include("lienform.inc");
	exit();
}

//    "/^[_a-zA-Z0-9-./:]+$/",  // "^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?" // "/^([a-zA-Z0-9_]|\\-|\\.)+$/"
switch( @$_GET['do'] ) {
   case "new": 	extract($_POST,EXTR_OVERWRITE);
   		foreach($_POST as $cl� => $valeur ) {
			switch( $cl� ){
				case "Description" : 	if( !strlen( $valeur ) ||
							    !preg_match("/^[_a-zA-Z0-9- .��������������������������������������������]+$/", 
							    stripslashes( $valeur ) ) ) {
								AfficherErreur( "{$NomChamps[$cl�]} incorrecte ou absente");
						     	}
							break;
				case "URLLien":   	if( !preg_match("/^(?:[;\/?:@&=+$,]|(?:[^\W_]|[-_.!~*\()\[\] ])|(?:%[\da-fA-F]{2}))*$/", stripslashes( $valeur )  ) ) {
								AfficherErreur( "{$NomChamps[$cl�]} incorrecte ou absente. Corrigez $valeur S.V.P.");
							}
							break;
				default :	    	break;
			
			} //switch
		} // for each
                $connection = mysql_connect( $host, $user, $password)
  		  		or die( "Connection impossible au serveur");

                $db = mysql_select_db( $database, $connection )
                  	or die("La base de donn�es ne peut �tre s�lectionn�e");

		$DateCr�� = date("Y-m-d");
		$data = myAddSlashes($Description);
		$sql = "INSERT INTO $database.pgliens
				( Type, Description, URLLien, Target, DateCr��, Langue ) VALUES
				('$Type', '$data', '$URLLien', '$Target', '$DateCr��', '$Langue')";                  
                if( !mysql_query($sql) ) {
                	$Mess ="ERREUR : ".mysql_errno()." : ".mysql_error();
                     	AfficherErreur( $Mess );
		}
		$No = mysql_insert_id();
		$NoLien = $Description = $URLLien = "";
		$Langue = "FRAN�AIS";
		$DateCr�� = date("Y-m-d");
		$data = "Lien ".$No." ajout� avec succ�s ";
		AfficherErreur( $data );
		break;
  default :	$NoLien = $Description = $URLLien = "";
		$Langue = "FRAN�AIS";
		$DateCr�� = date("Y-m-d");
                $EN_AJOUT = 1;
   		include( "lienform.inc");
   		break;
}

?>

