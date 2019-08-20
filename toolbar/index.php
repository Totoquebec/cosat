<html>

<head>
<title>Barre outils Cosat</title>
<META NAME="description" CONTENT="Cette page permet à nos client de télécharger nôtre barre outils.">
<META NAME="keywords" CONTENT="toolbar, outils, barre outils, cosat, google, ordinateur, informatique">
<META NAME="dc.keywords" CONTENT="toolbar, outils, barre outils, cosat, google, ordinateur, informatique">
<META NAME="subject" CONTENT="Barre outils Cosat">
<META NAME="author" CONTENT="Jean-Alexandre Technicien Cosat">
<META NAME="copyright" CONTENT="© 2009 Cosat ">
<META NAME="revisit-after" CONTENT="30 days">
<META NAME="identifier-url" CONTENT="http://www.cosat.biz">
<META NAME="reply-to" CONTENT="webmaster@cosat.biz">
<META NAME="publisher" CON
TENT="Cosat">
<META NAME="date-creation-ddmmyyyy" CONTENT="091207">
<META NAME="Robots" CONTENT="all">
<META NAME="Rating" CONTENT="General">
<META http-equiv="VW96.OBJECT TYPE" CONTENT="Other (votre choix)">
<META NAME="Category" CONTENT="Other (votre choix)">
<META NAME="Page-topic" CONTENT="Other (votre choix)">
<META NAME="Generator" content="Dev-PHP 2.3.2">
<META NAME="organization" CONTENT="Cosat">
<META NAME="contact" CONTENT="cosat.info@cosat.biz">
<META NAME="contactName" CONTENT="Denis">
<META NAME="contactOrganization" CONTENT="Denis">
<META NAME="contactStreetAddress1" CONTENT="329c boul labelle, Saint-Jérôme">
<META NAME="contactZip" CONTENT=" ">
<META NAME="contactCity" CONTENT="Saint-Jérôme">
<META NAME="contactState" CONTENT="Canada">
<META NAME="Classification" CONTENT="informatique, Cellulaire, Ordinateur, Conception">
<META http-equiv="Content-Language" CONTENT="fr">
<META http-equiv="Content-type" CONTENT="text/html;charset=iso-8859-1">
<META NAME="location" CONTENT="France, FRANCE">
<META NAME="expires" CONTENT="never">
<META NAME="date-revision-ddmmyyyy" CONTENT="26022008">
<META NAME="Distribution" CONTENT="Global">
<META NAME="Audience" CONTENT="General">
<META http-equiv="Content-Script-Type" CONTENT="text/javascript">
<META http-equiv="Content-Style-Type" CONTENT="text/ccs">

</head>

<body>
	<p align="center">
		<img src="../images/logocosat.jpg" border='0' width='300' height='230' name="Logo Cosat" alt="Logo Cosat"/>
	</p>

<?php
$Langue = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
$Langue = strtolower(substr(chop($Langue[0]),0,2));
//echo $Langue;
		if ( $Langue = "fr" ) 
			{
				include ("progressbar.php");
				
				 //Initialize(x,y,largeur,hauteur,'couleur bordure','couleur du pourcentage','couleur de la barre de progression');
				 Initialize(333,52,200,30,'000000','FFCC00','006699'); // initialisation de la barre de progression
				 for ($i=0;$i<=100;$i++)
				 {
				 ProgressBar($i); // réaffichage de la barre avec le nouvel indice
				 //***********************
				 // ici on mets notre code
				 for ($j=0;$j<=100000;$j++) {$p=1;} // dans cette exemple, j'ai une boucle de retardement
				 //**************************
				 }
				
				if( preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"]) ) 
						echo "<CENTER>VOTRE NAVIGATEUR EST INTERNET EXPLORER<BR><a href=\"cosat_fr.exe\">TÉLÉCHARGER LA BARRE OUTILS POUR INTERNET EXPLORER</a><br></CENTER>";
				else if (preg_match("/^Mozilla/", $_SERVER["HTTP_USER_AGENT"])) 
					{
						echo "
						<script language=\"JavaScript\" type=\"text/javascript\">
						function install_tb_complete (name, result) {
						if (result != 0 && result != 999) alert(\"Une erreur c'est produite: \" + result);
						else alert (\"Redémarrer Firefox pour terminer l'installation\");
						}
						
						function Install_tb_XPI () {
						var xpi = new Object ();
						xpi[\"Bar_Outils_Cosat_\"] = \"cosat_fr.xpi\";
						InstallTrigger.install (xpi, install_tb_complete);
						}
						</script>
						<CENTER>VOTRE NAVIGATEUR EST MOZILLA FIREFOX<BR<a href=\"javascript:Install_tb_XPI();\">CLIQUER ICI POUR INSTALLER LA BARRE OUTILS COSAT POUR MOZILLA FIREFOX</a></CENTER>";
					} 
				
				else if (preg_match("/^Opera/", $_SERVER["HTTP_USER_AGENT"])) 
					echo "Opéra<br>";
				else 
				    echo "un navigateur qui m'est inconnu<br/>";
				
			}
		else if ( $Langue == "en" )
		  {
		  				include ("progressbar.php");
				
				 //Initialize(x,y,largeur,hauteur,'couleur bordure','couleur du pourcentage','couleur de la barre de progression');
				 Initialize(333,52,200,30,'000000','FFCC00','006699'); // initialisation de la barre de progression
				 for ($i=0;$i<=100;$i++)
				 {
				 ProgressBar($i); // réaffichage de la barre avec le nouvel indice
				 //***********************
				 // ici on mets notre code
				 for ($j=0;$j<=100000;$j++) {$p=1;} // dans cette exemple, j'ai une boucle de retardement
				 //**************************
				 }
				
				if (preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) 
						echo "<CENTER>YOUR NAVIGATOR IS INTERNET EXPLORER<BR><a href=\"cosat_en.exe\">TO DOWNLOAD THE BAR TOOLS FOR INTERNET EXPLORER</a><br></CENTER>";
				else if (preg_match("/^Mozilla/", $_SERVER["HTTP_USER_AGENT"])) 
					{
						echo "
						<script language=\"JavaScript\" type=\"text/javascript\">
						function install_tb_complete (name, result) {
						if (result != 0 && result != 999) alert(\"An error it is produced: \" + result);
						else alert (\"To start again Firefox to finish the installation\");
						}
						
						function Install_tb_XPI () {
						var xpi = new Object ();
						xpi[\"Bar_Outils_Cosat_\"] = \"cosat_en.xpi\";
						InstallTrigger.install (xpi, install_tb_complete);
						}
						</script>
						<CENTER>YOUR NAVIGATOR IS MOZILLA FIREFOX<BR<a href=\"javascript:Install_tb_XPI();\">TO CLICK HERE TO INSTALL THE BAR TOOLS COSAT FOR MOZILLA FIREFOX</a></CENTER>";
					} 
				
				else if (preg_match("/^Opera/", $_SERVER["HTTP_USER_AGENT"])) 
					echo "Opéra<br>";
				else 
				    echo "a navigator who is unknown for me<br/>";
		  }
		else
			{
								include ("progressbar.php");
				
				 //Initialize(x,y,largeur,hauteur,'couleur bordure','couleur du pourcentage','couleur de la barre de progression');
				 Initialize(333,52,200,30,'000000','FFCC00','006699'); // initialisation de la barre de progression
				 for ($i=0;$i<=100;$i++)
				 {
				 ProgressBar($i); // réaffichage de la barre avec le nouvel indice
				 //***********************
				 // ici on mets notre code
				 for ($j=0;$j<=100000;$j++) {$p=1;} // dans cette exemple, j'ai une boucle de retardement
				 //**************************
				 }
				
				if (preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) 
						echo "<CENTER>VOTRE NAVIGATEUR EST INTERNET EXPLORER<BR><a href=\"cosat_fr.exe\">TÉLÉCHARGER LA BARRE OUTILS POUR INTERNET EXPLORER</a><br></CENTER>";
				else if ( preg_match("/^Mozilla/", $_SERVER["HTTP_USER_AGENT"]) ) 
					{
						echo "
						<script language=\"JavaScript\" type=\"text/javascript\">
						function install_tb_complete (name, result) {
						if (result != 0 && result != 999) alert(\"Une erreur c'est produite: \" + result);
						else alert (\"Redémarrer Firefox pour terminer l'installation\");
						}
						
						function Install_tb_XPI () {
						var xpi = new Object ();
						xpi[\"Bar_Outils_Cosat_\"] = \"cosat_fr.xpi\";
						InstallTrigger.install (xpi, install_tb_complete);
						}
						</script>
						<CENTER>VOTRE NAVIGATEUR EST MOZILLA FIREFOX<BR<a href=\"javascript:Install_tb_XPI();\">CLIQUER ICI POUR INSTALLER LA BARRE OUTILS COSAT POUR MOZILLA FIREFOX</a></CENTER>";
					} 
				
				else if (preg_match("/^Opera/", $_SERVER["HTTP_USER_AGENT"])) 
					echo "Opéra<br>";
				else 
				    echo "un navigateur qui m'est inconnu<br/>";
			}
?>
</body>
   </html>      
