<?php
/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
/*	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
*/
$infos_prod = get_prod_infos_by_id($_GET['id']);

$cat = $_GET['cat'];
$desc1 = "description_".$_SESSION['langue'];
$desc2 = "description_supplementaire_".$_SESSION['langue'];

?>
<table bgcolor='#FFFFFF' width='<?=$LargeAchat?>' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
  <tr>
   <td>
<?php


if( !is_array($infos_prod) ) 
	echo '<center>Oups '.$txt['a1'].'</center>';
else {
	// si le ID du client est dans la session...
	if(isset($_SESSION[$_SERVER['SERVER_NAME']]))
		$infosClient = infos_client($_SESSION[$_SERVER['SERVER_NAME']]);

	echo "<table width='94%' align='center' cellpadding=8>
			<tr>
				<td Valign=top>
					<a href='produit_detail.php?cat=$cat&id=".$infos_prod['id']."' target='ACCUEIL'>";

//					<img src='photoget_web.php?No=".$infos_prod['id']."&Idx=".$infos_prod['medium']."' border=0 ></a>
//*********************************************************************************************************************		
//		Il y avait un probleme avec Google qui demandais les images qu'il avait indexé ainsi :
//			http://www.cosat.biz/photoget_web.php%3FNo%3D5%26Idx%3D2 
//		Ce qui bien entendu causait un probleme puisque les symboles %3F (?) %3D (=) %26 (&) %3D (=) étaient interprété 
//		tel quel par apache et causaient un erreur 404
//		Pour contourner le problème je demande la 
//			photo/1/1 
//		et unev ligne dans le fichier .htaccess
//			RewriteRule ^/?photo/([0-9]+)/([0-9]+)$ photoget_web.php?No=$1&Idx=$2 [L]
//		Va convertir ma demande par 
//			photoget_web.php?No=1&Idx=1
//*********************************************************************************************************************	
echo "				<img src='photo/".$infos_prod['id']."/".$infos_prod['medium']."' alt='".$infos_prod['titre_'.$_SESSION['langue']]."' border='0' ></a>
				</td>
	        	<td width=100% align='left'>
	            <span class=titre>".
	                stripslashes($infos_prod['titre_'.$_SESSION['langue']]).
	         	"</span>
	        </td>
	    </tr>
	</table>";

?>

<form name="envoi_ami" action="envoi_ami_action.php" method="post">
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
			<input type="text" name="envoi_prenom" class='form1' value="<?php echo @$infosClient['Prenom']; ?>">
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_nom']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_nom" class='form1' value="<?php echo @$infosClient['Nom']; ?>">
			</td>
		</tr>
		<tr>
			<td align='right'>
			<b><?=$txt['Votre_courriel']?></b>
			</td>
			<td align='left'>
			<input type="text" name="envoi_courriel" class='form1' value="<?php echo @$infosClient['Courriel']; ?>">
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
			<td align='right'>
			<b><?=$TabMessGen[185]?></b>
			</td>
			<td align='left'>
			<input type="text" name="<?php echo($CHALLENGE_FIELD_PARAM_NAME) ?>" 
			id="<?php echo($CHALLENGE_FIELD_PARAM_NAME) ?>" 
			maxlength="<?php echo($MAX_MOT_MAGIQUE) ?>" 
			size="<?php echo($MAX_MOT_MAGIQUE) ?>" 
			class="inputText" />
			<img src="getimage.php" />
			</td>
		</tr>
		<tr>
			<td width=100% align='center' Valign=top colspan=2>
			<br>
			<input type="submit" value="<?=$txt['form_soumettre']?>" class='form1'>
			</td>
		</tr>
	</table>

   </td>
  </tr>
</table>
</form>
<script language='JavaScript1.2'>


// *********************************************************************
// *****  PROCEDURE MISE EN MARCHE A L'OUVERTURE ***********************
// *********************************************************************
	<?php
          if( isset($_GET['Message']) ) {
	    	echo "
				window.alert(\"".$_GET['Message']."\"); 
			";
          };
     ?>


</script>

<?php } ?>