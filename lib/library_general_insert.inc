<?php
//* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
//* MAJ : Denis Léveillé 	 			  Date : 2007-12-21

// DEBUT FUNCTIONS DIVERS --


/**********************************************************************************************
Table des matières des functions
___________________________
function insert_client()
function Insert_vente( $NoClient, $Destinataire, $Panier, $Totaux, $Paiement )
function insert_stock( $TabInfo )
**********************************************************************************************/

// ~~~~~~~~~~~~~~ DEBUT FUNCTIONS DE *INSERT ~~~~~~~~~~~~~~~~
function insert_client()
//-------------------------------------------------------------------------------------------------
//  FUNCTION : insert_client
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2007-11-01
//  derniere modif : Denis Léveillé
//  info : Insere les variables de la BD : clients
{
global $handle,$database, $PrioCompte, $txt, $Now;

	if( !isset($_POST) ) {
		echo "Impossible d'ajouter les informations du client.<br>";  // on met à jour les infos du clients
		return 0;
	}


	if( !isset($_SESSION[$_SERVER['SERVER_NAME']]) ){
		$sql = "SELECT mPasse FROM $database.secur WHERE NomLogin = '".$_POST['Courriel']."'";
		$result = mysql_query( $sql, $handle );
		if(  $result && mysql_num_rows( $result ) ) {
			$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
			extract($ligne);
			echo "<font size='+1' face ='verdana' color='#CF0630'>&nbsp;&nbsp;&nbsp;&nbsp;".$txt['courriel_existant']."</font>";
			return 0;
		} // Si pas d'erreur de recherche
	} // Si pas de client logger					
	extract( $_POST, EXTR_OVERWRITE );
	if( strlen($TelCodR) || strlen($TelP1) || strlen($TelP2) ) {
		if( strlen($TelCodR) )
			$Telephone = "(".$TelCodR.")".$TelP1."-".$TelP2;
		else
			$Telephone = $TelP1."-".$TelP2;
	}
	else
		$Telephone = "";
			
	if( $_SESSION['Prio'] > $PrioCompte )
		$NoClient = "";  	
				  
	$sql =  "INSERT INTO  $database.client SET NoClient = '@$NoClient', Nom='$Nom', Prenom='$Prenom',";
	$sql .=  " Contact='$Contact', Rue='$Rue', Indication='$Indication', Quartier='$Quartier',"; 
	$sql .=  " Ville='$Ville', Province='$Province', Pays='$Pays', CodePostal='$CodePostal',";
	$sql .=  " Telephone='$Telephone',Fax='$Fax', Cellulaire='$Cellulaire', Courriel='$Courriel',"; 
	$sql .=  " TypCli='$TypCli', Refere='$Refere', DateInscrip='$DateInscrip', DateRappel='$DateRappel',";
	$sql .=  " CoteCredit='$CoteCredit', Message='$Message', Langue= '$Langue', TPSApp='$TPSApp', TVQApp='$TVQApp',";
	$sql .=  " Profession='$Profession', MaxCredit='$MaxCredit', Identite='$Identite', Debit='$Debit', DevCli='$DevCli', Naissance='$Naissance';";
		
	mysql_query($sql, $handle )		
		or die( mysql_errno().' Customer ERROR : '.mysql_error() );
		
	$id_client = mysql_insert_id( $handle );
	
	
		// **** ON LAISSE UNE TRACE DE L'OPÉRATION

		$Mess = "Ajout Client $id_client";
		Suivi_log($Mess, $id_client);
	
	return $id_client;


} // info_client

function Insert_vente( $NoClient, $Destinataire, $Panier, $Totaux, $Paiement )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Insert_vente
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2007-11-01
//  derniere modif : Denis Léveillé
//  info : Insere les variables de la BD : ventes ET ventes_articles
{
global $handle, $mysql_base, $handle,$database, $Now;

	$id_vente = 0;
	$tx1 = $tx2 = 0; 
//	$date			= mktime();
	
	if( $Totaux['devise'] == 'CUC' ){
		$STotal = $Totaux['SousTotalCUC'];
		$Livraison = $Totaux['LivraisonCUC'];
		$Total =  $Totaux['TotalCUC'];
		$Taux = 0;
	}
	elseif( $Totaux['devise'] == 'USD' ){
		$STotal = $Totaux['SousTotalUSD'];
		$Livraison = $Totaux['LivraisonUSD'];
		$Total =  $Totaux['TotalUSD'];
		$Taux = $Totaux['TXCUC_USD'];
	}
	elseif( $Totaux['devise'] == 'EUR' ){
		$STotal = $Totaux['SousTotalEUR'];
		$Livraison = $Totaux['LivraisonEUR'];
		$Total =  $Totaux['TotalEUR'];
		$Taux = $Totaux['TXUSD_EUR'];
	}
	else{
		$STotal = $Totaux['SousTotalCAD'];
		$Livraison = $Totaux['LivraisonCAD'];
		$Total =  $Totaux['TotalCAD'];
		$Taux = $Totaux['TXUSD_CAD'];
	}
	
	if( !isset($_SESSION['paiement']['trnCardNumber']) ) {
		$_SESSION['paiement']['trnCardNumber'] = '';
		$_SESSION['paiement']['trnExpMonth']	= '';
		$_SESSION['paiement']['trnExpYear']		= '';
		$_SESSION['paiement']['detenteur']		= '';
	}
	
	
	$query = "INSERT INTO $database.ventes SET id_client='$NoClient', Date='".$_SESSION['Totaux']['DateFacture']."', Etat='5',";
	$query .= " Liv_nom= '".$Destinataire['livraison_nom']."',Liv_prenom= '".$Destinataire['livraison_prenom']."',";
	$query .= " Liv_contact= '".$Destinataire['livraison_contact']."',Liv_rue= '".$Destinataire['livraison_rue']."',";
	$query .= " Liv_indication= '".$Destinataire['livraison_indication']."',Liv_quartier= '".$Destinataire['livraison_quartier']."',";
	$query .= " Liv_ville= '".$Destinataire['livraison_ville']."',Liv_province= '".$Destinataire['livraison_province']."',";
	$query .= " Liv_pays= '".$Destinataire['livraison_pays']."',Liv_codepostale= '".$Destinataire['livraison_codepostal']."',";
	$query .= " Liv_courriel= '".$Destinataire['livraison_courriel']."',Liv_telephone= '".$Destinataire['livraison_telephone']."',";
	$query .= " TxCubain= '".$Totaux['TXCUC_USD']."',sous_total= '$STotal', frais_Livraison= '$Livraison', taxes1= '0', taxes2= '0', total= '$Total',"; 
	$query .= " DevAchat= '".$Totaux['devise']."', TxChgAchat= '$Taux', DevPaye= 'CAD', TxChgPaye= '".$Totaux['TXUSD_CAD']."',"; 
	$query .= " Charged= '".$Totaux['totalpourbanque']."', ModePaye='".$Paiement['ModePaye']."',";
	$query .= " NoDoc= '".substr($Paiement['trnCardNumber'],0,4)."XXXXXXXX".substr($Paiement['trnCardNumber'],12)."',";
	$query .= " ExpMois= '".@$Paiement['trnExpMonth']."', ExpAn= '".@$Paiement['trnExpYear']."',";
	$query .= " Detenteur= '".@$Paiement['detenteur']."', NoConf= '".@$Paiement['TrsId']."', trnId='".@$Paiement['BankCode']."',Paye='".@$Paiement['Complet']."';";

//echo $query;
	$query = mysql_query($query, $handle ) 
		or die("Impossible de mettre à jour les informations de la vente. ".mysql_error());  // on met à jour les infos du clients
	
	$id_vente = mysql_insert_id($handle);
	
	foreach( $Panier as  $Pid =>  $item){
		$infos_prod = get_prod_infos_by_id($Pid);
		$titre = "titre_".$_SESSION['langue'];
		$prix = ( $infos_prod['prix_promo'] != 0 ) ? $infos_prod['prix_promo'] : $infos_prod['prix_detail'];
		$query = "INSERT INTO $database.ventes_articles ( id_vente, id_produit, quantite, prix_unitaire, taxes_unitaire1, taxes_unitaire2 )";
		$query .= " VALUES ( '$id_vente', '$Pid', '".$item['Qte']."', '$prix', '$tx1', '$tx2' );";
		//echo $query;
		$query = mysql_query($query, $handle ) 
			or die("Impossible de mettre à jour les informations de la vente1. ".mysql_error());  // on met à jour les infos du clients
	}
	$infosClient = infos_client($NoClient);
	$infosClient['DernAchat'] = $_SESSION['Totaux']['DateFacture'];   
	$infosClient['AchatAnnuel'] +=  $Total;
	
	
	$sql =  "UPDATE  $database.client SET DernAchat='".$infosClient['DernAchat']."',";
	$sql .= "AchatAnnuel='".$infosClient['AchatAnnuel']."' WHERE NoClient = '".$infosClient['NoClient']."'";
	mysql_query( $sql, $handle )		      	
			or die("MAJ Client Impossible ajout vente. ".mysql_error());  // on met à jour les infos du clients
	mysql_query( $sql, $handle );
	// **** ON LAISSE UNE TRACE DE L'OPÉRATION
	$Mess = "Ajout Facture $id_vente";
	Suivi_log($Mess, $id_vente);

	return $id_vente;

} // insert_vente

// ~~~~~~~~~~~~~~ DEBUT FUNCTIONS DE *INSERT ~~~~~~~~~~~~~~~~
function insert_stock( $TabInfo )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : insert_stock
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2007-11-01
//  derniere modif : Denis Léveillé
//  info : Insere les variables de la BD : clients
{
global $handle, $database, $Now;

	if( !$TabInfo ) {
		echo "Can't add to the Inventory.<br>";  // on met à jour les infos du clients
		return 0;
	}


	extract( $TabInfo, EXTR_OVERWRITE );
	$prix_detail = sprintf("%8.2f",$prix_detail);
	$prix_promo = sprintf("%8.2f",$prix_promo);
	$titre_fr = myAddSlashes($titre_fr );
	$titre_en = myAddSlashes($titre_en );
	$titre_sp = myAddSlashes($titre_sp );
	$description_fr = myAddSlashes($description_fr ); 
	$description_en = myAddSlashes($description_en );
	$description_sp = myAddSlashes($description_sp );
	$description_supplementaire_fr = myAddSlashes($description_supplementaire_fr ); 
	$description_supplementaire_en = myAddSlashes($description_supplementaire_en );
	$description_supplementaire_sp = myAddSlashes($description_supplementaire_sp );
	
	$sql =  "INSERT INTO $database.stock SET Code='$Code', online='$online', titre_fr='$titre_fr', titre_en='$titre_en', titre_sp='$titre_sp',";  
	$sql .=  " prix_detail='$prix_detail', prix_promo='$prix_promo', Cout='$Cout', Markup='$Markup', Douane='$Douane',";  
	$sql .=  " weight='$weight', width='$width', height='$height',"; 
	$sql .=  " Secteur_Limite='$Secteur_Limite',Qte_Max_Livre='$Qte_Max_Livre',"; 
	$sql .=  " QteStock='$QteStock',QteDOA='$QteDOA',Provenance='$Provenance',"; 
	$sql .=  " description_fr='$description_fr', description_en='$description_en', description_sp='$description_sp',"; 
	$sql .=  " description_supplementaire_fr='$description_supplementaire_fr',";   
	$sql .=  " description_supplementaire_en='$description_supplementaire_en',";  
	$sql .=  " description_supplementaire_sp='$description_supplementaire_sp',"; 							
	$sql .=  " small='$small', medium='$medium', big='$big', DateAjout='$Now', MAJ='$Now'"; 
		
        if( !mysql_query($sql, $handle) ) 	
		return( 0 );
		
	$NoId = mysql_insert_id( $handle );
	
	
	// **** ON LAISSE UNE TRACE DE L'OPÉRATION

	$Mess = "Ajout Stock $NoId";
	Suivi_log($Mess, $NoId);
	
	return $NoId;


} // insert_stock


?>