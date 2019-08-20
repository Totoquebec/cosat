<?php
/* Programme : COLLectionMODIFication.php
* Description : Programme de modification des collection.
*/
include('connect.inc');

//include("actchamps.inc");

function AfficherErreur($texteMsg)
// Fonction pour afficher les erreurs
// Appel le formulaire en initialisant une variable globale - $NewMessage
// Le formulaire affiche un «alert» avec le contenu de cette variable
{ 
//include("actglobal.inc" );
        header( "Location: mainfr.php?Mess=\"$texteMsg\"" ); 
/*	unset($do);
	$NewMessage = $texteMsg;
	unset($EN_AJOUT);
	unset($EN_RECHERCHE);
	unset($EN_CLIENT);
   	$EN_CONSULTE = 1;
	include("textform.inc");*/
	exit();
}

// UPDATE `mfbdf`.`messages` SET `MetaKeyword` = 'blabla' WHERE `messages`.`Langue` = 'fr';


switch( @$_GET['do'] ) {
  case "consulte":  //AfficherErreur( $_POST['Commande'] );
			
			switch( @$_POST['Commande'] ) {
                       	   case "Modifier" : 	/*$sql = " SELECT * FROM $database.messages WHERE Langue = 'fr' ";
						if( $result != 0 && mysql_num_rows($result) != 0 ) {
							$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
    							extract($ligne);
						}
                       	   			extract($_POST,EXTR_OVERWRITE);*/
                       	   			$txt = myAddSlashes($_POST['LeTexte']);
						$sql =  "UPDATE $database.messages SET `messages`.`".$_GET['nomcol']."` = '$txt' WHERE `messages`.`Langue` = 'fr'";
    						//AfficherErreur( $sql );
						$result = mysql_query( $sql,$handle );
						if( $result == 0 ) {
                     			  		$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
	  						AfficherErreur( $Mess );
                                         	}
						//Suivi("Modification Message $No $Titre");
 						$NewMessage = "Modification réussi";
                          default :		break;
   		   	}
  default :  	   	
			header("Location: textlstframe.php");
   		   	break;
}

?>

