<?php
    /* Programme : PhotoPut.php
    * Description : Ajout d'une image rattaché à une oeuvre
    */
include('connect.inc');

//include("../formatjpeg.php");
// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
	case "ENGLISH":	include("produits_messen.inc");
							break;
	case "SPANISH":	include("produits_messsp.inc");
							break;
	default:	include("produits_messfr.inc");

} // switch SLangue

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Chargement Image</title>
		<script language=JavaScript1.2 src='javafich/disablekeys.js'></script>
      </head>
     <body bgcolor='#C0C0FF'>
	 <FORM METHOD=post ACTION='photoput.php' ENCTYPE='multipart/form-data'>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message </b><br>
	  <INPUT TYPE='button' value='Quitter' onClick='QuitterPage()'>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
      Les droits de reproduction de ce site © $CopyAn $NomCie.<br>
      Tous droits réservés. © $CopyAn<br>
      </font></p>
	  </FORM>
	  <script LANGUAGE='javascript'>
		 
         function QuitterPage() {
                 close();
         } // Quitter 
	  
		 addKeyEvent();

		</script>
		<script language=JavaScript1.2 src='javafich/blokclick.js'></script>
      </body>
      </html>
  \n";
   exit();
}



if (@$_POST['action'] == "upload") {

  
  if( isset($_FILES['FichPhoto']) && $_FILES['FichPhoto']['name'] != "") {
  
  	$NoInvent = $_POST['NoStock'];
	$NomFich = $_FILES['FichPhoto']['name'];
	$SizeFich = $_FILES['FichPhoto']['size'];
	$TypeFich = $_FILES['FichPhoto']['type'];
	
    $filehnd = @fopen($_FILES['FichPhoto']['tmp_name'], "r");

        // Es-ce réussi ?
    if( !$filehnd  ){
                echo "<p>Impossible d'ouvrir ".$_FILES['FichPhoto']['name']."</p>\n";
                return FALSE;
    }
	
	$data = addslashes(fread($filehnd, filesize($_FILES['FichPhoto']['tmp_name'])));
    
	// Fermer le fichier
    fclose($filehnd);
	
	$LargeX = $HautY = 0;
	DonneFormatJPEG( $_FILES['FichPhoto']['tmp_name'], $LargeX, $HautY );
	
	$Aujourdhui = date("Y-m-d");
	
	$NomF = addslashes($NomFich);

    $sql = "insert into $mysql_base.photo (NoInvent, DateCréé, Affichable, Largeur, Hauteur, FileName, FileSize, FileType, Photo )"; 
	 $sql .= " value ('$NoInvent', '$Aujourdhui', '".$_POST['Affichable']."', '$LargeX', '$HautY', '$NomF', '$SizeFich', '$TypeFich', '$data' )";

    if( !mysql_query($sql, $handle) ) {
		   MetMessErreur( mysql_error(),"Insertion invalide ".$sql,mysql_errno() );
    }
	header( "Location: photoput.php?choix=$NoInvent");
  }
  else {
  	  MetMessErreur("Fichier binaire","Nom fichier binaire vide", NULL);
  }
  mysql_close();
} else {

echo "
<HTML>
<head>
<title>".$TabId[7]."</title>
</head>
<BODY bgcolor='#C0C0FF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
<p align='center'> <font size='+1'><b>".$TabId[4]."</b></font></p>";


	// **** CONNECTION AU SERVEUR

  	$sql = " SELECT * FROM $mysql_base.photo";
	$sql .= " WHERE NoInvent='".$_GET['choix']."'";
  
  $result = mysql_query( $sql, $handle );
  
  if( $result != 0 ) {
   	   echo "<form action='photodetruit.php?no=".$_GET['choix']."' method='post'>";
  	   echo "<TABLE align=center BORDER='1' width=100%>";
       echo "<tr>\r\n";
	   for( $i=1; $i <= mysql_num_rows($result); $i++ ) {
          $row = mysql_fetch_row($result);
		  
		    if( $row[4] ) {
			    $Pourcent = 125/$row[4];
		    	$Largeur = $row[4]*$Pourcent;
			}
			else
		    	$Largeur = 125;
			if( $row[5] )
				$Hauteur = $row[5]*$Pourcent;
			else
				$Hauteur = 125;
			echo "<TD>";
echo <<<END
			<a href="#section2" onmouseover="window.status='Cliquer pour accéder à cette image en mode plein écran'; return true" 
			onClick="AfficheImage($row[0],$row[1])" onmouseout="window.status=''; return true" >
END;
			echo "<img src='photoget.php?No=$row[0]&Idx=$row[1]' width=$Largeur height=$Hauteur><br>\n";
			echo "</a>";
			$Hauteur = sprintf("%6.2f",$Hauteur);
			echo "<font size='-1'><i>$row[1]&nbsp;&nbsp;&nbsp;$row[4]&nbsp;X&nbsp;$row[5]</i></font><br>
			<font size='-1'>$row[6]</font><br>
			<select name='Affichable' size='1'>
         			<option value='Oui'";
		 			if( $row[3] == "Oui" ) echo "SELECTED";
		 			echo " >Oui\n
         			<option value='Non'"; 
		 			if( $row[3] == "Non" ) echo "SELECTED";
		 			echo " >Non
         	</select>
			<input name='chximg' TYPE='radio' VALUE='$row[1]'>";
			echo "</TD>\r\n";
			if( $i && !($i % 2 ) ) {
//	   			echo "<TD colspan=2>&nbsp;</TD>";
            	echo "</tr>\r\n";
                echo "<tr>\r\n";
				echo "<td colspan=6>&nbsp</td>\n";
                echo "</tr>\r\n";
                echo "<tr>\r\n";
			}
	   } // Si resultat contient des rangées
	    echo "</tr>\r\n
         	 <tr>\r\n
				<td colspan=6>
  	  	 			<p align='center'>          	
					   <input type=submit name='Go' value='".$TabId[48]."'>&nbsp;&nbsp;";
					  // <input type='button' name='Modif' value='".$TabId[41]."' onClick='ModifPhoto($row[0],$row[1])'></p>
				echo "
				</td>\n
             </tr>\r\n
		 </TABLE>
  		  </form>\r\n";
   } // Si un resultat valide 
    
$Affichable = "Oui";
echo "
<FORM METHOD=post ACTION='photoput.php' ENCTYPE='multipart/form-data'>
 <INPUT TYPE='hidden' NAME='MAX_FILE_SIZE' VALUE='10000000'>
 <INPUT TYPE='hidden' NAME='action' VALUE='upload'>
 
 <TABLE align=center BORDER='1'>
   <TR>
     <TD>".$TabId[6].":&nbsp;</TD>
     <TD><INPUT TYPE='text' NAME='NoStock' VALUE='".$_GET['choix']."'></TD> 
   </TR>
   <TR>
     <TD>".$TabId[52].":&nbsp;</TD>
     <TD><INPUT TYPE='file' NAME='FichPhoto' ACCEPT='image/jpeg'></TD>
   </TR>
   <tr>
       <td align=right>".$TabId[7]."&nbsp;</td>
         <td><select name='Affichable' size='1'>
         <option value='Oui'";
		 if( $Affichable == "Oui" ) echo "SELECTED";
		 echo " >Oui\n
         <option value='Non'"; 
		 if( $Affichable == "Non" ) echo "SELECTED";
		 echo " >Non
         </select>
       </td>
   </tr>
   
   <TR>
     <TD COLSPAN='2' align=center>
	 <INPUT TYPE='submit' VALUE='".$TabId[42]."'>&nbsp;
	 <INPUT TYPE='button' value='".$TabId[36]."' onClick='QuitterPage()'>
	 </TD>
   </TR>
 </TABLE>
</FORM>
<SCRIPT LANGUAGE='javascript'>

		function ModifPhoto(No, Idx) {
				 str = 'photomodif.php?No=' + No + '&Idx=' + Idx;
				 open(str,'_blank',
    			 'left=10,top=10,height=300,width=600,status=no,toolbar=no,menubar=no,location=no,resizable=no' );
		} // Modif Photo
		 
   function AfficheImage(No,Idx) {
		    str = 'photofull.php?No=' + No + '&Idx=' + Idx;
		 	open(str,'_blank',
             'left=1,top=1,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=yes fullscreen=yes' );
   } // AfficheImage
			
         function QuitterPage() {
                 close();
         } // Quitter 
		 
		 
</SCRIPT>
</BODY>
</HTML>";
}
?>
