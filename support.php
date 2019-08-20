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
  <?php  include('message.inc'); ?>
  <div class="cadre">
    <?php include('support.inc'); ?>

  </div>
 <?php include('pub.inc'); ?>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->
<script language='JavaScript1.2'>
	
  function start_up( url, target, attribut )
  {	  	
  	open(url,target,attribut);
  }

</script >
