<?php

InfoBannie( $ip );
InfoAcces( $ip );

/*
 //echo @$_SERVER['REMOTE_HOST']."<br>"; 
Couleur Orangé Cosat ( du menu ) : FF8000
Couleur Orangé foncé Cosat ( Hi Red ) : df0224
Couleur Bleu Cosat ( link ) : 006699
Couleur Bleu foncé Cosat ( texte ) : 00162F
Couleur Bleu mauve Cosat ( hover top menu ) : 2f3283  = #2b3078
Couleur Bleu pale Cosat ( texte ) : 1D5376;
Couleur Gris bleu Cosat ( Titre H1 ) : 334d55
Couleur Gris Foncé ( Titre h4 ) : 333333
Couleur gris Pale ( background ) : cccccc
Couleur gris tres Pale ( nous choisir ) : dddddd
Couleur gris tres Pale ( notre marque ) : eeeeee
Couleur gris tres Pale ( Produit ) : ebebeb
*/
/*	foreach($_POST as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}
	foreach($_GET as $clé => $valeur ) {
		echo $clé." = ".$valeur."<br>";
	}*/
//	exit();

if( isset($_REQUEST['langue']) && $_REQUEST['langue'] != "" ) {
	switch( $_REQUEST['langue'] ) {
		case "English":	$_SESSION['langue'] = "en";
				break;	
		case "Espanõl":	$_SESSION['langue'] = "sp";
				break;	
		case "Français":		
		default:	$_SESSION['langue'] = "fr";
				break;	
	} // switch
		// **** Choix de la langue de travail ****
	switch( $_SESSION['langue'] ) {
		case "en" : 	$_SESSION['SLangue'] = "ENGLISH";
				break;
		case "sp" : 	$_SESSION['SLangue'] = "SPANISH";
				break;
		case "fr" : 	
		default : 	$_SESSION['SLangue'] = "FRENCH";
	
	} // switch SLangue
  
	$txt = textes($_SESSION['langue']);
} // Si langue change

if( isset( $_POST['devise']) ) 
	$_SESSION['devise'] = CleanUp($_POST['devise']);

if( !isset( $_SESSION['devise'] ) )
	$_SESSION['devise'] = "CAD";
	
if( !isset( $_SESSION['infocompteur'] ) )
	$_SESSION['infocompteur'] = get_compteur();

/*header("HTTP/1.1 200 OK");
header("Status: 200 OK");
Header("Cache-Control: max-age=120, must-revalidate");
Header("Expires: " . date("D, j M Y H:i:s", time() + (60 * 24)) . " UTC");
Header("Pragma: Public");
 		<meta name='google-site-verification' content='Oh5M1oHp288tkdo4IkX9TCnn_cKXO2umnvQ9X7zHPbs' /> 
<script type='text/javascript' src='js/snowstorm.js?m=1322079653g&#038;ver=1322079653'></script>

*/
echo "<?xml version='1.0' encoding='charset=utf-8'?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html  xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title>".$txt['TitreWeb']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=charset=utf-8'>
		<META NAME='Author' CONTENT='Denis Léveillé'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<meta name='phrases' content='".$txt['MetaPhrases']."'>
	   	<link rel='stylesheet' href='styles/cosat.css' type='text/css' />   
		<link rel='shortcut icon' href='$entr_url/favicon.ico'>
		<link rel='apple-touch-icon' href='/apple-touch-icon.png' />
		<link rel='apple-touch-icon' sizes='57x57' href='/apple-touch-icon-57x57.png' />
		<link rel='apple-touch-icon' sizes='60x60' href='/apple-touch-icon-60x60.png' />
		<link rel='apple-touch-icon' sizes='72x72' href='/apple-touch-icon-72x72.png' />
		<link rel='apple-touch-icon' sizes='76x76' href='/apple-touch-icon-76x76.png' />
		<link rel='apple-touch-icon' sizes='114x114' href='/apple-touch-icon-114x114.png' />
		<link rel='apple-touch-icon' sizes='120x120' href='/apple-touch-icon-120x120.png' />
		<link rel='apple-touch-icon' sizes='144x144' href='/apple-touch-icon-144x144.png' />
		<link rel='apple-touch-icon' sizes='152x152' href='/apple-touch-icon-152x152.png' /> 		
		 <link rel='apple-touch-icon-precomposed' href='/apple-touch-icon-precomposed.png'>";

if( $_SESSION['local'] == 0 ) { 
echo "
<script type='text/javascript'>

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-10905154-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>\n";
} //  Si Session
?>

<script type='text/javascript'>

function restore() { 
	document.body.removeChild(document.getElementById('overlay')); 
}

function pageonload() {   
	// create overlay and append to page   
var overlay = document.createElement('div');
   	//window.alert('Yahoo !!!');
	overlay.setAttribute('id','overlay');   
	overlay.setAttribute('class', 'overlay');  
	overlay.innerHTML = '<div align=center><h1>Salutations !</h1><br><h1>Veuillez prendre note qu\'à partir du<br></h1></div>';
	overlay.innerHTML += '<div align=center><h1>1<sup>ier</sup> octobre 2013 notre nouvelle adresse est le :<br></h1></div>';
	overlay.innerHTML += '<br><div align=center><h1><u>545 rue Labelle,<br>St-Jérôme, Qc. J7Z 5L8<br>(450)530-3353 </h1></div>'; 
	overlay.innerHTML += '<br><div align=center><h2>www.cosat.biz</h1></div>'; 
//	overlay.onclick=restore;   
	document.body.appendChild(overlay);   
/*var img = document.createElement("img");   
	img.setAttribute("id","img");   
	img.setAttribute("class","overlayimg"); 
	img.src = 'gifs/fermer.png'; 
	img.setAttribute("width","40px");   
	img.setAttribute("height","40px");   
	// click to restore page   
	img.onclick=restore;   
// window.alert('A voir '+overlay.id);
	overlay.appendChild(img);*/

} // pageonload

</script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

</script>
<!-- script type='text/javascript' src='js/snowstorm.js?m=1322079653g&#038;ver=1322079653'></script -->

<table cellpadding='0' cellspacing='0' border='0' width="<?=$param['largeur_affichage']?>" align='center' bgcolor='#FFFFFF' >
<tr>
<td> 
 <div id='site'>