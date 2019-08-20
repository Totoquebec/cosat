<?php
/* Programme : LetCliLst.php
* Description : Affichage d'une liste de client pour les lettres.
* Auteur : Denis Léveillé 		Date : 2007-03-20
*/
include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  global $TabMessGen;
  echo "
      <html>
      <head>
      <title>$TabMessGen[160]</title>
      </head>
	<!-- script language='javascript1.2' src='javafich/disablekeys.js'></script>
	<script language='javascript1.2' src='javafich/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script -->
    <body bgcolor='".$_GET['couleur']."'>
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

	$query = "SELECT id,parent,ordre,".$_SESSION['langue'].",online FROM $mysql_base.catalogue";
	if( @$_SESSION['parent'] )
		$query .= " WHERE parent != 0 ORDER BY parent ASC, id ASC;";
	else
		$query .= " ORDER BY parent ASC,".$_SESSION['langue']." ASC;";
	$result = mysql_query($query, $handle); 

if( $result == 0 ) {
  MetMessErreur(mysql_error(),$TabMessGen[161], mysql_errno());
}

if (  mysql_num_rows($result) == 0 ) 
  MetMessErreur( 0,$TabMessGen[43], 0);

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
       <title>$TabMessGen[222]</title>	   
	  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
	  <meta http-equiv='Content-Disposition' content='inline; filename=Liste de catalogue' >
	  <meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
	  <meta name='author' content='$NomCieCréé' >
	  <meta name='copyright' content='copyright © $CopyAn $NomCie' >
	   <LINK title=HermesStyle href='styles/stylegen.css' type=text/css rel=STYLESHEET>
	  
		<style type='text/css' media='all'>
			#demo tr.ruled {
			  background:#9EC2E0;
			}
		</style>
		<!-- script language='javascript1.2' src='javafich/disablekeys.js'></script>
		<script language='javascript1.2' src='javafich/blokclick.js'></script>
		<script language='JavaScript1.2'>addKeyEvent();</script -->
		<script language='JavaScript1.2' src='js/denislib.js'></script>
  </head>

<body bgcolor='#".$_GET['couleur']."'>
 <form name='Liste' action='".$_GET['action'].".php?do=new' method='post' ENCTYPE='multipart/form-data'>
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
  </form>";
?>

<script language='javascript1.2'>
	window.onload=function(){tableruler();}

         function QuitterPage() {
		top.close();
         } // Quitter 

	function Modif() {
	 // Trouver le choix
	    var No=0;
	 	j=Liste.choix.length; 
   		for (i=0; i<j; i++){
	     	   if( Liste.choix[i].checked) No = Liste.choix[i].value;
        	}
	    	str = '<?=$_GET['action']?>.php?do=new&NoProd=<?=$_GET['NoProd']?>&choix='+No;
	 	open(str,'_top');
	} // Modif
</script>
</body>
</html>