<?php
include('connect.inc');

?>
<html>
<head>
<title><?php echo $NomCie ?></title>
<meta name="author" content="<?php echo $NomCieCréé ?>">
</head>
<frameset rows="100,*" framespacing=0 border=1 frameborder="1" >
     <frame name="TOPFNT" src="listtop.php?titre=<?php echo $TabMessGen[112] ?>&couleur=a2e8e8&bouton=26" scrolling="no" marginwidth=0 marginheight=0 frameborder="no" noresize>
  <frameset>
    <frame name="LIST" src="cat_produit_lst.php?NoCat=<?php echo $_GET['NoCat'] ?>&couleur=a2e8e8&action=produit_recherche" marginwidth=0 marginheight=0 frameborder="no" scrolling="auto" title="list">
  </frameset>
</frameset>
</html>