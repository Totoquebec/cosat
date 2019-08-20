<?php
include('connect.inc');
$type = $_GET['type'];
$texte			=	$_GET['texte'];
$lang				=	$_GET['lang'];
$lang2			=	$_GET['lang2'];
$texte 			= 	strtolower($texte);
//$texte			= strtr($texte,'ABCDEFGHIJKLMNOPQRSTUVWXYZ','abcdefghijklmnopqrstuvwxyz');

//Vérifie si résulta
if( $texte == "" )
exit();

### on verifie la présence des variables 

### on met un petit selected dans le formulaire pour la langue   

echo 
"<html>
<head>
	<title>Google</title>
</head>
<body onload='refresh(document.tradu.a.value, document.tradu.a2.value);'>
	<form name=tradu id=tradu>";

$texte = urlencode($texte);
### recherche la source chez google avec le mot à traduire: $texte 
$source = implode ('', file ("http://translate.google.com/translate_t?text=$texte&langpair=$lang&hl=fr")); 
### decoupage de $source au debut

$source = strstr($source, '<div id=result_box dir="ltr">'); 
### decoupage de $source à la fin
$fin_source = strstr($source, '</div>'); 
### supprimer $fin_source de la chaine $source 
$proposition = str_replace("$fin_source","", $source); 
$proposition = str_replace("<div id=result_box dir=\"ltr\">","", $proposition);   

### affichage du resultat 

echo'
		<center>
			Traduction:<br>
			<textarea rows="4" name="a" cols="46" onkeyup="refresh(document.tradu.a.value)" value="'.$proposition.'">'.$proposition.'</textarea>
		</center>';
### décommentez cette ligne pour tester l'url
#echo'<br><br><a href="'.$url.'" target="_Blank" class="texte1">'.$url.'</a><br><br><a class="test">'.htmlentities($source).'</a>'; 



if ($lang ==  "es|en"){

$reponse= str_replace(" ", "%20", $proposition);

}
else if ($lang ==  "fr|en"){
$reponse= str_replace("%20", "", $proposition);
$reponse= str_replace("</ b>", "", $reponse);
$reponse= str_replace("<b>", "", $reponse);
$reponse= str_replace(">", "", $reponse);
$reponse= str_replace(" ", "%20", $reponse);


}
else{
$reponse=str_replace(" ", "%20", $texte);

}
echo $reponse;
$sources = implode ('', file ("http://translate.google.com/translate_t?text=$reponse&langpair=$lang2&hl=fr")); 
### decoupage de $source au debut

$sources = strstr($sources, '<div id=result_box dir="ltr">'); 
### decoupage de $source à la fin
$fin_sources = strstr($sources, '</div>'); 
### supprimer $fin_source de la chaine $source 
$propositions = str_replace("$fin_sources","", $sources); 
$propositions = str_replace("<div id=result_box dir=\"ltr\">","", $propositions);  
$propositions = str_replace("¡", "", $propositions);

echo'
		<center>
			Traduction:<br>
			<textarea rows="4" name="a2" cols="46" onkeyup="refresh(document.tradu.a2.value);" value="'.$propositions.'">'.$propositions.'</textarea>
		</center>';

### affichage du resultat 

 if( $type == "description_" ){
 		if( $lang == "es|en" )
			$clang = "description_en";
		elseif( $lang == "en|fr" )
			$clang="description_fr"; 
		elseif( $lang == "fr|en" )
			$clang="description_en";
		else
			$clang="description_sp";
			
			
		if( $lang2 == "en|fr" )
 			$clang2="description_fr"; 
		elseif( $lang2 == "en|es" )
			$clang2="description_sp"; 
		else // if ($lang == "fr|en")
			$clang2="description_en";
		}
		else{
		if( $lang == "es|en" )
			$clang = "en";
		elseif( $lang == "en|fr" )
			$clang="fr"; 
		elseif( $lang == "fr|en" )
			$clang="en";
		else
			$clang="sp";
			
			
		if( $lang2 == "en|fr" )
 			$clang2="fr"; 
		elseif( $lang2 == "en|es" )
			$clang2="sp"; 
		else // if ($lang == "fr|en")
			$clang2="en";

}
?>
	<br></form>
	<script language='JavaScript1.2'>

		function refresh(toThis, taThis)
		{

			opener.document.langu.<?=$clang?>.value=toThis;
				opener.document.langu.<?=$clang2?>.value=taThis;
		this.close();
		}
	
	</script>
</body>
</html>