<?php
/* Programme : Login.php 
* Description : Programme de login pour la section à accès réservé. 
* Il propose deux options : 
* 1 - s'identifier par un couple nom de login / nom de passe 
* 2 - créer un nouveau compte 
* 
* Identificateurs de mots de passe sont conservés dans une base 
* de données MySQL. 
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-02-06
*/
$InLogIn = true;
include('../lib/config.php');

$ModifRec=0;
$_SESSION['nom_page'] = "login";

if( !isset($_GET['Lang']) ) $_GET['Lang'] = 'FR';

switch( @$_GET['Lang'] ) {
	case "EN" : 	include("logmessen.inc");
			include("varmessen.inc");
			break;
	default : 	include("logmessfr.inc");
			include("varmessfr.inc");
} // switch

$NomChamps = array( "Nom"=>"Nom", "Prenom"=>"Prenom", "Ville"=>"Ville", "Pays"=>"Pays", 
		"Telephone"=>"Telephone","Fax"=>"Fax",  "Courriel"=>"Courriel");

function AfficherErreur($texteMsg)
{ 
global $do,$Nom,$Prenom,$Ville,$Pays,$Telephone,$Fax,$Courriel,$Lang, $TabMessGen, $TabId,  $NomCie;

	if(isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
	   setcookie("cookname", "", time()-60*60*24*100, "/");
	   setcookie("cookpass", "", time()-60*60*24*100, "/");
	}
	$NewMessage = $texteMsg;
	include("login_form.inc");
	exit();
} // AfficherErreur

function confirme_usager($username, $pass){
/*********************************************************
  FUNCTION : confirme_usager
  version : 2.0
  date : 2015-08-20
  derniere modif : Denis Léveillé
  info : Vérifie si le nom d'utilisateur donné est ou non dans la 
 base de données, si tel est le cas, vérifie si le mot de passe 
 donné est le même mot de passe dans la base de données pour cet 
 utilisateur. Si l'utilisateur n'existe pas ou si les mots de 
 passe ne correspondent pas, il appel la procedure d'affichage 
 des erreurs.
 En cas de succès, il retourne un tableau avec les infos de
 sécurité de l'utilisateur
*********************************************************/
global $mabd, $database, $TabMessGen, $TabId;
	/* Ajouter des slashes si necessaire (pour la requête) */
	if( !get_magic_quotes_gpc() ) 
		$username = addslashes($username);

		
   	/* Verifier si l'usager est dans la base de données */
	$sql = "SELECT * FROM secur WHERE NomLogin = '$username'";
	$result = $mabd->query($sql);
	if( !$result || ( $result->num_rows < 1) )
		AfficherErreur($TabId[34]); // Indiquer qu'il y a eu un erreur de nom d'usager

	/* Retrouver le mot de passe du résultat, oter les slashes */
	$dbarray = $result->fetch_array();
	$dbarray['mPasse']  = stripslashes($dbarray['mPasse']);
	$pass = stripslashes($pass);

	/* Vérifier si le mot de passe est correct */
	if( !password_verify ( $pass , $dbarray['mPasse']) ) {
 		$Message = 'Mot de passe incorrect'; //.' >'.$dbarray['mPasse']."<>".$pass."<"
		AfficherErreur($Message); // Indiquer qu'il y a eu un erreur de mot de passe			   
	}

	return $dbarray; // Indiquer que tout est ok

} // confirme_usager


function verifie_login()
/*********************************************************
  FUNCTION : verifie_login
  version : 2.0
  date : 2015-08-20
  derniere modif : Denis Léveillé
  info : Vérifie si l'utilisateur a été mémorisé avec cookie. 
  Si c'est le cas, la base de données est interrogée pour 
  s'assurer de l'authenticité de l'utilisateur. 
  Renvoie un tableau d'info si l'utilisateur s'est connecté.
 **********************************************************/
 {
	$tab = array();
   	/* Vérifier si nous avons conservé les infos de l'usager en cours */
  	if( isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass']) ){
	  	//	echo "Isset cookname/cookpass !!!<br>";
      		$_SESSION['username'] = $_COOKIE['cookname'];
      		$_SESSION['password'] = $_COOKIE['cookpass'];
   	} // Si les cookie actif

   	// es-ce que le nom d'usager et le mot de passe existe dans la session 
   	if( isset($_SESSION['username']) && isset($_SESSION['password']) )
		$tab = confirme_usager( $_SESSION['username'], $_SESSION['password'] );
   
   	return( $tab );
   	
} // verifie_login


// ********************* DEBUT DU CODE DE LOGIN ********************************

	//	echo "Nom :".$_POST['NomUtilisateur'];

	CleanUp(@$_GET['Lang']);
		
	
	/* Si on a un reset, on efface tout y compris les cookies -> usager par défaut */
	if( !empty($_GET['reset']) ) {
		session_destroy();
    		destroy( session_id());

		session_unset();
		session_regenerate_id(true);
 		$_SESSION['NomLogin'] = "WEBUSER";
		session_name ( $_SESSION['NomLogin'] );
		$_SESSION['NoContact'] = 0;
		$_SESSION['Prio'] = 10;
		$_SESSION['local'] = true;
		$_SESSION['auth']  = 'N';
		$_SESSION['NoContact'] = 0;
		$_SESSION['AUCPT'] = 0;
		unset($_COOKIE['cookname']);
		unset($_COOKIE['cookpass']);
		setcookie("cookname", null, -1, "/");
		setcookie("cookpass", null, -1, "/");
		/*if( isset($_COOKIE['cookname']) && isset($_COOKIE['cookpass'])){
		   	setcookie("cookname", "", time() - 3600, "/");
		   	setcookie("cookpass", "", time() - 3600, "/");
		}
		unset($_COOKIE['cookname']);
		unset($_COOKIE['cookpass']);*/
		$md5pass = '';
	}
	else { // Sinon on vérifie si l'usager est comserver dans le cookie
		$tabUser = verifie_login();
		if( isset($tabUser['NomLogin']) ) {
			// oui alors on met les variable et on demande un rappel du dernier login.
			$md5pass = $_SESSION['password'];
			// ***** Correction du 2016-12-19 - on voit le password ????
			$_SESSION['password'] = '';
			unset($_SESSION['password']);
			// ********************************************************
		   	$_GET['do'] = 'rappel';
		}	
	}

switch( @$_GET['do'] ) {
	case "login" : 	// **** On est en mode Login avec les info fourni par l'usager
			$md5pass = '';
			if( isset($_POST['NomUtilisateur']) && strlen($_POST['NomUtilisateur']) )
				CleanUp($_POST['NomUtilisateur']);
			else
				AfficherErreur($TabId[34]);
			
			if( isset($_POST['MotDePasse']) ){ //&& strlen($_POST['MotDePasse']) ) {
				if( strlen($_POST['MotDePasse']) ) {
					// echo "Mot fourni : ".$_POST['MotDePasse'];
					CleanUp($_POST['MotDePasse']);
					$md5pass = $_POST['MotDePasse'];
				}
			}
			else { // Mot de passe incorrect
				$Message = $TabId[33].$_POST['NomUtilisateur']; //." PASS = ".$_POST['MotDePasse'];
				AfficherErreur($Message);			   
			}
			
			/* Verifier si le NomUtilisateur est dans la base de données et que MotDePasse (md5pass) existe */
			$tabUser = confirme_usager($_POST['NomUtilisateur'], $md5pass);
			$_POST['NomUtilisateur'] = stripslashes($_POST['NomUtilisateur']);
	case 'rappel':
			extract($tabUser);
	
			/* le NomUtilisateur et MotDePasse (md5pass) sont valide, Nous enregistrons les variables de Session */
			
			$_SESSION['username'] = $tabUser['NomLogin'];
			$_SESSION['auth'] = "yes";
			$aujourdhui = date("Y-m-d H:i:s");
					
			$_SESSION['NomLogin'] = strtoupper($tabUser['NomLogin']);
			$_SESSION['NoID'] = $_SESSION['NoContact'] = $NoClient;
			$_SESSION['Prio'] = $Priorite;
			$_SESSION['SLangue'] = $Langue;
			
			// On laisse une trace du passage
			$sql = "INSERT INTO $database.login ( NomLogin, DateLogin, Operation )";
			$sql .= "VALUES ('".$_SESSION['NomLogin']."','$aujourdhui', '***** CONNECTION *****')";
			//AfficherErreur($sql);
			if( !$mabd->query($sql) ) {
				$Message = $TabId[32]." ".$sql;
				AfficherErreur( $Message );
			}
			
			/**
			 C'est la partie la plus cool: l'utilisateur nous a demandé de nous rappeler qu'il était connecté, 
			 alors nous avons mis deux cookies. Un pour tenir son nom d'utilisateur, et un pour tenir son 
			 mot de passe crypté md5. Nous les avons tous deux expirés dans 5 jours. Maintenant, la prochaine 
			 fois qu'il vient sur notre site, nous allons le connecter automatiquement
			*/
			if( isset($_POST['remember']) ) { 
				//echo "SET cookname/cookpass !!!<br>";
				setcookie("cookname", $_SESSION['username'], time()+60*60*24*5, "/");
				setcookie("cookpass", $md5pass, time()+60*60*24*5, "/");
			}
					
			if( $Acces == "NON" ) 
				header("Location: mspsmodif.php");
			else 
				header("Location: pagegestion.php");
			exit();
			break;
	default : 	// l'usager est-il autorisé
		  	include( "login_form.inc");
		
}

?>

