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
	 "NoLien"=>"Numéro idx du lien",
 	 "Description"=>"Description du lien",
 	 "URLLien"=>"Adresse URL du lien",
	 "DateCréé"=>"Date de création du lien",
	 "Langue"=>"Langue du lien"
);  
	
function AfficherErreur($texteMsg)
{ global $do,$NoLien,$Description,$URLLien,$DateCréé,$Langue;

	$NewMessage = $texteMsg;
	unset($do);
	$EN_AJOUT = 1;
	include("lienform.inc");
	exit();
}

//    "/^[_a-zA-Z0-9-./:]+$/",  // "^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?" // "/^([a-zA-Z0-9_]|\\-|\\.)+$/"
switch( @$_GET['do'] ) {
   case "new": 	extract($_POST,EXTR_OVERWRITE);
   		foreach($_POST as $clé => $valeur ) {
			switch( $clé ){
				case "Description" : 	if( !strlen( $valeur ) ||
							    !preg_match("/^[_a-zA-Z0-9- .ÉÈËÀÂÎÏÔÙÜÁÃÅÆÌÍÕÓÒÑçÇéèêëàâîïôùüáãåæìíðñòóõ]+$/", 
							    stripslashes( $valeur ) ) ) {
								AfficherErreur( "{$NomChamps[$clé]} incorrecte ou absente");
						     	}
							break;
				case "URLLien":   	if( !preg_match("/^(?:[;\/?:@&=+$,]|(?:[^\W_]|[-_.!~*\()\[\] ])|(?:%[\da-fA-F]{2}))*$/", stripslashes( $valeur )  ) ) {
								AfficherErreur( "{$NomChamps[$clé]} incorrecte ou absente. Corrigez $valeur S.V.P.");
							}
							break;
				default :	    	break;
			
			} //switch
		} // for each
                $connection = mysql_connect( $host, $user, $password)
  		  		or die( "Connection impossible au serveur");

                $db = mysql_select_db( $database, $connection )
                  	or die("La base de données ne peut être sélectionnée");

		$DateCréé = date("Y-m-d");
		$data = myAddSlashes($Description);
		$sql = "INSERT INTO $database.pgliens
				( Type, Description, URLLien, Target, DateCréé, Langue ) VALUES
				('$Type', '$data', '$URLLien', '$Target', '$DateCréé', '$Langue')";                  
                if( !mysql_query($sql) ) {
                	$Mess ="ERREUR : ".mysql_errno()." : ".mysql_error();
                     	AfficherErreur( $Mess );
		}
		$No = mysql_insert_id();
		$NoLien = $Description = $URLLien = "";
		$Langue = "FRANÇAIS";
		$DateCréé = date("Y-m-d");
		$data = "Lien ".$No." ajouté avec succès ";
		AfficherErreur( $data );
		break;
  default :	$NoLien = $Description = $URLLien = "";
		$Langue = "FRANÇAIS";
		$DateCréé = date("Y-m-d");
                $EN_AJOUT = 1;
   		include( "lienform.inc");
   		break;
}

?>

