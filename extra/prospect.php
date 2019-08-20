<?php
/* Programme : Prospect.php
* Description : Affichage de la page des prospect.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-19
*/
include('connect.inc');
// Es-ce que l'usager à la priorité pour accéder cette fonction
if( @$_SESSION['Prio'] > $PrioModif ){
   		header( "Location: mainfr.php?Mess='Accès Interdit !'");
   		exit();
} // Si pas access autorisé

?>
<html>
<head>
<title>Page de traitement des Prospect</title>
</head>
<link title='hermesstyle' href="styles/styleprod.css" type='text/css' rel='stylesheet' />
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
<body bgcolor="#A2E8E8" >
<script language='JavaScript1.2'>mmLoadMenus();</script>
<base target=main>
<?php
// Connection au serveur
	$query = "SELECT * FROM contact";
	$result = mysql_query( $query, $handle );
	echo "
   	<p align='center'> <font size='+2'><b>Consultation des prospects</b></font></p>
	<hr size='5' color='#0dc4c4'>";
	if( $result == 0 ) {
		echo( "<b>Erreur ".mysql_errno().": ".mysql_error()."</b>");
   	}
	elseif (  @mysql_num_rows($result) == 0 ) {
	      	echo("<p align='center'><font size='+2'><b>Aucun nouveau prospect</b></font></p><br>");
        }
	else {
//		echo "
//			 <form action='prospdetruit.php' method=post>
		echo "
			 <form action='prospect_repond.php' method=post>
			 <table border='1' align='center'>
	         <thead>
	         <tr>";
	         for( $i=0; $i < mysql_num_fields( $result ) ; $i++ ) {
			 	  echo("<th>".mysql_field_name($result,$i)."</th>");
	         } /* for i < nombre de champs */
	         echo "</tr>
	         </thead>
	         <tbody>";
	         for( $i=0; $i < mysql_num_rows($result); $i++ ) {
			echo "<tr>";
                  	$row = mysql_fetch_row($result);
                  	for( $j=0; $j < mysql_num_fields( $result ) ; $j++ ) {
				    if( strlen($row[$j]) )
				  	   echo("<td>".$row[$j]."</td> ");
					else
				  	   echo("<td>&nbsp;</td> ");
                  	} // for j
                  	echo"	<td>
		  			<input name='choix' TYPE='radio' VALUE='$i'>
		  			<input name='dest_prenom[]' TYPE='hidden' VALUE='$row[1]'>
		  			<input name='dest_nom[]' TYPE='hidden' VALUE='$row[2]'>
		  			<input name='dest_courriel[]' TYPE='hidden' VALUE='$row[8]'>
				</td>
				</tr>";
	         } // for i < nombre de rangé
	         echo "</tbody>
	         </table>";
	      } // else resultat disponible
	echo "
	<hr size='5' color='#0dc4c4'>
   <br>
   <p align='center'>
        <input type='submit' name='Quitter' value='Quitter'>"; 
	  	if( @$Prio < 2 ) {
              		echo"<input type='submit' name='Détruire' value='Détruire'> ";
		}
	echo "
  	</form>";
?>


</body>
</html>
