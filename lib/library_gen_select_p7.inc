<?php
/* Programme : library_general_select.php
* Description : Diverse fonction
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
*/

/*
INSERT INTO `webmenu` (`No`, `Page`, `Niveau`, `Titre_fr`, `Titre_en`, `Titre_sp`, `RefPage`, `Parametre`, `TopMenu`, `Affichable`) VALUES
(180, 'Usagers', 9, 'Gestion des usagers', 'Users management', 'Information', 'mssec/ms_main', '', NULL, 'Oui'),
(181, 'Module sécurité', 9, 'Consulte Usager', 'User consult', '', 'mssec/msconsult', '', NULL, 'Oui'),
(182, 'Module sécurité', 9, 'Ajout Usager', 'User add', '', 'mssec/ms_ajout', '', NULL, 'Oui'),
(183, 'Module sécurité', 9, 'Consulte liste usager', 'User List consult', '', 'mssec/ms_usg_lst', '', NULL, 'Oui'),
(185, 'Module sécurité', 9, 'Modifie mot de passe', 'Change Password', '', 'mssec/mspsmodif', '', NULL, 'Oui'),
(186, 'Module de sécurité', 9, 'Consultation des accès', 'Acces information', '', 'mssec/ms_login_lst', '', NULL, 'Oui'),
(187, 'Module de sécurité', 9, 'Usager en ligne', 'Inline users', '', 'mssec/ms_actif_lst', '', NULL, 'Oui');

INSERT INTO `webmenu` (`No`, `Page`, `Niveau`, `Titre_fr`, `Titre_en`, `Titre_sp`, `RefPage`, `Parametre`, `TopMenu`, `Affichable`) VALUES
(19, 'accueil', 1, 'Paramètres', 'Parameters', '', 'parametres', '', 0, 'Oui'),
(90, 'Variables sytèmes', 1, 'Variables du système', 'System variable', '', 'sys_var_traite', '', 0, 'Oui'),
(99, 'Erreur', 1, 'Erreur du système', 'System Error', '', 'sys_erreur', '', 0, 'Oui');
COMMIT;

ALTER TABLE `secur` ADD `NomUsager` VARCHAR(100) NULL AFTER `Courriel`, ADD `Département` VARCHAR(30) NULL AFTER `NomUsager`, ADD `Poste` VARCHAR(30) NULL AFTER `Département`, ADD `Divers` VARCHAR(25) NULL AFTER `Poste`; 
// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________
function get_params($url_rech=0)
function textes($lang)
function Langue($langue)
function password_get($id)
*/

function get_params($url_rech=0)
//  FUNCTION : get_params - 1a
//  version : 1.0
//  date : 16-11-04
//  derniere modif : Maxime Dupuis
//  info : retourne les paramètres de configuration tels qu'édités par le client
{
global $mabd, $database, $entr_url;

//	echo "Rech 1 =".$url_rech."<br>";
	if( strlen($url_rech) < 5 ) 
		$url_rech = $_SERVER['HTTP_HOST'];
		
	$sql = "SELECT * FROM $database.parametre WHERE url LIKE '%$url_rech%' LIMIT 1;";
	
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_params", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	if( $result->num_rows ) {
		$params = $result->fetch_assoc();
	}
	else {
		Message_Erreur( "ERROR", "Site NON-INSCRIT",  $url_rech );			
		$params = array();
	}
	
	return $params;
} // fin de la fonction : get_params 

function textes($lang)
//  FUNCTION : textes - 1b
//  version : 1.0
//  date : 28-09-04
//  derniere modif : Maxime Dupuis
//  info : Selectionne les variables de la BD : textes selon la langue
{
global $mabd, $database;
		
	$sql = "SELECT * FROM $database.messages WHERE Langue = '$lang' LIMIT 1;";
	
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès textes", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	if( $result->num_rows ){
		$results = $result->fetch_assoc();
	}
	else
		$results = array();
	
	return $results;

} // fin de la fonction : textes -

function Langue($langue)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Langue
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 11-06-08
//  derniere modif : Jean-Alexandre Denis
//  info : Selectionne la langue dans la base
{
global $mabd, $database;
	$lang = array();
	
	$sql = "SELECT id, $langue FROM $database.messgen";

	$result = $mabd->query($sql);
	
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès Langue >$langue<", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	while( $r = $result->fetch_assoc() )
		$lang[$r['id']] = $r[$langue];
	
	return $lang;

} // fin de la fonction : Langue

function password_get($id)
//  FUNCTION : password_get - 12h
//  date : 2007-11-05
//  derniere modif : Denis Léveillé
//  info : Trouver le frais de livraison pour un montant donner
{
global $mabd, $database;

	$pass = "";
	$sql = "SELECT mPasse FROM $database.secur WHERE Courriel = '$id'";
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur password_get", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
		
   	if( $result->num_rows ) {
		$infopass = $result->fetch_assoc();
		$pass = $infopass["mPasse"];
	}
   	return($pass);
} // fin de la fonction : password_get
?>