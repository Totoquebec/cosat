<?php
include('connect.inc');

$page = $_SERVER["PHP_SELF"];
// Es-ce que l'usager à la priorité pour accéder cette fonction
if( @$_SESSION['Prio'] > $PrioAnnule ){
	header( "Location: mainfr.php");
	exit();
} // Si pas access autorisé

function first1(){
/*****************************************************************************************/
global $page,$TabMessGen, $lang;
	echo "
	<style>
		.scroll {
			height: 360px; /* Hauteur de 250 pixel */
			width:720px;  /* Largeur de 700 pixel */
			overflow: auto;
		}
	</style>";
	$sql = "SELECT * FROM noeud ORDER BY id";
	$req = mysql_query($sql);
	echo "<div style='float:left;margin-top=20px;width=20px;' border=1><img src='gifs/spacer.gif'></div>";
	echo "<div style='float:left;margin-top=10px;' border=1><div class='scroll'>";
//"ALTER TABLE ta_table AUTO_INCREMENT = 50".
	while ($telech = mysql_fetch_array($req)) {
		$id = stripslashes($telech['id']);
		$nom = stripslashes($telech[$lang]);
		echo "<a title='".$TabMessGen['364']."' href='$page?modifier=$id'>
			<img src='jpeg/edit.gif' height='15' border=0></a>&nbsp;
			<a title='".$TabMessGen['26']."' href='#' onClick=\"if (confirm('".$TabMessGen['380']."')) window.location.href='$page?remove=$id';\">
			<img src='jpeg/del.png' height='15' border=0></a> $id &nbsp; $nom<br>";

	
	} 	echo "</div><br><input type=button value='".$TabMessGen['118']."' name='Ajouter' onclick='window.location.href=\"$page?ajout=1\"'></div>";

} // FIN FUNCTION FIRST


// fonction récursive qui affiche les sous noeud d'un noeud

function affiche_sous_noeud( $argnoeudFils, $argnoeudId )
{
global $page,$TabMessGen, $lang;

	if( $aryNoeuds = @$argnoeudFils[$argnoeudId] ){

		echo "<ul type=\"circle\">\n";
	  // while( list(,$aryNoeud) = each($aryNoeuds) ){
	  // foreach($_POST as $clé => $valeur ) {
	   foreach($aryNoeuds as $aryNoeud){
			  $lang=$_SESSION['langue'];
			  $dlang= "description_$_SESSION[langue]";
			  $description= str_replace("'", "\'", $aryNoeud[$dlang]);
			  $id = $aryNoeud['id']; 
			  echo 
			  	"<li>\n<a title='".$TabMessGen['364']."' href='$page?modifier=$id'>
						<img src='jpeg/edit.gif' height='15' border=0></a>&nbsp;
						<a title='".$TabMessGen['26']."' href='#' onClick=\"if (confirm('".$TabMessGen['380']."')) window.location.href='$page?remove=$id';\">
						<img src='jpeg/del.png' height='15' border=0></a>
						$aryNoeud[$lang]\n";
			  affiche_sous_noeud( $argnoeudFils,$aryNoeud['id'] );
		}
		echo "</ul>";
	}
} // affiche_sous_noeud

function first(){
/*****************************************************************************************/
global $page,$TabMessGen, $lang, $mysql_base, $handle;

	$sql = "SELECT * from $mysql_base.noeud ORDER BY ordre ASC";
	$aryResultatRequete = mysql_query($sql, $handle)
		or die("Erreur à get_Lien : ".mysql_error());
	 
	echo "<br><input type=button value='".$TabMessGen['118']."' name='Ajouter' onclick='window.location.href=\"$page?ajout=1\"'>";

	// rangement des Noeud
	while( $aryNoeud = mysql_fetch_array($aryResultatRequete) ){
			$id_parent = $aryNoeud['id_parent'];
			$id = $aryNoeud['id'];
			// c'est le premier Noeud 
			if( !$id_parent ) 
				$aryNoeudsSujets[] = $aryNoeud; 
			else 	// sinon on l'ajoute dans la teableau des Noeuds fils
				$arynoeudFils[$id_parent][$id] = $aryNoeud;
	}

	// affichage des Noeuds
	foreach($aryNoeudsSujets as $arySujet){
	
		// appel de la fonction récursive qui va afficher tous les sous noeud
		affiche_sous_noeud( $arynoeudFils,$arySujet['id'] );
	}
} // FIN FUNCTION FIRST

function ajout(){
/*****************************************************************************************/
global $page,$TabMessGen,$lang;
	echo "<form method='POST' name='langu' action='$page?ajout_valid=1'>
			<div align='center'>

		<table border='1' width='44%' id='table1'>
		<tr><td width='50%' align='right'>".$TabMessGen['378']." : </td><td width='50%'>";


	$sql = 'SELECT id,'.$lang.' FROM noeud ORDER BY id';
	$req = mysql_query($sql);
	echo "<select size='1' name='id_parent'>";
	while ($telech = mysql_fetch_array($req)) {
		$id = stripslashes($telech['id']);
		$noms = stripslashes($telech[$lang]);
		echo "<option value='$id'>$noms </option><br>";
	}
	
	echo"
		<tr><td width='50%' align='right'>".$TabMessGen['368']." : </td><td width='50%'><input type='text' name='ordre' size='20' value='' onblur='checknum(\"$TabMessGen[381]\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['369']." : </td><td width='50%'><input type='text' name='fr' size='20' value='$fr'>	<input type='button' value='$TabMessGen[367]' name='B3' onclick='traduire(document.langu.fr.value,\"fr\",\"title\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['370']." : </td><td width='50%'><input type='text' name='en' size='20' value='$en'>	<input type='button' value='$TabMessGen[367]' name='B3' onclick='traduire(document.langu.en.value,\"en\",\"title\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['371']." : </td><td width='50%'><input type='text' name='sp' size='20' value='$sp'>	<input type='button' value='$TabMessGen[367]' name='B3' onclick='traduire(document.langu.sp.value,\"sp\",\"title\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['372']." : </td><td width='50%'><input type='text' name='description_fr' size='20' value='$description_fr'><input type='button' value='$TabMessGen[367]' name='B3' onclick='traduire(document.langu.description_fr.value,\"fr\",\"description_\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['373']." : </td><td width='50%'><input type='text' name='description_en' size='20' value='$description_en'><input type='button' value='$TabMessGen[367]' name='B3' onclick='traduire(document.langu.description_en.value,\"en\",\"description_\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['374']." : </td><td width='50%'><input type='text' name='description_sp' size='20' value='$description_sp'><input type='button' value='$TabMessGen[367]' name='B3' onclick='traduire(document.langu.description_sp.value,\"sp\",\"description_\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['375']." : </td><td width='50%'><input type='text' name='niveau' size='20' value='' onblur='checknum(\"$TabMessGen[381]\");'></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['376']." : </td><td width='50%'><input type='text' name='liens' size='20' value=''></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['377']." : </td><td width='50%'>
		<select size='1' name='type'>
			<option value='PHP'>PHP</option>
			<option value='HTML'>HTML</option>
			<option value='PDF'>PDF</option>
			<option value='JS'>JS</option>
			<option value='INC'>INC</option>
		</select></td></tr>
		</table>	
		<p><input type='submit' value='".$TabMessGen['118']."' name='B1'><input type=button value='Back' name='back' onclick='window.location.href=\"$page\"'></p>
		</div>
		
		</form>";
} // FIN FUNCTION AJOUT


function modifier($ids){
/*****************************************************************************************/
global $page,$TabMessGen,$lang;
	$sql = "SELECT * FROM noeud WHERE id = '$ids'";
		$req = mysql_query($sql);
		$telech = mysql_fetch_array($req);
		$id = stripslashes($telech['id']);
		$id_parent = stripslashes($telech['id_parent']);
		$ordre = stripslashes($telech['ordre']);
		$fr = stripslashes($telech['fr']);
		$en = stripslashes($telech['en']);
		$sp = stripslashes($telech['sp']);
		$description_fr = stripslashes($telech['description_fr']);
		$description_en = stripslashes($telech['description_en']);
		$description_sp = stripslashes($telech['description_sp']);
		$niveau = stripslashes($telech['niveau']);
		$liens = stripslashes($telech['liens']);
		$type = stripslashes($telech['type']);
		
		
		echo "
		<form method='POST' name='langu' action='$page?modifier_valide=$id' onSubmit='return verification(this)'>
		<div align='center'>
		<table border='1' width='44%' id='table1'>
		<tr><td width='50%' align='right'>".$TabMessGen['304'].": </td><td width='50%'><input type='text' name='id' size='20' readonly='true' value='$id' style=background-color:C0C0C0;></td></tr>
		<tr><td width='50%' align='right'>".$TabMessGen['378']." : </td><td width='50%'>";
		if( $id_parent == 0 ) 
		echo "<input type='text' name='id_parent' readonly='true' value='$id_parent' style=background-color:C0C0C0;>";
		else {
		$sql = 'SELECT id,'.$lang.' FROM noeud ORDER BY id';
		$req = mysql_query($sql);
		echo "<select size='1' name='id_parent'>";
	while ($telech = mysql_fetch_array($req)) {
		$id = stripslashes($telech['id']);
		$noms = stripslashes($telech[$lang]);
		echo "<option value='$id'";

		if( $id == $id_parent ) 
		 	echo " SELECTED";
    	echo " >$noms </option><br>";
		}
}
	
?>	
		<tr><td width='50%' align='right'><?=$TabMessGen['368']?> : </td><td width='50%'><input type='text' name='ordre' size='20' value='<?=$ordre?>' onblur='checknum("<?=$TabMessGen[381]?>")'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['369']?> : </td><td width='50%'><input type='text' name='fr' size='50' value="<?=$fr?>"><input type='button' value='<?=$TabMessGen['367']?>' name='B3' onclick='traduire(document.langu.fr.value,"fr","title")'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['370']?> : </td><td width='50%'><input type='text' name='en' size='50' value="<?=$en?>">	<input type='button' value='<?=$TabMessGen['367']?>' name='B3' onclick='traduire(document.langu.en.value,"en","title");'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['371']?> : </td><td width='50%'><input type='text' name='sp' size='50' value="<?=$sp?>">	<input type='button' value='<?=$TabMessGen['367']?>' name='B3' onclick='traduire(document.langu.sp.value,"sp","title");'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['372']?> : </td><td width='50%'><input type='text' name='description_fr' size='50' value="<?=$description_fr?>"><input type='button' value='<?=$TabMessGen['367']?>' name='B3' onclick='traduire(document.langu.description_fr.value,"fr","description_");'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['373']?> : </td><td width='50%'><input type='text' name='description_en' size='50' value="<?=$description_en?>"><input type='button' value='<?=$TabMessGen['367']?>' name='B3' onclick='traduire(document.langu.description_en.value,"en","description_");'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['374']?> : </td><td width='50%'><input type='text' name='description_sp' size='50' value="<?=$description_sp?>"><input type='button' value='<?=$TabMessGen['367']?>' name='B3' onclick='traduire(document.langu.description_sp.value,"sp","description_");'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['375']?> : </td><td width='50%'><input type='text' name='niveau' size='20' value='<?=$niveau?>' onblur='checknum("<?=$TabMessGen[381]?>");'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['376']?> : </td><td width='50%'><input type='text' name='liens' size='20' value='<?=$liens?>'></td></tr>
		<tr><td width='50%' align='right'><?=$TabMessGen['377']?> : </td><td width='50%'>
			<select size='1' name='type'>";
			<option value='PHP' <?php if ( $type == "PHP" )echo "SELECTED";?>>PHP</option>
			<option value='HTML' <?php if ( $type == "HTML" )echo "SELECTED";?>>HTML</option>
			<option value='PDF' <?php if ( $type == "PDF" )echo "SELECTED";?>>PDF</option>
			<option value='JS' <?php if ( $type == "JS" )echo "SELECTED";?>>JS</option>
			<option value='INC' <?php if ( $type == "INC" )echo "SELECTED";?>>INC</option>
		</select>
		</td></tr>
		</table>	
		<p><input type='submit' value='<?=$TabMessGen['364']?>' name='B1?>'><input type='button' value='Back' name='back' onclick='window.location.href="<?=$page?>"'></p>
	
		</div>
		
		</form>
		<?php
} // FIN FUNCTION MODIFIER



$lang = $_SESSION['langue'];
ob_start();

echo 
"<html  xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title>$NomCie</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=plan_modif' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='Author' content='Jean-Alexandre Denis'>
	</head>
	<script language='javascript1.2' src='js/mm_menu.js'></script>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>";
	switch( $_SESSION['SLangue'] ) {
			case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
					break;
			case "SPANISH" :echo "<script language='JavaScript1.2' src='js/ldmenusp.js'></script>\n";
					break;
			default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
	}
echo
"<body bgcolor='#D8D8FF'>
	<script language=JavaScript1.2>mmLoadMenus();</script>";

//if (isset($_GET['modifier_valide']))
if (isset($_GET['modifier']))
	modifier($_GET['modifier']);

if (isset($_GET['ajout']))
	ajout();


if (isset($_GET['modifier_valide'])){
	extract($_POST,EXTR_OVERWRITE);	 
	$sql = "UPDATE noeud SET id ='$id', id_parent ='$id_parent',";
	$sql .= " ordre ='$ordre', fr ='$fr',";
	$sql .= " en ='$en', sp ='$sp',";
	$sql .= " description_fr ='$description_fr', description_en ='$description_en',"; 
	$sql .= " description_sp ='$description_sp', niveau ='$niveau',";
	$sql .= " liens ='$liens', type ='$type' WHERE id = '$id'";
	mysql_query($sql);
	echo 'Modification reussi !';
	header("Refresh: 2; url=$page?first=1");
}

if (isset($_GET['ajout_valid'])){
	$sql = "INSERT INTO noeud (id_parent, ordre, fr, en, sp, description_fr, description_en, description_sp, niveau, liens, type) VALUES ('".$_POST['id_parent']."', '".$_POST['ordre']."', '".$_POST['fr']."', '".$_POST['en']."', '".$_POST['sp']."', '".$_POST['description_fr']."', '".$_POST['description_en']."', '".$_POST['description_sp']."', '".$_POST['niveau']."', '".$_POST['liens']."', '".$_POST['type']."')";
	mysql_query($sql);
	echo 'Ajout reussi !';
	header("Refresh: 2; url=$page?first=1");
}

if (isset($_GET['remove'])){	
	$sql = "DELETE FROM noeud WHERE id = '".$_GET['remove']."'";
	mysql_query($sql);
	echo 'Suppression réussi.';
	header("Refresh: 2; url=$page?first=1");
}


if (isset($_GET['first']))
	first();
	
if ($_SERVER["REQUEST_URI"] == $_SERVER["PHP_SELF"])	
	header("Refresh: 0; url=$page?first=1");

?>
<script language='JavaScript1.2'>
	
	function traduire(toThis, langue, type)
	{

		if( langue == 'fr' )
		window.open('pll_trad.php?lang=fr|en&lang2=en|es&texte='+ toThis +'&type='+ type,null,
    "height=1,width=1,status=yes,toolbar=no,menubar=no,location=no");
		else if( langue == 'en' )
				window.open('pll_trad.php?lang=en|es&lang2=en|fr&texte='+ toThis +'&type='+ type,null,
    "height=1,width=1,status=yes,toolbar=no,menubar=no,location=no");
		else if( langue == 'sp' )
				window.open('pll_trad.php?lang=es|en&lang2=en|fr&texte='+ toThis +'&type='+ type,null,
    "height=1,width=1,status=yes,toolbar=no,menubar=no,location=no");
		
	} // traduire

function checknum(champ) 
{ 

var valeur = document.langu.ordre.value; 
var valeur2 = document.langu.niveau.value; 
var reg = new RegExp("[^0-9]", "gi"); 
	if(valeur.match(reg)) 
	{ 
	 
	alert(champ);
	langu.ordre.focus();
	langu.ordre.style.backgroundColor='red';
	} 
	else 
	{ 
	langu.ordre.style.backgroundColor='green';
	} 
	if(valeur2.match(reg)) 
	{ 
	
	alert(champ);
	langu.niveau.focus();
	langu.niveau.style.backgroundColor='red';
	} 
	else 
	{ 
	 langu.niveau.style.backgroundColor='green';
	} 
}


function verification(ao_form, champ){
  //Contrôle du pseudo
 
var valeur = document.langu.ordre.value; 
var valeur2 = document.langu.niveau.value; 
var reg = new RegExp("[^0-9]", "gi"); 
	if(valeur.match(reg)) 
	{ 
	alert(champ);
	ao_form.ordre.focus();
	ao_form.ordre.style.backgroundColor='red';
	
	return false;
	
	} 
	if(valeur2.match(reg)) {
	ao_form.niveau.focus();
	alert(champ);
	ao_form.niveau.style.backgroundColor='red';
	return false;
	}
	 
  return true;  
}

</script>
</body>
</html>
