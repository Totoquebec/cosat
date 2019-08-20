<?php
include('../lib/config.php');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("msmessen.inc");
			break;
	default:	include("msmessfr.inc");
} // switch SLangue

/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

if( isset($_POST) ){
	$Mess = '';
	if( isset($_POST['password']) ) {
	  if( isset($_POST['NewmPass1']) && strlen($_POST['NewmPass1'])) {
	    if( isset($_POST['NewmPass2']) && strlen($_POST['NewmPass2'])) {	
		if( strlen( $_POST['NewmPass1'] ) < 5 )
			$Mess = $TabMessSecur[25];
		elseif( strcmp($_POST['NewmPass1'],$_POST['NewmPass2']) )
			$Mess = $TabMessSecur[26];
		elseif( !preg_match("/[0-9A-Za-z' ÉÈËÀÂÎÏÔÙÜÁÃÅÆÌÍÕÓÒÑçÇéèêëàâîïôùüáãåæìíðñòóõ-]{1,20}/", $_POST['NewmPass1'] ) ) 
			$Mess = $TabMessSecur[24];
		elseif( !strcmp($_POST['NewmPass1'],$_POST['password']) )
			$Mess = $TabMessSecur[27];
		else {
			$Aujourdhui = date("Y-m-d");
			$md5pass = md5($_POST['NewmPass1']);
	
		  	$sql =  "UPDATE $database.secur SET mPasse='$md5pass', Creation='$Aujourdhui', Acces ='OUI' ";
		  	$sql .= " WHERE NomLogin = '".$_SESSION['NomLogin']."'";
			$Mess ="Sql =".$sql;
			break;
		 	$result = mysql_query( $sql, $handle );
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
					</head>
					<script language='JavaScript1.2' src='js/disablekeys.js'></script>
				<body bgcolor='#ffffff' width='100%' align='$Enligne' alink='#000000' >
				<table bgcolor='#dae5fb' width='100%' cellpadding='0' cellspacing='0' align='$Enligne' border='1' bordercolor='C4C7C8' >
					<tr>
						<td>";
					echo "<br><br>";
					echo "<p align=center><font color=black size=3><b>Opération réussi !</b></font></p>";
				echo "<br><br>";
				echo '		</td>
				  	</tr>
					<tr>
						<td><br><p align=center>';
				// **** Choix de la langue de travail ****
				switch( @$_SESSION['SLangue'] ) {
					case "ENGLISH" :echo "<a href='login.php?Lang=EN'>";
							break;
					case "SPANISH" :echo "<a href='login.php?Lang=SP'>";
							break;
					default : 	echo "<a href='login.php'>";
				
				} // switch SLangue
		
				echo "<b>".$TabMessGen[11]."</font></b></a><br>";
				echo "</p><br>";
				echo '		</td>
				  	</tr>';
			
				echo '</table>';
				echo '</body>
					</html>';
				exit();
			} // else modif table ok
		} // Mot de passe valide
  	    }
	    else
		$Mess = $TabMessSecur[26];
	  }
	  else
		$Mess = $TabMessSecur[25];
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
		<meta name='keywords' content='".$txt['MetaKeyword']."'>";
?>
		<meta name='robots' content='noindex, follow'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
	</head>
	<script language='JavaScript1.2' src='js/disablekeys.js'></script>
<body >
	<table bgcolor='#dae5fb' width='100%' cellpadding='2' cellspacing='2' align='<?=$Enligne?>' border='1' bordercolor='C4C7C8' >
		<tr>
			<td  bgcolor='#E6F1FB'>
				<?php echo $TabMessSecur[23] ?>
			</td>
		</tr>
		<tr>
			<td>&nbsp;
			
<?php			
			if( isset($Mess) && strlen($Mess) ) {
				echo "<br>";
				echo "<p align=center><font color=red size=3><b>$Mess</b></font></p><br>";
			}
?>
				
			</td>
		</tr>
		<tr>
		<td>
			<form method='post' action=''>
		<table width='auto' border='0' cellpadding='3' cellspacing='1' align='center' >
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'><?=$txt['form_check_password']?></td>
		      <td width='200' bgcolor='#96B2CB'><input type='password' name='password'> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'><?=$txt['form_new_password']?></td>
		      <td width='200' bgcolor='#96B2CB'><input type='password' name='NewmPass1'> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td width='100' bgcolor='#E6F1FB'><?=$txt['form_verif_password']?></td>
		      <td width='200' bgcolor='#96B2CB'><input type='password' name='NewmPass2'> </td>
		   </tr>
		   <tr align='center' valign='middle'> 
		      <td>&nbsp; </td>
		      <td><input name='submit' type='submit' value='<?=$txt['form_soumettre']?>'>
		      <br/><br/>
    		      </td>
		    </tr>
		</table>
			</form>
		</td>
		</tr>
	
	</table>


<script language='JavaScript1.2'>
	function Rafraichie(){
		 		window.location.reload();
	} // Rafraichie

	addKeyEvent();

</script>
<script language='JavaScript1.2' src='js/blokclick.js'></script>
  
</body>
</html>