<?php
// Début de la session
include('lib/config.php');

?>
<html>
<head>
<title><?php echo $nomcie ?></title>
<meta name="author" content="<?=$nomciecréé ?>">
</head>
<frameset rows="100,*" framespacing=0 border=1 frameborder="1" >
     <frame name="topfnt" src="listtop.php?titre=<?=$tabmessgen[111] ?>&couleur=a2e8e8" scrolling="no" marginwidth=0 marginheight=0 frameborder="no" noresize>
  <frameset>
    <frame name="list" 
	       src="clientlst.php?sql=<?=$_get['sql']?>&couleur=a2e8e8&ok=<?=$_get['ok']?>&ok2=<?=$_get['ok2']?>&action=<?=$_get['retour']?>"
	       marginwidth=0 marginheight=0 frameborder="no" scrolling="auto" title="list">
  </frameset>
</frameset>
</html>