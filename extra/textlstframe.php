<?php
include('connect.inc');

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 3.2//EN">
<html>
<head>
<title><?=$param['nom_client'] ?></title>
<meta name="Author" content="<?=$param['nom_client'] ?>">
</HEAD>
<FRAMESET rows="100,*" FRAMESPACING=0 BORDER=1 FRAMEBORDER="1" >
     <FRAME NAME="TOPFNT" SRC="listtop.php?titre=Texte&couleur=D8D8FF&EnBoit=0" SCROLLING="No" MARGINWIDTH='0' MARGINHEIGHT='0' FRAMEBORDER="No" NORESIZE>
  <FRAMESET>
    <FRAME NAME="LIST" SRC="textlst.php?&No=<?=@$_GET['No'] ?>" MARGINWIDTH='0' MARGINHEIGHT='0' FRAMEBORDER="No" scrolling="auto" Title="LIST">
  </FRAMESET>
</FRAMESET>
</HTML>
