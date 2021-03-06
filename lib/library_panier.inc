<?php
// DEBUT FUNCTIONS PANIER --

/*
Table des mati�res des functions
___________________________

10a - panierAjout($id, $nombre = 1) - Selectionne les variables de la BD : ajoute un produit au panier
10b - panierCompte() - Compte le nombre d'articles dans le panier
10c - panierInfos() - Selectionne les variables de la BD : va chercher les infos dans la table pour chaque produits
10d - panierModif($produit, $quantite) -  Modifie la qte d'un article dans un panier
10e - panierReset() - info : Selectionne les variables de la BD : remet le panier � l'�tat initial
10f - panierSupprime($id) - Selectionne les variables de la BD : supprime un produit au panier
10g - panierTotal() - Retourne la valeur totale des articles dans le panier
10i - taxes_calculer() - calcule les taxes des produits dans le panier
10j - save_panier($serialized_basket, $id_client, $nb_jour=31) - sauvegarde le panier pendant X jours dans la table Panier
*/


function panierReset( &$Panier )
//- 10e -----------------------------------------------------------------------------------------
//  FUNCTION : panierReset
//  version : 1.0
//  date : 04-10-04
//  derniere modif : Maxime Dupuis
//  info : Selectionne les variables de la BD : remet le panier � l'�tat initial
{
         
	if( isset($Panier) )
		unset( $Panier );     // on supprime le panier
	$Panier = array();  // et on dit que c'est un tableau

//    unset( $Panier );     // on supprime le panier
//    $Panier = array();  // et on dit que c'est un tableau
//unset($_SESSION['panier']);
//$_SESSION['panier'] = array();

} // fin de la fonction : panierReset 

function panierAjout( &$Panier, $id, $qte = 1, $prix = 0 )
//- 10a -----------------------------------------------------------------------------------------
//  FUNCTION : panierAjout
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Selectionne les variables de la BD : ajoute un produit au panier
{
    if( !isset($Panier) || !is_array($Panier) )
        return 0;
        
	if( $id != 0 ) {
    	$Panier[$id]['Qte'] = $qte;
    	$Panier[$id]['Prix'] = $prix;
   }
} // fin de la fonction : panierAjout

function panierModif( &$Panier, $id, $qte, $prix = 0)
//- 10d -----------------------------------------------------------------------------------------
//  FUNCTION : panierModif
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Modifie la qte d'un article dans un panier
{
//	echo "Id ".$id." Qte ".$qte."<br>";
    if( !isset($Panier) || !is_array($Panier) || !count($Panier) )
        return 0;
        
	if( $id != 0 ) {
		$Panier[$id]['Qte'] = $qte;
    	$Panier[$id]['Prix'] = $prix;
	}
//    exit();
} // fin de la fonction : panierModif 

function panierSupprime( &$Panier, $id = 0 )
//- 10f -----------------------------------------------------------------------------------------
//  FUNCTION : panierSupprime
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Selectionne les variables de la BD : supprime un produit au panier
{
    if( !isset($Panier) || !is_array($Panier) || !count($Panier) )
        return 0;

    unset($Panier[$id]);
} // fin de la fonction : panierSupprime 

function panierCompte( &$Panier )
//- 10b -----------------------------------------------------------------------------------------
//  FUNCTION : panierCompte
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Compte le nombre d'articles dans le panier
{
    if( !isset($Panier) || !is_array($Panier) || !count($Panier) )
        return 0;

    $nbArticles = 0;

    foreach( $Panier as $id => $item){
        $nbArticles += @$item['Qte'];
    }

    return $nbArticles;
} // fin de la fonction : panierCompte 

function panierInfos( &$Panier, $Province=0 )
//- 10c -----------------------------------------------------------------------------------------
//  FUNCTION : panierInfos
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Selectionne les variables de la BD : va chercher les infos dans la table pour chaque produits
{
global $handle, $database;
 
     if( !isset($Panier) ) 
        	return false;

     if( !is_array($Panier)) {
     		panierReset($Panier);
        	return false;
      }
 
   // si le panier est vide
    if( count($Panier) == 0 )
        return false;

    // sinon
    $prods = array();
    foreach($Panier as $Pid => $item){    // pour chaque article
		$query = "SELECT *, titre_".$_SESSION['langue']." AS titre"
					.", description_".$_SESSION['langue']." AS description"
					." FROM $database.stock WHERE id =".$Pid;
		
		if( !($infoProduit = mysql_query($query, $handle)) ) {
     		panierReset($Panier);
			die("Erreur parsing du panier ID = ".$Pid." : ".mysql_error());
		}
		
//echo "Pro : $Province<br>";
//echo "Pid $Pid item ".$item['Qte']."<br>";	
//var_dump($item);	
//echo "<br>";	
		// si aucune donn�es
		if( mysql_num_rows($infoProduit) != false ) {
			$resultats = mysql_fetch_assoc($infoProduit);  // on ramasse ses infos
			foreach( $resultats as $keyProd => $valueProd )  // et pour chaque info
				$prods[$Pid][$keyProd] = $valueProd;        // on store dans $prod
			$prods[$Pid]['Disponible'] = true;
			$prods[$Pid]['QteVendu'] = $item['Qte'];
			$prods[$Pid]['PrixVendu'] = $item['Prix'];
			if( $Province  &&  $prods[$Pid]['Secteur_Limite'] && ( $prods[$Pid]['Secteur_Limite'] != $Province ) ) {
				$prods[$Pid]['Disponible'] = false;
//				echo "bla bla<br>";
			}
		} // Si produits trouver
//echo "Prod 2 : ".$prods[$Pid]['QteVendu']."<br>";	
		
    } // Pour chaques articles
//exit();
    // retour des valeurs
    return $prods;
} // fin de la fonction : panierInfos 

function panierValide( &$Panier, $Province=0 )
//- 10c -----------------------------------------------------------------------------------------
//  FUNCTION : panierInfos
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Selectionne les variables de la BD : va chercher les infos dans la table pour chaque produits
{
global $handle, $database;
 
     if( !isset($Panier) ) 
        	return 0;

     if( !isset($Province) ) 
        	return 0;

     if( !is_array($Panier)) {
     		panierReset($Panier);
        	return 0;
      }
 
   // si le panier est vide
    if( count($Panier) == 0 )
        return false;

    // sinon
    $prodInvalide = array();
    foreach($Panier as $Pid => $item){    // pour chaque article
		$query = "SELECT * FROM $database.stock WHERE id =".$Pid;
		
		if( !($infoProduit = mysql_query($query, $handle)) ) {
     		panierReset($Panier);
			die("Erreur parsing du panier ID = ".$Pid." : ".mysql_error());
		}
		// si aucune donn�es
		if( mysql_num_rows($infoProduit) != false ) {
			$resultats = mysql_fetch_assoc($infoProduit);  // on ramasse ses infos
//			echo "Limite ".$resultats['Secteur_Limite']." Province ".$Province."<br>";
			if( $resultats['Secteur_Limite'] && ( $resultats['Secteur_Limite'] != $Province ) ) {
				$prodInvalide[$Pid] = 0; //false;
//				echo "valeur : ".$prodInvalide[$Pid]."<br>";	
			}
		} // Si produits trouver
		
    } // Pour chaques articles
    // retour des valeurs
    return $prodInvalide;
} // fin de la fonction : panierInfos 


function panierTotal( &$Panier, $Province=0 )
//- 10g -----------------------------------------------------------------------------------------
//  FUNCTION : panierTotal
//  version : 2.0
//  date : 2007-12-09
//  derniere modif : Denis L�veill�
//  info : Retourne la valeur totale des articles dans le panier
{
global $handle, $database;

//    var_dump($Panier);

	if( !isset($Panier) || !is_array($Panier) )
		return 0;
	
	$total = 0;
	
	foreach($Panier as $Pid => $item){
		$query = "SELECT prix_detail, Secteur_Limite FROM $database.stock WHERE id ='$Pid' LIMIT 1;";
		
		$result = mysql_query($query, $handle )
			or die("Erreur dans le parsing du panier : ".mysql_error());
		$produit = mysql_fetch_assoc($result);
		
		if(  !$Province || !$produit['Secteur_Limite'] || ( $produit['Secteur_Limite'] == $Province )   )
			$total += $produit['prix_detail'] * $item['Qte'];
	
	}
	
	return $total;

} // fin de la fonction : panierTotal 


function panierTotalCourant( &$Panier, $Devise, $Province=0 )
//- 10g -----------------------------------------------------------------------------------------
//  FUNCTION : panierTotalCourant
//  version : 2.0
//  date : 2007-12-16
//  derniere modif : Denis L�veill�
//  info : Retourne la valeur totale des articles dans le panier en monnaie courante
{
global $handle, $database;


	$Total = $SousTotalCUC = panierTotal( $Panier, $Province );
	if( $SousTotalCUC ) {
		$TxCUC_USD = get_TauxVente("CUC"); 
		$TXUSD_CAD = get_TauxVente("CAD"); 
		$TXUSD_EUR = get_TauxVente("EUR"); 
		$SousTotalUSD = rounder($SousTotalCUC * $TxCUC_USD);
		$SousTotalCAD = rounder($SousTotalUSD * $TXUSD_CAD);
		$SousTotalEUR = rounder($SousTotalUSD * $TXUSD_EUR);
		switch( $Devise ) {
			case 'CUC' : 	$Total = $SousTotalCUC;
								break;
			case 'USD' : 	$Total = $SousTotalUSD;
								break;
			case 'EUR' : 	$Total = $SousTotalEUR;
								break;
			default		:	$Total = $SousTotalCAD;
		}

	}
	return $Total;

} // fin de la fonction : panierTotalpanierTotalCourant 


//- 10h---------------------------------------------------------------------------------------------------------------
//  FUNCTION : panierTotalLivrable
//  version : 1.0
//  date : 2007-10-29
//  derniere modif : denis L�veill�
//  info : Retourne la valeur totale des articles dans le panier qui sont livrable

function panierTotalLivrable( &$Panier, $Provenance=1 )
{
global $handle, $database;

    if( !isset($Panier) || !is_array($Panier) )
        return 0;

    $total = 0;

    foreach($Panier as $Pid =>  $item){
        $query = "SELECT * FROM $database.stock WHERE id ='$Pid' LIMIT 1;";
        
        $result = mysql_query($query, $handle )
		  		or die("Erreur dans le parsing du panier Livrable: ".mysql_error());
        $result = mysql_fetch_assoc($result);
        if( ($result['livrable'] == TRUE) && ( !$Provenance  || ($result['Provenance'] == $Provenance)) ) 
        		$total += $result['prix_detail'] * $item['Qte'];

    }

    return $total;

} // fin de la fonction : panierTotalLivrable

function panierTotalLivrable2( &$Panier, &$TotPrix, &$TotPoid, $Provenance=1, $Province=0 )
{
global $handle, $database;

    if( !isset($Panier) || !is_array($Panier) )
        return 0;

    $TotPrix = $TotPoid = 0;

    foreach($Panier as $Pid =>  $item){
        $query = "SELECT * FROM $database.stock WHERE id ='$Pid' LIMIT 1;";
        
        $result = mysql_query($query, $handle )
		  		or die("Erreur dans le parsing du panier Livrable: ".mysql_error());
        $result = mysql_fetch_assoc($result);
        if( ($result['livrable'] == TRUE) && (!$Provenance || ($result['Provenance'] == $Provenance) ) 
        		&& ( !$Province || !$result['Secteur_Limite'] || ( $result['Secteur_Limite'] == $Province ) )  ){
        		$TotPrix += $result['prix_detail'] * $item['Qte'];
        		$TotPoid += $result['weight'] * $item['Qte'];
        	}

    }
	return $TotPrix;

} // fin de la fonction : panierTotalLivrable

function taxes_calculer()
//- 10i ---------------------------------------------------------------------------------------------------------------
//  FUNCTION : taxes_calculer
//  version : 1.0
//  date : 30-11-04
//  derniere modif : Maxime Dupuis
//  info : calcule les taxes des produits dans le panier
{
	return;
} // fin de la fonction : taxes_calculer 

//- 10j ---------------------------------------------------------------------------------------------------------------
//  FUNCTION : save_panier
//  version : 1.0
//  date : 14-05-05
//  derniere modif : Maxime Dupuis
//  info : sauvegarde le panier pendant X jours dans la table Panier
function get_panier( $id_client ){
global $handle, $database;

	$Panier = array(); 

 	if( !isset($id_client ) )
		$id_client = ip2long($_SERVER['REMOTE_ADDR']);
 
 	$sql = "SELECT * FROM $database.panier WHERE id = $id_client LIMIT 1;";
 	$result = mysql_query($sql, $handle) 
 		or die("Erreur � la recup�ration du panier :: ".$id_client." :: ".mysql_error());
	if( mysql_num_rows($result) != false ) {
		$Panier_ser = mysql_fetch_assoc($result);
		$Panier = unserialize($Panier_ser['panier']);
	}
	else {
   	$id_client = 'ip'.ip2long($_SERVER['REMOTE_ADDR']);
	 
	 	$sql = "SELECT * FROM $database.panier WHERE id = $id_client LIMIT 1;";
	 	$result = mysql_query($sql, $handle) 
	 		or die("Erreur � la recup�ration du panier :: ".$id_client." :: ".mysql_error());
		if( mysql_num_rows($result) != false ) {
			$Panier_ser = mysql_fetch_assoc($result);
			$Panier = unserialize($Panier_ser['panier']);
		}
	}
	
   return( $Panier );
 
} // fin de la fonction : save_panier 

//- 10j ---------------------------------------------------------------------------------------------------------------
//  FUNCTION : save_panier
//  version : 1.0
//  date : 14-05-05
//  derniere modif : Maxime Dupuis
//  info : sauvegarde le panier pendant X jours dans la table Panier
function save_panier($Panier, $id_client, $nb_jour=31)
{
global $handle, $database;

	$serialized_basket = serialize($Panier); 
 // jour * heures * minutes * secondes
 	$nb_jour = $nb_jour * 24 * 60 * 60;
 	$timeout = mktime() + $nb_jour;
 
 	if(!isset($id_client))
     $id_client = ip2long($_SERVER['REMOTE_ADDR']);
 
 	$query = "REPLACE INTO $database.panier VALUES ('$id_client','".mysql_real_escape_string($serialized_basket)."','$timeout');";
 	$query = mysql_query($query, $handle) 
 		or die("Erreur � la sauvegarde du panier :: ".$id_client." :: ".mysql_error());

 	return mysql_affected_rows();
    
} // fin de la fonction : save_panier 
?>
