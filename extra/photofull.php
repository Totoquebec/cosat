<?php
    /* Programme : PhotoPut.php
    * Description : Ajout d'une image rattaché à une oeuvre
    */

include('connect.inc');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("varcie.inc");
  echo "
      <html>
      <head>
      <title>Page d'erreur Chargement Image</title>
      </head>
     <body bgcolor='#C0C0FF'>
	 <FORM METHOD=post ACTION='photoput.php' ENCTYPE='multipart/form-data'>
      <h2 align='center' style='margin-top: .7in'>
      Erreur: $NoErr - $Erreur</h2>
      <div align='center'>
      <p style='margin-top: .5in'>
      <b>Message : $Message </b><br>
	  <INPUT TYPE='button' value='Quitter' onClick='QuitterPage()'>
      </div>
      <p align='center' valign='bottom'><font size='1'><br>
      <br>
      Les droits de reproduction de ce site © $CopyAn $NomCie.<br>
      Tous droits réservés. © $CopyAn<br>
      </font></p>
	  </FORM>
	  <SCRIPT LANGUAGE='javascript'>
		 
         function QuitterPage() {
                 close();
         } // Quitter 
      var message=' Désolé ! Cette fonction est désactivée. ';
	  
      function clickIE()
      {
       if (document.all) 
           return false;
      }

      function clickNS(e) 
	  {
       if( document.layers || ( document.getElementById && !document.all ) ) {
               if( e.which == 2 || e.which==3 ) 
                       return false;
       }
      } // clickNS

      if (document.layers){
         	   document.captureEvents(Event.MOUSEDOWN);
               document.onmousedown=clickNS;
      }
      else{
               document.onmouseup=clickNS;
               document.oncontextmenu=clickIE;
      }
	  
      document.oncontextmenu=new Function('alert(message);return false')

      function disableselect(e)
	  {
       return false
      } // disableselect

      function reEnable()
      {
       return true
       } // reEnable

       document.onselectstart=new Function ('return false')

       if (window.sidebar){
              document.onmousedown=disableselect
              document.onclick=reEnable
       }
		 
	 </SCRIPT>
      </body>
      </html>
  \n";
   exit();
}



  $sql = " SELECT * FROM $mysql_base.photo
	   	 WHERE NoInvent='".$_GET['No']."' AND NoPhoto='".$_GET['Idx']."'";
 
  $result = mysql_query( $sql, $handle );
  
  if( $result == 0 ) { 
  	   MetMessErreur(mysql_error(),"Accès Photo impossible", mysql_errno());
  } elseif (  mysql_num_rows($result) != 0 ) {
	   	  $ligne = mysql_fetch_array($result,MYSQL_ASSOC);
   		  extract($ligne);
		  // Déactivé le barre d'outils Image de IE 6 
		  echo "
			<HTML>
			<head>
		  	    <meta http-equiv='imagetoolbar' content='no' />
				<title>Affichage d'une photo</title>
			</head>
			<BODY topmargin='10' leftmargin='10' marginheight='0' marginwidth='0'>";
//	    echo "<img src='photoaffiche.php?No=$NoInvent&Idx=$NoPhoto' width=$Largeur height=$Hauteur>\n";
	    echo "<img src='photoget.php?No=$NoInvent&Idx=$NoPhoto' width=$Largeur height=$Hauteur>\n";
   } // Si resultat contient des rangées
   else {
		  echo "
			<HTML>
			<head>
				<title>Affichage d'une photo</title>
			</head>
			<BODY bgcolor='#C0C0FF' topmargin='5' leftmargin='0' marginheight='0' marginwidth='0'>
				<p align='center'> <font size='+1'><b>Aucune Photo</b></font></p>";
   }
   echo " 
        <form action='login.php' method='post'>
           <input type='button' name='Quitter' value='Fermer la fenêtre' onClick='QuitterPage()'>
        </form>";

echo "
<SCRIPT LANGUAGE='javascript'>
		 
         function QuitterPage() {
                 close();
         } // Quitter
		  

		 
</SCRIPT>
</BODY>
</HTML>";
?>
 