<?php

?>

	<table bgcolor='#FFFFFF' width='100%' cellpadding='0' cellspacing='0' align='<?=$Enligne?>' border='0' >
		<tr>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td>
	<table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
          <!-- tr>
            <td>
		
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_page_b">
		      	  <?=@$txt['Le_Support'];?>
		        </td>
		  </tr>
		</table>
            </td>
         </tr>
         <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
          <tr>
            <td>
		
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_titre_b">
		      	  <?=@$txt['Les_Pilotes'];?>
		        </td>
		  </tr>
		</table>
            </td>
         </tr>
         <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
          <tr>
            <td>
		
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_titre_b">
		      	  <?=@$txt['Les_Outils'];?>
		        </td>
		  </tr>
 		</table>
           </td>
         <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
         <tr>
            <td>
	    	<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
			<tr class='s_lien'>
				<td  class='s_lien' width='72%' height='49'>
					<a  href='toolbar/index.php' >Barre Outils Cosat</a>
				</td>
	                </tr>	    	
		</table>

	     </td>
          </tr>
         </tr -->
         <tr>
            <td><img src="gifs/pixel_trans.gif" border="0" alt="" width="100%" height="2"></td>
          </tr>
          <tr>
            <td>
		<!-- Encadré //-->
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_titre_b">
		      	  <?=@$txt['Les_Liens'];?>
		        </td>
		  </tr>
		</table>
<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="4" class="infoBoxContents">
<?php
$sql = "SELECT * FROM $database.pgliens WHERE  Type != 'Site' AND Langue='".$_SESSION['langue']."'";

$result = $mabd->query($sql);

if( $result &&  $result->num_rows  ) {
                for( $i=0; $i < $result->num_rows; $i++ ) {
                   $row = $result->fetch_row();
                   if( strlen($row[2]) || strlen($row[3]) ) {  
                     echo "<tr class='s_lien'>";
					 echo "<td  class='s_lien' width='72%' height='49'>
						<a  href='support.php' onClick='start_up(\"$row[3]\",\"$row[4]\",\"$row[5]\"); return true' >".$row[2]."</a>
						</td>";
                     echo "</tr>";
				   } // Si quelque chose sur la ligne
                } // for i < nombre de rangé
}
?>

			</table>
		</td>
	</tr>
</table>
<!-- encadré_eof //-->
				</td>
          </tr>          
          <tr>
            <td>
		<!-- Encadré //-->
		<table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td class="s_titre_b">
		      	  Nos réalisations
		        </td>
		  </tr>
		</table>
<table border="0" width="100%" cellspacing="0" cellpadding="1" class="infoBox">
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="4" class="infoBoxContents">
<?php
$sql = "SELECT * FROM $database.pgliens WHERE  Type = 'Site' AND Langue='".$_SESSION['langue']."'";

$result = $mabd->query($sql);

if( $result &&  $result->num_rows  ) {
                for( $i=0; $i < $result->num_rows; $i++ ) {
                   $row = $result->fetch_row();
		  // var_dump($row);
                   if( strlen($row[2]) || strlen($row[3]) ) {  
                     echo "<tr class='s_lien'>";
					 echo "<td  class='s_lien' width='72%' height='49'>
						<a  href='support.php' onClick='start_up(\"$row[3]\",\"$row[4]\",\"$row[5]\"); return true' >".$row[2]."</a>
						</td>";
                     echo "</tr>";
				   } // Si quelque chose sur la ligne
                } // for i < nombre de rangé
}
?>

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
		</tr>
	</table>
