<?php
    /* Programme : LoginLst.php
    * Description : Affichage de la liste des code de prix.
    */
//session_start();
include('connect.inc');

if( @$_SESSION['Prio'] > 2 ){
		//echo "Acces Interdit<br>";
   		header( "Location: mainfr.php");
   		exit();
}
//include("var.inc");
//include("varcie.inc");

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur du Login</title>
      </head>
      <body bgcolor='#D8D8FF'>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message</b>
      <form action='Support.php?do=refresh' method='post'>
         <input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()'>
      </form>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
      Les droits de reproduction de ce site © <?php echo $CopyAn, $NomCie ?>.<br>
      Tous droits réservés. © <?php echo $CopyAn ?><br>
      </font></p>
      <SCRIPT LANGUAGE='javascript'>
      function QuitterPage() {
              close();
      } // QuitterPage
      </SCRIPT>
      </body>
      </html>
  \n";
   exit();
}

$sql = "SELECT * FROM $database.login";
if( strlen(@$_GET['NomLog']) ) 
	$sql .= " WHERE NomLogin='".@$_GET['NomLog']."'";

$sql .= " ORDER BY DateLogin DESC LIMIT 200";


$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Login impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  echo "<html>
   <head>
       <title>Consultation des Accès/Logins</title>
      </head>
      <body bgcolor='#D8D8FF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
         <form action='mainfr.php' method='post'>
           <p align='center'> <font size='+2'><b>Liste des Accès système</b></font></p>
             <p align='center'>
             <input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()'> ";
	  		 if( @$Prio < 2 ) {
              echo"<input type='submit' name='Détruire' value='Détruire'> ";
			 }
			 echo "
           <hr size='5' color='#7CDFDF'>
           <table border='1' width='100%' align='center'>
             <thead>
                <tr>";
                echo("<th>".mysql_field_name($result,0)."</th>");
                echo("<th>".mysql_field_name($result,1)."</th>");
                echo("<th>".mysql_field_name($result,2)."</th>");
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
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#7CDFDF'>
             <p align='center'>
             <input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()'> ";
	  		 if( @$Prio < 2 ) {
              echo"<input type='submit' name='Détruire' value='Détruire'> ";
			 }
			 echo "
         </form>
      <script language='javascript'>
      function QuitterPage() {
              close();
      } // QuitterPage
      </script>
   </body>
</html>
";
}
else {
?>
    <html>
      <head>
       <title>Consultation Accès</title>
      </head>
      <body bgcolor='#D8D8FF'>
      		<p align='center'>
      		<font size='+2'><b><?=$TabMessGen[38]?></b></font>
             	<hr size='5' color='#7CDFDF' />
             	<p align='center'>
             	<input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()' /> 
	      	<script language='javascript'>
	      		function QuitterPage() {
	              		close();
	      		} // QuitterPage
	      	</script>
      </body>
    </html>
<?php
}
?>

