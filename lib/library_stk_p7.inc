<?php
//* Auteur : Denis Léveillé 	 		  Date : 2016-05-17

// DEBUT CONSTANTE --


$_SESSION['MCSTK_ERREUR'] = 0;

/*
Table des matières des functions
___________________________
function init_stock()
function mcstk_load_param()
function info_MCStk( $NumInv )
function insert_mcstk_dept($TabDept)
function update_mcstk_dept($TabDept)
function insert_mcstk_item($TabItem)


INSERT INTO `webmenu` (`No`, `Page`, `Niveau`, `Titre_fr`, `Titre_en`, `Titre_sp`, `RefPage`, `Parametre`, `TopMenu`, `Affichable`) VALUES
(175, 'Inventaire', 9, 'Paramètre Inventaire', 'Stock Parameter', '', 'stk/mcstk_param', '', NULL, 'Oui');
COMMIT;

*/

// ~~~~~~~~~~~~~~ DEBUT FUNCTIONS  ~~~~~~~~~~~~~~~~

function init_stock()
//**********************************************************************************************
//  FUNCTION : init_stock
//  version : 2.0
//  date : 2017-06-09
//  derniere modif : Denis Léveillé
//  info : vérification de la disponibilité des table necessaire à l'inventaire
{
global $mabd, $database;

	//echo "Dans init_stock <br />";
	$sql = "SELECT * FROM $database.mcistock";
	if( !($result = $mabd->query($sql))  )  {
	
		// -- Structure de la table `mcisys`
		
		$sql = "CREATE TABLE `mcisys` (";
  		$sql .= "`Version` float NOT NULL DEFAULT '0',";
  		$sql .= "`NextNoBonCmd` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`NextNoINV` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Total` float NOT NULL DEFAULT '0',";
  		$sql .= "`Nom` varchar(40) NOT NULL DEFAULT '',";
  		$sql .= "`Fax` varchar(14) NOT NULL DEFAULT '',";
  		$sql .= "`LienFournisseur` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`LienBanqueAchat` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`NoImpBon` int(1) NOT NULL DEFAULT '0',";
  		$sql .= "`TypEtik` int(1) NOT NULL DEFAULT '0',";
  		$sql .= "`NoImpEtik` int(1) NOT NULL DEFAULT '0',";
  		$sql .= "`SecurMax` varchar(1) NOT NULL DEFAULT '',";
  		$sql .= "`Calcul_Auto` varchar(1) NOT NULL DEFAULT ''";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Creation mcisys : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}

		$sql = "INSERT IGNORE INTO `mcisys` (`Version`, `NextNoBonCmd`, `NextNoINV`, `Total`, `Nom`, `Fax`, `LienFournisseur`, `LienBanqueAchat`, `NoImpBon`, `TypEtik`, `NoImpEtik`, `SecurMax`, `Calcul_Auto`) VALUES";
		$sql .= "(2.1, 1, 1, 2.1, '', '', 0, 0, 0, 0, 0, 'N', 'O');";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR insert mcisys : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}
		
		//-- Structure de la table `mcistock`

		$sql = "CREATE TABLE `mcistock` (";
  		$sql .= "`NumInv` varchar(8) NOT NULL DEFAULT '',";         
  		$sql .= "`Description` varchar(100) NOT NULL DEFAULT '',";  
  		$sql .= "`Manufacturier` varchar(15) NOT NULL DEFAULT '',"; 
  		$sql .= "`CodProd` varchar(16) NOT NULL DEFAULT '',";       
  		$sql .= "`DernierPaye` decimal(8,2) DEFAULT NULL,";         
  		$sql .= "`Cout_Moyen` decimal(8,2) DEFAULT NULL,";          
  		$sql .= "`Vente1` decimal(8,2) DEFAULT NULL,";              
  		$sql .= "`Vente2` decimal(8,2) DEFAULT NULL,";              
  		$sql .= "`Vente3` decimal(8,2) DEFAULT NULL,";              
  		$sql .= "`Detail_Suggere` decimal(8,2) DEFAULT NULL,";      
  		$sql .= "`Date_Exp` date DEFAULT NULL,";                    
  		$sql .= "`Taxe` varchar(1) NOT NULL DEFAULT '',";           
  		$sql .= "`AvecNoSerie` varchar(1) NOT NULL DEFAULT '',";    
  		$sql .= "`Stk` float DEFAULT NULL,";                        
  		$sql .= "`Comm` float DEFAULT NULL,";                       
  		$sql .= "`BO` float DEFAULT NULL,";                         
  		$sql .= "`Ven` float DEFAULT NULL,";                        
  		$sql .= "`Demo` float DEFAULT NULL,";                       
  		$sql .= "`Min` int(3) NOT NULL DEFAULT '1',";               
  		$sql .= "`Max` int(3) NOT NULL DEFAULT '10',";              
  		$sql .= "`Promo` varchar(1) NOT NULL DEFAULT '',";          
  		$sql .= "`CodBar` varchar(24) NOT NULL DEFAULT '',";        
  		$sql .= "`Prix_Actif` varchar(1) NOT NULL DEFAULT '',";     
  		$sql .= "`Package` varchar(1) NOT NULL DEFAULT '',";        
  		$sql .= "`Rep` int(3) NOT NULL DEFAULT '0',";               
  		$sql .= "`CalcAuto` varchar(1) NOT NULL DEFAULT '',";       
  		$sql .= "`Date_Creation` varchar(10) NOT NULL DEFAULT '',"; 
  		$sql .= "`Edition` int(2) NOT NULL DEFAULT '0',";           
  		$sql .= "`Auteur` varchar(50) NOT NULL DEFAULT '',";        
  		$sql .= "`Unit_Achat` varchar(1) NOT NULL DEFAULT '',";     
  		$sql .= "`Unit_Vente` varchar(1) NOT NULL DEFAULT '',";     
  		$sql .= "`Unite` varchar(1) NOT NULL DEFAULT '',";          
  		$sql .= "`Marge` float NOT NULL DEFAULT '0',";              
  		$sql .= "`TPS` varchar(1) NOT NULL DEFAULT '',";            
  		$sql .= "`TVP` varchar(1) NOT NULL DEFAULT '',";            
  		$sql .= "`DateAjout` date DEFAULT NULL,";                   
  		$sql .= "`DateMAJ` date DEFAULT NULL,";                     
  		$sql .= "`length` float DEFAULT NULL,";                     
  		$sql .= "`width` float DEFAULT NULL,";                      
  		$sql .= "`height` float DEFAULT NULL,";                     
  		$sql .= "`weight` float DEFAULT NULL,";                     
  		$sql .= "`Markup` decimal(4,2) DEFAULT NULL,";              
  		$sql .= "`titre_fr` varchar(100) DEFAULT NULL,";            
  		$sql .= "`titre_en` varchar(100) DEFAULT NULL,";            
  		$sql .= "`description_fr` text,";                           
  		$sql .= "`description_en` text,";                           
  		$sql .= "`description_supplementaire_fr` text,";            
  		$sql .= "`description_supplementaire_en` text,";            
  		$sql .= "`small` tinyint(4) DEFAULT NULL,";                 
  		$sql .= "`medium` tinyint(4) DEFAULT NULL,";                
  		$sql .= "`big` tinyint(4) DEFAULT NULL,";                   
  		$sql .= "`online` enum('Oui','Non') NOT NULL DEFAULT 'Oui'";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Creation mcistock : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}        
           
		//-- Index pour la table `mcistock`
		
		$sql = "ALTER TABLE `mcistock`";
		$sql .= " ADD PRIMARY KEY (`NumInv`),";
		$sql .= " ADD KEY `Description` (`Description`),";
		$sql .= " ADD KEY `Manufacturier` (`Manufacturier`),";
		$sql .= " ADD KEY `CodProd` (`CodProd`),";
		$sql .= " ADD KEY `CodBar` (`CodBar`);";  

		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR index mcistock : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}        
	
		// Structure de la table `mcidepartmttmt`

		$sql = "CREATE TABLE `mcidepartmttmt` (";
  		$sql .= "`Rayon` varchar(1) NOT NULL DEFAULT '',";
  		$sql .= "`CategDept` varchar(3) NOT NULL DEFAULT '',";
  		$sql .= "`Description` varchar(40) NOT NULL DEFAULT '',";
  		$sql .= "`NextNoInv` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Break1` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup1` float NOT NULL DEFAULT '0',";
  		$sql .= "`Break2` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup2` float NOT NULL DEFAULT '0',";
  		$sql .= "`Break3` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup3` float NOT NULL DEFAULT '0',";
  		$sql .= "`Break4` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup4` float NOT NULL DEFAULT '0',";
  		$sql .= "`Break5` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup5` float NOT NULL DEFAULT '0',";
  		$sql .= "`Break6` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup6` float NOT NULL DEFAULT '0',";
  		$sql .= "`Break7` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`Markup7` float NOT NULL DEFAULT '0',";
  		$sql .= "`NoGLVente` int(5) NOT NULL DEFAULT '0',";
  		$sql .= "`NoGLAchat` int(5) NOT NULL DEFAULT '0'";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Creation mcidepartmttmt : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}

		// -- Index pour la table `mcfctitm`

		$sql = "ALTER TABLE `mcidepartmttmt`";
		$sql .= " ADD PRIMARY KEY (`Rayon`,`CategDept`);";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Index mcidepartmttmt : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}

		//-- Contenu de la table `webmenu`

		$sql = "INSERT IGNORE INTO `webmenu` (`No`, `Page`, `Niveau`, `Titre_fr`, `Titre_en`, `Titre_sp`, `RefPage`, `Parametre`, `TopMenu`, `Affichable`) VALUES";
  		$sql .= "(160, 'Département', 1, 'Ajout Département', 'Department Add', '', 'stk/mcstk_dept_ajout', '', 0, 'Oui'),";
  		$sql .= "(161, 'Département', 1, 'Modification Département', 'Department Modify', '', 'stk/mcstk_dept_traite', '', 0, 'Oui'),";
  		$sql .= "(162, 'Département', 1, 'Recherche Département', 'Department Search', '', 'stk/mcstk_dept_recherche', '', 0, 'Oui'),";
  		$sql .= "(163, 'Département', 1, 'Liste des Départements', 'Departments List', '', 'stk/mcstk_dept_liste', '', 0, 'Oui'),";
  		$sql .= "(170, 'Inventaire', 1, 'Ajout Inventaire', 'Inventory Add', '', 'stk/mcstk_ajout', '', 0, 'Oui'),";
  		$sql .= "(171, 'Inventaire', 1, 'Modification Inventaire', 'Inventory Modify', '', 'stk/mcstk_traite', '', 0, 'Oui'),";
  		$sql .= "(172, 'Inventaire', 1, 'Inventaire', 'Inventory', '', 'stk/mcstk_recherche', '', 0, 'Oui'),";
  		$sql .= "(173, 'Inventaire', 1, 'Rapport Inventaire', 'Inventory Report', '', 'stk/mcstk_rapstk', '', 0, 'Oui'),";
  		$sql .= "(174, 'Inventaire', 9, 'Menu gestion', 'Management menu', '', 'stk/mcstk_main', '', NULL, 'Oui'),";
  		$sql .= "(175, 'Inventaire', 9, 'Paramètre Inventaire', 'Stock Parameter', '', 'stk/mcstk_param', '', NULL, 'Oui');";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Insertion webmenu : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}

		//-- Contenu de la table `webpage`		
		$sql = "INSERT IGNORE INTO `webpage` (`Page`, `Titre`, `PosMenu`, `border`, `width`, `height`, `Autre`, `font_family`, `font_size`, `background_color`, `background_image`, `background_size`, `background_position`, `background_repeat`, `background_attachment`, `position`, `margin`, `padding`, `Affichable`, `FFileName`, `FFileSize`, `FFileType`, `large`, `haut`, `opacity`, `frame`, `Fond`) VALUES";
  		$sql .= "('mcstk_ajout', 'page d\'ajout Inventaire', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_dept_ajout', 'page d\'ajout de departement', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_dept_liste', 'page de recherche de departement', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_dept_recherche', 'page de recherche de departement', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_dept_traite', 'page de traitement de departement', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_main', 'page de traitement de departement', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_param', 'page de traitement de departement', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_rapstk', 'Rapport inventaire', NULL, 'none', '100%', '100%', 'min-height: 100%', 'Arial,Helvetica,sans-serif', '8pt ! important;', '#2d2d2d', './gifs/bodyback.gif', '', 'center', 'repeat', 'scroll', '', '0px', '0px', 'Oui', '', '', 'text/html', '100%', '100%', 0, '0', NULL),";
  		$sql .= "('mcstk_recherche', 'page de recherche Inventaire', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL),";
  		$sql .= "('mcstk_traite', 'page de modification Inventaire', NULL, '', 'auto', 'auto', 'min-height: 100%', 'Verdana, Arial, Helvetica, sans-serif', '8pt ! important', '#fff', './gifs/bodyback.gif', 'contain', 'top center', 'repeat-x repeat-y', 'fixed', '', '0px', '0px', 'Oui', '', '', 'image/pjpeg', '', '', 0, '', NULL);";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Insertion webpage : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}
		
		//-- Contenu de la table `webobjet`		
		$sql = "INSERT IGNORE INTO `webobjet` (`Page`, `Titre`, `Niveau`, `CType`, `Autre`, `border`, `border_radius`, `font_family`, `font_size`, `font_weight`, `font_style`, `text_decoration`, `text_transform`, `text_align`, `line_height`, `color`, `background_color`, `background_image`, `background_position`, `background_repeat`, `background_attachment`, `background_data`, `background_size`, `CSSFloat`, `Clear`, `width`, `height`, `position`, `left`, `right`, `top`, `bottom`, `margin`, `padding`, `align`, `zindex`, `Display`, `visibility`, `opacity`, `frame`, `limage`) VALUES";
  		$sql .= "('mcstk_ajout', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_dep_ajout', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_dep_liste', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_dep_recherche', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_dep_traite', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_main', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_param', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_rapstk', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_recherche', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL),";
  		$sql .= "('mcstk_traite', 'contenu', 0, 'ID', 'min-height : 300px', '', NULL, 'Verdana, Arial, Helvetica, sans-serif', 'inherit', 'normal', 'normal', 'none', 'none', 'inherit', 'normal', '#000', 'transparent', '', '', '', '', NULL, '', 'none', 'none', '970px', 'auto', 'relative', '0px', '0px', '0px', '', '40px auto', '0px', '', '1', 'block', 'Oui', 0, '', NULL);";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MCSTK_ERREUR'] = 1;
			$_SESSION['MCSTK_MESSAGE'] = "ERREUR Insertion webobjet : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}
		
		
	} //  Si table n'existe pas
		
	

	return ( 1 );


} // fin de la fonction : init_stock


function mcstk_load_param()
//**********************************************************************************************
//  FUNCTION : mcstk_load_param
//  version : 2.0
//  date : 2017-06-08
//  derniere modif : Denis Léveillé
//  info : Chargement des paramatre de l'inventaire
{
global $handle, $database,$MCIVersion,$MCINextNoBonCmd,$MCILienFournisseur,$MCILienBanqueAchat,$MCISecurMax,$MCICalcul_Auto;

	$_SESSION['MCSTK_ERREUR'] = 0;
	//echo "Dans info_facture : $serie $NoFct <br>";
	$sql = "SELECT * FROM $database.mcisys;";
	if( ($result = mysql_query( $sql, $handle )) == 0   )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR info_MCStk Inventaire : ".mysql_errno().": ".mysql_error()."<br>".$sql;
		return( 0 );
	}
		
	// si aucune données
	if( mysql_num_rows($result) != 0 ) {
		$infosParam= mysql_fetch_assoc($result);
		
		$MCIVersion = $infosParam['Version'];
		$MCINextNoBonCmd = $infosParam['NextNoBonCmd'];
		$MCILienFournisseur = $infosParam['LienFournisseur'];
		$MCILienBanqueAchat = $infosParam['LienBanqueAchat'];
		$MCISecurMax = $infosParam['SecurMax'];
		$MCICalcul_Auto = $infosParam['Calcul_Auto'];

	}
	else
		$infosParam = array();
	

	return ($infosParam);


} // fin de la fonction : mcstk_load_param


function info_MCStk( $NoInventaire )
//  FUNCTION : info_facture
//  version : 2.0
//  date : 15-09-01
//  derniere modif : Denis Léveillé
//  info : Selectionne les infos : Facture
{
global $mabd, $database;

	//echo "Dans info_facture : $serie $NoFct <br>";
	$_SESSION['MCSTK_ERREUR'] = 0;
	$sql = "SELECT * FROM $database.mcistock WHERE `NumInv` = '$NoInventaire' LIMIT 1;";
	if( !($result = $mabd->query($sql)) )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR info_MCStk Inventaire : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
		return( 0 );
	}
		
	// si aucune données
	if( $result->num_rows != false ) {
		$infosStock = $result->fetch_assoc();
	}
	else
		$infosStock = array();
	

	return ($infosStock);


} // fin de la fonction : info_MCStk

function insert_mcstk_dept($TabDept)
//  FUNCTION : insert_client
//  version : 2.0
//  date : 2007-11-01, 2015-08-21
//  derniere modif : Denis Léveillé
//  info : Insere les variables de la BD : clients
{
global $mabd, $database, $PrioCompte, $txt, $Now;
	// Si POST est vide
	$_SESSION['MCSTK_ERREUR'] = 0;
	if( empty($TabDept) ) {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "Impossible insert_mcstk_dept ajouter info Département VIDE.<br>";
		return( 0 );
	}
			
	extract( $TabDept, EXTR_OVERWRITE );

	
	$Description = myAddSlashes($Description);
	
	$sql =  "INSERT INTO $database.mcidepartmt (`Rayon`, `CategDept`, `Description`, `NextNoInv`, `Break1`, `Markup1`, `Break2`, `Markup2`,";
	$sql .=  " `Break3`, `Markup3`, `Break4`, `Markup4`, `Break5`, `Markup5`, `Break6`, `Markup6`, `Break7`, `Markup7`, `NoGLVente`,";
	$sql .=  " `NoGLAchat`) VALUES";
	$sql .=  " ('$Rayon', '$CategDept', '".myAddSlashes($Description)."', '$NextNoInv', '$Break1', '$Markup1', '$Break2', '$Markup2',"; 
	$sql .=  " '$Break3', '$Markup3', '$Break4', '$Markup4', '$Break5', '$Markup5', '$Break6', '$Markup6', '$Break7', '$Markup7',"; 
	$sql .=  " '$NoGLAchat', '$NoGLVente' );";  
//	echo $sql."<br>";
//	$mabd->query($sql)
//		or die( $mabd->errno.' ERREUR Client : '.$mabd->error );

	if( !$mabd->query($sql) )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR insert_mcstk_dept Département : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
		return( 0 );
	}

//	mysql_insert_id( $mabd );

		// **** ON LAISSE UNE TRACE DE L'OPÉRATION

	$Mess = "Insert Département $Rayon $CategDept";
	Suivi_log($Mess, $CategDept);
	
	return 1;


} // insert_mcstk_dept

function update_mcstk_dept($TabDept)
//  FUNCTION : insert_client
//  version : 2.0
//  date : 2007-11-01, 2015-08-21
//  derniere modif : Denis Léveillé
//  info : Insere les variables de la BD : clients
{
global $mabd, $database, $PrioCompte, $txt, $Now;
	// Si POST est vide
	$_SESSION['MCSTK_ERREUR'] = 0;
	if( empty($TabDept) ) {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "Impossible update_mcstk_dept modification info Département VIDE.<br>";
		return( 0 );
	}
			
	extract( $TabDept, EXTR_OVERWRITE );

	
	$Description = myAddSlashes($Description);

	$sql =  "UPDATE $database.mcidepartmt SET `Description`='".myAddSlashes($Description)."', `NextNoInv`='$NextNoInv', `Break1`='$Break1',";
	$sql .=  " `Markup1`='$Markup1', `Break2`='$Break2', `Markup2`='$Markup2', `Break3`='$Break3', `Markup3`='$Markup3', `Break4`='$Break4',";
	$sql .=  " `Markup4`='$Markup4', `Break5`='$Break5', `Markup5`='$Markup5', `Break6`='$Break6', `Markup6`='$Markup6', `Break7`='$Break7',";
	$sql .=  " `Markup7`='$Markup7', `NoGLVente`='$NoGLVente',`NoGLAchat`='$NoGLAchat'";
	$sql .=  " WHERE `Rayon`='$Rayon' AND `CategDept`='$CategDept' ";
//	echo $sql."<br>";
//	$mabd->query($sql)
//		or die( $mabd->errno.' ERREUR Client : '.$mabd->error );

	if( !$mabd->query($sql) )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR update_mcstk_dept Département : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
		return( 0 );
	}


		// **** ON LAISSE UNE TRACE DE L'OPÉRATION

	$Mess = "Update Département $Rayon $CategDept";
	Suivi_log($Mess, $CategDept);
	
	return 1;


} // insert_mcstk_dept

function insert_mcstk_item($TabItem)
//  FUNCTION : insert_mcstk_item
//  version : 2.0
//  date : 2016-06-10
//  derniere modif : Denis Léveillé
//  info : Insere les variables de la BD : item de l'inventaire
{
global $mabd, $database, $PrioCompte, $txt, $Now;
	// Si POST est vide
	$_SESSION['MCSTK_ERREUR'] = 0;
	if( empty($TabItem) ) {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "Impossible insert_mcstk_item ajouter TabItem VIDE.<br>";
		return( 0 );
	}
			
	extract( $TabItem, EXTR_OVERWRITE );

	
	$Description = myAddSlashes($Description);
	$Manufacturier = myAddSlashes($Manufacturier);
	$titre_fr = myAddSlashes($titre_fr );
	$titre_en = myAddSlashes($titre_en );
	$description_fr = myAddSlashes($description_fr ); 
	$description_en = myAddSlashes($description_en );
	$description_supplementaire_fr = myAddSlashes($description_supplementaire_fr ); 
	$description_supplementaire_en = myAddSlashes($description_supplementaire_en );
	$Auteur = myAddSlashes($Auteur);
	

	$sql =  "INSERT IGNORE INTO $database.mcistock SET";
	$sql .=  " `NumInv`='$NumInv',";
	$sql .=  " `Description`='$Description', `Manufacturier`='$Manufacturier', `CodProd`='$CodProd',";
//	$sql .=  "'".myAddSlashes($Description)."', '".myAddSlashes($Manufacturier)."', '$CodProd', "; lus haut
	if( $DernierPaye != 0 )
		$sql .=  "`DernierPaye`='$DernierPaye',";
	if( $Cout_Moyen != 0 )
		$sql .=  "`Cout_Moyen`='$Cout_Moyen',";
	if( $Vente1 != 0 )
		$sql .=  "`Vente1`='$Vente1',";
	if( $Vente2 != 0 )
		$sql .=  "`Vente2`='$Vente2',";
	if( $Vente3 != 0 )
		$sql .=  "`Vente3`='$Vente3',";
	if( $Detail_Suggere != 0 )
		$sql .=  "`Detail_Suggere`='$Detail_Suggere',";
	if( strlen($Date_Exp) != 0 )
		$sql .=  "`Date_Exp`='$Date_Exp',";
	$sql .=  " `Taxe`='$Taxe', `AvecNoSerie`='$AvecNoSerie',";
	if( $Stk != 0 )
		$sql .=  "`Stk`='$Stk',";
	if( $Comm != 0 )
		$sql .=  "`Comm`='$Comm',";
	if( $BO != 0 )
		$sql .=  "`BO`='$BO',";
	if( $Ven != 0 )
		$sql .=  "`Ven`='$Ven',";
	if( $Demo != 0 )
		$sql .=  "`Demo`='$Demo',";
	$sql .=  " `Min`='$Min', `Max`='$Max', `Promo`='$Promo',";
	$sql .=  " `CodBar`='$CodBar', `Prix_Actif`='$Prix_Actif', `Package`='$Package', `Rep`='$Rep', `CalcAuto`='$CalcAuto',";
	if( strlen($Date_Creation) != 0 )
		$sql .=  "`Date_Creation`='$Date_Creation',";
	$sql .=  " `Edition`='$Edition', `Auteur`='$Auteur', `Unit_Achat`='$Unit_Achat', `Unit_Vente`='$Unit_Vente',";
	$sql .=  " `online`='$online',"; 
	$sql .=  " `length`='$length', `width`='$width', `height`='$height', `weight`='$weight',"; 
	$sql .=  " `titre_fr`='$titre_fr', titre_en='$titre_en',"; 
	$sql .=  " `description_fr`='$description_fr', description_en='$description_en',"; 
	$sql .=  " `description_supplementaire_fr`='$description_supplementaire_fr',";   
	$sql .=  " `description_supplementaire_en`='$description_supplementaire_en',";  
	$sql .=  " `small`='$small', `medium`='$medium', `big`='$big', `DateAjout`='$Now', `DateMAJ`='$Now',"; 
	$sql .=  " `Unite`='Unité', `Markup`='$Markup', `TPS`='$TPS', `TVP`='$TVP'";
//	echo $sql."<br>";
//	$mabd->query($sql)
//		or die( $mabd->errno.' ERREUR Client : '.$mabd->error );

	if( !$mabd->query($sql) )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR insert_mcstk_item Stock : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
		return( 0 );
	}

//	mysql_insert_id( $mabd );

		// **** ON LAISSE UNE TRACE DE L'OPÉRATION

	$Mess = "Insert Inventaire $NumInv";
	Suivi_log($Mess, $NumInv);
	
	return 1;


} // insert_mcstk_item

function update_mcstk_item( $TabInfo )
//  FUNCTION : update_mcstk_item
//  version : 1.0
//  date : 2016-09-07
//  derniere modif : Denis Léveillé
//  info : Maj du paiement de la vente
{
global $mabd, $database, $Now;
	
	// Si POST est vide
	$_SESSION['MCSTK_ERREUR'] = 0;
	if( empty( $TabInfo ) ) {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "Impossible update_mcstk_item modification TabInfo VIDE.<br>";
		return( 0 );
	}
	extract( $TabInfo, EXTR_OVERWRITE );
	
	$description_fr = stripslashes($description_fr ); 
	$description_en = stripslashes($description_en );
	$description_supplementaire_fr = stripslashes($description_supplementaire_fr ); 
	$description_supplementaire_en = stripslashes($description_supplementaire_en );
	
	$Description = myAddSlashes($Description);
	$Manufacturier = myAddSlashes($Manufacturier);
	$titre_fr = myAddSlashes($titre_fr );
	$titre_en = myAddSlashes($titre_en );
	$description_fr = myAddSlashes($description_fr ); 
	$description_en = myAddSlashes($description_en );
	$description_supplementaire_fr = myAddSlashes($description_supplementaire_fr ); 
	$description_supplementaire_en = myAddSlashes($description_supplementaire_en );
	$Auteur = myAddSlashes($Auteur);

	//$date	= $Now; // mktime();
	$sql =  "UPDATE IGNORE $database.mcistock SET";
	$sql .=  " `NumInv`='$NumInv',";
	$sql .=  " `Description`='$Description', `Manufacturier`='$Manufacturier', `CodProd`='$CodProd',";
//	$sql .=  "'".myAddSlashes($Description)."', '".myAddSlashes($Manufacturier)."', '$CodProd', "; lus haut
	if( $DernierPaye != 0 )
		$sql .=  "`DernierPaye`='$DernierPaye',";
	if( $Cout_Moyen != 0 )
		$sql .=  "`Cout_Moyen`='$Cout_Moyen',";
	if( $Vente1 != 0 )
		$sql .=  "`Vente1`='$Vente1',";
	if( $Vente2 != 0 )
		$sql .=  "`Vente2`='$Vente2',";
	if( $Vente3 != 0 )
		$sql .=  "`Vente3`='$Vente3',";
	if( $Detail_Suggere != 0 )
		$sql .=  "`Detail_Suggere`='$Detail_Suggere',";
	if( strlen($Date_Exp) != 0 )
		$sql .=  "`Date_Exp`='$Date_Exp',";
	$sql .=  " `Taxe`='$Taxe', `AvecNoSerie`='$AvecNoSerie',";
	if( $Stk != 0 )
		$sql .=  "`Stk`='$Stk',";
	if( $Comm != 0 )
		$sql .=  "`Comm`='$Comm',";
	if( $BO != 0 )
		$sql .=  "`BO`='$BO',";
	if( $Ven != 0 )
		$sql .=  "`Ven`='$Ven',";
	if( $Demo != 0 )
		$sql .=  "`Demo`='$Demo',";
	$sql .=  " `Min`='$Min', `Max`='$Max', `Promo`='$Promo',";
	$sql .=  " `CodBar`='$CodBar', `Prix_Actif`='$Prix_Actif', `Package`='$Package', `Rep`='$Rep', `CalcAuto`='$CalcAuto',";
	//if( strlen($Date_Creation) != 0 )
		$sql .=  "`Date_Creation`='$Date_Creation',";
	$sql .=  " `Edition`='$Edition', `Auteur`='$Auteur', `Unit_Achat`='$Unit_Achat', `Unit_Vente`='$Unit_Vente',";
	$sql .=  " `online`='$online', `Markup`='$Markup',"; 
	$sql .=  " `length`='$length', `width`='$width', `height`='$height', `weight`='$weight',"; 
	$sql .=  " `titre_fr`='$titre_fr', titre_en='$titre_en',"; 
	$sql .=  " `description_fr`='$description_fr', description_en='$description_en',"; 
	$sql .=  " `description_supplementaire_fr`='$description_supplementaire_fr',";   
	$sql .=  " `description_supplementaire_en`='$description_supplementaire_en',";  
	$sql .=  " `small`='$small', `medium`='$medium', `big`='$big', `DateMAJ`='$Now',"; 
	$sql .=  " `Unite`='Unité', `Markup`='$Markup', `TPS`='$TPS', `TVP`='$TVP'";

	
	//echo $sql;
	if( !$mabd->query($sql) )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR update_mcstk_item Stock : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
		return( 0 );
	}
	
	$Mess = "MAJ Inventaire $NumInv";
	Suivi_log($Mess, $NumInv);

} // update_mcstk_item

function mcstk_item_get_lst(  )
//  FUNCTION : mcstk_item_get_lst
//  version : 1.0
//  date : 2018-03-21
//  derniere modif : Denis Léveillé
//  info : avoir une liste des descriptions indexé par le no d'inventaire
{
global $mabd, $database, $Now;

	$_SESSION['MCSTK_ERREUR'] = 0;
	$LstStock =  array();
	$sql = "SELECT NumInv, titre_".$_SESSION['langue']." FROM $database.mcistock WHERE ( `NumInv` LIKE 'SER%' );";
	if( !($result = $mabd->query($sql)) )  {
		$_SESSION['MCSTK_ERREUR'] = 1;
		$_SESSION['MCSTK_MESSAGE'] = "ERREUR info_MCStk Inventaire : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
		return( $LstStock );
	}
	elseif (  $result->num_rows != 0 ) {
		while( $row = $result->fetch_row() ) 
			$LstStock[$row[0]] = $row[1];
		
	}
	return ($LstStock);

} // mcstk_item_get_lst


?>