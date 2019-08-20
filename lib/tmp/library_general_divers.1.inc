<?php
//* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
//* MAJ : Denis Léveillé 	 			  Date : 2007-12-21

// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________

function get_compteur( $url_rech=0 )
function InfoBannie( $ip )
function InfoAcces( $ip )
// ***** DETECTION DES ROBOTS
function EsUnRobot( $ip )
function CheckRobot() {
function isMoteur($ip)
function Message_Erreur( $Top, $Message, $Info )
function recherche($criteres, $categorie)
function selectionRecherche( $idsProduits )
function adjust_path($cat)
function list_cats_checkbox($upcat=0,$level=1)
function list_cats($id=0, $lvl=0, $check=-1,$sous)
function afficher_un_produit( $produit, $NoCat, $Retour, $Page ){
function afficher_categorie_list( $ressource, $NoCat ){
function afficher_categorie_rech( $produits ){
**********************************************************************************************/

$NomJourFR = array(
		"0"=>"Dimanche",
		"1"=>"Lundi",
		"2"=>"Mardi",
		"3"=>"Mercredi",
		"4"=>"Jeudi",
		"5"=>"Vendredi",
		"6"=>"Samedi"
		); 
 
$NomJourSP = array(
		"0"=>"Domingo",
		"1"=>"Lunes",
		"2"=>"Martes",
		"3"=>"Miércoles",
		"4"=>"Jueves",
		"5"=>"Viernes",
		"6"=>"Sábado"
		);
		
$NomMoisFR = array(		
		"1"=>"Janvier",
		"2"=>"Février",
		"3"=>"Mars",
		"4"=>"Avril",
		"5"=>"Mai",
		"6"=>"Juin",
		"7"=>"Juillet",
		"8"=>"Août",
		"9"=>"Septembre",
		"10"=>"Octobre",
		"11"=>"Novembre",
		"12"=>"Décembre"
);
$NomSaisonFR = array(
	"Janvier" =>"Hiver",
	"Février" =>"Hiver",
	"Mars"    =>"Hiver",
	"Avril"   =>"Printemps",
	"Mai"     =>"Printemps",
	"Juin"    =>"Printemps",
	"Juillet" =>"Été",
	"Août"    =>"Été",
	"Septembre"=>"Été",
	"Octobre" =>"Automne",
	"Novembre"=>"Automne",
	"Décembre"=>"Automne"
); 

$NomSaisonNoFR = array(
	"01"=>"Hiver",
	"02"=>"Hiver",
	"03"=>"Hiver",
	"04"=>"Printemps",
	"05"=>"Printemps",
	"06"=>"Printemps",
	"07"=>"Été",
	"08"=>"Été",
	"09"=>"Été",
	"10"=>"Automne",
	"11"=>"Automne",
	"12"=>"Automne"
); 


$NomMoisFR_2 = array(
	"01"=>"Janvier",
	"02"=>"Février",
	"03"=>"Mars",
	"04"=>"Avril",
	"05"=>"Mai",
	"06"=>"Juin",
	"07"=>"Juillet",
	"08"=>"Août",
	"09"=>"Septembre",
	"10"=>"Octobre",
	"11"=>"Novembre",
	"12"=>"Décembre",
); 

function my_gethostbyaddr($ip) {
	if( isset( $_SESSION['LeHost'] ) && strlen($_SESSION['LeHost']) )
		return $_SESSION['LeHost'];
	else
		$_SESSION['LeHost'] = @gethostbyaddr($ip) or ($_SESSION['LeHost']= 'host inconnu');
	
	return $_SESSION['LeHost'];
} 



function get_compteur( $url_rech=0 )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database;

	if( strlen($url_rech) < 5 ) 
		$url_rech = $_SERVER['HTTP_HOST'];

	$sql = "SELECT id,date_debut, compteur FROM $database.parametre WHERE url LIKE '%$url_rech%' LIMIT 1;";
	$reponse = array();
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_compteur", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	if( mysql_num_rows($result) ) {
		$reponse = mysql_fetch_assoc($result);
		if( !(int)substr($reponse['date_debut'], 0, 4) ) $reponse['date_debut'] = date('Y-m-d');
		$reponse['compteur']++;
		$sql = "UPDATE $database.parametre SET date_debut = '".$reponse['date_debut']."', compteur = '".$reponse['compteur']."' WHERE id='".$reponse['id']."';";
		if( !mysql_query( $sql, $handle ) )
		      	Message_Erreur( "ERROR", "Erreur update get_compteur", mysql_errno()." : ".mysql_error()."<br>".$sql  );	
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
global $handle, $database, $Now, $HTTP_USER_AGENT;
//echo "IP ; $ip<br>";
	$badboy = false;
	unset($_SESSION['Jlaivu']);
//	if( !strlen($ip) ) return( false );
    	// Recherche des sous categorie
	$sql = "SELECT * FROM $database.badbot WHERE IP='$ip'";
	$result = mysql_query($sql, $handle );
	if( $result && mysql_num_rows( $result ) ) 
		$badboy = true;
	else {
		$domaine = my_gethostbyaddr($ip);
		$sql = "SELECT * FROM $database.badbot WHERE Hote='$domaine'";
		$result = mysql_query($sql, $handle );
		if( $result && mysql_num_rows( $result ) ) 
			$badboy = true;
	}
	if( $badboy ) {
		$row = mysql_fetch_row($result);
		$row[7]++;
		if( !strncmp( $row[9], $Now, 16 ) )
			$_SESSION['Jlaivu'] = 'OUI';
		$_SESSION['tst'] = "Row : ".$row[9]." Now : ".$Now;
		$sql =  "UPDATE $database.badbot SET Access = '".$row[7]."', DatDernAcces='$Now' WHERE Id='".$row[0]."';";
		// DatDernAcces
		$result = mysql_query( $sql, $handle );
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
global $handle, $database, $Now;
    	// Recherche des sous categorie
	$result = mysql_query("SELECT * FROM $database.robot", $handle );
	if( $result && mysql_num_rows( $result ) ) {
		$domaine = @my_gethostbyaddr($ip);
	  	for( $i = mysql_num_rows($result); $i; $i-- ) {
		  $row = mysql_fetch_row($result);
		  if(	strstr( $ip, $row[5] ) ||
		  	strstr( $domaine, $row[4] ) ||
		  	!strcmp( $row[3], $_SERVER["HTTP_USER_AGENT"] ) ){
				$sql =  "INSERT INTO $database.access SET Date = '$Now', Moteur='".$row[1]."', IP='$ip', Agent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine';";
				$result = mysql_query( $sql, $handle );
				break;
			} // Si trouver
		} // for $i;
	} // Si un resultat

} // InfoAcces

function EsUnRobot( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database, $Now;
	$domaine = @my_gethostbyaddr($ip);
    	// Recherche des sous categorie
    	$sql = "SELECT * FROM $database.robot";
    	$result = mysql_query($sql, $handle );
	if( $result && ( mysql_num_rows( $result ) > 0) ) {
	     for( $i=0; $i < mysql_num_rows($result); $i++ ) {
		$row = mysql_fetch_row($result);
		if( 	strstr( $domaine, $row[4] ) ||
		    	strstr( $ip, $row[5] ) ||
			!strcmp($row[3], $_SERVER["HTTP_USER_AGENT"]) ){
				return( true );
		} // Si trouver
	     } // for $i;
	} // Si un resultat
	return( false );

} // EsUnRobot

// **********************************************************************************************
// ***** DETECTION DES ROBOTS
function CheckRobot() 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $ip,$handle, $database, $Now, $entr_url, $AdrWebmestre, $txt;
//	return;
	if( isset($_SESSION['isRobot']) ) { 
		// on s'envoie un mail contenant l'adresse IP du visiteur (il s'agit peut être d'un vrai moteur de recherche) 
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
			
		$domaine = @my_gethostbyaddr($ip);
		$ip = get_ip(); 
		if (isset($_SESSION['isAspi'])) { 
			$sujet = "Un Aspirateur sur le site $entr_url";
			$Type = 'Aspirateur';
			if( !InfoBannie( $ip ) ) {
				$sql =  "INSERT INTO $database.badbot SET IP='$ip', UserAgent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine', Date = '$Now', Access = '1', Porte = '$txt2';";
				$result = mysql_query( $sql, $handle );
				$Type .= " (Ajouté $result)";
			}
		} // Si un aspirateur   
		else {
			$sujet = "Un Robot sur le site $entr_url";
			$Type = 'Robot';
		} // Sinon un simple robot
			// 			Son IP : <b>$ip</b><br/>".$_SESSION['tst']."<br><br/>
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
							<font color='#000000' size='6' face='verdana'>".$txt['Msg_bannie']." ".hexentities($AdrWebmestre)." !!!</font>
						</marquee>
					</p>		
				</body>
			</html>"; 
			exit();
		}
	
	}  // Si Un Robot actif
} // CheckRobot

function isMoteur($ip)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
/* Liste des robots de : Google, Altavista, Inktomi, 
	Voila, WiseNut, Fast, DeepIndex, Teoma, Whalhello, 
	Gigablast, Mirago, picsearch, Szukacz, Openfind, Naver */ 
{
	$listeiprobots[]='62.212.117.198'; 
	$listeiprobots[]='62.119.21.157'; 
	$listeiprobots[]='64.68.82.10'; 
	$listeiprobots[]='64.68.82.14'; 
	$listeiprobots[]='64.68.82.16'; 
	$listeiprobots[]='64.68.82.17'; 
	$listeiprobots[]='64.68.82.18'; 
	$listeiprobots[]='64.68.82.25'; 
	$listeiprobots[]='64.68.82.26'; 
	$listeiprobots[]='64.68.82.27'; 
	$listeiprobots[]='64.68.82.28'; 
	$listeiprobots[]='64.68.82.30'; 
	$listeiprobots[]='64.68.82.5'; 
	$listeiprobots[]='64.68.82.6'; 
	$listeiprobots[]='64.68.82.7'; 
	$listeiprobots[]='64.68.82.31'; 
	$listeiprobots[]='64.68.82.32'; 
	$listeiprobots[]='64.68.82.33'; 
	$listeiprobots[]='64.68.82.34'; 
	$listeiprobots[]='64.68.82.35'; 
	$listeiprobots[]='64.68.82.36'; 
	$listeiprobots[]='64.68.82.37'; 
	$listeiprobots[]='64.68.82.38'; 
	$listeiprobots[]='64.68.82.39'; 
	$listeiprobots[]='64.68.82.41'; 
	$listeiprobots[]='64.68.82.43'; 
	$listeiprobots[]='64.68.82.44'; 
	$listeiprobots[]='64.68.82.45'; 
	$listeiprobots[]='64.68.82.46'; 
	$listeiprobots[]='64.68.82.47'; 
	$listeiprobots[]='64.68.82.48'; 
	$listeiprobots[]='64.68.82.50'; 
	$listeiprobots[]='64.68.82.51'; 
	$listeiprobots[]='64.68.82.52'; 
	$listeiprobots[]='64.68.82.54'; 
	$listeiprobots[]='64.68.82.55'; 
	$listeiprobots[]='64.68.82.56'; 
	$listeiprobots[]='64.68.82.57'; 
	$listeiprobots[]='64.68.82.58'; 
	$listeiprobots[]='64.68.82.65'; 
	$listeiprobots[]='64.68.82.66'; 
	$listeiprobots[]='64.68.82.67'; 
	$listeiprobots[]='64.68.82.68'; 
	$listeiprobots[]='64.68.82.69'; 
	$listeiprobots[]='64.68.82.70'; 
	$listeiprobots[]='64.68.82.71'; 
	$listeiprobots[]='64.68.82.74'; 
	$listeiprobots[]='64.68.82.77'; 
	$listeiprobots[]='64.68.82.78'; 
	$listeiprobots[]='64.68.82.79'; 
	$listeiprobots[]='64.208.172.173';
	$listeiprobots[]='64.241.243.65'; 
	$listeiprobots[]='64.241.243.65'; 
	$listeiprobots[]='64.241.242.177'; 
	$listeiprobots[]='65.214.36.150'; 
	$listeiprobots[]='65.214.36.152'; 
	$listeiprobots[]='65.214.38.10'; 
	$listeiprobots[]='66.77.73.203'; 
	$listeiprobots[]='66.77.73.61'; 
	$listeiprobots[]='66.237.60.22'; 
	$listeiprobots[]='66.196.72.10'; 
	$listeiprobots[]='66.196.72.11'; 
	$listeiprobots[]='66.196.72.12'; 
	$listeiprobots[]='66.196.72.13'; 
	$listeiprobots[]='66.196.72.14'; 
	$listeiprobots[]='66.196.72.15'; 
	$listeiprobots[]='66.196.72.16'; 
	$listeiprobots[]='66.196.72.17'; 
	$listeiprobots[]='66.196.72.18'; 
	$listeiprobots[]='66.196.72.19'; 
	$listeiprobots[]='66.196.72.20'; 
	$listeiprobots[]='66.196.72.21'; 
	$listeiprobots[]='66.196.72.22'; 
	$listeiprobots[]='66.196.72.23'; 
	$listeiprobots[]='66.196.72.24'; 
	$listeiprobots[]='66.196.72.25'; 
	$listeiprobots[]='66.196.72.26'; 
	$listeiprobots[]='66.196.72.27'; 
	$listeiprobots[]='66.196.72.28'; 
	$listeiprobots[]='66.196.72.29'; 
	$listeiprobots[]='66.196.72.30'; 
	$listeiprobots[]='66.196.72.31'; 
	$listeiprobots[]='66.196.72.32'; 
	$listeiprobots[]='66.196.72.33'; 
	$listeiprobots[]='66.196.72.34'; 
	$listeiprobots[]='66.196.72.35'; 
	$listeiprobots[]='66.196.72.36'; 
	$listeiprobots[]='66.196.72.37'; 
	$listeiprobots[]='66.196.72.38'; 
	$listeiprobots[]='66.196.72.39'; 
	$listeiprobots[]='66.196.72.40'; 
	$listeiprobots[]='66.196.72.41'; 
	$listeiprobots[]='66.196.72.42'; 
	$listeiprobots[]='66.196.72.43'; 
	$listeiprobots[]='66.196.72.44'; 
	$listeiprobots[]='66.196.72.45'; 
	$listeiprobots[]='66.196.72.46'; 
	$listeiprobots[]='66.196.72.47'; 
	$listeiprobots[]='66.196.72.48'; 
	$listeiprobots[]='66.196.72.49'; 
	$listeiprobots[]='66.196.72.50'; 
	$listeiprobots[]='66.196.72.51'; 
	$listeiprobots[]='66.196.72.52'; 
	$listeiprobots[]='66.196.72.53'; 
	$listeiprobots[]='66.196.72.54'; 
	$listeiprobots[]='66.196.72.55'; 
	$listeiprobots[]='66.196.72.56'; 
	$listeiprobots[]='66.196.72.57'; 
	$listeiprobots[]='66.196.72.58'; 
	$listeiprobots[]='66.196.72.59'; 
	$listeiprobots[]='66.196.72.60'; 
	$listeiprobots[]='66.196.72.61'; 
	$listeiprobots[]='66.196.72.62'; 
	$listeiprobots[]='66.196.72.63'; 
	$listeiprobots[]='66.196.72.64'; 
	$listeiprobots[]='66.196.72.65'; 
	$listeiprobots[]='66.196.72.66'; 
	$listeiprobots[]='66.196.72.67'; 
	$listeiprobots[]='66.196.72.68'; 
	$listeiprobots[]='66.196.72.69'; 
	$listeiprobots[]='66.196.72.70'; 
	$listeiprobots[]='66.196.72.71'; 
	$listeiprobots[]='66.196.72.72'; 
	$listeiprobots[]='66.196.72.73'; 
	$listeiprobots[]='66.196.72.74'; 
	$listeiprobots[]='66.196.72.75'; 
	$listeiprobots[]='66.196.72.76'; 
	$listeiprobots[]='66.196.72.77'; 
	$listeiprobots[]='66.196.72.78'; 
	$listeiprobots[]='66.196.72.79'; 
	$listeiprobots[]='66.196.72.80'; 
	$listeiprobots[]='66.196.72.81'; 
	$listeiprobots[]='66.196.72.82'; 
	$listeiprobots[]='66.196.72.83'; 
	$listeiprobots[]='66.196.72.84'; 
	$listeiprobots[]='66.196.72.85'; 
	$listeiprobots[]='66.196.72.86'; 
	$listeiprobots[]='66.196.72.87'; 
	$listeiprobots[]='66.196.72.88'; 
	$listeiprobots[]='66.196.72.89'; 
	$listeiprobots[]='66.196.72.90'; 
	$listeiprobots[]='66.196.72.91'; 
	$listeiprobots[]='66.196.72.92'; 
	$listeiprobots[]='66.196.72.93'; 
	$listeiprobots[]='66.196.72.94'; 
	$listeiprobots[]='66.196.72.95'; 
	$listeiprobots[]='66.196.72.96'; 
	$listeiprobots[]='66.196.72.97'; 
	$listeiprobots[]='66.196.72.98'; 
	$listeiprobots[]='66.196.72.99'; 
	$listeiprobots[]='66.196.72.100'; 
	$listeiprobots[]='66.196.72.101'; 
	$listeiprobots[]='66.196.72.102'; 
	$listeiprobots[]='66.196.72.103'; 
	$listeiprobots[]='66.196.72.104'; 
	$listeiprobots[]='66.196.72.105'; 
	$listeiprobots[]='66.196.72.106'; 
	$listeiprobots[]='66.196.72.107'; 
	$listeiprobots[]='66.196.72.108'; 
	$listeiprobots[]='66.196.72.109'; 
	$listeiprobots[]='66.249.65.240'; 
	$listeiprobots[]='74.6.24.19';  
	$listeiprobots[]='74.6.20.26';  
	$listeiprobots[]='74.6.22.32';  
	$listeiprobots[]='74.6.21.125';  
	$listeiprobots[]='74.6.20.134'; 
	$listeiprobots[]='74.6.8.104';
	$listeiprobots[]='193.218.115.6'; 
	$listeiprobots[]='195.101.94.208'; 
	$listeiprobots[]='195.101.94.101'; 
	$listeiprobots[]='195.101.94.209'; 
	$listeiprobots[]='207.46.12.165'; 
	$listeiprobots[]='209.249.67.128'; 
	$listeiprobots[]='209.249.67.139'; 
	$listeiprobots[]='209.73.164.50'; 
	$listeiprobots[]='210.59.144.149'; 
	$listeiprobots[]='212.127.141.180'; 
	$listeiprobots[]='213.73.184.72'; 
	$listeiprobots[]='213.73.184.96'; 
	$listeiprobots[]='216.243.113.1'; 
	$listeiprobots[]='216.39.48.82'; 
	$listeiprobots[]='216.39.48.164'; 
	$listeiprobots[]='216.39.50.160'; 
	$listeiprobots[]='216.39.50.116'; 
	$listeiprobots[]='216.39.50.143'; 
	$listeiprobots[]='216.39.50.144'; 
	$listeiprobots[]='216.39.50.145'; 
	$listeiprobots[]='216.39.50.155'; 
	$listeiprobots[]='216.39.48.58'; 
	$listeiprobots[]='216.239.46.19'; 
	$listeiprobots[]='216.239.46.23'; 
	$listeiprobots[]='216.239.46.3'; 
	$listeiprobots[]='216.239.46.30'; 
	$listeiprobots[]='216.239.46.36'; 
	$listeiprobots[]='216.239.46.41'; 
	$listeiprobots[]='216.239.46.42'; 
	$listeiprobots[]='216.239.46.43'; 
	$listeiprobots[]='216.239.46.60'; 
	$listeiprobots[]='216.239.46.102'; 
	$listeiprobots[]='216.239.46.104'; 
	$listeiprobots[]='216.239.46.105'; 
	$listeiprobots[]='216.239.46.86'; 
	$listeiprobots[]='216.239.46.96'; 
	$listeiprobots[]='216.239.46.98'; 
	$listeiprobots[]='216.239.46.99'; 
	$listeiprobots[]='216.239.46.118'; 
	$listeiprobots[]='216.239.46.140'; 
	$listeiprobots[]='216.239.46.147'; 
	$listeiprobots[]='216.239.46.165'; 
	$listeiprobots[]='216.239.46.184'; 
	$listeiprobots[]='217.205.60.225'; 
	$listeiprobots[]='218.145.25.110'; 
	$listeiprobots[]='218.145.25.49'; 
	$listeiprobots[]='216.88.158.142'; 
	 


//         $listeiprobots[]='127.0.0.1'; 
	return( in_array($ip, $listeiprobots) );
/*        if(in_array($ip, $listeiprobots)) 
              return true;
        else
              return false;*/
} // isMoteur(

function Message_Erreur( $Top, $Message, $Info )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $txt,$param, $entr_url,$Now, $Large, $Enligne;

echo
"<html>
	<head>
		<title>ERREUR $entr_url</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='robots' content='noindex, follow'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
	</head>
<body topmargin='16px' >
	<table bgcolor='#EFEFEF' width='760px' cellpadding='4' cellspacing='0' align='left' border='1' >		
		<tr>
			<td>
				<p align='center'><font size='5'><b><em>$Top</em></b></font></p>";
echo 			"<p align='center'><font size='3' color='#FF0000'>$Message</strong></font><br>
				<font color='#FF0000'></font> <u><font color='#0000FF'><a href='".$entr_url."' target='_self'>$entr_url</a></font></u></p>";
echo 			"<p align='center'><strong><font size='2'>$Info</font></strong></p>
				<p align='center'><strong><a href='javascript:history.back()'>";
				// **** Choix de la langue de travail ****
				switch( @$_SESSION['langue'] ) {
					case "en" : 	echo "To return to the previous page, Click Here";
										break;
					case "fr" : 	echo "Pour revenir à la page précédente, cliquez ici";
										break;
					default : 		echo "Para volver a la página anterior, haga clic aquí";
				
				} // switch SLangue
echo			"</a></strong></p><br>
			</td>
	  	</tr>
		<tr>
			<td>
				Date : $Now
			</td>
	  	</tr>
	</table>
</body>
</html>";
exit();
} // function Message_Erreur

function recherche($criteres, $categorie)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Recherche
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database;

	if( !is_array( $criteres ) )
		return false;
	
	// array de retour contient 
	//  les IDdes produits trouvés selon les critères
	$ids = array();
	// La liste des catégorie de recherche
	$allCats = '';
	
	// Es-ce une catégorie principal
	$query = "SELECT parent FROM $database.catalogue WHERE id = $categorie";
	$query = mysql_query($query, $handle ) ;
	if( $query && mysql_num_rows( $query ) ) {
//	if( !in_array( $categorie, array(0,256) ) ){
		$parent = mysql_fetch_array($query);
//		echo "Parent = ".$parent[0]."<br>";
		// es-ce une catégorie parent
		if( $parent[0] == 0 ) {
//			echo "Ok Parent = 0<br>";
			// recherche de la categorie principal
			$cats = array();
			$cats[] = 'id_catalogue = '.$categorie;
			// Recherche des sous categorie
			$query = "SELECT id FROM $database.catalogue WHERE parent = $categorie";
			$query = mysql_query($query, $handle ) 
				or die('Erreur à la sélection des sousCats :: '.mysql_error());
			while($cat = mysql_fetch_assoc($query))
				$cats[] = 'id_catalogue = '.$cat['id'];
			
			$allCats = implode(' OR ', $cats);
//			echo "AllCat = ".$allCats."<br>";
		} // Si parent  est a zero
	} // Si une categorie
		
	/*** on bâti la requête ***/
	$toAdd = array();
	
	$query = "SELECT * FROM $database.stock ";
	// selon les critères
	foreach($criteres as $index => $critere){
		if( strlen($critere) ) {
			$toAdd[] = 'titre_fr LIKE "%'.$critere.'%"';
			$toAdd[] = 'titre_en LIKE "%'.$critere.'%"';
			$toAdd[] = 'titre_sp LIKE "%'.$critere.'%"';
			$toAdd[] = 'description_fr LIKE "%'.$critere.'%"';
			$toAdd[] = 'description_en LIKE "%'.$critere.'%"';
			$toAdd[] = 'description_sp LIKE "%'.$critere.'%"';
		}
	}
	if( count($toAdd) > 0 )
		$query .= " WHERE (".implode(' OR ', $toAdd);
		
	$query .= ") AND online = '1';";
		
//	echo "Sql = ".$query."<br>";
	$query = mysql_query($query, $handle ) 
		or die("Sélection selon critères : ".mysql_error()."<br>".$query);
		
		// Ici on a tous les ID selon les critères, mais TOUTES les catégories
		
//	if( !in_array( $categorie, array(0,256) ) ){
	if( strlen($allCats) ){
		$query2 = "SELECT id_produit FROM $database.catalogue_produits WHERE $allCats";
//		echo "AllCats = ".$query2."<br>";
		$query2 = mysql_query($query2, $handle ) 
			or die('sous-sélection :: '.mysql_error());
		$prod_filter = array();
		while( $prod = mysql_fetch_array($query2) )
			$prod_filter[] = $prod[0];
		
		while($r = mysql_fetch_assoc($query))
			if( in_array($r['id'],$prod_filter) )
				$ids[] = $r['id'];
	} // Si pas de catégorie
	else{
		while( $r = mysql_fetch_assoc($query) )
			$ids[] = $r['id'];
		
	} // Sinon si pas de categorie = avec categorie
	
	return $ids;
} // fin de la fonction : recherche 

function selectionRecherche( $idsProduits )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : selectionRecherche
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : selectionne les produits selon un tableau de ID passe en param.
{
global $handle, $database;

    if( !is_array($idsProduits) )
        return false;

    $recherche = array();
		$i = 0;
    foreach( $idsProduits as $index => $prodId ){
        if( $prodId != NULL ){
        		$sql = 'SELECT *, titre_'.$_SESSION['langue'].' AS nom, description_'.$_SESSION['langue'].' AS description';
            $sql .= " FROM $database.stock WHERE id ='$prodId' LIMIT 1;";
            $result = mysql_query($sql, $handle )  
					or die("selectionRecherche :: Infos de produits :: ".mysql_error());
//				$recherche[$i++] = $result;
            $query = mysql_fetch_assoc($result);

            foreach( $query as $colonne => $value )
                $recherche[$prodId][$colonne] = $value;
            
        }
    }

    return $recherche;
} // fin de la fonction : selectionRecherche 


function adjust_path($cat)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : adjust_path
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : ajuste le path de catÈgorie pour le menu
{
    $path = get_cat_path($cat);
    $path = array_reverse($path);
    $path[] = 0;
    $path = array_reverse($path);
    $path[] = $cat;

    return $path;
} // fin de la fonction : adjust_path 

function list_cats_checkbox($upcat=0,$level=1)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : list_cats_checkbox
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : Listing des catÈgories avec checkbox aux catÈgories n'ayant pas d'enfants
{

	$sousCats = get_subcats($upcat);
	foreach($sousCats as $id => $nom){
		for($i=0; $i<$level; $i++)
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	
		if(count(get_subcats($id)) == 0)
			echo '<input type="checkbox" name="chkCat[]" value="'.$id.'"/>';
			
		echo $nom,'<br>';
		list_cats_checkbox($id,($level+1));
	}
	
} // fin de la fonction : list_cats_checkbox ------------------------------------------------------


function list_cats($id=0, $lvl=0, $check=-1,$sous)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : list_cats
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : retourne le menu entier par rapport ý une sous-catÈgorie donnÈe
{
    $sousCats = get_subcats($id);
    /*
    echo '<br><br>';
    var_dump($sousCats);
    echo '<br><br>';
    */
    echo '<br>\n';
    if(is_array($sousCats))
    {
        foreach($sousCats as $categorie => $nom)
        {
             echo '<option value="',$categorie,'"';
             if($check != -1 && $check == $categorie)
                 echo " selected>";
             else
                 echo '>';
             for($i=0;$i<$lvl;$i++)
               if($sous=='4')
               { 
               echo "&nbsp;&nbsp;&nbsp;";
               }
             echo '- ',$nom,'</option>';
             list_cats($categorie, ($lvl+1), $check,4);
        }
      
    }
} // list_cats

function afficher_un_produit( $produit, $NoCat, $Retour, $Page )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $param, $handle, $txt, $database, $TxCUC_USD,$TXUSD_CAD,$TXUSD_EUR,$SymbCUC,$SymbUSD,$SymbCAD,$SymbEUR;

//	$_SESSION['TotProd']++;
	extract($produit);
	$titre = stripslashes($produit['titre_'.$_SESSION['langue']]);
	$Symbole	=	get_Symbole($_SESSION['devise']);

	switch( $_SESSION['devise'] ) {
		case 'CUC'	:	$image = 'gifs/cuba.gif';
					$prix  = rounder($prix_detail);
					break;
		case 'USD'	:	$image  = 'gifs/usa.gif';
					$prix	=rounder($prix_detail * $TxCUC_USD);
					break;
		case 'EUR'	:	$image = 'gifs/europe.gif';
					$prix  =rounder(($prix_detail * $TxCUC_USD) * $TXUSD_EUR);
					break;
		default		:  	$image = 'gifs/canada.gif';
					$prix  = rounder($prix_detail);
					break;
	} // switch devise

		echo '
			<tr>
				<td>
					<table width=100% cellpadding=8 border=0>
						<tr>
							<td width=120 align=center Valign=middle>';
							if( $big ) 
								echo "<a href='javascript:VoirZoom($id);'>";

							$LargX = $param['image_list_largeur'];
							$HautY = $param['image_list_hauteur'];
							$sql = " SELECT Largeur, Hauteur FROM $database.photo WHERE NoInvent='$id' AND NoPhoto='$small';";
							$result = mysql_query( $sql, $handle );
							if( $result &&  mysql_num_rows($result) ) {
								$L = @mysql_result($result, 0, "Largeur");
								$H = @mysql_result($result, 0, "Hauteur");
								if( ($difL = $L - $LargX) < 0 ) $difL = 0; 
								if( ($difH = $H - $HautY) < 0 ) $difH = 0;
								if( $difL || $difH ) {
									if( $difL > $difH ) {
										$Pourcent = $LargX/$L;
										$LargX = $L*$Pourcent;
										$HautY = $H*$Pourcent;
									}
									else {
										$Pourcent = $HautY/$H;
										$LargX = $L*$Pourcent;
										$HautY = $H*$Pourcent;
									}
								}
								else {
									$LargX = $L;
									$HautY = $H;
								}
							} // Si une photo

							echo "<img src='photoget_web.php?No=$id&Idx=$small' alt='$titre' border='0' width='$LargX' height='$HautY'></a>";
							//  bgcolor='DBE5FE' 
							echo "
							</td>
							<td align='left'>
								<table cellpadding='4' cellspacing='0' width='100%' border='0'>
									<tr>
										<td width='100%' align='left'>
											<span class=titre>$titre $Code</span>	
										</td>
										<td>&nbsp;
										</td>
									</tr>
								</table>
								<span class='description'>".stripslashes($produit['description_'.$_SESSION['langue']])."</span><br>
								<span class='prix'>
									<img src='$image'/>&nbsp;&nbsp;<b>$prix</b> $Symbole&nbsp;(".$_SESSION['devise'].")<sup>*</sup>";
							  echo "<br><br>
								</span>
            							<form name='ajout$id' action='panier_traite.php?retour=$Retour' method='POST'>
									<input type='hidden' name='cat' value='$NoCat'>
									<input type='hidden' name='CodePanier' value='1'>
									<input type='hidden' name='id' value='$id'>
									<input type='hidden' name='Target' value='$Page'>
									<a href='produit_detail.php?cat=$NoCat&id=$id' target='$Page' class='titre'>".$txt['plus_de_details']."</a>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href='envoi_ami.php?cat=$NoCat&id=$id' class='titre'>".$txt['envoyer_ami']."</a>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>";

} // afficher_categorie_list

function afficher_categorie_list( $ressource, $NoCat )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
	while( $produit = mysql_fetch_assoc( $ressource ))
		afficher_un_produit( $produit, $NoCat, 3, 'ACCUEIL' );	
} // afficher_categorie_list

function afficher_categorie_rech( $produits )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{


   foreach($produits as $produit)
		afficher_un_produit( $produit, 0, 5, 'MAIN' );	
   
} // afficher_categorie_rech

?>