<?php
/*
// DEBUT FUNCTIONS DIVERS --
/**********************************************************************************************
Table des matières des functions
___________________________
function update_client_password($pass)
function update_sys_var($TabSysVar)
*/

// ~~~~~~~~~~~~~~ DEBUT FUNCTIONS DE *UPDATE ~~~~~~~~~~~~~~~~


function update_client_password($pass)
//  FUNCTION : update_client_password
//  version : 1.0
//  date : 21-11-04
//  derniere modif : Maxime Dupuis
//  info : Met à jour les variables de la BD : clients
{
global $mabd, $database;
		$sql = "UPDATE $database.clients set password = \"".$pass."\" WHERE id = ".$_SESSION[$_SERVER['SERVER_NAME']].";";
		$mabd->query($sql)
			or die("Impossible de mettre à jour les informations du client. ".$mabd->error);  

		return 1;

} // fin de la fonction : update_client_password 


function update_sys_var($TabSysVar)
//  FUNCTION : update_sys_var
//  version : 1.0
//  date : 2016-12-30
//  derniere modif : Denis Léveillé
//  info : Met à jour les variables de la BD : parametre
{
global $mabd, $database;
	$_SESSION['SYSVAR_ERREUR'] = 0;
	
	// Si POST est vide
	if( empty($TabSysVar) ) {
		$_SESSION['SYSVAR_ERREUR'] = 1;
		$_SESSION['SYSVAR_MESSAGE'] = "Impossible de mettre à jour les informations du SYSVAR.";
		return 0;
	}

	extract( $TabSysVar, EXTR_OVERWRITE );
	
	$nom_client = myAddSlashes($nom_client);
	$adresse_client = myAddSlashes($adresse_client);
	$ville_client = myAddSlashes($ville_client);
	
	// on met à jour les infos des variables systèmes
	$sql =  "UPDATE IGNORE $database.parametre SET `Createur`='$Createur',`Programme`='$Programme',`Version`='$Version',`CopyAn`='$CopyAn',";
	$sql .=  " `nom_client`='$nom_client',`courriel_client`='$courriel_client',`adresse_client`='$adresse_client',";
	$sql .=  " `ville_client`='$ville_client',`codepostal_client`='$codepostal_client',`telephone_client`='$telephone_client',";
	$sql .=  " `fax_client`='$fax_client',`province_client`='$province_client',`pays_client`='$pays_client',`www_client`='$www_client',";
	$sql .=  " `no_tps`='$no_tps',`no_tvq`='$no_tvq',`tvq`='$tvq',`tps`='$tps',`url`='$url',`url_ssl`='$url_ssl',";
	$sql .=  " `email_facture`='$email_facture',`email_administration`='$email_administration',";
//	$sql .=  " `email_facture`='$email_facture',`email_commande`='$email_commande',`email_administration`='$email_administration',";
	$sql .=  " `email_clientele`='$email_clientele',`email_support`='$email_support',`email_ventes`='$email_ventes',`email_info`='$email_info',";
	$sql .=  " `date_debut`='$date_debut',`dateMAJ`='$dateMAJ' ";
	$sql .=  " WHERE `Id` = '$Id';";
//echo $sql;
//exit();
	if( !$mabd->query($sql) )  {
		$_SESSION['SYSVAR_ERREUR'] = 1;
		$_SESSION['SYSVAR_MESSAGE'] = "ERREUR modification SYSVAR : ".$mabd->errno.": ".$mabd->error;
		return( 0 );
	}
		
	$Mess = "Modification SYSVAR : $Programme";
	Suivi_log($Mess, 0);
	return 1;
	

} // fin de la fonction : update_sys_var 
?>