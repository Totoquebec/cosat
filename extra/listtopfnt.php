<?php
    /* Programme : OeuvreLst.inc
    * Description : Affichage de la liste des oeuvres.
    */
include('connect.inc');

$_GET['titre'] = stripslashes( $_GET['titre'] );
?>
<html>
	<head>
	    <title><?php echo $_GET['titre'] ?></title>
	</head>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
<body bgcolor='#<?php echo $_GET['couleur'] ?>' >
		 <center>
        <font size='+2'><b><?php echo $_GET['titre'] ?></b></font>
        <hr size='5' color='#000000'>
          <input type='button' name='Quitter' value='<?php echo $TabMessGen[14] ?>' onClick='AppelBouton(0)'>
          <input type='button' name='Execute' STYLE='visibility:visible' value='<?php echo $TabMessGen[25] ?>' onClick='AppelBouton(1)'>
        <hr size='5' color='#000000'>
	</center>
		
	<script language="javascript1.2">
		
		function AppelBouton( Choix ) {
			if( !top.LIST ) {
				alert("attention *** pas de frame list !!!");
				return;
			}
			else {
				if( Choix == 1 ) 
					top.LIST.Modif();
				else 
					top.LIST.QuitterPage();
			} // Sinon exist en fentre
			
		} // AppelBouton
	
	</script>
</body>
</html>
