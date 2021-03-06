<?php
/* Programme : library_get_lib.php
* Description : Fonction diverse de get 
* Auteur : Denis L�veill� 	 		  Date : 2004-01-01
* MAJ : Denis L�veill� 	 			  Date : 2007-12-21
*/

/**********************************************************************************************
Table des mati�res des functions
___________________________
function get_variab($url_rech=0)
function get_ville_prov( $Quartier, &$TabVille, &$TabProvince)
function get_enums($table, $field)
function get_etat( $service )
function get_Modepaye( $webtrs=0, $webpqt=0, $online=1, $rapport=0 )
function get_IdModepaye( $ModePaye )
function get_Province($Livreur=0)
function get_Livreur_id($id=0)
function get_Livreur($province='')
function get_service( $unite, $online=1 )
function get_unite()
function get_no_service( $str, $langue=0 )
function get_surcharge($Mode)
function get_operation( $priorite=0 )

**********************************************************************************************/
function get_variab($url_rech=0)
//  FUNCTION : get_params - 1a
//  version : 1.0
//  date : 16-11-04
//  derniere modif : Maxime Dupuis
//  info : retourne les param�tres de configuration tels qu'�dit�s par le client
{
global $handle, $database;
		
//	echo "Rech 1 =".$url_rech."<br>";
	if( strlen($url_rech) < 5 ) 
		$url_rech = $_SERVER['HTTP_HOST'];
		
	$sql = "SELECT * FROM $database.variable WHERE url LIKE '%$url_rech%' LIMIT 1;";
	
	$result = mysql_query( $sql, $handle );
	if( !$result ) {
		echo( "Erreur acc�s get_variab : ".mysql_errno()." : ".mysql_error()."<br>".$sql  );	
		exit();
	}		

	if( mysql_num_rows($result) ) {
		$variabs = mysql_fetch_assoc($result);
		mysql_free_result($result);
	}
	else
		$variabs = array();
	
	return $variabs;
} // fin de la fonction : get_params 

function get_ville_prov( $Quartier, &$TabVille, &$TabProvince)
/****************************************************************************
Fonction : get_ville_prov
Sortie : tableau des ville et des province
Description : Cette fonction permet de r�cup�rer les villes et les provinces ou 
					se situe le $Quartier fourni
Auteur : Denis L�veill� 	 		  Date : 2004-01-01
*****************************************************************************/
{
global $handle, $database;

	$Pays = '';
	
	$j = 0;
	$sql = "SELECT Ville FROM $database.quartier WHERE Quartier = '$Quartier'";
	$result = mysql_query( $sql, $handle );
	if( $result == 0 ) {
		echo(mysql_errno()."Get VilleProvince : ".mysql_error().$sql);
	}
	elseif (  mysql_num_rows($result) != 0 ) {
		   for( $i=0; $i < mysql_num_rows($result); $i++ ) {
				$row = mysql_fetch_row($result);
				$TabVille[$i] = $row[0];
				$sql = "SELECT Province, Pays FROM $database.quartier WHERE Ville = '$row[0]'";
				$result2 = mysql_query( $sql, $handle );
				if( ( $result2 != 0 ) && (mysql_num_rows($result2) != 0) ) {
		         	$row = mysql_fetch_row($result2);
				 	 	$TabProvince[$j] = $row[0];
					 	$j++;
				}
	       	$Pays = $row[1];
		   }
	} // Si services existent
	else {
		 unset($TabVille);
		 unset($TabProvince);
	}
	mysql_free_result($result);
	return( $Pays );
} // get_ville_prov

function get_enums($table, $field)
/****************************************************************************
Fonction : get_enums
Entr�e : une cha�ne contenant le nom d'une table, une cha�ne contenant le nom
         d'un champ de type ENUM de la table
Sortie : tableau de cha�ne contenant toutes les possibilit� du champ ENUM
Description : Cette fonction permet de r�cup�rer les diff�rentes possibilit�s
              d'un ENUM
Auteur : Denis L�veill� 	 		  Date : 2004-01-01
	* MAJ : Denis L�veill� 	 		  Date : 2007-01-22
*****************************************************************************/
{
global $handle, $database;
    // on r�cup�re les propri�t�s de la table :
    // chaque ligne repr�sente un champ de la table :
    // les colonnes sont 'Field','Type'...
	$option= array();
	$result=mysql_query("desc $database.$table", $handle  );
	if( $result == 0 ) 
		echo "Probl�me table $table<br>";
	else {
		while( $row = mysql_fetch_array($result) )  {
				// on ne s'int�resse qu'au champ donn� en param�tre
				if( $row['Field'] == $field ) {
					// on r�cup�re les types possible
					// la cha�ne du champ 'Type' est ainsi constitu�e :
					// enum('bleu','vert','marron')
					$option=explode(",", substr($row['Type'], 5, -1));
					for($i=0;$i<sizeof($option);$i++)
					$option[$i] = str_replace("'","",$option[$i]); // suppression des apostrophes pour chaque valeur possible
				} // Row == filed
		} // While
		mysql_free_result($result);
	}
	return($option);
}

function get_etat( $service )
/****************************************************************************
Fonction : get_etat
Sortie : tableau de cha�ne contenant les �tat possibles
Description : Cette fonction permet de r�cup�rer les diff�rentes etat des Services
Auteur : Denis L�veill� 	 		  Date : 2008-01-29
*****************************************************************************/
{
global $handle, $database;

	$Tab = array();
			
	$sql = "SELECT * FROM $database.etattrs";
	
	if( strlen( $service ) )
		$sql .= "  WHERE 'Service' = '$service'; ";
		
	$result = mysql_query( $sql, $handle  );
	if( $result == 0 ) {
	    echo "Probl�me table Etat ".$sql;
	}
	elseif (  mysql_num_rows($result) != 0 ) {
//		   for( $i=0; $i < mysql_num_rows($result); $i++ ) {
//		         $row = mysql_fetch_row($result);
	   	while( $row = mysql_fetch_row($result) ) {
		         switch( $_SESSION['SLangue'] ) {
						case "ENGLISH" :  $Etat = $row[2];
	 		 	 								break;
						case "SPANISH" : 	$Etat = $row[3];
	 	  		 								break;
						default : 			$Etat = $row[1];	 
		         }
		   		 $Tab[$row[0]] = $Etat;
//			   		 $TabUnite[$Service] = $row[10];
		   }
			mysql_free_result($result);
	} // Si services existent
  	return($Tab);
} // get_etat

function get_Modepaye( $webtrs=0, $webpqt=0, $online=1, $rapport=0 )
/****************************************************************************
Fonction : get_Modepaye
Sortie : tableau de cha�ne contenant tout les modes de paiement
Description : Cette fonction permet de r�cup�rer les diff�rents modes de paiement
Auteur : Denis L�veill� 	 		  Date : 2007-03-27
*****************************************************************************/
{
global $handle, $database;

		$Tab = array();
   

		$sql = "SELECT * FROM $database.modepaye WHERE (Mode >= 0)";
		
		if( $online )
			$sql .= " AND ( Online = '$online' )";

		if( $webtrs ) 
				$sql .= " AND ( WebTrs = '$webtrs' )";

		if( $webpqt ) 
				$sql .= " AND ( WebPqt = '$webpqt' ) ";

		if( $rapport ) 
				$sql .= " AND ( Rapport = '$rapport' ) ";
	
//		echo $sql."<br>";
		$result = mysql_query( $sql, $handle );
		if( $result == 0 ) {
		    echo "probl�me table modepaye";
		}
		elseif (  mysql_num_rows($result) != 0 ) {
//			   for( $i=0; $i < mysql_num_rows($result); $i++ ) {
//			         $row = mysql_fetch_row($result);
	   		while( $row = mysql_fetch_row($result) ) {
			         switch( $_SESSION['SLangue'] ) {
							case "ENGLISH" :  $Mode = $row[2];
		 		 	 								break;
							case "FRENCH" : 	$Mode = $row[1];
		 	  		 								break;
							default : 			$Mode = $row[3];	 
			         }
			   		 $Tab[$row[0]] = $Mode;
		//	   		 $TabModPay[$i] = $row[0];
			   }
				mysql_free_result($result);
		} // Si services existent
		return($Tab);
} // get_ModePaye

function get_IdModepaye( $ModePaye )
/****************************************************************************
Fonction : get_IdModepaye
Sortie : 
Description : Cette fonction permet de r�cup�rer les diff�rents modes de paiement
Auteur : Denis L�veill� 	 		  Date : 2007-03-27
*****************************************************************************/
{
global $handle, $database;

		$Id = "";
   
		$sql = " SELECT * FROM $database.modepaye WHERE Mode = '$ModePaye'";

		$result = mysql_query( $sql, $handle );
		if( $result == 0 ) {
		    echo "probl�me table modepaye";
		}
		elseif (  mysql_num_rows($result) != 0 ) {
				$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
				extract($ligne);
	         switch( $_SESSION['SLangue'] ) {
					case "ENGLISH" :  $Id = $en;
 		 	 								break;
					case "SPANISH" : 	$Id = $sp;
 	  		 								break;
					default : 			$Id = $fr;	 
	         }
				mysql_free_result($result);
		} // Si services existent
		return($Id);
} // get_IdModepaye

function get_Province($Livreur=0)
/****************************************************************************
Fonction : get_Province
Sortie : Charge l,ensemble des provinces disponibles
Description : Cette fonction permet de r�cup�rer les diff�rentes province disponible
					Si $Livreur est fourni, elle retourne seulement les province disponible pour
					ce num�ro de livreur
Auteur : Denis L�veill� 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $handle, $database;
	   
   $TabProv = array();	   

	$sql = "SELECT * FROM $database.livreur";
	if( $Livreur ) 
			$sql .= " WHERE NoLivreur = '$Livreur'";
	
	$sql .= " GROUP BY id ORDER BY Province;";
	
   $result = mysql_query( $sql, $handle );
   if( $result != 0 ) {
    if (  mysql_num_rows($result) != 0 ) {
//	   for( $i=0; $i < mysql_num_rows($result); $i++ ) {
	   while( $row = mysql_fetch_row($result) ) {
//var_dump($row);
//echo "<br>";
//exit();
	   		$TabProv[$row[5]] = $row[0];
	   }
	
     } // Si services existent
   } // Si pas erreur
   mysql_free_result($result);
   return($TabProv);
   
} // get_Province

function get_Livreur_id($id=0)
/****************************************************************************
Fonction : get_Livreur_id
Sortie : Le livreur correspondant
Description : Cette fonction permet de r�cup�rer le num�ro du livreur attach� �
					la province identifi� par son code ID
Auteur : Denis L�veill� 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $handle, $database;
	   
	$Liv = 0;
	if( $id ) {
	
	   $sql = "SELECT * FROM $database.livreur WHERE id = '$id'";

	   $result = mysql_query( $sql, $handle );
	   if( $result != 0 ) {
	    if (  mysql_num_rows($result) != 0 ) {
			$row = mysql_fetch_row($result);
		   $Liv = $row[1];
	     } // Si services existent
	   } // Si pas erreur
	   mysql_free_result($result);
	}
   return($Liv);
   
} // get_Livreur_id

function get_Livreur($province='')
/****************************************************************************
Fonction : get_Livreur
Sortie : Num�ro du livreur
Description : Cette fonction permet de r�cup�rer le livreur pour une province par texte
Auteur : Denis L�veill� 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $handle, $database;
	   
	$Liv = 0;
	if( strlen($province) ) {

		$sql = "SELECT * FROM $database.livreur WHERE Province = '$province'";
		$result = mysql_query( $sql, $handle );
		if( $result != 0 ) {
			if (  mysql_num_rows($result) != 0 ) {
				$row = mysql_fetch_row($result);
				$Liv = $row[1];
			} // Si services existent
		} // Si pas erreur
	   
	   mysql_free_result($result);
	}
   return($Liv);
   
} // get_Livreur

function get_service( $unite, $online=1 )
/****************************************************************************
Fonction : get_service
Sortie : tableau de cha�ne contenant tout les Services
Description : Cette fonction permet de r�cup�rer les diff�rents Services
					$online d�fini seulement les services actif pr�sentement
					$unite d�fini les services ARGENT, POID, UNIT�, AUTRES
Auteur : Denis L�veill� 	 		  Date : 2004-01-01
*****************************************************************************/
{
global $handle, $database;

	$Tab = array();
			
	$sql = "SELECT * FROM $database.services";
	
	if( $online )
		$sql .= " WHERE Online = '1'";

	if( strlen( $unite ) )
		if( $online )
			$sql .= " AND Unite = '$unite';";
		else
			$sql .= " WHERE Unite = '$unite';";
		
	$result = mysql_query( $sql, $handle  );
	if( $result == 0 ) {
		echo(mysql_errno()."Get Service : ".mysql_error().$sql);
	}
	elseif (  mysql_num_rows($result) != 0 ) {
//		   for( $i=0; $i < mysql_num_rows($result); $i++ ) {
//		         $row = mysql_fetch_row($result);
	   	while( $row = mysql_fetch_row($result) ) {
		         switch( $_SESSION['SLangue'] ) {
						case "ENGLISH" :  $Service = $row[2];
	 		 	 								break;
						case "FRENCH" : 	$Service = $row[1];
	 	  		 								break;
						default : 			$Service = $row[3];	 
		         }
		   		 $Tab[$row[0]] = $Service;
		   }
			mysql_free_result($result);
	} // Si services existent
  	return($Tab);
} // get_service

function get_unite()
/****************************************************************************
Fonction : get_service
Sortie : tableau de cha�ne contenant tout les unit� de calcul des services
Description : Cette fonction permet de r�cup�rer les diff�rents unit� des servcies Services
					utilis� en parall�le avec la tab service
Auteur : Denis L�veill� 	 		  Date : 2004-01-01
*****************************************************************************/
{
global $handle, $database;

	$Tab = array();
	
	$sql = " SELECT * FROM $database.services";
		
	$result = mysql_query( $sql, $handle  );
	if( $result == 0 ) {
	    echo "probl�me table service";
	}
	elseif (  mysql_num_rows($result) != 0 ) {
	   	while( $row = mysql_fetch_row($result) ) {
	   		 $Tab[$row[0]] = $row[10];
		   }
			mysql_free_result($result);
	} // Si services existent
 	return($Tab);
} // get_unite

function get_no_service( $str, $langue=0 )
/****************************************************************************
Fonction : get_service
Sortie : Le num�ro du service
Description : Cette fonction permet de r�cup�rer unservice � l'aide de son nom
					d�pend de la variable langue pour la chaine fournit
Auteur : Denis L�veill� 	 		  Date : 2004-01-01
*****************************************************************************/
{
global $handle, $database;

	$Tab = array();

	$sql = "SELECT Service FROM $database.services WHERE ";
	if( $langue == 0 )
		$langue = $_SESSION['SLangue'];
   switch( $langue ) {
		case "ENGLISH" :  $sql .= "en = '$str';";
 								break;
		case "FRENCH" : 	$sql .= "fr = '$str';";
 								break;
		default : 			$sql .= "sp = '$str';";	 
   }
		
	$result = mysql_query( $sql, $handle  );
	if( $result == 0 ) {
	    echo "Probl�me table service ".$sql;
	}
	elseif (  mysql_num_rows($result) != 0 ) {
		$row = mysql_fetch_row($result);
		mysql_free_result($result);
		return( $row[0] );
	} // Si services existent
  	return(0);
} // get_no_service

function get_surcharge($Mode)
/****************************************************************************
Fonction : get_surcharge
Sortie : Le montant de la surcharge applicable ou 0 
Description : Cette fonction permet de r�cup�rer la surcharge attribuer � un mode de paiement
					ex. carte de cr�dit surcharge de 3.5% � 4%
Auteur : Denis L�veill� 	 		  Date : 2007-01-26
*****************************************************************************/

{
global $handle, $database;
	   
	// **** CONNECTION AU SERVEUR
  	$Sur = "";	   
   $sql = " SELECT * FROM $database.modepaye WHERE Mode='".$Mode."'";
   $result = mysql_query( $sql, $handle );
   if( $result == 0 ) 
		echo(mysql_errno()."Get Surcharge : ".mysql_error().$sql);
   elseif (  mysql_num_rows($result) != 0 ) {
	         $row = mysql_fetch_row($result);
	   		 $Sur = $row[7];
   } // Si services existent
   mysql_free_result($result);

   return($Sur);
} // get_surcharge

function get_operation( $priorite=0 )
/****************************************************************************
Fonction : get_service
Sortie : tableau de cha�ne contenant tout les Services
Description : Cette fonction permet de r�cup�rer les diff�rents Services
					$online d�fini seulement les services actif pr�sentement
					$unite d�fini les services ARGENT, POID, UNIT�, AUTRES
Auteur : Denis L�veill� 	 		  Date : 2004-01-01
*****************************************************************************/
{
global $handle, $database;

	$Tab = array();
			
	$sql = "SELECT * FROM $database.mcrpoper";
	
	if( $priorite )
		$sql .= " WHERE priorit� >= '$priorite'";

	$result = mysql_query( $sql, $handle  );
	if( $result == 0 ) {
		echo(mysql_errno()."Get Op�ration : ".mysql_error().$sql);
	}
	elseif (  mysql_num_rows($result) != 0 ) {
	   	while( $row = mysql_fetch_row($result) ) {
		         switch( $_SESSION['SLangue'] ) {
						case "ENGLISH" :  $Operation = $row[2];
	 		 	 								break;
						case "FRENCH" : 	$Operation = $row[1];
	 	  		 								break;
						default : 			$Operation = $row[3];	 
		         }
		   		 $Tab[$row[0]] = $Operation;
		   }
			mysql_free_result($result);
	} // Si services existent
  	return($Tab);
} // get_service


?>