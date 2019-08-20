<?php
			$Ok = $Ok2 = 0;
			$sql = " SELECT * FROM $database.stock WHERE ";
			
			foreach($_POST as $clé => $valeur ) {
				switch( $clé ){
					case "id":	if( strlen($valeur) ) {
												stripslashes( $valeur );
												$$clé = strip_tags( trim( $valeur ) );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 1;
												}
												else
													$Ok = 1;
												$sql .= "id = '$valeur'";
											}
											break;
					case "Code":	if( strlen($valeur) ) {
												stripslashes( $valeur );
												$$clé = strip_tags( trim( $valeur ) );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 5;
												}
												else
													$Ok = 5;
												$sql .= "Code = '$valeur'";
											}
											break;
					case "titre_fr":	
											if( strlen($valeur) ) {
												stripslashes( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 4;
												}
												else
													$Ok = 4;
												$sql .= "titre_fr LIKE '$valeur%'";
											}
											break;
					case "titre_en":	
											if( strlen($valeur) ) {
												stripslashes( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 4;
												}
												else
													$Ok = 4;
												$sql .= "titre_en LIKE '$valeur%'";
											}
											break;
					case "titre_sp":	
											if( strlen($valeur) ) {
												stripslashes( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 4;
												}
												else
													$Ok = 4;
												$sql .= "titre_sp LIKE '$valeur%'";
											}
											break;
					case "description_fr":	
											if( strlen($valeur) ) {
												stripslashes( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 6;
												}
												else
													$Ok = 6;
												$sql .= "description_fr LIKE '$valeur%'";
											}
											break;
					case "description_en":	
											if( strlen($valeur) ) {
												stripslashes( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 6;
												}
												else
													$Ok = 6;
												$sql .= "description_en LIKE '$valeur%'";
											}
											break;
					case "description_sp":	
											if( strlen($valeur) ) {
												stripslashes( $valeur );
												if( $Ok ) {
													$sql .= " AND ";
													$Ok2 = 6;
												}
												else
													$Ok = 6;
												$sql .= "description_sp LIKE '$valeur%'";
											}
											break;
					default :	     break;
					
				} //switch
			} // for each
			$sql .= " LIMIT 500;";

?>