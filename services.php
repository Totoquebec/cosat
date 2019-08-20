<?php
// include('global_prepend.php');
include('lib/config.php');

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
<div id="contenu">
  <?php include('message.inc'); ?>
		<!-- Encadré //-->
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_page_b">
		      	  <?=@$txt['Les_Services'];?>
		        </td>
		  </tr>
		</table>
  <div id="cadre1">
    <!-- begin sandbag divs -->
    <div id="sml1-01"></div>
    <div id="sml1-02"></div>
    <div id="sml1-03"></div>
    <div id="sml1-04"></div>
    <!-- end sandbag divs -->
     <h1>ENTRETIEN&nbsp;</h1>
    <p>Votre ordinateur est lent...<br>Apportez-le-nous pour un entretien!</p>    
    <font color='#df0224'>Imprimez et apportez cette page et vous aurez droit à un nettoyage et optimisation pour seulement 34.99 $.</font>
  </div>
  <div id="cadre2">
    <!-- begin sandbag divs -->
    <div id="sml2-01"></div>
    <div id="sml2-02"></div>
    <div id="sml2-03"></div>
    <div id="sml2-04"></div>
    <!-- end sandbag divs -->
     <h1>LOGICIEL&nbsp;</h1>
    <p>Nous pouvons développer pour vous l'application nécessaire à vos opérations.<br>Nous avons aussi des solutions complètes pour 
    votre PME telle que le logiciel de P.O.S. WinFaktur</p>    
    
  </div>
  <div id="cadre3">
    <!-- begin sandbag divs -->
    <div id="sml3-01"></div>
    <div id="sml3-02"></div>
    <div id="sml3-03"></div>
    <div id="sml3-04"></div>
    <!-- end sandbag divs -->
     <h1>RÉPARATION&nbsp;</h1>     
    <p>Nous effectuons la Réparation d'ordinateur sur place par des techniciens compétents formés au plus nouvelles technologies.<br>    
	Microsoft Windows® XP, Vista, Seven, linux. Nous nous en chargerons pour vous.
    <p>Votre ordinateur est mort...<br>Apportez-le-nous pour une estimation!</p>    
    <font color='#df0224'>Imprimez et apportez cette page et vous aurez droit à un rabais de 50%<BR>sur une estimation.</font>
  </div>
  <div id="cadre4">
    <!-- begin sandbag divs -->
    <div id="sml4-01"></div>
    <div id="sml4-02"></div>
    <div id="sml4-03"></div>
    <div id="sml4-04"></div>
    <div id="sml4-05"></div>
    <!-- end sandbag divs -->
     <h1>SITE WEB&nbsp;</h1><br>
     Notre site WEB vous plait!
    Laissez-nous concevoir et mettre en ligne votre propre site web à des prix plus que compétitifs.    

  </div>
<?php include('pub.inc'); ?>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
// include('global_append.php');

?>