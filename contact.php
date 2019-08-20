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


<div id="contenu">
 <div class="cadre">
  <?php include('contactajout.inc'); ?>

  </div>
<?php include('pub.inc'); ?>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->
</body>
</html>
