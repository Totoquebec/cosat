<?php
include('../lib/config.php');

?>
<html>
<head>
	<meta name="description" content="Section menu du logiciel Hermes"/>
	<meta http-equiv="Content-Type" content="text/html; charset=charset=utf-8"/>
	<meta name="Author" content="Denis Léveillé"/>
	<title>Menu E-Hermes</title>
</head>

<script language='javascript1.2'>

function MMshowMenuInFrame(menuLabel, x, y, imgLabel) {

        if (!top.window.frames[1]) {
                return;
        }
		
		// pageXOffset -Gets the amount of content that has been hidden by scrolling to the right. 
        if (window.pageXOffset > -1) {
		   		x = x || top.window.frames[1].pageXOffset;
				// pageYOffset -Gets the amount of content that has been hidden by scrolling down. 
				// window.pageY -Returns the vertical coordinate of the event relative to the visible page
                y = y || top.window.frames[1].pageYOffset;
        } else if (document.body) {
                x = x || top.window.frames[1].document.body.scrollLeft;
                y = y || top.window.frames[1].document.body.scrollTop;
        }
		
        if (top.window.frames[1].MM_showMenu) {
		   top.window.frames[1].MM_showMenu(menuLabel,x,y, null,imgLabel);
        }
} // MMshowMenuInFrame

function MM_startTimeoutInFrame(menuLabel, x, y, imgLabel) {
        if (!top.window.frames[1]) {
                return;
        }
        if (top.window.frames[1].MM_showMenu) {
		   top.window.frames[1].MM_startTimeout();	   						   
        }
} // MM_startTimeoutInFrame

function mouseTracker(e) {
        e = e || window.Event || window.event;
        window.pageX = e.pageX || e.clientX;
        window.pageY = e.pageY || e.clientY;
} // mouseTracker

function img_on(imgName)  {
   	  imgDown = eval(imgName + "on.src");
   	  document [imgName].src = imgDown;
} // img_on

function img_off(imgName)  {
   	  imgUp = eval(imgName + "off.src");
   	  document [imgName].src = imgUp;
} // img_off

	if (window.captureEvents) {
	    window.captureEvents(Event.MOUSEMOVE | Event.MOUSEUP);
		window.onmousemove = mouseTracker;
	}
	else {
		document.onmousemove = mouseTracker;
	}

	menu1on = new Image();
	menu1on.src = "jpeg/menaccon<?=$_SESSION['langue']?>.jpg";
	menu1off = new Image();
	menu1off.src = "jpeg/menacc<?=$_SESSION['langue']?>.jpg";
	
	menu2on = new Image();
	menu2on.src = "jpeg/menlieon<?=$_SESSION['langue']?>.jpg";
	menu2off = new Image();
	menu2off.src = "jpeg/menlie<?=$_SESSION['langue']?>.jpg";
	
	menu3on = new Image();
	menu3on.src = "jpeg/mencaton<?=$_SESSION['langue']?>.jpg";
	menu3off = new Image();
	menu3off.src = "jpeg/mencat<?=$_SESSION['langue']?>.jpg";
	
	menu4on = new Image();
	menu4on.src = "jpeg/menproon<?=$_SESSION['langue']?>.jpg";
	menu4off = new Image();
	menu4off.src = "jpeg/menpro<?=$_SESSION['langue']?>.jpg";
	
	menu5on = new Image();
	menu5on.src = "jpeg/menproson<?=$_SESSION['langue']?>.jpg";
	menu5off = new Image();
	menu5off.src = "jpeg/menpros<?=$_SESSION['langue']?>.jpg";
	
	menu6on = new Image();
	menu6on.src = "jpeg/menopton<?=$_SESSION['langue']?>.jpg";
	menu6off = new Image();
	menu6off.src = "jpeg/menopt<?=$_SESSION['langue']?>.jpg";




</script>

<!--script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script -->
<script language='javascript1.2' src="js/mm_menu.js"></script>
<script language='javascript1.2' src="js/ldmenu<?=$_SESSION['langue']?>.js"></script>


<body vLink=#0000cc aLink=#0000cc link=#0000cc bgColor=#ffffff >
<script language='JavaScript1.2'>mmLoadMenus();</script>
<base target="MAIN">

<table cellSpacing='0' cellPadding='0' width='760' border='0'>
  <tbody>
  <tr>
    <TD vAlign=top colSpan=11><IMG height='81' alt="" src="gifs/toplogo.gif" width='760' align='top' border='0' name='top_logo'></td>
  </tr>
  <tr>
    <td><a 
      onmouseover="window.status='<?=$TabMessGen[220] ?>'; img_on('menu1'); return true;" 
      onmouseout="window.status=''; img_off('menu1'); return true"  href="mainfr.php" target='MAIN'><IMG 
      height=21 alt="" src="jpeg/menacc<?=$_SESSION['langue']?>.jpg" width='126' 
      border=0 name=menu1></A></TD>
    <TD><A 
      onmouseover="window.status='<?=$TabMessGen[221] ?>'; img_on('menu2'); MMshowMenuInFrame(window.mm_menu_Liens,126,0,'menu2'); return true" 
      onmouseout="window.status=''; img_off('menu2'); MM_startTimeoutInFrame(); return true" href="lienlst.php" target='MAIN'><IMG 
      height=21 alt="" src="jpeg/menlie<?=$_SESSION['langue']?>.jpg" width='126' 
      border=0 name=menu2></A></TD>
    <TD><A 
      onmouseover="window.status='<?=$TabMessGen[222] ?>'; img_on('menu3'); MMshowMenuInFrame(window.mm_menu_Catalogue,252,0,'menu3'); return true" 
      onmouseout="window.status=''; img_off('menu3'); MM_startTimeoutInFrame(); return true" href="catalogue_recherche.php" target='MAIN'><IMG 
      height=21 alt="" src="jpeg/mencat<?=$_SESSION['langue']?>.jpg" width='126' 
      border=0 name=menu3></A></TD>
    <TD><A 
      onmouseover="window.status='<?=$TabMessGen[223] ?>'; img_on('menu4'); MMshowMenuInFrame(window.mm_menu_Produits,378,0,'menu4'); return true" 
      onmouseout="window.status=''; img_off('menu4'); MM_startTimeoutInFrame(); return true" href="produits_recherche.php" target='MAIN'><IMG 
      height=21 alt="" src="jpeg/menpro<?=$_SESSION['langue']?>.jpg" width='126' 
      border=0 name=menu4></A></TD>
    <TD><A 
      onmouseover="window.status='<?=$TabMessGen[224] ?>'; img_on('menu5'); MMshowMenuInFrame(window.mm_menu_Prospects,504,0,'menu5'); return true" 
      onmouseout="window.status=''; img_off('menu5'); MM_startTimeoutInFrame(); return true" href="prospect.php" target='MAIN'><IMG 
      height=21 alt="" src="jpeg/menpros<?=$_SESSION['langue']?>.jpg" width='126' 
      border=0 name=menu5></A></TD>
	<TD><A 
      onmouseover="window.status='<?=$TabMessGen[225] ?>'; img_on('menu6'); MMshowMenuInFrame(window.mm_menu_Options,630,0,'menu6'); return true" 
      onmouseout="window.status=''; img_off('menu6'); MM_startTimeoutInFrame(); return true" href="support.php" target='MAIN'><IMG 
      height=21 alt="" src="jpeg/menopt<?=$_SESSION['langue']?>.jpg" width='127'
      border=0 name=menu6></A></TD>
   <TD><IMG height=21 src="jpeg/menuspace.jpg" width=100 border=0></td>
  </tr>
  </tbody>
</table>

</body>
</html>