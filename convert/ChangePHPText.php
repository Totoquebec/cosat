 <?php

/*
		// Prendre les informations des colonnes 
		$finfo = $result->fetch_fields();
		echo("<th>".$finfo[1]->name."</th>\n");

*/ 

$Src = array (
	   1 => 'mysql_query( $sql, $handle )',
	   2 => 'mysql_query( $sql,  $handle )',
	   3 => 'mysql_num_rows($result)',
	   4 => 'mysql_fetch_assoc($result)', 
	   5 => 'mysql_fetch_array($result,MYSQL_ASSOC)', 
	   6 => 'mysql_fetch_row($result)',
	   7 => 'mysql_errno()',
	   8 => 'mysql_error()',
	   9 => '$result == 0',
	   10 => 'mysql_field_name($result,',
	   11 => 'mysql_insert_id()',
	   12 => 'mysql_num_rows( $result )',
	   13 => '$handle',
	   14 => '',
);

$Dest = array (
	   1 => '$mabd->query($sql)',
	   2 => '$mabd->query($sql)',
	   3 => '$result->num_rows',
	   4 => '$result->fetch_assoc()', 
	   5 => '$result->fetch_assoc()', 
	   6 => '$result->fetch_row()',
	   7 => '$mabd->errno',
	   8 => '$mabd->error',
	   9 => '!$result',
	   10 => '$finfo[1]->name // ',
	   11 => '$mabd->insert_id',
	   12 => '$result->num_rows',
	   13 => '$mabd',
	   14 => '',
);
	   
 
     ## Function toString to invoke and split to explode

    function FixPHPText( $dir = "./" ){
    	global $Src,$Dest;
	    
	$Dat =  date("YmdHis");;
	
	$Nm = 'fix'.$Dat.'.log';
	// Ouverture fichier LOG
	$filehnd = @fopen($Nm, "w");
	
	// Es-ce réussi ?
	if( !$filehnd  ){
		echo "<p>Impossible d'ouvrir $Nm</p>";
		return FALSE;
	}
	

       	$d = new RecursiveDirectoryIterator( $dir );
       	foreach( new RecursiveIteratorIterator( $d, 1 ) as $path ){  
          if( 	is_file( $path ) && 
	  	( (substr($path, -3)=='php') || (substr($path, -3)=='inc' )) && 
		substr($path, -17) != 'ChangePHPText.php'){ 
              $orig_file = file_get_contents($path);
              $new_file = str_replace($Src[1], $Dest[1], $orig_file);
	      $max = sizeof($Src);
	      for( $i = 2; $i < $max; $i++ )
        	$new_file = str_replace( $Src[$i], $Dest[$i], $new_file );
		      
              if($orig_file != $new_file){
                file_put_contents($path, $new_file);
		$str = "$path converti";
		echo $str."<br/>";
		$str .= "\n";
		fwrite( $filehnd, $str );
                
              } // si fichier modifié
          } // si un fichier valide
      } // pour tout les fichiers
      
	// Fermer le fichier LOG
	fclose($filehnd);

    } // FixPHPText

    echo "----------------------- DEBUT Modification des fichiers PHP -------------------------<br/>";
    $start = (float) array_sum(explode(' ',microtime()));
    echo "<br/>*************** Mise à jour des fichiers ***************<br/>";
    echo "Changement de tout les fichiers PHP contenant :<br/>";
    echo "Par :<br/>";
    FixPHPText( "." );

    $end = (float) array_sum(explode(' ',microtime()));
    echo "<br/>------------------- Modification des fichiers PHP COMPLETÉ en: ". sprintf("%.4f", ($end-$start))." secondes ------------------<br/>";
    
 /*
----------------------- DEBUT Modification des fichiers PHP -------------------------

*************** Mise � jour des fichiers ***************
Changement de tout les fichiers PHP contenant :
Par :
.\mcfct_ajout.inc updated
.\mcfct_item.inc updated
.\mcfct_lst.inc updated
.\mcfct_rap_init.inc updated
.\mcfct_rap_sommaire.inc updated
.\mcfct_recherche.inc updated
.\mcfct_shwlst.php updated
.\mcfct_traite.inc updated

------------------- Modification des fichiers PHP COMPLETER en:0.0124 secondes ------------------
 */   
    
    ?>