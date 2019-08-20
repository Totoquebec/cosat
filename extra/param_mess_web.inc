<?php
					// On envoi un message au RESPONSABLE

					$entete = "MIME-Version: 1.0\r\n";                                 // le MIME approprié
					$entete = "Return-Path: ".$param['email_compte']."\r\n"; 
					$entete .= "Content-Type: text/html; charset=iso-8859-1\r\n";     // OU l'envoie html
					$entete .= "Content-Transfer-Encoding: 8bit\r\n";                   // nombre de bits d'encodage (8bits)
					$entete .= "X-Mailer: PHP/".phpversion()."\n";                      // l'e-maileur
					$entete .= "From: ".$param['email_compte']."\r\n";                          // qui l'envoie ?
					$entete .= "Reply-To: ".$param['email_support']."\n";                                 // son adresse
				
					ob_start();
					echo
					"<html>
						<head>
							<title>Un Message de $entr_url</title>
							<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
						</head>";
					include('styles/style.inc');
					echo "<body width='600px' >
					<br>
					<table bgcolor='#FFFFFF' width='600px' cellpadding='4' cellspacing='4' border='1' align='center' >
						<tr>
							<td align='center'>
								Le parametre « $resource » a été modifié.<br>
							</td>
						</tr>
						<tr>
							<td align='center'>
								<font size='+2'>$result</font>
							</td>
						</tr>
						<tr>
							<td align='right'>
								<i>Webmaster (<b>Denis</b>)</i>";
					echo "</td>
						</tr>
						<tr>
							<td align='right'>
								En date du :  <i>$Now</i><br/><br/>
							</td>
						</tr>
					</table>
					</body>
					</html>";
					
					$message .= ob_get_contents();
					
					ob_end_clean();
					

					$sujet = 'Table Parametre modifier';
					
					@mail( $param['email_support'], $sujet, $message, $entete);
//					echo "To ".$to." Sujet ".$sujet."".."<br>";
//					echo "Entete ".$entete."".."<br>";
//					echo $message."<br>";
//					exit();
?>