<?php
	/* Programme : MainFr.php
    * Description : Ecran d'ouverture du système de gestion
    */
include('../lib/config.php');

/*$NomJourFR = array(
		"0"=>"Dimanche",
		"1"=>"Lundi",
		"2"=>"Mardi",
		"3"=>"Mercredi",
		"4"=>"Jeudi",
		"5"=>"Vendredi",
		"6"=>"Samedi"
		); 
 
$NomJourSP = array(
		"0"=>"Domingo",
		"1"=>"Lunes",
		"2"=>"Martes",
		"3"=>"Miércoles",
		"4"=>"Jueves",
		"5"=>"Viernes",
		"6"=>"Sábado"
		);*/
		 
// **** Choix de la langue de travail ****
switch( $_SESSION['SLangue'] ) {
 	case "ENGLISH" :include("varmessen.inc");
			$LaDate = date(" l \\t\h\e dS of F Y");
			break;
	default : 	include("varmessfr.inc");
			$Jour = date("w");
			$LaDate = $NomJourFR[$Jour].date(" \l\\e Y-m-d");
			//H:i:s T O");

} // switch SLangue

?>
<html>
<head>
<title>Page Logo <?php echo $NomPGM ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=charset=utf-8"/>
</head>
<!--script language='javascript1.2' src='javafich/disablekeys.js'></script>
<script language='javascript1.2' src='javafich/blokclick.js'></script>
<script language='JavaScript1.2'>addKeyEvent();</script-->
<script language='javascript1.2' src="js/mm_menu.js"></script>
<?php
switch( $_SESSION['SLangue'] ) {
		case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
				break;
		default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
}
?>
<body bgcolor="#9a8bb4">
<script language='JavaScript1.2'>mmLoadMenus();</script>
<base target='MAIN'>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td align="center" valign="top">
		<p align="center">
      		<img src="gifs/logohermes.gif" alt="e-Extra"/><br>
		<img src="gifs/ordi.gif" alt="Ordi" width="25%" height="30%"/></p>
		<p align="center" ><?php echo $LaDate ?><br>
	      <a href="pagegestion.php?langue=fr" target='_top' >Français</a> | 
			<a href="pagegestion.php?langue=en" target='_top' >English</a>
		<div id='Clock' align='center' style="font-family: Verdana; font-size: 20; color:#0000FF">
		<font size="+1"><b><?php echo $_SESSION['NomLogin'] ?></font>&nbsp;&nbsp;&nbsp;</div></p>
  		 <p align="center"><font size="1">
  		 <?php echo sprintf($txt['Copyright'], $param['CopyAn'], $param['nom_client'], $param['CopyAn'] ); ?>.<br>
	</td>
  </tr>
</table>
<?php
          if( isset($_GET['Mess']) ) {
	    	echo "<script language='javascript1.2'>

				window.alert(".$_GET['Mess']."); 
			</script>";
          };
?>
</body>
</html>
