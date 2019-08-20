<?php
?>
<div id="siteInfo"> 
<table border='0'>
	<tr>
	<td>
		<img src="gifs/icon_technet.gif" width="44" height="22" />
	</td>
	<td>
		<a href="index.php"><?=$txt['ChxMenuAccueil']?></a>
	</td>
	<td>
	|
	</td>
	<!-- td>
		<a href="#">Qui sommes-nous</a>
	</td>
	<td width='2%' align="right" >
		 |
	</td -->
	<td>
		<a href="produits.php"><?=$txt['ChxMenuProduits']?></a>
	</td>
	<td>
	|
	</td>
	<td>
		<a href="services.php"><?=$txt['ChxMenuServices']?></a>
	</td>
	<td>
	|
	</td>
	<td>
		<a href="#"><?=$txt['ChxMenuSupport']?></a>
	</td>
	<td>
	|
	</td>
	<td>
		<a href="contact.php"><?=$txt['ChxMenuContactez']?></a>
	</td>
	<td>
	|
	</td>
	<td>
		<a href="plan.php"><?=$txt['ChxMenuPlan']?></a>
	</td>
	<td>
	|
	</td>
	<td>
		<a href="confidentialite.php"><?=$txt['ChxMenuConfidentialite']?></a>
	</td>
	<td>
		<b>&copy; <?=$param['CopyAn'];?>  <?=$param['nom_client'];?></b>
	</td>
	<td colspan='2' align="right" >
		<?=$TabMessGen[62]?> : <img src="compteur/compteur.php"/>
		<!-- ?=include('./compteur/compteur.php')? -->
	</td>
	</tr>
	<tr>
		<td colspan='18' align="center" valign="top" class="textSmallCenter">
			* Les prix sont sujet à changement sans préavis. Nous ne pouvons garantir la disponibilité des produits.
		</td>
		<!-- td colspan='8' valign="bottom">
			<p class="textSmallRight">Conception Denis Léveillé <b>&copy; <?=$param['CopyAn'];?>  <?=$param['nom_client'];?></b></p>
		</td -->
	</tr>
</table>
</div>
<br />