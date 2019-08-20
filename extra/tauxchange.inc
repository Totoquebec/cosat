<?php 
/** http://www.x-rates.com/cgi-bin/xexcel/USD_rates.xls ***/
//include("gettxchg.inc");
 
  
class ConvertDevise { 
  
/** CONFIG >> **/ 
var $precision = 4; //<- decimal numbers after dot 
var $ModeCourant=3; //<- 1:'GBP' / 2:'British Pound' / 2:'British Pound (GBP)' 
var $update= 2; //<- cache updating interval (in hours) 
var $cache=true; //<- allow file caching for FASTER loading
var $FrTauxChg = 1.0175; 
var $FichierTemp='cache/mcache.txt'; //<- cache file (chmod folder to 755) 
/** << CONFIG **/ 
var $xml_obj; 
var $xml_data; 
var $map_array = array("Cube"=>true); 
var $updated; 
var $LstDevise; 
var $xml=1;

function ConvertDevise(){ 
  
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
  define('DIR',''); 
  
} 

function PremierElem($parser, $name, $attrs) { 
   if (isset($this->map_array[$name]))   
    if (@$attrs['time']) { 
	   $this->xml_data['EUR']=1;
	   $this->updated=$attrs['time']; 
	} 
    elseif ( @$attrs['currency']) 
	  $this->xml_data[$attrs['currency']]=$attrs['rate'];  
     
} 
function DernierElem($parser, $name) {} 
function characterData($parser, $data) {} 

function ChargeTaux(){ 
    $url='http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml'; 
    $update=1;#$this->update *60*60; 
	$buffer = "";
      
        
  if( $this->cache && 
  	  file_exists($this->FichierTemp) && 
	  filesize($this->FichierTemp)>1 && 
	  ( time() - $update < filemtime($this->FichierTemp)) ) { 
    //from cache 
	error_reporting(1); 
    $handle = fopen($this->FichierTemp, "r");   
      if ($handle) { 
       while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       //echo "\n<!-- Cached @".date('H:i', filemtime($this->FichierTemp))."-->\n"; 
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
  	  file_exists($this->FichierTemp) && 
	  filesize($this->FichierTemp)>1 ) {
         //from cache  
    	 $handle = fopen($this->FichierTemp, "r");   
      	 if ($handle) { 
       	 	while (!feof($handle))  $buffer .= fgets($handle, 4096); 
       		//echo "\n<!-- Cached @".date('H:i', filemtime($this->FichierTemp))."-->\n"; 
       		fclose($handle); 
      	 }   
	} // Si un fichier dans la cache
	  
    if( $this->cache && strlen($buffer) ) { // save cache 
      $handle = fopen($this->FichierTemp, "w");    
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
     if($k==$base) 
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
    $mul=$this->xml_data['USD']; 
    foreach ($this->xml_data as $k=>$v){ 
     if($k==$Devise) {
	    $out=$this->cutstr ($v/$mul);
		$out *= $this->FrTauxChg;
		$out /= 10;
	    $out = round($out,4);
	    $out *= 10; 

	 }  
    } 
 	return $out;
} // Donne Taux
 
function TrouveGraphiqueDevise($c) { 
   if( $this->xml  == 0 ) return;
   if( $c=='EUR' || !$this->LstDevise[$c] ) return 'Devise non valide'; 
   return "<img src=\"http://www.ecb.int/stats/exchange/eurofxref/shared/img/$c.png\" alt=\"$c chart\" />"; 
} 
  
  
} // Class
  
?>