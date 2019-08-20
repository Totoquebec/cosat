<?php
/* Programme : library_general_select.php
* Description : Diverse fonction
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
* MAJ : Denis Léveillé 	 			  Date : 2007-12-21
*/

/**********************************************************************************************
Table des matières des functions
___________________________

function get_prod_infos_by_id($id)
function get_all_products($id=0)
function get_certificat_libre($id_produit)
function selectionProduits($idCat=0, $idProduit=0, $online=0, $page = 0, $parPage = 0)
function check_prod_into_cat($id)
function check_prod_into_cat_complete($id)
function get_first_cats($online = 0)
function get_count_cats($upCat)
function get_count_sub_cats($Cat)
function get_subcats($upCat, $online = 0)
function get_cat_path($id)
function get_cat_name_by_id($id)
function vente_get($id)
function produits_accueil( $id = 0 )
function get_count_10best()
function ventes_get_all($date_avant, $date_apres, $id_produit, $id_client, $id_vendeur){


******************************************************************************************************/
function calcul_format_photo( &$LargX, &$HautY, $NoId, $Idx )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : affiche_photo_prod
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  Auteur : Denis Léveillé
//  date : 2019-06-12
//  derniere modif : 
//  info : 
{
global $mabd, $database;
	$sql = " SELECT Largeur, Hauteur FROM $database.photo WHERE NoInvent='$NoId' AND NoPhoto='$Idx';";
	$result = $mabd->query($sql);
	if( $result &&  $result->num_rows  ) {
		$pic_format = $result->fetch_assoc();
		$L = $pic_format['Largeur'];
		$H = $pic_format['Hauteur'];
		if( ($difL = $L - $LargX) < 0 ) $difL = 0; 
		if( ($difH = $H - $HautY) < 0 ) $difH = 0;
		if( $difL || $difH ) {
			if( $difL > $difH ) {
				$Pourcent = $LargX/$L;
				$LargX = $L*$Pourcent;
				$HautY = $H*$Pourcent;
			}
			else {
				$Pourcent = $HautY/$H;
				$LargX = $L*$Pourcent;
				$HautY = $H*$Pourcent;
			}
		}
		else {
			$LargX = $L;
			$HautY = $H;
		}
	} // Si une photo
	$LargX 		= rounder($LargX);
	$HautY 		= rounder($HautY);
	

} // affiche_photo_prod

function afficher_un_produit( $produit, $NoCat, $Retour, $Page )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 2.0
//  Auteur : Maxime Dupuis
//  date : 09-10-31
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : 
{
global $mabd, $param, $txt, $TabMessGen, $database, $TxCUC_USD,$TXUSD_CAD,$TXUSD_EUR,$SymbCUC,$SymbUSD,$SymbCAD,$SymbEUR;

//	$_SESSION['TotProd']++;
	extract($produit);
	$titre = stripslashes($produit['titre_'.$_SESSION['langue']]);
	$Symbole	=	get_Symbole($_SESSION['devise']);

	switch( $_SESSION['devise'] ) {
		case 'CUC'	:	$image = 'gifs/cuba.gif';
					$prix  = rounder($prix_detail);
					break;
		case 'USD'	:	$image  = 'gifs/usa.gif';
					$prix	=rounder($prix_detail * $TxCUC_USD);
					break;
		case 'EUR'	:	$image = 'gifs/europe.gif';
					$prix  =rounder(($prix_detail * $TxCUC_USD) * $TXUSD_EUR);
					break;
		default		:  	$image = 'gifs/canada.gif';
					$prix  = rounder($prix_detail);
					break;
	} // switch devise

		echo '
			<tr>
				<td>
					<table width=100% cellpadding=8 border=0>
						<tr>
							<td width=120 align=center Valign=middle>';
							if( $big ) 
								echo "<a href='javascript:VoirZoom($id);'>";

							$LargX = $param['image_list_largeur'];
							$HautY = $param['image_list_hauteur'];
							calcul_format_photo( $LargX, $HautY, $id, $small );
							

//*********************************************************************************************************************		
//		Il y avait un probleme avec Google qui demandais les images qu'il avait indexé ainsi :
//			http://www.cosat.biz/photoget_web.php%3FNo%3D5%26Idx%3D2 
//		Ce qui bien entendu causait un probleme puisque les symboles %3F (?) %3D (=) %26 (&) %3D (=) étaient interprété 
//		tel quel par apache et causaient un erreur 404
//		Pour contourner le problème je demande la 
//			photo/1/1 
//		et unev ligne dans le fichier .htaccess
//			RewriteRule ^/?photo/([0-9]+)/([0-9]+)$ photoget_web.php?No=$1&Idx=$2 [L]
//		Va convertir ma demande par 
//			photoget_web.php?No=1&Idx=1
//*********************************************************************************************************************		
//			echo "<img src='photo/".$produit['id']."/".$produit['small']."' alt='".$produit['titre_'.$_SESSION['langue']]."' border='0' width='$LargX' height='$HautY'></a><br>";
							echo "<img src='photo/$id/$small' alt='$titre' border='0' width='$LargX' height='$HautY'></a>";
							//  bgcolor='DBE5FE' 
							echo "
							</td>
							<td align='left'>
								<table cellpadding='4' cellspacing='0' width='100%' border='0'>
									<tr>
										<td width='100%' align='left'>
											<span class=titre>$titre $Code</span>	
										</td>
										<td>&nbsp;
										</td>
									</tr>
								</table>
								<span class='description'>".stripslashes($produit['description_'.$_SESSION['langue']])."</span><br>
								<span class='prix'>
									<img src='$image'/>&nbsp;&nbsp;<b>$prix</b> $Symbole&nbsp;(".$_SESSION['devise'].")<sup>*</sup>";
							  echo "<br><br>
								</span>
            							<form name='ajout$id' action='#' method='POST'>
									<input type='hidden' name='cat' value='$NoCat'>
									<input type='hidden' name='CodePanier' value='1'>
									<input type='hidden' name='id' value='$id'>
									<input type='hidden' name='Target' value='$Page'>
									<a href='produit_detail.php?cat=$NoCat&id=$id' target='$Page' class='titre'>".$txt['plus_de_details']."</a>
									&nbsp;&nbsp;&nbsp;&nbsp;<a href='envoi_ami.php?cat=$NoCat&id=$id' class='titre'>".$txt['envoyer_ami']."</a>
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>";

} // afficher_un_produit

/**********************************************************************************************/
function produits_accueil( $id = 0 )
//  FUNCTION : produits_accueil
//  Auteur : Denis Léveillé
//  date : 2007-11-05
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : Trouver les produits à afficher sur la page d'acceuil
{
global $mabd, $database;

	$sql = "SELECT * FROM $database.produits_accueil";
	if( $id != 0 )
	  $sql .= " WHERE id ='$id'";
	  
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection produit acceuil :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	if( ($id != 0) && $result->num_rows )
		$results = $result->fetch_assoc();
	
	return $results;
} // produits_accueil

function get_prod_infos_by_id($id)
//  FUNCTION : get_prod_infos_by_id - 1j
//  version : 2.0
//  Auteur : Maxime Dupuis
//  date : 09-10-04
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : retourne les infos d'un produit selon son ID
{
global $mabd, $database;
	$infos = array();
	
	$sql = "SELECT * FROM $database.stock WHERE id='$id' LIMIT 1;";

	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection get_prod_infos_by_id :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
	
	if( $result->num_rows ) {
		$tableau = $result->fetch_assoc();
		foreach($tableau as $column => $value)
			$infos[$column] = $value;
	}
		
	return $infos;
} // fin de la fonction : get_prod_infos_by_id-

function check_cat_du_prod($id)
//  FUNCTION : check_cat_du_prod
//  version : 2.0
//  Auteur : Denis Léveillé
//  date : 2009-09-30
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : Trouver la catégorie du produit
{
global $mabd, $database;

	$sql = "SELECT * FROM $database.catalogue_produits WHERE $database.catalogue_produits.id_produit =$id;";

	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection check_cat_du_prod :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
	
	if( $result->num_rows ) 
		$cat = $result->fetch_assoc();
	else	// si aucune données
		return 0;

	return $cat['id_catalogue'];

} // fin de la fonction : check_cat_du_prod 

function get_subcats($upCat, $online = 0)
//  FUNCTION : get_subcats  - 1q
//  version : 2.0
//  Auteur : Maxime Dupuis
//  date : 09-10-04
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
global $mabd, $database;

   	$categories = array();

	$sql = "SELECT id, ".$_SESSION['langue']." AS titre_cat FROM $database.catalogue WHERE parent ='$upCat'";

	if( $online ) 
		$sql .= " AND online = $online";
		
	$sql .=' ORDER BY ordre ASC, '.$_SESSION['langue'].' ASC;';
	
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection get_subcats :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	while( $r = $result->fetch_assoc() )
		$categories[$r['id']] = $r['titre_cat'];
	
	return $categories;
} // fin de la fonction : get_subcats ----------------------------------------------------------

function get_count_cats($upCat)
//  FUNCTION : get_subcats  - 1q
//  version : 2.0
//  Auteur : Maxime Dupuis
//  date : 09-10-04
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
global $mabd, $database;

	$sql = "SELECT id FROM $database.catalogue WHERE parent ='$upCat' AND online = '1';";
	$Total = 0;

	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection get_count_cats :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	while( $r = $result->fetch_assoc() ) {
		$sql = "SELECT COUNT(*) FROM $database.catalogue_produits WHERE $database.catalogue_produits.id_catalogue =".$r['id'];
		$result2 = $mabd->query($sql);
		if( !$result2 )
			Message_Erreur( "ERROR", "Erreur count get_count_cats :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );				
		$Resultat = $result2->fetch_row();
		$Total += $Resultat[0];
	}	
	return( $Total );
} // get_count_cats

function check_prod_into_cat($id)
//  FUNCTION : check_prod_into_cat
//  version : 2.0
//  Auteur : Maxime Dupuis
//  date : 27-11-04
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : Regarde si des produits sont présents dans une catégorie ou non
{
global $mabd, $database;

	$sql = "SELECT * FROM $database.catalogue_produits WHERE $database.catalogue_produits.id_catalogue =$id;";
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection check_prod_into_cat :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
	
	return( $result->num_rows != 0 );

} // fin de la fonction : check_prod_into_cat 

function get_count_sub_cats($Cat)
//  FUNCTION : get_subcats  - 1q
//  version : 2.0
//  Auteur : Maxime Dupuis
//  date : 09-10-04
//  derniere modif : Denis Léveillé	date : 19-06-10
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
 global $mabd, $database;
	$Total = 0;

  	$sql = "SELECT DISTINCT COUNT(*) FROM $database.stock";
	$sql .= " LEFT JOIN $database.catalogue_produits ON id = $database.catalogue_produits.id_produit";
	$sql .= " WHERE $database.catalogue_produits.id_catalogue = '$Cat'  AND online = '1'";

	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à la sélection get_count_sub_cats :: ", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	$Resultat = $result->fetch_row();
	$Total = $Resultat[0];

	return( $Total );
} // get_count_cats



function frais_livraison_get($total, $Source=1)
//  FUNCTION : frais_livraison_get - 11h
//  date : 2007-11-05
//  derniere modif : Denis Léveillé
//  info : Trouver le frais de livraison pour un montant donner
{
global $mabd, $database;
 
	$frais = 0;
   	if( $total ) {     
		$sql = "SELECT frais FROM $database.frais_livraison WHERE (montant > $total) AND (Provenance = $Source) LIMIT 1;";
		
		$result = $mabd->query($sql);
		if( !$result )
			Message_Erreur( "ERROR", "Erreur accès frais_livraison_get", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
		
		$result = $result->fetch_assoc();
		$frais = $result['frais'];
	}

   	return($frais);
} // fin de la fonction : frais_livraison_get

function frais_livraison_get2($total, $Source=1)
//  FUNCTION : frais_livraison_get - 11h
//  date : 2007-11-05
//  derniere modif : Denis Léveillé
//  info : Trouver le frais de livraison pour un montant donner
{
global $database, $mabd;
	

	$frais = 0;
   if( $total ) {  
		$LeCode = 'WB'.$Source;   
		$sql = "SELECT * FROM $database.codeprix WHERE (Code = '$LeCode') && (QteMax > $total) LIMIT 1;";
		
		$result = $mabd->query($sql);
		if( !$result )
			Message_Erreur( "ERROR", "Erreur accès frais_livraison_get2", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
		
		$result = $result->fetch_assoc();
		$frais = $result['Fixe'];
	}

   return($frais);
} // fin de la fonction : frais_livraison_get
                                                                                      
function get_all_products($id=0)
//  FUNCTION : get_all_products 1l
//  version : 1.0 
//  date : 03-12-04
//  derniere modif : Daniel de Varennes
//  info : Selectionne les variables de la BD : produits et prouits_infos et retourne TOUTES les produits
{
global $mabd, $database;
	$sql = "SELECT * FROM $database.stock ";
	if( $id != 0 )
		$sql .= " WHERE id=$id;";
	else
		$sql .= " WHERE online = '1';";

	$result = $mabd->query($sql);
    if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_all_products", $mabd->errno." : ".$mabd->error."<br>".$sql );			
 	
	return $result;
} // fin de la fonction : get_all_products 

function get_certificat_libre($id_produit)
//  FUNCTION : get_certificat_libre - 1x
//  version : 1.0
//  date : 2007-10-29
//  derniere modif : Denis Léveillé
//  info : Trouver un numéro de certificat cadeau de libre
{
global $mabd, $database;
	$Ret = 1;
	$date			= mktime();
	$aujourdhui = date("Y-m-d H:i:s", $date );
//	echo "Date : ".$aujourdhui."<br>";

	$sql = "SELECT * FROM $database.stock  WHERE id < $id_produit;";
	
	$result = $mabd->query($sql);
    if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_certificat_libre", $mabd->errno." : ".$mabd->error."<br>".$sql );			

	while( $item = $result->fetch_assoc() ) {
		$datelut = date("Y-m-d H:i:s", $item['MAJ'] );
//		echo "No : ".$item['id']." Lut : ".$datelut."<br>";
		if( $item['MAJ'] < ($date - 3600) ) {
			$sql = "UPDATE $database.stock set MAJ = '$date' WHERE id = '".$item['id']."';";
			$result = $mabd->query($sql);
			if( !$result )
				Message_Erreur( "ERROR", "Erreur accès MAJ de certificat", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
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
global $mabd, $database;
	$sql = "SELECT DISTINCT * FROM $database.stock";
	$sql .= " LEFT JOIN $database.catalogue_produits ON id = $database.catalogue_produits.id_produit";
	$sql .= " WHERE $database.catalogue_produits.id_catalogue = '$idCat'"; // AND Qte_Max_Livre > 0";
	
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
	$result = $mabd->query($sql);
	
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès selectionProduits", $mabd->errno." : ".$mabd->error."<br>".$sql );			
	
	// si aucune données
	if( !$result->num_rows )
		return $result;
	else   // sinon retour des valeurs
		return $result;
		
} // fin de la fonction : selectionProduits 

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
global $mabd, $database;
	$firstCats = array();
	
	$sql = "SELECT * FROM $database.catalogue WHERE parent = 0";
	
	if( $online ) 
		$sql .= " AND online = $online";

	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get-first-cats", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
	
	while($r = $result->fetch_assoc())
		$firstCats[$r['id']] = $r[$_SESSION['langue']];
	
	return $firstCats;
} // fin de la fonction : get_first_cats -------------------------------------------



function get_cat_path($id)
//  FUNCTION : get_cat_path - 1r
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : retourne le chemin (les id des parents) jusqu'à la catégorie donnée en paramètre initial
{
global $mabd, $database;
	
	$path = array();

	$sql = "SELECT parent FROM $database.catalogue WHERE id=$id;";
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_cat_path", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	$row = $result->fetch_assoc();
	
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
global $mabd, $database;
	$sql = "SELECT ".$_SESSION['langue']." FROM $database.catalogue WHERE id =$id LIMIT 1;";
	
	$result = $mabd->query($sql);
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get-cat-name-by-id", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
		
	$result = $result->fetch_row();

    return $result[0];
    
} // fin de la fonction : get_cat_by_id -----------------------------------------------------------

function vente_get($id)
//  FUNCTION : vente_get
//  version : 1.0
//  date : 29-12-04
//  derniere modif : Maxime Dupuis
//  info : Selectionne les infos d'une vente
{
global $mabd, $database;
	$infosVente = array();
	
	$sql = "SELECT * FROM $database.ventes WHERE id=$id;";
	
	$result = $mabd->query($sql); 
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à vente_get", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
	
	$infosVente = $result->fetch_assoc();
	
	$sql = "SELECT * FROM $database.ventes_articles WHERE id_vente=$id;";
	$result = $mabd->query($sql); 
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à vente_articles-get", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	$i = 1;
	while( $monArticle = $result->fetch_assoc() )
		$infosVente['articles'][$i++] = 	$monArticle;
/*	$i = 1;
	while( $monArticle = mysql_fetch_assoc($select) )
	   foreach($monArticle as $colonne => $valeur)
	       $infosVente['articles'][$i++][$colonne] = $valeur;*/
	
	return($infosVente);
} // fin de la fonction : vente_get 

function get_count_10best()
//  FUNCTION : get_subcats  - 1q
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
 global $mabd, $database;
 $NbJour = 90;
 	// On a un chiffre en secondes alors -> 24h par 60 min x 60 sec = 86400 sec.
 	$derniermois = time() - ($NbJour * 86400);
 	$Ladate = date("Y-m-d", $derniermois);
	$TabProd = array();

	$sql = "SELECT id_produit, id_vente, quantite, count(quantite) AS nombre FROM $database.ventes_articles";
	$sql .= " LEFT JOIN $database.ventes ON id_vente = $database.ventes.id";
	$sql .= " WHERE $database.ventes.Date > '$Ladate'"; 
	$sql .= " GROUP BY id_produit ORDER BY nombre DESC";
 
	$result = $mabd->query($sql);
	if( $result ) {
			for( $i = 1; ($i <= 10) && ($Resultat = $result->fetch_row() ); $i++ ) {
				$TabProd[$i] = get_prod_infos_by_id($Resultat[0]);
				$TabProd[$i]['nombre'] = $Resultat[3];
//				var_dump($Resultat);
//				$Total += $Resultat[0];
			}	
//		$Resultat = $result->fetch_row();
//		$Total = $Resultat[0];
//		var_dump($Resultat);
	} // sI UN RESULTAT	
//	else
//		$Total = 'NULL !!!';
	return( $TabProd );
} // get_count_10best


//  FUNCTION : ventes_get_all
//  version : 1.0
//  date : 01-12-04
//  derniere modif : Daniel de Varennes
//  info : Selectionne les variables de la BD : ventes et retourne TOUTEs les ventes

function ventes_get_all($date_avant, $date_apres, $id_produit, $id_client, $id_vendeur){
 global $mabd, $database;
	$ventes = array();
	$ventes_get_all = array();
	$where = true;
	
	$sql = 'SELECT * FROM ventes';
		
	
	if( $id_client ){
		if( $where ){
			$sql .= ' WHERE ';
			$where = false;
		}
		else
			$sql .= ' AND ';
		$sql .= ' id_client = '. $id_client .'';
	}	
	
	if( $id_vendeur ){
		if( $where ){
			$sql .= ' WHERE ';
			$where = false;
		}
		else
			$sql .= ' AND ';
		$sql .= ' id_vendeur = '. $id_vendeur .'';
	}
	
	if( $date_avant && $date_apres ){
		if( $where ){
			$sql .= ' WHERE ';
			$where = false;
		}
		else
			$sql .= ' AND ';
		$sql .= ' date >= '.$date_avant.' AND date <= '.$date_apres.'';
	}		
	
	
	$sql .= ' order by date DESC';
	
	$result = $mabd->query($sql); 
	if( !$result )
		Message_Erreur( "ERROR", "Erreur à vente_get_all", $mabd->errno." : ".$mabd->error."<br>".$sql  );			

	$i = 0;
	while( $r = $result->fetch_assoc() ){
		foreach( $r as $colonne => $valeur )
			$ventes_get_all[$i][$colonne] = $valeur;
		$i++;
		//$sql = "UPDATE ventes SET LaDate = ".date( "Y-m-d H:i:s", $r[2] )." WHERE id = '".$r[0]."' ;";
	}
	
	return $ventes_get_all;

} // fin de la fonction : ventes_get_all ------------------------------------------------------------------------

/************************************************************/
function faire_souscat($upCat){
 global $mabd, $database;
 global $txt, $prod_filter;

	$sql = "SELECT id FROM $database.catalogue WHERE parent ='$upCat' AND online = 1";
	
	$sql .=' ORDER BY ordre ASC, '.$_SESSION['langue'].' ASC;';
	
	$result = $mabd->query($sql); 
	if( !$result )
		Message_Erreur( "ERROR", "Erreur selection faire_souscat", $mabd->errno." : ".$mabd->error."<br>".$sql  );			
	
	while( $r = $result->fetch_assoc( ) ) {
		$produits = selectionProduits( $r['id'], null, 1 );
		if( $produits ) {
			while( $produit = $produits->fetch_assoc() )
				if( !in_array( $produit['id'],$prod_filter ) ) {
//					$prod_filter[] = $produit['id'];
					afficher_un_produit( $produit, $r['id'], 3, '_top' );	
				}
		}
		faire_souscat($r['id']);
	} // foreach
	
} // faire_souscat
/************************************************************/

?>