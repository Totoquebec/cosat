<?php
//define('FPDF_FONTPATH','font/');
//INCLUDE DES LIB
//include('lib/config.php');
include('connect.inc');
require('fpdf/WriteHTML.php');
//require('fpdf/mem_image.php');

/*****************VARIABLE GLOBAL***************************/
$html = "";
$prod_filter = array();
$top_marge = 10;

$police_nom = 'Times';
$police_point = 10;
$point_par_ligne = 6;

$nb_point_entete = 15;
$nb_car_ligne = 100;
$nb_ligne_par_page = 52;
//$fich_fond = "images/fond_pdf.jpg";
$x_fond = 40;
$y_fond = 40;
$w_fond = 160;
$h_fond = 209;
extract($_POST,EXTR_OVERWRITE);	 

$LaPhoto =array();

	if ( $Langue == "fr" ){
		$titre_doc = "COSAT INFORMATIQUE CATALOGUE";
		$description_doc = "CATALOGUE DES ARTICLES VENDU PAR ANTILLAS-EXPRESS";
		$description_false = "AUCUNE DESCRIPTION POUR CE PRODUIT";
	}
	else if ( $Langue == "en" ){
		$titre_doc = "COSAT INFORMATIQUE CATALOGUE";
		$description_doc = "CATALOGUE ARTICLES SOLD BY ANTILLAS-EXPRESS";
		$description_false = "NO DESCRIPTION FOR THIS PRODUCT";
	}
	elseif ( $Langue == "sp" ){
		$titre_doc = "COSAT INFORMATIQUE CATÁLOGO";
		$description_doc = "LOS ARTÍCULOS DEL CATÁLOGO VENDIERON POR ANTILLAS-EXPRESS";
		$description_false = "NINGUNA DESCRIPCIÓN PARA ESTE PRODUCTO";
	}
	else{
		$titre_doc = "COSAT INFORMATIQUE CATALOGUE";
		$description_doc = "CATALOGUE DES ARTICLES VENDU PAR ANTILLAS-EXPRESS";
		$description_false = "AUCUNE DESCRIPTION POUR SE PRODUIT";
	}
	$auteur_doc = "Denis Léveillé";

/*****************FIN VARIABLE GLOBAL************************/

//DÉBUT FUNCTION clean
function clean($description,$Code,$titre)
//  FUNCTION : clean
//  version : 1.0
//  date : 27-08-08
//  derniere modif : Jean-Alexandre
//  info : Nettoye les descriptions
{
 global $handle, $mysql_base, $Langue, $tri_cat, $prod, $status, $image;

	$description = str_replace($titre, "", $description);
	$description = str_replace($Code, "", $description);
	//$description = strip_tags( $description );
	$description = str_replace("<li>", "", $description);
	$description = str_replace("</li>", "<br/>", $description);
	$description = str_replace("<LI>", "", $description);
	$description = str_replace("</LI>", "<br/>", $description);
	$description = str_replace("<h3>", "", $description);
	$description = str_replace("</h3>", "<br/>", $description);
	$description = str_replace("<ul>", "", $description);
	$description = str_replace("</ul>", "<br/>", $description);
	$description = str_replace("<UL>", "", $description);
	$description = str_replace("</UL>", "<br/>", $description);
	$description = str_replace("<h2>", "", $description);
	$description = str_replace("</h2>", "<br/>", $description);
//	$description = str_replace("<", "", $description);
//	$description = str_replace("\"", "", $description);
	$description = stripslashes($description);
	if( $deb = strpos ( strtoupper($description) ,'<A'  ) ) {
//		echo 'Avant : '.$description.'<br/>';
		
		$fin = strpos ( strtoupper($description) ,'A>'  );
		
		$chaine = substr ( $description , 0 , $deb ); 
		$chaine .= substr ( $description , $fin+2  ); 
		$description = $chaine;
//		echo 'Après : '.$description.'<br/>';
	}
	return $description;
} // fin de la fonction : Clean ----------------------------------------------------------




//DÉBUT FUNCTION SELECT_PROD_CAT
function select_prod_cat($idCat=0, $idProduit=0, $online=0, $page = 0, $parPage = 0)
//  FUNCTION : SELECT PROD_CAT
//  version : 1.0
//  date : 27-06-08
//  derniere modif : Jean-Alexandre Denis
//  info : sélectionne les produits contenus dans une catégorie OU
//         les infos d'un produit selon son ID passé en paramètre 2
{
global $handle, $database, $Langue, $tri_cat, $prod, $status, $image;
  	$sql = "SELECT DISTINCT * FROM $database.stock";
	$sql .= " LEFT JOIN $database.catalogue_produits ON id = $database.catalogue_produits.id_produit";
	$sql .= " WHERE $database.catalogue_produits.id_catalogue = '$idCat'"; // AND Qte_Max_Livre > 0";

	if( $idProduit )
		$sql .= " AND id =$idProduit LIMIT 1";
	
	if( $status == 1 )
		$sql .= " AND online = '1'";
	elseif ( $status == 0 )
		$sql .= " AND online = '0'";
	    else {}
	if( $parPage ){
		$min = $page*$parPage-$parPage;
		if($min < 1)
			$min = 0;
		$sql .= " LIMIT $min,$parPage ";
	}
	if( $prod == "id" )
		$sql .= " ORDER BY id ASC;";
	elseif ( $prod == "titre" )
		$sql .= " ORDER BY $database.stock.titre_$Langue ASC;";
	    else {
		$sql .= " ORDER BY Code ASC;";
	    }
//echo $sql."<br>";
    $result = mysql_query($sql, $handle);
    if( !$result )
		Message_Erreur( "ERROR", "Erreur accès selectionProduits", mysql_errno()." : ".mysql_error()."<br/>".$sql );			

	// si aucune données
	if( !mysql_num_rows($result) )
		return false;
	else   // sinon retour des valeurs
		return $result;
} // fin de la fonction : select_prod_cat 


//DÉBUT FUNCTION GET_CATÉGORIE
function get_categorie($upCat, $online = 0)
//  FUNCTION : get_categorie
//  version : 1.0
//  date : 27-08-08
//  derniere modif : Jean-Alexandre
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre
{
 global $handle, $database, $Langue, $tri_cat, $prod, $status, $image;
   $categories = array();

	$sql = "SELECT id, ".$Langue." AS titre_cat FROM $database.catalogue WHERE parent ='$upCat'";

	if( $online ) 
		$sql .= " AND online = $online";
		if ( $tri_cat == "alpha" )
			$sql .=' ORDER BY '.$Langue.' ASC';
		else
			$sql .=' ORDER BY ordre ASC';
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_subcats", mysql_errno()." : ".mysql_error()."<br/>".$sql  );			

	while( $r = mysql_fetch_assoc($result) )
		$categories[$r['id']] = $r['titre_cat'];
	
	return $categories;
} // fin de la fonction : get_CATEGORIE ----------------------------------------------------------


//DÉBUT FUNCTION AFFICHER PRODUIT
function item_catalogue( $produit  )
//  FUNCTION : item_catalogue
//  version : 1.0
//  date : 27-08-08
//  derniere modif : Jean-Alexandre
//  info : Sélectionne les items dans chacune des catégories.
		
{
// INCLUDE DES VARIABLE GLOBAL
	global $param, $handle, $txt, $database, $TxCUC_USD,$TXUSD_CAD,$TXUSD_EUR,$SymbCUC,$SymbUSD,
	$SymbCAD,$SymbEUR,$html,$pdf, $point_par_ligne,$nb_car_ligne, $Langue, $tri_cat, $prod, $status, $image, $description_false;
	$nb_ligne = 5;
	
	//$_SESSION['TotProd']++;
	extract($produit);
	//SÉLECTION DU TITRE EN FUNCTION DE LA LANGUE DU SITE
	$titre = stripslashes($produit['titre_'.$Langue]);
	//SÉLECTION DE LA DEVISE EN FUNCTION DE LA LANGUE DU SITE
	$Symbole	=	get_Symbole($_SESSION['devise']);
	//DÉBUT SWITCH DEVISE
	switch( $_SESSION['devise'] ) {
			case 'CUC' :	$image = 'images/cuba.gif';
					$prix = $prix_detail;
					break;
			case 'USD' :	$image = 'images/usa.gif';
					$prix = rounder($prix_detail * $TxCUC_USD);
					break;
			case 'EUR' :	$image = 'images/europe.gif';
					$prix = rounder(($prix_detail * $TxCUC_USD) * $TXUSD_EUR);
					break;
			default	: 	$image = 'images/canada.gif';
					$prix	= rounder(($prix_detail * $TxCUC_USD) * $TXUSD_CAD);
					break;
	} // switch devise
	
	// DÉBUT DE RÉCUPÉRATION DES DESCRIPTIONS
	if ( $produit['description_'.$Langue] and $produit['description_supplementaire_'.$Langue] == "" )
		//SI AUCUNE DESCRIPTION
		$description = $description_false;
	else { //SINON
		//ON CALCULE LA TAILLE
		if ( strlen($produit['description_'.$Langue]) ){
			//ON SUPPRIME LE TITRE ET LE CODE DANS LA DESCRIPTION
			$description1 = clean($produit['description_'.$Langue],$Code,$titre);
				/*	$description1 = str_replace($titre, "", $produit['description_'.$Langue]);
					$description1 = str_replace($Code, "", $description1);
					$description1 = str_replace("<", "", $description1);*/
			//ON FAIT UN SAUT DE LIGNE
			$description1 = wordwrap($description1, $nb_car_ligne,"<br/>");
			//ON COMPTE COMBIEN DE FOIS NOUS AVONS SAUTER DES LIGNES
			$nb_ligne+=substr_count($description1, "<br/>");
		}
		else //SI AUCUNE DESCRIPTION VARIALBE VAUT ""
			$description1 = '';
			//ON CALCULE LA TAILLE
		if ( strlen($produit['description_supplementaire_'.$Langue]) ){
			//ON SUPPRIME LE TITRE ET LE CODE DANS LA DESCRIPTION
			$description2 = clean($produit['description_supplementaire_'.$Langue],$Code,$titre);
				//$description2 = $produit['description_supplementaire_'.$Langue];
				/*$description2 = str_replace($titre, "", $produit['description_supplementaire_'.$Langue]);
			  	$description2 = str_replace($Code, "", $description2);
			  	$description2 = str_replace("<", "", $description2);*/
			//ON FAIT UN SAUT DE LIGNE
//			echo 'Avant : '.$description2.'<br/>';
			$description2 = wordwrap($description2, $nb_car_ligne,"<br/>");
			//ON COMPTE COMBIEN DE FOIS NOUS AVONS SAUTER DES LIGNES
			$nb_ligne+=substr_count($description2, "<br/>");
		}
		else //SI AUCUNE DESCRIPTION VARIALBE VAUT ""
			$description2 = '';
			
		$description = '<i>'.$description1.'</i>'.$description2;
		$QteStock = round($produit['QteStock']);
		$LeTitre = wordwrap($id.' '.$titre.' '.$Code, $nb_car_ligne,"<br/>");
		$nb_ligne+=substr_count($LeTitre, "<br/>");
	}
	//NOUS ÉTABLISSON NOTRE VARIABLE HTML
	$html .= "<p align=center><b>$LeTitre</b></p><br/>";
	$html .= $description.'<br/>';
	$html .= '<p align=left>'.$QteStock;
	$html .= '                                                     '.rounder($produit['prix_detail']).'';
	$html .= "$Symbole ".$_SESSION['devise'].'                                                     ';
	$html .= $produit['prix_promo']."$Symbole ".$_SESSION['devise'].'</p><br/>';
	$html .= '<p align=center>______________________________________________________________________________________________________________</p><br/>';
		//ON RETOURNE LE NOMBRE DE LIGNE UTILISER PAR LA VARIABLE HTML
//	echo 'Après : '.$html.'<br/>';
	return($nb_ligne * $point_par_ligne);
			
} // afficher_categorie_list

function MetPhoto( $id, $ref )
{
global $handle, $database, $LaPhoto , $pdf;
		if ($id == "")
    			$pdf->Image("images/nondisp.jpg",156,$pdf->GetY(),20,20,'JPEG');
		else {
			$LaPhoto =array();
			$sql = " SELECT * FROM $database.photo WHERE NoInvent=$id AND NoPhoto='$ref'";
			$result = mysql_query( $sql, $handle );
	
			mysql_num_rows($result);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
					
			$target = dirname(__FILE__)."/results/photo".$row['NoInvent'].".jpg";
			$f_handle = fopen( $target, "w", 1);
	
			if( fwrite($f_handle, $row['Photo']) === FALSE ) {
	  	   		MetMessErreur1();
			}    
			fclose ($f_handle);
			$LargX = 20;
			$HautY = 20;
			$L = $row['Largeur'];
			$H = $row['Hauteur'];
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
			$pdf->Image($target, 180,$pdf->GetY(),$LargX,$HautY,'JPEG');
	   }

} // MetPhoto


//DÉBUT DE LA FONCTION AFFICHE MENU
function create_catalogue($cat=0, $lvl=0, $online=0)
{
//NOS VARIALBE GLOBAL
global $larg,$html, $pdf, $prod_filter, $point_par_ligne,$top_marge, $police_point,
$nb_ligne_par_page, $point_par_ligne, $nb_point_entete, $Langue, $tri_cat, $prod, $status, $image, $counter, $AvecImage;

	$sousCats = get_categorie($cat, $online);
	$max_ligne_page = ($nb_ligne_par_page * $point_par_ligne);

	foreach( $sousCats as $categorie => $titre_cat ) {
		if( !$lvl )
			$pdf->AddPage();

		for( $i=0; $i < $lvl ; $i++ )
			$html .= " -> ";
		
		$titre_cat = strtoupper($titre_cat);
		$html .= "$titre_cat";
		if( $lvl ){
			//NOUS INCRÉMENTONS NOTRE VARIABLE HTML
//			$html .= "<br/><br/>";
			//NOUS AJOUTONS 2 LIGNE A NOTRE COUNTER
//			$counter += (2*$point_par_ligne);
		}
		//COMMENCEMENT DE VÉRIFICATION
		if(($counter + (1*$nb_point_entete)) > ($nb_ligne_par_page)){
			$counter=$top_marge;
			$pdf->AddPage();
			$pdf->SetFont('Times','B',$nb_point_entete);
			$pdf->WriteHTML($html);
			$pdf->SetFont('Times','',$police_point);
			$html = '';
		}
		else{
			$pdf->SetFont('Times','B',$nb_point_entete);
			$pdf->WriteHTML($html);
			$pdf->SetFont('Times','',$police_point);
			$html = '';
		}
		//FIN DE VÉRIFICATION
		$Prod_In_Cat = check_prod_into_cat_complete($categorie);

		if( $Prod_In_Cat ) {
			//NOUS INCRÉMENTONS NOTRE VARIABLE HTML
			$pdf->WriteHTML('<br/><br/>');
			//NOUS AJOUTONS 2 LIGNE A NOTRE COUNTER
			$produits = select_prod_cat($categorie, null, 1);
			while( $produit = @mysql_fetch_assoc( $produits ))
				if( !in_array( $produit['id'],$prod_filter ) ) {
					$prod_filter[] = $produit['id'];
					$counter_item = item_catalogue( $produit );
			//	echo 'valeur '.$AvecImage.'<br/>';
					// SI ON N'EST ARRIVER AU BAS DE LA PAGE ON AJOUTER UNE PAGE
					if( ( $counter + $counter_item ) < $max_ligne_page ){
						if( $AvecImage == "oui" )
							MetPhoto( $produit['id'], $produit['small']);
						
						$pdf->WriteHTML($html);	
						$counter += $counter_item;
					}
					//SINON ON CONTINUE
					else{
						$pdf->AddPage();
						$counter = $top_marge + $counter_item;
						if( $AvecImage == "oui" )
							MetPhoto($produit['id'], $produit['small']);
						$pdf->WriteHTML($html);
					}
					$html = '';
				
			}
		} // Sinon produit dans cat
		// RAPELLE D'AFFICHE MENU POUR SOUS CAT
		create_catalogue($categorie, ($lvl+1), $online);

		if( !$lvl ){
				$pdf->WriteHTML($html);
				$html = '';
		}
	
	} // for each


} 

//FIN FUNCTION AFFICHE MENU



$pdf=new PDF_HTML();
$pdf->Open();
//ON INSCRIT LE CRÉATEUR
$pdf->SetCreator($auteur_doc);
//ON INCRIT L'AUTEUR
$pdf->SetAuthor($auteur_doc);
//ON INSCRIT LE TITRE
$pdf->SetTitle($titre_doc);
//ON INSCRIT LE SUJET
$pdf->SetSubject($description_doc);
//ON INSCRIT LES MOTS CLÉS
$pdf->SetKeywords('Cosat Informatique Catalogue vente ordinateur pieces');
//ON INDIQUE LA GROSSEUR DE LA MARGE
$pdf->SetTopMargin($top_marge);
//ON INDIQUE LA FACON QU'ON AFFICHE LE PDF
/*********************************************************************************
*			Paramètres																																 *
*			SetDisplayMode(mixed zoom [, string layout])															 *
*			Le zoom à utiliser. Il peut prendre l'une des valeurs chaînes suivantes :  *
*			fullpage : affiche entièrement les pages à l'écran												 *
*			fullwidth : maximise la largeur des pages																	 *
*			real : affiche la taille réelle (équivaut à un zoom de 100%)               *
*			default : utilise le mode d'affichage par défaut du lecteur 							 *
*			La disposition des pages. Les valeurs possibles sont :                     *
*			single : affiche une seule page à la fois 																 *
*			continuous : affichage continu d'une page à l'autre                        *
*			two : affiche deux pages sur deux colonnes                                 *
*			default : utilise le mode d'affichage par défaut du lecteur                *
*********************************************************************************/
$pdf->SetDisplayMode('fullpage','single');
//ON CRÉE LA PAGE PRINCIPALE
$pdf->SetFont('Times','',25);
$pdf->AddPage();
$pdf->Image("images/logocosat.jpg",30,60,150,115, 'JPEG');

//$pdf->WriteHTML("<br/><br/><br/><br/><p align='center' style='vertical-align:middle'>$titre_doc</P>");
$pdf->WriteHTML("<br/><br/><br/><br/><p align='center' >$titre_doc</P>");
//ON INSCRIT LES NUMÉRO DE PAGE
$pdf->AliasNbPages();
  
//FIN DE LA PAGE PRINCIPALE
$pdf->SetFont($police_nom,'',$police_point);
create_catalogue(0,0,1);


/*****************************************************************************************************************
*    I : envoyer en inline au navigateur. Le plug-in est utilisé s'il est installé. 														 *
*		Le nom indiqué dans name est utilisé lorsque l'on sélectionne "enregistrer sous" sur le lien générant le PDF.*
*    D : envoyer au navigateur en forçant le téléchargement, avec le nom indiqué dans name.											 *
*    F : sauver dans un fichier local, avec le nom indiqué dans name. 																					 *
*    S : renvoyer le document sous forme de chaîne. name est ignoré. 																						 *
*****************************************************************************************************************/

$pdf->Output($titre_doc.'_'.$Langue.'.pdf',$pdf_mod);
?>