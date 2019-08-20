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
      <title>Page d'erreur Catalogue</title>
      </head>
		<script language='javascript1.2' src='js/disablekeys.js'></script>
		<script language='javascript1.2' src='js/blokclick.js'></script>
		<script language='JavaScript1.2'>addKeyEvent();</script>
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
      </body>
      </html>
  \n";
   exit();
}

    $query = "SELECT id,parent,ordre,".$_SESSION['langue'].",online FROM $mysql_base.catalogue LEFT JOIN $mysql_base.catalogue_produits";
	 $query .= " ON $mysql_base.catalogue_produits.id_catalogue = $mysql_base.catalogue.id WHERE $mysql_base.catalogue_produits.id_produit=".$_GET['NoProd'];
    $result = mysql_query( $query, $handle ); 


if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Catalogue impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
      <title>Choix d'un catalogue</title>	   
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<link title=HermesStyle href='styles/stylegen.css' type=text/css rel='STYLESHEET'>
		<style type='text/css' media='all'>
			#demo tr.ruled {
			background:#B4E7FF;
			}
		</style>

  </head>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
	<script language='JavaScript1.2' src='js/denislib.js'></script>

<body bgcolor='#".$_GET['couleur']."' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
 <form name='Liste' action='".$_GET['action'].".php?do=trouve' method='post' enctype='multipart/form-data'>
		<font size='-1'>
        <table id='demo' class='ruler' summary='Liste des catégorie' border='1' width='100%' align='center'>
          <thead>
	     <tr>";
             echo("<th>".mysql_field_name($result,0)."</th>");
             echo("<th>".mysql_field_name($result,2)."</th>");
             echo("<th>Parent</th>");
             echo("<th>Description</th>");
             echo("<th>".mysql_field_name($result,4)."</th>");
	
	     echo "</tr>
          </thead>
	  <tbody>";
	     for( $i=0; $i < mysql_num_rows($result); $i++ ) {
	   	 	  echo "<tr>";
			  $row = mysql_fetch_row($result);
				echo("");
				if( strlen($row[0]) )
					echo("<td>".$row[0]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
				if( strlen($row[2]) )
					echo("<td>".$row[2]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
    			$sql = "SELECT ".$_SESSION['langue']." FROM $mysql_base.catalogue WHERE id = $row[1];";
				$res = mysql_query( $sql, $handle );
				if( $res && mysql_num_rows($result) ) {
					$ligne = mysql_fetch_array($res,MYSQL_ASSOC);
					$TitParent = $ligne[$_SESSION['langue']];
				}
				else
					$TitParent = "";

				echo("<td>$TitParent</td> ");
				if( strlen($row[3]) )
					echo("<td>".$row[3]."</td> ");
				else
					echo("<td>&nbsp;</td> ");
				if( strlen($row[4]) )
					echo("<td>".$row[4]."</td> ");
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
		top.close();
		//open('quit.php','_top');
	} // Quitter 
	
	function Modif() {
		// Trouver le choix
		var No=0;
		if( window.confirm('".$TabMessGen[7]."') ){
	
			j=Liste.choix.length; 
			for (i=0; i<j; i++){
				if( Liste.choix[i].checked ) 
					No = Liste.choix[i].value;
			}
			str = '".$_GET['action'].".php?choix='+No+'&NoProd='+".$_GET['NoProd'].";
			//do=trouve&
			open(str,'_top');
		}
	} // Modif

</script >

</body>
</html>
";
}
?>
