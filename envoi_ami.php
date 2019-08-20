<?php
include('lib/config.php');
require_once('extra/challenge.php');

//DonneNewMotMagique();
//	echo "Mot: ".$_SESSION[$VAR_MOT_MAGIQUE]."<br>";


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
  <div class="cadre">
  <?php include('envoi_ami.inc'); ?>
  </div>
</div>
<!-- ***** footer ******************** //-->
<?php include('bas_page.inc'); ?>
<!-- footer_eof //-->


</div>
</td>
</tr>
</table>
<?php 
// ******  fermes le code html ******************** 
include('terminer.inc'); 
// ******  fermes le code html_eof ******************** 
?>