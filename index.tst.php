<?php

include('lib/config.php');

// ***** Intro ******************** 
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
	
//if( !isset( $_SESSION['infocompteur'] ) )
//	$_SESSION['infocompteur'] = @get_compteur();

echo "<?xml version='1.0' encoding='ISO-8859-1'?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'> 
<html  xmlns='http://www.w3.org/1999/xhtml'>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<META NAME='Author' CONTENT='Techno Concept N2N Inc.'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
	   	<link rel='stylesheet' href='styles/cosat.css' type='text/css' />
 		<link rel='shortcut icon' href='$entr_url/favicon.ico'>
<body>
<table cellpadding='0' cellspacing='0' border='0' width='1024px' align='center' bgcolor='#FFFFFF' >
<tr>
<td> 
 <div id='site'>
";
?>
<div id="Gauche">
  <div id="logo">
  	<img src='gifs/logo.gif' width="220" height="189" /><a href="suspect.php"><img src="gifs/blank.gif" width="1" height="1" border="0"></a>
  </div>
  <div id="nouschoisir">
  	<table border='0' cellpadding='4px' >
  		<tr>
  			<td align='right'>
  				<img id="fleche" src='gifs/fleche.gif' width="32" height="33" />
  			</td>
  			<td>
  				<h1>POURQUOI NOUS CHOISIR?</h1>
  			</td>
  		</tr>
 		<tr>
   			<td align='right'>
   				<span class="titleright">01</span>
  			</td>
  			<td>
  				<span class="hiTextRed">Un chef de file depuis 20 ans</span>
  			</td>
  		</tr>
 		<tr>
   			<td align='right'>&nbsp;
   				
  			</td>
  			<td>
  				<span >Cosat a commencé ses opérations en 1989. C'est en 2000 que le département 
				  informatique a été ajouté. Donc dans les Laurentides, cela fait 20 ans que Cosat vous offre un service de 
				  qualité.</span>
  			</td>
  		</tr>
  		<tr>
   			<td align='right'>
   				<span class="titleright">02</span>
  			</td>
  			<td>
  				<span class="hiTextRed">Une solide expertise</span>
  			</td>
  		</tr>
  		<tr>
   			<td align='right'>&nbsp;
   				
  			</td>
  			<td>
  				<span >Une expertise de plus de 22 ans dans le domaine de la vente, de la réparation et
				   de l'entretien des ordinateurs personnels</span>
  			</td>
  		</tr>
 	</table>
  </div>
  <div id="notremarque">
  	<table border='0' cellpadding='4px' >
  		<tr>
  			<td align='right'>
  				<img id="fleche" src='gifs/fleche.gif' width="32" height="33" />
  			</td>
  			<td>
  				<h1>NOTRE MARQUE</h1>
  			</td>
  		</tr>
 		<tr>
   			<td align='right'>&nbsp;
   				
  			</td>
  			<td>
  				<span >Nous assemblons nos ordinateurs sur place selon <b>vos spécifications</b>. Nous vous offrons un produit sur mesure rien
				  de moins. Notre méthode vous assure un produit adéquat qui répond à <b>VOS besoins</b>.</span>
  			</td>
  		</tr>
  		<tr>
   			<td align='right'>
   				<img src='gifs/ptfleche.gif' width="22" height="17" />
  			</td>
  			<td>
  				<span class="hiTextGreen">La marque Cosat</span>
  			</td>
  		</tr>
 	</table>
  </div>
</div>
<!-- header //-->
 <div id="topmenu">
	<a href="index.php">Accueil</a>
	<a href="produits.php">Produits</a>
	<a href="services.php">Services</a>
	<a href="support.php">Support</a>
	<a href="contacteznous.php">Nous contactez</a>
 </div>
<!-- header_eof //-->
<?php $LargeAchat = '100%';?>
<div id="contenu">
  <?php include('message.inc'); ?>
  <div class="cadre">
	<table bgcolor='#FFFFFF' width='100%' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
		<td>
		<table width='<?=$LargeAchat?>' height=23 cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
			<tr>
				<td valign='left' width='17' id='flash_t_g' background='images/tit_accueil_bg_top_g.jpg'>
					&nbsp;
				</td>
				<td  colspan=3 valign=middle width='97%' id='flash_t_c' background='images/tit_accueil_bg_c.jpg'>
					<span id='topmsg' style='visibility:hidden'><center><b><font color=ffffff size=2><?=$txt['Speciaux']?></font></b></center></span>
				</td>
				<td valign='right' width='20' id='flash_t_d' background='images/tit_accueil_bg_top_d.jpg'>
					&nbsp;
				</td>
			</tr>
		</table>
		</td>
		</tr>
		<tr>
		<td>
		<table width='100%' align='left' bgcolor='#FFFFFF' cellpadding='2' border='0' >
			<tr>
				<td align='left' width='17'>
					&nbsp;
				</td>


			<td colspan='2' >
				&nbsp;
			</td>
			<td align='left' width='17'>
				&nbsp;
			</td>
		</tr>
	</table>
		</td>
		</tr>
		<tr>
		<td>
	<table width='<?=$LargeAchat?>' height='23' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
			<td align='left' width='17' id='flash_b_g' background='images/tit_accueil_bg_bas_g.jpg'>
				&nbsp;
			</td>
			<td colspan='3' align='center' width='97%' id='flash_b_c' background='images/tit_accueil_bg_c.jpg'>
				&nbsp;
			</td>
			<td align='right' width='20' id='flash_b_d' background='images/tit_accueil_bg_bas_d.jpg'>
				&nbsp;
			</td>
		</tr>
	</table>

		</td>
		</tr>

	</table>
  </div>
  <div id="advert">
  		<table>
  			<tr>
  				<td width=30% >
  				<span class="produits_img">
				  <img src='images/atemps.jpg' width="116" height="109" align="left" />
				</span>
				</td>
				<td width=40%>

				<span class="GrosTexte"><center>LIVRAISON RAPIDE!!!</center></span>
		
   				<center>
   				Vous cherchez une pièce<br>
   		  		Si nous ne l'avons pas en stock,</center>
   				<span class="hiTextBlue"><center>Nous pouvons vous la procurer la plupart du temps en 24 heures</center></span>
   				</td>
   				<td width=30% >
  				<span class="produits_img">
				  <img src='images/livraison3.jpg' width="116" height="101" align="right" />
				</span>
				</td>
  			</tr>
   		</table>
  </div>
</div>
<!-- ***** footer ******************** //-->
<div id="siteInfo"> 
<table align='center' width='100%'>
	<tr>
	<td>
		<img src="gifs/icon_technet.gif" width="44" height="22" />
	</td>
	<td>
		<a href="index.php">Accueil</a>
	</td>
	<td>
		 |
	</td>
	<!-- td>
		<a href="#">Qui sommes-nous</a>
	</td>
	<td>
		 |
	</td -->
	<td>
		<a href="produits.php">Produits</a>
	</td>
	<td>
		 |
	</td>
	<td>
		<a href="services.php">Services</a>
	</td>
	<td>
		 |
	</td>
	<td>
		<a href="#">Support</a>
	</td>
	<td>
		 |
	</td>
	<td>
		<a href="contacteznous.php">Nous contactez</a>
	</td>
	<td>
		 |
	</td>
	<td>
		&copy; 2009  Cosat Informatique 
	</td>
	<td>
	</td>
	</tr>
</table>
</div>
<br />
<!-- footer_eof //-->

<script type='text/javascript'>

//enter your message in this part, including any html tags
var message='<center><b><font color=blue size=4><?=$txt['Speciaux']?></font></b></center>'

//enter a color name or hex value to be used as the background color of the message. Don't use hash # sign
var backgroundcolor=0x2f3283; //19556;

//enter 0 for always display, 1 for a set period, 2 for random display mode
var displaymode=0;

//if displaymode is set to display for a set period, enter the period below (1000=1 sec)
var displayduration=10000;

//enter 0 for non-flashing message, 1 for flashing
var flashmode=1
//if above is set to flashing, enter the flash-to color below
var flashtocolor=0xb8280f;

///////////////do not edit below this line////////////////////////////////////////

function regenerate(){
	window.location.reload()
}

var which=0

function regenerate2(){
	if (document.layers)
		setTimeout("window.onresize=regenerate",400)
}


function display2(){
	if (document.layers){
		if (topmsg.visibility=="show")
			topmsg.visibility="hide"
		else
			topmsg.visibility="show"
	}
	else if (document.all){
		if (topmsg.style.visibility=="visible")
			topmsg.style.visibility="hidden"
		else
			topmsg.style.visibility="visible"
		setTimeout("display2()",Math.round(Math.random()*10000)+10000)
	}
}

function flash(){
	if (which==0){
		if (document.layers)
			topmsg.bgColor=flashtocolor
		else {
			topmsg.style.backgroundColor=flashtocolor
			flash_t_g.background="images/tit_accueil_bg_top_gr.jpg"		
			flash_t_c.background="images/tit_accueil_bg_cr.jpg"		
			flash_t_d.background="images/tit_accueil_bg_top_dr.jpg"		
			flash_b_g.background="images/tit_accueil_bg_bas_gr.jpg"		
			flash_b_c.background="images/tit_accueil_bg_cr.jpg"		
			flash_b_d.background="images/tit_accueil_bg_bas_dr.jpg"		
		}
		which=1
	}
	else{
		if (document.layers)
			topmsg.bgColor=backgroundcolor
		else {
			topmsg.style.backgroundColor=backgroundcolor
			flash_t_g.background="images/tit_accueil_bg_top_g.jpg"		
			flash_t_c.background="images/tit_accueil_bg_c.jpg"		
			flash_t_d.background="images/tit_accueil_bg_top_d.jpg"		
			flash_b_g.background="images/tit_accueil_bg_bas_g.jpg"		
			flash_b_c.background="images/tit_accueil_bg_c.jpg"		
			flash_b_d.background="images/tit_accueil_bg_bas_d.jpg"		
		}
		which=0
	}
}


//if (document.all){
//	document.write('<span id="topmsg" style="position:absolute;visibility:hidden">'+message+'</span>')
//}


function logoit(){
//	document.all.topmsg.style.left=document.body.scrollLeft+document.body.clientWidth/2-document.all.topmsg.offsetWidth/2
//	document.all.topmsg.style.top=document.body.scrollTop+document.body.clientHeight-document.all.topmsg.offsetHeight-4
}


function logoit2(){
//	topmsg.left=pageXOffset+window.innerWidth/2-topmsg.document.width/2
//	topmsg.top=pageYOffset+window.innerHeight-topmsg.document.height-5
	setTimeout("logoit2()",90)
}

function setmessage(){
//	document.all.topmsg.style.left=document.body.scrollLeft+document.body.clientWidth/2-document.all.topmsg.offsetWidth/2
//	document.all.topmsg.style.top=document.body.scrollTop+document.body.clientHeight-document.all.topmsg.offsetHeight-4
	document.all.topmsg.style.backgroundColor=backgroundcolor
	document.all.topmsg.style.visibility="visible"
	if (displaymode==1)
		setTimeout("topmsg.style.visibility='hidden'",displayduration)
	else if (displaymode==2)
		display2()
	if (flashmode==1)
		setInterval("flash()",1000)
	window.onscroll=logoit
	window.onresize=new Function("window.location.reload()")
}


function setmessage2(){
	topmsg=new Layer(window.innerWidth)
	topmsg.bgColor=backgroundcolor
	regenerate2()
	topmsg.document.write(message)
	topmsg.document.close()
	logoit2()
	topmsg.visibility="show"
	if (displaymode==1)
		setTimeout("topmsg.visibility='hide'",displayduration)
	else if (displaymode==2)
		display2()
	if (flashmode==1)
		setInterval("flash()",1000)
}


if (document.layers)
	window.onload=setmessage2
else if (document.all)
	window.onload=setmessage



</script>
</div>
</td>
</tr>
</table>
</body>
</html>
