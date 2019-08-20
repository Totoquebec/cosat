<?php
$NomCie="Cosat Informatique";
$TelCie="(450)530-3353";
$AdrCourriel="cosat.info@cosat.biz";
$DebugDet=0;
$AdrWebmestre="webmaster@cosat.biz";
$CopyAn="2007-2009";
$DateMAJ="2009/10/08";
$NomCieCréé="Denis Léveillé";
$NomPGM="e-Cosat";
$Version=1.00;

$PrioMaitre = 1;
$PrioDetruit = 1;
$PrioCompte = 2;
$PrioAnnule = 3;
$PrioModif = 4;
$PrioImprime = 5;
$PrioLivreur = 7;
$PrioRien = 9;

if( !isset($_SESSION['_VARCIE']) ) {
	 $_SESSION['_VARCIE'] =  1;
	$_SESSION['ClientMaxCrédit'] =  5.00;
}

$Aujourdhui = date("Y-m-d");
$Now =  date("Y-m-d H:i:s");
$entr_id   = "Cosat Informatique";  // numéro de l'entreprise
$entr_date = "2009-09-30";  // date d'installation du site au format jj-mm-aaaa

// Configuration de l'entreprise
$entr_path = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);  // chemin du site sur le serveur
$entr_www = $_SERVER['HTTP_HOST'];

if( isset( $_SERVER['HTTPS'] ) && !strcasecmp("on", $_SERVER['HTTPS']) ) 
	$entr_url  = "https://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);  // url complète de l'entreprise
else
	$entr_url  = "http://".$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);  // url complète de l'entreprise

?>