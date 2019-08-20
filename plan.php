<?php
include('lib/config.php');

$courant = 'plan'; //$_SERVER['SCRIPT_URI'];

function affiche_sous_noeud( $argnoeudFils, $argnoeudId )
{

	if( $aryNoeuds = @$argnoeudFils[$argnoeudId] ){

		echo "<ul type='circle'>\n";
	   	foreach($aryNoeuds as $aryNoeud){
			  $lang=$_SESSION['langue'];
			  $dlang= "description_$_SESSION[langue]";
			  $description= str_replace("'", "\'", $aryNoeud[$dlang]);
			  echo "<li>\n<a href='$aryNoeud[liens]' name='$description'>$aryNoeud[$lang]</a>\n";
			  affiche_sous_noeud( $argnoeudFils,$aryNoeud['id'] );
		}
		echo "</ul>";
	}
} // affiche_sous_noeud

// selection dans noeud
$sql = "SELECT * from $database.noeud ORDER BY ordre ASC";
$result = $mabd->query($sql);
if( !$result )
	Message_Erreur( "ERROR", "Erreur à la sélection get_Lien :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

// rangement des Noeud
while( $aryNoeud = $result->fetch_assoc() ){
		$id_parent = $aryNoeud['id_parent'];
		// c'est le premier Noeud 
		if( !$id_parent ) 
			$aryNoeudsSujets[] = $aryNoeud; 
		else 	// sinon on l'ajoute dans la teableau des Noeuds fils
			$arynoeudFils[$id_parent][] = $aryNoeud;
}


// ***** Intro ******************** 
include('intro.inc');
// ****** intro_eof ******************** 
// ***** left_navigation ******************** //-->
include('gauche.inc');
// -- left_navigation_eof //-->
// ******  header ******************** 
include('entete.inc');
// ******  header_eof ******************** 

?>
<!-- body //-->
<div id="contenu">
  <?php include('message.inc'); ?>
  <div class="cadre">
	<table bgcolor='#FFFFFF' width='100%' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
  		<tr>
<!-- ***** body_text ******************** //-->
<?php include( 'plan.inc' ); ?>
<!-- ****** body_text_eof ******************** //-->
  		</tr>
	</table>
  </div>
<?php include('pub.inc'); ?>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->
<script type='text/javascript'>


</script>
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>