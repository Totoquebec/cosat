<?php
    /* Programme : LienLst.php
    * Description : Affichage de la liste des Liens
    
session_start();
if( @$_SESSION['auth'] != "yes") {
   	header( "Location: login.php");
   	exit();
}

include("var.inc");
include("varcie.inc");*/
include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Liens</title>
      </head>
      <body bgcolor='#9BB7FF'>
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
      Tous droits réservés. © <?php echo $CopyAn?><br>
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


// Connection au serveur
$connection = mysql_connect( $host, $user, $password)
	or die( "Connection impossible au serveur");
$db = mysql_select_db( $database, $connection )
	or die("La base de données ne peut être sélectionnée");

$sql = " SELECT * FROM pgliens";
$result = mysql_query( $sql );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès a la table des Liens IMPOSSIBLE", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
?>
<html>
   <head>
       <title>Consultation des Liens</title>
      </head>
	<link title='hermesstyle' href="styles/styleprod.css" type='text/css' rel='stylesheet'>
	<!--script language='javascript1.2' src='javafich/disablekeys.js'></script>
	<script language='javascript1.2' src='javafich/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script-->
	<script language='javascript1.2' src="js/mm_menu.js"></script>
	<?php
	switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
				break;
		case "SPANISH" :echo "<script language='JavaScript1.2' src='js/ldmenusp.js'></script>\n";
				break;
		default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
	}
	?>
	<body bgcolor='#9BB7FF' onload='javascript:pageonload()'>
	<script language='JavaScript1.2'>mmLoadMenus();</script>
         <form action='construction.html' method='post'>
           <p align='center'> <font size='+2'><b>Sommaire des Liens</b></font></p>
           <hr size='5' color='#9999FF'>
           <table border='1' width='100%' align='center'>
             <thead>
                <tr>
<?php
                echo("<th>".mysql_field_name($result,0)."</th>");
                echo("<th>".mysql_field_name($result,1)."</th>");
                echo("<th width='10'>".mysql_field_name($result,2)."</th>");
                echo("<th >".mysql_field_name($result,3)."</th>");
                echo("<th  width='10'>".mysql_field_name($result,4)."</th>");
?>
                </tr>
             </thead>
             <tbody>
<?php
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
                           echo("<td width='10'>".$row[2]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[3]) )
                           echo("<td>".$row[3]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[4]) )
                           echo("<td  width='10'>".$row[4]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#9999FF'>
             <p align='center'>
             <input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()'> ";
	  		 if( @$Prio < 2 ) {
              echo"<input type='submit' name='Détruire' value='Détruire'> ";
			 }
			 echo "
         </form>
         <SCRIPT LANGUAGE='javascript'>
         function QuitterPage() {
                 close();
         } 
         </SCRIPT>
   </body>
</html>
";
}
else {
  echo "
    <html>
      <head>
       <title>Consultation des Liens</title>
      </head>
      <body bgcolor='#9BB7FF' onload='javascript:pageonload()'>
         <SCRIPT LANGUAGE='javascript'>
         function pageonload() {
                 close();
         } // QuitterPage
         </SCRIPT>
      </body>
    </html>
  ";
}
?>

