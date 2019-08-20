<?php
/* Programme : library_general_update.php
* Description : Fonction de mise à jour
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
*/

/**********************************************************************************************
Table des matières des functions
___________________________

function update_client()
function update_client_password($pass)
function update_certificat($id_produit, $prix)
function update_vente( $NoId, $Paiement )
function update_stock( $TabInfo )

**********************************************************************************************/

// ~~~~~~~~~~~~~~ DEBUT FUNCTIONS DE *UPDATE ~~~~~~~~~~~~~~~~

function update_client()
//  FUNCTION : update_client
//  version : 1.0
//  date : 21-11-04
//  derniere modif : Maxime Dupuis
//  info : Met à jour les variables de la BD : clients
{
global $handle,$database;

		if(!isset($_POST)) {
			echo "Impossible de mettre à jour les informations du client.<br>";  
			return 0;
		}


		extract( $_POST, EXTR_OVERWRITE );
		if( strlen($TelCodR) || strlen($TelP1) || strlen($TelP2) ) {
			if( strlen($TelCodR) )
				$Telephone = "(".$TelCodR.")".$TelP1."-".$TelP2;
			else
				$Telephone = $TelP1."-".$TelP2;
		}
		else
			$Telephone = "";
			
		// Courriel='$Courriel',
		// on met à jour les infos du clients
		$sql =  "UPDATE  $database.client SET Nom='$Nom', Prenom='$Prenom', Contact='$Contact', Rue='$Rue', Indication='$Indication',"; 
		$sql .=  "Quartier='$Quartier', Ville='$Ville',Province='$Province', Pays='$Pays',CodePostal='$CodePostal',";
		$sql .=  "Telephone='$Telephone',Fax='$Fax', Cellulaire='$Cellulaire', Courriel='$Courriel',"; 
		$sql .=  "Message='$Message', Langue= '$Langue',";
		$sql .=  "Identite='$Identite',Debit='$Debit' WHERE NoClient = '$NoClient'";
		//AfficherErreur( $sql );
		if( !mysql_query( $sql, $handle ) )
		      	AfficherErreur("ERREUR : ".mysql_errno().": ".mysql_error());
		mysql_close($handle);
		$Mess = "Modification du client $NoClient";
		Suivi_log($Mess, $NoClient);

		return 1;
} // fin de la fonction : update_client 

function update_client_password($pass)
//  FUNCTION : update_client_password
//  version : 1.0
//  date : 21-11-04
//  derniere modif : Maxime Dupuis
//  info : Met à jour les variables de la BD : clients
{

		$query = "UPDATE clients set password = \"".$pass."\" WHERE id = ".$_SESSION[$_SERVER['SERVER_NAME']].";";
		$query = mysql_query($query) 
			or die("Impossible de mettre à jour les informations du client. ".mysql_error());  

		return 1;

} // fin de la fonction : update_client_password 

function update_certificat($id_produit, $prix)
//  FUNCTION : update_certificat
//  version : 1.0
//  date : 2007-10-29
//  derniere modif : Denis Léveillé
//  info : Maj du prix du certificat
{
global $handle, $mysql_base;
	$date			= mktime();
	$sql = "UPDATE $mysql_base.stock set prix_detail = '$prix', MAJ = '$date' WHERE id = '$id_produit';";
	$result = mysql_query($sql, $handle) 
		or die("Erreur à la MAJ de certificat: ".mysql_error());
} // fin de la fonction : update_certificat 


function update_vente( $NoId, $Paiement )
//  FUNCTION : update_vente
//  version : 1.0
//  date : 2007-12-08
//  derniere modif : Denis Léveillé
//  info : Maj du paiement de la vente
{
global $handle, $mysql_base, $Now;
	
/*	if(@$Paiement['Complet'])
		$Etat = 1;
	else
		$Etat = 5;
	
	$sql = "UPDATE $mysql_base.ventes SET Etat='$Etat', ModePaye='".$Paiement['ModePaye']."',";*/
	$sql = "UPDATE $mysql_base.ventes SET ModePaye='".$Paiement['ModePaye']."',";
	$sql .= " NoDoc= '".@$Paiement['reference']."',";
	$sql .= " ExpMois= '".@$Paiement['trnExpMonth']."', ExpAn= '".@$Paiement['trnExpYear']."',";
	$sql .= " Detenteur= '".@$Paiement['detenteur']."', NoConf= '".@$Paiement['TrsId']."',";
	$sql .= " Paye='".@$Paiement['Complet']."', NoEcr='".@$_SESSION['NoEcr']."', NoTrans='".@$_SESSION['NoTrans']."' WHERE id='$NoId';";

//echo $sql;
	mysql_query($sql, $handle ) 
		or die("Impossible de mettre à jour les informations de VENTE. ".mysql_error()); 
	
	$Mess = "Paiement Facture $NoId";
	Suivi_log($Mess, $NoId);

} // insert_vente

function update_stock( $TabInfo )
//  FUNCTION : update_vente
//  version : 1.0
//  date : 2007-12-08
//  derniere modif : Denis Léveillé
//  info : Maj du paiement de la vente
{
global $handle, $mysql_base, $Now;
	
	extract( $TabInfo, EXTR_OVERWRITE );
	
$titre_fr = stripslashes($titre_fr );
$titre_en = stripslashes($titre_en );
$titre_sp = stripslashes($titre_sp );
$description_fr = stripslashes($description_fr ); 
$description_en = stripslashes($description_en );
$description_sp = stripslashes($description_sp );
$description_supplementaire_fr = stripslashes($description_supplementaire_fr ); 
$description_supplementaire_en = stripslashes($description_supplementaire_en );
$description_supplementaire_sp = stripslashes($description_supplementaire_sp );

$titre_fr = myAddSlashes($titre_fr );
$titre_en = myAddSlashes($titre_en );
$titre_sp = myAddSlashes($titre_sp );
$description_fr = myAddSlashes($description_fr ); 
$description_en = myAddSlashes($description_en );
$description_sp = myAddSlashes($description_sp );
$description_supplementaire_fr = myAddSlashes($description_supplementaire_fr ); 
$description_supplementaire_en = myAddSlashes($description_supplementaire_en );
$description_supplementaire_sp = myAddSlashes($description_supplementaire_sp );
/*$titre_fr = htmlspecialchars($titre_fr, ENT_QUOTES );
$titre_en = htmlspecialchars($titre_en, ENT_QUOTES );
$titre_sp = htmlspecialchars($titre_sp, ENT_QUOTES );
echo <<<END
$titre_fr
<br>
END;*/
	$date			= mktime();
	$prix_detail = sprintf("%8.2f",$prix_detail);
	$prix_promo = sprintf("%8.2f",$prix_promo);
	$sql =  "UPDATE $mysql_base.stock SET Code='$Code', online='$online', titre_fr='$titre_fr', titre_en='$titre_en', titre_sp='$titre_sp',";  
	$sql .=  " prix_detail='$prix_detail', prix_promo='$prix_promo', Cout='$Cout', Markup='$Markup', Douane='$Douane',";   
	$sql .=  " weight='$weight', width='$width', height='$height',"; 
	$sql .=  " Secteur_Limite='$Secteur_Limite',Qte_Max_Livre='$Qte_Max_Livre',"; 
	$sql .=  " QteStock='$QteStock',QteDOA='$QteDOA',Provenance='$Provenance',"; 
	$sql .=  " description_fr='$description_fr', description_en='$description_en', description_sp='$description_sp',"; 
	$sql .=  " description_supplementaire_fr='$description_supplementaire_fr',";   
	$sql .=  " description_supplementaire_en='$description_supplementaire_en',";  
	$sql .=  " description_supplementaire_sp='$description_supplementaire_sp',"; 							
	$sql .=  " small='$small', medium='$medium', big='$big', MAJ='$date' WHERE id = '$id'"; 							

	mysql_query($sql, $handle ) 
		or die("Impossible de mettre à jour les informations de l'INVENTAIRE. ".mysql_error()); 
	
	$Mess = "MAJ InventaireFacture $id";
	Suivi_log($Mess, $id);

} // insert_stock


?>