<?php
	// Portion Catégorie
	if( isset($_GET['niveau'] ) ) {
		$_GET['niveau'] = CleanUp($_GET['niveau']);
	
		if( isset($_GET['cat']) && $_GET['cat'] ) 
			$_SESSION['choix_categorie'][$_GET['niveau']] = $_GET['cat'];
	}

function affiche_menu($cat=0, $lvl=0, $online=0)
{
		$sousCats = get_subcats($cat, $online);
//		echo "Cat : ".$cat." Lvl ".$lvl."<br>"; 
		//echo "Chx : ".$_SESSION['choix_categorie'][$lvl]."<br>";
		$str = '';
		for( $i=0; $i < $lvl ; $i++ )
			$str .= '&nbsp;';
		foreach( $sousCats as $categorie => $titre_cat ) {
			if( !$lvl ) 
				echo "<a href='produits_list.php?cat=$categorie&niveau=$lvl'>
				<span class='l1' >$titre_cat&nbsp;(".get_count_cats($categorie).")</span></a><br>\n";
			else
				echo "<a href='produits_list.php?cat=$categorie&niveau=$lvl'>
				<span class='l2' >$str$titre_cat&nbsp;(".get_count_sub_cats($categorie).")</span></a><br>\n";
			if( @$_SESSION['choix_categorie'][$lvl] == $categorie )
					affiche_menu($categorie, ($lvl+1), $online);
					
		} // for each

} // fonction affiche_menu

?>
<!-- categories //-->
<div id="Gauche">
  <div id="logo"><img src='gifs/logo.gif' width="220" height="189" alt='<?=$txt['TitreWeb']?>' /></div>
  <div id="categorie">
  	<table width='100%' border='0' cellpadding='4px' >
          <tr>
            <td>
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
		 <td height="14" class="infoBoxHeading">
		    <img src="gifs/corner_right_left.gif" border="0" alt="" width="11" height="14">
		    </td>
		    <td width="100%" height="14" class="infoBoxHeading">
		    	<?=$txt['categorie']?>
		    </td>
		    <td height="14" class="infoBoxHeading" nowrap>
		    	<img src="gifs/pixel_trans.gif" border="0" alt="" width="11" height="14">
		    </td>
		  </tr>
		</table>
		<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
		  <tr>
		    <td>
		    	<table border="0" width="100%" cellspacing="1" cellpadding="3" class="infoBoxContents">
		  	<tr>
		    		<td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="1"/></td>
		  	</tr>
		  	<tr>
		    		<td width="90%" nowrap class="boxText" >
		<?php 				affiche_menu(0,0,1);					?>
							
			 	</td>
		  	</tr>
		  	<tr>
		    		<td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="1"/></td>
		  	</tr>
			</table>
		    </td>
		  </tr>
		</table>
            </td>
          </tr>
	</table>
  </div>
</div>
<!-- categories_eof //-->