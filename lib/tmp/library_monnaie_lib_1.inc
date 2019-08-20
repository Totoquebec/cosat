<?php


   $urldesj='http://www.desjardins.com/fr/taux/change/tableau_cheques.jsp'; 
	$desjcache=$acces_hermes.'/cache/desjcache.txt';
   $urlcuba='http://www.banco-metropolitano.com/tasasn.htm'; 
	$cubacache=$acces_hermes.'/cache/cubacache.txt';
	$eurocache= $acces_hermes.'/cache/mcache.txt'; //<- cache file (chmod folder to 755) 


/** http://www.x-rates.com/cgi-bin/xexcel/USD_rates.xls ***/
class ConvertDevise { 
  
	/** CONFIG >> **/ 
	var $precision = 4; //<- decimal numbers after dot 
	var $ModeCourant=3; //<- 1:'GBP' / 2:'British Pound' / 2:'British Pound (GBP)' 
	var $update= 2; //<- cache updating interval (in hours) 
	var $cache=true; //<- allow file caching for FASTER loading
	var $FrTauxChg = 1.0175; 
	var $euro_cache = '';
//	var $euro_cache= $acces_hermes.'/cache/mcache.txt'; //<- cache file (chmod folder to 755) 
	/** << CONFIG **/ 
	var $xml_obj; 
	var $xml_data; 
	var $map_array = array("Cube"=>true); 
	var $updated; 
	var $LstDevise; 
	var $xml=1;
	
	function ConvertDevise(){ 
	  global $eurocache;
	  
	  $this->euro_cache = $eurocache;
	  $this->xml_obj = xml_parser_create();  
	  xml_set_object($this->xml_obj,$this); 
	  xml_set_element_handler($this->xml_obj, "PremierElem", "DernierElem");  
	  xml_set_character_data_handler($this->xml_obj, "characterData");  
	  xml_parser_set_option($this->xml_obj, XML_OPTION_CASE_FOLDING, 0); 
	  $this->ChargeTaux ();
	  if( $this->xml  == 0 ) return;
	 
	  ksort($this->xml_data); 
	  $this->LstDevise = array('AUD'=>'Australian dollar','BGN'=>'Bulgarian lev','CAD'=>'Canadian dollar','CHF'=>'Swiss franc', 
	  				   'CNY'=>'Chinese yuan', 'CYP'=>'Cypriot Pound', 'CZK'=>'Czech koruna', 'DKK'=>'Danish krone', 'EEK'=>'Estonian kroon',  
	  				  'EUR'=>'Euro', 'GBP'=>'British pound', 'HKD'=>'Hong Kong dollar', 'HRK'=>'Croatian kuna', 'HUF'=>'Hungarian forint',  
					  'IDR'=>'Indonesian rupiah', 'ISK'=>'Icelandic Krona', 'JPY'=>'Japanese yen', 'KRW'=>'South Korean won', 
					  'LTL'=>'Lithuanian litas', 'LVL'=>'Latvian lats', 'MTL'=>'Maltese lira', 'MYR'=>'Malaysian ringgit', 
					  'NOK'=>'Norwegian krone', 'NZD'=>'New Zealand dollar', 'PHP'=>'Philippine Peso', 'PLN'=>'Polish zloty', 
					  'RON'=>'Romanian lei', 'RUB'=>'Russian ruble', 'SEK'=>'Swedish krona', 'SGD'=>'Singapore dollar', 
					  'SIT'=>'Slovenian tolar', 'SKK'=>'Slovak koruna', 'THB'=>'Thai baht', 'TRY'=>'Turkish lira', 'USD'=>'US Dollar', 
					  'ZAR'=>'South African rand'); 
	  $_sc='MC';
	//  define('DIR',''); 
	  
	} 
	
	function PremierElem($parser, $name, $attrs) { 
	   if (isset($this->map_array[$name]))   
	    if (@$attrs['time']) { 
		   $this->xml_data['EUR']=1;
		   $this->updated=$attrs['time']; 
		} 
	    elseif ( @$attrs['currency']) 
		  $this->xml_data[$attrs['currency']]=$attrs['rate'];  
	     
	} // PremierElem
	
	function DernierElem($parser, $name) {} 
	function characterData($parser, $data) {} 
	
	function ChargeTaux(){ 
		$url='http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml'; 
		$update = 60 * 60; 
		$buffer = "";
		
		
		if(	$this->cache && 
				file_exists($this->euro_cache) && 
				( filesize($this->euro_cache) > 1 ) && 
				( filemtime($this->euro_cache) > (time() - $update) ) ) { 
	    //from cache 
					error_reporting(1); 
	    		$handle = fopen($this->euro_cache, "r");   
	      	if ($handle) { 
	       		while (!feof($handle))  $buffer .= fgets($handle, 4096); 
	       		//echo "\n<!-- Cached @".date('H:i', filemtime($this->euro_cache))."-->\n"; 
	       		fclose($handle); 
	      	} 
		 			error_reporting(0);  
	  } // Si données déja caché et valide 
	  else { 
			$handle = fopen($url, "r");
			if ($handle) { 
	    		while (!feof($handle))  $buffer .= fgets($handle, 4096); 
	       	fclose($handle); 
	  	} // Si site exchange accessible
			elseif( $this->cache && 
	  	  file_exists($this->euro_cache) && 
		  	filesize($this->euro_cache)>1 ) {
	         //from cache  
	    	$handle = fopen($this->euro_cache, "r");   
	      if ($handle) { 
	       	 	while (!feof($handle))  $buffer .= fgets($handle, 4096); 
	       		//echo "\n<!-- Cached @".date('H:i', filemtime($this->euro_cache))."-->\n"; 
	       		fclose($handle); 
	      }   
		} // Si un fichier dans la cache
		  
	    if( $this->cache && strlen($buffer) ) { // save cache 
	      $handle = fopen($this->euro_cache, "w");    
	      if ($handle) { 
	       fwrite($handle, $buffer); 
	       fclose($handle); 
	      } // Si fichier cache ouvre  
	    } // Si données cacher     
	  }   
	  if( strlen( $buffer ) )
	   $xml = xml_parse($this->xml_obj,$buffer);
	  else 
	   $xml = 0;
	//   echo "XML = ".$xml."<br> \n";
	} // ChargeTaux   
	  
	function cutstr ($var){ 
	 $var=trim($var); 
	 return round($var,$this->precision); 
	} 
	  
	function Devise($c,$mode=''){ 
	 if( $this->xml == 0 ) return "";
	 if($mode=='') 
	   $m=$this->ModeCourant; 
	 else 
	   $m=$mode;  
	 if($m==2)   
	   return $this->LstDevise[$c]; 
	 elseif($m==3)   
	   return '('.$c.') '.$this->LstDevise[$c]; 
	 else 
	   return $c; 
	} // Devise
	  
	function valide (){
	 foreach($this->xml_data as $k=>$v) { 
	  $this->xml_data[$k]=$v; 
	 } 
	} // Valide 
	  
	function Conversion($amount,$from,$to) {
	  if( $this->xml  == 0 ) return; 
	  $this->valide(); 
	  if(!$this->xml_data[$from] || !$this->xml_data[$to]) 
	     $r= 'Devise invalide'; 
	   elseif($from=='EUR') 
	     $r= $this->cutstr($amount*$this->xml_data[$to]); 
	   else 
	     $r= $this->cutstr($amount/$this->xml_data[$from]*$this->xml_data[$to]);
	  return $r; 
	} // Conversion
	 
	function getMiseAjourTime() { 
	  if( $this->xml  == 0 ) return; 
	 $this->valide(); 
	  return $this->updated; 
	} 
	
	function TrouveListDevise ($mode=1){
	 if( $this->xml  == 0 ) return ""; 
	 $this->valide(); 
	  foreach ($this->xml_data as $k=>$v) 
	    $out[]=$this->Devise($k,$mode); 
	  return $out; 
	} // TrouveListDevise
	 
	function TrouveListConversion($base='EUR') 
	{ 
	 if( $this->xml  == 0 ) return "";
	 if($base=='EUR')    
	   $mul=1;  
	  else  
	   $mul=$this->xml_data[$base];   
	  
	  $this->valide(); 
	   
	  foreach ($this->xml_data as $k=>$v){ 
	    if( $k == $base ) 
		   	$out[$k]='1'; 
	    else 
		    $out[$k]=$this->cutstr ($v/$mul); 
	  } 
	   
	  return $out; 
	} // TrouveListConversion
	
	function DonneTaux( $Devise )
	{
	 	//return get_Taux($Devise);
	   if( $this->xml  == 0 ) return 0;
		if( $Devise != 'USD' )
			$mul = $this->xml_data['USD'];
		else
			$mul = 1; 
	    foreach( $this->xml_data as $k => $v ){ 
	    	if( $k==$Devise ) {
		    	$out = $this->cutstr( $v / $mul );
		    	$out = round($out,4);
		 	}  // Si la devise recherché
	    } // pour chaque devise
	 		return $out;
	} // Donne Taux
	 
	function TrouveGraphiqueDevise($c) { 
	   if( $this->xml  == 0 ) return;
	   if( $c=='EUR' || !$this->LstDevise[$c] ) return 'Devise non valide'; 
	   return "<img src=\"http://www.ecb.int/stats/exchange/eurofxref/shared/img/$c.png\" alt=\"$c chart\" />"; 
	} 
	  
  
} // Class

function get_Symbole($Dev)
/****************************************************************************
Fonction : GetSymbole
Sortie : Trouve l'etra pour une devise
Description : Cette fonction permet de récupérer les différentes Monnaies utilisées
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $user,$host,$password,$database;
	   
   $S = "";	   
	// **** CONNECTION AU SERVEUR
	$connection = mysql_connect( $host, $user, $password)
       or die( "Connection impossible au serveur");
	$db = mysql_select_db( $database, $connection )
       or die("La base de données ne peut être sélectionnée");

   $sql = " SELECT * FROM $database.monnaies WHERE Devise='".$Dev."'";
   $result = mysql_query( $sql, $connection );
   if( $result != 0 ) {
    if (  mysql_num_rows($result) != 0 ) {
		$row = mysql_fetch_row($result);
		$S = $row[5];
     } // Si services existent
   } // Si pas erreur
   mysql_free_result($result);
   return($S);
   
} // get_Symbole

function get_Xtra($Dev)
/****************************************************************************
Fonction : GetExtra
Sortie : Trouve l'etra pour une devise
Description : Cette fonction permet de récupérer les différentes Monnaies utilisées
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
	   
   $Xtra = "";	   
   $sql = " SELECT * FROM monnaies WHERE Devise='".$Dev."'";
   $result = mysql_query( $sql );
   if( $result == 0 ) {
     echo "Erreur get extra ".$sql." <br>\n";
   }
   elseif (  mysql_num_rows($result) != 0 ) {
		$row = mysql_fetch_row($result);
		$Xtra = $row[4];
   } // Si services existent
   mysql_free_result($result);

   return($Xtra);
} // get_xtra

function get_TXUS($Dev)
/****************************************************************************
Fonction : GetExtra
Sortie : 
Description : 
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
	   
   $TXUS = "";	   
   $sql = " SELECT * FROM monnaies WHERE Devise='".$Dev."'";
   $result = mysql_query( $sql );
   if( $result == 0 ) {
     echo "Erreur get Taux US ".$sql." <br>\n";
   }
   elseif (  mysql_num_rows($result) != 0 ) {
	   $row = mysql_fetch_row($result);
	   $TXUS = $row[4];
   } // Si services existent
   mysql_free_result($result);

   return($TXUS);
} // get_TXUS

function get_money($TypMon)
/****************************************************************************
Fonction : get_money
Sortie : tableau de chaîne contenant toutes monnaies repondant au critère
Description : Cette fonction permet de récupérer les différentes Monnaies utilisées
Auteur : Denis Léveillé 	 		  Date : 2007-01-23
*****************************************************************************/
{
global $user,$host,$password,$database;
	// **** CONNECTION AU SERVEUR
	$connection = mysql_connect( $host, $user, $password)
       or die( "Connection impossible au serveur");
	$db = mysql_select_db( $database, $connection )
       or die("La base de données ne peut être sélectionnée");
	   
   $Tab[0] = "";	   
   $sql = " SELECT * FROM $database.monnaies";
   switch( @$TypMon ) {
		case 'Paiement':	$sql .= " WHERE Paiement = 'OUI'";
			 			   	break;
		case 'Transfert': $sql .= " WHERE Transfert = 'OUI'";
			 			   	break;

		default : break;
   }
   $result = mysql_query( $sql, $connection );
   if( $result == 0 ) {
     echo "<h2>ERREUR - Problème table monnaie<h2><br>";
   }
   elseif (  mysql_num_rows($result) != 0 ) {
	   for( $i=0; $i < mysql_num_rows($result); $i++ ) {
	         $row = mysql_fetch_row($result);
	   		 $Tab[$i] = $row[0];
	   }
   	mysql_free_result($result);
   } // Si services existent
  return($Tab);
} // get_money

function ChargeDesjardinsVente()
/****************************************************************************
Fonction : ChargeDesjardinsVente()
Sortie : Taux de vente USD en CAD
Description : Récupère sur le site de Desjardins les taux de vente du USD .
Auteur : Denis Léveillé 	 		  Date : 2007-01-23
*****************************************************************************/
{
global $desjcache, $urldesj; 
	$buffer = "";
	$TxCANUSD = 0;
      
	if(	file_exists($desjcache) && 
			filesize($desjcache)>1 && 
			ValideUnixDate( filemtime($desjcache) ) ) { 
			// from cache 
			$handle = fopen($desjcache, "r");   
			if ($handle) { 
				while (!feof($handle))  
					$buffer .= fgets($handle, 4096); 
				fclose($handle); 
			}
			else
				echo "Handle Invalide ".$handle."<br>"; 
	} // Si données déja caché et valide 
	else { 
		$handle = fopen($urldesj, "r");
		if ($handle) { 
			while (!feof($handle))  
				$buffer .= fgets($handle, 4096); 
			fclose($handle); 
		} // Si site exchange accessible
	
		if( strlen($buffer) ) { // save cache 
//			echo "Dans Save<br>";
			$handle = fopen($desjcache, "w");    
			if ($handle) { 
//				echo "Dans écrit<br>";
				fwrite($handle, $buffer); 
				fclose($handle); 
			} // Si fichier cache ouvre 
/*			else {
				echo "Pas Dans écrit $desjcache<br>";
				// is it writable?        
				if (is_writable($desjcache)) {            
					echo 'File is writable <br />';        
				} 
				else
					echo 'File is NOT writable <br />';        
				// is it writable?        
				if (is_writable('/cache')) {            
					echo '2 File is writable <br />';        
				} 
				else
					echo '2 File is NOT writable <br />';        

			}*/
			
		} // Si données cacher     
	
	} // sinon pas cache
	
	if( strlen( $buffer ) ) {
		// Trouve la chaine USD = US Dollar
		$Ptr = strstr( $buffer, "USD" );
		// taux d'achat
		$Ptr = strstr( $Ptr, "div>" );
		$Ptr[0] = 0;
		// taux de vente
		$Ptr = strstr( $Ptr, "div>" );
		for( $i=0 ; $Ptr[$i] != ',' ; $i++ );
		$i--;
		$Ptr = substr($Ptr, $i, 6);     // bcdef
		//	echo "PTR achat 1 =>".$Ptr."<= <br>";
		//		$Ptr = strstr( $Ptr, "1," );
		//		echo "PTR vente ".$Ptr."<br>";
		// Si trouver
		if( $Ptr != FALSE ) {
		
			$TxCANUSD = $Ptr;
			$TxCANUSD[1] = '.';
			//			  $TxCANUSD = 1.0 / $TxCANUSD;
			$TxCANUSD = floatval($TxCANUSD);
			$TxCANUSD = round($TxCANUSD,4);
		} // Si un chaine
	} // Si buffer plein
	return($TxCANUSD);	
 //echo "Taux US Desjardins Vente ".$TxCANUSD."<br>\n";
} // ChargeDesjardinsVente   
  
function ChargeDesjardinsAchat()
/****************************************************************************
Fonction : ChargeDesjardinsAchat()
Sortie : Taux de Achat USD en CAD
Description : Récupère sur le site de Desjardins les taux d'achat du USD .
Auteur : Denis Léveillé 	 		  Date : 2007-01-23
*****************************************************************************/
{ 
global $desjcache, $urldesj; 
	$buffer = "";
	$TxUSDCAN = 0;
      
  if( file_exists($desjcache) && 
	  filesize($desjcache)>1 && 
	  ValideUnixDate( filemtime($desjcache) ) ) { 
    // from cache 
    $handle = fopen($desjcache, "r");   
      if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       fclose($handle); 
      }
	  else
	  	  echo "Handle Invalide ".$handle."<br>"; 
  } // Si données déja caché et valide 
  else { 
    $handle = fopen($urldesj, "r");
    if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       fclose($handle); 
    } // Si site exchange accessible
	if( strlen($buffer) ) { // save cache 
      $handle = fopen($desjcache, "w");    
      if ($handle) { 
       fwrite($handle, $buffer); 
       fclose($handle); 
      } // Si fichier cache ouvre  
    } // Si données cacher     

  } // sinon pas cache
  
  if( strlen( $buffer ) ) {
		// Trouve la chaine USD = US Dollar
		$Ptr = strstr( $buffer, "USD" );
		// taux d'achat
		$Ptr = strstr( $Ptr, "div>" );
	for( $i=0 ; $Ptr[$i] != ',' ; $i++ );
	$i--;
	$Ptr = substr($Ptr, $i, 6);     // bcdef
//	echo "PTR achat 1 =>".$Ptr."<= <br>";
		// taux d'achat
//		$Ptr = strstr( $Ptr, "1," );
//		echo "PTR achat ".$Ptr."<br>";
		// Si trouver
		if( $Ptr != FALSE ) {
		  
			  $TxUSDCAN = $Ptr;
			  $TxUSDCAN[1] = '.';
			  $TxUSDCAN = floatval($TxUSDCAN);
			  $TxUSDCAN = round($TxUSDCAN,4);
		} // Si un chaine
  } // Si buffer plein
  return($TxUSDCAN);	
 //echo "Taux US Desjardins Achat".$TxUSDCAN."<br>\n";
} // ChargeDesjardinsAchat   

function ChargeDesjardinsAchatEURO()
/****************************************************************************
Fonction : ChargeDesjardinsAchat()
Sortie : Taux d'achat EUR en CAD
Description : Récupère sur le site de Desjardins les taux d'achat du EUR .
Auteur : Denis Léveillé 	 		  Date : 2007-01-23
*****************************************************************************/
{ 
global $desjcache, $urldesj; 
	$buffer = "";
	$TxUSDEUR = 0;
      
  if( file_exists($desjcache) && 
	  filesize($desjcache)>1 && 
	  ValideUnixDate( filemtime($desjcache) ) ) { 
    //from cache 
    $handle = fopen($desjcache, "r");   
      if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       fclose($handle); 
      }
	  else
	  	  echo "Handle Invalide ".$handle."<br>"; 
  } // Si données déja caché et valide 
  else { 
    $handle = fopen($urldesj, "r");
    if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       fclose($handle); 
    } // Si site exchange accessible
	if( strlen($buffer) ) { // save cache 
      $handle = fopen($desjcache, "w");    
      if ($handle) { 
       fwrite($handle, $buffer); 
       fclose($handle); 
      } // Si fichier cache ouvre  
    } // Si données cacher     

  } // sinon pas cache
  
  if( strlen( $buffer ) ) {
		// Trouve la chaine USD = US Dollar
		$Ptr = strstr( $buffer, "USD" );
		// taux d'achat
		$Ptr = strstr( $Ptr, "</div>" );
		// On enleve les balise html
		$Ptr = strip_tags($Ptr);
		// On enleve les blancs de début de chaine.
		$Ptr = ltrim ($Ptr);
		// On prend les 10 caracteres seulement
		$Ptr = sprintf("%10.10s",$Ptr);
//	echo "PTR achat 1 =>".$Ptr."<= <br>";
		for( $i=0; $i <= 10; $i++ ) 
			if( $Ptr[$i] == ',' ) {
				$i--; 
				break;
			}
		// Si trouver
		if( $Ptr != FALSE ) {
			  $TxUS = $Ptr;
			  $TxUS[1] = '.';
			  $TxUS = floatval($TxUS);
			  $TxUS = round($TxUS,4);
		} // Si un chaine
		else
			$TxUS = 0;
//		echo "TxUS ".$TxUS."<br>";
			
		// Trouve la chaine USD = US Dollar
		$Ptr = strstr( $buffer, "EUR" );
		// taux d'achat
		$Ptr = strstr( $Ptr, "div>" );
		$Ptr[0] = 0;
		// taux de vente
		// On se positionne sur la colonne désiré
		$Ptr = strstr( $Ptr, "</div>" );
		// On enleve les balise html
		$Ptr = strip_tags($Ptr);
		// On enleve les blancs de début de chaine.
		$Ptr = ltrim ($Ptr);
		// On prend les 10 caracteres seulement
		$Ptr = sprintf("%10.10s",$Ptr);
//	echo "PTR achat 2 =>".$Ptr."<= <br>";
		for( $i=0; $i <= 10; $i++ ) 
			if( $Ptr[$i] == ',' ) {
				$i--; 
				break;
			}
		// Si trouver
		if( $i < 11 ) {
				$TxUSDEUR = $Ptr;
				$TxUSDEUR[1] = '.';
				$TxUSDEUR = floatval($TxUSDEUR);
				$TxUSDEUR = $TxUS / $TxUSDEUR;
				$TxUSDEUR = round($TxUSDEUR,4);
		} // Si un chaine
  } // Si buffer plein
// echo "<br>Taux EURO Desjardins Achat ".$TxUSDEUR."<br>\n";
  return($TxUSDEUR);	
} // ChargeDesjardinsAchatEURO   


function ChargeCuba( $Devise ){ 
/****************************************************************************
Fonction : ChargeDesjardinsAchat()
Sortie : Taux de Vente/Achat USD en CUC
Description : Récupère sur le site de la banque Cubaine les taux du USD .
Auteur : Denis Léveillé 	 		  Date : 2007-01-23
*****************************************************************************/
global $cubacache, $urlcuba; 
GLOBAL $Taux,$Facteur;

	$buffer = "";
	$Taux = $Facteur = 0;
      
  if( file_exists($cubacache) && 
	  filesize($cubacache)>1 && 
	  ValideUnixDate( filemtime($cubacache) ) ) { 
    //from cache 
	error_reporting(1); 
    $handle = fopen($cubacache, "r");   
      if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       fclose($handle); 
      }
	  else
	  	  echo "Handle Invalide ".$handle."<br>"; 
	 error_reporting(0); 
  } // Si données déja caché et valide 
  else { 
    $handle = @fopen($urlcuba, "r");
    if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       fclose($handle); 
    } // Si site exchange accessible
	if( strlen($buffer) ) { // save cache 
      $handle = fopen($cubacache, "w");    
      if ($handle) { 
       fwrite($handle, $buffer); 
       fclose($handle); 
      } // Si fichier cache ouvre  
    } // Si données cacher     
  } // Sinon charge URL
  
  if( strlen( $buffer ) ) {
		// Trouve la chaine CAD = Canadian Dollar
		$Ptr = strstr( $buffer, $Devise );
		$Ptr = strstr( $Ptr, "1," );
//		echo "PTR =>".$Ptr."<=<br>";
		// Si trouver
		if( $Ptr != FALSE ) {
		  
			  $Taux = $Ptr;
			  $Taux[1] = '.';
			  $Taux = floatval($Taux);
				$Taux = round($Taux,4);
		} // Si un chaine
  }
  
  if( $Taux ) {
	$Facteur = 1/$Taux;
	$Facteur /= 10;
	$Facteur = round($Facteur,4);
	$Facteur *= 10;
  }
//echo "Taux ".$Taux."<br>"; 
  return( $Taux ); 
//echo "Taux Cuba ".$Taux." Facteur ".$Facteur."<br>\n";
} // ChargeCuba  


function GetNewTaux( $Type, $Dev, $frais)
/****************************************************************************
Fonction : GetNewTaux
Sortie : Nouveau taux de change du jour
Description : Cette fonction permet de récupérer le taux de change de $Type ( ACHAT, VENTE )
					du jour pour une monnaie spécifier dans $Dev en ajoutant le frais $frais
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $database;
//echo "GETNEWTAUX<br>";
//exit();
		// On initialise a -1 pour indiquer une erreur
		// Car un taux de 0 peux être valide
		$TxVente = $TxAchat = $Taux = -1;
		$aujourdhui = date("Y-m-d");
//echo "A Type ".$Type." Vente ".$TxVente." Achat ".$TxAchat." Taux ".$Taux."<br>";
		
		if( $Dev == "CAD" ) {
			$TxVente = ChargeDesjardinsVente();
			$TxAchat = ChargeDesjardinsAchat();
			$TxVente += $frais;
			$TxAchat += $frais;
		} // $Dev == "CAD"
		
		if( $Dev == "CUC" ) {
			if( $Tx = ChargeCuba("USD") ) {
				$TxVente = $Tx;
				$TxAchat = 1 / $TxVente;
				$TxVente += $frais;
				$TxAchat += $frais;
			}
		} // $Dev == "CUC"
//echo "A Type ".$Type." Vente ".$TxVente." Achat ".$TxAchat." Taux ".$Taux."<br>";
		
		if( $Dev == "EUR" ) {
 			$money = new ConvertDevise(); 
			$TxAchat = $money->DonneTaux('USD');  
 			$TxVente  = 1 / $TxAchat;
			$TxVente += $frais;
			$TxAchat += $frais;
		} // $Dev == "EUR"
		
		if( $Type == "VENTE" )
			$Taux = $TxVente;
		else
			$Taux = $TxAchat;
			
		if( $Taux >= 0 ) {
			$sql =  "UPDATE $database.monnaies SET TxAchatUS='$TxAchat', TxVenteUS='$TxVente', DateMAJ='$aujourdhui' WHERE Devise= '$Dev'";
			$result = mysql_query( $sql );
			if( $result == 0 ) {
				$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			}
			$Message = "Modification ($Type) Devise ".$Dev;
			$aujourdhui = date("Y-m-d H:i:s");
			$sql = "INSERT INTO $database.login ( NomLogin, DateLogin, Operation ) VALUES ('".$_SESSION['NomLogin']."','$aujourdhui', '$Message')";
			$result = mysql_query( $sql );
			if( $result == 0 ) {
				$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
				AfficherErreur( $Mess );
			} // Si pas reussi
		}
		else {
		   $sql = "SELECT * FROM $database.monnaies WHERE Devise='$Dev'";
		   $result = mysql_query( $sql );
		   if( $result && mysql_num_rows($result) ) {
				$row = mysql_fetch_row($result);
				if( $Type == "VENTE" )
					$Taux = $row[1];
				else
					$Taux = $row[4];
		   		 	 
		   } // Si services existent
		   mysql_free_result($result);
			$sujet = "PROBLEME +++ TAUX $Dev";
			
			$info = "<font size='3'><b>MAJ Taux $Type</b><br/>
						Il semble y a voir un probleme avec la mise a jour du taux de change $Dev<br/></font>"; 
		

		   AlloWebmaster( $sujet, $info );
		}
		
//echo "B Type ".$Type." Vente ".$TxVente." Achat ".$TxAchat." Taux ".$Taux."<br>";

		return( $Taux );
} // get_NewTauxVente

function get_TauxVente($Dev)
/****************************************************************************
Fonction : get_TauxVente
Sortie : Taux de change du jour
Description : Cette fonction permet de récupérer le taux de change VENTE
					du jour pour une monnaie spécifier.
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $user,$host,$password,$database;
	   
   $Taux = 0;
		// **** CONNECTION AU SERVEUR
		if( !($Connection = mysql_connect( $host, $user, $password )) ) {
			$Message = mysql_errno().$TabMessGen[30].mysql_error();
			AfficherErreur($Message);
		} // Connection au serveur			   
		if( !($db = mysql_select_db( $database, $Connection )) ) {
			$Message = mysql_errno().$TabMessGen[31].mysql_error();
			AfficherErreur($Message);
		} // Selection de la BD
		
   $sql = "SELECT * FROM $database.monnaies WHERE Devise='$Dev'";
   $result1 = mysql_query( $sql, $Connection );
   if( $result1 == 0 ) {
     $NewMessage = "Erreur get taux".$sql;
   }
   elseif (  mysql_num_rows($result1) != 0 ) {
		$row = mysql_fetch_row($result1);
		if( !ValideStrDate($row[7]) ) {
			if( ($Tx = GetNewTaux( "VENTE" ,$Dev, $row[8] )) >= 0 )
				$Taux = $Tx;
			else 
				$Taux = $row[1];
		}
		else
			$Taux = $row[1];
   		 	 
   } // Si services existent
   mysql_free_result($result1);
   
   if( $Taux < 0 )
   	$Taux = 0;

   return($Taux);
} // get_TauxVente

function get_TauxAchat($Dev)
/****************************************************************************
Fonction : get_TauxAchat
Sortie : Taux de change du jour
Description : Cette fonction permet de récupérer le taux de change ACHAT
					du jour pour une monnaie spécifier.
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $user,$host,$password,$database;	 
   $Taux = 0;
		// **** CONNECTION AU SERVEUR
		if( !($Connection = mysql_connect( $host, $user, $password )) ) {
			$Message = mysql_errno().$TabMessGen[30].mysql_error();
			AfficherErreur($Message);
		} // Connection au serveur			   
		if( !($db = mysql_select_db( $database, $Connection )) ) {
			$Message = mysql_errno().$TabMessGen[31].mysql_error();
			AfficherErreur($Message);
		} // Selection de la BD
						
   $sql = "SELECT * FROM $database.monnaies WHERE Devise='$Dev'";
   $result1 = mysql_query( $sql, $Connection  );
   if( $result1 == 0 ) {
     $NewMessage = "Erreur get taux".$sql;
   }
   elseif (  mysql_num_rows($result1) != 0 ) {
		$row = mysql_fetch_row($result1);

		if( !ValideStrDate($row[7]) ) {
			if( ($Tx = GetNewTaux( "ACHAT" ,$Dev, $row[8] )) >= 0 )
				$Taux = $Tx;
			else 
				$Taux = $row[4];
		}
		else
			$Taux = $row[4];

  } // Si services existent

   mysql_free_result($result1);
   if( $Taux < 0 )
   	$Taux = 0;
   return($Taux);

} // get_TauxAchat



?>