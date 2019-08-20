 <?php
/* Programme : Produits_Form.inc
 * Description : Affichage de la page des clients. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de modifier un client.
 * Auteur : Denis Léveillé 	 		  Date : 2007-09-04
*/

//----------------------------------------------------------------------------------------------------------------
//  FUNCTION : get_subcats
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : Sélectionne les sous_catégories directes à la catégorie passée en paramètre

function get_subcats($upCat, $offline = 1){
    $categories = array();

    $select = 'SELECT catalogue_arborescence.id AS id,'.
                    ' catalogue_noms.'.$_SESSION['lang'].' AS nom'.
             ' FROM catalogue_arborescence'.
             ' LEFT JOIN catalogue_noms ON'.
                    ' catalogue_arborescence.nom = catalogue_noms.id'.
             ' WHERE up ='.$upCat;
             
    $select .=' ORDER BY priorite ASC, catalogue_noms.'.$_SESSION['lang'].
             ' ASC;';

    $sous_cats = mysql_query($select) or die("Erreur à get_subcats : ".mysql_error());
    while($r = mysql_fetch_assoc($sous_cats))
        $categories[$r['id']] = $r['nom'];

    return $categories;
}

// fin de la fonction : get_subcats ------------------------------------------------------------------------


//----------------------------------------------------------------------------------------------------------------
//  FUNCTION : list_cats
//  version : 1.0
//  date : 09-10-04
//  derniere modif : Maxime Dupuis
//  info : retourne le menu entier par rapport ý une sous-catÈgorie donnÈe

function list_cats($id=0, $lvl=0, $check=-1,$sous)
{
    $sousCats = get_subcats($id);
    echo '<br>\n';
    if(is_array($sousCats))
    {
        foreach($sousCats as $categorie => $nom)
        {
             echo '<option value="',$categorie,'"';
             if($check != -1 && $check == $categorie)
                 echo " selected>";
             else
                 echo '>';
             for($i=0;$i<$lvl;$i++)
               if($sous=='4')
               { 
               echo "&nbsp;&nbsp;&nbsp;";
               }
             echo '- ',$nom,'</option>';
             list_cats($categorie, ($lvl+1), $check,4);
        }
      
    }
}

// fin de la fonction : list_cats ------------------------------------------------------------------------


 
?>
<html>
<head>
<?php 
 if( isset($EN_AJOUT) ) echo $TabId[1];
 if( isset($EN_RECHERCHE) ) echo $TabId[2];
 if( isset($EN_CONSULTE) ) echo $TabId[3]; 
?>

<LINK title=HERMESStyle href="stylegen.css" type=text/css rel=STYLESHEET>
</head>
<SCRIPT language=JavaScript1.2 src="javafich/mm_menu.js"></SCRIPT>
<SCRIPT language=JavaScript1.2 src="javafich/disablekeys.js"></SCRIPT>
<?php
 switch( $_SESSION['SLangue'] ) {
 	case "ENGLISH" : echo
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenuen.js'></SCRIPT>";
		 		 	 break;
	case "SPANISH" : echo  
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenusp.js'></SCRIPT>";
		 	  		 break;
		 default : 	 echo  
		 	  	    "<SCRIPT language=JavaScript1.2 src='javafich/ldmenufr.js'></SCRIPT>";

 }
?>

<body bgcolor="#8DFFA0" topmargin="0" leftmargin="0" marginheight="0" marginwidth="0" onload="javascript:pageonload()">
<SCRIPT language=JavaScript1.2>mmLoadMenus();</SCRIPT>

<?php
  if( isset($EN_AJOUT) ) echo "<form name=ProduitsForm action='produits_ajout.php?do=new' method='post'>";
  if( isset($EN_RECHERCHE) ) echo "<form name=ProduitsForm action='produits_recherche.php?do=rech' method='post'>"; 
  if( isset($EN_CONSULTE) ) echo "<form name=ProduitsForm action=produits_consulte.php?do=consulte&NoProd=$NoClient' method='post'>";
?>

<table cellpadding=0 width=100% border=0 align=center>
	<tr>
		<td width=15% align=center>&nbsp;
		</td>
		<td width=60% align=center>

<table cellpadding=6 width=100% align=center border=0>
	<tr>
		<td nowrap valign=top  width=100% align=left>
			<br><br>

			</td>
		</tr>
		<tr>
			<td nowrap align=top  width=100% align=left>
			<br>
			<table cellpadding=4 width=100% align=center>
             <tr>
                 <td nowrap align=top  width=100% align=left colspan=2>
                     <b>1. Identification</b>
                     <br>
                 </td>
             </tr>
				<tr align=left >
					<td nowrap valign=top>
						ID :&nbsp;
						<input type="text" name="id" class=form1 value="<?php echo $id;?>">
					</td>
				</tr>


				<tr>
					<td nowrap align=top  width=100% align=left colspan=2>
						<b>2. Entrez les informations du produit</b>
						<br><br>
					</td>
				</tr>
				<tr align=left >
					<td nowrap valign=top>
						Titre français :&nbsp;
						<input type="text" name="titre1_fr" class=form1 value="<?php echo $titre1_fr;?>">
					</td>
				</tr>
				<tr align=left > 
					<td nowrap valign=top>
						Title english :&nbsp;
						<input type="text" name="titre1_en" class=form1 value="<?php echo $titre1_en;?>">
					</td>
				</tr>
				<tr align=left >
					<td nowrap valign=top>
						Titulo spanish :&nbsp;
						<input type="text" name="titre1_sp" class=form1 value="<?php echo $titre1_sp;?>">
					</td>
				</tr>

				<tr>
					<td nowrap align=top  width=100% align=left colspan=2>
						<br><br>
						<b>3. Gestion prix du produit</b>
						<br><br>
					</td>
				</tr>
				<tr align=left >
					<td nowrap valign=top colspan=2>
						Prix de détail du produit :&nbsp;
						<input type="text" name="prix_detail" class=myselect4 value="<?php echo $prix_detail;?>" >
					</td>
				</tr>

				<tr align=left >
					<td nowrap valign=top colspan=2>
						Prix de promotion du produit (en devise : <?php echo $id_devise; ?>) :&nbsp;
						<input type="text" name="id_devise" class=myselect4 value="<?php echo $prix_promo;?>">
					</td>
				</tr>

				<tr align=left >
					<td nowrap valign=top colspan=2>
						Poid du produit) :&nbsp;
						<input type="text" name="weight" class=myselect4 value="<?php echo $weight;?>">
					</td>
				</tr>

				<tr align=left >
					<td nowrap valign=top colspan=2>
						Largeur du produit :&nbsp;
						<input type="text" name="width" class=myselect4 value="<?php echo $width;?>">
					</td>
				</tr>	

				<tr align=left >
					<td nowrap valign=top colspan=2>
						Hauteur du produit :&nbsp;
						<input type="text" name="height" class=myselect4 value="<?php echo $height;?>">
					</td>
				</tr>	
				<tr>
					<td nowrap align=top  width=100% align=left colspan=2>
						<br><br>
						<b>4. Description du produit</b>
						<br><br>
					</td>
				</tr>
														
				<tr>
					<td nowrap valign=top align=left colspan=2>
						Description du produit francais
						<br>
						<textarea name="description1_fr" cols=55 rows=4><?php echo $description1_fr;?></textarea>
						</textarea>
					</td>
				</tr>
				<tr>
					<td nowrap valign=top align=left colspan=2>
						Description du produit en anglais
						<br>
						<textarea name="description1_en" cols=55 rows=4><?php echo $description1_en;?></textarea>
					</td>
				</tr>
				<tr>
					<td nowrap valign=top align=left colspan=2>
						Description du produit en espagnol
						<br>
						<textarea name="description1_sp" cols=55 rows=4><?php echo $description1_sp;?></textarea>
					</td>
				</tr>

				<tr>
					<td nowrap valign=top align=left colspan=2>
                  Description additionnelle du produit francais
						<br>
						<textarea name="description_supplementaire_fr" cols=55 rows=4><?php echo $description_supplementaire_fr;?></textarea>
					</td>
				</tr>
				<tr>
					<td nowrap valign=top align=left colspan=2>
						Description additionnelle du produit english
						<br>
						<textarea name="description_supplementaire_en" cols=55 rows=4><?php echo $description_supplementaire_en;?></textarea>
					</td>
				</tr>
				<tr>
					<td nowrap valign=top align=left colspan=2>
						Description additionnelle du produit spanish
						<br>
						<textarea name="description_supplementaire_sp" cols=55 rows=4><?php echo $description_supplementaire_sp;?></textarea>
					</td>
				</tr>
				
             <tr>
                 <td nowrap align=top  width=100% align=left colspan=2>
                     <b>5. Ajouter une image à votre produit (optionel)</b>
                     <br><br>
                 </td>
             </tr>
             <tr>
                 <td nowrap valign=top align=left colspan=2>
                 	Petite&nbsp;:&nbsp;<input type="file" name="fichier1" class=form1><br>
                  Moyenne&nbsp;:&nbsp;<input type="file" name="fichier2" class=form1><br>
                  Grande&nbsp;&nbsp;:&nbsp;<input type="file" name="fichier3" class=form1><br>
                 </td>
             </tr>

				
												
  <tr>
       <td colspan="2" align="center">
          <?php
				if( isset($EN_AJOUT) ) echo "<input type='submit' name='Commande' value='$TabId[39]'>&nbsp;"; // Ajouter
				if( isset($EN_RECHERCHE) ) {
					echo "<input type='submit' name='Commande' value='$TabId[40]'>&nbsp;"; // Rechercher
					echo "<input type='button' name='Commande' value='Reset' onClick='ResetClient()'>&nbsp;"; // Reset
				} // EN RECHERCHE
				if( isset($EN_CONSULTE) ) {
					if( @$_SESSION['Prio'] <= $PrioModif ) 
						echo "<input type='submit' name='Commande' value='$TabId[41]'>&nbsp;"; // Modifier
					echo "<input type='button' name='Commande' value='$TabId[46]' onClick='ImprimePage()'>&nbsp;";
					if( @$_SESSION['Prio'] < $PrioAnnule )  
						echo "<br>&nbsp;&nbsp;<input type='button' name='Commande' value='$TabId[48]' onClick='ConfirmeDet()'>"; // Detruire
				} // En CONSULTE
         ?>
       </td>
   </tr>
   <tr>
       <td colspan="2" bgcolor="#26FE5E" align="center">
          <font color="white" size="+1">
          <?php 
		    if( isset($EN_AJOUT) ) echo "<b>$TabId[49]</b>"; 
            if( isset($EN_RECHERCHE) ) echo "<b>$TabId[50]</b>"; 
            if( isset($EN_CONSULTE) ) echo "<b>$TabId[51]</b>"; 
		  ?> 
          </font>
       </td>
   </tr>
			</table>
			
			<br><br>

		</td>
	</tr>
</table>

		</td>
		<td width=15% align=center>
		</td>
	</tr>
</table>
</form>

<SCRIPT LANGUAGE="javascript">

function ResetClient() {
      document.ClientForm.Nom.value = "";
      document.ClientForm.Prenom.value = "";
      document.ClientForm.Contact.value = "";
      document.ClientForm.Rue.value = "";
	  document.ClientForm.Quartier.value = "";
      document.ClientForm.Ville.value = "";
      document.ClientForm.Province.value = "";
      document.ClientForm.Pays.value = "";
      document.ClientForm.CodePostal.value = "";
      document.ClientForm.Identite.value = "";
      document.ClientForm.Indication.value = "";
      document.ClientForm.CodePostal.value = "";
      document.ClientForm.TelCodR.value = "";
      document.ClientForm.TelP1.value = "";
      document.ClientForm.TelP2.value = "";
      document.ClientForm.Fax.value = "";
      document.ClientForm.Cellulaire.value = "";
	  document.ClientForm.NoClient.focus();
} // ResetClient


//Convert the username to uppercase.
function capitalize() {
		document.ClientForm.Nom.value = document.ClientForm.Nom.value.toUpperCase();
		document.ClientForm.Prenom.value = document.ClientForm.Prenom.value.toUpperCase();
		document.ClientForm.Contact.value = document.ClientForm.Contact.value.toUpperCase();
		document.ClientForm.Rue.value = document.ClientForm.Rue.value.toUpperCase();
		document.ClientForm.Quartier.value = document.ClientForm.Quartier.value.toUpperCase()
		document.ClientForm.CodePostal.value = document.ClientForm.CodePostal.value.toUpperCase();
		document.ClientForm.Ville.value = document.ClientForm.Ville.value.toUpperCase();
		document.ClientForm.Province.value = document.ClientForm.Province.value.toUpperCase();
		document.ClientForm.Pays.value = document.ClientForm.Pays.value.toUpperCase();
		document.ClientForm.Profession.value = document.ClientForm.Profession .value.toUpperCase();
} // capitalize

function ConfirmeDet() {
<?php 
	  if( @$_SESSION['Prio'] < $PrioAnnule ) {
	  	echo "  
		  if( window.confirm('$TabMessGen[7]') ){
		  	  open(\"clientconsulte.php?do=detruit&NoCli=$NoClient\",\"_self\" );
		  }
		";
	  }
	  else {
	    echo "
			 window.alert(\"$TabMessGen[6]\");
		";
	  };
?>
	  return;
} // ConfirmeDet

function ImprimePage() {
	window.print();
} // ImprimePage

function pageonload() {
      document.ClientForm.NoClient.focus();
	<?php
 		 if( isset($EN_AJOUT) ) 
		   echo "window.status = '$TabId[70]';";
 		 if( isset($EN_RECHERCHE) ) 
		   echo "window.status = '$TabId[71]';";
          if( isset($NewMessage) ) {
	    	echo "window.alert(\"$NewMessage\");";
          	unset( $NewMessage );
          };
   ?>
	 return;
} // pageonload



 addKeyEvent();

</SCRIPT>
<SCRIPT language=JavaScript1.2 src="javafich/blokclick.js"></SCRIPT>

</body>
</html>
