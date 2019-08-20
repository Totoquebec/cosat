<?php
include("var_extra.inc");
include('connect.inc');
ob_start();
// l'usager est-il autorisé
if( @$_SESSION['auth'] != "yes" ) {
      // Non. alors n'a pas utilisé le chemin du login
  		header( "Location: login.php");
		exit();
}
// Inclusion des variables
include("varcie.inc");
// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	include("varmessen.inc");
							break;
	case "SPANISH":	include("varmesssp.inc");
							break;
	default:				include("varmessfr.inc");

} // switch SLangue

function allo(){
	
	$sql = "SELECT * FROM parametre ORDER BY id";
	$req = mysql_query($sql);
	while ($telech = mysql_fetch_array($req)) {
		$id = stripslashes($telech['id']);
		echo ''.$id."  <a href='param.php?modifier=$id'><img src='jpeg/edit.gif'></a><br>";
	} 
} // allo

if (@$_GET['modifier_valide'] == ""){
	if (@$_GET['modifier'] == ""){
		allo();
	}
	else {
		$sql = "SELECT * FROM parametre WHERE id = '".$_GET['modifier']."'";
		$req = mysql_query($sql);
		if ($req) 
			$telech = mysql_fetch_array($req);
		$id = stripslashes($telech['id']);
		$nom_client = stripslashes($telech['nom_client']);
		$courriel_client = stripslashes($telech['courriel_client']);
		$adresse_client = stripslashes($telech['adresse_client']);
		$ville_client = stripslashes($telech['ville_client']);
		$codepostal_client = stripslashes($telech['codepostal_client']);
		$telephone_client = stripslashes($telech['telephone_client']);
		$fax_client = stripslashes($telech['fax_client']);
		$province_client = stripslashes($telech['province_client']);
		$pays_client = stripslashes($telech['pays_client']);
		$www_client = stripslashes($telech['www_client']);
		$no_tps = stripslashes($telech['no_tps']);
		$no_tvq = stripslashes($telech['no_tvq']);
		$tvq = stripslashes($telech['tvq']);
		$tps = stripslashes($telech['tps']);
		$mode_paiement_carte = stripslashes($telech['mode_paiement_carte']);
		$mode_paiement_ligne = stripslashes($telech['mode_paiement_ligne']);
		$mode_paiement_cheque = stripslashes($telech['mode_paiement_cheque']);
		$fr = stripslashes($telech['fr']);
		$en = stripslashes($telech['en']);
		$sp = stripslashes($telech['sp']);
		$url = stripslashes($telech['url']);
		$url_ssl = stripslashes($telech['url_ssl']);
		$url_payeur = stripslashes($telech['url_payeur']);
		$url_payeur_test = stripslashes($telech['url_payeur_test']);
		$id_payeur = stripslashes($telech['id_payeur']);
		$cle_payeur = stripslashes($telech['cle_payeur']);
		$Email_facture = stripslashes($telech['Email_facture']);
		$Email_commande = stripslashes($telech['Email_commande']);
		$email_administration = stripslashes($telech['email_administration']);
		$email_clientele = stripslashes($telech['email_clientele']);
		$email_paquet = stripslashes($telech['email_paquet']);
		$email_support = stripslashes($telech['email_support']);
		$email_ventes = stripslashes($telech['email_ventes']);
		$email_pharmacie = stripslashes($telech['email_pharmacie']);
		$email_info = stripslashes($telech['email_info']);
		$largeur_affichage = stripslashes($telech['largeur_affichage']);
		$largeur_achat = stripslashes($telech['largeur_achat']);
		$alignement = stripslashes($telech['alignement']);
		$categorie_affichage = stripslashes($telech['categorie_affichage']);
		$banque = stripslashes($telech['banque']);
		$image_special_largeur = stripslashes($telech['image_special_largeur']);
		$image_special_haut = stripslashes($telech['image_special_haut']);
		$image_list_largeur = stripslashes($telech['image_list_largeur']);
		$image_list_hauteur = stripslashes($telech['image_list_hauteur']);
		$image_mid_height = stripslashes($telech['image_mid_height']);
		$image_mid_weight = stripslashes($telech['image_mid_weight']);
		$ventes = stripslashes($telech['ventes']);
		$Transfert = stripslashes($telech['Transfert']);
		$MaxTransfert = stripslashes($telech['MaxTransfert']);
		$clients = stripslashes($telech['clients']);
		$inventaire = stripslashes($telech['inventaire']);
		$soumissions = stripslashes($telech['soumissions']);
		$agenda = stripslashes($telech['agenda']);
		$livraisons = stripslashes($telech['livraisons']);
		$paiement_par_cheque = stripslashes($telech['paiement_par_cheque']);
		$album_photos = stripslashes($telech['album_photos']);
		$panier_actif = stripslashes($telech['panier_actif']);
		$path_show_main = stripslashes($telech['path_show_main']);
		$scat_show_main = stripslashes($telech['scat_show_main']);

		allo();
?>
		<form method="POST" action="param.php?modifier_valide=<?php echo $id; ?>">
			<div align="center">
		
		<table border="1" width="44%" id="table1">
		<tr><td width="50%" align="right"><?php echo $TabMessGen['304']; ?> : </td><td width="50%"><input type="text" name="id" size="20" readonly="true" value="<?php echo $id ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['305']; ?> : </td><td width="50%"><input type="text" name="nom_client" size="20" value="<?php echo $nom_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['306']; ?> : </td><td width="50%"><input type="text" name="courriel_client" size="20" value="<?php echo $courriel_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['307']; ?> : </td><td width="50%"><input type="text" name="adresse_client" size="20" value="<?php echo $adresse_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['308']; ?> : </td><td width="50%"><input type="text" name="ville_client" size="20" value="<?php echo $ville_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['309']; ?> : </td><td width="50%"><input type="text" name="codepostal_client" size="20" value="<?php echo $codepostal_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['310']; ?> : </td><td width="50%"><input type="text" name="telephone_client" size="20" value="<?php echo $telephone_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['311']; ?> : </td><td width="50%"><input type="text" name="fax_client" size="20" value="<?php echo $fax_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['312']; ?> : </td><td width="50%"><input type="text" name="province_client" size="20" value="<?php echo $province_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['313']; ?> : </td><td width="50%"><input type="text" name="pays_client" size="20" value="<?php echo $pays_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['314']; ?> : </td><td width="50%"><input type="text" name="www_client" size="20" value="<?php echo $www_client ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['315']; ?> : </td><td width="50%"><input type="text" name="no_tps" size="20" value="<?php echo $no_tps ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['316']; ?> : </td><td width="50%"><input type="text" name="no_tvq" size="20" value="<?php echo $no_tvq ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['317']; ?> : </td><td width="50%"><input type="text" name="tvq" size="20" value="<?php echo $tvq ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['318']; ?> : </td><td width="50%"><input type="text" name="tps" size="20" value="<?php echo $tps; ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['319']; ?> : </td><td width="50%"><input type="text" name="mode_paiement_carte" size="20" value="<?php echo $mode_paiement_carte ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['320']; ?> : </td><td width="50%"><input type="text" name="mode_paiement_ligne" size="20" value="<?php echo $mode_paiement_ligne ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['321']; ?> : </td><td width="50%"><input type="text" name="mode_paiement_cheque" size="20" value="<?php echo $mode_paiement_cheque ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['322']; ?> : </td><td width="50%"><input type="text" name="fr" size="20" value="<?php echo $fr ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['323']; ?> : </td><td width="50%"><input type="text" name="en" size="20" value="<?php echo $en ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['324']; ?> : </td><td width="50%"><input type="text" name="sp" size="20" value="<?php echo $sp ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['325']; ?> : </td><td width="50%"><input type="text" name="url" size="20" value="<?php echo $url ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['326']; ?> : </td><td width="50%"><input type="text" name="url_ssl" size="20" value="<?php echo $url_ssl ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['327']; ?> : </td><td width="50%"><input type="text" name="url_payeur" size="20" value="<?php echo $url_payeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['328']; ?> : </td><td width="50%"><input type="text" name="url_payeur_test" size="20" value="<?php echo $url_payeur_test ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['329']; ?> : </td><td width="50%"><input type="text" name="id_payeur" size="20" value="<?php echo $id_payeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['330']; ?> : </td><td width="50%"><input type="text" name="cle_payeur" size="20" value="<?php echo $cle_payeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['331']; ?> : </td><td width="50%"><input type="text" name="Email_facture" size="20" value="<?php echo $Email_facture ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['332']; ?> : </td><td width="50%"><input type="text" name="Email_commande" size="20" value="<?php echo $Email_commande ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['333']; ?> : </td><td width="50%"><input type="text" name="email_administration" size="20" value="<?php echo $email_administration ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['334']; ?> : </td><td width="50%"><input type="text" name="email_clientele" size="20" value="<?php echo $email_clientele ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['335']; ?> : </td><td width="50%"><input type="text" name="email_paquet" size="20" value="<?php echo $email_paquet ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['336']; ?> : </td><td width="50%"><input type="text" name="email_support" size="20" value="<?php echo $email_support ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['337']; ?> : </td><td width="50%"><input type="text" name="email_ventes" size="20" value="<?php echo $email_ventes ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['338']; ?> : </td><td width="50%"><input type="text" name="email_pharmacie" size="20" value="<?php echo $email_pharmacie ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['339']; ?> : </td><td width="50%"><input type="text" name="email_info" size="20" value="<?php echo $email_info ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['340']; ?> : </td><td width="50%"><input type="text" name="largeur_affichage" size="20" value="<?php echo $largeur_affichage ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['341']; ?> : </td><td width="50%"><input type="text" name="largeur_achat" size="20" value="<?php echo $largeur_achat ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['342']; ?> : </td><td width="50%"><input type="text" name="alignement" size="20" value="<?php echo $alignement ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['343']; ?> : </td><td width="50%"><input type="text" name="categorie_affichage" size="20" value="<?php echo $categorie_affichage ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['344']; ?> : </td><td width="50%"><input type="text" name="banque" size="20" value="<?php echo $banque ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['345']; ?> : </td><td width="50%"><input type="text" name="image_special_largeur" size="20" value="<?php echo $image_special_largeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['346']; ?> : </td><td width="50%"><input type="text" name="image_special_haut" size="20" value="<?php echo $image_special_haut ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['347']; ?> : </td><td width="50%"><input type="text" name="image_list_largeur" size="20" value="<?php echo $image_list_largeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['348']; ?> : </td><td width="50%"><input type="text" name="image_list_hauteur" size="20" value="<?php echo $image_list_hauteur ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['349']; ?> : </td><td width="50%"><input type="text" name="image_mid_height" size="20" value="<?php echo $image_mid_height ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['350']; ?> : </td><td width="50%"><input type="text" name="image_mid_weight" size="20" value="<?php echo $image_mid_weight ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['351']; ?> : </td><td width="50%"><input type="text" name="ventes" size="20" value="<?php echo $ventes ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['352']; ?> : </td><td width="50%"><input type="text" name="Transfert" size="20" value="<?php echo $Transfert ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['353']; ?> : </td><td width="50%"><input type="text" name="MaxTransfert" size="20" value="<?php echo $MaxTransfert ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['354']; ?> : </td><td width="50%"><input type="text" name="client" size="20" value="<?php echo $clients ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['355']; ?> : </td><td width="50%"><input type="text" name="inventaire" size="20" value="<?php echo $inventaire ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['356']; ?> : </td><td width="50%"><input type="text" name="soumissions" size="20" value="<?php echo $soumissions ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['357']; ?> : </td><td width="50%"><input type="text" name="agenda" size="20" value="<?php echo $agenda ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['358']; ?> : </td><td width="50%"><input type="text" name="livraisons" size="20" value="<?php echo $livraisons ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['359']; ?> : </td><td width="50%"><input type="text" name="paiement_par_cheque" size="20" value="<?php echo $paiement_par_cheque ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['360']; ?> : </td><td width="50%"><input type="text" name="album_photos" size="20" value="<?php echo $album_photos ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['361']; ?> : </td><td width="50%"><input type="text" name="panier_actif" size="20" value="<?php echo $panier_actif ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['362']; ?> : </td><td width="50%"><input type="text" name="path_show_main" size="20" value="<?php echo $path_show_main ?>"></td></tr>
		<tr><td width="50%" align="right"><?php echo $TabMessGen['363']; ?> : </td><td width="50%"><input type="text" name="scat_show_main" size="20" value="<?php echo $scat_show_main ?>"></td></tr>
		</table>	
		<p><input type="submit" value="<?php echo $TabMessGen['364']; ?>" name="B1"></p>
		</div>
		
		</form>

<?php
	}	 
}
else{
	extract($_POST,EXTR_OVERWRITE);	 
	$sql = "UPDATE parametre SET id ='".$_GET['modifier_valide']."', nom_client ='".$_POST['nom_client']."',";
	$sql .= " courriel_client ='$courriel_client', adresse_client ='$adresse_client',";
	$sql .= " ville_client ='$ville_client', codepostal_client ='$codepostal_client',";
	$sql .= " telephone_client ='$telephone_client', fax_client ='$fax_client',"; 
	$sql .= " province_client ='$province_client', pays_client ='$pays_client',";
	$sql .= " www_client ='$www_client', no_tps ='$no_tps', no_tvq ='$no_tvq',";
	$sql .= " tvq ='$tvq', tps ='$tps', mode_paiement_carte ='$mode_paiement_carte',";
	$sql .= " mode_paiement_ligne ='$mode_paiement_ligne', mode_paiement_cheque ='$mode_paiement_cheque',";
	$sql .= " fr ='$fr', en ='$en', sp ='$sp', url ='$url',";
	$sql .= " url_ssl ='$url_ssl', url_payeur ='$url_payeur', url_payeur_test ='$url_payeur_test',";
	$sql .= " id_payeur ='$id_payeur', cle_payeur ='$cle_payeur', Email_facture ='$Email_facture',";
	$sql .= " Email_commande ='$Email_commande', email_administration ='$email_administration',";
	$sql .= " email_clientele ='$email_clientele', email_paquet ='$email_paquet',";
	$sql .= " email_support ='$email_support', email_ventes ='$email_ventes',";
	$sql .= " email_pharmacie ='$email_pharmacie', email_info ='$email_info',";
	$sql .= " largeur_affichage ='$largeur_affichage', largeur_achat ='$largeur_achat',";
	$sql .= " alignement ='$alignement', categorie_affichage ='$categorie_affichage',";
	$sql .= " image_special_haut ='$image_special_haut', image_list_largeur ='$image_list_largeur',";
	$sql .= " image_list_hauteur ='$image_list_hauteur', image_mid_height ='$image_mid_height',";
	$sql .= " image_mid_weight ='$image_mid_weight', ventes ='$ventes',";
	$sql .= " Transfert ='$Transfert', MaxTransfert ='$MaxTransfert', clients ='$clients',";
	$sql .= " image_list_hauteur ='$image_list_hauteur', image_mid_height ='$image_mid_height',"; 
	$sql .= " image_mid_weight ='$image_mid_weight', ventes ='$ventes', Transfert ='$Transfert',"; 
	$sql .= " MaxTransfert ='$MaxTransfert', clients ='$clients', inventaire ='$inventaire',"; 
	$sql .= " soumissions ='$soumissions', agenda ='$agenda', livraisons ='$livraisons', paiement_par_cheque ='$paiement_par_cheque',"; 
	$sql .= " album_photos ='$album_photos', panier_actif ='$panier_actif', path_show_main ='$path_show_main',"; 
	$sql .= " scat_show_main ='$scat_show_main' WHERE id = '".$_GET['modifier_valide']."'";
	mysql_query($sql);
	echo 'Modification reussi !';
	header("Refresh: 2; url=param.php");
}
ob_flush(); 
?>