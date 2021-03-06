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
extract($_POST,EXTR_OVERWRITE);	 
$logo=array();

	if ( $Langue == "fr" ){
		$titre_doc = "ANTILLAS EXPRESS CATALOGUE";
		$description_doc = "CATALOGUE DES ARTICLES VENDU PAR ANTILLAS-EXPRESS";
		$description_false = "AUCUNE DESCRIPTION POUR CE PRODUIT";
	}
	else if ( $Langue == "en" ){
		$titre_doc = "ANTILLAS EXPRESS CATALOGUE";
		$description_doc = "CATALOGUE ARTICLES SOLD BY ANTILLAS-EXPRESS";
		$description_false = "NO DESCRIPTION FOR THIS PRODUCT";
	}
	elseif ( $Langue == "sp" ){
		$titre_doc = "ANTILLAS EXPRESS CAT�LOGO";
		$description_doc = "LOS ART�CULOS DEL CAT�LOGO VENDIERON POR ANTILLAS-EXPRESS";
		$description_false = "NINGUNA DESCRIPCI�N PARA ESTE PRODUCTO";
	}
	else{
		$titre_doc = "ANTILLAS EXPRESS CATALOGUE";
		$description_doc = "CATALOGUE DES ARTICLES VENDU PAR ANTILLAS-EXPRESS";
		$description_false = "AUCUNE DESCRIPTION POUR SE PRODUIT";
	}
	$auteur_doc = "Jean-Alexandre";

/*****************FIN VARIABLE GLOBAL************************/

//D�BUT FUNCTION clean
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
								$description = strip_tags( $description );
/*								$description = str_replace("<li>", "", $description);
								$description = str_replace("</li>", "", $description);
								$description = str_replace("<h3>", "", $description);
								$description = str_replace("</h3>", "", $description);
								$description = str_replace("<ul>", "", $description);
								$description = str_replace("</ul>", "", $description);
								$description = str_replace("<h2>", "", $description);
								$description = str_replace("</h2>", "", $description);*/
								$description = str_replace("<", "", $description);
								$description = str_replace("\"", "", $description);
								$description = stripslashes($description);
	return $description;
} // fin de la fonction : Clean ----------------------------------------------------------




//D�BUT FUNCTION SELECT_PROD_CAT
function select_prod_cat($idCat=0, $idProduit=0, $online=0, $page = 0, $parPage = 0)
//  FUNCTION : SELECT PROD_CAT
//  version : 1.0
//  date : 27-06-08
//  derniere modif : Jean-Alexandre Denis
//  info : s�lectionne les produits contenus dans une cat�gorie OU
//         les infos d'un produit selon son ID pass� en param�tre 2
{
global $handle, $mysql_base, $Langue, $tri_cat, $prod, $status, $image;
  	$sql = "SELECT DISTINCT * FROM $mysql_base.stock";
	$sql .= " LEFT JOIN $mysql_base.catalogue_produits ON id = $mysql_base.catalogue_produits.id_produit";
	$sql .= " WHERE $mysql_base.catalogue_produits.id_catalogue = '$idCat'"; // AND Qte_Max_Livre > 0";

    if( $idProduit )
        $sql .= " AND id =$idProduit LIMIT 1";

    if( $status == 1 )
        $sql .= " AND online = '1'";
		else if ( $status == 0 )
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
		else if ( $prod == "titre" )
				$sql .= " ORDER BY titre_$Langue ASC;";
		else {
				$sql .= " ORDER BY Code ASC;";}
//echo $sql."<br>";
    $result = mysql_query($sql, $handle);
    if( !$result )
		Message_Erreur( "ERROR", "Erreur acc�s selectionProduits", mysql_errno()." : ".mysql_error()."<br>".$sql );			

	// si aucune donn�es
	if( !mysql_num_rows($result) )
		return false;
	else   // sinon retour des valeurs
		return $result;
} // fin de la fonction : select_prod_cat 


//D�BUT FUNCTION GET_CAT�GORIE
function get_categorie($upCat, $online = 0)
//  FUNCTION : get_categorie
//  version : 1.0
//  date : 27-08-08
//  derniere modif : Jean-Alexandre
//  info : S�lectionne les sous_cat�gories directes � la cat�gorie pass�e en param�tre
{
 global $handle, $mysql_base, $Langue, $tri_cat, $prod, $status, $image;
   $categories = array();

	$sql = "SELECT id, ".$Langue." AS titre_cat FROM $mysql_base.catalogue WHERE parent ='$upCat'";

	if( $online ) 
		$sql .= " AND online = $online";
		if ( $tri_cat == "alpha" )
			$sql .=' ORDER BY '.$Langue.' ASC';
		else
			$sql .=' ORDER BY ordre ASC';
	
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur acc�s get_subcats", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	while( $r = mysql_fetch_assoc($result) )
		$categories[$r['id']] = $r['titre_cat'];
	
	return $categories;
} // fin de la fonction : get_CATEGORIE ----------------------------------------------------------


//D�BUT FUNCTION AFFICHER PRODUIT
	function item_catalogue( $produit  )
//  FUNCTION : item_catalogue
//  version : 1.0
//  date : 27-08-08
//  derniere modif : Jean-Alexandre
//  info : S�lectionne les items dans chacune des cat�gories.
		
		{
		// INCLUDE DES VARIABLE GLOBAL
			global $param, $handle, $txt, $mysql_base, $TxCUC_USD,$TXUSD_CAD,$TXUSD_EUR,$SymbCUC,$SymbUSD,
			$SymbCAD,$SymbEUR,$html,$pdf, $logo, $this,$point_par_ligne,$nb_car_ligne, $Langue, $tri_cat, $prod, $status, $image, $description_false;
			$nb_ligne = 5;
			
			//$_SESSION['TotProd']++;
			extract($produit);
			//S�LECTION DU TITRE EN FUNCTION DE LA LANGUE DU SITE
			$titre = stripslashes($produit['titre_'.$Langue]);
			//S�LECTION DE LA DEVISE EN FUNCTION DE LA LANGUE DU SITE
			$Symbole	=	get_Symbole($_SESSION['devise']);
			//D�BUT SWITCH DEVISE
			switch( $_SESSION['devise'] ) {
					case 'CUC'	:	$image = 'images/cuba.gif';
					$prix = $prix_detail;
				break;
					case 'USD'	:	$image = 'images/usa.gif';
					$prix	=	rounder($prix_detail * $TxCUC_USD);
				break;
					case 'EUR'	:	$image = 'images/europe.gif';
					$prix	=	rounder(($prix_detail * $TxCUC_USD) * $TXUSD_EUR);
				break;
					default		:  $image = 'images/canada.gif';
					$prix	=	rounder(($prix_detail * $TxCUC_USD) * $TXUSD_CAD);
				break;
			} // switch devise
			
			//D�BUT DE R�CUP�RATION DES DESCRIPTIONS
			if ( $produit['description_'.$Langue] and $produit['description_supplementaire_'.$Langue] == "" )
				//SI AUCUNE DESCRIPTION
				$description = $description_false;
			else {
			//SINON
				//ON CALCULE LA TAILLE
				if ( strlen($produit['description_'.$Langue]) ){
							//ON SUPPRIME LE TITRE ET LE CODE DANS LA DESCRIPTION
						$description1 = clean($produit['description_'.$Langue],$Code,$titre);
						/*	$description1 = str_replace($titre, "", $produit['description_'.$Langue]);
							$description1 = str_replace($Code, "", $description1);
							$description1 = str_replace("<", "", $description1);*/
							//ON FAIT UN SAUT DE LIGNE
							$description1 = wordwrap($description1, $nb_car_ligne,"<br>");
							//ON COMPTE COMBIEN DE FOIS NOUS AVONS SAUTER DES LIGNES
							$nb_ligne+=substr_count($description1, "<br>");
				}
				else
				//SI AUCUNE DESCRIPTION VARIALBE VAUT ""
					$description1 = '';
					//ON CALCULE LA TAILLE
				if ( strlen($produit['description_supplementaire_'.$Langue]) ){
					//ON SUPPRIME LE TITRE ET LE CODE DANS LA DESCRIPTION
						$description2 = clean($produit['description_supplementaire_'.$Langue],$Code,$titre);
					/*$description2 = str_replace($titre, "", $produit['description_supplementaire_'.$Langue]);
				  $description2 = str_replace($Code, "", $description2);
				  $description2 = str_replace("<", "", $description2);*/
					//ON FAIT UN SAUT DE LIGNE
					$description2 = wordwrap($description2, $nb_car_ligne,"<br>");
					//ON COMPTE COMBIEN DE FOIS NOUS AVONS SAUTER DES LIGNES
					$nb_ligne+=substr_count($description2, "<br>");
				}
				else
				//SI AUCUNE DESCRIPTION VARIALBE VAUT ""
					$description2 = '';
					
				$description = $description1.$description2;
				$QteStock = round($produit['QteStock']);
			}
			//NOUS �TABLISSON NOTRE VARIABLE HTML
			$html .= "<p align=left>$id $titre $Code</p><br>";
			$html .= ''.stripslashes($description).' <br>';
			$html .= '<p align=left>'.$QteStock;
			$html .= '                                                     '.rounder($produit['prix_detail']).'';
			$html .= "$Symbole ".$_SESSION['devise'].'                                                     ';
			$html .= $produit['prix_promo']."$Symbole ".$_SESSION['devise'].'</p><br>';
			$html .= '<p align=center>______________________________________________________________________________________________________________</p><br>';
//			$html .= '<p align=center>_______________________________________________________________________________________________';
				//ON RETOURNE LE NOMBRE DE LIGNE UTILISER PAR LA VARIABLE HTML
				return($nb_ligne * $point_par_ligne);
					
		} // afficher_categorie_list

function toto( $pdf, $id, $ref )
{
global $handle, $mysql_base, $logo;
		if ($id == "")
    		$pdf->Image("images/nondisp.jpg",156,$pdf->GetY(),20,20,'JPEG');
		else {
			$sql = " SELECT * FROM $mysql_base.photo WHERE NoInvent=$id AND NoPhoto='$ref'";
			$result = mysql_query( $sql, $handle );
	
			mysql_num_rows($result);
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
	
			$logo = $row['Photo'];
	//Affichage (n�cessite PHP>=4.3.2 et FPDF>=1.52)
			$pdf->Image('var://logo', 156,$pdf->GetY(),20,20,'JPEG');
	   }

} // toto


//D�BUT DE LA FONCTION AFFICHE MENU
function create_catalogue($cat=0, $lvl=0, $online=0)
{
//NOS VARIALBE GLOBAL
global $larg,$html, $pdf, $prod_filter, $mysql_base, $handle, $logo, $this,$point_par_ligne,$top_marge, $police_point,
$nb_ligne_par_page, $point_par_ligne, $nb_point_entete, $Langue, $tri_cat, $prod, $status, $image, $counter;

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
			//NOUS INCR�MENTONS NOTRE VARIABLE HTML
//			$html .= "<br><br>";
			//NOUS AJOUTONS 2 LIGNE A NOTRE COUNTER
//			$counter += (2*$point_par_ligne);
		}
		//COMMENCEMENT DE V�RIFICATION
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
		//FIN DE V�RIFICATION
		$Prod_In_Cat = check_prod_into_cat_complete($categorie);

		if( $Prod_In_Cat ) {
			//NOUS INCR�MENTONS NOTRE VARIABLE HTML
			$pdf->WriteHTML('<br><br>');
			//NOUS AJOUTONS 2 LIGNE A NOTRE COUNTER
//			$counter += (1*$point_par_ligne);
			$produits = select_prod_cat($categorie, null, 1);
			while( $produit = @mysql_fetch_assoc( $produits ))
				if( !in_array( $produit['id'],$prod_filter ) ) {
					$prod_filter[] = $produit['id'];
					$counter_item = item_catalogue( $produit );
//					$html .= $max_ligne_page." -- $counter $counter_item</p><br>";;
					// SI ON N'EST ARRIVER AU BAS DE LA PAGE ON AJOUTER UNE PAGE
					if( ( $counter + $counter_item ) < $max_ligne_page ){
//						$pdf->Rect(1, $counter, 200, $counter_item ); 
						$pdf->Image("images/nondisp.jpg",156,$pdf->GetY(),20,20,'JPEG');
						$pdf->WriteHTML($html);	
						 
//						$pdf->Image("images/nondisp.jpg",156,$counter,20,20,'JPEG');
						$counter += $counter_item;
					}
					//SINON ON CONTINUE
					else{
//							$pdf->WriteHTML("Saut $t $max_ligne_page<br>");
						$pdf->AddPage();
						$counter = $top_marge + $counter_item;
						toto($pdf, $produit['id'], $produit['small']);
//						$pdf->Image("images/nondisp.jpg",156,$pdf->GetY(),20,20,'JPEG');
						$pdf->WriteHTML($html);
//						$pdf->Image("images/nondisp.jpg",156, $counter,20,20,'JPEG');
//						$pdf->Image("photoget_web.php?No=".$produit['id']."&Idx=1",160, $counter,20,20,'JPEG');
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
//ON INSCRIT LE CR�ATEUR
$pdf->SetCreator($auteur_doc);
//ON INCRIT L'AUTEUR
$pdf->SetAuthor($auteur_doc);
//ON INSCRIT LE TITRE
$pdf->SetTitle($titre_doc);
//ON INSCRIT LE SUJET
$pdf->SetSubject($description_doc);
//ON INSCRIT LES MOTS CL�S
$pdf->SetKeywords('Antillas-express Catalogue vente cuba');
//ON INDIQUE LA GROSSEUR DE LA MARGE
$pdf->SetTopMargin($top_marge);
//ON INDIQUE LA FACON QU'ON AFFICHE LE PDF
/*********************************************************************************
*			Param�tres																																 *
*			SetDisplayMode(mixed zoom [, string layout])															 *
*			Le zoom � utiliser. Il peut prendre l'une des valeurs cha�nes suivantes :  *
*			fullpage : affiche enti�rement les pages � l'�cran												 *
*			fullwidth : maximise la largeur des pages																	 *
*			real : affiche la taille r�elle (�quivaut � un zoom de 100%)               *
*			default : utilise le mode d'affichage par d�faut du lecteur 							 *
*			La disposition des pages. Les valeurs possibles sont :                     *
*			single : affiche une seule page � la fois 																 *
*			continuous : affichage continu d'une page � l'autre                        *
*			two : affiche deux pages sur deux colonnes                                 *
*			default : utilise le mode d'affichage par d�faut du lecteur                *
*********************************************************************************/
$pdf->SetDisplayMode('fullpage','single');
//ON CR�E LA PAGE PRINCIPALE
$pdf->SetFont('Times','',25);
$pdf->AddPage();
$pdf->Image("images/antillas_express.jpg",-25,0,250,0, 'JPEG');

//$pdf->WriteHTML("<br><br><br><br><p align='center' style='vertical-align:middle'>$titre_doc</P>");
$pdf->WriteHTML("<br><br><br><br><p align='center' >$titre_doc</P>");
//ON INSCRIT LES NUM�RO DE PAGE
$pdf->AliasNbPages();
  
//FIN DE LA PAGE PRINCIPALE
$pdf->SetFont($police_nom,'',$police_point);
create_catalogue(0,0,1);


/*****************************************************************************************************************
*    I : envoyer en inline au navigateur. Le plug-in est utilis� s'il est install�. 														 *
*		Le nom indiqu� dans name est utilis� lorsque l'on s�lectionne "enregistrer sous" sur le lien g�n�rant le PDF.*
*    D : envoyer au navigateur en for�ant le t�l�chargement, avec le nom indiqu� dans name.											 *
*    F : sauver dans un fichier local, avec le nom indiqu� dans name. 																					 *
*    S : renvoyer le document sous forme de cha�ne. name est ignor�. 																						 *
*****************************************************************************************************************/

$pdf->Output($titre_doc.'_'.$Langue.'.pdf',$pdf_mod);
//$pdf->Output('Catalogue Antillas-express.pdf','I');
//$pdf->Output('Catalogue Antillas-express.pdf','D');
//$pdf->Output('Catalogue Antillas-express.pdf','F');
//$pdf->Output('Catalogue Antillas-express.pdf','S');
?>