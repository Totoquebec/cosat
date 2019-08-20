<?php
/* Programme : LetCliLst.php
* Description : Affichage d'une liste de client pour les lettres.
* Auteur : Denis Léveillé 		Date : 2007-03-20
*/
// Début de la session
include('connect.inc');

// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "FRENCH":		$tit = 26;
							break;
	case "ENGLISH":	$tit = 27;
							break;
	default:				$tit = 28;

} // switch SLangue

function MetMessErreur( $Erreur, $Message, $NoErr )
{
global $TabMessGen;
// Début de la session
include('connect.inc');
 echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
      <title>$TabMessGen[150]</title>
      </head>
 	  <SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
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
		<script language='javascript1.2'>
			addKeyEvent();
		
		</script>
		<script language='JavaScript1.2' src='javafich/blokclick.js'></script>
      </body>
      </html>
  \n";
   exit();
}

	$_GET['sql'] = stripslashes( $_GET['sql'] );
	$_GET['sql'] = stripslashes( $_GET['sql'] );
//MetMessErreur( "SQL TEST"," SQL >".$_GET['sql']."<", 0 );

$result = mysql_query( $_GET['sql'] );
if( $result == 0 ) 
  MetMessErreur(mysql_error(),$TabMessGen[151], mysql_errno());

if (  mysql_num_rows($result) == 0 ) 
  MetMessErreur( 0,$TabMessGen[42], 0);

echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
       <title>$TabMessGen[153]</title>	   
		<style type='text/css' media='all'>
			#demo tr.ruled {
			  background:#FFFF80;
			}
		</style>
	   <LINK title=HermesStyle href='styles\stylegen.css' type=text/css rel=STYLESHEET>

	  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
	  <meta http-equiv='Content-Disposition' content='inline; filename=Liste de produits' >
	  <meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
	  <meta name='author' content='$NomCieCréé' >
	  <meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<script language=JavaScript1.2 src='javafich/disablekeys.js'></script>
		<script language='JavaScript1.2' src='javafich/denislib.js'></script>
  </head>

<body bgcolor='#".$_GET['couleur']."'>
 <form name='Liste' action='".$_GET['action'].".php?do=trouve' method='post' ENCTYPE='multipart/form-data'>
		<font size='-1'>
        <table id='demo' class='ruler' summary='Liste des produits' border='1' width='100%' align='center'>
          <thead>
	     <tr>";
             echo("<th>".mysql_field_name($result,0)."</th>");
             echo("<th>".mysql_field_name($result,5)."</th>");
             echo("<th>".mysql_field_name($result,$tit)."</th>");
             echo("<th>".mysql_field_name($result,1)."</th>");
             echo("<th>".mysql_field_name($result,21)."</th>");
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
                if( strlen($row[5]) )
                	echo("<td>".$row[5]."</td> ");
                else
                	echo("<td>&nbsp;</td> ");
                if( strlen($row[$tit]) )
                	echo("<td>".$row[$tit]."</td> ");
                else
                	echo("<td>&nbsp;</td> ");
                if( strlen($row[1]) )
                	echo("<td>".$row[1]."</td> ");
                else
                	echo("<td>&nbsp;</td> ");
                if( strlen($row[21]) )
                	echo("<td>".$row[21]."</td> ");
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
		 		  open('mainfr.php','MAIN');
         } // Quitter 

		function Modif() {
		 // Trouver le choix
		    var No=0;
		 	j=Liste.choix.length; 
	   		for (i=0; i<j; i++){
		     	   if( Liste.choix[i].checked) No = Liste.choix[i].value;
	        }
		    str = '<?=$_GET['action']?>.php?do=trouve&choix='+No;
		 	open(str,'<?=$_GET['target']?>',
             'left=10,top=10,height=555,width=768,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes');
		} // Modif
	
	addKeyEvent();

</script>
<script language='JavaScript1.2' src='javafich/blokclick.js'></script>

</body>
</html>