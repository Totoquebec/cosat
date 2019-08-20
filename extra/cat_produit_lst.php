<?php
/* Programme : LetCliLst.php
* Description : Affichage d'une liste de client pour les lettres.
* Auteur : Denis Léveillé 		Date : 2007-03-20
*/
include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Stock</title>
      </head>
 	  <SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
    <body bgcolor='#".$_GET['couleur']."'>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message</b>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
      Les droits de reproduction de ce site © $CopyAn $NomCie.<br>
      Tous droits réservés. © $CopyAn<br>
      </font></p>
      <SCRIPT LANGUAGE='javascript'>
	  		  addKeyEvent();

	  </SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT>
      </body>
      </html>
  \n";
   exit();
}


    $query = "SELECT id,titre_".$_SESSION['langue'].",Code,prix_detail FROM $mysql_base.stock LEFT JOIN $mysql_base.catalogue_produits";
	 $query .= " ON $mysql_base.catalogue_produits.id_produit = $mysql_base.stock.id WHERE $mysql_base.catalogue_produits.id_catalogue=".$_GET['NoCat'];
    $result = mysql_query( $query, $handle ); 


if( $result == 0 ) {
//  MetMessErreur(mysql_error(),"Accès Stock impossible", mysql_errno());
  MetMessErreur(mysql_error(),$query, mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
      <title>Choix d'un produit</title>	   
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<link title=HermesStyle href='styles\stylegen.css' type=text/css rel='STYLESHEET'>
		
		<script language='JavaScript1.2' src='javafich/disablekeys.js'></script>
		<script language='JavaScript1.2' src='javafich/denislib.js'></script>
		<style type='text/css' media='all'>
			#demo tr.ruled {
			background:#B4E7FF;
			}
		</style>
  </head>

<body bgcolor='#".$_GET['couleur']."' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
 <form name='Liste' action='".$_GET['action'].".php?do=trouve' method='post' ENCTYPE='multipart/form-data'>
		<font size='-1'>
        <table id='demo' class='ruler' summary='Liste des catégorie' border='1' width='100%' align='center'>
          <thead>
	     <tr>";
             echo("<th>".mysql_field_name($result,0)."</th>");
             echo("<th>".mysql_field_name($result,1)."</th>");
             echo("<th>".mysql_field_name($result,2)."</th>");
             echo("<th>".mysql_field_name($result,3)."</th>");
	
	     echo "</tr>
          </thead>
	  <tbody>";
	     for( $i=0; $i < mysql_num_rows($result); $i++ ) {
	   	 	  echo "<tr>";
			  $row = mysql_fetch_row($result);
				if( strlen($row[0]) )
					echo("<td>".$row[0]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
				if( strlen($row[1]) )
					echo("<td>".$row[1]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
 				if( strlen($row[2]) )
					echo("<td>".$row[2]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
				if( strlen($row[3]) )
					echo("<td>".$row[3]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
				echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
				echo "</tr>";
         } // for i < nombre de rangé
	     echo "</tbody>
        </table>
	  </font>	
  </form>
 
<script LANGUAGE='javascript'>
	window.onload=function(){tableruler();}
	
	function QuitterPage() {
		open('quit.php','_top');
	} // Quitter 
	
	function Modif() {
		// Trouver le choix
		var No=0;
		j=Liste.choix.length; 
		for (i=0; i<j; i++){
			if( Liste.choix[i].checked ) 
				No = Liste.choix[i].value;
		}
		str = '".$_GET['action'].".php?NoProd=".$_GET['NoProd']."&choix='+No;
		//do=trouve&
		open(str,'_top');
	} // Modif
	
//	addKeyEvent();

</script >
<!-- script language=JavaScript1.2 src='javafich/blokclick.js'></script -->

</body>
</html>
";
}
?>
