<?php
/* Programme : sessionsave.inc
* Description : Gestion  des variable de SESSION 
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2019-05-15
*/	

function open ($save_path, $session_name) {  
	gc( 0 );  
  	return(true);
} // open

function close() {
	return(true);
} // close

function read ($id) {  
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = ""; // Doit retourner "" par defaut.  
	// Connection au serveur
	$sess_mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		echo ( "Connection impossible au serveur - Session read ".mysqli_connect_errno()." : ".mysqli_connect_error()."<br>");
		exit();
	}

	/* Change la base de données en "world" */
	if( !$sess_mabd->select_db($database) ) { 
		echo ( "La base de données ne peut être sélectionnée - Session read<br>");
		exit();
	}
	/* Modification du jeu de résultats en utf8 */
	if (!$sess_mabd->set_charset("utf8")) {
	    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
	    exit();
	} 

	$sql = "SELECT Donnees_Session FROM $database.session WHERE ID_Session = '$id'";
	$result = $sess_mabd->query($sql);
	if( !$result ) {
	   	$Mess = addslashes ( "ERREUR Session Read ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo "</SCRIPT>";
	}
//	elseif (  $result->num_rows == 0 ) {
	elseif (  $result->num_rows != 0 ) {
		$ligne = $result->fetch_assoc();
		extract($ligne);
	 	$ret = $Donnees_Session;  
    		/* Libère le jeu de résultats */
    		$result->close();
		 
	} // Si de sinfo
	
	/* Fermeture de la connexion */	
	$sess_mabd->close();
	
	return($ret); 

} // read

function write( $id, $sess_data ) {  
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = false; // Doit retourner 0 par defaut.  
	$sess_mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		echo ( "Connection impossible au serveur - Session read ".mysqli_connect_errno()." : ".mysqli_connect_error()."<br>");
		exit();
	}

	/* Change la base de données en "world" */
	if( !$sess_mabd->select_db($database) ) { 
		echo ( "La base de données ne peut être sélectionnée - Session read<br>");
		exit();
	}
	/* Modification du jeu de résultats en utf8 */
	if (!$sess_mabd->set_charset("utf8")) {
	    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
	    exit();
	} 
  	$MAJ = time();
  	$sess_data = addslashes($sess_data);
								   			   
  	$sql = "SELECT * FROM $database.session WHERE ID_Session = '$id'";
  	$result = $sess_mabd->query($sql);
  	if( !$result ) {
		$Mess = addslashes ( "ERREUR Session Write 1 ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo "</SCRIPT>";
  	}
  	elseif (  $result->num_rows == 0 ) {
  			$Cree = date("Y-m-d H:i:s");
  			$sql = "INSERT INTO $database.session ( ID_Session, Usager, IP_Addr, NoClient, Date_Cree, Derniere_MAJ, Donnees_Session	) VALUES";
      	 		$sql .= "( '$id','".@$_SESSION['NomLogin']."','".$_SERVER["REMOTE_ADDR"]."','".@$_SESSION['NoID']."','$Cree','$MAJ','$sess_data' )";
		} // Ajout
	else 
         		$sql =  "UPDATE $database.session SET Usager='".@$_SESSION['NomLogin']."', Derniere_MAJ='$MAJ', Donnees_Session='$sess_data' WHERE ID_Session = '$id'";
	/* Libère le jeu de résultats */
	//$result->close();
	
	if( !$sess_mabd->query($sql) ) {
		$Mess = addslashes ( "ERREUR Session Write 2 ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo '</SCRIPT>';
	}
	else 
		$ret = true;
	/* Fermeture de la connexion */	
  	$sess_mabd->close();
	
   	return($ret); 

} // write

function destroy ($id) {  
global $mysql_host, $mysql_user, $mysql_pass,$database;

	$ret = false; // Doit retourner 0 par defaut.  
	$sess_mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		echo ( "Connection impossible au serveur - Session read ".mysqli_connect_errno()." : ".mysqli_connect_error()."<br>");
		exit();
	}

	/* Change la base de données en "world" */
	if( !$sess_mabd->select_db($database) ) { 
		echo ( "La base de données ne peut être sélectionnée - Session read<br>");
		exit();
	}
	/* Modification du jeu de résultats en utf8 */
	if (!$sess_mabd->set_charset("utf8")) {
	    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
	    exit();
	} 
	
	$sql = "DELETE FROM $database.session WHERE ID_Session = '$id'";
	$result = $sess_mabd->query($sql);
	if( !$result ) {
		$Mess = addslashes ( "ERREUR Session Destroy : ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo "</SCRIPT>";
	}
	else {
		$ret = true;
    		/* Libère le jeu de résultats */
    		//$result->close();
	}
	
	/* Fermeture de la connexion */	
	$sess_mabd->close();
	
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
	$sess_mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		echo ( "Connection impossible au serveur - Session read ".mysqli_connect_errno()." : ".mysqli_connect_error()."<br>");
		exit();
	}

	/* Change la base de données en "world" */
	if( !$sess_mabd->select_db($database) ) { 
		echo ( "La base de données ne peut être sélectionnée - Session read<br>");
		exit();
	}
	/* Modification du jeu de résultats en utf8 */
	if (!$sess_mabd->set_charset("utf8")) {
	    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
	    exit();
	} 
		
	$TropVieux = time() - (4 * 60 * 60); // Disons 4 heure
	$sql = "DELETE FROM $database.session WHERE Derniere_MAJ < '$TropVieux'";
	$result = $sess_mabd->query($sql);
	if( !$result ) {
		$Mess = addslashes ( "ERREUR Session GC : ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo "</SCRIPT>";
	}
	else {
		$ret = true;
    		/* Libère le jeu de résultats */
    	//	$result->close();
	}
		
	/* Fermeture de la connexion */	
	$sess_mabd->close();

   	return($ret); 
} // gc

function ListUsager() 
{
global $mysql_host, $mysql_user, $mysql_pass,$database, $NomCieCréé, $CopyAn, $NomCie;
	$sess_mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		echo ( "Connection impossible au serveur - Session read ".mysqli_connect_errno()." : ".mysqli_connect_error()."<br>");
		exit();
	}

	/* Change la base de données en "world" */
	if( !$sess_mabd->select_db($database) ) { 
		echo ( "La base de données ne peut être sélectionnée - Session read<br>");
		exit();
	}
	/* Modification du jeu de résultats en utf8 */
	if (!$sess_mabd->set_charset("utf8")) {
	    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
	    exit();
	} 

 	$sql = "SELECT * FROM $database.session";
 	$result = $sess_mabd->query($sql);
 	if( !$result ) {
  	    	$Mess = addslashes ( "ERREUR Session List ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo "</SCRIPT>";
		return(false);
 	}
	 elseif (  $result->num_rows != 0 ) {
 		$nb = $result->num_rows;
   echo "<html>
   <head>
       <title>Consultation des Usagers</title>
		<meta http-equiv='Content-Type' content='text/html; charset=utf-8' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste des accès' >
		<meta http-equiv='Content-Description' content='text/html; charset=utf-8' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<link title=SessionStyle href='css\styleutl.css' type=text/css rel=STYLESHEET>
		<style type='text/css' media='all'>
			#demo tr.ruled {
			  background:#B4E7FF;
			}
		</style>
      </head>
		<script language='JavaScript1.2' src='js/denislib.js'></script>
		<script language='javascript1.2' src='js/disablekeys.js'></script>
		<script language='javascript1.2' src='js/blokclick.js'></script>
		<script language='JavaScript1.2'>addKeyEvent();</script>
	      <body bgcolor='#D8D8FF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
      	<script language='JavaScript1.2'>window.onload=function(){tableruler();}</script>
         <form name'detail_session' action='' method='post'>
           <p align='center'> <font size='+2'><b>Liste des Usagers ($nb)</b></font></p>
           <hr size='5' color='#7CDFDF'>
           <table id='demo' class='ruler' border='1' width='100%' align='center'>
             <thead>
                <tr>";
                /* Prendre les informations des colonnes */
                $finfo = $result->fetch_fields();
                echo"<th>".$finfo[1]->name."</th>\n";
                echo"<th>".$finfo[2]->name."</th>\n";
                echo"<th>".$finfo[3]->name."</th>\n";
                echo"<th>".$finfo[5]->name."</th>\n";
                echo "</tr>
             </thead>
             <tbody>";
                for( $i=0; $i < $result->num_rows; $i++ ) {
                   echo "<tr>";
                   $row = $result->fetch_row();
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
	/* Fermeture de la connexion */	
	$sess_mabd->close();

} // ListUsager

function ListUsagerInc( $Appel ) 
{
global $mysql_host, $mysql_user, $mysql_pass,$database, $NomCieCréé, $CopyAn, $NomCie;
	$sess_mabd = new mysqli( $mysql_host, $mysql_user, $mysql_pass );

	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		echo ( "Connection impossible au serveur - Session read ".mysqli_connect_errno()." : ".mysqli_connect_error()."<br>");
		exit();
	}

	/* Change la base de données en "world" */
	if( !$sess_mabd->select_db($database) ) { 
		echo ( "La base de données ne peut être sélectionnée - Session read<br>");
		exit();
	}
	/* Modification du jeu de résultats en utf8 */
	if (!$sess_mabd->set_charset("utf8")) {
	    printf("Erreur lors du chargement du jeu de caractères utf8 : %s\n", $mysqli->error);
	    exit();
	} 

 	$sql = "SELECT * FROM $database.session";
 	$result = $sess_mabd->query($sql);
 	if( !$result ) {
  	    	$Mess = addslashes ( "ERREUR Session List ".$sess_mabd->errno.": ".$sess_mabd->error );
		echo "<SCRIPT LANGUAGE='javascript'>";
		echo " window.alert('".$Mess."'); ";
		echo "</SCRIPT>";
		return(false);
 	}
	 elseif (  $result->num_rows != 0 ) {
 		$nb = $result->num_rows;
   echo "
		<style type='text/css' media='all'>
			#demo tr.ruled {
			  background:#B4E7FF;
			}
		</style>
	<script language='JavaScript1.2' src='js/denislib.js'></script>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
     	<script language='JavaScript1.2'>window.onload=function(){tableruler();}</script>
         <form name'detail_session' action='$Appel' method='post'>
         	<p align='center'>
             		<input type='button' name='Detail' value='Detail' onClick='LoadDetail(this)'>&nbsp;&nbsp;
	     		<input type='submit' name='Commande' value='Quitter'> <!-- //Quitter -->
	     	</p> 
        <table id='demo' class='ruler' border='1' width='100%' align='center'>
          <thead>
                <tr>";
                /* Prendre les informations des colonnes */
                $finfo = $result->fetch_fields();
                echo"<th>".$finfo[1]->name."</th>\n";
                echo"<th>".$finfo[2]->name."</th>\n";
                echo"<th>".$finfo[3]->name."</th>\n";
                echo"<th>".$finfo[5]->name."</th>\n";
  		echo("<th>&#10004;</th>\n");
              echo "</tr>
             </thead>
             <tbody>";
                for( $i=0; $i < $result->num_rows; $i++ ) {
                   echo "<tr>";
                   $row = $result->fetch_row();
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
        	<p align='center'>
             		<input type='button' name='Detail' value='Detail' onClick='LoadDetail(this)'>&nbsp;&nbsp;
	     		<input type='submit' name='Commande' value='Quitter'> <!-- //Quitter -->
	     	</p> 
         </form>
         <SCRIPT LANGUAGE='javascript'>
 				   
				function LoadDetail( LaPage ){
					var Formulaire = LaPage.form, i,j,Nb;
					j = Formulaire.length; 
					Nb = 0;
					for( i=0; i < j; i++ ){
						if( Formulaire[i].checked  )	{
							str = 'sessiondetail.php?id=' + Formulaire[i].value; 
							open(str,'_blank','width=600,height=500,status=no,toolbar=no,menubar=no,location=no,resizable=yes' );
						}
					} // for
				} // LoadDetail

		 </SCRIPT>\n";
  } // ListUsagerInc
	/* Fermeture de la connexion */	
	$sess_mabd->close();

} // ListUsagerInc

//session_destroy(); 

//Allez chercher les valeur par défaut pour le Session_id (cookie)
$currentCookieParams = session_get_cookie_params(); 

// Mettre nos valeurs => surtout SECURE a FALSE pour ne pas a avoir a généré un cookie à chaque fois
session_set_cookie_params( 
    $currentCookieParams["lifetime"], // 0 = jusqu'a ce que le browser ferme 
    $currentCookieParams["path"], // ou '/'
    0, // ou  '.example.com' 
    FALSE, 
    $currentCookieParams["httponly"] 
); 
 
// On met notre gestionnaire de session_id en place
session_set_save_handler ("open", "close", "read", "write", "destroy", "gc");
session_start();
?>