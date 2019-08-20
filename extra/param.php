<?php
include('connect.inc');

// Es-ce que l'usager à la priorité pour accéder cette fonction
if( @$_SESSION['Prio'] > $PrioAnnule ){
	header( "Location: mainfr.php");
	exit();
} // Si pas access autorisé

function allo(){
	
	$sql = "SELECT * FROM parametre ORDER BY id";
	$req = mysql_query($sql);
	while ($telech = mysql_fetch_array($req)) {
		$id = stripslashes($telech['id']);
		$nom = stripslashes($telech['nom_client']);
		echo "$id $nom  <a href='param.php?modifier=$id'><img src='jpeg/edit.gif'></a><br>";
	} 
} // allo

if (@$_GET['modifier_valide'] == ""){
/*	if (@$_GET['modifier'] == ""){
		allo();
	}
	else {
		$sql = "SELECT * FROM parametre WHERE id = '".$_GET['modifier']."'";*/
		$sql = "SELECT * FROM parametre WHERE id = '1'";
		$req = mysql_query($sql);
		if( $req ) 
			$telech = mysql_fetch_array($req);
			extract($telech,EXTR_OVERWRITE);			   

//		allo();
	echo "
	<html>
	<head>
		<title><?=$TabMessGen[69]?></title>
	<link title='hermesstyle' href='styles/stylegen.css' type='text/css rel=stylesheet'>
	</head>
	<script language='javascript1.2' src='js/mm_menu.js'></script>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>";
	switch( $_SESSION['SLangue'] ) {
			case "ENGLISH" :echo "<script language='JavaScript1.2' src='js/ldmenuen.js'></script>\n";
					break;
			case "SPANISH" :echo "<script language='JavaScript1.2' src='js/ldmenusp.js'></script>\n";
					break;
			default :	echo "<script language='JavaScript1.2' src='js/ldmenufr.js'></script>\n";
	}
	echo "
	<body bgcolor='#D8D8FF'>
	<script language='JavaScript1.2'>mmLoadMenus();addKeyEvent();</script>";

?>
		<form method="POST" action="param.php?modifier_valide=<?php echo $id; ?>">
			<div align="center">
			<input type="hidden" name="id" value="<?=$id ?>">
		
		<table border="1" width="70%" id="table1">
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['305']?> : </td>
			<td width="50%">
				<input type="text" name="nom_client" size="20" value="<?=$nom_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['306']?> : </td>
			<td width="50%">
				<input type="text" name="courriel_client" size="50" value="<?=$courriel_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['307']?> : </td>
			<td width="50%">
				<input type="text" name="adresse_client" size="20" value="<?=$adresse_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['308']?> : </td>
			<td width="50%">
				<input type="text" name="ville_client" size="20" value="<?=$ville_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['309']?> : </td>
			<td width="50%">
				<input type="text" name="codepostal_client" size="20" value="<?=$codepostal_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['310']?> : </td>
			<td width="50%">
				<input type="text" name="telephone_client" size="50" value="<?=$telephone_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['311']?> : </td>
			<td width="50%">
				<input type="text" name="fax_client" size="20" value="<?=$fax_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['312']?> : </td>
			<td width="50%">
				<input type="text" name="province_client" size="20" value="<?=$province_client ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['313']?> : </td>
			<td width="50%">
				<input type="text" name="pays_client" size="20" value="<?=$pays_client ?>">
			</td>
		</tr>
		<!-- tr>
			<td width="50%" align="right">
				<?=$TabMessGen['314']?> : </td>
			<td width="50%">
				<input type="text" name="www_client" size="50" value="<?=$www_client ?>">
			</td>
		</tr -->
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['315']?> : </td>
			<td width="50%">
				<input type="text" name="no_tps" size="20" value="<?=$no_tps ?>">
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['316']?> : </td>
			<td width="50%">
				<input type="text" name="no_tvq" size="20" value="<?=$no_tvq ?>">
			</td>
		</tr>
		<tr>
		<td width="50%" align="right"><?=$TabMessGen['317']?> : </td><td width="50%"><input type="text" name="tvq" size="20" value="<?=$tvq ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['318']?> : </td><td width="50%"><input type="text" name="tps" size="20" value="<?=$tps?>"></td></tr>
		<!-- tr><td width="50%" align="right"><?=$TabMessGen['319']?> : </td><td width="50%"><input type="text" name="mode_paiement_carte" size="20" value="<?=$mode_paiement_carte ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['320']?> : </td><td width="50%"><input type="text" name="mode_paiement_ligne" size="20" value="<?=$mode_paiement_ligne ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['321']?> : </td><td width="50%"><input type="text" name="mode_paiement_cheque" size="20" value="<?=$mode_paiement_cheque ?>"></td></tr -->
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['322']?> : </td>
			<td width="50%">
	         <select name="fr" size="1" class='s2'>
		         <option value="OUI" <?php if( $fr == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
		         <option value="NON" <?php if( $fr == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
	         </select>
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['323']?> : </td>
			<td width="50%">
	         <select name="en" size="1" class='s2'>
		         <option value="OUI" <?php if( $en == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
		         <option value="NON" <?php if( $en == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
	         </select>
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['324']?> : </td>
			<td width="50%">
	         <select name="sp" size="1" class='s2'>
		         <option value="OUI" <?php if( $sp == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
		         <option value="NON" <?php if( $sp == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
	         </select>
			</td>
		</tr>
		<tr><td width="50%" align="right">url_douane  : </td><td width="50%"><input type="text" name="url_douane " size="50" value="<?=$url_douane  ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['325']?> : </td><td width="50%"><input type="text" name="url" size="50" value="<?=$url ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['326']?> : </td><td width="50%"><input type="text" name="url_ssl" size="50" value="<?=$url_ssl ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['327']?> : </td><td width="50%"><input type="text" name="url_payeur" size="50" value="<?=$url_payeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['328']?> : </td><td width="50%"><input type="text" name="url_payeur_test" size="50" value="<?=$url_payeur_test ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['329']?> : </td><td width="50%"><input type="text" name="id_payeur" size="20" value="<?=$id_payeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['330']?> : </td><td width="50%"><input type="text" name="cle_payeur" size="20" value="<?=$cle_payeur ?>"></td></tr>
		<tr><td width="50%" align="right">email Comptes : </td><td width="50%"><input type="text" name="email_compte e" size="40" value="<?=$email_compte?>"></td></tr>
		<tr><td width="50%" align="right">email Envoi : </td><td width="50%"><input type="text" name="email_envoi " size="40" value="<?=$email_envoi?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['331']?> : </td><td width="50%"><input type="text" name="Email_facture" size="40" value="<?=$Email_facture ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['332']?> : </td><td width="50%"><input type="text" name="Email_commande" size="40" value="<?=$Email_commande ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['333']?> : </td><td width="50%"><input type="text" name="email_administration" size="40" value="<?=$email_administration ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['334']?> : </td><td width="50%"><input type="text" name="email_clientele" size="40" value="<?=$email_clientele ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['335']?> : </td><td width="50%"><input type="text" name="email_paquet" size="40" value="<?=$email_paquet ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['336']?> : </td><td width="50%"><input type="text" name="email_support" size="40" value="<?=$email_support ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['337']?> : </td><td width="50%"><input type="text" name="email_ventes" size="40" value="<?=$email_ventes ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['338']?> : </td><td width="50%"><input type="text" name="email_pharmacie" size="40" value="<?=$email_pharmacie ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['339']?> : </td><td width="50%"><input type="text" name="email_info" size="40" value="<?=$email_info ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['340']?> : </td><td width="50%"><input type="text" name="largeur_affichage" size="20" value="<?=$largeur_affichage ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['341']?> : </td><td width="50%"><input type="text" name="largeur_achat" size="20" value="<?=$largeur_achat ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['342']?> : </td><td width="50%"><input type="text" name="alignement" size="20" value="<?=$alignement ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['343']?> : </td><td width="50%"><input type="text" name="categorie_affichage" size="20" value="<?=$categorie_affichage ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['344']?> : </td><td width="50%"><input type="text" name="banque" size="20" value="<?=$banque ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['345']?> : </td><td width="50%"><input type="text" name="image_special_largeur" size="20" value="<?=$image_special_largeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['346']?> : </td><td width="50%"><input type="text" name="image_special_haut" size="20" value="<?=$image_special_haut ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['347']?> : </td><td width="50%"><input type="text" name="image_list_largeur" size="20" value="<?=$image_list_largeur ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['348']?> : </td><td width="50%"><input type="text" name="image_list_hauteur" size="20" value="<?=$image_list_hauteur ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['349']?> : </td><td width="50%"><input type="text" name="image_mid_height" size="20" value="<?=$image_mid_height ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['350']?> : </td><td width="50%"><input type="text" name="image_mid_weight" size="20" value="<?=$image_mid_weight ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['351']?> : </td><td width="50%"><input type="text" name="ventes" size="20" value="<?=$ventes ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['352']?> : </td><td width="50%"><input type="text" name="Transfert" size="20" value="<?=$Transfert ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['353']?> : </td><td width="50%"><input type="text" name="MaxTransfert" size="20" value="<?=$MaxTransfert ?>"></td></tr>
		<!-- tr><td width="50%" align="right"><?=$TabMessGen['354']?> : </td><td width="50%"><input type="text" name="client" size="20" value="<?=$clients ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['355']?> : </td><td width="50%"><input type="text" name="inventaire" size="20" value="<?=$inventaire ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['356']?> : </td><td width="50%"><input type="text" name="soumissions" size="20" value="<?=$soumissions ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['357']?> : </td><td width="50%"><input type="text" name="agenda" size="20" value="<?=$agenda ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['358']?> : </td><td width="50%"><input type="text" name="livraisons" size="20" value="<?=$livraisons ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['359']?> : </td><td width="50%"><input type="text" name="paiement_par_cheque" size="20" value="<?=$paiement_par_cheque ?>"></td></tr>
		<tr><td width="50%" align="right"><?=$TabMessGen['360']?> : </td><td width="50%"><input type="text" name="album_photos" size="20" value="<?=$album_photos ?>"></td></tr -->
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['361']?> : </td>
			<td width="50%">
	         <select name="panier_actif" size="1" class='s2'>
		         <option value="OUI" <?php if( $panier_actif == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
		         <option value="NON" <?php if( $panier_actif == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
	         </select>
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['362']?> : </td>
			<td width="50%">
	         <select name="path_show_main" size="1" class='s2'>
		         <option value="OUI" <?php if( $path_show_main == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
		         <option value="NON" <?php if( $path_show_main == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
	         </select>
			</td>
		</tr>
		<tr>
			<td width="50%" align="right">
				<?=$TabMessGen['363']?> : </td>
			<td width="50%">
	         <select name="scat_show_main" size="1" class='s2'>
		         <option value="OUI" <?php if( $scat_show_main == "OUI" ) echo 'SELECTED' ?>><?=$TabMessGen[200]?>
		         <option value="NON" <?php if( $scat_show_main == "NON" ) echo 'SELECTED' ?>><?=$TabMessGen[201]?>
	         </select>
			</td>
		</tr>
		</table>	
		<p><input type="submit" value="<?=$TabMessGen['364']?>" name="B1"></p>
		</div>
		
		</form>
</body>
</html>
<?php
//	}	 
}
else{
	extract($_POST,EXTR_OVERWRITE);	 
	$sql = "UPDATE parametre SET id ='".$_GET['modifier_valide']."', nom_client ='$nom_client',";
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
?>