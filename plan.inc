<?php
	// Portion BODY
?>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
          <tr>
            <td>
		<!-- Encadré //-->
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_plan_b">
		      	  <?=@$txt['Plan_du_site'];?>
		        </td>
		  </tr>
		</table>
<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="4" class="infoBoxContents">
				<tr class="s_plan">
					<td class="s_plan">
<?php
	// affichage des Noeuds
	foreach($aryNoeudsSujets as $arySujet){
		// appel de la fonction récursive qui va afficher tous les sous noeud
		affiche_sous_noeud( $arynoeudFils,$arySujet['id'] );
	}
?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<!-- encadré_eof //-->
				</td>
          </tr>
          <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="10"></td>
          </tr>
        </table>
		  </td>
      </tr>
    </table>
</td>
<!-- body_text_eof //-->