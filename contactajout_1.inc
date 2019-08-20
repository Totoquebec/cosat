<?php
/* Programme : ContactAjout.php
* Description : Programme d'ajout d'un contact.
*/

$NomChamps = array(
		"NoContact"=>"Num�ro du contact",
		"Nom"=>"Nom du contact",
		"Pr�nom"=>"Pr�nom du contact",
		"Adresse"=>"Num�ro civique et Rue",
		"Ville"=>"Ville",
		"Province"=>"Province",
		"Pays"=>"Pays",
		"CodePostal"=>"Code postal",
		"TelCodR"=>"",
		"TelP1"=>"",
		"TelP2"=>"",
		"T�l�phone"=>"Num�ro de T�l�phone",
		"Fax"=>"Num�ro de Fax",
		"Courriel"=>"Adresse de Courriel",
		"Langue"=>"Langue",
		"DateInscrip"=>"Date d'inscription",
		"TypeMess"=>"Type de Client",
		"Sujet"=>"Le sujet du message",
		"Commentaire"=>"Le commentaire",
		"Ok"=>"Ok");
		
function AfficherErreur($texteMsg)
{ 
global $do,$NoContact,$Nom,$Prenom,$Adresse,
	   $Ville,$Province,$Pays,$CodePostal,$T�l�phone,$Fax,
	   $Courriel,$DateInscrip,$TypeMess,$Sujet,$Commentaire,
	   $Langue,$TelCodR,$TelP1,$TelP2, $txt, $param;

	$NewMessage = $texteMsg;
	unset($do);
	unset($EN_RECHERCHE);
	unset($EN_CONSULTE);
	unset($EN_CLIENT);
	$EN_AJOUT = 1;
	include("contactform.inc");
	exit();
}

function customCheckDnsrr($host,$recType='') {
 if(!empty($host)) {
  if($recType=='') $recType="MX";
  exec("nslookup -type=$recType $host",$output);
  foreach($output as $line) {
   if(preg_match("/^$host/", $line)) {
    return true;
   }
  }
  return false;
 }
 return false;
}

function checkEmail($email) {

  if(preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email)){

    list( $username, $domain ) = explode( "@", $email, 2 );
    if( checkdnsrr($domain,'MX')) {    
      return true;
    }    
    else
    	return false;
  }  
  else
  	return false;
}

function check_email_address($email) {
  // First, we check that there's one @ symbol, 
  // and that the lengths are right.
  if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
    // Email invalid because wrong number of characters 
    // in one section or wrong number of @ symbols.
    return false;
  }
  // Split it into sections to make life easier
  $email_array = explode("@", $email);
  $local_array = explode(".", $email_array[0]);
  for ($i = 0; $i < sizeof($local_array); $i++) {
    if
(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
$local_array[$i])) {
      return false;
    }
  }
  // Check if domain is IP. If not, 
  // it should be valid domain name
  if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
    $domain_array = explode(".", $email_array[1]);
    if (sizeof($domain_array) < 2) {
        return false; // Not enough parts to domain
    }
    for ($i = 0; $i < sizeof($domain_array); $i++) {
      if
(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$",
$domain_array[$i])) {
        return false;
      }
    }
  }
  return true;
}





switch( @$_GET['do'] ) {
	case "new" : 	extract($_POST,EXTR_OVERWRITE);
				// if(isset($_POST)) {foreach($_POST as $key=>$val) { echo $key.'=>'.$val.'<p>';  }}else { echo 'le formulaire n\'a pas �t� envoy�';}		 		   	
			$T�l�phone = "(".$TelCodR.")".$TelP1."-".$TelP2;  			  
                  	include( "contactvalide.inc");
//			$sql =  "INSERT INTO  $mysql_base.Contact SET NoClient = '@$NoClient', Nom='$Nom', Pr�nom='$Pr�nom',";
			$sql =  "INSERT IGNORE INTO  $mysql_base.contact SET Nom='".myAddSlashes($Nom)."', Pr�nom='$Prenom',";
			$sql .=  " Adresse='".myAddSlashes($Adresse)."', Ville='".myAddSlashes($Ville)."', Province='$Province', Pays='$Pays', CodePostal='$CodePostal',";
			$sql .=  " Courriel='$Courriel', T�l�phone='$T�l�phone',Fax='$Fax', Langue= '$Langue', DateInscrip='$DateInscrip',";
			$sql .=  " TypeMess='$TypeMess', Sujet='".myAddSlashes($Sujet)."', Commentaire='".myAddSlashes($Commentaire)."';";
			if( !mysql_query($sql, $handle) ) {
				$Mess ="ERREUR : ".mysql_errno().": ".mysql_error();
			   	AfficherErreur( $Mess );
			}
		 	$NoCon = mysql_insert_id();
		 	$domaine = @gethostbyaddr($ip) 
					or ($domaine = 'IP non r�solue');

		 	$sujet = "Un contact a �t� ajout� BD : ".$param['nom_client'];
			$info = "<font size='3'><b>Un nouveau contact no $NoCon sur<br>$entr_url</b><br/>
						$Nom, $Prenom<br/>
						Son IP : <b>$ip</b><br/><br/>
						User Agent : <b>$HTTP_USER_AGENT</b><br>
						Domaine : <b>$domaine</b><br>
						Courriel : <a href='mailto:$Courriel?subject=Reponse Cosat Informatique'>$Courriel</a><br/>
						TypeMess : $TypeMess<br>
						Sujet : $Sujet<br>
						Commentaire : $Commentaire<br>
						</font>"; 

			EnvoiCourriel( $param['email_info'], $sujet, $info );
			include( "contactok.inc");
			break;	
	default :	$NoContact = $Nom = $Prenom = "";
			$Adresse = $Ville = $Province = ""; 
			$Pays = $CodePostal = $Courriel = "";
			$T�l�phone = $Fax = "";
			$Langue="FRAN�AIS";
			$DateInscrip = date("Y-m-d");
			$TypeMess = "Information";
			$Sujet = $Commentaire="";
			unset($do);
			unset($EN_RECHERCHE);
			unset($EN_CONSULTE);
			unset($EN_CLIENT);
			$EN_AJOUT = 1;
			
			include( "contactform.inc");
			break;
}

?>
                                                                    