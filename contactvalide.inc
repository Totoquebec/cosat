<?php
//require_once 'Net/DNS.php';


                 foreach($_POST as $clé => $valeur ) {
                     switch( $clé ){
                        case "Nom"    	:
                        case "Prenom" 	:   if( !preg_match("/^[A-Za-z' ÉÈÊËÀÂÎÏÔÙÜéèêëàâîïôùü-]{1,40}$/",
                                                stripslashes( $valeur ) ) ) {
                                              AfficherErreur( "{$NomChamps[$clé]} incorrecte ou absente.");
                                            }
                                            break;
                        case "CodePostal" : $valeur = strtoupper( $valeur );
					    $$clé = rtrim ( $valeur ); 							 			  
                                            switch( $i = strlen( $valeur ) ) {
						case 0 : $Ok = 1;
							break;
                                            	case 5 : $Ok = preg_match("/[0-9]{5}/", $valeur );
                                                         break;
                                                case 6 : $Ok =preg_match("/([A-Z]{1})([0-9]{1})([A-Z]{1})([0-9]{1})([A-Z]{1})([0-9]{1})/", $valeur );
						   	 if( $Ok ) {
							 	 $t1= $valeur;
								 $t2 = $valeur[3];
								 $t3 = $valeur[4];
								 $t4 = $valeur[5];
								 $$clé = sprintf("%3.3s %s%s%s",$t1,$t2,$t3,$t4);
//								AfficherErreur("1:$t1 2:$t2 3:$t3 4:$t4 5:$t5");
							}
                                                         break;
                                                case 7 : $Ok = preg_match("/([A-Z]{1})([0-9]{1})([A-Z]{1})[ ]([0-9]{1})([A-Z]{1})([0-9]{1})/", $valeur );
                                                         break;
                                                default: $Ok = 0;
                                                         break;
                                            }
                                            if( !$Ok ) {
                                                 AfficherErreur( "{$NomChamps[$clé]} $i incorrect ou absent.");
                                            } // if code postale
                                            break;
			case "Courriel"	  : $Ok=preg_match('/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)+$/',$valeur);
				 			    // Es-ce que la chaine est valide
			 		    			if( $Ok ) {
									list ($login, $domaine) = explode ("@", $valeur,2);
    									//list( $username, $domain ) = explode( "@", $email, 2 );
    									if( checkdnsrr($domaine,'MX')) break;
					    			} // Si Ok
					    			else
					    				$login = $domaine = '';	 
                                        AfficherErreur( "{$NomChamps[$clé]} « $login@$domaine » incorrect ou absent.");
								break;
                        case "Téléphone"  : if( strlen($valeur) ) 
						if( !preg_match("/^[0-9 -.]{10,14}/", $valeur ) ){
                                                 AfficherErreur( "{$NomChamps[$clé]} incorrect ou absent  (999-999-9999).");
                                              } // if téléphone
                                            break;

                        case "Fax"	  :    if( strlen($valeur) ) {
                                              if( !preg_match("/^[0-9 -.]{10,14}/", $valeur ) ){
                                                 AfficherErreur( "{$NomChamps[$clé]} incorrect (999-999-9999). Corrigez S.V.P.");
                                              } // if téléphone ou fax
                                            }
                                            break;
                        case "DateInscrip": if( !preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $valeur) ) {
                                              AfficherErreur( "{$NomChamps[$clé]} incorrecte (aaaa-mm-jj). Corrigez S.V.P.");
                                            }
						$ladate = $valeur;
						$tmp = strtok($ladate,"-");
						if( !$tmp[0] )
							$$clé =  date("Y-m-d");
						$tmp = strtok("-");
//											AfficherErreur("tmp =>$tmp<=");
						if( !$tmp[0] && !$tmp[1] )
							$$clé =  date("Y-m-d");
						$tmp = strtok("-");
						if( !$tmp[0] && !$tmp[1] )
							$$clé =  date("Y-m-d");
                        default :	    	break;

                     } //switch
                  } // for each
?>