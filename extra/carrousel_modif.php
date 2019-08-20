<?php
include('connect.inc');

$page = $_SERVER["PHP_SELF"]; //VARIABLE PAGE = PAGE ACTUEL

ob_start();

echo "
	<html>
	<head>
		<title><?=$TabMessGen[69]?></title>
		<link title='hermesstyle' href='styles/stylegen.css' type='text/css rel=stylesheet'>
		<style>
			.scroll {
				height: 430px; /* Hauteur de 250 pixel */
				width:100%;  /* Largeur de 700 pixel */
				overflow: auto;
			}
		</style>
	</head>
	<script language='javascript1.2' src='js/mm_menu.js'></script>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	
	<script language='JavaScript1.2'>
	
		function changerImage1(tothis) 
			{
			  document.getElementById(\"pic\").style.visibility=\"visible\";
				document.images[\"photo\"].src='photoget.php?No='+tothis+'&Idx=1';
				document.getElementById(\"NoInv\").value =tothis;
				
	  	} 
	  	
	</script>";
	
		switch( $_SESSION['SLangue'] ) {
			case "ENGLISH" :	echo "<script language='javascript1.2' src='js/ldmenuen.js'></script>";
									break;
			case "FRENCH" :	echo "<script language='javascript1.2' src='js/ldmenufr.js'></script>";
									break;
			default :			echo "<script language='javascript1.2' src='js/ldmenusp.js'></script>";
		}
echo 
	"<body bgcolor='#D8D8FF'>
	<script language=JavaScript1.2>mmLoadMenus();</script>";
// DÉBUT DE LA FUNTION FIRST


// DÉBUT VALIDATION DES MODIFICATION
if (isset($_GET['modifier_ok']))
	{
		extract($_POST,EXTR_OVERWRITE);
		$sql = "UPDATE carrousel SET id ='$id', NoInv ='$NoInv',";
		$sql .= " NoPhoto ='$NoPhoto', Description ='$Description' WHERE id = '$id'";
		mysql_query($sql);
		echo '<center>Modification reussi !</center>';
		header("Refresh: 2; url=$page?first=1");
	}// FIN VALIDATION DES MODIFICATION

// DÉBUT AFFICHAGE ITEM À MODIFIER	
if (isset($_GET['modifier'])){
	extract($_GET,EXTR_OVERWRITE);	
	echo "
	<div align='center'><div class='scroll'>
		<form  method='POST' name='langu' action='carrousel_modif.php?modifier_ok=1' >
		<table border='1'>
		<tr>
			<td>".$TabMessGen['304']."</td>
			<td>NoInv</td>
			<td>".$TabMessGen['383']."</td>
			<td>".$TabMessGen['384']."</td>
			<td>".$TabMessGen['385']."</td>
		</tr>
		<tr>
			<td>
				<input type'text' name='id' readonly='true' value='$id' style=background-color:C0C0C0;>
			</td>
			<td>
				<input type'text' name='NoInv' value='$NoInv' STYLE='width:40'>
			</td>
			<td>";
		
		$title = "titre_".$_SESSION['langue'];
		$query = "SELECT id,$title FROM stock ORDER BY id";
		$requete = mysql_query($query);
		echo "
			<select size='1' name='Stk_description' onchange='changerImage1(this.value);' STYLE='width:330'>
				<option value='0' >NULL</option>";
		while ($row = mysql_fetch_array($requete)) {
				$ids = stripslashes($row['id']);
				$titre = stripslashes($row[$title]);
				echo "<option value='$ids' ";
				if( $ids == $NoInv ) 
					echo " SELECTED";
					echo " >$titre</option>";
		}
		
		
		echo "
			</td>
			<td>
				<input type'text' name='NoPhoto' value='$NoPhoto' STYLE='width:55'>
			</td>
			<td>
				<input type'text' name='Description' value='$Description'>
			</td>
		</tr>
		</table>
		<input type='submit' value='".$TabMessGen['364']."' name='B1'>
		<input type=button value='Back' name='back' onclick='window.location.href=\"$page\"'>
		</form><div id='pic' style='visibility:visible;'><img name='photo' src='photoget.php?No=$NoInv&Idx=$NoPhoto'></div></div></div>";
	}// FIN AFFICHAGE ITEM À MODIFIER

//DÉBUT APELLE LA FUNCTION POUR AFFICHER LA LISTE DES ITEMS.
if (isset($_GET['first'])) {
		$sql = "SELECT * FROM carrousel ORDER BY id";
		$req = mysql_query($sql);
		echo "<div align='center'><div class='scroll'>";
		echo "<form  method='POST' name='first' action=''>
		<table border='1'>";
		echo "<tr>
		<td>".$TabMessGen['304']."</td>
		<td>".$TabMessGen['383']."</td>
		<td>".$TabMessGen['384']."</td>
		<td>".$TabMessGen['385']."</td>
		<td>".$TabMessGen['364']."</td>
		</tr>";
		
		while ($telech = mysql_fetch_array($req)) 
			{
				$id = $telech['id'];
				$NoInv = $telech['NoInv'];
				$NoPhoto = $telech['NoPhoto'];
				$Description = $telech['Description'];
				echo "
				<tr>
				<td><input type'text' name='id' readonly='true' value='$id' style=background-color:C0C0C0;></td>
				<td><input type'text' name='NoInv' value='$NoInv' readonly='true' style=background-color:C0C0C0;></td>
				<td><input type'text' name='NoPhoto' value='$NoPhoto' readonly='true' style=background-color:C0C0C0;></td>
				<td><input type'text' name='Description' value='$Description' readonly='true' style=background-color:C0C0C0;></td>
				<td><a href='$page?modifier=ok&id=$id&NoInv=$NoInv&NoPhoto=$NoPhoto&Description=$Description'>".$TabMessGen['364']."</a></td></tr>
				";
			
			} 		
		echo "
		</table>
		</form>
		</div></div>";
}
//FIN APELLE LA FUNCTION POUR AFFICHER LA LISTE DES ITEMS.

// VÉFIER SI L'ADRESSE DE LA PAGE EST SANS REQUETE
if ($_SERVER["REQUEST_URI"] == $_SERVER["PHP_SELF"])
	header("Refresh: 0; url=$page?first=1");

ob_flush();
?>
</body>
</html>