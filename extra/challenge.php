<?php
 	// Check if a valid challenge string does not exist
//session_start(); 
/****************************************************************************
 * DRBImageVerification
 * http://www.dbscripts.net/imageverification/
 * http://www.astahost.com/8ennett-s-Php-Web-Community-Part-1-t21786.html
 * Copyright © 2007 Don Barnes 
 ****************************************************************************/
 
// Length of challenge string 
$MAX_MOT_MAGIQUE = 5;

// Characters that will be used in challenge string
//$Caractere_Valide = 'ABCDEFGHJKLMNPQRTUVWXY3678@#$&*+?';
$Caractere_Valide = 'ABCDEFGHJKLMNPQRTUVWXY123456789';

// Name of session variable that will be used by the script.
// You shouldn't need to change this unless it collides with a
// session variable you are using.  
$VAR_MOT_MAGIQUE = 'Mot_Magique';

// Font size of challenge string in image 5
$GROSLETTREMOTMAGIQUE = 5;

// Whether background pattern is enabled
$Dessin_de_fond = TRUE;

// Font size of characters in background pattern 1
$GROSLETTREDUFOND = 1;

// Whether image should alternate between dark-on-light and 
// light-on-dark
$Couleur_Moire = TRUE;

// How much padding there should be between the edge of the image
// and the challenge string bounds
$MARGEMOTMAGIQUE = 2;	// in pixels

// Whether the entered verification code should be converted to upper-case.
// In effect, this makes the verification code case-insensitive.
$En_Majuscule = TRUE;

$CHALLENGE_FIELD_PARAM_NAME = "verificationCode"; 



function UniForme()
{
//double Inter;
	if( !isset( $_SESSION['GERME'] ) ) {
		$_SESSION['GERME'] = time();
	}
	$Inter = fmod( ( (25173 * $_SESSION['GERME']) + 13849 ), 65536 );
	$_SESSION['GERME'] = $Inter;
    	return( $Inter /= 65536 );
}

function Aleatoire( $Infer, $Super )
{
  	
	  return( $Infer + (($Super - $Infer + 1) * UniForme() ));
}

function Donne1Lettre()
{
global $Caractere_Valide;
	return( substr($Caractere_Valide, Aleatoire(0, strlen($Caractere_Valide) ), 1) );
} // Donne1Lettre

function DonneNewMotMagique() {
global $MAX_MOT_MAGIQUE, $VAR_MOT_MAGIQUE;
 	
/* 	if( isset($_SESSION[$VAR_MOT_MAGIQUE] )) {
		$name = '0_en.jpg';
		$fhandle = fopen($name, "r", 1);
		$size = filesize ($name);
		$data = fread ($fhandle, $size );
		fclose ($fhandle);
		header("HTTP/1.1 200 OK");
		header("Status: 200 OK");
		Header("Pragma: Public");
		header("Content-type: image/jpeg; charset=windows-1252");
		header("Content-length: $size");
		header("Content-Disposition: inline; filename=$name"); 
		header("Content-Description: PHP Generated Data");
		include($name);
		return;
 		//echo "un ancien mot<br>";
 		unset($_SESSION[$VAR_MOT_MAGIQUE]);
 		return;
 	}*/
 	$Mot_Magique = "";
 	
 	// Create string from random characters in list of valid characters
 	for($i = 0; $i < $MAX_MOT_MAGIQUE; $i++) {
 		// string substr ( string $string , int $start [, int $length ] )
 		$Mot_Magique .= Donne1Lettre();
 	}
	 
 	//echo "Mot: ".$Mot_Magique."<br>";
 	//exit();
	 
 	// Store challenge string in session global $VAR_MOT_MAGIQUE;
 	$_SESSION[$VAR_MOT_MAGIQUE] = $Mot_Magique;
 	return $Mot_Magique;
 }
 
 
 function DonneLeMotMagique() {
 	global $VAR_MOT_MAGIQUE;
 	
 	if( !isset($_SESSION[$VAR_MOT_MAGIQUE] )) {
 		
 		return FALSE;
 	}
 	
 	return $_SESSION[$VAR_MOT_MAGIQUE];
 }
 
 function ReponseEstValide($str) {
 	global $VAR_MOT_MAGIQUE;
 	
 	// Get challenge string
 	$Mot_Magique = DonneLeMotMagique();
 	if($Mot_Magique === FALSE) { return FALSE; }
 
 	// Convert entered value into uppercase, if enabled
 	global $En_Majuscule;
 	if($En_Majuscule === TRUE) {
 		$str = strtoupper($str);
 	}
 	
 	// Remove from session, so that it cannot be reused
 	unset($_SESSION[$VAR_MOT_MAGIQUE]);
 	
 	// Compare entered value to challenge string in session
    return ($Mot_Magique === $str);
}
 
 function AfficheMotMagique() {
 global $Dessin_de_fond, $Couleur_Moire, $GROSLETTREMOTMAGIQUE, $MAX_MOT_MAGIQUE, $MARGEMOTMAGIQUE, $GROSLETTREDUFOND;	
 	// Create a challenge string
 	$Mot_Magique = DonneLeMotMagique();
 	if($Mot_Magique == FALSE) { 
		$name = 'images\0_'.$_SESSION['langue'].'.jpg';
		$fhandle = fopen($name, "r", 1);
		$size = filesize ($name);
		$data = fread ($fhandle, $size );
		fclose ($fhandle);
		
		header("HTTP/1.1 200 OK");
		header("Status: 200 OK");
	
		//Header("Cache-Control: max-age=120, must-revalidate");
		//Header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
		Header("Cache-Control: max-age=0, no-cache, no-store");
		Header("Pragma: no-cache");
		Header("Pragma: Public");
		
		header("Content-type: image/jpeg; charset=windows-1252");
		header("Content-length: $size");
		header("Content-Disposition: inline; filename=$name"); 
		header("Content-Description: PHP Generated Data");
		include($name);
		return;
	}
 	
 	// Set content type
 	header("Content-type: image/png");
	Header("Cache-Control: max-age=0, no-cache, no-store");
	Header("Pragma: no-cache");
	Header("Pragma: Public");

 	// Get character sizes and string sizes
	$char_width = imagefontwidth($GROSLETTREMOTMAGIQUE);
    	$char_height = imagefontheight($GROSLETTREMOTMAGIQUE);
    	$string_width = $MAX_MOT_MAGIQUE * $char_width;
    	$string_height = 1 * $char_height;
     	
    // Create image and get color
    	$img_width = $string_width + $MARGEMOTMAGIQUE * 2;
    	$img_height = $string_height + $MARGEMOTMAGIQUE * 2; 	
 	$img = @imagecreatetruecolor($img_width, $img_height)
 	  or die("imagecreatetruecolor failed");

    // Pick colors
    if($Couleur_Moire === FALSE || rand(0, 1) == 0) {
	 	$background_color = imagecolorallocate($img, 15, 15, 15);
	 	$text_color = imagecolorallocate($img, 238, 238, 238);
	 	$bg_text_color = imagecolorallocate($img, 95, 95, 95);
    } else {
	 	$background_color = imagecolorallocate($img, 238, 238, 238);
	 	$text_color = imagecolorallocate($img, 15, 15, 15);
	 	$bg_text_color = imagecolorallocate($img, 191, 191, 191);
    }

 	// Fill background
 	imagefill($img ,0, 0, $background_color);
 	
 	// Draw background text pattern
 	
 	if($Dessin_de_fond === TRUE) {
	 	
		$bg_char_width = imagefontwidth($GROSLETTREDUFOND);
	    	$bg_char_height = imagefontheight($GROSLETTREDUFOND);
	 	for($x = rand(-2, 2); $x < $img_width; $x += $bg_char_width + 1) {
	 		for($y = rand(-2, 2); $y <  $img_height; $y += $bg_char_height + 1) {
	 			if( rand(0,1) )
	 				imagestring($img, $GROSLETTREDUFOND, $x, $y, Donne1Lettre(), $bg_text_color);
	 			else
	 				imagestringup($img, $GROSLETTREDUFOND, $x, $y, Donne1Lettre(), $bg_text_color);
	 		}
	 	}
 	}

 	// Draw text
 	$x = $MARGEMOTMAGIQUE + rand(-2, 2);
 	$y = $MARGEMOTMAGIQUE + rand(-2, 2);
 	for($i = 0; $i < strlen($Mot_Magique); $i++) {
	    imagestring($img, $GROSLETTREMOTMAGIQUE, $x, $y  + rand(-2, 2), substr($Mot_Magique, $i, 1), $text_color);
	    $x += $char_width;
 	}
      
    // Output image
    	$new_img_width = $img_width * 2;
	$new_img_height = $img_height * 2;
 	$img2 = @imagecreatetruecolor($new_img_width, $new_img_height)
 	  or die("imagecreatetruecolor failed");
        imagecopyresized( $img2 , $img , 0 , 0 , 0 , 0 , $new_img_width, $new_img_height, $img_width , $img_height );
	imagepng($img2);
	
	// Release image resources
	imagedestroy($img);
	imagedestroy($img2);
 	
 }
 
?>
