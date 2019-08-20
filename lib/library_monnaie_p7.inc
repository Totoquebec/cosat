<?php
	$urlbkcadxml='http://www.banqueducanada.ca/valet/observations/group/FX_RATES_DAILY/xml/FX_RATES_DAILY.xml';
	$urlbkcad='http://www.banqueducanada.ca/taux/sommaire-quotidien/';
	$bkcadcache='bankcadcache';
   	$urldesj='http://www.desjardins.com/taux-rendement/taux-change/cheques-traites-transfert-fonds/'; 
	$desjcache='desjcache';
	$urleuro='http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml'; 
	$eurocache= 'eurocache'; //<- cache file (chmod folder to 755) 


/** http://www.x-rates.com/cgi-bin/xexcel/USD_rates.xls ***/
class ConvertDevise { 
  
	/** CONFIG >> **/ 
	var $precision = 4; //<- decimal numbers after dot 
	var $ModeCourant=3; //<- 1:'GBP' / 2:'British Pound' / 2:'British Pound (GBP)' 
	var $update= 2; //<- cache updating interval (in hours) 
	var $cache=true; //<- allow file caching for FASTER loading
	var $FrTauxChg = 1.0175; 
	var $euro_cache = '';
	var $euro_url = '';
//	var $euro_cache= $acces_hermes.'/cache/mcache.txt'; //<- cache file (chmod folder to 755) 
	/** << CONFIG **/ 
	var $xml_obj; 
	var $xml_data; 
	var $map_array = array("Cube"=>true); 
	var $updated; 
	var $LstDevise; 
	var $xml=1;
	
	function __construct(){ //ConvertDevise(){ 
	  global $eurocache, $urleuro;
	  
	  $this->euro_cache = $eurocache;
	  $this->euro_url = $urleuro;
	  $this->xml_obj = xml_parser_create();  
	  xml_set_object( $this->xml_obj, $this ); 
	  xml_set_element_handler( $this->xml_obj, "PremierElem", "DernierElem");  
	  xml_set_character_data_handler($this->xml_obj, "characterData");  
	  xml_parser_set_option($this->xml_obj, XML_OPTION_CASE_FOLDING, 0); 
	  $this->ChargeTaux ();
	  if( $this->xml  == 0 ) return;
	 
	  ksort($this->xml_data); 
	  $this->LstDevise = array(
	  			'AUD'=>'Australian dollar',
	  			'BGN'=>'Bulgarian lev',
	  			'BRL'=>'Brasilian real ',
				'CAD'=>'Canadian dollar',
				'CHF'=>'Swiss franc', 
	  			'CNY'=>'Chinese yuan', 
				'CYP'=>'Cypriot Pound', 
				'CZK'=>'Czech koruna',
				'DKK'=>'Danish krone',
				'EEK'=>'Estonian kroon',  
				'EUR'=>'Euro',
				'GBP'=>'British pound', 
				'HKD'=>'Hong Kong dollar', 
				'HRK'=>'Croatian kuna', 
				'HUF'=>'Hungarian forint',  
				'IDR'=>'Indonesian rupiah', 
				'ILS'=>'Israeli shekel', 
				'INR'=>'Indian rupee', 
				'ISK'=>'Icelandic Krona', 
				'JPY'=>'Japanese yen', 
				'KRW'=>'South Korean won', 
				'LTL'=>'Lithuanian litas', 
				'LVL'=>'Latvian lats', 
				'MXN'=>'Mexican peso ', 
				'MTL'=>'Maltese lira', 
				'MYR'=>'Malaysian ringgit', 
				'NOK'=>'Norwegian krone', 
				'NZD'=>'New Zealand dollar', 
				'PHP'=>'Philippine Peso', 
				'PLN'=>'Polish zloty', 
				'RON'=>'Romanian lei', 
				'RUB'=>'Russian ruble', 
				'SEK'=>'Swedish krona', 
				'SGD'=>'Singapore dollar', 
				'SIT'=>'Slovenian tolar', 
				'SKK'=>'Slovak koruna', 
				'THB'=>'Thai baht', 
				'TRY'=>'Turkish lira', 
				'USD'=>'US Dollar', 
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
		global $mabd, $database,$Aujourdhui, $TabMessGen; 
		

		$buffer = "";
		$TxUSDCAD = 0;
		
										   			   
		$sql = " SELECT * FROM $database.cachetaux WHERE NomPage='$this->euro_cache'";
		$result = $mabd->query($sql);
		if( $result && $result->num_rows  ) {
				$RecPageTaux = $result->fetch_assoc();
				$DateMAJ = strtotime( $RecPageTaux['MAJ'] );
				$Maintenant = strtotime( $Aujourdhui  );
				if( $DateMAJ == $Maintenant ) {
					$buffer = $RecPageTaux['Data'];
	//				echo "Buffer bon ACHAT !!!<br>";
				}
		}
		else {
			$sql =  "INSERT INTO $database.cachetaux SET NomPage='$this->euro_cache', MAJ='0000-00-00', Data='';";
			if( !$mabd->query($sql) ) 
				echo ( "<br>"."ERREUR ChargeTaux ".$mabd->errno.": ".$mabd->error." : $sql<br>" );
		}
	
		if( !strlen($buffer) ) {
			echo "Accès Site ACHAT !!!<br>";
			$f_handle = fopen($this->euro_url, "r");
			if ($f_handle) { 
				while (!feof($f_handle))  
					$buffer .= fgets($f_handle, 4096); 
				fclose($f_handle); 
			} // Si site exchange accessible
		
			if( strlen($buffer) ) { // save cache 
				echo "Dans Save<br>";
				$tampon = addslashes($buffer);
	
				$sql =  "UPDATE $database.cachetaux SET `MAJ`='$Aujourdhui', `Data`='".$tampon."' WHERE `NomPage`='".$this->euro_cache."';";
	//			$sql =  'UPDATE '.$database.'.cachetaux SET MAJ="'.$Aujourdhui.'", Data="'.$tampon.'" WHERE NomPage="'.$this->euro_cache.'";';
	//			$sql =  "UPDATE $database.cachetaux SET NomPage='$desjcache', MAJ='$Aujourdhui', Data=`$tampon`;";
				if( !$mabd->query($sql) ) 
					echo ( "<br>"."ERREUR ChargeTaux ".$mabd->errno.": ".$mabd->error." : $sql<br>" );
				
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
		/*if( $Devise != 'USD' ) ///CAD
			$mul = $this->xml_data['USD'];
		else*/
			$mul = 1; 
	    	foreach( $this->xml_data as $k => $v ){ 
	    		if( $k==$Devise ) {
		    		$out = $this->cutstr( $v / $mul );
		    		$out = round($out,4);
		 	}  // Si la devise recherch�
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
Description : Cette fonction permet de r�cup�rer les diff�rentes Monnaies utilis�es
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $mabd,$database;
	   
   $S = "";	   

   $sql = " SELECT * FROM $database.monnaies WHERE Devise='".$Dev."'";
   $result = $mabd->query($sql);
   if( $result ) {
    if (  $result->num_rows != 0 ) {
		$row = $result->fetch_row();
		$S = $row[5];
     } // Si services existent
   } // Si pas erreur
   return($S);
   
} // get_Symbole

function get_Xtra($Dev)
/****************************************************************************
Fonction : GetExtra
Sortie : Trouve l'etra pour une devise
Description : Cette fonction permet de r�cup�rer les diff�rentes Monnaies utilis�es
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $mabd,$database;	   
   $Xtra = "";	   
   $sql = " SELECT * FROM $database.monnaies WHERE Devise='".$Dev."'";
   $result = $mabd->query($sql);
   if( !$result ) {
     echo "Erreur get extra ".$sql." <br>\n";
   }
   elseif (  $result->num_rows != 0 ) {
		$row = $result->fetch_row();
		$Xtra = $row[4];
   } // Si services existent
  
   return($Xtra);
} // get_xtra

function ChargeTauxDesjardins( $Type, $dev )
/****************************************************************************
Fonction : ChargeDesjardinsVente()
Sortie : Taux de vente USD en CAD
Description : R�cup�re sur le site de Desjardins les taux de vente du USD .
Auteur : Denis Léveillé 	 		  Date : 2007-01-23

  
    
  <tr> 
   <th class="cell-texte"><span class="taux" type="switch">Etats-Unis</span></th> 
   <td class="cell-texte"><span class="taux">dollar</span></td> 
   <td class="cell-texte"><span class="taux">USD</span></td> 
   <td class="cell-num"><span class="taux">1,276500</span></td> 
   <td class="cell-num"><span class="taux">1,341900</span></td> 
   <td class="cell-num"><span class="taux">15 000</span></td> 
  </tr>
  
    
*****************************************************************************/
{
global $mabd,$database,$desjcache, $urldesj, $Aujourdhui, $TabMessGen; 
	$buffer = "";
	$TxChange = 0;
	
	$sql = " SELECT * FROM $database.cachetaux WHERE `NomPage` = '$desjcache' AND `Devise` = '$dev'";
	$result = $mabd->query($sql);
	if( $result && $result->num_rows  ) {
			$RecPageTaux = $result->fetch_assoc();
			$DateMAJ = strtotime( $RecPageTaux['MAJ'] );
			$Maintenant = strtotime( $Aujourdhui  );
			if( $DateMAJ == $Maintenant ) {
				$buffer = $RecPageTaux['Data'];
			}
	}
	else {
		$sql =  "INSERT INTO $database.cachetaux SET NomPage='$desjcache', `Devise` = '$dev', MAJ='0000-00-00', Data='';";
		if( !$mabd->query($sql) ) 
			echo ( "<br>"."ERREUR ChargeDesjardinsVente ".$mabd->errno.": ".$mabd->error." : $sql<br>" );
	}

	if( !strlen($buffer) ) {
		// echo "Accès Site VENTE !!!<br>";
	
		@$f_handle = fopen($urldesj, "r");
		if ($f_handle) { 
			while (!feof($f_handle))  
				$buffer .= fgets($f_handle, 4096); 
			fclose($f_handle); 
		} // Si site exchange accessible
	
		if( strlen($buffer) ) { // save cache 
//			echo "Dans Save<br>";
			$buffer = str_replace( chr( 160 ), ' ', $buffer );
			$tampon = trim( $tampon );
			$tampon = addslashes($buffer);
			//$tampon = $buffer;
			$PosDEVISE = strpos ( $tampon, $dev );
			//echo "Dans Save Pos 1 : $PosDEVISE<br>";
			$PosDEVISE -= 195;
			//echo "Dans Save Pos 2 : $PosDEVISE<br>";
			$buffer = substr ( $tampon, $PosDEVISE, 410 );
			//echo "Dans Save buf : >>$buffer<< <br><br>";
			$sql =  'UPDATE '.$database.'.cachetaux SET MAJ="'.$Aujourdhui.'", Data="'.$buffer.' " WHERE NomPage="'.$desjcache.'" AND Devise = "'.$dev.'";';
			//$sql =  "UPDATE $database.cachetaux SET `MAJ` = '$Aujourdhui', `Data` = '$buffer' WHERE NomPage = '$desjcache' AND `Devise` = '$dev';";
			if( !$mabd->query($sql) ) 
				echo ( "<br>ERREUR ChargeDesjardinsVente UPDATE ".$mabd->errno.": ".$mabd->error." : $sql<br>" );
			
		} // Si données cacher     
	}

	if( strlen( $buffer ) ) {
		// Trouve la chaine USD = US Dollar
		$Ptr = strstr( $buffer, $dev );
		if( strlen($Ptr) ) {
	//echo "<br>PTR ChargeDesjardinsVente 1 =>".$Ptr."<= <br>";
			// taux d'achat
			$Ptr = strstr( $Ptr, "taux" );
			
	//echo "<br>PTR ChargeDesjardinsVente 2 =>".$Ptr."<= <br>";
			if( $Type == 'VENTE' ) {
				$Ptr = substr( $Ptr, 6, 100);
				$Ptr = strstr( $Ptr, 'taux' );
	//echo "<br>PTR ChargeDesjardinsVente 3 =>".$Ptr."<= <br>";
			}
			$Ptr = substr($Ptr, 6, 8);
	//echo "<br>PTR ChargeDesjardinsVente 4 =>".$Ptr."<= <br>";
			
			// Si trouver
			if( $Ptr != FALSE ) {
			
				$TxChange = $Ptr;
				$TxChange[1] = '.';
				//			  $TxChange = 1.0 / $TxChange;
				$TxChange = floatval($TxChange);
				$TxChange = round($TxChange,4);
			} // Si un chaine
		}
	} // Si buffer plein
 //echo "Taux US Desjardins Vente ".$TxChange."<br>\n";
	return($TxChange);	
} // ChargeDesjardinsVente   


function GetNewTaux( $Type, $Dev, $frais)
/****************************************************************************
Fonction : GetNewTaux
Sortie : Nouveau taux de change du jour
Description : Cette fonction permet de r�cup�rer le taux de change de $Type ( ACHAT, VENTE )
					du jour pour une monnaie sp�cifier dans $Dev en ajoutant le frais $frais
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $database, $entr_url, $mabd;
//echo "GETNEWTAUX<br>";
		// On initialise a -1 pour indiquer une erreur
		// Car un taux de 0 peux �tre valide
		$TxVente = $TxAchat = $Taux = -1;
		$Tx = 0;
		$aujourdhui = date("Y-m-d");
//echo "A Type : $Type $Dev Vente : $TxVente  Achat : $TxAchat Taux : $Taux<br>";
		
		if( $Tx = ChargeTauxDesjardins( "VENTE", $Dev ) ) { 
			$TxVente = 1.0 / $Tx;
			$TxVente += $frais;
		}
		if( $Tx = ChargeTauxDesjardins( "ACHAT", $Dev ) ) { 
			$TxAchat = $Tx;
			$TxAchat += $frais;
		}
//echo "B Type : $Type Vente : $TxVente Achat : $TxAchat Taux :$Taux Tx : $Tx<br>";
		
		
		if( $Type == "VENTE" )
			$Taux = $TxVente;
		else
			$Taux = $TxAchat;
			
		if( $Taux >= 0 ) {
			$sql =  "UPDATE $database.monnaies SET TxAchatUS='$TxAchat', TxVenteUS='$TxVente', DateMAJ='$aujourdhui' WHERE Devise= '$Dev'";
			$result = $mabd->query($sql);
			if( !$result ) {
				$Mess ="ERREUR GetNewTaux : ".$mabd->errno.": ".$mabd->error;
				echo $Mess."<br>";
			}
			$Message = "Modification ($Type) Devise ".$Dev;
			$aujourdhui = date("Y-m-d H:i:s");
			$sql = "INSERT INTO $database.login ( NomLogin, DateLogin, Operation ) VALUES ('".$_SESSION['NomLogin']."','$aujourdhui', '$Message')";
			$result = $mabd->query($sql);
			if( !$result ) {
				$Mess ="ERREUR GetNewTaux : ".$mabd->errno.": ".$mabd->error;
				echo $Mess."<br>";
			} // Si pas reussi
		}
		else {
		   $sql = "SELECT * FROM $database.monnaies WHERE Devise='$Dev'";
		   $result = $mabd->query($sql);
		   if( $result && $result->num_rows ) {
				$row = $result->fetch_row();
				if( $Type == "VENTE" )
					$Taux = $row[1];
				else
					$Taux = $row[4];
		   		 	 
		   } // Si services existent

		 /*  if( $Dev != "CAD" ) {
			$sujet = "MAJ +++ TAUX $Dev";
			$info = "<font size='3'>Sur le site $entr_url<br>
				<b>GetNewTaux MAJ Taux $Type</b><br/>
				Il semble y avoir une mise a jour du taux de change $Dev<br/></font>"; 
			AlloWebmaster( $sujet, $info );
		   }*/
		   
		  
		}
		
//echo "C Type ".$Type." Vente ".$TxVente." Achat ".$TxAchat." Taux ".$Taux."<br>";

		return( $Taux );
} // get_NewTaux

function get_TauxVente($Dev)
/****************************************************************************
Fonction : get_TauxVente
Sortie : Taux de change du jour
Description : Cette fonction permet de r�cup�rer le taux de change VENTE
					du jour pour une monnaie sp�cifier.
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $mabd,$database;
	   
   $Taux = 0;
		
   $sql = "SELECT * FROM $database.monnaies WHERE Devise='$Dev'";
   $result1 = $mabd->query($sql);
   if( !$result1 ) {
     	$NewMessage = "Erreur get taux".$sql;
   }
   elseif (  $result1->num_rows != 0 ) {
		$row = $result1->fetch_row();
		//echo "<br><br><br><br><br><br>get_TauxVente Dev ".$Dev." Vente ".$row[1]." Date : ".$row[7]."<br>";
		if( !ValideStrDate( $row[7] ) && $row[9] ) {
			if( ($Tx = GetNewTaux( "VENTE" , $Dev, $row[8] )) >= 0 )
				$Taux = $Tx;
			else 
				$Taux = $row[1];
		}
		else
			$Taux = $row[1];
   		 	 
   } // Si services existent
  
   
   if( $Taux < 0 )
   	$Taux = 0;

   return($Taux);
} // get_TauxVente

function get_TauxAchat($Dev)
/****************************************************************************
Fonction : get_TauxAchat
Sortie : Taux de change du jour
Description : Cette fonction permet de r�cup�rer le taux de change ACHAT
					du jour pour une monnaie sp�cifier.
Auteur : Denis Léveillé 	 		  Date : 2007-01-26
*****************************************************************************/
{
global $mabd,$database;	 

   $Taux = 0;
						
   $sql = "SELECT * FROM $database.monnaies WHERE Devise='$Dev'";
   $result1 = $mabd->query($sql);
   if( !$result1 ) {
     $NewMessage = "Erreur get taux".$sql;
   }
   elseif (  $result1->num_rows != 0 ) {
		$row = $result1->fetch_row();

		if( !ValideStrDate($row[7]) && $row[9] ) {
			if( ($Tx = GetNewTaux( "ACHAT" ,$Dev, $row[8] )) >= 0 )
				$Taux = $Tx;
			else 
				$Taux = $row[4];
		}
		else
			$Taux = $row[4];

  } // Si services existent

   if( $Taux < 0 )
   	$Taux = 0;
   return($Taux);

} // get_TauxAchat




?>