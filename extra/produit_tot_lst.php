<?php
/* Programme : LetCliLst.php
* Description : Affichage d'une liste de client pour les lettres.
* Auteur : Denis Léveillé 		Date : 2007-03-20
*/
// Début de la session
include('connect.inc');

if( !isset($_GET['couleur']) )
	$_GET['couleur'] = '#FFFFFF';
	
if( !isset( $_GET['action'] ) )
	$_GET['action'] = "produits_recherche";
	

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Produit</title>
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
      <SCRIPT LANGUAGE='javascript'>
	  		  addKeyEvent();

	  </SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT>
      </body>
      </html>
  \n";
   exit();
}

	$query = "SELECT * FROM $mysql_base.stock;";
	$result = mysql_query($query, $handle); 

if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Catalogue impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
       <title>Choix d'un client</title>	   
	  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
	  <meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
	  <meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
	  <meta name='author' content='$NomCieCréé' >
	  <meta name='copyright' content='copyright © $CopyAn $NomCie' >
	   <LINK title=HermesStyle href='styles\stylegen.css' type=text/css rel=STYLESHEET>
	  
<SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
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

<body bgcolor='#".$_GET['couleur']."' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
 <form name='Liste' action='".$_GET['action'].".php?do=new' method='post' ENCTYPE='multipart/form-data'>
		<font size='-1'>
        <table id='demo' class='ruler' summary='Liste des catégorie' border='1' width='100%' align='center'>
          <thead>
	     <tr>";
	     	for( $i=0; $i < mysql_num_fields($result); $i++ ) 
             echo("<th>".mysql_field_name($result,$i)."</th>");
	
	     echo "</tr>
          </thead>
	  <tbody>";
	     for( $i=0; $i < mysql_num_rows($result); $i++ ) {
	   	 	echo "<tr>";
			  	$row = mysql_fetch_row($result);
	     		for( $j=0; $j < mysql_num_fields($result); $j++ ){
					if( strlen($row[$j]) )
						echo("<td>".$row[$j]."</td> ");
					else
						echo("<td>&nbsp;</td> ");
				}
				echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'>");
				echo "</tr>";
         } // for i < nombre de rangé
	     echo "</tbody>
        </table>
	  </font>	
  </form>
 
<SCRIPT LANGUAGE='javascript'>
	window.onload=function(){
		tableruler();
	}
	
	function QuitterPage() {
		open('quit.php','_top');
	} // Quitter 
	
	function Modif() {
		// Trouver le choix
		var No=0;
		j=Liste.choix.length; 
		for (i=0; i<j; i++){
			if( Liste.choix[i].checked) No = Liste.choix[i].value;
		}
		str = '".$_GET['action'].".php?do=trouve&choix='+No;
		open(str,'_top');
	} // Modif
	
//	addKeyEvent();

</SCRIPT>
<!-- SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT -->

</body>
</html>
";
}
?>
