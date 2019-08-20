<?php
// DEBUT FUNCTIONS DIVERS --
/**********************************************************************************************
Table des matières des functions
___________________________
function get_autoincrement( $Nomtable )
function get_enums($table, $field)
function get_Modepaye( $web=0, $email=0, $online=1, $rapport=0 )
function get_money($TypMon)
**********************************************************************************************/

function get_autoincrement( $Nomtable )
//  FUNCTION : get_autoincrement - 1a
//  version : 1.0
//  date : 2015-01-15
//  derniere modif : Denis Léveillé
//  info : retourne l'autoincrement d'un item de la table spécifier
{
global  $mabd, $database;
	$No = 0;
	$sql = "SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$database' AND TABLE_NAME = '$Nomtable'"; 
	$result = $mabd->query($sql);
	if( $result ) {
		$ligne = $result->fetch_assoc();
		//foreach($ligne as $clé => $valeur ) 
	//		echo "Cle=$clé Val=$valeur<br>";
		//extract($ligne);
		$No = $ligne['AUTO_INCREMENT'];  
		 //MAX( NoFacture )'] + 1;
	}
	return $No;
} // fin de la fonction : get_autoincrement


function get_enums($table, $field)
/****************************************************************************
Fonction : get_enums
Entrée : une chaîne contenant le nom d'une table, une chaîne contenant le nom
         d'un champ de type ENUM de la table
Sortie : tableau de chaîne contenant toutes les possibilité du champ ENUM
Description : Cette fonction permet de récupérer les différentes possibilités
              d'un ENUM
Auteur : Denis Léveillé 	 		  Date : 2004-01-01
	* MAJ : Denis Léveillé 	 		  Date : 2007-01-22
*****************************************************************************/
{
global  $mabd, $database;
    // on récupère les propriétés de la table :
    // chaque ligne représente un champ de la table :
    // les colonnes sont 'Field','Type'...
	// **** CONNECTION AU SERVEUR
	// **** CONNECTION AU SERVEUR
	$option= array();
	$sql = "desc $database.$table";
	$result= $mabd->query($sql);
	if( !$result ) 
		echo "Problème table $table<br>";
	else {
		while( $row = $result->fetch_array() )  {
			// on ne s'intéresse qu'au champ donné en paramètre
			if( $row['Field'] == $field ) {
				// on récupère les types possible
				// la chaîne du champ 'Type' est ainsi constituée :
				// enum('bleu','vert','marron')
				$option=explode(",", substr($row['Type'], 5, -1));
				for($i=0;$i<sizeof($option);$i++)
				$option[$i] = str_replace("'","",$option[$i]); // suppression des apostrophes pour chaque valeur possible
			} // Row == filed
		} // While
	}
	return($option);
}

function get_Modepaye( $web=0, $email=0, $online=1, $rapport=0 )
/****************************************************************************
Fonction : get_Modepaye
Sortie : tableau de chaîne contenant tout les modes de paiement
Description : Cette fonction permet de récupérer les différents modes de paiement
Auteur : Denis Léveillé 	 		  Date : 2007-03-27
*****************************************************************************/
{
global  $mabd, $database, $PrioCompte;



 	$_SESSION['MODPAY_ERREUR'] = 0;

	//echo "Dans info_facture : $serie $NoFct <br>";
	$sql = "SELECT * FROM $database.mcpayaccept";
	if( !($result = $mabd->query($sql))  )  {
		//-- Structure de la table `mcpayaccept`


		$sql = "CREATE TABLE `mcpayaccept` (";
		$sql .= "`Mode` tinyint(4) NOT NULL DEFAULT '0',";
		$sql .= "`fr` varchar(16) NOT NULL DEFAULT 'MANDAT',";
		$sql .= "`en` varchar(16) NOT NULL DEFAULT 'MONEY ORDER',";
		$sql .= "`Description_fr` varchar(80) DEFAULT NULL,";
		$sql .= "`Description_en` varchar(80) DEFAULT NULL,";
		$sql .= "`Surcharge` decimal(7,3) DEFAULT NULL,";
		$sql .= "`Web` tinyint(1) NOT NULL DEFAULT '0',";
		$sql .= "`EMail` tinyint(1) NOT NULL DEFAULT '0',";
		$sql .= "`Online` tinyint(1) NOT NULL DEFAULT '1',";
		$sql .= "`Rapport` tinyint(1) NOT NULL DEFAULT '1',";
		$sql .= "`AuCpt` varchar(1) NOT NULL DEFAULT 'N',";
		$sql .= "`Prio` int(2) NOT NULL DEFAULT '10'";
		$sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1;";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MODPAY_ERREUR'] = 1;
			$_SESSION['MODPAY_MESSAGE'] = "ERREUR Creation Paiement Accepté : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}


		//-- Chargement des données de la table `mcpayaccept`

		$sql = "INSERT INTO `mcpayaccept` (`Mode`, `fr`, `en`, `Description_fr`, `Description_en`, `Surcharge`, `Web`, `EMail`, `Online`, `Rapport`, `AuCpt`, `Prio`) VALUES";
		$sql .= "(0, 'N/A', 'N/A', NULL, NULL, NULL, 0, 0, 0, 1, 'N', 10),";
		$sql .= "(2, 'COMPTANT', 'CASH', 'PAYER COMPTANT', 'CASH PAYMENT', NULL, 0, 0, 1, 1, 'N', 10),";
		$sql .= "(4, 'INTERAC', 'INTERAC', 'PAIEMENT INTERACT', '', NULL, 0, 0, 1, 1, 'N', 10),";
		$sql .= "(5, 'VISA', 'VISA', 'CARTE CRÉDIT VISA', 'VISA CREDIT CARD', '0.035', 0, 1, 1, 1, 'N', 10),";
		$sql .= "(6, 'MASTER CARD', 'MASTER CARD', 'CARTE CRÉDIT MASTER CARD', 'MASTER CARD CREDIT CARD', '0.035', 0, 1, 1, 1, 'N', 10),";
		$sql .= "(7, 'AMEX', 'AMEX', 'CARTE CRÉDIT AMERICAN EXPRESS', 'AMERICAN EXPRESS CREDIT CARD', '0.040', 0, 0, 0, 1, 'N', 10),";
		$sql .= "(26, 'COMPTE', 'ACCOUNT', 'Chargé au compte du client', 'Customer account charge', NULL, 0, 0, 1, 0, 'O', 10),";
		$sql .= "(10, 'CHÈQUE', 'CHECK', 'CHÈQUE BANCAIRE', 'BANKER CHECK', '0.000', 0, 1, 1, 1, 'N', 10);";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MODPAY_ERREUR'] = 1;
			$_SESSION['MODPAY_MESSAGE'] = "ERREUR Insertion Paiement Accepté : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}

		// -- Index pour la table `mcpayaccept`
		$sql = "ALTER TABLE `mcpayaccept`";
		$sql .= " ADD PRIMARY KEY (`Mode`);";
		$sql .= "COMMIT;";
		if( !($result = $mabd->query($sql))  )  {
			$_SESSION['MODPAY_ERREUR'] = 1;
			$_SESSION['MODPAY_MESSAGE'] = "ERREUR Index Paiement Accepté : ".$mabd->errno.": ".$mabd->error."<br>".$sql;
			return( 0 );
		}
	} // Si la table n'existe pas

  	$Tab = array();	   

	$sql = "SELECT * FROM $database.mcpayaccept WHERE (Mode >= 0)";
	
	if( $online )
		$sql .= " AND ( Online = '$online' )";

	if( $web ) 
		$sql .= " AND ( Web = '$web' )";

	if( $email ) 
		$sql .= " AND ( EMail = '$email' ) ";

	if( $rapport ) 
		$sql .= " AND ( Rapport = '$rapport' ) ";

	$result = $mabd->query($sql);
   	if( !$result ) {
		$_SESSION['MODPAY_ERREUR'] = 1;
		$_SESSION['MODPAY_MESSAGE'] = "get_Modepaye - Probleme accès table.";
		return( $Tab );
  	}
	elseif (  $result->num_rows != 0 ) {
		while( $row = $result->fetch_row() ) {
			// Avos la priorite pouyr ce type de paiement
			if( $row[11] >= $_SESSION['Prio'] ) {
				switch( $_SESSION['SLangue'] ) {
					case "ENGLISH" :	$Mode = $row[2];
								break;
					default :		$Mode = $row[1];
								break;
				}
				$Tab[$row[0]] = $Mode;
				
				// es-ce au AuCpt alors on le rend disponible
				if( $row[10] == 'O' )
					$_SESSION['AUCPT'] = $row[0];
			} // pour la priorite
		} // while des mode de paiement
	} // Si services existent
	return($Tab);
} // get_ModePaye

function get_money( $TypMon )
/****************************************************************************
Fonction : get_money
Sortie : tableau de chaîne contenant toutes monnaies repondant au critère
Description : Cette fonction permet de récupérer les différentes Monnaies utilisées
Auteur : Denis Léveillé 	 		  Date : 2007-01-23
*****************************************************************************/
{
global $mabd,$database;
	   
	$_SESSION['MONEY_ERREUR'] = 0;
	$Tab = array();	 

	$sql = " SELECT * FROM $database.monnaies";
	switch( @$TypMon ) {
			case 'Paiement':  $sql .= " WHERE Paiement = 'OUI'";
					break;
			case 'Transfert': $sql .= " WHERE Transfert = 'OUI'";
					break;

			default : break;
	}
	$result = $mabd->query($sql);
	if( !$result ) {
			$_SESSION['MONEY_ERREUR'] = 1;
			$_SESSION['MONEY_MESSAGE'] = "get_money - Probleme accès table.";
			return( $Tab );
	}
	elseif (  $result->num_rows != 0 ) {
		for( $i=0; $i < $result->num_rows; $i++ ) {
			$row = $result->fetch_row();
			$Tab[$i] = $row[0];
		}
	} // Si services existent
	return($Tab);
} // get_money

?>