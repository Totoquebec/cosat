<?php
include('lib/config.php');

$cat = @$_GET['cat'];
$produit = get_prod_infos_by_id($_GET['id']);

/*	$TxCUC_USD 	= 	get_TauxVente("CUC"); 
	$TXUSD_CAD 	= 	get_TauxVente("CAD"); 
	$TXUSD_EUR 	= 	get_TauxVente("EUR"); 
	$SymbCUC	=	get_Symbole("CUC");
	$SymbUSD	=	get_Symbole("USD");*/
	$SymbCAD	=	get_Symbole("CAD");
//	$SymbEUR	=	get_Symbole("EUR");

/*	$prix_cuc	=	rounder($produit['prix_detail']);
	$prix_us	=	rounder($prix_cuc  * $TxCUC_USD);
	$prix_ca	=	rounder($prix_us * $TXUSD_CAD);
	$prix_eur	=	rounder($prix_us * $TXUSD_EUR);*/
	
	$prix_ca	=	rounder($produit['prix_detail']);

// ***** Intro ******************** 
include('intro.inc');
// ****** intro_eof ******************** 
// ***** left_navigation ******************** //-->
include('categorie.inc');
// -- left_navigation_eof //-->
// ******  header ******************** 
include('entete.inc');
// ******  header_eof ******************** 
//dae5fb
?>

<div id="contenu">
 <?php include('message.inc'); ?>
  <div class="cadre">
<table bgcolor='#ebebeb' width='$LargeAchat' cellpadding='4' cellspacing='1' align='$Enligne' border='1' >
  	<tr>
		<td Valign='top'  colspan='2'>

<?php
if( !is_array($produit) ){
	echo "<center>".$txt['a1']."</center>";
}
else {
	echo "
		<table width='100%' cellpadding='2' cellspacing='0' height='22' border='0' bgcolor='#cccccc'>
			<tr>
			<td  align=left nowrap>
				&nbsp;&nbsp;<a href='produits.php' class=titre>".$txt['accueil']."</a> -";
				if( $cat != 0 ){
					$path = get_cat_path($cat);
					$subCatCtr = count($path);
						
					if( $subCatCtr > 0 ){
						echo "&nbsp;<span class=titre><a href='produits_list.php?cat=".$path[0]."' class=titre>".get_cat_name_by_id($path[0]),"</a>";
				      		if( $subCatCtr > 1 ) {
				         		for($i = 1; $i < $subCatCtr; $i++ )
				            		echo " - <span  class=titre><a href='produits_list.php?cat=".$path[$i]."' class=titre>".get_cat_name_by_id($path[$i])."</a>";
				    		} // Si $subCatCtr > 0
				  	} // $subCatCtr > 0 
				    	echo " - <span class=titre><a href='produits_list.php?cat=$cat' class=titre>".get_cat_name_by_id($_GET['cat']).
						"</a> > <a href='".$_SERVER['PHP_SELF']."?id=".$_GET['id']."&cat=$cat' class=titre>".
					 	$produit['titre_'.$_SESSION['langue']]."</a>";
				} // si $cat != 0

	echo "
			</td>
			</tr>
		</table>  
		</td>
	</tr>
	<tr>
		<td  align='left' nowrap>";

	// ***** FIN DE L'AFFICHAGE DU PATH

	if( $produit['big'] ) 
		echo "<a href='javascript:VoirZoom(".$produit['id'].");'>";
		
	$LargX = 400;
	$HautY = 400;
	
	calcul_format_photo( $LargX, $HautY, $produit['id'], $produit['small'] );


//	echo "<img src='photoget_web.php?No=".$produit['id']."&Idx=".$produit['medium']."' border=0 width='$LargX' height='$HautY'></a></td>";
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
	echo "<img src='photo/".$produit['id']."/".$produit['medium']."' alt='".$produit['titre_'.$_SESSION['langue']]."' border=0 width='$LargX' height='$HautY'></a></td>";
 
?>
		</td>
		<td width='100%' align=left>
			<span class=titre>
				<?php echo $produit['id']." - ".$produit['titre_'.$_SESSION['langue']]." ".$produit['Code']; ?>
			</span>
			<br><br>
			<span class=description>
            			<?=$produit['description_'.$_SESSION['langue']]?>
            			<?=$produit['description_supplementaire_'.$_SESSION['langue']]?><br><br>
			</span>
		</td>
	</tr>
	<tr>
		<td valign='top' width='100%' align='center' colspan='2'>	
			
			<table width="100%" border=1 align=left cellpadding=4 cellspacing=1>
        			<tr> 
          			<td width="50%" bgcolor="#E6F1FB"> 
			 		<span class='prix'> 
				<?php
			 		echo "
					 		$prix_ca $SymbCAD - CAD<sup>*</sup>";
				?>
					</span> 
				</td>
          			<td align='center' width="50%" bgcolor='#cccccc'> 
					&nbsp;
				</td>
        			</tr>
        			<tr> 
          			<td colspan="2"> 
            				<a href='envoi_ami.php?cat=<?=$cat?>&id=<?=$produit['id']?>' class='generallinks'> 
           				<?=$TabMessGen[181]?></a>
				</td>
        			</tr>
      			</table>
<?php 
}
?>
		</td>
	</tr>	
</table>
  </div>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->

<script type='text/javascript'>
	function VoirZoom(No){
		str = 'zoom.php?id=' + No;
		open( str, '_blank','left=10,top=10,width=460,height=500,status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
	function Rafraichie(){
		window.location.reload();
	}


</script>
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>