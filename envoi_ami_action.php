<?php
include('lib/config.php');
require_once('extra/challenge.php');

/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
*/

/****************************************************************/
// Identification de notre produit
/****************************************************************/
$cat = $_POST['id_cat'];
$id = $_POST['id_prod'];

$__LIEN_SITE    = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$infos_prod = get_prod_infos_by_id( $id );

$nom = "titre_".$_SESSION['langue'];
$desc1 = "description_".$_SESSION['langue'];
$desc2 = "description_supplementaire_".$_SESSION['langue'];

/****************************************************************/
// Preparation de la photo
/****************************************************************/
$sql = " SELECT * FROM $database.photo WHERE Id='".$infos_prod['id']."' AND NoPhoto='".$infos_prod['medium']."'";
$result = $mabd->query($sql);
if( $result && $result->num_rows ) {
	$tab_photo = $result->fetch_assoc();
	
  	$data = $tab_photo['Photo'];
  	$name = $tab_photo['FileName'];
	$size = $tab_photo['FileSize'];
  	$type = $tab_photo['FileType'];

}
else 
	$data = $name =  $size = $type = '';

/****************************************************************/
// SI il y a une chaine Magique alors valider ici
/****************************************************************/
if( isset($_POST[$CHALLENGE_FIELD_PARAM_NAME]) ) {


	$infosClient['Prenom']	=$_POST['envoi_prenom'];
	$infosClient['Nom']	=$_POST['envoi_nom'];
	$infosClient['Courriel']=$_POST['envoi_courriel'];
  	
  	//echo "id = ".$id."<br>";
	// Check challenge string
	if( ReponseEstValide($_POST[$CHALLENGE_FIELD_PARAM_NAME]) === FALSE ) {
	    header( "Location: envoi_ami.php?cat=$cat&id=$id&Message=".$TabMessGen[186] );
	    exit();
	} // ReponseEstValide
} // $CHALLENGE_FIELD_PARAM_NAME
	
/****************************************************************/
//     Les variables du E-Mail
/****************************************************************/

// Les séparateur de section
//$multipartSep = uniqid("-----_Part_".md5(time()), true).'-----'; //random unique string

$multipartSep = str_replace(".", "", uniqid( '', true)); //random unique string
$multipartSep2 = str_replace(".", "", uniqid( '', true)); //random unique string
$multipartSep3 = str_replace(".", "", uniqid('', true)); //random unique string
$IDPhoto = str_replace(".", "", uniqid('', true)).'jpg'; //random unique string
$IDLogo = str_replace(".", "", uniqid('', true)).'gif'; //random unique string
$IDFond = str_replace(".", "", uniqid('', true)).'gif'; //random unique string

// Notre Sujet
$sujet = sprintf( $TabMessGen[182], $param['nom_client'], $_POST['envoi_prenom'], $_POST['envoi_nom'] );

// Notre message
$message = stripslashes($_POST['envoi_text']);

/****************************************************************/
// Preparation de l'entete
/****************************************************************/

$headers  = "From: ".$param['nom_client']." <".$param['email_envoi'].">\r\n"
	. "X-Priority: 3\r\n"
	. "X-MSMail-Priority: Normal\r\n"
	. "X-Mailer: PHP/".phpversion()."\r\n"
	. "MIME-Version: 1.0\r\n"
	. "Content-Type: multipart/mixed; boundary=\"$multipartSep\"\r\n"
	. "\r\n";

/*****************************************************************************************
***** preparation des différente sections
*****************************************************************************************/	

// Partie que défini que le fichier contient plusieurs partie que se concerne		
$partie1  = "--$multipartSep\r\n"
	. "Content-Type: multipart/related; boundary=\"$multipartSep2\"\r\n"
	. "\r\n";

// Partie qui contine des valeur alternative
$partie1_1  = "--$multipartSep2\r\n"
	. "Content-Type: multipart/alternative; boundary=\"$multipartSep3\"\r\n"
	. "\r\n";

// Partie alternative 1 le texte plain
$partie1_1_1_1 = "--$multipartSep3\r\n"
	. "Content-Type: text/plain; charset=\"utf-8\"\r\n"
	. "Content-Transfer-Encoding: quoted-printable\r\n"
	. "\r\n";
	
// Partie alternative 2 le texte html
$partie1_1_1_2  = "--$multipartSep3\r\n"
	. "Content-Type: text/html; charset=\"utf-8\"\r\n"
	. "Content-Transfer-Encoding: quoted-printable\r\n"
	. "\r\n";

/*****************************************************************************************
***** preparation du contenu du courriel en Texte
*****************************************************************************************/	
	
$Courriel_Plain = "Ceci est un message HTML. S.V.P. Utiliser un client courriel capable de=\r\n"
	. "lire les courriel HTML pour lire ce message.\r\n"
	. "\r\n";


/*****************************************************************************************
***** preparation du contenu du courriel en HTML
*****************************************************************************************/	
/*

It's an email encoding system called "quoted-printable", which allows non-ASCII characters to be represented as ASCII 
for email transportation.

In quoted-printable, any non-standard email octets are represented as an = sign followed by two hex digits representing 
the octet's value. Of course, to represent a plain = in email, it needs to be represented using quoted-printable encoding 
too: 3D are the hex digits corresponding to ='s ASCII value (61).
 
*/
	
ob_start();
echo
"<html>
   <head>
      <title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
      <meta http-equiv=3D'Content-Type' content=3D'text/html; charset=3D UTF-8'>
   </head>";
include('styles/style.inc');
echo 
"<body background=3D'cid:$IDFond' >
   <table width=3D'$LargeAchat' cellpadding=3D'4' cellspacing=3D'4' align=3D'$Enligne' border=3D'0' >
      <tr>
         <td colspan=3D'2' align=3D'left' >
            <img src=3D'cid:$IDLogo' width=3D'160' height=3D'162' border=3D'0' >
         </td>
      </tr>
      <tr>
         <td Valign=3D'top' colspan=3D'2' >
            $message<br /><hr /><br />
         </td>
      </tr>
      <tr>
         <td Valign=3Dtop>
            <a href=3D'$entr_path/produit_detail.php?cat=3D$cat&id=3D$id' target=3D'_blank'>
            <img src=3D'cid:$IDPhoto' border=3D'0' ></a>
         </td>
         <td align=3D'left'>
            <a href=3D'$entr_path/produit_detail.php?cat=3D$cat&id=3D$id' target=3D_blank>
            <span class=3Dtitre>".$infos_prod[$nom]."</span></a><br><br>
            <span class=3Ddescription>".$infos_prod[$desc1]."<br><br>".$infos_prod[$desc2]."</span>
         </td>
      </tr>
      <tr>
         <td Valign=3D'top' colspan=3D'2' >
            <a href=3D'$entr_path/produit_detail.php?cat=3D$cat&id=3D$id' target=3D'_blank'>".
            $TabMessGen[183]."</a>
         </td>
      </tr>
   </table>
   <br>		
</body>
</html>\r\n";

$message = ob_get_contents();

ob_end_clean();

$message = str_replace("\t", "   ", $message);
	
$Courriel_HTML = wrapText($message, 76, true); //chunk_split ( $message, 76 , "=" );
//$Courriel_HTML = chunk_split ( $message, 76 , "=" );

/*****************************************************************************************
***** preparation de l'image du produit
*****************************************************************************************/
$Limage = Courriel_Attachment( $name, $IDPhoto, $type, '', $data  );

	
/*****************************************************************************************
***** preparation du fond - background
*****************************************************************************************/


$LeFond = Courriel_Attachment( './gifs/tech.gif', $IDFond );
/*****************************************************************************************
***** preparation du logo
*****************************************************************************************/	

$LeLogo = Courriel_Attachment( 'gifs/lelogo.gif', $IDLogo  );

/*****************************************************************************************
***** Preparration du courriel MIME même
*****************************************************************************************/	
ob_start();
echo $partie1;
echo $partie1_1;
echo $partie1_1_1_1;
echo $Courriel_Plain;
echo $partie1_1_1_2;
echo $Courriel_HTML;
echo "--$multipartSep3--\r\n\n"; // Fin partie 1_1_1
echo "--$multipartSep2\r\n";	// Partie 1_1_2
echo $Limage;
echo "--$multipartSep2\r\n";	// Partie 1_1_2
echo $LeFond;
echo "--$multipartSep2\r\n";	// Partie 1_1_2
echo $LeLogo;
echo "--$multipartSep2--\r\n";	// Fin partie 1_1_2
echo "--$multipartSep--\r\n";	// Fin partie 1
$message = ob_get_contents();

ob_end_clean();

/*mail($to, $subject, $email, implode("\r\n", $headers));*/
    /*******************
     L'envoie du E-Mail
     *******************/

foreach( $_POST['dest_courriel'] as $index => $email_addr){
	if( strlen( $email_addr ) ) {
		mail($email_addr, $sujet, $message, $headers);
/*		echo "email ".$email_addr."<br>";
		echo "sujet ".$sujet."<br>";*
		echo "header ".$headers."<br><br>";
		echo $headers;
		echo $message;
		exit();*/
	}

}

/************************************************************/

// ***** Intro ******************** 
include('intro.inc');
// ****** intro_eof ******************** 
include('categorie.inc');
// ******  header ******************** 
include('entete.inc');
// ******  header_eof ******************** 
?>

<!-- body //-->
<div id="contenu">
 <?php include('message.inc'); ?>
  <div class="cadre">
<table bgcolor='#dae5fb' width='<?=$LargeAchat?>' cellpadding='4' cellspacing='1' align='<?=$Enligne?>' border='1' >
  <tr>
		<td align='center' Valign=top >
<?php
echo "<big>".$TabMessGen[184]."<br><br><a href='produit_detail.php?cat=$cat&id=".$infos_prod['id']."' >".
		$txt['continuer_a_magasiner'].'</a></big>'; 
?>

		</td>
	</tr>	
</table>
<!-- body_eof //-->
  </div>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>