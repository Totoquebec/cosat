<?php
/* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
* MAJ : Denis Léveillé 	 			  Date : 2019-05-15
*/
// ****** VARIABLES GLOBALES *****
$TabCouleur = array(
	'Noir' =>"#000000",
	'Blanc' =>"#FFFFFF",
	'Rouge' =>"#FF0000",
	'Bleu' =>"#0000FF",
	'Vert' =>"#008000",
	'Orange' =>"#FF8000",
	'Mauve' =>"#8000FF",
);

// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________
function mysql_next_id($table, $id_column) {
function get_compteur( $url_rech=0 )
function InfoBannie( $ip )
function InfoAcces( $ip )
// ***** DETECTION DES ROBOTS
function EsUnRobot( $ip )
function SauveIP( $ip )
function CheckRobot() 

pour pas cacher les pagezs 
<meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
 

http://stackoverflow.com/questions/9814191/mysql-row-locking-via-php

This is an old discussion, but perhaps people are still following it. I use a method similar to JMack's but include the locking information in the table I want to row-lock. My new columns are LockTime and LockedBy. To attempt a lock, I do:

UPDATE table
SET LockTime='$now',LockedBy='$Userid'
WHERE Key='$value' AND (LockTime IS NULL OR LockTime<'$past' OR LockedBy='$Userid')
($past is 4 minutes ago)

If this fails, someone else has the lock. I can explicitly unlock as follows or let my lock expire:

UPDATE table
SET LockTime=NULL,LockedBy=''
WHERE Key='$value' AND LockedBy='$Userid'
A cron job could remove old locks, but it's not really necessary.
*********************************************************************************************/


function mysql_next_id($table, $id_column) {

/*show table status like '%client' 
SELECT LAST_INSERT_ID() FROM matable
SELECT MAX(NoClient) AS maxid FROM client*/
  
	$sql = "SELECT MAX($id_column) AS maxid FROM $table;";
	$result = $mabd->query($sql);
	if( !$result ) {
		Message_Erreur( "ERROR", "Erreur mysql_next_id $table $id_column : ", $mabd->errno." : ".$mabd->error."<br>".$sql  );	
		return( 0 );		
	}		

	if( $result->num_rows ) { 
  		$rows = $result->fetch_assoc();
		return ( $rows['maxid'] + 1 );
   	}
   	else
   		return( 0 );
} // mysql_next_id



function get_compteur( $url_rech=0 )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $mabd, $database;

	if( strlen($url_rech) < 5 ) 
		$url_rech = $_SERVER['HTTP_HOST'];

	$sql = "SELECT id,date_debut, compteur FROM $database.parametre WHERE url LIKE '%$url_rech%' LIMIT 1;";
	$reponse = array();
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_compteur", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	if( $result->num_rows ) {
		$reponse = $result->fetch_assoc();
		if( !(int)substr($reponse['date_debut'], 0, 4) ) $reponse['date_debut'] = date('Y-m-d');
		$reponse['compteur']++;
		$sql = "UPDATE $database.parametre SET date_debut = '".$reponse['date_debut']."', compteur = '".$reponse['compteur']."' WHERE id='".$reponse['id']."';";
		if( !$mabd->query($sql) )
		      	Message_Erreur( "ERROR", "Erreur update get_compteur", $mabd->errno." : ".$mabd->error."<br>".$sql  );	
	}
	return( $reponse );

} // Iget_compteur

function InfoBannie( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
// Les badbot peuvent utilisé un USER_AGENT tout à fait légitime
 //		  		!strlen( $HTTP_USER_AGENT ) ||
//		  		!strcmp( $row[3], $HTTP_USER_AGENT ) ){
{
global $mabd, $database, $Now, $HTTP_USER_AGENT;
		//echo "IP ; $ip<br>";
	$badboy = false;
	unset($_SESSION['Jlaivu']);
		//	if( !strlen($ip) ) return( false );
    	// Recherche des sous categorie
	$sql = "SELECT * FROM $database.badbot WHERE IP='$ip'";
	$result = $mabd->query($sql);
	if( $result && $result->num_rows ) 
		$badboy = true;
	else {
		$domaine = my_gethostbyaddr($ip);
		$sql = "SELECT * FROM $database.badbot WHERE Hote='$domaine'";
		$result = $mabd->query($sql);
		if( $result && $result->num_rows ) 
			$badboy = true;
	}
	if( $badboy ) {
		$row = $result->fetch_row();
		$row[7]++;
		if( !strncmp( $row[9], $Now, 16 ) )
			$_SESSION['Jlaivu'] = 'OUI';
		$_SESSION['tst'] = "Row : ".$row[9]." Now : ".$Now;
		$sql =  "UPDATE $database.badbot SET Access = '".$row[7]."', DatDernAcces='$Now' WHERE Id='".$row[0]."';";
		// DatDernAcces
		$result = $mabd->query($sql);
		$_SESSION['isRobot'] = true;
		$_SESSION['isAspi'] = 3;
		return( true );
	} // Si un resultat
	return( false );

} // InfoBannie

function InfoAcces( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $mabd, $database, $Now, $Moteur;
    	// Recherche des robots
	if( EsUnRobot($ip) )  {
		$_SESSION['MLeRobot'] = true;
		$domaine = @my_gethostbyaddr($ip);
		$sql =  "INSERT INTO $database.access SET Date = '$Now', Moteur='".$row[1]."', IP='$ip', Agent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine';";
		$result = $mabd->query($sql);
	} // Si un robot

} // InfoAcces

function EsUnRobot( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Valide si une adresse IP est reconnu comme un moteur de recherche
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $mabd, $database, $Now, $Moteur;
    	// Recherche des robots
 	$result = $mabd->query("SELECT * FROM $database.robot" );
	if( $result && ( $result->num_rows > 0) ) {
		$domaine = @my_gethostbyaddr($ip);
	     for( $i=0; $i < $result->num_rows; $i++ ) {
			$row = $result->fetch_row();
			if( 	strstr( $domaine, $row[4] ) ||
		    		strstr( $ip, $row[5] ) ||
				!strcmp($row[3], $_SERVER["HTTP_USER_AGENT"]) ){
				$Moteur = $row[1];
				return( true );
			} // Si trouver
	     } // for $i;
	} // Si un resultat
	return( false );

} // EsUnRobot

function SauveIP( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Ajoute l'adresse IP dans une table et compte le nombre d'occurence
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2015-04-03
//  derniere modif : Denis Léveillé
//  info : 
{
global $mabd, $database, $Now, $Moteur;

	$nbr = 1;
	// Le cleanup des vieiles affaires
	$JourAvant = time() - (24 * 60 * 60);
	
	$sql = "DELETE FROM $database.tableip WHERE DatDernAcces < '$JourAvant'"; 
	$result = $mabd->query($sql);
	
	$MAJ = time();
	// On le connais-tu lui lala
 	$sql = "SELECT * FROM $database.tableip WHERE IP='$ip';";
	$result = $mabd->query($sql);
	   // echo "Dans sauve ip ".$sql."<br>";
	if( $result && ( $result->num_rows > 0) ) {
		// Ho yes on compte le nombre d'appel qu'on a recu
		$row = $result->fetch_row();
		$nbr += $row[4];
		$sql =  "UPDATE $database.tableip SET Nbr = '$nbr', DatDernAcces='$MAJ' WHERE IP='$ip';";
				// DatDernAcces
	    //	echo "Existe sauve ip ".$sql."<br>";
		$result = $mabd->query($sql);
		return( $nbr );
	} // Si un resultat
	else {
		// Pas sur on l'inscrit sur la liste
		$domaine = @my_gethostbyaddr($ip);
		$sql =  "INSERT INTO $database.tableip SET IP='$ip', DatDernAcces = '$MAJ', Agent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine', Nbr=1 ;";
	  //  	echo "Pas existe sauve ip ".$sql."<br>";
		$result = $mabd->query($sql);
	}
	return( $nbr );

} // SauveIP



// **********************************************************************************************
// ***** DETECTION DES ROBOTS
function CheckRobot() 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Si le client est un robot, envoi un message à l'écran : Hi ! Robot !!!!
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $ip,$mabd, $database, $Now, $entr_url, $AdrWebmestre, $txt, $TabMessGen;

	if( isset($_SESSION['isRobot']) ) { 
		// on s'envoie un mail contenant l'adresse IP du visiteur (il s'agit peut être d'un vrai moteur de recherche) 
			
		$domaine = @my_gethostbyaddr($ip);
		$ip = get_ip(); 
		if (isset($_SESSION['isAspi'])) { 
			switch( $_SESSION['isAspi'] ) {
				case 1:		$txt2 = ' => par Suspect';
							break;
				case 2:		$txt2 = ' => par Trappe';
							break;
				case 3:		$txt2 = ' => par Table';
							break;
				case 4:		$txt2 = ' => par 404';
							break;
				default :	$txt2 = ' => par ????';
			} // switch isaspi
			$sujet = "Un Aspirateur sur le site $entr_url";
			$Type = 'Aspirateur';
			if( !InfoBannie( $ip ) ) {
				$sql =  "INSERT INTO $database.badbot SET IP='$ip', UserAgent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine', Date = '$Now', Access = '1', Porte = '$txt2';";
				$result = $mabd->query($sql);
				$Type .= " (Ajouté $result)";
			}
		} // Si un aspirateur   
		else {
			$sujet = "Un Robot sur le site $entr_url";
			$Type = 'Robot';
			$txt2 = ' => par Suspect';
		} // Sinon un simple robot
			// 			Son IP : <b>$ip</b><br/>".$_SESSION['tst']."<br><br/>
			// http://ping.eu/ns-whois/
		$info = "<font size='3'><b>Un $Type a été choppé sur<br>$entr_url</b><br/>
				$txt2<br/>
				Son IP : <b><a href='http://whois.domaintools.com/".$_SERVER["REMOTE_ADDR"]."'>".$_SERVER["REMOTE_ADDR"]."</a></b><br><br/>
				User Agent : <b>".$_SERVER["HTTP_USER_AGENT"]."</b><br>
				Domaine : <b>$domaine</b></font>"; 
		if( !isset($_SESSION['Jlaivu']) )
			AlloWebmaster( $sujet, $info );
		else
			unset($_SESSION['Jlaivu']);
		// on bloque l'affichage 
		if (isset($_SESSION['isAspi'])) { 
			echo "
			<html>
				<head>
				<title>Hi ! ROBOT !!!!!!</title>
				</head>
				<body>
					<p align='center'>
						<marquee bgcolor='#FFFF00' height='60'>
							<font color='#000000' size='6' face='verdana'>".$TabMessGen[2000]." ".hexentities($AdrWebmestre)." !!!</font>
						</marquee>
					</p>		
				</body>
			</html>"; 
			exit();
		}
	
	}  // Si Un Robot actif
} // CheckRobot


?>