<?php
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

<!-- body //-->

<div id="contenu">
 <div class="cadre">
<table border="1" width='100%' align='<?=$Enligne?>' cellspacing="3" cellpadding="3">
  <tr>
<!-- ***** body_text ******************** //-->
  <?php include('confidentialite.inc'); ?>
<!-- ****** body_text_eof ******************** //-->
  </tr>
</table>

  </div>
<?php include('pub.inc'); ?>
</div>
<!-- body_eof //-->
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>