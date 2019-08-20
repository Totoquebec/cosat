<?php

// overflow: scroll

//	filter: alpha(opacity=70);
//	-moz-opacity:.70;
//	opacity:.70;
/*
text-shadow 

Voila par exemple des ensembles de fontes : 

Times New Roman, Times, serif. 
Arial, Helvetica, sans-serif. 
Courier New, Courier, mono. 
Alpha Geometrique, Critter, Cottonwood, fantasy. 
Courier, MS Courier New, Prestige, monospace.
 
Voila les types de police générique : 

- serif, 
- sans-serif, 
- cursive, 
- fantasy, 
- monospace.

Propriété css first-letter
Le sélecteur de feuille de style css first-letter permet de spécifier des propriétés de feuille de style css 
pour la première lettre d'un élément de type bloc.
<STYLE> identifiant:first-letter{  Propriétés  } </STYLE> 

Propriété css first-line
Le sélecteur de feuille de style css first-line permet de spécifier la feuille de style 
de la première ligne d'un bloc.
<STYLE> identifiant:first-line{  Propriétés  } </STYLE> 

Astuce : arrêter l'effet float et rétablir le fluxDans le cas où vous avez besoin d'arrêter l'effet de float 
mettez un clear:both; dans une balise invisible ou visible selon vos besoins. 
Sous Firefox, la balise doit être de type "block" (display:block;). 

Définition de focus
Le speudo-élément de feuille de style css :focus permet de spécifier toutes les propriétés liées à la fonte, 
et à la décoration de texte (gras, souligné, ...), bordures, arrière plan, ... d'un élément HTML ou XHTML 
lorsque ce dernier est sélectionné via la touche de tabulation ou pour certains cas lorsque l'on clique dessus.

=========================================================================================================
Pour résumer à propos des différents positionnements : Les différents positionnements sont : 

soit “position: relative”
soit “position: absolute” (ou “fixed” qui ne fonctionne pas sur IE)
soit “float”
soit aucune position précise et des marges pour placer l’objet 
Chaque positionnement est différent des autres, on ne peut cumuler deux positionnements pour le même objet
===========================================================================================================
overflow:hidden 
This is to prevent issues with MSIE, as well as with modern browsers in case an element in a container is/gets "too large" or that container shrinks too much. With modern browsers, the element would stick outside of the container, with MSIE, it could force a "drop" of the container. 
display:inline-block 
This is to prevent a MSIE painting bug. It is to make sure background colors are not painted outside of elements. 
==============================================================================================================
*/

$Tab_CSS_Couleur = array(
		"0"=>"aqua",
		"1"=>"black",
		"2"=>"blue",
		"3"=>"fuchsia",
		"4"=>"gray",
		"5"=>"green",
		"6"=>"lime",
		"7"=>"maroon",
		"8"=>"navy",
		"9"=>"olive",
		"10"=>"purple",
		"11"=>"red",
		"12"=>"silver",
		"13"=>"teal",
		"14"=>"white",
		"15"=>"yellow"
		);
		
$Tab_CSS_Repeat = array(
		"0"=>"repeat",
		"1"=>"repeat-x",
		"2"=>"repeat-y",
		"3"=>"no-repeat"
		);
		
$Tab_CSS_Style = array(
		"0"=>"normal",
		"1"=>"italic",
		"2"=>"oblique"
		);

$Tab_CSS_Variant = array(
		"0"=>"normal",
		"1"=>"small-caps"
		);

$Tab_CSS_Weight = array(
		"0"=>"normal",
		"1"=>"bold",
		"2"=>"bolder",
		"3"=>"lighter",
		"4"=>"100",
		"5"=>"200",
		"6"=>"300",
		"7"=>"400",
		"8"=>"500",
		"9"=>"600",
		"10"=>"700",
		"11"=>"800",
		"12"=>"900"
		);

$Tab_CSS_Attachment = array(
		"0"=>"scroll",
		"1"=>"fixed"
		);

$Tab_CSS_DIVPosition = array(
		'0'=>'none',
		'1'=>'absolute',
		'2'=>'fixed'
		);
		
$Tab_CSS_DIVFloat = array(
		'0'=>'none',
		'1'=>'left',
		'2'=>'right'
		);
$Tab_CSS_DIVTexteAlign = array(
		'0'=>'none',
		'1'=>'left',
		'2'=>'right',
		'3'=>'center',
		'4'=>'justify'
		);
		
$Tab_CSS_DIVTextDecoration = array(
		'0'=>'none',
		'1'=>'underline',
		'2'=>'overline',
		'3'=>'line-through',
		'4'=>'blink'
		);
		
$Tab_CSS_DIVTextTransformation = array(
		'0'=>'none',
		'1'=>'capitalize',
		'2'=>'uppercase',
		'3'=>'lowercase'
		);

		
function loadUnImage( $Nom_Page, $Nom_Objet )
{
global $mabd, $database;
$sql = "  SELECT * FROM $database.webobjet WHERE Page='$Nom_Page' AND Titre ='$Nom_Objet' ";
		 
$result = $mabd->query($sql);
	
if( $result ) {

  $data = @mysql_result($result, 0, "limage");
  $name = @mysql_result($result, 0, "FFileName");
  $size = @mysql_result($result, 0, "FFileSize");
  $type = @mysql_result($result, 0, "FFileType");
 	
  header("HTTP/1.1 200 OK");
  header("Status: 200 OK");
  Header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
  Header("Cache-Control: Public");
  Header("Pragma: Public");

  header("Content-Encoding: AnyTrash");
  header("Content-type: $type; charset=windows-1252");
  header("Content-length: $size");
  header("Content-Disposition: inline; filename=$name"); // inline; filename=$name");attachment
  header("Content-Description: PHP Generated Data");
  echo $data;
}

} // loadImage
		


function loadBodyPage( $NomPage, $En_Modif = 0 ) 
{
global $mabd, $database;

	$NomPage = basename($NomPage);
	$sql = " SELECT * FROM $database.webpage WHERE Page='$NomPage'";
	$result = $mabd->query($sql);
	
	if( $result && $result->num_rows ) {
		$body = $result->fetch_assoc();
		extract($body);
		if( $En_Modif ) {
			$border = 'thin black';
		    	$background_image = '../'.$background_image;
		}
		if( strlen($FFileName) ) {
//			$target = dirname(__FILE__)."/fond/bk_grnd.jpg";
			$target = "./fond/bk_grnd.jpg";
			$f_handle = fopen( $target, "w", 1);
	
			if( fwrite($f_handle, $Fond) === FALSE ) {
	  	   		MetMessErreur1();
			}    
			fclose ($f_handle);
		} // Si FFileName
		else
			$target = $background_image;
		echo "/* zeroes */
				body {\n"; 
		if( strlen($border) ) 	
			echo "				border: $border;\n";  // thin solid black;\n
		if( strlen($font_family) ) 	
			echo "				font-family: $font_family;\n";
		if( strlen($font_size) ) 	
				echo "				font-size: $font_size;\n";
		if( strlen($font_weight) ) 	
				echo "				font-weight: $font_weight;\n";
		if( strlen($font_style) ) 	
				echo "				font-style: $font_style;\n";
//		echo "	font-variant: normal;\n";
		if( strlen($text_decoration) ) 	
				echo "				text-decoration : $text_decoration;\n";
		if( strlen($text_transform) ) 	
				echo "				text-transform : $text_transform;\n";
		if( strlen($text_align) ) 	
				echo "				text-align: $text_align;\n";
		if( strlen($line_height) ) 	
				echo "				line-height  : $line_height;\n";
			if( strlen($position) ) 
				echo "				position: $position;\n";
			if( $opacity > 0 ) {
					echo "
					 filter: alpha(opacity=$opacity);
					 -moz-opacity:.$opacity;
					 opacity:.$opacity;\n";
			}
			if( strlen($background_image) ) 	
				echo "				background-image  : url('$background_image');\n";
			if( strlen($background_position) ) 	
				echo "				background-position  : $background_position;\n";
			if( strlen($background_repeat) ) 	
				echo "				background-repeat  : $background_repeat;\n";
			if( strlen($background_attachment) ) 	
				echo "				background-attachment  : $background_attachment;\n";
			if( strlen($background_size) ) 	
				echo "				background-size  : $background_size;\n";
			if( strlen($background_color) ) 	
				echo "				background-color  : $background_color;\n";
			echo "		
					/*overflow:hidden;	 safari and opera need this */
					/*Display:inherit;	 safari and opera need this inline-block;*/\n";
			if( strlen($margin) ) 	
				echo "				margin: $margin;\n";
			if( strlen($padding) ) 	
				echo "				padding: $padding;\n";
			if( strlen($Autre) ) 	
				echo "				$Autre;\n";
			echo "}\n";
	}
	else
		echo "\nCSS Body de la Page INTROUVABLE ".$NomPage."\n";

} // loadBodyPage

function loadCSSObjetPage( $NomPage, $En_Modif = 0 )
{
global $mabd, $database;

$NomPage = basename($NomPage);
$sql = " SELECT * FROM $database.webobjet WHERE Page='$NomPage' ORDER BY Niveau ASC";
$result = $mabd->query($sql);

if( $result && $result->num_rows ) {
	echo "/* ============================ $NomPage =====================================*/\n";
	for( $i=1; $i <=$result->num_rows; $i++ ) {
		$objet = $result->fetch_assoc();
    		extract($objet);
    		if( $En_Modif ) {
		    $border = 'solid 2px black';
		    $background_image = '../'.$background_image;
		}
/*		if( strlen($FFileName) ) {
			$target = "./fond/bk_grnd.jpg";
			$f_handle = fopen( $target, "w", 1);
	
			if( fwrite($f_handle, $Fond) === FALSE ) {
	  	   		MetMessErreur1();
			}    
			fclose ($f_handle);
		} // Si FFileName
		else
			$target = $background_image;*/
		switch( $CType ) {
			case 'HTML'	: echo "$Titre";
					  break;
			case 'ID'	: echo "#$Titre";
					  break;
			case 'CLASS'	: echo ".$Titre";
					  break;
			case 'DIV CLASS': echo "div.$Titre";
					  break;
			default		: echo "div#$Titre";
		}
		echo "	{\n";
		if( strlen($position) ) 
				echo "				position: $position;\n";
		if( strlen($left) ) 
				echo "				left: $left;\n";
		if( strlen($top) ) 
				echo "				top: $top;\n";
		if( strlen($right) ) 
				echo "				right: $right;\n";
		if( strlen($bottom) ) 
				echo "				bottom: $bottom;\n";
		if( strlen($CSSFloat) ) 	
				echo "				float: $CSSFloat;\n";
		if( strlen($Clear) ) 	
				echo "				clear: $Clear;\n";
		if( strlen($width) ) 	
				echo "				width: $width;\n";
		if( strlen($height) ) 	
				echo "				height: $height;\n";
		if( strlen($margin) ) 	
				echo "				margin: $margin;\n";
		if( strlen($padding) ) 	
				echo "				padding: $padding;\n";
		if( strlen($border_radius) )
				echo "				border-radius: $border_radius;
				 -moz-border-radius: $border_radius;
				 -webkit-border-radius: $border_radius;\n";
		if( strlen($border) )
				echo "				border: $border;\n"; //$border;\n";  thin solid black;\n
		if( strlen($color) ) 
				echo "				color: $color;\n";
		if( $opacity  > 0 ) {
				echo "				filter: alpha(opacity=$opacity);
				 -moz-opacity:.$opacity;
				 opacity:.$opacity;\n";
		}
		if( strlen($font_family) ) 	
		echo "				font-family: $font_family;\n";
		if( strlen($font_size) ) 	
				echo "				font-size: $font_size;\n";
		if( strlen($font_weight) ) 	
				echo "				font-weight: $font_weight;\n";
		if( strlen($font_style) ) 	
				echo "				font-style: $font_style;\n";
//		echo "	font-variant: normal;\n";
		if( strlen($text_decoration) ) 	
				echo "				text-decoration : $text_decoration;\n";
		if( strlen($text_transform) ) 	
				echo "				text-transform : $text_transform;\n";
		if( strlen($text_align) ) 	
				echo "				text-align: $text_align;\n";
		if( strlen($line_height) ) 	
				echo "				line-height  : $line_height;\n";
		if( strlen($background_image) ) 	
				echo "				background-image  : url('$background_image');\n";
		if( strlen($background_position) ) 	
				echo "				background-position  : $background_position;\n";
		if( strlen($background_repeat) ) 	
				echo "				background-repeat  : $background_repeat;\n";
		if( strlen($background_attachment) ) 	
				echo "				background-attachment  : $background_attachment;\n";
		if( strlen($background_size) ) 	
				echo "				background-size  : $background_size;\n";
		if( strlen($background_color) ) 	
				echo "				background-color  : $background_color;\n";

		echo "				overflow:hidden;	/* safari and opera need this */\n";
//		if( strlen($align) ) 
//				echo "				align: $align;\n";

		if( $zindex > 0 )
				echo "				z-index: $zindex;\n";
		if( strlen($Display) )
			echo "				display: $Display;\n";
		if( $visibility == 'oui' )
				echo "				visibility : visible;\n";		
				
		if( strlen($Autre) ) 	
			echo "				$Autre;\n";
		 echo "			}\n";
				// border: dotted solid magenta; 
	// behavior:url(#default#time2);
	}
}
else
	echo "\nCSS DIV de la Page INTROUVABLE ".$NomPage."\n";
			
} // loadCSSBodyPage

function loadObjetPage( $Nom_Page, $En_Modif = 0  )
{
global $mabd, $database, $txt, $param;

$Nom_Page = basename($Nom_Page);
$sql = " SELECT * FROM $database.webobjet WHERE Page='$Nom_Page' ORDER BY Niveau ASC";
$result = $mabd->query($sql);
$Niveau_prec = 0;

if( $result && $result->num_rows ) {
	$i=0;
	do {
		$objet = $result->fetch_assoc();
    	extract( $objet );
    	if( $i && ($Niveau == $Niveau_prec) ) 
    		echo "</div>\n";
		if( $En_Modif ) { 
			echo "</a>\n<a href='pagedivmodif.php?nom_page=$Nom_Page&nom_objet=$Titre' target='_self'>\n";
			$FFileName = '../'.$FFileName;
		}
//		if( $En_Modif ) echo "</a><a onClick='Modifierdiv()'>";
		echo "<div id='$Titre'>\n";
		switch( $type_objet ) {
			case 'emane'		:	echo "<font size='1'>";
							echo sprintf($txt['Mess_bas'], $txt['MetaAuthor'], hexentities($param['email_info']), $param['nom_client'] );
							echo "</font>";
							break;
			case 'entretien'	:	echo "<address><font size='1' face='arial'>";
	 						echo sprintf($txt['Mess_bas2'], $txt['MetaAuthor'], hexentities($param['email_support']), hexentities($param['email_support']), $param['dateMAJ'] );
							echo "</address></font>";
							break;
			case 'copyright'	:	echo sprintf($txt['Copyright'], $param['CopyAn'], $param['nom_client'], $param['CopyAn'] );

						 	break;
			case 'text/html'	:	echo "$texte_obj";
						 	break;
			case 'image/pjpeg'	:	
											
			case 'image/gif'	:	echo "<img border='$frame' src='pageloadimage.php?nom_page=$Nom_Page&nom_objet=$Titre' width='$large' height='$haut'>\n";
							//echo "<img border='$frame' src='$FFileName' width='$large' height='$haut'>\n";
							break;
			case 'photo'		:	echo "<img src='PhotoGet.php?No=$FFileName&Idx=$FFileSize' width=$LargX height=$HautY><br>\n";
						 	break;
			default :		break;
		} // switch type_objet
		$Niveau_prec = $Niveau;
		$i++;
	} while( $i < $result->num_rows );
	do {
		echo "</a>\n</div>\n";
		$Niveau_prec--;
	} while( $Niveau_prec >= 0 );
}
else
	echo "Objet de la Page INTROUVABLE ".$Nom_Page;

} // loadObjetPage

?>