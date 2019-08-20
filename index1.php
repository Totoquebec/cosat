<?php
include('lib/config.php');

$courant = 'index'; //$_SERVER['SCRIPT_URI'];
$Symbole	=	get_Symbole($_SESSION['devise']);

// ***** Intro ******************** 
include('intro.inc');
echo "<script language='javascript1.2' src='js/affiche.js'></script>";
// ****** intro_eof ******************** 
// ***** left_navigation ******************** //-->
include('gauche.inc');
// -- left_navigation_eof //-->
// ******  header ******************** 
include('entete.inc');
// ******  header_eof ******************** 

?>
<div id="contenu">
  <?php include('message.inc'); ?>
  <div class="cadre">
	<table bgcolor='#FFFFFF' width='100%' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
		<td>
		<table width='<?=$LargeAchat?>' height=23 cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
			<tr>
				<td valign='left' width='17' id='flash_t_g' background='images/tit_accueil_bg_top_g.jpg'>
					&nbsp;
				</td>
				<td  colspan=3 valign=middle width='97%' id='flash_t_c' background='images/tit_accueil_bg_c.jpg'>
					<span id='topmsg' style='visibility:hidden'><center><b><font color='ffffff' size='2'><?=$txt['Speciaux']?></font></b></center></span>
				</td>
				<td valign='right' width='20' id='flash_t_d' background='images/tit_accueil_bg_top_d.jpg'>
					&nbsp;
				</td>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table width='100%' align='left' bgcolor='#FFFFFF' cellpadding='2' border='0' >
			<tr>
				<td align='left' width='17'>
					&nbsp;
				</td>
<?php

$Nb = 1;
while( $Nb < 5 ) {
	$produits_accueil = produits_accueil($Nb);
	$produit = get_prod_infos_by_id($produits_accueil['id_produit']);
	//if( $produit['Qte_Max_Livre'] < 1 ) $produit['Qte_Max_Livre'] = 1;
	echo "
	<td valign=bottom align=center width=33%>";
		$LargX = $param['image_special_largeur'];
		$HautY = $param['image_special_haut'];

		$sql = " SELECT Largeur, Hauteur FROM $mysql_base.photo WHERE NoInvent='".$produit['id']."' AND NoPhoto='".$produit['small']."';";
		$result2 = mysql_query( $sql, $handle );
		if( $result2 &&  mysql_num_rows($result2) ) {
			$L = @mysql_result($result2, 0, "Largeur");
			$H = @mysql_result($result2, 0, "Hauteur");
			if( ($difL = $L - $LargX) < 0 ) $difL = 0; 
			if( ($difH = $H - $HautY) < 0 ) $difH = 0;
			 
			if( $difL || $difH ) {
				if( $difL > $difH ) {
					$Pourcent = $LargX/$L;
					$LargX = $L*$Pourcent;
					$HautY = $H*$Pourcent;
				}
				else {
					$Pourcent = $HautY/$H;
					$LargX = $L*$Pourcent;
					$HautY = $H*$Pourcent;
				}
			}
			else {
				$LargX = $L;
				$HautY = $H;
			}
		} // Si une photo
		$LargX 		= rounder($LargX);
		$HautY 		= rounder($HautY);

		$prix_cad	=	rounder($produit['prix_detail']);

//		echo "<a href='photo/".$produit['id']."/".$produit['small']."' class=titre>";
		echo "<a href='produit_detail.php?cat=".check_cat_du_prod($produit['id'])."&id=".$produit['id']."' class=titre>";
		// http://127.0.0.1/cosat/photo/".$produit['id']."/".$produit['small']."
		echo "<img src='photo/".$produit['id']."/".$produit['small']."' alt='".$produit['titre_'.$_SESSION['langue']]."' border='0' width='$LargX' height='$HautY'></a><br>";
//		echo "<img src='photoget_web.php?No=".$produit['id']."&Idx=".$produit['small']."' alt='".$produit['titre_'.$_SESSION['langue']]."' border='0' width='$LargX' height='$HautY'></a><br>";
		echo $produit['titre_'.$_SESSION['langue']]."<br>";
		echo "<font color='red'><b>".$txt['Speciaux']." $prix_cad&nbsp;$Symbole&nbsp;(".$_SESSION['devise'].")<sup>*</sup></font></b><br><br>";
		
	/* <form name='ajout<?=$produit['id']?>' action='panier_traite.php?retour=4' method='post'>
		<input type="hidden" name="cat" value="<?=@$_GET['cat']?>">
		<input type="hidden" name="CodePanier" value="1">
		<input type="hidden" name="id" value="<?=$produit['id']?>">
	</form> */
?>

	</td>
	
<?php  
	// Es-ce le troisieme element            
	if( !($Nb % 2) ) {
		echo "
			<td align='left' width='17'>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td align='left' width='17'>
				&nbsp;
			</td>
		";
	} // Si le 3ieme element
	$Nb++;
} // Tant que des spéciaux 
?>


			<td colspan='2' >
				&nbsp;
			</td>
			<td align='left' width='17'>
				&nbsp;
			</td>
		</tr>
	</table>
		</td>
		</tr>
		<tr>
		<td>
	<table width='<?=$LargeAchat?>' height='23' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
			<td align='left' width='17' id='flash_b_g' background='images/tit_accueil_bg_bas_g.jpg'>
				&nbsp;
			</td>
			<td colspan='3' align='center' width='97%' id='flash_b_c' background='images/tit_accueil_bg_c.jpg'>
				&nbsp;
			</td>
			<td align='right' width='20' id='flash_b_d' background='images/tit_accueil_bg_bas_d.jpg'>
				&nbsp;
			</td>
		</tr>
	</table>

		</td>
		</tr>

	</table>
  </div>
<?php include('pub.inc'); ?>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->


</div>
</td>
</tr>
</table>
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>