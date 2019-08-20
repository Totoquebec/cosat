<?php
//* Auteur : Denis Léveillé 	 		  Date : 2004-01-01
//* MAJ : Denis Léveillé 	 			  Date : 2007-12-21

// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________

function get_compteur( $url_rech=0 )
function InfoBannie( $ip )
function InfoAcces( $ip )
// ***** DETECTION DES ROBOTS
function EsUnRobot( $ip )
function CheckRobot() {
function isMoteur($ip)
function Message_Erreur( $Top, $Message, $Info )
function recherche($criteres, $categorie)
function selectionRecherche( $idsProduits )
function adjust_path($cat)
function list_cats_checkbox($upcat=0,$level=1)
function list_cats($id=0, $lvl=0, $check=-1,$sous)
function afficher_un_produit( $produit, $NoCat, $Retour, $Page ){
function afficher_categorie_list( $ressource, $NoCat ){
function afficher_categorie_rech( $produits ){
**********************************************************************************************/

$NomJourFR = array(
		"0"=>"Dimanche",
		"1"=>"Lundi",
		"2"=>"Mardi",
		"3"=>"Mercredi",
		"4"=>"Jeudi",
		"5"=>"Vendredi",
		"6"=>"Samedi"
		); 
 
$NomJourSP = array(
		"0"=>"Domingo",
		"1"=>"Lunes",
		"2"=>"Martes",
		"3"=>"Miércoles",
		"4"=>"Jueves",
		"5"=>"Viernes",
		"6"=>"Sábado"
		);
		
$NomMoisFR = array(		
		"1"=>"Janvier",
		"2"=>"Février",
		"3"=>"Mars",
		"4"=>"Avril",
		"5"=>"Mai",
		"6"=>"Juin",
		"7"=>"Juillet",
		"8"=>"Août",
		"9"=>"Septembre",
		"10"=>"Octobre",
		"11"=>"Novembre",
		"12"=>"Décembre"
);
$NomSaisonFR = array(
	"Janvier" =>"Hiver",
	"Février" =>"Hiver",
	"Mars"    =>"Hiver",
	"Avril"   =>"Printemps",
	"Mai"     =>"Printemps",
	"Juin"    =>"Printemps",
	"Juillet" =>"Été",
	"Août"    =>"Été",
	"Septembre"=>"Été",
	"Octobre" =>"Automne",
	"Novembre"=>"Automne",
	"Décembre"=>"Automne"
); 

$NomSaisonNoFR = array(
	"01"=>"Hiver",
	"02"=>"Hiver",
	"03"=>"Hiver",
	"04"=>"Printemps",
	"05"=>"Printemps",
	"06"=>"Printemps",
	"07"=>"Été",
	"08"=>"Été",
	"09"=>"Été",
	"10"=>"Automne",
	"11"=>"Automne",
	"12"=>"Automne"
); 


$NomMoisFR_2 = array(
	"01"=>"Janvier",
	"02"=>"Février",
	"03"=>"Mars",
	"04"=>"Avril",
	"05"=>"Mai",
	"06"=>"Juin",
	"07"=>"Juillet",
	"08"=>"Août",
	"09"=>"Septembre",
	"10"=>"Octobre",
	"11"=>"Novembre",
	"12"=>"Décembre",
); 

function setContentType($type, $charset = NULL)
{
        if (PHP_VERSION_ID >= 50600 && $charset === NULL && func_num_args() >= 2) {
            $defaultCharset = ini_get('default_charset');
            ini_set('default_charset', NULL);
        }

        $this->setHeader('Content-Type', $type . ($charset ? '; charset=' . $charset : ''));

        if (isset($defaultCharset)) {
            ini_set('default_charset', $defaultCharset);
        }

        return $this;
} //  setContentType

function my_gethostbyaddr($ip) {
	if( isset( $_SESSION['LeHost'] ) && strlen($_SESSION['LeHost']) )
		return $_SESSION['LeHost'];
	else
		$_SESSION['LeHost'] = @gethostbyaddr($ip) or ($_SESSION['LeHost']= 'host inconnu');
	
	return $_SESSION['LeHost'];
} 



function get_compteur( $url_rech=0 )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database;

	if( strlen($url_rech) < 5 ) 
		$url_rech = $_SERVER['HTTP_HOST'];

	$sql = "SELECT id,date_debut, compteur FROM $database.parametre WHERE url LIKE '%$url_rech%' LIMIT 1;";
	$reponse = array();
	$result = mysql_query( $sql, $handle );
	if( !$result )
		Message_Erreur( "ERROR", "Erreur accès get_compteur", mysql_errno()." : ".mysql_error()."<br>".$sql  );			

	if( mysql_num_rows($result) ) {
		$reponse = mysql_fetch_assoc($result);
		if( !(int)substr($reponse['date_debut'], 0, 4) ) $reponse['date_debut'] = date('Y-m-d');
		$reponse['compteur']++;
		$sql = "UPDATE $database.parametre SET date_debut = '".$reponse['date_debut']."', compteur = '".$reponse['compteur']."' WHERE id='".$reponse['id']."';";
		if( !mysql_query( $sql, $handle ) )
		      	Message_Erreur( "ERROR", "Erreur update get_compteur", mysql_errno()." : ".mysql_error()."<br>".$sql  );	
	}
	return( $reponse );

} // Iget_compteur

function InfoBannie( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
// Les badbot peuvent utilisé un USER_AGENT tout à fait légitime
 //		  		!strlen( $HTTP_USER_AGENT ) ||
//		  		!strcmp( $row[3], $HTTP_USER_AGENT ) ){
{
global $handle, $database, $Now; //, $HTTP_USER_AGENT;
		//echo "IP ; $ip<br>";
	$badboy = false;
	unset($_SESSION['Jlaivu']);
		//	if( !strlen($ip) ) return( false );
    	// Recherche des sous categorie
	$sql = "SELECT * FROM $database.badbot WHERE IP='$ip'";
	$result = mysql_query($sql, $handle );
	if( $result && mysql_num_rows( $result ) ) 
		$badboy = true;
	else {
		$domaine = my_gethostbyaddr($ip);
		$sql = "SELECT * FROM $database.badbot WHERE Hote='$domaine'";
		$result = mysql_query($sql, $handle );
		if( $result && mysql_num_rows( $result ) ) 
			$badboy = true;
	}
	if( $badboy ) {
		$row = mysql_fetch_row($result);
		$row[7]++;
		if( !strncmp( $row[9], $Now, 16 ) )
			$_SESSION['Jlaivu'] = 'OUI';
		$_SESSION['tst'] = "Row : ".$row[9]." Now : ".$Now;
		$sql =  "UPDATE $database.badbot SET Access = '".$row[7]."', DatDernAcces='$Now' WHERE Id='".$row[0]."';";
		// DatDernAcces
		$result = mysql_query( $sql, $handle );
		$_SESSION['isRobot'] = true;
		$_SESSION['isAspi'] = 3;
		return( true );
	} // Si un resultat
	return( false );

} // InfoBannie

function InfoAcces( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database, $Now, $Moteur;
    	// Recherche des robots
	if( EsUnRobot($ip) )  {
		$_SESSION['MLeRobot'] = true;
		$domaine = @my_gethostbyaddr($ip);
		$sql =  "INSERT INTO $database.access SET Date = '$Now', Moteur='$Moteur', IP='$ip', Agent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine';";
		$result = mysql_query( $sql, $handle );
	} // Si un robot

} // InfoAcces

function EsUnRobot( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Valide si une adresse IP est reconnu comme un moteur de recherche
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database, $Now, $Moteur;
    	// Recherche des robots
 	$result = mysql_query("SELECT * FROM $database.robot", $handle );
	if( $result && ( mysql_num_rows( $result ) > 0) ) {
		$domaine = @my_gethostbyaddr($ip);
	     for( $i=0; $i < mysql_num_rows($result); $i++ ) {
			$row = mysql_fetch_row($result);
			if( 	strstr( $domaine, $row[4] ) ||
		    	strstr( $ip, $row[5] ) ||
				!strcmp($row[3], $_SERVER["HTTP_USER_AGENT"]) ){
				$Moteur = $row[1];
				return( true );
			} // Si trouver
	     } // for $i;
	} // Si un resultat
	return( false );

} // EsUnRobot

function SauveIP( $ip )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Ajoute l'adresse IP dans une table et compte le nombre d'occurence
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2015-04-03
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database, $Now, $Moteur;

	$nbr = 1;
	// Le cleanup des vieiles affaires
	$JourAvant = time() - (24 * 60 * 60);
	
	$sql = "DELETE FROM $database.tableip WHERE DatDernAcces < '$JourAvant'"; 
	$result = mysql_query( $sql, $handle );
	
	$MAJ = time();
	// On le connais-tu lui lala
 	$sql = "SELECT * FROM $database.tableip WHERE IP='$ip';";
	$result = mysql_query( $sql, $handle );
	   // echo "Dans sauve ip ".$sql."<br>";
	if( $result && ( mysql_num_rows( $result ) > 0) ) {
		// Ho yes on compte le nombre d'appel qu'on a recu
		$row = mysql_fetch_row($result);
		$nbr += $row[4];
		$sql =  "UPDATE $database.tableip SET Nbr = '$nbr', DatDernAcces='$MAJ' WHERE IP='$ip';";
				// DatDernAcces
	    //	echo "Existe sauve ip ".$sql."<br>";
		$result = mysql_query( $sql, $handle );
		return( $nbr );
	} // Si un resultat
	else {
		// Pas sur on l'inscrit sur la liste
		$domaine = @my_gethostbyaddr($ip);
		$sql =  "INSERT INTO $database.tableip SET IP='$ip', DatDernAcces = '$MAJ', Agent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine', Nbr=1 ;";
	  //  	echo "Pas existe sauve ip ".$sql."<br>";
		$result = mysql_query( $sql, $handle );
	}
	return( $nbr );

} // SauveIP

// **********************************************************************************************
// ***** DETECTION DES ROBOTS
function CheckRobot() 
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Si le client est un robot, envoi un message à l'écran : Hi ! Robot !!!!
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $ip,$handle, $database, $Now, $entr_url, $AdrWebmestre, $txt, $TabMessGen;

	if( isset($_SESSION['isRobot']) ) { 
		// on s'envoie un mail contenant l'adresse IP du visiteur (il s'agit peut être d'un vrai moteur de recherche) 
			
		$domaine = @my_gethostbyaddr($ip);
		$ip = get_ip(); 
		if (isset($_SESSION['isAspi'])) { 
			switch( $_SESSION['isAspi'] ) {
				case 1:		$txt2 = ' => par Suspect';
							break;
				case 2:		$txt2 = ' => par Trappe';
							break;
				case 3:		$txt2 = ' => par Table';
							break;
				case 4:		$txt2 = ' => par 404';
							break;
				default :	$txt2 = ' => par ????';
			} // switch isaspi
			$sujet = "Un Aspirateur sur le site $entr_url";
			$Type = 'Aspirateur';
			if( !InfoBannie( $ip ) ) {
				$sql =  "INSERT INTO $database.badbot SET IP='$ip', UserAgent='".$_SERVER["HTTP_USER_AGENT"]."', Hote='$domaine', Date = '$Now', Access = '1', Porte = '$txt2';";
				$result = mysql_query( $sql, $handle );
				$Type .= " (Ajouté $result)";
			}
		} // Si un aspirateur   
		else {
			$sujet = "Un Robot sur le site $entr_url";
			$Type = 'Robot';
			$txt2 = ' => par Suspect';
		} // Sinon un simple robot
			// 			Son IP : <b>$ip</b><br/>".$_SESSION['tst']."<br><br/>
		$info = "<font size='3'><b>Un $Type a été choppé sur<br>$entr_url</b><br/>
				$txt2<br/>
				Son IP : <b><a href='http://whois.domaintools.com/".$_SERVER["REMOTE_ADDR"]."'>".$_SERVER["REMOTE_ADDR"]."</a></b><br><br/>
				User Agent : <b>".$_SERVER["HTTP_USER_AGENT"]."</b><br>
				Domaine : <b>$domaine</b></font>"; 
		if( !isset($_SESSION['Jlaivu']) )
			AlloWebmaster( $sujet, $info );
		else
			unset($_SESSION['Jlaivu']);
		// on bloque l'affichage 
		if (isset($_SESSION['isAspi'])) { 
			echo "
			<html>
				<head>
				<title>Hi ! ROBOT !!!!!!</title>
				</head>
				<body>
					<p align='center'>
						<marquee bgcolor='#FFFF00' height='60'>
							<font color='#000000' size='6' face='verdana'>".$TabMessGen[2000]." ".hexentities($AdrWebmestre)." !!!</font>
						</marquee>
					</p>		
				</body>
			</html>"; 
			exit();
		}
	
	}  // Si Un Robot actif
} // CheckRobot


function Message_Erreur( $Top, $Message, $Info )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $txt,$param, $entr_url,$Now, $Large, $Enligne;

echo
"<html>
	<head>
		<title>ERREUR $entr_url</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='robots' content='noindex, follow'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
	</head>
<body topmargin='16px' >
	<table bgcolor='#EFEFEF' width='760px' cellpadding='4' cellspacing='0' align='left' border='1' >		
		<tr>
			<td>
				<p align='center'><font size='5'><b><em>$Top</em></b></font></p>";
echo 			"<p align='center'><font size='3' color='#FF0000'>$Message</strong></font><br>
				<font color='#FF0000'></font> <u><font color='#0000FF'><a href='".$entr_url."' target='_self'>$entr_url</a></font></u></p>";
echo 			"<p align='center'><strong><font size='2'>$Info</font></strong></p>
				<p align='center'><strong><a href='javascript:history.back()'>";
				// **** Choix de la langue de travail ****
				switch( @$_SESSION['langue'] ) {
					case "en" : 	echo "To return to the previous page, Click Here";
							break;
					case "sp" : 	echo "Para volver a la página anterior, haga clic aquí";
							break;
					default : 	echo "Pour revenir à la page précédente, cliquez ici";		
				
				} // switch SLangue
echo			"</a></strong></p><br>
			</td>
	  	</tr>
		<tr>
			<td>
				Date : $Now
			</td>
	  	</tr>
	</table>
</body>
</html>";
exit();
} // function Message_Erreur

function recherche($criteres, $categorie)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : Recherche
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $handle, $database;

	if( !is_array( $criteres ) )
		return false;
	
	// array de retour contient 
	//  les IDdes produits trouvés selon les critères
	$ids = array();
	// La liste des catégorie de recherche
	$allCats = '';
	
	// Es-ce une catégorie principal
	$query = "SELECT parent FROM $database.catalogue WHERE id = $categorie";
	$query = mysql_query($query, $handle ) ;
	if( $query && mysql_num_rows( $query ) ) {
//	if( !in_array( $categorie, array(0,256) ) ){
		$parent = mysql_fetch_array($query);
//		echo "Parent = ".$parent[0]."<br>";
		// es-ce une catégorie parent
		if( $parent[0] == 0 ) {
//			echo "Ok Parent = 0<br>";
			// recherche de la categorie principal
			$cats = array();
			$cats[] = 'id_catalogue = '.$categorie;
			// Recherche des sous categorie
			$query = "SELECT id FROM $database.catalogue WHERE parent = $categorie";
			$query = mysql_query($query, $handle ) 
				or die('Erreur à la sélection des sousCats :: '.mysql_error());
			while($cat = mysql_fetch_assoc($query))
				$cats[] = 'id_catalogue = '.$cat['id'];
			
			$allCats = implode(' OR ', $cats);
//			echo "AllCat = ".$allCats."<br>";
		} // Si parent  est a zero
	} // Si une categorie
		
	/*** on bâti la requête ***/
	$toAdd = array();
	
	$query = "SELECT * FROM $database.stock ";
	// selon les critères
	foreach($criteres as $index => $critere){
		if( strlen($critere) ) {
			$toAdd[] = 'titre_fr LIKE "%'.$critere.'%"';
			$toAdd[] = 'titre_en LIKE "%'.$critere.'%"';
			$toAdd[] = 'titre_sp LIKE "%'.$critere.'%"';
			$toAdd[] = 'description_fr LIKE "%'.$critere.'%"';
			$toAdd[] = 'description_en LIKE "%'.$critere.'%"';
			$toAdd[] = 'description_sp LIKE "%'.$critere.'%"';
		}
	}
	if( count($toAdd) > 0 )
		$query .= " WHERE (".implode(' OR ', $toAdd);
		
	$query .= ") AND online = '1';";
		
//	echo "Sql = ".$query."<br>";
	$query = mysql_query($query, $handle ) 
		or die("Sélection selon critères : ".mysql_error()."<br>".$query);
		
		// Ici on a tous les ID selon les critères, mais TOUTES les catégories
		
//	if( !in_array( $categorie, array(0,256) ) ){
	if( strlen($allCats) ){
		$query2 = "SELECT id_produit FROM $database.catalogue_produits WHERE $allCats";
//		echo "AllCats = ".$query2."<br>";
		$query2 = mysql_query($query2, $handle ) 
			or die('sous-sélection :: '.mysql_error());
		$prod_filter = array();
		while( $prod = mysql_fetch_array($query2) )
			$prod_filter[] = $prod[0];
		
		while($r = mysql_fetch_assoc($query))
			if( in_array($r['id'],$prod_filter) )
				$ids[] = $r['id'];
	} // Si pas de catégorie
	else{
		while( $r = mysql_fetch_assoc($query) )
			$ids[] = $r['id'];
		
	} // Sinon si pas de categorie = avec categorie
	
	return $ids;
} // fin de la fonction : recherche 

function selectionRecherche( $idsProduits )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : selectionRecherche
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : selectionne les produits selon un tableau de ID passe en param.
{
global $handle, $database;

    if( !is_array($idsProduits) )
        return false;

    $recherche = array();
		$i = 0;
    foreach( $idsProduits as $index => $prodId ){
        if( $prodId != NULL ){
        		$sql = 'SELECT *, titre_'.$_SESSION['langue'].' AS nom, description_'.$_SESSION['langue'].' AS description';
            $sql .= " FROM $database.stock WHERE id ='$prodId' LIMIT 1;";
            $result = mysql_query($sql, $handle )  
					or die("selectionRecherche :: Infos de produits :: ".mysql_error());
//				$recherche[$i++] = $result;
            $query = mysql_fetch_assoc($result);

            foreach( $query as $colonne => $value )
                $recherche[$prodId][$colonne] = $value;
            
        }
    }

    return $recherche;
} // fin de la fonction : selectionRecherche 


function adjust_path($cat)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : adjust_path
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : ajuste le path de catÈgorie pour le menu
{
    $path = get_cat_path($cat);
    $path = array_reverse($path);
    $path[] = 0;
    $path = array_reverse($path);
    $path[] = $cat;

    return $path;
} // fin de la fonction : adjust_path 

function list_cats_checkbox($upcat=0,$level=1)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : list_cats_checkbox
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : Listing des catÈgories avec checkbox aux catÈgories n'ayant pas d'enfants
{

	$sousCats = get_subcats($upcat);
	foreach($sousCats as $id => $nom){
		for($i=0; $i<$level; $i++)
			echo '&nbsp;&nbsp;&nbsp;&nbsp;';
	
		if(count(get_subcats($id)) == 0)
			echo '<input type="checkbox" name="chkCat[]" value="'.$id.'"/>';
			
		echo $nom,'<br>';
		list_cats_checkbox($id,($level+1));
	}
	
} // fin de la fonction : list_cats_checkbox ------------------------------------------------------


function list_cats($id=0, $lvl=0, $check=-1,$sous)
//-------------------------------------------------------------------------------------------------
//  FUNCTION : list_cats
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : retourne le menu entier par rapport ý une sous-catÈgorie donnÈe
{
    $sousCats = get_subcats($id);
    /*
    echo '<br><br>';
    var_dump($sousCats);
    echo '<br><br>';
    */
    echo '<br>\n';
    if(is_array($sousCats))
    {
        foreach($sousCats as $categorie => $nom)
        {
             echo '<option value="',$categorie,'"';
             if($check != -1 && $check == $categorie)
                 echo " selected>";
             else
                 echo '>';
             for($i=0;$i<$lvl;$i++)
               if($sous=='4')
               { 
               echo "&nbsp;&nbsp;&nbsp;";
               }
             echo '- ',$nom,'</option>';
             list_cats($categorie, ($lvl+1), $check,4);
        }
      
    }
} // list_cats

function afficher_un_produit( $produit, $NoCat, $Retour, $Page )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
global $param, $handle, $txt, $TabMessGen, $database, $TxCUC_USD,$TXUSD_CAD,$TXUSD_EUR,$SymbCUC,$SymbUSD,$SymbCAD,$SymbEUR;

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
							$sql = " SELECT Largeur, Hauteur FROM $database.photo WHERE NoInvent='$id' AND NoPhoto='$small';";
							$result = mysql_query( $sql, $handle );
							if( $result &&  mysql_num_rows($result) ) {
								$L = @mysql_result($result, 0, "Largeur");
								$H = @mysql_result($result, 0, "Hauteur");
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

} // afficher_categorie_list

function afficher_categorie_list( $ressource, $NoCat )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{
	while( $produit = mysql_fetch_assoc( $ressource ))
		afficher_un_produit( $produit, $NoCat, 3, 'ACCUEIL' );	
} // afficher_categorie_list

function afficher_categorie_rech( $produits )
//-------------------------------------------------------------------------------------------------
//  FUNCTION : 
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2009-10-31
//  derniere modif : Denis Léveillé
//  info : 
{


   foreach($produits as $produit)
		afficher_un_produit( $produit, 0, 5, 'MAIN' );	
   
} // afficher_categorie_rech

?>