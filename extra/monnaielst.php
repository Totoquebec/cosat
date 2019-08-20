<?php
/* Programme : CodPLst.inc
* Description : Affichage de la liste des code de prix.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-24
*/
include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
global $TabMessGen, $NomCie, $AdrCourriel;

  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
      <head>
      <title>$TabMessGen[112]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
      <body bgcolor='#D8D8FF'>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessGen[22] $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>$TabMessGen[23] $Message</b>
      <form action='mainfr.php' method='post'>
         <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'>
      </form>
      </div>
		<div align='center'><font size=-1>
		$TabMessGen[1]
		<a href='mailto:$AdrCourriel?subject=Page Web $NomCie'>
		$TabMessGen[2]</a>
		</font></div>
		<p align='center' valign='bottom'><font size=1>
		$TabMessGen[8]		 
		$TabMessGen[3]		 
		$NomCie
		$TabMessGen[4]		  
		</p>
		
      <SCRIPT LANGUAGE='javascript'>
         function QuitterPage() {
              close();
         } // QuitterPage
		 addKeyEvent();

	  </SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='js/blokclick.js'></SCRIPT>
      </body>
      </html>
  \n";
   exit();
}

$sql = " SELECT * FROM $database.monnaies";
$result = mysql_query( $sql,$handle );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),$TabMessGen[61], mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  echo 
"<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
 <html  xmlns='http://www.w3.org/1999/xhtml'>
 <head>
	<title>$TabMessGen[112]</title>
	<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
	<meta http-equiv='Content-Disposition' content='inline; filename=Liste dee monnaies' >
	<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
	<meta name='author' content='$NomCieCréé' >
	<meta name='copyright' content='copyright © $CopyAn $NomCie' >
	<link title=HermesStyle href='styles\styleutl.css' type=text/css rel=STYLESHEET>
	<style type='text/css' media='all'>
		#demo tr.ruled {
		  background:#B4E7FF;
		}
	</style>
 </head>
	<script language='JavaScript1.2' src='js/denislib.js'></script>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
 <body bgcolor='#D8D8FF' >
			<script language='JavaScript1.2'>window.onload=function(){tableruler();}</script>
         <form name='Liste' action='monnaiemodif.php' method='post' ENCTYPE='multipart/form-data'>
           <p align='center'> <font size='+2'><b>$TabMessGen[112]</b></font></p>
           <hr size='5' color='#7CDFDF'>
             
           <table id='demo' class='ruler' summary='Table des monnaies' border='1' width='100%' align='center'>
             <thead>
                <tr>";
				for( $i=0; $i < mysql_num_fields( $result); $i++ ) 
                	 echo("<th>".mysql_field_name($result,$i)."</th>");
                echo "</tr>
             </thead>
             <tbody>";
                for( $i=0; $i < mysql_num_rows($result); $i++ ) {
                   echo "<tr>";
                   $row = mysql_fetch_row($result);
				   for( $j=0; $j < mysql_num_fields( $result); $j++ )  {
                     if( strlen($row[$j]) )
                           echo("<td>".$row[$j]."</td> ");
                     else
                           echo("<td>&nbsp;</td> ");
				   } // Pour chaque champs
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#7CDFDF'>
             <p align='center'>
             <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'> 
             <input type='submit' name='Modifier' value='$TabMessGen[18]'> ";
	  		 if( @$_SESSION['Prio'] < 2 )
              echo"<input type='submit' name='Détruire' value='$TabMessGen[26]'> ";
			 echo " </p>
         </form>
";
}
else {
  echo "
    <html>
      <head>
       <title>$TabMessGen[62]</title>
      </head>
      <body bgcolor='#D8D8FF'>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessGen[64]</h2>
      <div align='center'>
      <form action='mainfr.php?do=refresh' method='post'>
         <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'>
      </form>
		<div align='center'><font size=-1>
		$TabMessGen[1]
		<a href='mailto:$AdrCourriel?subject=Page Web $NomCie'>
		$TabMessGen[2]</a>
		</font></div>
		<p align='center' valign='bottom'><font size=1>
		$TabMessGen[8]		 
		$TabMessGen[3]		 
		$NomCie
		$TabMessGen[4]		  
		</p>
  ";
}
?>
<script language="javascript">
         function QuitterPage() {
                 close();
         } 

</script>

</body>
</html>