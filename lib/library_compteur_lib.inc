<?php
/* Programme : library_transid_lib.php
* Description : Fonction pour géré les doubles cliques.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
*/

/******************************************************* 
 * ATTENTION - Vous devrez implémenter un
 * 
 * collecteur de données obosolètes ici. 
 * 
 *******************************************************/
 
function GC_TransId( ) {
global $handle,$database;

  $TropVieux = time() - (1 * 60 * 60); // Disons 2 heures
  $sql = "DELETE FROM $database.checkid WHERE Date_Cree < '$TropVieux'";
  $result = mysql_query( $sql, $handle );
  if( $result == 0 ) {
       	$Mess ="ERREUR DESTROY : ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
		return(false);
   }
   else {    
   		return(true);  
   }
 
} // GC_TransId 

function Chk_TransId( $id ) {  
global $handle,$database;
	$Ret = 0; // Doit retourner 0 ici.  

	if( $id ) {
		$sql = "SELECT COUNT(transid) FROM $database.checkid WHERE transid = '$id'";
		$result = mysql_query( $sql, $handle );
		if( $result == 0 ) {
		    $Mess = "ERREUR READ".mysql_errno().": ".mysql_error();
			echo "<SCRIPT LANGUAGE='javascript'>";
			echo " window.alert(\"$Mess\"); ";
			echo "</SCRIPT>";
		}
		elseif (  mysql_num_rows($result) != 0 ) {
			 $row = mysql_fetch_row($result);
		 	 $Ret = $row[0];  
		   } // Si de sinfo
	}
	GC_TransId( );
 	return($Ret);
} // Chk_Id

function Aj_TransId ($id) {  
global $handle,$database;

	if( !$id ) return(false);

  $Cree = time();
  $sql = "INSERT INTO $database.checkid ( transid, Usager, IP_Addr, Date_Cree) VALUES
           ( '$id','".$_SESSION['NomLogin']."','".$_SERVER["REMOTE_ADDR"]."','$Cree' )";
  $result = mysql_query( $sql, $handle );
  if( $result == 0 ) {
  	    $Mess = "ERREUR WRITE 1 ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
		return(false);
  }
  return(true);  
  
} //  Aj_TransId

function  Get_TransId() {  
  GC_TransId();
  $Id = mt_rand();
  while( Chk_TransId($Id) ) $Id = mt_rand();
  return( $Id );  
  
} // Get_TransId


function  Ote_TransId($id) {  
global $handle,$database;

  $sql = "DELETE FROM $database.checkid WHERE transid = '$id'";
  $result = mysql_query( $sql, $handle );
  if( $result == 0 ) {
       	$Mess ="ERREUR DESTROY : ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
		return(false);
   }
   else   
   		return(true);  
  
} // Ote_TransId

?>