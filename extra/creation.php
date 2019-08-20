<?php
/* Fichier : Creation.php
* Description : Creation des tables nécessaire à un programme
* Auteur : Denis Léveillé 	 		  Date : 2004-01-01

Attention 
N'utilisez pas extract sur des données inconnues, comme les données 
utilisateurs ( $_GET , etc). Si vous le faites, par exemple, pour rendre 
compatible un vieux code avec register_globals à Off de façon temporaire, 
assurez-vous d'utiliser l'une des constantes extract_type qui n'écrasent 
pas les valeurs, comme EXTR_SKIP . Sachez aussi que vous devez maintenant 
extraire $_SERVER , $_SESSION , $_COOKIE , $_POST et $_GET dans cet ordre. 
 
<INPUT TYPE = password NAME = oPassword AUTOCOMPLETE = "off">

<FORM AUTOCOMPLETE = "off">
:
</FORM>


    */

session_start();

include("vartb.inc");
include("varcie.inc");

function MetMessErreur( $Erreur, $Message, $NoErr )
{
include("varcie.inc");
	echo "
      <html>
      <head>
      <title>Page d'Erreur</title>
      </head>
	  <SCRIPT language=JavaScript1.2 src='javafich/mm_menu.js'></SCRIPT>
	  <SCRIPT language=JavaScript1.2 src='javafich/loadmenu.js'></SCRIPT>
      <body>
	  <SCRIPT language=JavaScript1.2>mmLoadMenus();</SCRIPT>
	  <BASE TARGET=MAIN>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message</b>
      <form action='Support.php' method='post'>
         <input type='submit' value='Retour à la page précédente'>
      </form>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
      Les droits de reproduction de ce site © 2004 <?php echo $NomCie ?>.<br>
      Tous droits réservés. © 2007 <br>
      </font></p>
      </body>
      </html>
   \n";
   exit();
}

?>

<html>
<head>
<title>Page de création des tables E-Hermes</title>
</head>
<SCRIPT language=JavaScript1.2 src="javafich/mm_menu.js"></SCRIPT>
<SCRIPT language=JavaScript1.2 src="javafich/loadmenu.js"></SCRIPT>
<body bgcolor='#6666FF' topmargin='0' leftmargin='0' marginheight='0' marginwidth='0'>
<SCRIPT language=JavaScript1.2>mmLoadMenus();</SCRIPT>

<?php

// Connection au serveur MySQL
$Connection = mysql_connect( $host, $user, $password)
	or MetMessErreur(mysql_error(), "Connection impossible au serveur", mysql_errno() );

$db = mysql_select_db( $database, $Connection );


if( $db != 0 )
	MetMessErreur("ERREUR BASE DE DONNÉES DÉJÀ EXISTANTE","Opération de création INVALIDE", $db );

echo "
     <p align='center'><font size='2'><br>
      CREATION DE LA BASE DE DONNÉES<br>
      </font></p>
     ";

$sql = "CREATE DATABASE $database";
$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la base de données", $result );

$db = mysql_select_db( $database, $Connection );

// *** TABLE SESSION
echo "
     <p align='center'><font size='2'><br>
     CREATION DE LA TABLE SESSION<br>
      </font></p>
     ";
$sql = "CREATE TABLE session
(
  ID_Session   	VARCHAR(32) NOT NULL default '',
  Usager	   		VARCHAR(16) default NULL,
  IP_Addr	   	VARCHAR(12),
  Date_Cree	   	DATETIME NOT NULL,
  Derniere_MAJ 	INT NOT NULL default '0',
  Donnees_Session	LONGTEXT,
  PRIMARY KEY  ( ID_Session ),
  KEY ( Derniere_MAJ )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table Session", $result );

// *** TABLE CHECKID
echo "
     <p align='center'><font size='2'><br>
     CREATION DE LA TABLE CHECKID<br>
      </font></p>
     ";
$sql = "CREATE TABLE checkid
(
  transid      VARCHAR(32) NOT NULL default '',
  Usager	   	VARCHAR(16) default NULL,
  IP_Addr	   VARCHAR(12),
  Date_Cree	   INT NOT NULL default '0',
  PRIMARY KEY  ( transid )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table CHECKID", $result );

// *** TABLE DE LA SYSTÈME
echo "
     <p align='center'><font size='2'><br>
     CREATION DE LA TABLE SYSTÈME<br>
      </font></p>
     ";
$sql = "CREATE TABLE sysher
(
	Version			DECIMAL(5,2) DEFAULT '1.00' NOT NULL,
	NextNoAppel		INT(6)		UNSIGNED,
	NextNoFact		INT(6)		UNSIGNED,
	NextNoClient	INT(6)		UNSIGNED,
	NoTPS     		CHAR(11),
	TauxTPS   		DECIMAL(5,3),
	NoTVQ     		CHAR(15),
	TauxTVQ   		DECIMAL(5,3),
	NbLigneFct		TINYINT(3) UNSIGNED,
	Service1			CHAR(15),
	CodeP1		  	CHAR(4),
	Service2			CHAR(15),
	CodeP2			CHAR(4),
	Service3			CHAR(15),
	CodeP3			CHAR(4),
	NomCie			VARCHAR(50),
	RueCie			VARCHAR(50),
	VilleCie			VARCHAR(40),
	ProvinceCie		VARCHAR(20),
	PaysCie			VARCHAR(30),
	CPCie				CHAR(10),
	CourrielCie		VARCHAR(50),
	TélCie			VARCHAR(20),
	FaxCie			VARCHAR(20),
	CellCie			VARCHAR(20),
	ImpBon			VARCHAR(30),
	ImpRelev  		VARCHAR(30),
	NbrLignePage 	TINYINT(3) UNSIGNED,
	FrsMinLivreur	DECIMAL(6,2) DEFAULT '3.00';
	CliMaxCrédit	DECIMAL(6,2) DEFAULT '5.00';
	NbLigneRapCond TINYINT(3) UNSIGNED DEFAULT '53';
	NbLigneRapEtq	TINYINT(3) UNSIGNED DEFAULT '8';
	NoLivreurAIS	TINYINT(3) UNSIGNED DEFAULT '50';
		PRIMARY KEY(Version)
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table Système", $result );

// *** TABLE DE LA SECURITES
echo "
     <p align='center'><font size='2'><br>
     CREATION DE LA TABLE SECUR<br>
      </font></p>
     ";
$sql = "CREATE TABLE secur
(
	NomLogin	VARCHAR(20)	NOT NULL,
   mPasse	CHAR(255)	NOT NULL,
   Priorite	INT(2),
	Creation	DATE		NOT NULL,
   Langue	ENUM('ENGLISH','FRENCH','SPANISH','OTHER')  DEFAULT 'SPANISH' NOT NULL,
   NoClient	INT(6),
	Acces		ENUM('NON','OUI') DEFAULT 'NON' NOT NULL,
		PRIMARY KEY(NomLogin),
		KEY( NoClient )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table Secur", $result );

$Aujourdhui = date("Y-m-d");
$sql = "INSERT INTO secur
      ( NomLogin, mPasse, Priorite, Creation, Langue, NoClient, Acces ) VALUES
      ('oper', password('dwarf'), '0', '$Aujourdhui', 'FRENCH', '1', 'OUI')";

	  
if( !mysql_query($sql) ) {
   echo mysql_errno()." : ".mysql_error();
}

// *** TABLE DES LOGINS
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE LOGIN<br>
      </font></p>
     ";
$sql = "CREATE TABLE login (
	NoLog	   	INT(6)		UNSIGNED NOT NULL AUTO_INCREMENT,
	NomLogin 	VARCHAR(20)	NOT NULL,
   DateLogin	DATETIME 	NOT NULL,
	Operation	VARCHAR(100) NOT NULL
  		PRIMARY KEY( NoLog ), 
) AUTO_INCREMENT = 1 ";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table Login", $result );

// *** TABLE DES CLIENTS
echo "
     <p align='center'><font size='2'><br>
		CREATION DE LA TABLE CLIENT<br>
      </font></p>
     ";

$sql = "CREATE TABLE client
(
   NoClient		INT(6)		AUTO_INCREMENT,
	Nom			VARCHAR(50)	NOT NULL,
   Prenom		VARCHAR(40)	NOT NULL,
   Contact		VARCHAR(80),
   Rue			VARCHAR(50),
	Indication	VARCHAR(40),
	Quartier		VARCHAR(20),
   Ville			VARCHAR(40),
	Province		VARCHAR(20),
   Pays			VARCHAR(30),
   CodePostal	CHAR(10),
	Courriel		VARCHAR(50),
	Telephone	VARCHAR(20),
	Fax			VARCHAR(20),
	Cellulaire	VARCHAR(20),
	TypCli      ENUM('PROSPECT','CLIENT','DESTINATAIRE','LIVREUR'),
	Refere		INT(5),
	DateInscrip	DATE	  	NOT NULL,
	DateRappel  DATE,
	TotalEnvoi	DECIMAL(9,2),
	DernAchat	DATE,
	AchatAnnuel	DECIMAL(9,2),
	CoteCredit  ENUM('A','B','C','D','E') NOT NULL,
	Message		VARCHAR(50),
	Langue      ENUM('ENGLISH','FRENCH','SPANISH','OTHER')  DEFAULT 'SPANISH' NOT NULL,
	TPSApp		ENUM('NON','OUI') DEFAULT 'NON' NOT NULL,
	TVQApp		ENUM('NON','OUI') DEFAULT 'NON' NOT NULL,
	MaxCredit   DECIMAL(7,2),
	Solde			DECIMAL(7,2),
	DevCli		CHAR(4) DEFAULT 'USD' NOT NULL,
	Identite		VARCHAR(15),
	Debit			VARCHAR(15),
	NomLong     CHAR(1),
	Profession	VARCHAR(100) NOT NULL,
	Naissance 	DATE NOT NULL,
		
  		PRIMARY KEY( NoClient ), 
		KEY( Nom, Prenom ),
		KEY( CodePostal ),
		KEY( Telephone )
)
AUTO_INCREMENT = 1000 ";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table Client", $result );

// *** TABLE DES NOTES
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE NOTE<br>
      </font></p>
     ";

$sql = "CREATE TABLE notes
(
   	NoClient		INT(6),
		NotesOper	VARCHAR(255),
		NotesFact	VARCHAR(255),
		NotesAdm		VARCHAR(255),
		PRIMARY KEY( NoClient )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Notes", $result );

// *** TABLE DES IDENTITÉS
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE IDENTITÉS<br>
      </font></p>
     ";

$sql = "CREATE TABLE identité
(
   	NoClient		INT(6),
		TypeDoc		ENUM('CONDUCT','ASSMAL','ASSSOC','PASSPORT','ARMY','RESIDENT', 'NAISSAN'),
		Autre			VARCHAR(100),
		NoDoc			VARCHAR(255),
		Emetteur		VARCHAR(100),
		Expiration	DATE,
		PRIMARY KEY( NoClient )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des IDENTITÉS", $result );

// *** TABLE DES IDENTIFIANTS
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE IDENTIFIANT<br>
      </font></p>
     ";

$sql = "CREATE TABLE identifiant
(
		TypeDoc		ENUM('CONDUCT','ASSMAL','ASSSOC','PASSPORT','ARMY','RESIDENT', 'NAISSAN'),
		Langue      ENUM('ENGLISH','FRENCH','SPANISH','OTHER')  DEFAULT 'SPANISH' NOT NULL,
		Desc			VARCHAR(255),
		PRIMARY KEY( NoClient )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des IDENTIFIANT", $result );

// *** TABLE DES TARIFS CLIENT
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE TARIF CLIENT<br>
      </font></p>
     ";

$sql = "CREATE TABLE tarifclient
(
   NoClient	INT(6)		NOT NULL,
	Service	CHAR(15)		NOT NULL,
	CodeP		CHAR(4)		NOT NULL,
		PRIMARY KEY( NoClient, Service )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Tarifs Client", $result );

// *** TABLE DES Quartier
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE QUARTIER<br>
      </font></p>
     ";

$sql = "CREATE TABLE quartier
(
	Quartier	VARCHAR(25),
	Ville		VARCHAR(25),
	Province	VARCHAR(25),
	Pays		VARCHAR(25),
	Centre	CHAR(6),
		PRIMARY KEY( Quartier,Ville )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Quartiers", $result );

// *** TABLE DES CONTACTS
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE CONTACT<br>
      </font></p>
     ";

$sql = "CREATE TABLE contact
(
 	NoContact	INT(5)          AUTO_INCREMENT,
	Nom			VARCHAR(50) 	NOT NULL,
 	Prenom		VARCHAR(40) 	NOT NULL,
   Ville			VARCHAR(20),
   Pays			VARCHAR(40),
	Courriel		VARCHAR(50),
   Telephone	VARCHAR(20),
   Fax			VARCHAR(20),
   DateInscrip	DATE		NOT NULL,
		PRIMARY KEY( NoContact ),
  		KEY( Nom, Prenom ),
		KEY( Telephone )
)
AUTO_INCREMENT = 1000 ";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table Contact", $result );

// *** TABLE DES SERVICES
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE SERVICES<br>
      </font></p>
     ";

$sql = "CREATE TABLE services
(
	Service		CHAR(15)	NOT NULL,
	Description	VARCHAR(50) 	NOT NULL,
   PrixMin     DECIMAL(7,2),
   Type			CHAR(1),
   Def			CHAR(4),
   Unite			ENUM('ARGENT/CASH','POID/WEIGHT','UNITÉ/UNIT','OTHER')  DEFAULT 'ARGENT/CASH' NOT NULL,
		PRIMARY KEY( Service ),
  		KEY( Pays )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Services", $result );

// *** TABLE DES CODEPRIX
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE CODEPRIX<br>
      </font></p>
     ";

$sql = "CREATE TABLE codeprix
(
	Code	   	CHAR(4)	NOT NULL,
   QteMin		DECIMAL(10,2),
   QteMax    	DECIMAL(10,2),
	Type   		CHAR(10),
   Unite			ENUM('DOLARES','UNIDAD','LBS'),
	Form			CHAR(1),
   Pourcent   	DECIMAL(7,4),
	Fixe			DECIMAL(7,2),
	Cout			DECIMAL(7,2),
	Max			DECIMAL(7,2),
	Addit			DECIMAL(7,2),
		PRIMARY KEY( Code, QteMin, QteMax )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des CodePrix", $result );

	
// *** TABLE DES TAUX DE CHANGE
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE TAUX DE CHANGE<br>
      </font></p>
     ";

$sql = "CREATE TABLE monnaies
(
	Devise	   CHAR(4)	NOT NULL,
   TxVenteUS	DECIMAL(6,5),
	Transfert	ENUM('OUI','NON'),
	Paiement		ENUM('OUI','NON'),
   TxAchatUS  	DECIMAL(6,5),
	Symbole		CHAR(4),
	Commentaire VARCHAR(50),
    DateMAJ		DATE		NOT NULL,
		PRIMARY KEY( Devise )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des taux de change", $result );

	
// *** TABLE DES LETTRES
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE LETTRES<br>
      </font></p>
     ";

$sql = "CREATE TABLE lettre
(
	NoLettre		VARCHAR(20)   	NOT NULL,
	DateRecu    DATETIME NOT NULL,
	CommisRecu	VARCHAR(20)	NOT NULL,
	Contenu		VARCHAR(10) DEFAULT 'DIVERS' NOT NULL,
	NoCarte		VARCHAR(20),
	DateExp		VARCHAR(5),
   Montant		DECIMAL(10,2),
	PayCurrency	CHAR(4) DEFAULT 'USD' NOT NULL, 
	ENoClient	INT(6),
	DateTraite	DATETIME,
	CommisTraite	VARCHAR(20),
	NoEcrit       	DECIMAL(8,2),
	Depot			DATETIME,
		PRIMARY KEY( NoLettre ),
  		KEY( ENoClient )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Lettres", $result );
	
// *** TABLE DES DESTLET
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE DESTLET<br>
      </font></p>
     ";

$sql = "CREATE TABLE letdest
(
	NoLettre		VARCHAR(20)   	NOT NULL,
	DNoClient	INT(6),
	Commentaire VARCHAR(200),
   Transfert	DECIMAL(10,2),
	TrsCurrency	CHAR(4) DEFAULT 'USD' NOT NULL,
	Service		CHAR(15)	 NOT NULL,
	Transaction	INT(6)	UNSIGNED,
		PRIMARY KEY( NoLettre, DNoClient )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des DestLet", $result );
	
// *** TABLE DES TRANSACTIONS
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE TRANSACTIONS<br>
      </font></p>
     ";

$sql = "CREATE TABLE transaction
(
	NoTrans		INT(6)	UNSIGNED AUTO_INCREMENT,
	Service		CHAR(15)	 NOT NULL,
	Poids			DECIMAL(8,2),
   Transfert	DECIMAL(10,2),
	CurTrans		CHAR(4) DEFAULT 'CUC',
	Etat			ENUM('Reçu','Envoyé','Cuba','Livré','Fermé','Retenu','Annulé','Archivé'),
	NoLettre		VARCHAR(20),
	Commis		VARCHAR(20)	NOT NULL,
	ENoClient	INT(6)		NOT NULL,
	ENom			VARCHAR(50),
	EPrenom		VARCHAR(40),	#10
	ERue			VARCHAR(50),
   EQuartier	VARCHAR(20),
	EVille		VARCHAR(40),
	EProvince	VARCHAR(20),
   EPays			VARCHAR(30),
	ECP			VARCHAR(10),
	ETelephone	VARCHAR(20),
	EDetail		VARCHAR(200),
	DNoClient	INT(6),
	DNom			VARCHAR(50), 	#20
	DPrenom		VARCHAR(40),
	DContact		VARCHAR(80),
	Rue			VARCHAR(100),
   DQuartier	VARCHAR(20),
	DVille		VARCHAR(40),	#25
	DProvince	VARCHAR(20),
   DPays			VARCHAR(30),
	DCP			VARCHAR(10),
	DTelephone	VARCHAR(20),
	DDetail		VARCHAR(200), 	   #30
	DateRecu    DATETIME,
	DateRamasse	DATETIME,
	DateLivre	DATETIME,
	Signature	VARCHAR(50),
	Livreur		INT(6),
	Payable		ENUM('OUI','NON'),
	NoFacture	INT(6)	UNSIGNED,
	DateFacture DATE,
	FrTransant	DECIMAL(7,2),
	FrFixe		DECIMAL(7,2),	 #40
	Extra			DECIMAL(7,5),
	CoutUS		DECIMAL(7,2),
	DevPaye		CHAR(4) DEFAULT 'USD' NOT NULL,
	TauxChg		DECIMAL(7,3),
	ModePaye		VARCHAR(10),
	CoutLivreur DECIMAL(7,2),	#46
	Assurance	DECIMAL(7,2),
	Douane		DECIMAL(7,2),
	DateCuba		DATETIME,
		PRIMARY KEY( NoTrans ),
		KEY( NoLettre ),
  		KEY( ENoClient ),
		KEY( DNoClient ),
		KEY( Livreur )
)
AUTO_INCREMENT = 1000 ";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Transaction", $result );

// *** TABLE DES Livreur
echo "
     <p align='center'><font size='2'><br>
	CREATION DE LA TABLE LIVREUR<br>
      </font></p>
     ";

$sql = "CREATE TABLE livreur
(
		Province		VARCHAR(25) NOT NULL,
		NoLivreur	INT(6)		NOT NULL,
		Tarif1		DECIMAL(7,2),
		Max1			DECIMAL(7,2),
		Tarif2		DECIMAL(7,2),
		PRIMARY KEY( Province )
)";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible créer table des Livreurs", $result );
	
include("mcrptab.inc");

$sql = "CREATE TABLE `stock` 
(
  `id` int(11) NOT NULL auto_increment,
  `prix_detail` float default '0',
  `prix_promo` float default NULL,
  `Cout` decimal(5,2) default NULL,
  `Markup` decimal(4,2) default NULL,
  `Code` varchar(30) default NULL,
  `id_devise` int(11) NOT NULL default '0',
  `length` float NOT NULL default '1',
  `width` float NOT NULL default '1',
  `height` float NOT NULL default '1',
  `weight` float NOT NULL default '1', 						#10
  `online` char(1) NOT NULL default '1',
  `livrable` char(1) NOT NULL default '1',
  `Secteur_Limite` tinyint(1) default NULL,
  `Qte_Max_Livre` decimal(4,2) default NULL,
  `QteStock` decimal(4,2) NOT NULL default '0.00',
  `QteVendu` decimal(4,2) NOT NULL default '0.00',
  `QteCmd` decimal(4,2) NOT NULL default '0.00',
  `QteBO` decimal(4,2) NOT NULL default '0.00',
  `QteDOA` decimal(4,2) NOT NULL default '0.00',
  `Unite` enum('Unit','Poids','Pied','Metre') NOT NULL default 'Unit', #20
  `Provenance` varchar(30) NOT NULL default 'CUBA',
  `CodeTrans` char(2) NOT NULL default '1',
  `description_fr` text NOT NULL,	#23
  `description_en` text,
  `description_sp` text,
  `titre_fr` varchar(120) default NULL, 					#26
  `titre_en` varchar(120) default NULL,
  `titre_sp` varchar(120) default NULL,
  `description_supplementaire_fr` text,
  `description_supplementaire_en` text, 					#30
  `description_supplementaire_sp` text,
  `small` tinyint(4) NOT NULL default '1',
  `medium` tinyint(4) NOT NULL default '2',
  `big` tinyint(4) NOT NULL default '3',
  `DateAjout` date NOT NULL default '0000-00-00',
  `MAJ` int(11) default NULL,
  PRIMARY KEY  (`id`),
  KEY `titre_fr` (`titre_fr`),
  KEY `titre_sp` (`titre_sp`),
  KEY `titre_en` (`titre_en`),
  KEY `Code` (`Code`),
  KEY `prix_detail` (`prix_detail`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1718 ;";


?>

<div align='center'>
   <p style='margin-top: .5in'>
   <b>CREATION TERMINER AVEC SUCCÈS<br></b>
   <form action='Support.php' method='post'>
   	<input type='submit' value='Retour à la page précédente'>
   </form>
</div>
<br>
<div align="center"><font size="-1">
Nous apprécierions vos commentaires et suggestions. Vous pouvez les adresser
à <a href="mailto:<?php echo $AdrCourriel ?>?subject=Page Web Nomcie">Webmestre</a>
</font></div>
         <p align="center" valign="bottom"><font size="1"><br>
         <br>
         Les droits de reproduction de ce site © 2007 <?php echo $NomCie ?>.<br>
         Tous droits réservés. © 2007 <br>
         </p>
</body>
</html>

<?php
/* *** POP UP
echo "
<SCRIPT LANGUAGE='javascript'>
  function Bye() {
    			  alert('Valeur de date : $Date');
  }
  Bye();
  </SCRIPT>
";	
ALTER TABLE `sysher` ADD `FrsMinLivreur` DECIMAL( 6, 2 ) NULL DEFAULT '3',
ADD `CliMaxCrédit` DECIMAL( 6, 2 ) NULL DEFAULT '5',
ADD `NbLigneRapCond` TINYINT( 3 ) NULL DEFAULT '53',
ADD `NbLigneRapEtq` TINYINT( 3 ) NULL DEFAULT '8',
ADD `NoLivreurAIS` TINYINT( 3 ) NULL DEFAULT '50';

*/
?>