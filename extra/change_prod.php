<?php
/* Programme : LetCliLst.php
* Description : Affichage d'une liste de client pour les lettres.
* Auteur : Denis Léveillé 		Date : 2007-03-20
*/
include('connect.inc');

function myAddSlashes( $string ) { 
 	$string = str_replace ( "'", "`" , $string );
	if (get_magic_quotes_gpc()==1)  
		return ( $string ); 
	else  
		return ( addslashes ( $string ) );
	  
//mysql_real_escape_string(). 	
	
} // Addslash 


// **** Choix de la langue de travail ****
switch( @$_SESSION['SLangue'] ) {
	case "ENGLISH":	$_SESSION['langue'] = 'en';
							break;
	case "SPANISH":	$_SESSION['langue'] = 'sp';
							break;
	default:				$_SESSION['langue'] = 'fr';

} // switch SLangue

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Catalogue</title>
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
	  		  addKeyEvent();

	  </SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='javafich/blokclick.js'></SCRIPT>
      </body>
      </html>
  \n";
   exit();
}

	$query = "SELECT * FROM $mysql_base.stock;";
	$result = mysql_query($query, $handle); 

if( $result == 0 ) {
  MetMessErreur(mysql_error(),"Accès Produit impossible", mysql_errno());
}
elseif (  mysql_num_rows($result) != 0 ) {
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
		
		while( $p = mysql_fetch_assoc($result) ) {
			echo "Id ".$p['id']; 
			if( strlen($p['meta_keywords']) == 9 ) {
				echo " meta ".$p['meta_keywords']; 
				$p['titre_fr'] = str_replace ( $p['meta_keywords'], "" , $p['titre_fr'] );
				$p['titre_en'] = str_replace ( $p['meta_keywords'], "" , $p['titre_en'] );
				$p['titre_sp'] = str_replace ( $p['meta_keywords'], "" , $p['titre_sp'] );
				$p['description_fr'] = str_replace ( $p['meta_keywords'], "" , $p['description_fr'] );
				$p['description_en'] = str_replace ( $p['meta_keywords'], "" , $p['description_en'] );
				$p['description_sp'] = str_replace ( $p['meta_keywords'], "" , $p['description_sp'] );
				$p['description_supplementaire_fr'] = str_replace ( $p['meta_keywords'], "" , $p['description_supplementaire_fr'] );
				$p['description_supplementaire_en'] = str_replace ( $p['meta_keywords'], "" , $p['description_supplementaire_en'] );
				$p['description_supplementaire_sp'] = str_replace ( $p['meta_keywords'], "" , $p['description_supplementaire_sp'] );
				$sql =  "UPDATE $mysql_base.stock SET";
				$sql .=  " titre_fr='".myAddSlashes($p['titre_fr'])."',";
				$sql .=  " titre_en='".myAddSlashes($p['titre_en'])."',";
				$sql .=  " titre_sp='".myAddSlashes($p['titre_sp'])."',";  
				$sql .=  " description_fr='".myAddSlashes($p['description_fr'])."',";
				$sql .=  " description_en='".myAddSlashes($p['description_en'])."',";
				$sql .=  " description_sp='".myAddSlashes($p['description_sp'])."',"; 
				$sql .=  " description_supplementaire_fr='".myAddSlashes($p['description_supplementaire_fr'])."',";   
				$sql .=  " description_supplementaire_en='".myAddSlashes($p['description_supplementaire_en'])."',";  
				$sql .=  " description_supplementaire_sp='".myAddSlashes($p['description_supplementaire_sp'])."',"; 							
				$sql .=  " Code='".$p['meta_keywords']."', meta_keywords='' "; 							
				$sql .=  " WHERE id = '".$p['id']."';"; 							
//					MetMessErreur("",$sql,0);
				$result2 = mysql_query( $sql, $handle );
				if( $result2 == 0 ) {
					MetMessErreur(mysql_error(),"Accès Produit impossible ".$sql, mysql_errno());
				}
				 
			} //  Si
			echo "<br>"; 
		} // while
 
echo "
</body>
</html>
";
}
?>
