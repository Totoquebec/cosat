<?php
/* Programme : MCRPLst.inc
* Description : Affichage de la liste des opération à un compte client.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-27
*/
include('connect.inc');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("msmessen.inc");
			break;
	case "SPANISH":	include("msmesssp.inc");
			break;
	default:	include("msmessfr.inc");
} // switch SLangue


function MetMessErreur( $Erreur, $Message, $NoErr )
{
global $TabMessSecur, $TabMessGen;
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>$TabMessSecur[90]</title>
      </head>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
      <body bgcolor='#C0C0FF'>
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

	  </SCRIPT>
      </body>
      </html>
  \n";
   exit();
}

								   			   
$sql = "SELECT * FROM $database.secur WHERE NoClient < 100;";
$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),$TabMessSecur[91], mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  echo "<html>
   <head>
       <title>$TabMessSecur[92]</title>
      </head>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
      <body bgcolor='#C0C0FF''>
         <form action='msconsult.php' method='post'>
           <p align='center'> <font size='+2'><b>$TabMessSecur[93]</b></font></p>
           <hr size='5' color='#9999FF'>
             <p align='center'>
    	   	 <input type='submit' style='visibility:' name='Commande' value='$TabMessGen[102]'>\n 
  	   	 	<input type='submit' style='visibility:' name='Commande' value='$TabMessGen[27]'>\n 
             <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'> ";
	  		 if(  @$_SESSION['Prio'] < $PrioCompte )
              echo"<input type='submit' name='Commande' value='$TabMessGen[26]'> ";
			 echo " </p>
           <table border='1' width='100%' align='center'>
             <thead>
                <tr>";
                echo("<th>".mysql_field_name($result,0)."</th>");
                //echo("<th>".mysql_field_name($result,1)."</th>");
                echo("<th>".mysql_field_name($result,2)."</th>");
                echo("<th>".mysql_field_name($result,3)."</th>");
                echo("<th>".mysql_field_name($result,4)."</th>");
                echo("<th>".mysql_field_name($result,5)."</th>");
                echo("<th>".mysql_field_name($result,6)."</th>");
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
                   /*if( strlen($row[1]) )
                           echo("<td width='100'>".$row[1]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");*/
                   if( strlen($row[2]) )
                           echo("<td>".$row[2]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[3]) )
                           echo("<td>".$row[3]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[4]) )
                           echo("<td>".$row[4]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[5]) )
                           echo("<td>".$row[5]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[6]) )
                           echo("<td>".$row[6]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#9999FF'>
             <p align='center'>
   	   	 <input type='submit' style='visibility:' name='Commande' value='$TabMessGen[102]'>\n <!-- Transaction --> 
   	   	 <input type='submit' style='visibility:' name='Commande' value='$TabMessGen[27]'>\n  <!-- Détruire --> 
             <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'> "; // Quitter
	if( @$_SESSION['Prio'] < $PrioCompte )
              echo"<input type='submit' name='Commande' value='$TabMessGen[26]'> "; // Détruire
			 echo " </p>
         </form>
";
}
else {
  echo "
      <html>
      <head>
       <title>$TabMessSecur[92]</title>
      </head>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
	  <body bgcolor='#C0C0FF'>
	  <BASE TARGET=MAIN>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessSecur[94]</h2>
      <div align='center'>
      <form action='mainfr.php?do=refresh' method='post'>
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
  ";
}
?>
<script language="javascript1.2">
         function QuitterPage() {
                 close();
         } 
	<?php
		if( isset($NewMessage) ) {
			echo "	alert(\"$NewMessage\"); ";
	      unset( $NewMessage );
	   }
	?>
</script>
   </body>
</html>

