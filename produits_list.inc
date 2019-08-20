<?php
	// Portion BODY
?>
<!-- body_text //-->
    <td width="100%" valign="top">
    <table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
	  <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
          <tr>
            <td>
<!-- Encadré //-->
<table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td height="14" class="infoBoxHeading"><img src="gifs/corner_left.gif" border="0" alt="" width="11" height="14"></td>
    <td height="14" class="infoBoxHeading" width="100%">
<?php
// ******  DÉBUT DE L'AFFICHAGE DU PATH **********************************************************
// ******   EN HAUT DE LA PAGE 
if( $param['path_show_main'] == 1 ){
?>
		&nbsp;&nbsp;<a href='produits.php' class='titre'><?=$txt['accueil']?> - </a>
<?php
	if( $cat != 0 ){
		$path = get_cat_path($cat);
		$subCatCtr = count($path);
		
		if( $subCatCtr > 0 ){
			echo "<span class=titre><a href='produits_list.php?cat=".$path[0]."'  class=titre>".get_cat_name_by_id($path[0]),"</a>";
      	if( $subCatCtr > 1 ) {
         	for($i = 1; $i < $subCatCtr; $i++ )
            	echo "<span  class=titre><a href='produits_list.php?cat=".$path[$i]."' class=titre>".get_cat_name_by_id($path[$i])."</a>";
    		} // Si $subCatCtr > 0
  		}	 // $subCatCtr > 0 
    	echo " > <span class=titre><a href='produits_list.php?cat=".$_GET['cat']."' class=titre>".get_cat_name_by_id($_GET['cat'])."</a>";
	} // si $cat != 0
?>
<?php
} // ******** FIN DE L'AFFICHAGE DU PATH 
else
	echo "nbsp;";
?>
	 </a></td>
    <td height="14" class="infoBoxHeading"><img src="gifs/corner_right.gif" border="0" alt="" width="11" height="14"></td>
  </tr>
</table>
<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
	<tr>
		<td>
			<table border="1" width="100%" cellspacing="0" cellpadding="4" class="productBoxContents">
				<tr>
					<td>
<?php
// ******  DÉBUT DE L'AFFICHAGE DE LA DEVISE *******************************************************
// ******   EN HAUT DE LA PAGE 2IEME LIGNE A DROITE

if( !$param['categorie_affichage'] || !$Prod_In_Cat ) {
?>
				<center>
					<?=$txt['Aucun_produit_cat']?>
				</center>
<?php	
} // Si pas de produit dans cat
else {
?>
<?php
	if( $param['categorie_affichage'] && $Prod_In_Cat ){
		$produits = selectionProduits($cat, null, 1);
		$_SESSION['i'] = 1;
		if( $produits ) {
			while( $produit = $produits->fetch_assoc() )
				if( !in_array( $produit['id'],$prod_filter ) ) {
	//				$prod_filter[] = $produit['id'];
					afficher_un_produit( $produit, $cat, 3, '_top' );
				}
		} // si  $produits ) {
		faire_souscat($cat);
	} // Sinon produit dans cat
}
?>

					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- encadré_eof //-->
				</td>
          </tr>
          <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="10"></td>
          </tr>
        </table>
		  </td>
      </tr>
    </table>
	</td>
<!-- body_text_eof //-->