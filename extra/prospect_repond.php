<?php
include('connect.inc');
extract($_POST,EXTR_OVERWRITE);	 

if( isset($envoye) ){
   /*******************
     Les variables du E-Mail
     *******************/

	$__LIEN_SITE    = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);

	$sujet = ucfirst ( $txt['information'] ).' - '.$param['nom_client'];

	// on joint le tout
	$message = stripslashes($envoi_text)."<br /><hr /><br />";

	/****************************************************************/
	$dest_prenom = ucfirst( strtolower ( $dest_prenom ) );
	$dest_nom = ucfirst( strtolower ( $dest_nom ) );

	ob_start();
	
	echo
	"<html>
		<head>
			<title>".$txt['TitreWeb']."</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		</head>";
	include('styles/style.inc');
	echo 
	"<body>
		<table width='100%' cellpadding='4' cellspacing='4' align='left' border='0' >
		  	<tr>
		    		<td Valign=top>
				 	<a href='http://www.cosat.biz' target='_blank'>
					<img src='http://www.cosat.biz/images/logocosat.jpg' width='150' height='115' border='0' ></a>
				</td>
		    		<td>
		    			&nbsp;
		        	</td>
			</tr>
		  	<tr>
		    	<td Valign='top' colspan='2' >
		    		Bonjour $dest_prenom $dest_nom<br>
		    		<br>
		    		$envoi_text<br>
		        </td>
			</tr>
		  	<tr>
		    		<td Valign=top>
				 	<a href='http://www.cosat.biz' target='_blank'>www.cosat.biz</a>
				</td>
		    		<td>
		    			&nbsp;
		        	</td>
			</tr>
			<tr>
				<td>".
					$txt['form_courriel']." : <a href='mailto:".$param['courriel_client']."?subject=Reponse $dest_prenom $dest_nom'>".
					$param['courriel_client']."</a>
				</td>
			</tr>
			<tr>
				<td align='right'>
					En date du :  <i>$Now</i><br/><br/>
				</td>
			</tr>
	</table>
		<br>		
	</body>
	</html>";
	
	$message = ob_get_contents();
	
	ob_end_clean();

	/****************************************************************/
	
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	$headers .= "From: Cosat Informatique <".$param['email_envoi'].">\r\n";
	    /*******************
	     L'envoie du E-Mail
	     *******************/
//echo $message;
//exit();
	mail($dest_courriel, $sujet, $message, $headers);


	/************************************************************/

echo "<?xml version='1.0' encoding='ISO-8859-1'?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html  xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title>".$txt['TitreWeb']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<META NAME='Author' CONTENT='Techno Concept N2N Inc.'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<meta name='phrases' content='".$txt['MetaPhrases']."'>
 	</head>
	 <body bgcolor='#A2E8E8' >
	 	<center><big>".$txt['envoyer_courriel']."</big> </center>
	</body>
	</html>";
exit();
} // Si go

echo "<?xml version='1.0' encoding='ISO-8859-1'?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html  xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title>".$txt['TitreWeb']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<META NAME='Author' CONTENT='Techno Concept N2N Inc.'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<meta name='phrases' content='".$txt['MetaPhrases']."'>
 	</head>";
?>
<body bgcolor='#A2E8E8' >
<table cellpadding='0' cellspacing='0' border='1' align='center' >
<tr>
<td> 


<table bgcolor='#FFFFFF' width='<?=$LargeAchat?>' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
  <tr>
   <td>

<form name="envoi_ami" action="" method="post">
	<table cellpadding=4 cellspacing=0 width=100% align='center' border=0>
		<tr>
			<td width=100% align='center' colspan=2>
				<big><b><?=$txt['Remplissez_formulaire']?></b></big><br><br>
			</td>
		</tr>
		<tr>
			<td width=44% align='right'>
				<big><b><?=$txt['Vos_coordonnees']?></b></big><br>
			</td>
			<td width=56% align='left'>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_prenom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_prenom" class='form1' value="Denis">
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_nom" class='form1' value="Léveillé">
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_courriel" class='form1' value="<?=$param['email_envoi']?>">
			</td>
		</tr>
		<tr>
			<td width=100% align='center' colspan=2>
			<b><?=$txt['Votre_message']?></b>
			<br>
			<textarea name="envoi_text" rows=4 cols=50></textarea>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<br>
			<big><b><?=$txt['Vos_amis']?></b></big>
			<br>
			</td>
			<td align='left'>
				&nbsp;		
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_prenom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_prenom" value='<?=$dest_prenom[$choix]?>' class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_nom" value='<?=$dest_nom[$choix]?>' class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_courriel" value='<?=$dest_courriel[$choix]?>' class='form1'>
			</td>
		</tr>
		<tr>
			<td width=100% align='center' Valign=top colspan=2>
			<br>
			<input type="submit" value="<?=$txt['form_soumettre']?>" class='form1'>
			<input type="hidden" name='envoye' value="1">
			</td>
		</tr>
	</table>

   </td>
  </tr>
</table>
</form>
</td>
</tr>
</table>
</body>
</html>
