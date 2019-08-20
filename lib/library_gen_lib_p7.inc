<?php
/* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
* MAJ : Denis Léveillé 	 			  Date : 2019-05-15
*/
// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________
function Message_Erreur( $Top, $Message, $Info )
function my_gethostbyaddr($ip) 
function myAddSlashes( $string ) 
function hexentities($str) 
function CleanUp( $str ) 
function get_ip() 
function generatePassword( $length = 8 )
function rounder($value)
function Suivi($texte)
function Suivi_log($Mess, $No)
function Suivi_log_interne($Mess, $No)
function AlloWebmaster( $sujet, $info )
function EnvoiCourriel( $Destinataire, $sujet, $info )
*************
function DonneFormatJPEG( $filename, &$LargeX, &$HautY )
function convert_image_JPG( $source, $destination )
function reduit_image( $source, $destination, $qualite)
*************
function ValideNoCarteCredit( $str )
function Detect_IE()
function ValideStrDate( $AValider ) 
function greg_jd( $month, $day, $year )
function estBissextile( $year )
function DonneJourFinMois( $an,  $mois)
function JourSem( $an, $mois, $jour )
function array_combine_emulated( $keys, $vals ) 
function strTrimTotal($input) 
*************
function LoadNomPrenomParId( $result) 
function formatPhoneNumber($phoneNumber) 
function getRelativePath($from, $to)

**********************************************************************************************/
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require DIR_BASE.'PHPMailer/src/Exception.php';
require DIR_BASE.'PHPMailer/src/PHPMailer.php';
require DIR_BASE.'PHPMailer/src/SMTP.php';
//ini_set ("max_execution_time","90"); 

//cette ligne met le timeout à 90, le temps peut etre ralonger en fonction des besoins... Il suffi de la mettre en debut de page
$NomJourFR = array(
		"0"=>"Dimanche",
		"1"=>"Lundi",
		"2"=>"Mardi",
		"3"=>"Mercredi",
		"4"=>"Jeudi",
		"5"=>"Vendredi",
		"6"=>"Samedi"
		); 
$NomJRFR = array(
		"0"=>"Di",
		"1"=>"Lu",
		"2"=>"Ma",
		"3"=>"Me",
		"4"=>"Je",
		"5"=>"Ve",
		"6"=>"Sa"
		); 
$NomJourEN = array(
 		"0"=>"Sunday",
 		"1"=>"Monday",
 		"2"=>"Tuesday",
 		"3"=>"Wednesday",
 		"4"=>"Thursday",
 		"5"=>"Friday",
 		"6"=>"Saturday"
 		); 
$NomJREN = array(
   		"0"=>"Su",
   		"1"=>"Mo",
   		"2"=>"Tu",
   		"3"=>"We",
   		"4"=>"Th",
   		"5"=>"Fr",
   		"6"=>"Sa"
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

$NomMoisEN = array(		
		"1"=>"January",
		"2"=>"February",
		"3"=>"March",
		"4"=>"April",
		"5"=>"May",
		"6"=>"June",
		"7"=>"July",
		"8"=>"August",
		"9"=>"September",
		"10"=>"October",
		"11"=>"November",
		"12"=>"Décember"
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
		<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
		<meta name='robots' content='noindex, follow'>
		<link href='css/style.css' rel='stylesheet' type='text/css'>
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
					case "sp" : 	echo "Para volver a la página anterior, haga clic aquí";
							break;
					default : 	echo "Pour revenir à la page précédente, cliquez ici";		
				
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


function my_gethostbyaddr($ip) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : my_gethostbyaddr
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{	if( isset( $_SESSION['LeHost'] ) && strlen($_SESSION['LeHost']) )
		return $_SESSION['LeHost'];
	else
		$_SESSION['LeHost'] = @gethostbyaddr($ip) or ($_SESSION['LeHost']= 'host inconnu');
	
	return $_SESSION['LeHost'];
} // my_gethostbyaddr



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

function addslashes_array($a){
	if(is_array($a)){
		foreach($a as $n=>$v){
			$b[$n]=addslashes_array($v);
		}
		return $b;
	}else{
		return addslashes($a);
	}
}
  
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

function format_phone($phone)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : format_phone
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  Auteur : inconnu
//  derniere modif : Denis Léveillé
//  info : formatter un numéro de téléphone
{
    $phone = preg_replace("/[^0-9]/", "", $phone);
// echo "Tel ".$phone."<br/>";
    if(strlen($phone) == 7)
        return preg_replace("/(\d{3})(\d{4})/", "$1-$2", $phone);
    elseif(strlen($phone) == 10)
        return preg_replace("/(\d{3})(\d{3})(\d{4})/", "($1) $2-$3", $phone);
    elseif(strlen($phone) == 11)
        return preg_replace("/(\d{1})(\d{3})(\d{3})(\d{4})/", "$1-$2-$3-$4", $phone);
    else
        return $phone;
} // format_phone
 
function get_ip() 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : get_ip
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Allez charche l'adresse IP d'un client
{ 
//echo "X ".$_SERVER['HTTP_X_FORWARDED_FOR']."Cli ".$_SERVER['HTTP_CLIENT_IP'],"Rem ".$_SERVER['REMOTE_ADDR'];
/*	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) 
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];  
	elseif(isset($_SERVER['HTTP_CLIENT_IP'])) 
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	else*/
		
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

} // generatePassword

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

function Suivi($texte)
//  FUNCTION : Suivi
//  version : 1.0
//  date : 2010-04-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi d'une operation dans le fichier login
{
global $mabd, $database, $Now;
	
	$sql = "INSERT INTO $database.login SET ". 
	$sql = "NomLogin = '".$_SESSION['NomLogin']."', DateLogin = '$Now', Operation = '$texte';";

	if( !$mabd->query($sql) ) 
		Message_Erreur( "ERROR", "Erreur accès Login ", $mabd->errno." : ".$mabd->error."<br>".$sql  );
	
	return;

} // fin de la fonction : Suivi

function Suivi_log($Mess, $No)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Suivi
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi dans le fichier LOG d'une opération - TRACE
{
global $mabd, $database, $Now;
	// *** LAISSE UNE TRACE DANS LE FICHIER LOG
   	$sql = "INSERT INTO $database.login ( NomLogin, DateLogin, Operation, NoId )";
   	$sql .= " VALUES ('".$_SESSION['NomLogin']."','$Now', '$Mess', '$No')";
	if( !$mabd->query($sql) ) 
		Message_Erreur( "ERROR", "Erreur accès Login ", $mabd->errno." : ".$mabd->error."<br>".$sql  );

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
global $mabd, $database, $Now;
	// *** LAISSE UNE TRACE DANS LE FICHIER LOG
	$Mess = AddSlashes($Mess);
  	$sql = "INSERT INTO $database.suivi ( NomLogin, DateLogin, Operation, NoId )";
   	$sql .= " VALUES ('".$_SESSION['NomLogin']."','$Now', '$Mess', '$No')";
	if( !$mabd->query($sql) ) {
		echo "ERROR"."Erreur accès suivi ".$mabd->errno." : ".$mabd->error."<br>".$sql;
		//Message_Erreur( "ERROR", "Erreur accès suivi ", $mabd->errno." : ".$mabd->error."<br>".$sql  );
		exit();
	}
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

	ob_start();
	echo
	"<html>
		<head>
			<title>Un Message de $entr_url</title>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		</head>";
	include('css/style.inc');
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

	// Instantiation and passing `true` enables exceptions
	$mail = new PHPMailer(true);
	
	try {
		//Server settings
		//$mail->SMTPDebug = 2;                                       // Enable verbose debug output
     		//$langcode  ISO 639-1 2-character language code (e.g. French is "fr")
     		//$lang_path Path to the language file directory, with trailing separator (slash)
	    	$mail->setLanguage($langcode = 'fr', 'PHPMailer/language/');
    		$mail->CharSet = PHPMailer::CHARSET_UTF8;
		$mail->isSMTP();                                            // Set mailer to use SMTP
		$mail->Host       = 'mail.cosat.biz';  // Specify main and backup SMTP servers
		$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
		$mail->Username   = 'webmaster@cosat.biz';                     // SMTP username
		$mail->Password   = 'mibuq1987';                               // SMTP password
		$mail->SMTPSecure = 'tls';                                  // Enable TLS encryption, `ssl` also accepted
		$mail->Port       = 587;                                    // TCP port to connect to
		
		//Recipients
		$mail->setFrom($param['email_compte'], $param['nom_client']);
		$mail->addReplyTo($param['email_support'], 'Information');
		$mail->addAddress($param['email_support'], 'Erreur');     // Add a recipient
		
		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = $sujet;
		$mail->Body    = $message;
		$mail->AltBody = 'Ce message nécessite un client Courriel HTML pour être lut';
		
		$mail->send();
		$Mess = "Message Envoyer : ".$info;
		Suivi_log_interne( $Mess, 000 );
	} catch (Exception $e) {
		$Mess = sprintf( "Erreur envoi : (%s) Mess: %.200s",$mail->ErrorInfo, $info);
		Suivi_log_interne( $Mess, 911 );
	    
	}

	
} // function AlloWebmaster

function AlloWebmaster_old( $sujet, $info )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : AlloWebmaster
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 08-02-07
//  derniere modif : Denis Léveillé
//  info : Faire un suivi par courriel au Webmester
{ 
global $param,$entr_url,$Now;

	$entete = "MIME-Version: 1.0\r\n";                                 // le MIME approprié
	$entete = "Return-Path: ".$param['email_compte']."\r\n"; 
	$entete .= "Content-Type: text/html; charset=UTF-8\r\n";     // OU l'envoie html
	$entete .= "Content-Transfer-Encoding: 8bit\r\n";                   // nombre de bits d'encodage (8bits)
	$entete .= "X-Mailer: PHP/".phpversion()."\n";                      // l'e-maileur
	$entete .= "From: ".$param['email_compte']."\r\n";                          // qui l'envoie ?
	$entete .= "Reply-To: ".$param['email_compte']."\n";                                 // son adresse

	ob_start();
	echo
	"<html>
		<head>
			<title>Un Message de $entr_url</title>
			<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
		</head>";
	include('css/style.inc');
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

	$R = '-f'.$param['email_compte'];
	if( mail( $param['email_support'], $sujet, $message, $entete, $R ) ) {
		$Mess = "Message Envoyer : ".$info;
		Suivi_log_interne( $Mess, 000 );
		return true;
	}
	else {
		$_SESSION['errorMail'] = error_get_last()['message'];
		$Mess = sprintf( "Erreur envoi : %s Mess: %.200s",$_SESSION['errorMail'], $info);
		Suivi_log_interne( $Mess, 911 );
		return false;
	}

	//@mail( $param['email_support'], $sujet, $message, $entete );
	
//   if( !@mail($AdrWebmestre,$sujet,$message,$entete) )
//		echo "<br><br>To : $AdrWebmestre<br>Head : ".$entete."<br>Sujet : ".$sujet."<br>Mess : ".$message."<br>";
	
} // function AlloWebmaster

function EnvoiCourriel( $Destinataire, $sujet, $info )
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
	$entete .= "Content-Type: text/html; charset=UTF-8\r\n";     // OU l'envoie html
	$entete .= "Content-Transfer-Encoding: 8bit\r\n";                   // nombre de bits d'encodage (8bits)
	$entete .= "X-Mailer: PHP/".phpversion()."\n";                      // l'e-maileur
//	$entete .= "From: ".$param['nom_client']." ".$param['email_compte']."\r\n";                          // qui l'envoie ?
	$entete .= "From: ".$param['email_compte']."\r\n";                          // qui l'envoie ?
	$entete .= "Reply-To: $Destinataire\n";                                 // son adresse

	ob_start();
	echo
	"<html>
		<head>
			<title>Un Message de $entr_url</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		</head>";
	include('css/style.inc');
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

	@mail( $Destinataire, $sujet, $message, $entete );
	
//   if( !@mail($AdrWebmestre,$sujet,$message,$entete) )
//		echo "<br><br>To : $AdrWebmestre<br>Head : ".$entete."<br>Sujet : ".$sujet."<br>Mess : ".$message."<br>";
	
} // function EnvoiCourriel


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

function convert_image_JPG( $source, $destination )
/*********************************************************
  FUNCTION : reduit_image
  version : 1.0
  date : 2017-11-05
  info : Converti un fichier image (GIF, PNG, BMP) en JPEG
  derniere modif : Denis Léveillé 
*********************************************************/
{
$ret = true;

	$info = getimagesize($source);
	
	if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source);
	
	elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source);
	
	elseif ($info['mime'] == 'image/png') 
		$image = imagecreatefrompng($source);
		
	elseif( $info['mime'] == 'image/bmp') 
		$image = imagecreatefrombmp($source);
		
	else {
 		// echo "oups : ".$source."</br>";
                 /* Création d'une image vide */
	        $image = imagecreatetruecolor (150, 30);
	        $bgc = imagecolorallocate ($image, 255, 255, 255);
	        $tc = imagecolorallocate ($image, 0, 0, 0);
	
	        imagefilledrectangle ($image, 0, 0, 150, 30, $bgc);
	
	        /* Affiche un message d'erreur dans l'image */
	        imagestring ($image, 1, 5, 5, 'Format Image invalide '.$source, $tc);  
		return false;
	  
    	}
  	
    	$ret = imagejpeg( $image, $destination );        

    	return $ret;
} // convert_image_JPG

function reduit_image( $source, $destination, $qualite)
/*********************************************************
  FUNCTION : reduit_image
  version : 1.0
  date : 2017-11-05
  info : Reduit la taille d'un fichier après l'avoir converti en JPEG
  derniere modif : Denis Léveillé
*********************************************************/
{
$ret = true;

	$info = getimagesize($source);
	
	if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source);
	
	elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source);

    	elseif ($info['mime'] == 'image/png') 
        	$image = imagecreatefrompng($source);

	elseif( $info['mime'] == 'image/bmp') 
		$image = imagecreatefrombmp($source);

    	else {
	    	//	echo "oups : ".$source."</br>";
	    	return false;
	        /* Création d'une image vide */
	        $image = imagecreatetruecolor (150, 30);
	        $bgc = imagecolorallocate ($image, 255, 255, 255);
	        $tc = imagecolorallocate ($image, 0, 0, 0);
	
	        imagefilledrectangle ($image, 0, 0, 150, 30, $bgc);
	
	        /* Affiche un message d'erreur dans l'image */
	        imagestring ($image, 1, 5, 5, 'Format Image invalide '.$source, $tc);  
	  
    	}
  	

    	$ret = imagejpeg($image, $destination, $qualite);        

   	 return $ret;
} // reduit_image



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

function estBissextile( $year )
/************************************************************
   FONCTION: estBissextile
   BUT:	Nous indique si une année est Bissextile
   AUTEUR: Denis Leveille	DATE: 2016/10/05
************************************************************/
{
	if ( (($year % 400) == 0) || ((($year % 4) == 0) && (($year % 100) != 0)) )
     		return( true );
 	else
     		return( false );
} // estBissextile

function DonneJourFinMois( $an,  $mois)
/************************************************************
   FONCTION: DonneJourFinMois
   BUT:	Donne le jour pour la fin du mois fourni.
   AUTEUR: Denis Leveille	DATE: 02/03/95
************************************************************/
{
$tab_jour = array(0,31,28,31,30,31,30,31,31,30,31,30,31);
$jour=0;
	if( $mois <= 12 ) {
		$jour = $tab_jour[$mois];
		if( ($mois == 2) && !( $an % 4 ) ) $jour++;
	}
	return( $jour );

} /* DonneJourFinMois */

function JourSem( $an, $mois, $jour )
/************************************************************
   FONCTION: JourSem
   BUT:	Donne le jour dans la semaine de 0 à 6.
   AUTEUR: Denis Leveille	DATE: 02/03/95
************************************************************/
{
 /* The Month_Code is used to find the Day of the Week (LY = LeapYear/Année bissextile )*/
$Month_Code =    array(0, 1, 4, 4, 0, 2, 5, 0, 3, 6, 1, 4, 6);
$Month_Code_LY = array(0, 0, 3, 4, 0, 2, 5, 0, 3, 6, 1, 4, 6);

 /* The Century_Code is used to find the Day of the Week */
$Century_Code  = array(0, 6, 4, 2);
$wDayOfWeek;

	if ( !estBissextile($an) ) {
		/*
		(Century_Code+Month_Code+Year_Code+Day) % 7

		The century code repeats every 400 years , so the array
		works out like this,

		Century_Code[0] is for 16th/20th Centry
		Century_Code[1] is for 17th/21th Centry
		Century_Code[2] is for 18th/22th Centry
		Century_Code[3] is for 19th/23th Centry

		The year code is found with the formula (year + (year / 4))
		the "year" must be between 0 and 99 .

		The Month Code (Month_Code[1]) starts with January and
		ends with December.
		*/

		$wDayOfWeek = (( $Century_Code[(( ($an+100) - ( $an % 100) ) / 100) %4] + (( $an % 100 )+( $an % 100 )/4)+ $Month_Code[$mois] + $jour) % 7);

	}
	else  {
		$wDayOfWeek = (( $Century_Code[(( ($an+100) - $an%100) /100) %4] + (($an%100)+($an%100)/4)+ $Month_Code_LY[$mois] + $jour) % 7);


	}
	if ( $wDayOfWeek == 0)
               	$wDayOfWeek = 7;
		       
        return( $wDayOfWeek );


}  // JourSem
 
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

function mysql_field_array( $query )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : mysql_field_array
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2016-11-17
//  Auteur : Denis Léveillé
//  Info :  make an array of field names
// Examples of use
//    $fields = mysql_field_array( $query );
// Show name of column 3
//	echo $fields[3];
// Show them all
//	echo implode( ', ', $fields[3] );
// Count them - easy equivelant to 'mysql_num_fields'
//	echo count( $fields );

{

	$field = mysql_num_fields( $query );

	for ( $i = 0; $i < $field; $i++ ) {
		$names[] = mysql_field_name( $query, $i );
	}

	return $names;

} // mysql_field_array
    
function br2nl( $input ) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : br2nl
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2015-12-30
//  Auteur : aftamat4ik 
//  here i replaced \n and \r symbols from $input because nl2br dosen't remove them and this causes wrong output with \n\n or \r<br>.
// source http://stackoverflow.com/questions/6004343/converting-br-into-a-new-line-for-use-in-a-text-area
{
     return preg_replace('/<br\s?\/?>/ius', "\n", str_replace("\n","",str_replace("\r","", htmlspecialchars_decode($input))));
} // br2nl
 
function truncate($string,$length=100,$append="&hellip;") 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : truncate
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2010-07-01
//  Auteur : Brendan Bullen 
{
   $string = trim($string);
 
   if(strlen($string) > $length) {
     $string = wordwrap($string, $length);
     $string = explode("\n", $string, 2);
     $string = $string[0] . $append;
   }
 
   return $string;
} // truncate

function Clean_texarea( $Str )
/************************************************************
   FONCTION: Clean_texarea
   BUT:	Oter le garbage HTML dans un text area
   AUTEUR: Denis Leveille	DATE: 2012-12-12
************************************************************/
{
	
	$Str = br2nl($Str);
	$Str = str_replace('&lt;br /&gt;', "", $Str);
	$Str = str_replace('<br />', "", $Str);
	$Str = str_replace('<br/>', "", $Str);
	$Str = str_replace('<br>', "", $Str);
	
	return $Str;
} // Clean_texarea

function LoadNomPrenomParId( $result) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : LoadNomPrenomParId
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
    	$ret = array();
    	while( $row = $result->fetch_assoc() ) {
    		$ret[$row[0]][0] = $row[1];
    		$ret[$row[0]][1] = $row[2];
        
	}
    	return ($ret);
} // LoadNomPrenomParId

function formatPhoneNumber($phoneNumber) 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : formatPhoneNumber
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2013-01-05
//  Auteur : Bryan Schoen  
//  derniere modif : Denis Léveillé 2016-01-15
//  info : This function will format international (10+ digit), non-international (10 digit) or old 
//	   school (7 digit) phone numbers. Any numbers other than 10+, 10 or 7 digits will remain unformatted.
{
    $phoneNumber = preg_replace('/[^0-9]/','',$phoneNumber);

    if(strlen($phoneNumber) > 10) {
        $countryCode = substr($phoneNumber, 0, strlen($phoneNumber)-10);
        $areaCode = substr($phoneNumber, -10, 3);
        $nextThree = substr($phoneNumber, -7, 3);
        $lastFour = substr($phoneNumber, -4, 4);

        $phoneNumber = '+'.$countryCode.' ('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 10) {
        $areaCode = substr($phoneNumber, 0, 3);
        $nextThree = substr($phoneNumber, 3, 3);
        $lastFour = substr($phoneNumber, 6, 4);

        $phoneNumber = '('.$areaCode.') '.$nextThree.'-'.$lastFour;
    }
    else if(strlen($phoneNumber) == 7) {
        $nextThree = substr($phoneNumber, 0, 3);
        $lastFour = substr($phoneNumber, 3, 4);

        $phoneNumber = $nextThree.'-'.$lastFour;
    }

    return $phoneNumber;
} // formatPhoneNumber

function getRelativePath($from, $to)
//**********************************************************************************************
//  FUNCTION : getRelativePath
//  version : 1.1
//  date : 2010-04-15
//  derniere modif : Young
//  info : Getting relative path from absolute path in PHP
{
   $from = explode('/', $from);
   $to = explode('/', $to);
   foreach($from as $depth => $dir)
   {

        if(isset($to[$depth]))
        {
            if($dir === $to[$depth])
            {
               unset($to[$depth]);
               unset($from[$depth]);
            }
            else
            {
               break;
            }
        }
    }
    //$rawresult = implode('/', $to);
    for($i=0;$i<count($from)-1;$i++)
    {
        array_unshift($to,'..');
    }
    $result = implode('/', $to);
    return $result;
} // getRelativePath

function array_sort($array, $on, $order=SORT_ASC)
//**********************************************************************************************
//  FUNCTION : array_sort
//  version : 1.1
//  Author : unknow
//  derniere modif : 2018-04-27
//  info : sorting table on an item
{
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            //$new_array[$k] = $array[$k];
            $new_array[] = $array[$k];
        }
    }

    return $new_array;
} // array_sort


?>