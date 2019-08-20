<?php
//require_once 'Net/DNS.php';


                 foreach($_POST as $cl� => $valeur ) {
                     switch( $cl� ){
                        case "Nom"    	:
                        case "Prenom" 	:   if( !preg_match("/^[A-Za-z' ����������������������-]{1,40}$/",
                                                stripslashes( $valeur ) ) ) {
                                              AfficherErreur( "{$NomChamps[$cl�]} incorrecte ou absente.");
                                            }
                                            break;
                        case "CodePostal" : $valeur = strtoupper( $valeur );
					    $$cl� = rtrim ( $valeur ); 							 			  
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
								 $$cl� = sprintf("%3.3s %s%s%s",$t1,$t2,$t3,$t4);
//								AfficherErreur("1:$t1 2:$t2 3:$t3 4:$t4 5:$t5");
							}
                                                         break;
                                                case 7 : $Ok = preg_match("/([A-Z]{1})([0-9]{1})([A-Z]{1})[ ]([0-9]{1})([A-Z]{1})([0-9]{1})/", $valeur );
                                                         break;
                                                default: $Ok = 0;
                                                         break;
                                            }
                                            if( !$Ok ) {
                                                 AfficherErreur( "{$NomChamps[$cl�]} $i incorrect ou absent.");
                                            } // if code postale
                                            break;
			case "Courriel"	  : $Ok=preg_match('/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)+$/',$valeur);
				 			    // Es-ce que la chaine est valide
			 		    if( $Ok ) {
						list ($login, $domaine) = explode ("@", $valeur,2);
						// es-ce que le domaine est valide
//						if (getmxrr($domaine,$mxrecords))
//							break;
/*						$resolver = new Net_DNS_Resolver();
						$resolver->debug = 1; // Turn on debugging output to show the query
						if( $resolver->query($domaine, 'MX') )
						break;*/
						if ( checkEmail( $domaine ) ) break;
						//if ( customCheckDnsrr($domaine,'MX') ) break;
					    } // Si Ok
					    else
					    	$login = $domaine = '';	 
                                            AfficherErreur( "{$NomChamps[$cl�]} � $login@$domaine � incorrect ou absent.");
											break;
                        case "T�l�phone"  : if( strlen($valeur) ) 
						if( !preg_match("/^[0-9 -.]{10,14}/", $valeur ) ){
                                                 AfficherErreur( "{$NomChamps[$cl�]} incorrect ou absent  (999-999-9999).");
                                              } // if t�l�phone
                                            break;

                        case "Fax"	  :    if( strlen($valeur) ) {
                                              if( !preg_match("/^[0-9 -.]{10,14}/", $valeur ) ){
                                                 AfficherErreur( "{$NomChamps[$cl�]} incorrect (999-999-9999). Corrigez S.V.P.");
                                              } // if t�l�phone ou fax
                                            }
                                            break;
                        case "DateInscrip": if( !preg_match("/([0-9]{4})-([0-9]{1,2})-([0-9]{1,2})/", $valeur) ) {
                                              AfficherErreur( "{$NomChamps[$cl�]} incorrecte (aaaa-mm-jj). Corrigez S.V.P.");
                                            }
						$ladate = $valeur;
						$tmp = strtok($ladate,"-");
						if( !$tmp[0] )
							$$cl� =  date("Y-m-d");
						$tmp = strtok("-");
//											AfficherErreur("tmp =>$tmp<=");
						if( !$tmp[0] && !$tmp[1] )
							$$cl� =  date("Y-m-d");
						$tmp = strtok("-");
						if( !$tmp[0] && !$tmp[1] )
							$$cl� =  date("Y-m-d");
                        default :	    	break;

                     } //switch
                  } // for each
?>