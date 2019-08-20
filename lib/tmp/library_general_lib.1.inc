<?php
//* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
//* MAJ : Denis Léveillé 	 			  Date : 2007-12-21

// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________

function Langue($langue)
function mysql_next_id($table, $id_column) {
function myAddSlashes( $string ) 
function hexentities($str) 
function CleanUp( $str ) 
function get_ip() 
function generatePassword( $length = 8 )
function rounder($value)
function Suivi_log($Mess, $No)
function Suivi_log_interne($Mess, $No)
function AlloWebmaster( $sujet, $info )
function DonneFormatJPEG( $filename, &$LargeX, &$HautY )
function ValideNoCarteCredit( $str )
function Detect_IE()
function ValideUnixDate( $AValider ) 
function ValideStrDate( $AValider ) 
function greg_jd( $month, $day, $year )
function array_combine_emulated( $keys, $vals ) 
**********************************************************************************************/

//ini_set ("max_execution_time","90"); 

//cette ligne met le timeout à 90, le temps peut etre ralonger en fonction des besoins... Il suffi de la mettre en debut de page


function Langue($langue)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Langue
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 11-06-08
//  derniere modif : Jean-Alexandre Denis
//  info : Selectionne la langue dans la base
{
global $handle, $database;
	$lang = array();
	
	$sql = "SELECT id, $langue FROM $database.messgen";

	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès Langue", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	while( $r = mysql_fetch_assoc($result) )
		$lang[$r['id']] = $r[$langue];
	
	return $lang;

} // fin de la fonction : Langue


function mysql_next_id($table, $id_column) {

/*show table status like '%client' 
SELECT LAST_INSERT_ID() FROM matable
SELECT MAX(NoClient) AS maxid FROM client*/
  
	$sql = "SELECT MAX($id_column) AS maxid FROM $table;";
	$result = mysql_query($sql);
	if( !$result ) {
		echo( "Erreur mysql_next_id $table $id_column : ".mysql_errno()." : ".mysql_error()."<br>".$sql  );			
		exit();
	}		

	if( mysql_num_rows($result) ) { 
  		$rows = mysql_fetch_assoc($result);
		return ( $rows['maxid'] + 1 );
   }
   else
   	return( 0 );
} // mysql_next_id


function myAddSlashes( $string ) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : myAddSlashes
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Add des slash dasn une chaine de caractère afin de la sauver dans une BD
{ 
  if (get_magic_quotes_gpc()==1)  
    return ( $string ); 
  else  
    return ( addslashes ( $string ) ); 
   //mysql_real_escape_string(). 	
	
} // Addslash 
  
function hexentities($str) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : hexentities
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Scribouille une adresse courriel pour éviter d'être sniffer par un Robot SPY
{
   $return = '';
   for($i = 0; $i < strlen($str); $i++) {
       $return .= '&#x'.bin2hex(substr($str, $i, 1)).';';
   }
   return $return;
} // hexentities
  
function CleanUp( $str ) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : CleanUp
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Oter tout script possible dasn une chaine - protection Hacker
{
 	$str = strip_tags( $str );
	$str = nl2br( $str );
	$str = htmlspecialchars( $str );
	return( $str );
} // Clean
 
function get_ip() 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : get_ip
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Allez charche l'adresse IP d'un client
{ 
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) 
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	else
		$ip = $_SERVER['REMOTE_ADDR']; 
	return $ip;  
}  // get_ip

function generatePassword( $length = 8 )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : generatePassword
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Généré un mot de passe aléatoire
{

  // start with a blank password
  $password = "";

  // define possible characters
//  $possible = "0123456789abcdefghjkmnpqrstvwxyzABCDEFGHJKMNPQRSTVWWXYZ"; 
  $possible = "123456789abcdefghjkmnpqrstvwxyz"; 
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 
    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }
  }

  // done!
  return $password;

}

function rounder($value)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : rounder
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 03-12-04
//  derniere modif : Daniel de Varennes
//  info : Selectionne les variables de la BD : pour arrondir a deux chiffres apres la virgule
{
	if( $Ptr = strtok($value,"$") )
		$value = $Ptr;
	$value *= 100;
	$value = ceil( $value );
	$value = round( $value );
	$value /= 100;
	$point_pos = strpos( $value, "." );
	if( !$point_pos )
		$value .= ".00";
	elseif( (strlen($value) - $point_pos) == 2 )
		$value .= "0";
	
	return $value;
} // fin de la fonction : rounder --


function Suivi_log($Mess, $No)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Suivi
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi dans le fichier LOG d'une opération - TRACE
{
global $handle, $database, $Now;
	// *** LAISSE UNE TRACE DANS LE FICHIER LOG
   $sql = "INSERT INTO $database.login ( NomLogin, DateLogin, Operation, NoId )";
   $sql .= " VALUES ('".$_SESSION['NomLogin']."','$Now', '$Mess', '$No')";
   mysql_query( $sql,$handle )
       or die( "ERREUR LOGIN: ".mysql_errno().": ".mysql_error() );
} // fin de la fonction : rounder --

function Suivi_log_interne($Mess, $No)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Suivi
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi dans le fichier LOG d'une opération - TRACE
{
global $handle, $database, $Now;
	// *** LAISSE UNE TRACE DANS LE FICHIER LOG
   $sql = "INSERT INTO $database.suivi ( NomLogin, DateLogin, Operation, NoId )";
   $sql .= " VALUES ('".$_SESSION['NomLogin']."','$Now', '$Mess', '$No')";
   mysql_query( $sql,$handle )
       or die( "ERREUR Suivi: ".mysql_errno().": ".mysql_error() );
} // fin de la fonction : rounder --

function AlloWebmaster( $sujet, $info )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : AlloWebmaster
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi par courriel au Webmester
{ 
global $param,$entr_url,$Now;

		//----------------------------------------------- 
     //PIECE JOINTE 
     //----------------------------------------------- 

     /*$message .= 'Content-Type: image/jpeg; name="nom_du_fichier.jpg"'."\n"; 
     $message .= 'Content-Transfer-Encoding: base64'."\n"; 
     $message .= 'Content-Disposition:attachement; filename="nom_du_fichier.jpg"'."\n\n"; 

     $message .= chunk_split(base64_encode(file_get_contents('nom_du_fichier.jpg')))."\n";*/ 


	$entete = "MIME-Version: 1.0\r\n";                                 // le MIME approprié
	$entete = "Return-Path: ".$param['email_compte']."\r\n"; 
	$entete .= "Content-Type: text/html; charset=iso-8859-1\r\n";     // OU l'envoie html
	$entete .= "Content-Transfer-Encoding: 8bit\r\n";                   // nombre de bits d'encodage (8bits)
	$entete .= "X-Mailer: PHP/".phpversion()."\n";                      // l'e-maileur
//	$entete .= "From: ".$param['nom_client']." ".$param['email_compte']."\r\n";                          // qui l'envoie ?
	$entete .= "From: ".$param['email_compte']."\r\n";                          // qui l'envoie ?
	$entete .= "Reply-To: ".$param['email_support']."\n";                                 // son adresse

	ob_start();
	echo
	"<html>
		<head>
			<title>Un Message de $entr_url</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		</head>";
	include('styles/style.inc');
	echo "<body width='600px' >
	<br>
	<table bgcolor='#FFFFFF' width='600px' cellpadding='4' cellspacing='4' border='1' align='center' >
		<tr>
			<td align='center'>";
	echo $info;		
	echo "</td>
		</tr>
		<tr>
			<td align='right'>
				En date du :  <i>$Now</i><br/><br/>
			</td>
		</tr>
	</table>
	</body>
	</html>";
	
	$message .= ob_get_contents();
	
	ob_end_clean();

	@mail( $param['email_support'], $sujet, $message, $entete );
	
//   if( !@mail($AdrWebmestre,$sujet,$message,$entete) )
//		echo "<br><br>To : $AdrWebmestre<br>Head : ".$entete."<br>Sujet : ".$sujet."<br>Mess : ".$message."<br>";
	
} // function AlloWebmaster

/******************************************************************************
* Function:     DonneFormatJPEG
* Description:  Trouve le format d'une image JPEG 
* Parameters:   filename - le nom du fichier JPEG
* Returns:      LargeX - largeur de l'image
*               HautY - hauteur de l'image
******************************************************************************/
function DonneFormatJPEG( $filename, &$LargeX, &$HautY )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : DonneFormatJPEG
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-03-09
//  Auteur : Denis Léveillé
//  Info : Trouve le format d'une image JPEG 
// Parameters:   filename - le nom du fichier JPEG
// Returns:      LargeX - largeur de l'image
//               HautY - hauteur de l'image
{
	$BitComp = 0;
 		$LargeX = $HautY = 0;
        // Empêche l'usager de changer de page ou de rafraichir
        ignore_user_abort(true);

        // Attempt to open the jpeg file - the at symbol supresses the error message about
        // not being able to open files. The file_exists would have been used, but it
        // does not work with files fetched over http or ftp.
        $filehnd = @fopen($filename, 'rb');

        // Es-ce réussi ?
        if( !$filehnd  ){
                echo "<p>Impossible d'ouvrir $filename</p>\n";
                return FALSE;
        }

        // Lecture des 2 premiers octets
        $data = fread( $filehnd, 2 );

        // Toput les fichiers JPEG débute avec les 2 caractèrese 0xFFD8  (SOI - Start of image)
        if( $data != "\xFF\xD8" ) {
                // Pas de SOI (FF D8)
                echo "<p>Ce fichier n'est probablement pas un JPEG</p>\n";
                fclose($filehnd);
                return FALSE;
        }

        // Lecture du 3ieme octet
        $data = fread( $filehnd, 2 );

        // Vérifier sie le 3ieme octet est 0xFF (Début du premier segment d'entête)
        if( $data{0} != "\xFF" ){
                // Pas de FF - OUPS ! le JPEG est probablement invalide
                fclose($filehnd);
                return FALSE;
        }

        // Indique que nous n'avons pas encore atteint les données de l'image compressé
        $SegmentImage = FALSE;

        // Cycle through the file until, one of: 1) an EOI (End of image) marker is hit,
        //                                       2) we have hit the compressed image data (no more headers are allowed after data)
        //                                       3) or end of file is hit

        while ( ( $data{1} != "\xD9" ) && !$SegmentImage && !feof( $filehnd ) ){
                // On à lut un Marqueur de Segment.
                // Vérifier que le marqueur de segment n'est pas Restart - Les marqueur Restart n'on pas de grosseur ou de données
                if (  ( ord($data{1}) < 0xD0 ) || ( ord($data{1}) > 0xD7 ) ){
                        // Lecture des 2 prochains octets (size)
                        $sizestr = fread( $filehnd, 2 );

                        // convertir les bytes de size en entier
                        $decodedsize = unpack ("nsize", $sizestr);

                        // Lecture du segment de données de longeur size
                        $segdata = fread( $filehnd, $decodedsize['size'] - 2 );
	 					    // Si c'est un marqueur "SOF" (Start Of Frame) alors prendre le format
                		if (  ( ord($data{1}) >= 0xC0 ) && ( ord($data{1}) <= 0xC3 ) ){
                		// First byte is Bits per component
                		   $BitComp = ord( $segdata{0} );

                		// Second and third bytes are Image Height
                		   $HautY = ord( $segdata{ 1 } ) * 256 + ord( $segdata{ 2 } );

                		// Forth and fifth bytes are Image Width
                		   $LargeX = ord( $segdata{ 3 } ) * 256 + ord( $segdata{ 4 } );

                		// Sixth byte is number of components
                		   $numcomponents = ord( $segdata{ 5 } );
						   
/*						   $str = "Ok BitComp = ".$BitComp;
						   $str .= "/ Y = ".$HautY;
						   $str .= "/ X = ".$LargeX;
						    echo("<SCRIPT LANGUAGE='javascript'>");
							echo("window.alert('$str');");
							echo("</SCRIPT>");*/
						   return $BitComp;
						}

                }

                // Si c'est un marqueur de segment SOS (Start Of Scan), alors la lecture de l'entête est terminé - les données de l'image compressé suive
                if ( $data{1} == "\xDA" ){
                        // Indiquer que nous avons atteint l'image compressé - Srtie de la boucle plus d'entête à lire.
                        $SegmentImage = TRUE;
                } // Si DA
                else {
						
                        // PAS un SOS - Lecture des 2 prochain octets - doit etre le marqueur de segment pour le prochain segment
                        $data = fread( $filehnd, 2 );

        				// Vérifier si le 1ier octet des 2 est 0xFF comme cela doit etre pour un marqueur
        				if( $data{0} != "\xFF" ){
                			// Pas de FF - OUPS ! le JPEG est probablement invalide
                			fclose($filehnd);
                			return FALSE;
        				} // Si pas FF
                } // Sinon pas DA
        }

        // Fermer le fichier
        fclose($filehnd);
        // Autoriser l'usager à faire ce qu'il veut
        ignore_user_abort(false);

        return $BitComp;
}  // DonneFormatJPEG

function ValideNoCarteCredit( $str )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : ValideNoCarteCredit
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-08
//  derniere modif : Denis Léveillé
//  Info : Utilise la méthode «Luhn check» pour valider un numéro de carte de crédit
{
		//-------------------
		// Perform Luhn check
		//-------------------
	  	if( ctype_digit($str) ) {   
	  		$sum = 0;
			$timesTwo = false;
			
			for( $i = (strlen($str) - 1) ; $i >= 0 ; $i-- ) {
				$digit = $str[$i];
				if( $timesTwo ) {
					$digit *= 2;
					if( $digit > 9) 
						$digit -= 9;
				}
				$sum += $digit;
				$timesTwo = !$timesTwo;
			} // for i
			$modulus = $sum % 10;
			return( $modulus != 0 );
		} // si un nombre
		else {
			//echo "Chaine invalide (PAS ENTIER)=>".$str."<br>";
			return( 1 );
		}

} // ValideNoCarteCredit

function Detect_IE()
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Detect_IE
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-03-09
//  derniere modif : Denis Léveillé
//  Info : Utilise la chaine USER AGENT pour detecter si nous sommes en présence de Internet Explorer
{    
	if( isset($_SERVER['HTTP_USER_AGENT']) && ( strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false) )        
		return true;    
	else        
		return false;
}

function ValideUnixDate( $AValider ) 
{
 $t = time();
 if( date( "y" , $t ) == date( "y", $AValider ) ) {
 	 if( date( "n" , $t ) == date( "n", $AValider ) ) {
 	 	 if( date( "j" , $t ) == date( "j", $AValider ) ) {
		 	 return 1;
		 } // si jour
	 } // si mois
 } // si année
 return 0;
} // ValideDate
 
function ValideStrDate( $AValider ) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : ValideStrDate
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-08
//  derniere modif : Denis Léveillé
//  Info : Utilise la méthode «Luhn check» pour valider un numéro de carte de crédit
{
 $t = time();
 $AV = strtotime( $AValider );
 if( date( "y" , $t ) == date( "y", $AV ) ) {
 	 if( date( "n" , $t ) == date( "n", $AV ) ) {
 	 	 if( date( "j" , $t ) == date( "j", $AV ) ) {
		 	 return 1;
		 } // si jour
	 } // si mois
 } // si année
 return 0;
} // ValideDate

function greg_jd( $month, $day, $year )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : greg_jd
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2004-01-01
//  Auteur : Denis Léveillé
//  Info : Conversion d'une date en jour depuis le christ pour les calculs
{ 
   if ($month > 2) { 
       $month = $month - 3; 
   } else { 
       $month = $month + 9; 
       $year = $year - 1; 
   } 
   $c = floor($year / 100); 
   $ya = $year - (100 * $c); 
   $j = floor((146097 * $c) / 4); 
   $j += floor((1461 * $ya)/4); 
   $j += floor(((153 * $month) + 2) / 5); 
   $j += $day + 1721119; 
   return $j; 
} // GregorianToJD 


 
function array_combine_emulated( $keys, $vals ) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : array_combine_emulated
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2004-01-01
//  Auteur : Denis Léveillé
//  Info : Emulation de la fonction array_emulation include dans php 5
{
	 $keys = array_values( (array) $keys );
	 $vals = array_values( (array) $vals );
	 $n = max( count( $keys ), count( $vals ) );
	 $r = array();
	 for( $i=0; $i<$n; $i++ ) {
	  $r[ $keys[ $i ] ] = $vals[ $i ];
	 }
	 return $r;
}

/*$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
$message = "--$mime_boundary\n";
$message .= "Content-Type: text/plain; charset=UTF-8\n";
$message .= "Content-Transfer-Encoding: 8bit\n\n";*/

function strTrimTotal($input) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : strTrimTotal
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2004-01-01
//  Auteur : Denis Léveillé
//  Info : 
{

    $input = trim($input);
    $output = '';

    for($i=0;$i<strlen($input);$i++) {

        if(substr($input, $i, 1) != " ") {

            $output .= trim(substr($input, $i, 1));

        } else {

            $output .= " ";

        }

    }

    return $output;
} // strTrimTotal

function Suivi($texte)
//  FUNCTION : Suivi
//  version : 1.0
//  date : 2010-04-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi d'une operation dans le fichier login
{
global $handle, $database, $Now;
	
	$sql = "INSERT INTO $database.Login SET ". 
	$sql = "NomLogin = '".$_SESSION['NomLogin']."', DateLogin = '$Now', Operation = '$texte';";

	if( !mysql_query( $sql, $handle ) )
		Message_Erreur( "ERREUR", "Erreur accès Login", mysql_errno()." : ".mysql_error()."<br>".$sql  );
	
	return;

} // fin de la fonction : Suivi

?>