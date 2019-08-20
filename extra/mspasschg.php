<?php
/* Programme : MSChangPass.php
* Description : Programme pour changer le password d'un usager.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
*/
include('connect.inc');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("msmessen.inc");
			break;
	case "SPANISH":	include("msmesssp.inc");
			break;
	default:	include("msmessfr.inc");
} // switch SLangue


function AfficherErreur( $Message )
{
global $TabMessGen, $NomCie;

  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
      <head>
      <title>Page d'Erreur Notes</title>
      </head>
      <body bgcolor='#C0C0FF'>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message</b>
      <form action='' method='post'>
         <input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()'>
      </form>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
		$TabMessGen[8]		 
		$TabMessGen[3]		 
		$NomCie
		$TabMessGen[4]		  
      </font></p>
      <SCRIPT LANGUAGE='javascript'>
        function QuitterPage() {
              close();
        } // QuitterPage

	  </SCRIPT>
      </body>
      </html>
  \n";
   exit();
}


/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

	$Mess = '';
	if( isset($_POST) && isset($_POST['id']) ){
			$sql = "SELECT mPasse FROM $database.secur WHERE NomLogin = '".$_POST['id']."'";
			
			if( !($result = mysql_query( $sql, $handle )) ) {
				AfficherErreur(mysql_errno().$TabId[30]. mysql_error());
			}			   
			if( mysql_num_rows( $result ) == 1 ) {	// Le nom de login est trouvé
					$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
					extract($ligne);
			}
			else
				$mPasse = '';
			if( isset($_POST['NewmPass1']) && strlen($_POST['NewmPass1'])) {
				if( isset($_POST['NewmPass2']) && strlen($_POST['NewmPass2'])) {
					if( strlen( $_POST['NewmPass1'] ) < 5 )
						$Mess = $TabMessSecur[25];
					elseif( strcmp($_POST['NewmPass1'],$_POST['NewmPass2']) )
						$Mess = $TabMessSecur[26];
					elseif( !ereg ("[0-9A-Za-z' ÉÈËÀÂÎÏÔÙÜÁÃÅÆÌÍÕÓÒÑçÇéèêëàâîïôùüáãåæìíðñòóõ-]{1,20}$", $_POST['NewmPass1'] ) )
						$Mess = $TabMessSecur[24];
					elseif( !strcmp($_POST['NewmPass1'],$mPasse) )
						$Mess = $TabMessSecur[27];
					else {
						$Aujourdhui = date("Y-m-d");
						$md5pass = md5($_POST['NewmPass1']);
						if( strlen($mPasse) ) {
							$sql =  "UPDATE $database.secur SET mPasse='$md5pass', Creation='$Aujourdhui'";
							$sql .= " WHERE NomLogin = '".$_POST['id']."'";
						}
						else {
							$sql =  "INSERT INTO $database.secur SET NomLogin='".$_POST['id']."', mPasse='$md5pass',";
							$sql .= "  Priorite='10', Creation='$Aujourdhui', Langue='".$_SESSION['SLangue']."', NoClient='".$_POST['NoCli']."'";
						}
						//	  									AfficherErreur( $sql );
						$result = mysql_query( $sql, $handle );
						if( $result == 0 ) {
							$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
                  }
                  else {
							echo 
							"<html>
								<head>
									<title>".$TabMessSecur[28]."</title>
									<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
									<meta name='robots' content='noindex, follow'>
									<link href='styles/stylegen.css' rel='stylesheet' type='text/css'>
								</head>
							<script language='javascript1.2' src='javafich/disablekeys.js'></script>
							<script language='javascript1.2' src='javafich/blokclick.js'></script>
							<script language='JavaScript1.2'>addKeyEvent();</script>
							<body bgcolor='#ffffff' width='100%' leftmargin='0' topmargin='0' marginwidth='0' marginheight='0' align='center' >
								<table bgcolor='#dae5fb' width='100%' cellpadding='0' cellspacing='0' align='center' border='1' bordercolor='C4C7C8' >
									<tr>
										<td>
											<br><br>
											<p align=center><font color=red size=3><b>Opération réussi !</b></font></p>
											<br><br>
										</td>
								  	</tr>
								   <tr align='center' valign='middle'> 
								      <td>
							            <input type='button' name='do' value='Quitter' onClick='QuitterPage()'>
										</td>
								  	</tr>
						  		</table>
								<script language='javascript1.2'>
									function QuitterPage() {
										close();
									} 
								
								</script>
							</body>
							</html>";
							exit();
                  }
					} // On modifie
				}
				else
					$Mess = $TabMessSecur[26]; //"Vous avez fait un erreur de confirmation.";
			}
			else
				$Mess = $TabMessSecur[25]; // Au moins 5 caractere
		}
		
		
/* FORMULAIRE PRINCIPAL */

echo 
"<html>
	<head>
		<title>".$TabMessSecur[28]."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='robots' content='noindex, follow'>
		<link href='styles/stylegen.css' rel='stylesheet' type='text/css'>
	</head>
	<script language='javascript1.2' src='javafich/disablekeys.js'></script>
	<script language='javascript1.2' src='javafich/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
<body >
	<table bgcolor='#dae5fb' width='100%' cellpadding='0' cellspacing='0' align='center' border='1' bordercolor='C4C7C8' >
		<tr>
			<td>
			<form name=PassForm method='post' action=''>";
			if( isset($Mess) && strlen($Mess) ) {
				echo "<p align=center><font color=red size=3><b>$Mess</b></font></p>";
			}
			else
				echo "<p>&nbsp;</p>";
echo
			"<table width='300' border='0' cellpadding='3' cellspacing='1' align='center' >
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$TabMessSecur[21]."</td>
		      <td width='200' bgcolor='#96B2CB'><input type='text' name='NewmPass1' value=''> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'>".$TabMessSecur[22]."</td>
		      <td width='200' bgcolor='#96B2CB'><input type='text' name='NewmPass2' value=''> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td>&nbsp; </td>
		      <td>
					<input name='submit' type='button' value='".$TabMessGen[130]."' onClick='GenerePass()'>&nbsp;&nbsp;
					<input name='submit' type='submit' value='".$TabMessGen[27]."'>&nbsp;&nbsp;
	            <input type='button' name='do' value='Quitter' onClick='QuitterPage()'>
				</td>
		  	</tr>
		</table>
       <input name='id' TYPE='hidden' VALUE='".$_GET['id']."'>
       <input name='NoCli' TYPE='hidden' VALUE='".$_GET['NoCli']."'>
 	</form>
				</td>
		  	</tr>
  </table>";
?>

<script language="javascript1.2">
	function QuitterPage() {
		close();
	} 
	function GenerePass() {
		document.PassForm.NewmPass1.value = document.PassForm.NewmPass2.value = '<?=generatePassword();?>';
	} // ResetClient
	
</script>
</body>
</html>