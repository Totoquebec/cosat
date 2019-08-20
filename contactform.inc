<?php
	/* Programme : login_form.inc
    * Description : Affichage de la page de login. Celle-ci présente deux
    *					  formulaire : le premier pour saisir un nom de login
    *					  existant et le mot de passe associé ; la seconde pour
    *					  saisir les informations permettant de s'enregistrer
    *					  en tant que nouveau client.
    */
 $Option = get_enums("contact", "TypeMess");


?>
<table border="0" cellspacing="5" cellpadding="0" width="100%" height="100%" >
  <tr>
	<td bgcolor="#2f3283" align="center">
		<!-- Encadré //-->
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_page_b">
		      	  <?=@$txt['Contactez_nous'];?>
		        </td>
		  </tr>
		</table>
      	  
        </td>
  </tr>
  <tr>
      <td>
      <p align="center"><font size="+2"><b><?=@$txt['Par_la_poste'];?></b></font><br><br>
	  <font size="+1">
		<?=@$param['nom_client'];?><br>
		<?=@$param['adresse_client'];?><br><?=@$param['ville_client'];?> 
		<?=@$param['province_client'];?>, <?=@$param['pays_client'];?><br>
		<?=@$param['codepostal_client'];?><br><br>
	  </font>
	  </td>
  </tr>
  <tr  height="3" ><td bgcolor="#2f3283">&nbsp;</td></tr>
  <tr>
      <td>
      <p align="center"><font size="+2"><b><?=@$txt['Par_courriel'];?></b></font><br><br>
	  <font size="+1">
		<?=@$txt['form_courriel'];?> : <a href="mailto:<?php echo hexentities($param['courriel_client']) ?>?subject=Page Web <?php echo $param['nom_client'] ?>">
		<?php echo hexentities($param['courriel_client']) ?></a>
	  </font>
	  </td>
  </tr>
  <tr height="3"><td bgcolor="#2f3283">&nbsp;</td></tr>
  <tr>
      <td>

      <!-- pour l'enregistrement des commentaires -->
      <form name=ContactForm action="contact.php?do=new" method="post">
      	<p>
<?php
	if( isset($NewMessage) ) {
		echo "<font size='+1' color='#FF0000'>$NewMessage</font>";
	}
?>
         <div align="center">
         <table border="1" cellspacing="5" cellpadding="0">
           	<tr>
         	<td align='right' colspan="2"><b><?=@$txt['form_nom'];?></b></td>
            <td colspan="2"><input type="text" name="Nom" size="30" value="<?=@$Nom ?>" onchange='capitalize();' maxlength="50"/><font color=red><b>*</b></font>
             &nbsp;&nbsp;&nbsp;<b><?=@$txt['form_prenom']; ?>&nbsp;</b>
             <input type="text" name="Prenom" size="25" value="<?=@$Prenom ?>" onchange='capitalize();' maxlength="40"/><font color=red><b>*</b></font></td>
            </tr>
			<tr>
         	<td align='right' colspan="2"><b><?=@$txt['form_rue'];?></b></td>
            <td colspan='2' align='left'>
					<input type="text" name="Adresse" size="30" value="<?=@$Adresse ?>" onchange='capitalize();' maxlength="40">
            	 &nbsp;&nbsp;&nbsp;<b><?=@$txt['form_ville']; ?>&nbsp;</b>
                <input type="text" name="Ville" size="30" value="<?=@$Ville ?>" onchange='capitalize();' maxlength="30"/></td>
           	</tr>
			<tr>
         	<td align='right' colspan="2"><b><?=@$txt['form_province'];?></b></td>
            <td colspan='2' align='left'>
				 	<input type="text" name="Province" size="30" value="<?=@$Province ?>" onchange='capitalize();' maxlength="30"></td>
			</tr>
			<tr>
         	<td align='right' colspan="2"><b><?=@$txt['form_pays'];?></b></td>
            <td colspan='2' align='left'>
					<input type="text" name="Pays" size="30" value="<?=@$Pays ?>" onchange='capitalize();' maxlength="20">
            	 &nbsp;&nbsp;&nbsp;<b>Code Postal/Zip&nbsp;</b>
                <input type="text" name="CodePostal" size="10" value="<?=@$CodePostal ?>" maxlength="10"/></td>
			</tr>
			<tr>
         	<td align='right' colspan="2"><b><?=@$txt['form_courriel'];?></b></td>
            <td colspan='2' align='left'>
					<input type="text" name="Courriel" size="30" value="<?=@$Courriel ?>" maxlength="67"/><font color='red'><b>*</b></font></td>
			</tr>
			<tr>
         	<td align='right' colspan="2"><b><?=@$txt['form_telephone'];?></b></td>
      		<td colspan='2' align='left'>
					(<input type="text" name="TelCodR" size="3" value="<?=@$TelCodR ?>" maxlength="3"/>)
 		  		 <input type="text" name="TelP1" size="3" value="<?=@$TelP1 ?>" maxlength="3"/>
				 -		
		  		 <input type="text" name="TelP2" size="4" value="<?=@$TelP2 ?>" maxlength="4"/>
		  		 &nbsp;&nbsp;&nbsp;
				 <b><?=@$txt['form_telecopieur'];?>&nbsp;</b>
                <input type="text" name="Fax" size="15" value="<?=@$Fax ?>" maxlength="20"/></td>
			</tr>
			<tr>
				 <td colspan='4'>&nbsp;</td>
			</tr>
			<tr>
			<td align='center' colspan="4"><b><?=@$txt['Msg_raison'];?></b>
			       <select name="TypeMess" size="1">
					  <?php
       				  	   if( isset($EN_RECHERCHE) || isset($EN_AJOUT) ) 
           				   	   echo "<option value='' SELECTED >";
  						   for($i=0;$i<sizeof($Option);$i++) {
    					   	 echo "<option value='".$Option[$i]."' ";
    					   	 if( $TypeMess == $Option[$i] ) echo " SELECTED";
    					   	 echo " >".$Option[$i];
  						   }  
					   ?>
          			</select>
		  		 </td>
				 
           	</tr>
			<tr>
         	<td align="center" colspan="4" height="23">
            <?=@$txt['Msg_sujet'];?> : <input type="text" name="Sujet" value="<?=@$Sujet ?>" size="20"/></td>
           	</tr>
			<tr>
         	<td align="center" colspan="4" height="23">
            <?=$txt['Votre_message'];?> :<br/><textarea rows="10" name="Commentaire" value="<?=@$Commentaire ?>" cols="65"></textarea><br/>
			<p align="center"><font size="-1"><font color='red'><b>*</b></font><i> <?=$txt['Tous_champs_oblig']?></i></font></p></td>
           	</tr>
			<tr>
				<td align="center" colspan='4'>
				<input type="hidden" name="Langue" value="<?=@$Langue ?>"/>
				<input type="hidden" name="DateInscrip" value="<?=@$DateInscrip ?>"/>
            <input type="submit" name="GoContact"  value="<?=$txt['form_soumettre']?> !"/></td>
			</tr>
         </table>
      	</div>
      </td>
   </tr>
   <tr><td bgcolor="#2f3283">&nbsp;</td></tr>
</table>
<script language='JavaScript1.2'>


//Convert the username to uppercase.
function capitalize() {
	document.ContactForm.Nom.value = document.ContactForm.Nom.value.toUpperCase();
	document.ContactForm.Prenom.value = document.ContactForm.Prenom.value.toUpperCase();
	document.ContactForm.Adresse.value = document.ContactForm.Adresse.value.toUpperCase();
	document.ContactForm.CodePostal.value = document.ContactForm.CodePostal.value.toUpperCase();
	document.ContactForm.Ville.value = document.ContactForm.Ville.value.toUpperCase();
	document.ContactForm.Province.value = document.ContactForm.Province.value.toUpperCase();
	document.ContactForm.Pays.value = document.ContactForm.Pays.value.toUpperCase();
	document.ContactForm.Courriel.value = document.ContactForm.Courriel.value.toLowerCase();
}

// *********************************************************************
// *****  PROCEDURE MISE EN MARCHE A L'OUVERTURE ***********************
// *********************************************************************
function pageonload() {
	document.ContactForm.Nom.focus();
	<?php
          if( isset($NewMessage) ) {
	    	echo "
				window.alert(\"$NewMessage\"); 
			";
          	unset( $NewMessage );
          };
     ?>
	 return;
}


</script>
