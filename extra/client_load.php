<?php
/* Programme : LetCliLst.php
* Description : Affichage d'une liste de client pour les lettres.
* Auteur : Denis Léveillé 		Date : 2007-03-20
*/
include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Client</title>
      </head>
 	  <SCRIPT language=JavaScript1.2 src='javafich/disablekeys.js'></SCRIPT>
    <body bgcolor='#FFFFFF'>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message</b>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
      Les droits de reproduction de ce site © $CopyAn $NomCie.<br>
      Tous droits réservés. © $CopyAn<br>
      </font></p>
      <SCRIPT LANGUAGE='javascript'>
	//  		  addKeyEvent();

	  </SCRIPT>
	  <!-- SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT -->
      </body>
      </html>
  \n";
   exit();
}

function insert_client(){
global $database,$TabMessGen,$Connection;

	$No = 0;
	if(!isset($_POST)) {
		echo "Impossible d'ajouter les informations du client.<br>";  // on met à jour les infos du clients
		return 0;
	}


	if( !isset($_SESSION[$_SERVER['SERVER_NAME']]) ){
		$sql = "SELECT mPasse FROM $database.secur WHERE NomLogin = '".$_POST['Courriel']."'";
		$result = mysql_query( $sql, $Connection );
		if(  $result && mysql_num_rows( $result ) ) {
			$ligne = mysql_fetch_array($result,MYSQL_ASSOC);
			extract($ligne);
			echo 'courriel_existant'.'<br>';
			extract( $_POST, EXTR_OVERWRITE );
					
			$sql =  "INSERT INTO  $database.client_rejet SET NoClient = '$NoClient', Nom='$Nom', Prenom='$Prenom',";
			$sql .=  " Contact='$Contact', Rue='$Rue', Indication='$Indication', Quartier='$Quartier',"; 
			$sql .=  " Ville='$Ville', Province='$Province', Pays='$Pays', CodePostal='$CodePostal',";
			$sql .=  " Telephone='$Telephone',Fax='$Fax', Cellulaire='$Cellulaire', Courriel='$Courriel',"; 
			$sql .=  " TypCli='$TypCli', Refere='$Refere', DateInscrip='$DateInscrip', DateRappel='$DateRappel',";
			$sql .=  " CoteCredit='$CoteCredit', Message='$password', Langue= '$Langue', TPSApp='$TPSApp', TVQApp='$TVQApp',";
			$sql .=  " Profession='', MaxCredit='$MaxCredit', Identite='$Identite', Debit='$Debit', DevCli='$DevCli', Naissance='';";
				
//			if( !mysql_query($sql, $Connection ) ) 
//						MetMessErreur(mysql_error(),$TabMessGen[32]." ".$sql, mysql_errno());
			mysql_query($sql, $Connection );
			return 0;
		}
	}						
	extract( $_POST, EXTR_OVERWRITE );
			
	$sql =  "INSERT INTO  $database.client SET NoClient = '$NoClient', Nom='$Nom', Prenom='$Prenom',";
	$sql .=  " Contact='$Contact', Rue='$Rue', Indication='$Indication', Quartier='$Quartier',"; 
	$sql .=  " Ville='$Ville', Province='$Province', Pays='$Pays', CodePostal='$CodePostal',";
	$sql .=  " Telephone='$Telephone',Fax='$Fax', Cellulaire='$Cellulaire', Courriel='$Courriel',"; 
	$sql .=  " TypCli='$TypCli', Refere='$Refere', DateInscrip='$DateInscrip', DateRappel='$DateRappel',";
	$sql .=  " CoteCredit='$CoteCredit', Message='$Message', Langue= '$Langue', TPSApp='$TPSApp', TVQApp='$TVQApp',";
	$sql .=  " Profession='', MaxCredit='$MaxCredit', Identite='$Identite', Debit='$Debit', DevCli='$DevCli', Naissance='';";
		
//	if( !mysql_query($sql, $Connection ) ) 
//				MetMessErreur(mysql_error(),$TabMessGen[32]." ".$sql, mysql_errno());
	if( mysql_query($sql, $Connection ) ) 
		$No = mysql_insert_id();
	
	return $No;


} // info_client

/

	$query = "SELECT * FROM $database.clients;";
	$result1 = mysql_query($query, $handle); 

if( $result1 == 0 ) {
  MetMessErreur(mysql_error(),"Accès Produit impossible", mysql_errno());
}
elseif (  mysql_num_rows($result1) != 0 ) {
  echo "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
  <html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
       <title>Change produit</title>	   
	  <meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
	  <meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
	  <meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
	  <meta name='author' content='$NomCieCréé' >
	  <meta name='copyright' content='copyright © $CopyAn $NomCie' >
  </head>
	<body bgcolor='#FFFFFF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>";
		
		echo "BASE DE DONNÉES OUVERTE<br>";
		// *** On ajouter les codes de prix par defaut tel que
		// defini dans la table système 
		$sql = " SELECT  * FROM $database.sysher ";
		
		$res = mysql_query($sql, $Connection);
		
		if( $res == 0 )
				MetMessErreur(mysql_error(),$TabMessGen[37], mysql_errno());
		elseif(  mysql_num_rows($res) == 0 ) 
		   	MetMessErreur(mysql_error(),$TabMessGen[19], mysql_errno());
		
		$ligne = mysql_fetch_array($res,MYSQL_ASSOC);
		extract($ligne);
		echo "TABLE SYSTEME OUVERTE<br>";
		
		$_POST['Indication'] = '';
		$_POST['Quartier'] = '';
		$_POST['CoteCredit'] = 'A'; 
		$_POST['TPSApp'] = "NON"; 
		$_POST['TVQApp'] = "NON";
		$_POST['Identite'] = ''; 
		$_POST['Debit'] = ''; 
		$_POST['DevCli'] = 'USD'; 
		$_POST['NoClient'] = '';
		$Aujourdhui = date("Y-m-d");
		
		while( $c = mysql_fetch_assoc($result1) ) {
/*			$Mess = "Date :".date( "Y-m-d H:i:s",$c['date_insertion']);
			$Mess .= " Time :".time()."Date :".date('d F Y', time());
			MetMessErreur('',$Mess, 0);*/
			
			echo "Id ".$c['id']."<br>"; 
			
			foreach($c AS $key => $value )
				str_replace("'","",$value);
			$_POST['Nom'] = myAddSlashes($c['nom']); 
			$_POST['Prenom'] =myAddSlashes($c['prenom']); 
			$_POST['Contact'] = myAddSlashes($c['entreprise']); 
			$_POST['Rue'] = myAddSlashes($c['adresse']);
			$_POST['Ville'] = myAddSlashes($c['ville']); 
			$_POST['Province'] = myAddSlashes($c['province']); 
			$_POST['Pays'] = myAddSlashes($c['pays']); 
			$_POST['CodePostal'] = $c['codepostal']; 
			$_POST['Courriel'] = myAddSlashes($c['courriel']); 
			$_POST['Telephone'] = myAddSlashes($c['telephone']); 
			$_POST['Fax'] = myAddSlashes($c['telecopieur']); 
			$_POST['Cellulaire'] = myAddSlashes($c['telephone2']); 
			$_POST['TypCli'] = "CLIENT"; 
			$_POST['Refere'] = 0; 
			if( $c['date_insertion'] > 1127093965 )
				$_POST['DateInscrip'] = date("Y-m-d",$c['date_insertion']);
			else
				$_POST['DateInscrip'] = $Now;
//			echo "Insc ".$c['date_insertion']."<br>"; 
//			echo "Date ".$_POST['DateInscrip']."<br>"; 
			$_POST['DateRappel'] = $c['DernierLog'];
			$_POST['Message'] = "FROM OLD DATABASE ".$c['id'];
			$_POST['password'] = $c['password'];
			switch( $c['langue'] ) {
				case "en":	$_POST['Langue'] = "ENGLISH"; 
								break;
				case "fr":	$_POST['Langue'] = "FRENCH"; 
								break;
				default:		$_POST['Langue'] = "SPANISH"; 
			
			} // switch SLangue
			$_POST['MaxCredit'] = $_SESSION['ClientMaxCrédit']; 
			$_POST['MaxAchat'] = $c['MaxAchat']; 
			if( $NoCli1 = insert_client() ) {

				$sql = "INSERT INTO $database.secur";
				$sql .= " ( NomLogin, mPasse, Priorite, Creation, Langue, NoClient ) VALUES";
				$sql .= " ('".$_POST['Courriel']."', '".$c['password']."', '10', '$Aujourdhui', '".$_POST['Langue']."', '$NoCli1')";
				if( !mysql_query($sql, $Connection) ) 				
				   	MetMessErreur(mysql_error(),$TabMessGen[36], mysql_errno());
				
				if( strlen( $Service1 ) && strlen( $CodeP1 ) ) {
					$sql =  "INSERT INTO $database.tarifclient	( NoClient, Service, CodeP	)";
					$sql .= " VALUES	( '$NoCli1','$Service1','$CodeP1' )";
					$result = mysql_query( $sql, $Connection );
				} // Si Service 1 defini
				if( strlen( $Service2 ) && strlen( $CodeP2 ) ) {
					$sql =  "INSERT INTO $database.tarifclient	( NoClient, Service, CodeP	)"; 
					$sql .= "VALUES ( '$NoCli1','$Service2','$CodeP2' )";
					$result = mysql_query( $sql, $Connection );
				} // Si Service 2 defini
				if( strlen( $Service3 ) && strlen( $CodeP3 ) ) {
					$sql =  "INSERT INTO $database.tarifclient ( NoClient, Service, CodeP	)";
					$sql .= " VALUES ( '$NoCli1','$Service3','$CodeP3' )";
					$result = mysql_query( $sql, $Connection );
				} // Si Service 3 defini
		
				if( strlen($c['livraison_nom']) && strlen($c['livraison_prenom']) ) {
					$_POST['Nom'] = myAddSlashes($c['livraison_nom']); 
					$_POST['Prenom'] = myAddSlashes($c['livraison_prenom']); 
					$_POST['Contact'] = myAddSlashes($c['livraison_entreprise']); 
					$_POST['Rue'] = myAddSlashes($c['livraison_adresse']);
					$_POST['Ville'] = myAddSlashes($c['livraison_ville']); 
					$_POST['Province'] = myAddSlashes($c['livraison_province']); 
					$_POST['Pays'] = "CUBA"; 
					$_POST['CodePostal'] = $c['livraison_codepostal']; 
					$_POST['Courriel'] = myAddSlashes($c['livraison_courriel']); 
					$_POST['Telephone'] = myAddSlashes($c['livraison_telephone']); 
					$_POST['MaxCredit'] = 0; 
					$_POST['TypCli'] = "DESTINATAIRE"; 
					$_POST['Refere'] = $NoCli1; 
					$_POST['DateRappel'] = '';
					$_POST['Langue'] = "SPANISH";
					$NoCli2 = insert_client();
					
					// ***** Insertion du lien avec le destinataire
					$sql = "INSERT INTO $database.destinataire ( Envoyeur, Destinataire )";
					$sql .= " VALUES ( '$NoCli1', '$NoCli2' )";
//					if( !mysql_query($sql, $Connection ) ) 
//						MetMessErreur(mysql_error(),$TabMessGen[32], mysql_errno());
					mysql_query($sql, $Connection );
				} // Si un non et prenom pour l'adresse de livraison
			} // Si un no de client valide 
			echo "<br>"; 
		} // while
 
echo "
</body>
</html>
";
}
?>
