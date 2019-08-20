<?php
include('lib/config.php');

$courant = 'produits'; //$_SERVER['SCRIPT_URI'];
$Symbole	=	get_Symbole($_SESSION['devise']);
// ***** Intro ******************** 
include('intro.inc');
echo "<script language='javascript1.2' src='js/affiche.js'></script>";
// ****** intro_eof ******************** 
include('categorie.inc');
// ******  header ******************** 
include('entete.inc');
// ******  header_eof ******************** 
?>
<div id="contenu">
  <div class="cadre">
		<!-- Encadré //-->
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_page_b">
		      	  <?=@$txt['Les_Produits'];?>
		        </td>
		  </tr>
          <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
		</table>
	<table bgcolor='#FFFFFF' width='100%' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
		<td>
		<table width='$LargeAchat' height=23 cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
			<tr>
				<td valign='left' width='17' id='flash_t_g' background='images/tit_accueil_bg_top_g.jpg'>
					&nbsp;
				</td>
				<td  colspan=3 valign=middle width='97%' id='flash_t_c' background='images/tit_accueil_bg_c.jpg'>
					<span id='topmsg' style='visibility:hidden'><center><b><font color=ffffff size=2><?=$txt['Speciaux']?></font></b></center></span>
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
		
		calcul_format_photo( $LargX, $HautY, $produit['id'], $produit['small'] );

		$prix_cad	=	rounder($produit['prix_detail']);

		echo "<a href='produit_detail.php?cat=".@$_GET['cat']."&id=".$produit['id']."' class=titre>";
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
		echo "<img src='photo/".$produit['id']."/".$produit['small']."' alt='".$produit['titre_'.$_SESSION['langue']]."' border='0' width='$LargX' height='$HautY'></a><br>";
		echo $produit['titre_'.$_SESSION['langue']]."<br>";
		echo "<font color='red'><b>".$txt['Speciaux']." $prix_cad&nbsp;$Symbole&nbsp;(".$_SESSION['devise'].")<sup>*</sup></font></b><br><br>";
		
	/* <for m n ame='  ajo ut<?=$pr  oduit['id']?>' action=' panier _  traite .  php  ?  retou  =  4' met hod='pos  t'>
		<input type="hidden" name="cat" value="<?=@$_GET['cat']?>">
		<input type="hidden" name="CodePanier" value="1">
		<input type="hidden" name="id" value="<?=$produit['id']?>">
      		<input type="hidden" name="Target" value="ACCUEIL">
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
	<table width='$LargeAchat' height='23' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
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

		</td>
	</tr>	
</table>
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>