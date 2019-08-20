<?php
include('connect.inc');

if( !isset($_GET['NoProd']) ) $_GET['NoProd'] = 0;

echo "<?xml version='1.0' encoding='ISO-8859-1'?>";
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN' 'http://www.w3.org/TR/html4/frameset.dtd'> 
<html>
<head>
<title><?php echo $NomCie ?></title>
<meta name="author" content="<?php echo $NomCieCréé ?>">
</head>
<frameset rows="100,*" framespacing=0 border=1 frameborder="1" >
	<frame name="TOPFNT" src="listtopfnt.php?titre=<?php echo $TabMessGen[222] ?>&couleur=a2e8e8&bouton=25" scrolling="no" marginwidth=0 marginheight=0 frameborder="no" noresize />
  <frameset>
	<frame name="LIST" src="cat_tot_lst.php?NoProd=<?php echo $_GET['NoProd'] ?>&couleur=a2e8e8&action=produit_cat_ajout" marginwidth=0 marginheight=0 frameborder="no" scrolling="auto" title="list" >
  </frameset>
</frameset>
</html>