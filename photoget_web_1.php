<?php
    /* Programme : PhotoGet.php
    * Description : Recherche d'une image rattaché à une oeuvre
    */
include('lib/config.php');

// Si la page est appeler directement - genre index par Google
// if( !preg_match( "/^cosat/", $_SERVER["HTTP_REFERER"] ) ) {
$pos = strpos( $_SERVER["HTTP_REFERER"], "cosat");

if( ($pos === false) && (!$_SESSION['MLeRobot']) ) {
	$name = 'gifs/lelogo.gif';
	$handle = fopen($name, "r", 1);
	$size = filesize ($name);
	$data = fread ($handle, $size );
	fclose ($handle);
	
	header("HTTP/1.1 200 OK");
	header("Status: 200 OK");
	Header("Pragma: Public");
	
	header("Content-type: image/jpeg; charset=windows-1252");
	header("Content-length: $size");
	header("Content-Disposition: inline; filename=$name"); 
	header("Content-Description: PHP Generated Data");
	include($name);
}
/*if( !isset($_SESSION['pascadre']) ) {
	$_SESSION['IdxPhoto'] = $_GET['Idx'];
	$script = "<script language='javascript'>";
	$script .= '	open("'.$entr_url.'/index.php?appel=produit_detail.php?id='.$_GET['No'].'","_top" );';
	$script .= "</script>";
	echo $script;
}*/

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("./extra/varcie.inc");
	$name = 'gifs/logo.gif';
	$handle = fopen($name, "r", 1);
	$size = filesize ($name);
	$data = fread ($handle, $size );
	fclose ($handle);
	
	header("HTTP/1.1 200 OK");
	header("Status: 200 OK");
	Header("Pragma: Public");
	
	header("Content-type: image/jpeg; charset=windows-1252");
	header("Content-length: $size");
	header("Content-Disposition: inline; filename=$name"); 
	header("Content-Description: PHP Generated Data");
	include($name);
   exit();
}
 //MetMessErreur(0,0,0);



if( !isset($_GET['Idx']) ) {
	if( isset($_SESSION['IdxPhoto']) ) {
		$_GET['Idx'] = $_SESSION['IdxPhoto'];
		unregister($IdxPhoto);
	}
	else
		MetMessErreur( 0,"Accès Photo impossible", 0 );
}


$sql = " SELECT * FROM $mysql_base.photo WHERE NoInvent='".$_GET['No']."' AND NoPhoto='".$_GET['Idx']."'";

$result = mysql_query( $sql, $handle );
if( $result == 0 ) { 
  	   MetMessErreur(mysql_error(),"Accès Photo impossible", mysql_errno());
} elseif (  mysql_num_rows($result) != 0 ) {

  $data = @mysql_result($result, 0, "Photo");
  $name = @mysql_result($result, 0, "FileName");
  $size = @mysql_result($result, 0, "FileSize");
  $type = @mysql_result($result, 0, "FileType");
	mysql_close($handle);
 	
 header("HTTP/1.1 200 OK");
  header("Status: 200 OK");
  Header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
  Header("Cache-Control: Public");
  Header("Pragma: Public");

  header("Content-Encoding: AnyTrash");
  header("Content-type: $type; charset=windows-1252");
  header("Content-length: $size");
  header("Content-Disposition: inline; filename=$name");
  header("Content-Description: PHP Generated Data");
  echo $data;
}
else {
//	mysql_close($handle);
	$name = './images/0_'.$_SESSION['langue'].'.jpg';
	$fhandle = fopen($name, "r", 1);
	$size = filesize ($name);
	$data = fread ($fhandle, $size );
	fclose ($fhandle);
	
	header("HTTP/1.1 200 OK");
	header("Status: 200 OK");

//	Header("Cache-Control: max-age=120, must-revalidate");
//	Header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
	Header("Pragma: Public");
	
	header("Content-type: image/jpeg; charset=windows-1252");
	header("Content-length: $size");
	header("Content-Disposition: inline; filename=$name"); 
	header("Content-Description: PHP Generated Data");
//	include($name);
	echo "No :".$_GET['No']."<br>";
	echo "Idx :".$_GET['Idx']."<br>";
	

}
?>
