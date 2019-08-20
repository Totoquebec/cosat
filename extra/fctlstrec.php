<?php
/* Programme : TRanSactionLiSTeRECord.php
* Description : Affichage de la liste des transaction à l'interne.
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-01-28
*/

include('connect.inc');
$TabEtat = get_etat("");	

if( isset( $_POST['devise']) ) 
	$_SESSION['devise'] = $_POST['devise'];

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en" : 	include("trsmessen.inc");
						break;
	case "fr" : 	include("trsmessfr.inc");
						break;
	default : 		include("trsmesssp.inc");  
 // switch SLangue

function MetMessErreur( $Erreur, $Message, $NoErr )
{
global $TabMessTrs, $TabMessGen, $NomCie;

  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>$TabMessGen[202]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
      <body bgcolor='#EEEEFF'>
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
		<a href='mailto:<?php echo hexentities($AdrCourriel) ?>?subject=Page Web $NomCie'>
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
	  addKeyEvent();

	  </SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT>
      </body>
      </html>
  \n";
   exit();
}

  
$sql = "SELECT * FROM $mysql_base.ventes WHERE Etat='".@$_GET['Action']."' ";

switch(@$_GET['Action']) {
	case '1' :  $Etat = $TabMessTrs[1]; // Recu
		 		   break;
	case '2':	$Etat = $TabMessTrs[2]; //Envoyé
		 		   break;
	case '3':	$Etat = $TabMessTrs[3]; // Cuba
		 		   break;
	case '4':	$Etat = $TabMessTrs[4]; // Livré
		 		   break;
	case '5': 	$Etat = $TabMessTrs[0]; // Retenu
		 		   break;
	case '8':	$Etat = $TabMessTrs[5]."/".$TabMessTrs[119]; // Annule
					$sql .= " OR Etat='7' "; // Archive
		 		   break;
	default :	$Etat = $TabMessTrs[0];
} // switch

$sql .= ' order by id DESC;';

//MetMessErreur(0,$sql, 0);
//echo "Test";
$result = mysql_query( $sql, $handle );
if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Ventes impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
echo 
"<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
  	<head>
	   <title>$TabMessGen[127] : $Etat</title>
		<style type='text/css' media='all'>
			#demo tr.ruled {
			  background:#B4E7FF;
			}
		</style>
	  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
	  <meta http-equiv='Content-Disposition' content='inline; filename=Rapport Cpt Client' >
	  <meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
	  <meta name='author' content='$NomCieCréé' >
	  <meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<link title=rapstyle href='styles/styraptrs.css' type='text/css' rel='stylesheet'>
	</head>
   <script language='javascript1.2' src='javafich/mm_menu.js'></script>
	<script language='JavaScript1.2' src='javafich/denislib.js'></script>
   <script language='javascript1.2' src='javafich/disablekeys.js'></script>";
		switch( $_SESSION['SLangue'] ) {
			case "ENGLISH" :	echo "<script language='javascript1.2' src='javafich/ldmenuen.js'></script>";
									break;
			case "FRENCH" :	echo "<script language='javascript1.2' src='javafich/ldmenufr.js'></script>";
									break;
			default :			echo "<script language='javascript1.2' src='javafich/ldmenusp.js'></script>";
		}

 $i = mysql_num_rows($result);
 $Entete = 35;
echo 
"<body bgcolor='#EFEFEF' >
	<script language='JavaScript1.2'>mmLoadMenus();window.onload=function(){tableruler();}</script>
	<base target=MAIN>
	<form name='LstTrs' action='' method='post'>
		<p align='center'> <font size=big><b>
		<input type=text name='NbChoix' size=4 value='0' maxlength=4>$TabMessGen[127] : $Etat</b></font><br><br>\n";
		if( @$_SESSION['Prio'] < $PrioLivreur ) {
			echo"<input type='button' onClick='ConfirmeDet(this);return;' ";
			switch( $_GET['Action'] ){
				case "5"	: 	echo "name='Commande' value='$TabMessTrs[120]'>\n"; // Retenu
								$NewEtat = 1; //"Reçu";
								break;
				case "1" : 	echo "name='Commande' value='$TabMessTrs[27]'>\n"; //Reçu
								$NewEtat = 2; //"Envoyé";
								break;
				case "2"	:	echo "name='Commande' value='$TabMessTrs[28]'>\n"; //Envoyé
								$NewEtat = 3; //"Cuba";
								break;
				case "3"	:  echo "name='Commande' value='$TabMessTrs[29]'>\n"; //Cuba
								$Entete = 34;
								$NewEtat = 4; //"Livré";
								break;
				case "4"	:  echo "name='Commande' value='$TabMessTrs[119]'>\n"; //Livré
								$NewEtat = 7; //"Archivé";
								break;
				default	: 	echo "name='Commande' value='$TabMessGen[25]'>\n";
			} // switch action
		} // Si priorité
	   if( ( $_GET['Action'] == 1 ) || ( $_GET['Action'] == 2 ) || (@$_SESSION['Prio'] == 0) )
			echo("<input name='Tous' TYPE='button' VALUE='Tous/Aucun' onclick='ChoixTous(this);'>\n");
		echo "</p>	 
           <hr size='5' color='#7CDFDF'>
		
		<input name='NbTrans' TYPE='hidden' VALUE='$i'>
		<input name='NewEtat' TYPE='hidden' VALUE='".@$NewEtat."'>";
 //     <input name='transid' TYPE='hidden' VALUE='".Get_TransId()."'>
      echo "
		<table id='demo' class='ruler' summary='$TabMessGen[127]' border='1' width='100%' align='center'>
			<thead>
				<tr>";
                echo("<th>".mysql_field_name($result,0)."</th>");
                echo("<th>".mysql_field_name($result,2)."</th>");
                echo("<th>".mysql_field_name($result,4)."</th>");
                echo("<th>".mysql_field_name($result,5)."</th>");
                echo("<th>".mysql_field_name($result,21)."</th>");
                echo("<th>".mysql_field_name($result,3)."</th>");
                echo("<th>".mysql_field_name($result,33)."</th>");
				echo "</tr>
			</thead>
			<tbody>";
				
				for( $i=0; $i < mysql_num_rows($result); $i++ ) {
                   $row = mysql_fetch_row($result);
                   if( strlen($row[0]) )
                           echo("<td>".$row[0]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[2]) )
                           echo("<td>".$row[2]."</td> ");
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
                   if( strlen($row[21]) )
                           echo("<td>".$row[21]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[3]) )
                           echo("<td>".$TabEtat[$row[3]]."</td> ");
                   else
                           echo("<td>&nbsp;</td> ");
                 if( $row[33] == 1 ) 
                  	echo "<td>".$TabMessGen[200]."</td>";
                  else
                  	echo "<td>".$TabMessGen[201]."</td>";
					echo("<td><input name='choix' TYPE='radio' VALUE='$row[0]'></td>");
					if( ( $_GET['Action'] == 1 ) || ($_GET['Action'] == 2) || ($_GET['Action'] == 3) || (@$_SESSION['Prio'] == 0) )
						echo("<td><input name='var[$i]' TYPE='checkbox' VALUE='$row[0]' onclick='AjoutChoix(this);'></td>");
					echo "</tr>";
				} // for i < nombre de rangé
				echo "</tbody>
		</table>
   <hr size='5' color='#7CDFDF'>
	<p align='center'>
	<input type='button' name='Quitter' value='$TabMessGen[14]' onClick='QuitterPage()'>\n";
	if( @$_SESSION['Prio'] < $PrioLivreur ) {
		echo"<input type='button' onClick='ConfirmeDet(this);return;' ";
			switch( $_GET['Action'] ){
				case "1" : 	echo "name='Commande' value='$TabMessTrs[27]'>\n";
								break;
				case "2"	:	echo "name='Commande' value='$TabMessTrs[28]'>\n";
								break;
				case "3"	:  echo "name='Commande' value='$TabMessTrs[29]'>\n";
								break;
				case "4"	:  echo "name='Commande' value='$TabMessTrs[119]'>\n";
								break;
				case "5"	: 	echo "name='Commande' value='$TabMessTrs[120]'>\n";
								break;
				default	: 	echo "name='Commande' value='$TabMessGen[25]'>\n";
			} // switch action
	} // Si Priorité
	if( ( $_GET['Action'] == 1 ) || ( $_GET['Action'] == 2) || (@$_SESSION['Prio'] == 0) )
		echo("<input name='Tous' TYPE='button' VALUE='Tous/Aucun' onclick='ChoixTous(this);'>");
	echo "</form>";
}
else {
  echo "
      <html>
      <head>
       <title>$TabMessGen[127]</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
      <SCRIPT language=JavaScript1.2 src=\"javafich/mm_menu.js\"></SCRIPT>";
	switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :	echo "<SCRIPT language=JavaScript1.2 src='javafich/ldmenuen.js'></SCRIPT>";
								break;
		case "SPANISH" :	echo "<SCRIPT language=JavaScript1.2 src='javafich/ldmenusp.js'></SCRIPT>";
								break;
		default :			echo "<SCRIPT language=JavaScript1.2 src='javafich/ldmenufr.js'></SCRIPT>";
	}
	  echo "  
 	  <body bgcolor='#EEEEFF'>
	  <SCRIPT language=JavaScript1.2>mmLoadMenus();</SCRIPT>
	  <BASE TARGET=MAIN>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessGen[127] $Etat</h2>
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
<script language="javascript">
		
	function QuitterPage() {
		close();
	   open("mainfr.php","_self" );
	} 
	
	function ConfirmeDet() {
		var Formulaire = LaPage.form, i,j,Ok=1;
		j = Formulaire.length; 
		for (i=0; i < j; i++){
			if( Formulaire[i].type == 'checkbox' )
				Ok = 0;
		} // for
		if( Ok && window.confirm('Traiter la liste? Etes-vous sûre ?') )
	   	document.LstTrs.submit();
	} // ConfirmeDet

	
	function AjoutChoix( LaPage ) {
		var Formulaire = LaPage.form, i,j,Nb;
		j = Formulaire.length; 
		Nb = 0;
		for( i=0; i < j; i++ ){
			if( Formulaire[i].checked  )	Nb++;
		} // for
		Formulaire.NbChoix.value  = Nb;
	} // ChoixTous

	function ChoixTous( LaPage ) {
		var Formulaire = LaPage.form, i,j;
		j = Formulaire.length; 
		for (i=0; i < j; i++){
			if( Formulaire[i].type == 'checkbox' )
				Formulaire[i].checked = !Formulaire[i].checked;
		} // for
		AjoutChoix( LaPage );
	} // ChoixTous
	 
	addKeyEvent();
	
</script>
<script language='JavaScript1.2' src="javafich/blokclick.js"></script>

   </body>
</html>


