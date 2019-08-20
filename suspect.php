<?php
include('lib/config.php');
 
// On est accéder alors on enregistre une variable de session  
$_SESSION['isRobot'] = true;  
  
// on inclus notre fonction isMoteur contenu dans le fichier dataBot.php  and librairy maintenant
//include ('dataBot.php');  

// On récupère l'adresse IP du visiteur  
$ip = get_ip();  

// On teste si on a affaire à un vrai moteur de recherche  
if( !EsUnRobot($ip) )  {
	$_SESSION['isAspi'] = 1;  
}

// un retour vers le site  
header('Location: index.php'); 
?> 