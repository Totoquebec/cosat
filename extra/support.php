<?php
/* Fichier : Support.php
 * Description : 	Page de support du logiciel qui permet la création l'indexation
 *						La modification des variables du logiciel.
 * Auteur : Denis Léveillé 	 		  Date : 2006-09-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-06
 */



/*include("vartb.inc");
include("varcie.inc");
session_start();*/
include('connect.inc');

// Connection au serveur MySQL
$Connection = mysql_connect( $mysql_host, $mysql_user, $mysql_pass )
	or die( "Connection impossible au serveur");

// Es-ce que la base de données existe
$db = mysql_select_db( $database, $Connection );

 $exist_db = ($db != 0);
 if( $exist_db ) {
//	session_start();
	if( @$_SESSION['auth'] != "yes") {
		die( "Pas autorisé");
   		header( "Location: login.php");
   		exit();
	}
	if( @$_SESSION['Prio'] > 2 ){
		die( "pas de priorité");
   		header( "Location: mainfr.php");
   		exit();
	}
}
else { 
	session_start();
	session_register('auth');
	session_register('NomLogin');
	session_register('exist_db');
	$_SESSION['auth']="yes";
}

?>
<html>
<head>
	<title>Page de support</title>
	<script language='javascript1.2' src='js/mm_menu.js'></script>
	<?php
	switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
				break;
		case "SPANISH" :echo "<script language='JavaScript1.2' src='js/ldmenusp.js'></script>\n";
				break;
		default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
	}
	?>
</head>
<body bgcolor="#6666FF" t>
<script language='JavaScript1.2'>mmLoadMenus();</script>
<base target="MAIN">
<h2 bgcolor="#28CACA" align="center" style="margin-top: 5">PAGE DE SUPPORT</h2>
<p align="center">
Vous êtes dans la page de support du logiciel <?php echo $NomPGM ?>.<br>
Vous pouvez ici faire l'entretien de vos tables MySQL.<br>
<div align="center">
<?php 
	  if( !$exist_db ) { 
	  	  echo "<form action='creation.php' method='post'>
		  	   <input type='submit' value='Création des tables'>
		  	   </form>";
	  }
?>
<p align='center'>
<form action="mainfr.php" method="post">
	<input type="button" value="Ajout d'un usager" onClick='AjoutUnUsager()'>
	<input type="button" value="Liste des usagers" onClick='ConsulteUsagers()'>
	<br><br>
	<input type="button" value="Ajout d'un lien" onClick='AjoutUnLien()'>
	<input type="button" value="Liste des liens" onClick='ConsulteLiens()'>
	<br><br>
	<input type="button" value="Consultation des contacts" onClick='ConsulteContact()'>
	<br><br>
	<input type="button" value="Liste des monnaies" onClick='ConsulteMonnaie()'>
	<input type="button" value="Liste taux change" onClick='ConsulteDevise()'>
	<br><br>
	<input type="button" value="Consultation des Accès" onClick='ConsulteLogin()'>
	<!-- input type="button" value="Chargement Table" onClick='LoadTable()'>
	<br -->
<?php 
	if( @$_SESSION['Prio'] < $PrioMaitre ) {
	  echo "<input type='button' value='Usager en Ligne' onClick='LstUser()'><br>";
	}
?>
</form>
</p>
<form action="mainfr.php" method="post">
	<input type="submit" value="Quitter">
</form>
Vos tables sont présentement :
<?php
if( $exist_db ) 
	echo "<b>EXISTANTE</b><br>";
else
	echo "<b>INEXISTANTE</b><br>";
?>
</div>
<br>
<div align="center"><font size="-1">
Nous apprécierions vos commentaires et suggestions. Vous pouvez les adresser
à <a href="<?php echo $AdrCourriel ?>?subject=Page Web Nomcie">Webmestre</a>
</font></div>
<p align="center" valign="bottom"><font size="1"><br>
<br>
Les droits de reproduction de ce site © <?php echo $CopyAn," ",$NomCie ?><br>
Tous droits réservés. © <?php echo $CopyAn ?>
 
<script language="javascript">

function LoadTable() {
	open("chargedonnees.php","_blank",
    "left=10,top=10,height=325,width=600,status=no,toolbar=yes,scrollbars=yes,menubar=yes,location=no,resizable=yes" );
}

function AjoutUnUsager() {
	open("msajout.php","_blank",
    "left=10,top=10,height=325,width=390,status=no,toolbar=no,menubar=no,location=no,resizable=no" );
}

function ConsulteUsagers() {
	open("mslstusg.php","_blank",
	"left=10,top=10,height=325,width=660,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}

function AjoutUnLien() {
	open("lienajout.php","_blank",
    "left=10,top=10,height=300,width=600,status=no,toolbar=no,menubar=no,location=no,resizable=no" );
}

function ConsulteLiens() {
	open("lienlst.php","_blank",
	"left=10,top=10,height=400,width=800,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}

function ConsulteMonnaie() {
	open("call_function.php?call=monnaielst.php","_blank",
	"left=10,top=10,height=250,width=750,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}

function ConsulteDevise() {
	open("call_function.php?call=monnaielsttx.php","_blank",
	"left=10,top=10,height=400,width=500,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}


function ConsulteLogin() {
	open("loginlst.php","_blank",
	"left=10,top=10,height=400,width=450,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}

function ConsulteContact() {
	open("contact.php","_blank",
	"left=10,top=10,height=400,width=640,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}

function LstUser() {
	open("sessionlst.php","_blank",
	"left=10,top=10,height=400,width=500,status=no,toolbar=no,scrollbars=yes,menubar=no,location=no,resizable=no" );
}



// *********************************************************************
// ***** METTRE HORS FONCTION LE CLIC DE DROITE  ***********************
// *********************************************************************
      var message='Désolé, fonction désactivé !!!';
      function clickIE()
      {
       if (document.all) 
           return false;
      }

      function clickNS(e) 
	  {
       if( document.layers || ( document.getElementById && !document.all ) ) {
               if( e.which == 2 || e.which==3 ) 
                       return false;
       }
      } // clickNS

      if (document.layers){
         	   document.captureEvents(Event.MOUSEDOWN);
               document.onmousedown=clickNS;
      }
      else{
               document.onmouseup=clickNS;
               document.oncontextmenu=clickIE;
      }
	  
      document.oncontextmenu=new Function('alert(message);return false')

      function disableselect(e)
	  {
       return false
      } // disableselect

      function reEnable()
      {
       return true
       } // reEnable

       document.onselectstart=new Function ('return false')

       if (window.sidebar){
              document.onmousedown=disableselect
              document.onclick=reEnable
       }


</SCRIPT>
</body>
</html>

