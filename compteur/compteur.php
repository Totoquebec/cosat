<?php
//session_start();
include("../lib/var.inc");

//////////////////////////////////////////////////////
////////////	Paramètres à modifier selon besoin
//////////////////////////////////////////////////////
//chemin et nom du fichier texte dans lequel se trouve un seule ligne contenant le nomvre de visites 
$fichier="./compteur.txt"; 	
//chemin ou se trouve les 10 images représentant les chiffres 0 à 9
//et nom de la premiere image ce qui va permettre de recupérer l'extension de l'image
//type d'image autorisé dans ce script: png, jpg ou gif
$img="./jpg/im0.jpg";
//$img="./png/0.jpg";	exemple avec png
//$img="./gif/im0.gif";
//$img="./gifs/im0.gif";
// Le script gd.php permet de vérifier que l'extension gd est bien pésente et les types d'images supportés
//les 10 images doivent etre présentes 
//////////////////////////////////////////////////////


//////////////////////////////////////////////////////
////////////	Code réalisation du compteur
//////////////////////////////////////////////////////
if (imagetypes() & IMG_PNG) { // on dessine du png quelque soit le type des images (png, jpg ou gif) 
    header ("Content-type: image/png");
	
	if( isset( $_SESSION["nb"] ) ) 
		$nb=$_SESSION["nb"] ;
	else {	
		/////////////// Ouverture fichier texte contenant le compteur, lecture, incrementation, ecriture
		if (file_exists($fichier)) {//le fichier existe
		 	if (is_writable($fichier)) 
			 	$mode="r+"; //et le fichier est accessible en ecriture
	 		else  
		 		noimage("Compteur indisponible"); //en lecture seule donc affichage erreur
		}
		else 
			$mode="w+"; //le fichier n'existe pas, il va etre créé
		$fic=fopen($fichier,$mode); //ouverture du fichier
		if (!$fic) 
			noimage("Compteur indisponible");  //probleme lors de l'ouverture et  affichage erreur
		
		$nb =  fgets($fic); //recupere la seule ligne du fichier devant contenir le nombre de visites
		if ($nb=="") 
			$nb=0;
		$nb++; //si ligne vide alors nombre =1 sinon on incremente
		rewind ($fic); //on se replace en debut de fichier
		fputs($fic,$nb); //on ecrit le nombre de visites
		fclose($fic);//fermeture du fichier
		$_SESSION["nb"]=$nb;
	}	
	$ligne=str_pad($nb,5, "0", STR_PAD_LEFT);	//complete a gauche par des zéro si le nombre a moins de 5 chiffres
												//afin d'avoir un compteur sur  5 chiffres
	// extension des images represenatnt les chiffres de 0 à 9
	$ext=substr($img, strrpos($img,".")); 	
	$fic=substr($img,0, strrpos($img,".")-1); 	

	for($i=0;$i<10;$i++) {	//si une image est manquante affichage sous forme de texte
		if (!file_exists($fic.$i.$ext) ) 
			noimage($ligne);
		//pour chaque image on recupere sa largeur, sa hauteur, ...
		list(${"w$i"},${"h$i"},${"typ$i"},${"attrib$i"}) = getimagesize($fic.$i.$ext);
	}
		
	$wtot=0;	//calcul de la largeur du compteur en fonction des images qui le forment
	for($i=0;$i<strlen($ligne);$i++) 
		$wtot += ${"w".$ligne[$i]};
	
	$imdest = imagecreatetruecolor  ($wtot,$h0); //creation d'une image vide de la longueur des 5 images
	
	///////////////////////////////////	couleur de fond	////////////////////////	
	//pas necessiare mais je laisse le code en exemple
	/*$imsource = createfrom($fic."1".$ext,$ext,$ligne);	//chargement de l'image im1.gif  
	if (! $imsource) noimage($ligne); //probleme donc affichage sous forme de texte
	//recupéréation de la couleur du pixel en haut  a gauche senssé etre couleur de fond
	$rgb = imagecolorsforindex($imsource,imagecolorat($imsource, 0, 0)) ;
	//mettre cette meme couleur de fond dans la nouvelle image
	$bgc = imagecolorallocate ($imdest, $rgb["red"], $rgb["green"], $rgb["blue"]);
	imagefill ($imdest, 0, 0, $bgc);
	*/////////////////////////////////
	
	////////////////	realisation de l'image compteur	///////////// 
	$pos=0;
	for($i=0;$i<strlen($ligne);$i++) {	//copy de l'image representant chacun des 5 chiffres du compteur
		$imsource = createfrom($fic.$ligne[$i].$ext,$ext,$ligne);
		if (!$imsource) 
			noimage($ligne); //probleme donc affichage sous forme de texte
		imagecopymerge ( $imdest ,$imsource  ,$pos, 0, 0, 0,${"w".$ligne[$i]}, ${"h".$ligne[$i]}, 100);
		$pos +=${"w".$ligne[$i]};
	}
	
	imagepng($imdest) ; //affichage du compteur sous frome d'une image png
}

function createfrom($img,$ext,$ligne){
	switch ($ext){
		case ".gif" :return imagecreatefromgif($img); 	
		case ".jpg" :return imagecreatefromjpeg($img);	
		case ".png" :return imagecreatefrompng($img);	
		default: noimage($ligne);
	}
}	

function noimage($txt){
	$font=2; //ecriture du texte $txt dans l'image $imdest
	$imdest = imagecreatetruecolor  (10+strlen($txt)* imagefontwidth($font) ,5+imagefontheight($font) );
	$bgc = imagecolorallocate ($imdest, 255, 255, 255);
	$tc = imagecolorallocate ($imdest, 0, 0, 0);
	imagefilledrectangle ($imdest, 0, 0, 150, 30, $bgc);
	imagestring ($imdest, $font, 5, 5, $txt, $tc);
	imagepng($imdest) ;
	die();
}
?>