<?php
/* Programme : ClienteleForm.inc
 * Description : Affichage de la page des type de clientele. Celui-ci présente un
 *  		 formulaire pour saisir les informations permettant d'ajouter
 *  		 de rechercher ou de le modifier.
 */
  //include("gettypebio.inc"); AND No=".$_GET['choix']
?>

<html>
<head>
<?php 
 if( isset($EN_AJOUT) ) echo "<title>Ajout d'un Message</title>";
 if( isset($EN_RECHERCHE) ) echo "<title>Recherche d'un Message</title>";
 if( isset($EN_CONSULTE) ) echo "<title>Consultation d'un Message</title>"; 
?>

	<link title='StyleGen' href="styles/stylegen.css" type='text/css' rel='stylesheet'/>
	<script language='javascript1.2' src='js/mm_menu.js'></script>
	<script language='JavaScript1.2' src='js/loadmenuhori.js'></script>
<!-- TinyMCE -->
<script type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",

		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		// theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "styles/word.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "<?php echo $_SESSION['NomLogin'];?>",
			staffid : "991234"
		}
	});
</script>
<!-- /TinyMCE -->
</head>

<body onload="javascript:pageonload()">
<script language='JavaScript1.2'>mmLoadMenus();</script>

<?php 
  if( isset($EN_AJOUT) ) echo "<form name='TextForm' action='txtajout.php?do=new' method='post'>";
  if( isset($EN_RECHERCHE) ) echo "<form name='TextForm' action='clirecherche.php?do=rech' method='post'>"; 
  if( isset($EN_CONSULTE) ) echo "<form name='TextForm' action='textmodif.php?do=consulte&nomcol=".mysql_field_name($result,$_GET['choix'])."' method='post'>";
?>

<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td colspan='2' align='center'>&nbsp;</td>
   </tr>
   <tr>
      <td colspan='2' align='center'><b><font size='+2'><?=mysql_field_name($result,$_GET['choix'])?></font></b></td>
   </tr>
   <tr>
       <td >&nbsp;</td>
      <td align='right'>
 	<textarea id="elm1" name="LeTexte" rows="20" cols="80" style="padding: 20px width: 80%">
		<?php echo $row[$_GET["choix"]] ?>
	</textarea>
      </td>
   </tr>
   <tr>
       <td colspan="2" align="center">
       	  <input type="submit" name="Commande"
          <?php
           if( isset($EN_AJOUT) ) echo "value='Ajouter'>&nbsp;"; 
           if( isset($EN_RECHERCHE) ) echo "value='Rechercher'>&nbsp;"; 
           if( isset($EN_CONSULTE) ) {
   	   		 echo "value='Modifier'>&nbsp;";
   	   		 echo "<input type='button' name='Commande' value='Imprime' onClick='ImprimePage()'>&nbsp;";
           }
   	       echo"<input type='button' name='Quitter' value='Quitter' onClick='QuitterPage()\n'>";

         ?>
      </td>
   </tr>
   <tr>
       <td colspan="2" bgcolor="#C0C0C0" align="center">
          <font color="white" size="+1">
          <?php 
		    if( isset($EN_AJOUT) ) echo "<b>AJOUT D'UN MESSAGE</b>"; 
            if( isset($EN_RECHERCHE) ) echo "<b>RECHERCHE D'UN MESSAGE</b>"; 
            if( isset($EN_CONSULTE) ) echo "<b>CONSULTATION D'UN MESSAGE</b>"; 
		  ?> 
          </font>
       </td>
   </tr>
</table>
</form>

<script language='javascript1.2'>
//Convert the username to uppercase.
// *********************************************************************
// ***** FONCTION JAVA DE LA PAGE  *************************************
// *********************************************************************

function QuitterPage() {
	open('mainfr.php','_self');
} // QuitterPage

function ImprimePage() {
	window.print();
} // ImprimePage

// *********************************************************************
// *****  PROCEDURE MISE EN MARCHE A L'OUVERTURE ***********************
// *********************************************************************
function pageonload() {
	//document.TextForm.Description.focus();
	<?php
          if( isset($NewMessage) ) {
	    	echo "
				window.alert(\"$NewMessage\"); 
			";
          	unset( $NewMessage );
          };
     ?>
	 return;
} // pageonload

</script>

</body>
</html>