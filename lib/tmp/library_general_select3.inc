<?php
/* Programme : library_general_select.php
* Description : Diverse fonction
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
*/

/*Table des matières des functions

1b - SELECT from textes
1c - SELECT from clients (par id)
1d - SELECT from clients  (tous)
1e - SELECT from pays (par id)
1f - SELECT from pays (abréviation)
1g - SELECT from pays (la liste complète)
1h - SELECT from provinces (la liste complète)
1i - SELECT from provinces  (par id)
1j - SELECT from provinces (abréviation)
1k - SELECT from ventes et vente_articles avec ou sans filtres
1l - SELECT from produits et produits_infos
1m - SELECT from employes (tous ou par id)
1n - SELECT from vente et vente_articles selon un ID de vente
1o = SELECT from produits selon un Id de catalogue
1p - SELECT from catalogue_arborescence LEFT JOIN catalogue_noms Va chercher les catégories primaire
1q - SELECT from catalogue_arborescence LEFT JOIN catalogue_noms Sélectionne les sous_catégories directes à la catégorie passée en paramètre
1r - SELECT from catalogue_arborescence retourne le chemin (les id des parents) jusqu'à la catégorie donnée en paramètre initial
1s - SELECT from catalogue_arborescence retourne le/les nom(s) par d'une/des catégorie(s) selon leur ID
1t - SELECT from produits Affiche le nom et la descript des produits d'une catégorie pour la SUPRESSION
1u - SELECT from produits Affiche le nom et la descript des produits d'une catégorie pour la MODIFICATION
1v - SELECT from ventes_articles - top 10
1w - SELECT from ventes_articles - ceux qui ont achetés
1x - SELECT from stock - un certificat de libre
1y - SELECT from employes_permissions pour recupérer les permissions de l'employé loggé
1z - SELECT from catalogue_arborescence pour faire un listing des cats avec checkboxes
10h - selectionProduits($idCat=0, $idProduit=0) -  info : sélectionne les produits contenus dans une catégorie OU les infos d'un produit selon son ID passé en paramètre 2
*/

function get_params($url_rech=0)
//  FUNCTION : get_params - 1a
//  version : 1.0
//  date : 16-11-04
//  derniere modif : Maxime Dupuis
//  info : retourne les paramètres de configuration tels qu'édités par le client
{
global $handle, $mysql_base, $entr_url;

//	echo "Rech 1 =".$url_rech."<br>";
	if( strlen($url_rech) < 5 ) 
		$url_rech = $_SERVER['HTTP_HOST'];
		
	$sql = "SELECT * FROM $mysql_base.parametre WHERE url LIKE '%$url_rech%' LIMIT 1;";
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_params", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	if( mysql_num_rows($result) ) {
		$params = mysql_fetch_assoc($result);
		mysql_free_result($result);
	}
	else
		$params = array();
	
	return $params;
} // fin de la fonction : get_params 

function textes($lang)
//  FUNCTION : textes - 1b
//  version : 1.0
//  date : 28-09-04
//  derniere modif : Maxime Dupuis
//  info : Selectionne les variables de la BD : textes selon la langue
{
global $handle, $mysql_base;
		
	$sql = "SELECT * FROM $mysql_base.messages WHERE Langue = '$lang' LIMIT 1;";
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès textes", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	if( mysql_num_rows($result) ){
		$results = mysql_fetch_assoc($result);
		mysql_free_result($result);
	}
	else
		$results = array();
	
	return $results;

} // fin de la fonction : textes -

function frais_livraison_get($total, $Source=1)
//  FUNCTION : frais_livraison_get - 11h
//  date : 2007-11-05
//  derniere modif : Denis Léveillé
//  info : Trouver le frais de livraison pour un montant donner
{
global $handle, $mysql_base;
 
	$frais = 0;
   if( $total ) {     
		$sql = "SELECT frais FROM $mysql_base.frais_livraison WHERE (montant > $total) AND (Provenance = $Source) LIMIT 1;";
		
		$result = mysql_query( $sql, $handle );
		if( !$result )
			Message_Erreur( "ERROR", "Erreur accès frais_livraison_get", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
		
		$result = mysql_fetch_assoc($result);
		$frais = $result['frais'];
	}

   return($frais);
} // fin de la fonction : frais_livraison_get

function password_get($id)
//  FUNCTION : password_get - 12h
//  date : 2007-11-05
//  derniere modif : Denis Léveillé
//  info : Trouver le frais de livraison pour un montant donner
{
global $user,$host,$password,$database;

	// **** CONNECTION AU SERVEUR
	$Connection = mysql_connect( $host, $user, $password ) 		
		or	die("Erreur Connect password :: ".mysql_error());

	$db = mysql_select_db( $database, $Connection )
		or	die("Erreur Select password :: ".mysql_error());
	
	$pass = "";
	$sql = "SELECT mPasse FROM $database.secur WHERE NomLogin = '$id'";
	$result = mysql_query( $sql, $Connection )
		or	die("Erreur recherche password :: ".mysql_error());
		
   if( mysql_num_rows($result) ) {
		$infopass = mysql_fetch_assoc($result);
		$pass = $infopass["mPasse"];
	}
//	mysql_close($Connection);
   return($pass);
} // fin de la fonction : password_get

function infos_client($id)
//  FUNCTION : infos_client - 1c
//  version : 1.0
//  date : 28-09-04
//  derniere modif : Maxime Dupuis
//  info : Selectionne les variables de la BD : clients, un seul ou tous
{
global $user,$host,$password,$database;

		// **** CONNECTION AU SERVEUR
		if( !($Connection = mysql_connect( $host, $user, $password )) ) {
			$Message = mysql_errno().$TabMessGen[30].mysql_error();
			AfficherErreur($Message);
		} // Connection au serveur			   
		if( !($db = mysql_select_db( $database, $Connection )) ) {
			$Message = mysql_errno().$TabMessGen[31].mysql_error();
			AfficherErreur($Message);
		} // Selection de la BD


		$query = "SELECT * FROM $database.client WHERE NoClient ='$id' LIMIT 1;";
		$query = mysql_query($query, $Connection ) 
			or die(mysql_error());
		
		// si aucune données
		if(mysql_num_rows($query) != false) {
			$results = mysql_fetch_assoc($query);
			mysql_free_result($query);
		}
		else
			$results = array();
		
//		mysql_close($Connection);

		return $results;
	
} // fin de la fonction : infos_client -

function dest_client($id)
{
global $user,$host,$password,$database;
$tab = array();

		// **** ON LAISSE UNE TRACE DE L'OPÉRATION
		// **** CONNECTION AU SERVEUR
		$Connection = mysql_connect( $host, $user, $password )
			or die( mysql_errno().$TabMessGen[30].mysql_error() );
		$db = mysql_select_db( $database, $Connection )
			or die( mysql_errno().$TabMessGen[31].mysql_error() );

		$sql = "SELECT * FROM $database.destinataire WHERE Envoyeur = '$id' LIMIT 1;";
		$result = mysql_query( $sql, $Connection )
			or die( mysql_errno().$TabMessGen[50].mysql_error() );
		
		if (  mysql_num_rows($result) != 0 ) {
			$row = mysql_fetch_row($result);
			$sql = "SELECT * FROM $database.client WHERE NoClient ='$row[1]' LIMIT 1;";
			$result = mysql_query($sql, $Connection )
				or die( mysql_errno().$TabMessGen[50].mysql_error() );
			if( mysql_num_rows($result) != 0 ) {
				$tab = mysql_fetch_assoc($result);
				mysql_free_result($result);
			}
		}
//		mysql_close($Connection);
		

		return $tab;
	
} // fin de la fonction : infos_client -

function infos_client_all()
//  FUNCTION : infos_client_all - 1d
//  version : 1.0
//  date : 28-09-04
//  derniere modif : Daniel de Varennes
//  info : Selectionne les variables de la BD : clients, un seul ou tous
{

		// **** CONNECTION AU SERVEUR
		$Connection = mysql_connect( $host, $user, $password )
			or die( mysql_errno().$TabMessGen[30].mysql_error() );
		$db = mysql_select_db( $database, $Connection )
			or die( mysql_errno().$TabMessGen[31].mysql_error() );
		$query = "SELECT * FROM $database.client";
	   $query = mysql_query($query, $handle ) 
		 	or die("Erreur à la sélection d'employés :: ".mysql_error());
//		mysql_close($Connection);
	
	    return $query;
	
} // fin de la fonction : infos_client_all  


function get_prod_infos_by_id($id)
//  FUNCTION : get_prod_infos_by_id - 1j
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : retourne les infos d'un produit selon son ID
{
global $handle, $mysql_base;
	$infos = array();
	
	$sql = "SELECT * FROM $mysql_base.stock WHERE id='$id' LIMIT 1;";
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_params", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	
	if( mysql_num_rows($result) > 0 ) {
		$result = mysql_fetch_assoc($result);
		foreach($result as $column => $value)
			$infos[$column] = $value;
	}
	
	
	return $infos;
} // fin de la fonction : get_prod_infos_by_id-
                                                                                               
function get_all_products($id=0)
//  FUNCTION : get_all_products 1l
//  version : 1.0 
//  date : 03-12-04
//  derniere modif : Daniel de Varennes
//  info : Selectionne les variables de la BD : produits et prouits_infos et retourne TOUTES les produits
{
global $handle, $mysql_base;
	$sql = "SELECT * FROM $mysql_base.stock ";
	if( $id != 0 )
		$sql .= " WHERE id=$id;";
	else
		$sql .= " WHERE online = '1';";

	$result = mysql_query( $sql, $handle );
    if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_all_products", mysql_errno()." : ".mysql_error()."<br>".$sql );			
 	
	return $result;
} // fin de la fonction : get_all_products 

function get_certificat_libre($id_produit)
//  FUNCTION : get_certificat_libre - 1x
//  version : 1.0
//  date : 2007-10-29
//  derniere modif : Denis Léveillé
//  info : Trouver un numéro de certificat cadeau de libre
{
global $handle, $mysql_base;
	$Ret = 1;
	$date			= mktime();
	$aujourdhui = date("Y-m-d H:i:s", $date );
//	echo "Date : ".$aujourdhui."<br>";

	$sql = "SELECT * FROM $mysql_base.stock  WHERE id < $id_produit;";
	
	$result = mysql_query( $sql, $handle );
    if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_certificat_libre", mysql_errno()." : ".mysql_error()."<br>".$sql );			

	while( $item = mysql_fetch_assoc($result) ) {
		$datelut = date("Y-m-d H:i:s", $item['MAJ'] );
//		echo "No : ".$item['id']." Lut : ".$datelut."<br>";
		if( $item['MAJ'] < ($date - 3600) ) {
			$sql = "UPDATE $mysql_base.stock set MAJ = '$date' WHERE id = '".$item['id']."';";
			$result = mysql_query( $sql, $handle );
			if( !$result )
				Message_Erreur( "ERROR", "Erreur accès MAJ de certificat", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
			$Ret = $item['id'];
			break;
		} // si date valide
	} // tant que des certificats
	
	return($Ret);
} // fin de la fonction : get_certificat_libre

function selectionProduits($idCat=0, $idProduit=0, $online=0, $page = 0, $parPage = 0)
//  FUNCTION : selectionProduits - 10h
//  version : 2.0
//  date : 04-10-04
//  derniere modif : Maxime Dupuis
//  info : sélectionne les produits contenus dans une catégorie OU
//         les infos d'un produit selon son ID passé en paramètre 2
{
global $handle, $mysql_base;
  	$sql = "SELECT DISTINCT * FROM $mysql_base.stock";
	$sql .= " LEFT JOIN $mysql_base.catalogue_produits ON id = $mysql_base.catalogue_produits.id_produit";
	$sql .= " WHERE $mysql_base.catalogue_produits.id_catalogue = '$idCat'"; // AND Qte_Max_Livre > 0";

    if( $idProduit )
        $sql .= " AND id =$idProduit LIMIT 1";

    if( $online )
        $sql .= " AND online = '1'";

    if( $parPage ){
        $min = $page*$parPage-$parPage;
        if($min < 1)
            $min = 0;
        $sql .= " LIMIT $min,$parPage ";
    }

    $sql .= " ORDER BY prix_detail ASC;";
//echo $sql."<br>";
    $result = mysql_query($sql, $handle);
    if( !$result )
		Message_Erreur( "ERROR", "Erreur accès selectionProduits", mysql_errno()." : ".mysql_error()."<br>".$sql );			

	// si aucune données
	if( !mysql_num_rows($result) )
		return false;
	else   // sinon retour des valeurs
		return $result;
} // fin de la fonction : selectionProduits 

function check_prod_into_cat($id)
//  FUNCTION : check_prod_into_cat
//  version : 1.0
//  date : 27-11-04
//  derniere modif : Maxime Dupuis
//  info : Regarde si des produits sont présents dans une catégorie ou non
{
global $handle, $mysql_base;

	$sql = "SELECT * FROM $mysql_base.catalogue_produits WHERE $mysql_base.catalogue_produits.id_catalogue =$id;";
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès check_prod_into_cat", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
	
	return( mysql_num_rows($result) != 0 );

} // fin de la fonction : check_prod_into_cat 

function check_prod_into_cat_complete($id)
//  FUNCTION : check_prod_into_cat_complete
//  version : 1.0
//  date : 27-11-04
//  derniere modif : Maxime Dupuis
//  info : Regarde si des produits sont presents dans une categorie ou Sinon dans ses sous-catÈgories
{

    if( check_prod_into_cat($id) )
        return true;
    else{
        $sousCats = get_subcats($id);

        foreach( $sousCats as $id_cat => $nom_cat ){
            if( check_prod_into_cat_complete($id_cat) )
                return true;
        }
      	return false;
    }
} // fin de la fonction : check_prod_into_cat_complete 


function get_first_cats($online = 0)
//  FUNCTION : get_first_cats - 1p
//  version : 1.0
//  date : 16-10-04
//  derniere modif : Maxime Dupuis
//  info : Va chercher les catégories primaire dans la table selon la langue
{
global $handle, $mysql_base;
	$firstCats = array();
	
	$sql = "SELECT * FROM $mysql_base.catalogue WHERE parent = 0";
	
	if( $online ) 
		$sql .= " AND online = $online";

	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get-first-cats", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
	
	while($r = mysql_fetch_assoc($result))
		$firstCats[$r['id']] = $r[$_SESSION['langue']];
	
	return $firstCats;
} // fin de la fonction : get_first_cats -------------------------------------------

function get_count_cats($upCat)
//  FUNCTION : get_subcats  - 1q
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
 global $handle, $mysql_base;
	$sql = "SELECT id FROM $mysql_base.catalogue WHERE parent ='$upCat' AND online = '1';";
	$Total = 0;
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_subcats", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	while( $r = mysql_fetch_assoc($result) ) {
		$sql = "SELECT COUNT(*) FROM $mysql_base.catalogue_produits WHERE $mysql_base.catalogue_produits.id_catalogue =".$r['id'];
		$result = mysql_query( $sql, $handle );
		if( !$result )
			Message_Erreur( "ERROR", "Erreur accès check_prod_into_cat", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
		$Resultat = mysql_fetch_row($result);
		$Total += $Resultat[0];
	}	
	return( $Total );
} // get_count_cats

function get_subcats($upCat, $online = 0)
//  FUNCTION : get_subcats  - 1q
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
 global $handle, $mysql_base;
   $categories = array();

	$sql = "SELECT id, ".$_SESSION['langue']." AS titre_cat FROM $mysql_base.catalogue WHERE parent ='$upCat'";

	if( $online ) 
		$sql .= " AND online = $online";
		
	$sql .=' ORDER BY ordre ASC, '.$_SESSION['langue'].' ASC;';
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_subcats", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	while( $r = mysql_fetch_assoc($result) )
		$categories[$r['id']] = $r['titre_cat'];
	
	return $categories;
} // fin de la fonction : get_subcats ----------------------------------------------------------


function get_cat_path($id)
//  FUNCTION : get_cat_path - 1r
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : retourne le chemin (les id des parents) jusqu'à la catégorie donnée en paramètre initial
{
global $handle, $mysql_base;
	
	$path = array();

	$sql = "SELECT parent FROM $mysql_base.catalogue WHERE id=$id;";
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_cat_path", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
	if ($row['parent'] != 0) {
		$path[] = $row['parent'];
		$path = array_merge( get_cat_path($row['parent']), $path );
	}
	
	return $path;
} // fin de la fonction : get_cat_path --------------------------------------------


function get_cat_name_by_id($id)
//  FUNCTION : get_cat_name_by_id - 1s
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : retourne le/les nom(s) par d'une/des catégorie(s) selon leur ID
{
global $handle, $mysql_base;
	$sql = "SELECT ".$_SESSION['langue']." FROM $mysql_base.catalogue WHERE id =$id LIMIT 1;";
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get-cat-name-by-id", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
		
	$result = mysql_fetch_array($result, MYSQL_NUM);

    return $result[0];
} // fin de la fonction : get_cat_by_id -----------------------------------------------------------

function vente_get($id)
//  FUNCTION : vente_get
//  version : 1.0
//  date : 29-12-04
//  derniere modif : Maxime Dupuis
//  info : Selectionne les infos d'une vente
{
global $handle, $mysql_base;
	$infosVente = array();
	
	$query = "SELECT * FROM $mysql_base.ventes WHERE id=$id;";
	
	$select = mysql_query($query, $handle ) 
		or Message_Erreur( "ERROR", "Erreur à vente_get", mysql_errno()." : ".mysql_error()."<br>".$sql  );			
	
	$infosVente = mysql_fetch_assoc($select);
	
	$query = "SELECT * FROM $mysql_base.ventes_articles WHERE id_vente=$id;";
	$select = mysql_query($query, $handle ) 
		or Message_Erreur( "ERROR", "Erreur à vente_articles-get", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	$i = 1;
	while( $monArticle = mysql_fetch_assoc($select) )
		$infosVente['articles'][$i++] = 	$monArticle;
/*	$i = 1;
	while( $monArticle = mysql_fetch_assoc($select) )
	   foreach($monArticle as $colonne => $valeur)
	       $infosVente['articles'][$i++][$colonne] = $valeur;*/
	
	return($infosVente);
} // fin de la fonction : vente_get 

function produits_accueil( $id = 0 )
{
global $handle, $mysql_base;
	$select = "SELECT * FROM $mysql_base.produits_accueil";
	if( $id != 0 )
	  $select .= " WHERE id ='$id'";
	
	$select = mysql_query($select, $handle ) or 
		die("Erreur à la sélection produit acceuil :: ".mysql_error());
	
	if( $id != 0 )
		$select = mysql_fetch_assoc($select);
	
	return $select;
} // produits_accueil



?>