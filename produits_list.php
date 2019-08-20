<?php
include('lib/config.php');

$courant = 'produits_list'; //$_SERVER['SCRIPT_URI'];

$prod_filter = array();

$TabPaie =  get_money( "tout" );
/*$TxCUC_USD = get_TauxVente("CUC"); 
$TXUSD_CAD = get_TauxVente("CAD"); 
$TXUSD_EUR = get_TauxVente("EUR"); */

$cat = $_GET['cat'];

$Prod_In_Cat = check_prod_into_cat_complete($cat);

// ***** Intro ******************** 
include('intro.inc');
// ****** intro_eof ******************** 
include('categorie.inc');
// ******  header ******************** 
include('entete.inc');
// ******  header_eof ******************** 
?>
<!-- body //-->
<div id="contenu">
 <?php include('message.inc'); ?>
  <div class="cadre">
<table bgcolor='#ffffff' width='$LargeAchat' cellpadding='4' cellspacing='1' align='$Enligne' border='0' >
  	<tr>
		<td Valign='top'  colspan='2'>
<!-- ***** body_text ******************** //-->
<?php include( 'produits_list.inc' ); ?>
<!-- ****** body_text_eof ******************** //-->
  </tr>
</table>
<!-- body_eof //-->
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
		</td>
	</tr>	
</table>
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>