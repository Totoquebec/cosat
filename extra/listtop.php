<?php
    /* Programme : OeuvreLst.inc
    * Description : Affichage de la liste des oeuvres.
    */
include('connect.inc');

$_GET['titre'] = stripslashes( $_GET['titre'] );
?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
       <title><?php echo $_GET['titre'] ?></title>
   </head>
   <script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src="javafich/mm_menu.js"></script>
<?php
	switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :	echo "<SCRIPT language=JavaScript1.2 src='javafich/ldmenuen.js'></SCRIPT>";
								break;
		case "SPANISH" :	echo "<SCRIPT language=JavaScript1.2 src='javafich/ldmenusp.js'></SCRIPT>";
								break;
		default :			echo "<SCRIPT language=JavaScript1.2 src='javafich/ldmenufr.js'></SCRIPT>";
	}
?>
<body bgcolor='#<?php echo $_GET['couleur'] ?>' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
<script language='JavaScript1.2'>mmLoadMenus();</script>
   		 <center>
           <font size='+2'><b><?php echo $_GET['titre'] ?></b></font>
           <hr size='5' color='#000000'>
             <input type='button' name='Quitter' value='<?php echo $TabMessGen[14] ?>' onClick='AppelBouton(0)'>
             <input type='button' name='Execute' STYLE='visibility:visible' value='<?php echo $TabMessGen[25] ?>' onClick='AppelBouton(1)'>
           <hr size='5' color='#000000'>
		</center>
		
<script language="javascript1.2">
	
	function AppelBouton( Choix ) {
		if( !top.MAIN.LIST ) {
			alert("attention *** pas de frame list !!!");
			return;
		} // Si dans la fenetre principal
		else {
			if( Choix == 1 ) 
				top.MAIN.LIST.Modif();
			else 
				top.MAIN.LIST.QuitterPage();
		} // Sinon existe en fenetre principal
		//alert("attention *** dans top.LIST.modif!!!");
	} // AppelBouton
	
addKeyEvent();

</script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
   </body>
</html>
