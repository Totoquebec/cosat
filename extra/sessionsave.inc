<?php
//include("var.inc");

function open ($save_path, $session_name) {  
  gc( 0 );  
  return(true);
} // open

function close() {
//  gc( 0 );  
  return(true);
} // close

function read ($id) {  
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = ""; // Doit retourner "" par defaut.  
 // Connection au serveur
  $connection = @mysql_connect( $mysql_host, $mysql_user, $mysql_pass)
	or die( "Connection impossible au serveur - Session read ".mysql_errno()." : ".mysql_error()."<br>");
  $db = @mysql_select_db( $database, $connection )
	or die("La base de données ne peut être sélectionnée - Session read");

  $sql = "SELECT Donnees_Session FROM $database.session WHERE ID_Session = '$id'";
  $result = mysql_query( $sql, $connection );
  if( $result == 0 ) {
  	   $Mess = "ERREUR READ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
  }
  elseif (  mysql_num_rows($result) != 0 ) {
  		 	$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
      			extract($ligne);
 	 	 	$ret = $Donnees_Session;  
      } // Si de sinfo

//	mysql_close($connection);

   return($ret); 

} // read

function write( $id, $sess_data ) {  
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = false; // Doit retourner 0 par defaut.  
	// Connection au serveur
	$connection = @mysql_connect( $mysql_host, $mysql_user, $mysql_pass)
		or die( "Connection impossible au serveur - Session write");
	$db = @mysql_select_db( $database, $connection )
		or die("La base de données ne peut être sélectionnée - Session write");

  	$MAJ = time();
  	$sess_data = addslashes($sess_data);
								   			   
  	$sql = "SELECT * FROM $database.session WHERE ID_Session = '$id'";
  	$result = mysql_query( $sql, $connection );
  	if( $result == 0 ) {
  	   	$Mess = "ERREUR WRITE 1 ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
  	}
  	elseif (  mysql_num_rows($result) == 0 ) {
	  		$IpAdr = $_SERVER["REMOTE_ADDR"];
	  		$sql = "SELECT * FROM $database.session WHERE IP_Addr = '$IpAdr'";
	  		$result = mysql_query( $sql, $connection );
			// Si une erreur
		  	if( $result == 0 ) {
		  	   	$Mess = "ERREUR WRITE 2 ".mysql_errno().": ".mysql_error();
				echo "<SCRIPT LANGUAGE='javascript'>";
				echo " window.alert(\"$Mess\"); ";
				echo "</SCRIPT>";
		  	}
		  	elseif (  mysql_num_rows($result) == 0 ) { // Sinon si requete retourne 0 record = on ajoute
  				$Cree = date("Y-m-d H:i:s");
  				$sql = "INSERT INTO $database.session ( ID_Session, Usager, IP_Addr, NoClient, Date_Cree, Derniere_MAJ, Donnees_Session	) VALUES";
      	 			$sql .= "( '$id','".@$_SESSION['NomLogin']."','$IpAdr','".@$_SESSION['NoContact']."','$Cree','$MAJ','$sess_data' )";
			}
			else { // Oups cette adresse IP existe deja avec un autre ID de session ?????
				$Table = mysql_fetch_assoc($result); 
				$sql =  "UPDATE $database.session SET Usager='".@$_SESSION['NomLogin']."', Derniere_MAJ='$MAJ', Donnees_Session='$sess_data' WHERE ID_Session = '".$Table['ID_Session']."'";
			}
		} // Ajout
		else 
         		$sql =  "UPDATE $database.session SET Usager='".@$_SESSION['NomLogin']."', Derniere_MAJ='$MAJ', Donnees_Session='$sess_data' WHERE ID_Session = '$id'";
	
	if( !mysql_query($sql) ) {
		$Mess = "ERREUR WRITE 3 ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo ' window.alert("$Mess"); ';
		echo '</SCRIPT>';
	}
	else 
		$ret = true;
	
   	return($ret); 

} // write

function destroy ($id) {  
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = false; // Doit retourner 0 par defaut.  
 // Connection au serveur
  $connection = @mysql_connect( $mysql_host, $mysql_user, $mysql_pass )
	or die( "Connection impossible au serveur - Session destroy");
  $db = @mysql_select_db( $database, $connection )
	or die("La base de données ne peut être sélectionnée - Session destroy");

  $sql = "DELETE FROM $database.session WHERE ID_Session = '$id'";
  $result = mysql_query( $sql, $connection );
  if( $result == 0 ) {
      $Mess ="ERREUR DESTROY : ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
	}
   else 
		$ret = true;
		
//	mysql_close($connection);

   return($ret); 

} // destroy

/******************************************************* 
 * ATTENTION - Vous devrez implémenter un
 * 
 * collecteur de données obosolètes ici. 
 * 
 *******************************************************/
 
function gc( $maxlifetime ) {
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = false; // Doit retourner 0 par defaut.  
 // Connection au serveur
	if( $connection = @mysql_connect( $mysql_host, $mysql_user, $mysql_pass ) ) {
		//	or die( "Connection impossible au serveur");
		$db = @mysql_select_db( $database, $connection )
			or die("BD ne peut être sélectionnée : $database - Session GC ".mysql_errno()." : ".mysql_error()."<br>");
		
		$TropVieux = time() - (1 * 60 * 60); // Disons 1 heure
		$sql = "DELETE FROM $database.session WHERE Derniere_MAJ < '$TropVieux'";
		$result = mysql_query( $sql, $connection );
		if( $result == 0 ) {
			$Mess ="ERREUR DESTROY : ".mysql_errno().": ".mysql_error();
			echo "<SCRIPT LANGUAGE='javascript'>";
			echo " window.alert(\"$Mess\"); ";
			echo "</SCRIPT>";
		}
		else 
			$ret = true;
	} // Si connection
		
//	mysql_close($connection);

   return($ret); 
} // gc

function ListUsager() 
{
global $mysql_host, $mysql_user, $mysql_pass,$database;
 // Connection au serveur
 $connection = @mysql_connect( $mysql_host, $mysql_user, $mysql_pass)
	or die( "Connection impossible au serveur - Session List Usager");
 $db = @mysql_select_db( $database, $connection )
	or die("La base de données ne peut être sélectionnée - Session List Usager");

 $sql = "SELECT * FROM $database.session";
 $result = mysql_query( $sql, $connection );
 if( $result == 0 ) {
  	    $Mess = "ERREUR LIST 1 ".mysql_errno().": ".mysql_error();
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert(\"$Mess\"); ";
		echo "</SCRIPT>";
		return(false);
 }
 elseif (  mysql_num_rows($result) != 0 ) {
 	$nb = mysql_num_rows($result);
   echo "<html>
   <head>
       <title>Consultation des Usagers</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste des accès' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<link title=HermesStyle href='styles\styleutl.css' type=text/css rel=STYLESHEET>
		<style type='text/css' media='all'>
			#demo tr.ruled {
			  background:#B4E7FF;
			}
		</style>
      </head>
		<script language='JavaScript1.2' src='javafich/denislib.js'></script>
		<script language='javascript1.2' src='javafich/disablekeys.js'></script>
		<script language='javascript1.2' src='javafich/blokclick.js'></script>
		<script language='JavaScript1.2'>addKeyEvent();</script>
	      <body bgcolor='#D8D8FF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
      	<script language='JavaScript1.2'>window.onload=function(){tableruler();}</script>
         <form name'detail_session' action='' method='post'>
           <p align='center'> <font size='+2'><b>Liste des Usagers ($nb)</b></font></p>
           <hr size='5' color='#7CDFDF'>
           <table id='demo' class='ruler' border='1' width='100%' align='center'>
             <thead>
                <tr>";
                echo("<th>".mysql_field_name($result,1)."</th>");
                echo("<th>".mysql_field_name($result,2)."</th>");
                echo("<th>".mysql_field_name($result,3)."</th>");
                echo("<th>".mysql_field_name($result,5)."</th>");
                echo "</tr>
             </thead>
             <tbody>";
                for( $i=0; $i < mysql_num_rows($result); $i++ ) {
                   echo "<tr>";
                   $row = mysql_fetch_row($result);
                   if( strlen($row[1]) )
                           echo("<td>".$row[1]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[2]) )
                           echo("<td>".$row[2]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[3]) )
                           echo("<td>".$row[3]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
				   	$MAJ = date('Y-m-d H:i:s', $row[5] );
                   if( strlen($MAJ) )
                           echo("<td>".$MAJ."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#7CDFDF'>
             <p align='center'>
             <input type='button' name='Detail' value='Detail' onClick='LoadDetail(this)'>&nbsp;&nbsp; 
             <input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()'> 
         </form>
         <SCRIPT LANGUAGE='javascript'>
           	function QuitterPage() {
                 close();
           	}
				   
				function LoadDetail( LaPage ){
					var Formulaire = LaPage.form, i,j,Nb;
					j = Formulaire.length; 
					Nb = 0;
					for( i=0; i < j; i++ ){
						if( Formulaire[i].checked  )	{
							str = 'sessiondetail.php?id=' + Formulaire[i].value; 
							open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=yes' );
						}
					} // for
				}

		 </SCRIPT>
   </body>
  </html>
  ";
  }

} // ListUsager

//session_destroy();  
session_set_save_handler ("open", "close", "read", "write", "destroy", "gc");
session_start();
?>