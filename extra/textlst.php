<?php
    /* Programme : SerLst.inc
    * Description : Affichage de la biographie.
    */
include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
       <title>LIST</title>
      </head>
     <body bgcolor='#FFFFFF'>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message</b>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>".
      sprintf($txt['Copyright'], $param['CopyAn'], $param['nom_client'] ).
      "</font></p>
       </body>
      </html>
  \n";
   exit();
}


$sql = " SELECT * FROM $database.messages WHERE Langue = 'fr';";
$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Message Impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>

   <head>
       <title>Liste des Actvités</title>
	   <link title='MessStyle' href='styles/stylelst.css' type='text/css' rel='STYLESHEET'>
<!--script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script-->
<script type='text/javascript'>

function tableruler() {
  if (document.getElementById && document.createTextNode) {
    var tables=document.getElementsByTagName('table');
    for (var i=0;i<tables.length;i++){
      if(tables[i].className=='ruler') {
        var trs=tables[i].getElementsByTagName('tr');
        for(var j=0;j<trs.length;j++) {
          if(trs[j].parentNode.nodeName=='TBODY') {
            trs[j].onmouseover=function(){this.className='ruled';return false}
            trs[j].onmouseout=function(){this.className='';return false}
          } // Si TBODY
        } // for j
      } // Si ruler
    } // for i
  } // si document
} // tableruler

</script>
   </head>
   <body bgcolor='#D8D8FF' >
         <form name='Liste' action='textconsult.php' method='post' enctype='multipart/form-data' >
           <table id='demo' class='ruler' summary='Table des Messages' border='1' width='100%' align='center'>
<?php
                for( $i=0; $i < mysql_num_rows($result); $i++ ) {
                   $row = mysql_fetch_row($result);
                   for( $j = 1; $j < mysql_num_fields($result); $j++ ) {
                   	echo "<tr>";
                   	echo("<td width='100px'>".mysql_field_name($result,$j)."</td> ");
                   	if( strlen($row[$j]) )
                           echo("<td width='200px'>".$row[$j]."</td> ");
                   	else
                           echo("<td>&nbsp;</td> ");
                   	echo("<td width='10px'><input name='choix' TYPE='radio' VALUE='$j'></td>");
                   	echo "</tr>";
                   }
                } // for i < nombre de rangé
?>
                </tbody>
           </table>
         </form>
<script language='javascript'>
// *********************************************************************
// *****  PROCEDURE MISE EN MARCHE A L'OUVERTURE ***********************
// *********************************************************************
		 
		 window.onload=function(){tableruler();}
		 		 
// *********************************************************************
// ***** FONCTION JAVA DE LA PAGE  *************************************
// *********************************************************************
	function QuitterPage() {
		open('mainfr.php','MAIN');
	} // Quitter 
		 
	function Modif() {
		// Trouver le choix
		var No=0;
		j=Liste.choix.length; 
		if( j > 1 ) { 
			for (i=0; i<j; i++){
				if( Liste.choix[i].checked) {
		   	   		No = Liste.choix[i].value;
		   		} // Si choisi	   
			} // pour tous les items
		}
		else {
		  	No = Liste.choix.value;
		} // Si choisi	   
		str = 'textconsult.php?choix='+No;
		open(str,'MAIN');
	} // Ajout Photo



      </script>
   </body>
</html>
<?php
}
else {
?>
   <html>
      <head>
       <title>Liste des messages</title>
      </head>
      <body bgcolor='#FFFFFF'>
           <p align='center'> <font size='+2'><b>Sommaire des messages</b></font></p>
           <hr size='5' color='#9999FF'>
		   AUCUNS MESSAGES DE DÉFINIS
      	   <p align='center' valign='bottom'><font size='1'><br>
      	   <br>
      	   <?php echo sprintf($txt['Copyright'], $param['CopyAn'], $param['nom_client'] );?>
      	   </font></p>
      </body>
    </html>
<?php
}
?>