 <?php
      function Initialize($gauche,$haut,$largeur,$hauteur,$bord_col,$txt_col,$bg_col)
            {
    
      echo "<div id='progmaster' align='center'>";
        echo "<p align=\"center\"><font size=\"4\" color=#000080>VÉRIFICATION DE VOTRE NAVIGATEUR EN COURS</font><br></p>";

			 $tailletxt=$hauteur-10;
       echo '<div id="pourcentage" align="center" style="top:'.$haut;
     
      echo ';width:'.$largeur.'px';
      echo ';height:'.$hauteur.'px;border:1px solid '.$bord_col.';font-family:Tahoma;font-weight:bold';
      echo ';font-size:'.$tailletxt.'px;color:'.$txt_col.';z-index:1;text-align:center;">0%</div>';
    
      echo '<div id="progrbar" align="center" style="top:'.($haut+1); //+1
    //+1
      echo ';width:0px';
      echo ';height:'.$hauteur.'px';
      echo ';background-color:'.$bg_col.';z-index:0;"></div>';
      echo "</div>";
    
     }
     function ProgressBar($indice)
     {
    if ($indice==100)
      {
       echo "\n<script>";
       echo "document.getElementById('progmaster').style.display='none'";
       echo "</script>";
      }
           echo "\n<script>";
       echo "document.getElementById(\"pourcentage\").innerHTML='".$indice."%';";
       echo "document.getElementById('progrbar').style.width=".($indice*2).";\n";
       echo "</script>";
      flush(); // explication : http://www.manuelphp.com/php/function.flush.php
     }

 ?>


