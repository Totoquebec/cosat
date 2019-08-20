<?php
// Début de la session
include('connect.inc');

echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN' 'http://www.w3.org/TR/html4/frameset.dtd'> 
<html>
<head>
<title><?=$NomCie ?></title>
<meta name="Author" content="<?=$NomCieCréé ?>">
</head>
<frameset rows="100,*">
     <frame name="TOPFNT" src="listtop.php?titre=<?=$TabMessGen[153] ?>&couleur=26FE5E" scrolling="no" marginwidth='0' marginheight='0' frameborder="no" noresize>
  <frameset>
    <frame name="LIST" 
	       src="produits_lst.php?sql=<?=$_GET['sql'] ?>&couleur=26FE5E&action=produits_recherche&target=<?=$_GET['target']?>"
	       marginwidth='0' marginheight='0' frameborder="no" scrolling="auto" title="LIST">
  </frameset>
</frameset>
</html>