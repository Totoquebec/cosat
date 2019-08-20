<?php
/* Programme : LiSTTauXCHanGe.inc
 * Description : Affichage des taux de chage en cours pour le USD 
 * Auteur : Denis Léveillé 	 		  Date : 2007-01-31
*/
include('connect.inc');

 $DEVISE = "EUR";

 $money= new ConvertDevise(); 
// $t =  $money->TrouveListConversion($DEVISE); 
 $t =  $money->TrouveListConversion(); 
   

echo "<html>
<head>
 <title>Taux de change</title> 
</head>
	<script language='javascript1.2' src='js/disablekeys.js'></script>
	<script language='javascript1.2' src='js/blokclick.js'></script>
	<script language='JavaScript1.2'>addKeyEvent();</script>
<body bgcolor=#0DC4C4>
 <p align=center> 
 (<i>Taux d'échange mis à jour le ".$money->getMiseAjourTime()."</i>)<br></p>
 <hr size='2'><br>";
 
// $TxCANUSD = ChargeDesjardinsVente();
// $TxUSDCAN = ChargeDesjardinsAchat();
 
//echo "<p align=center><font size=+2>Desjardins</font><br><br>
//	 Taux US Desjardins Vente ".$TxCANUSD."<br>
//	 Taux US Desjardins Achat ".$TxUSDCAN."<br><hr size='2'><br>\n";
	 
 $TxCANUSD = ChargeBkCADVente();
 $TxUSDCAN = ChargeBkCADAchat();
 
echo "<p align=center><font size=+2>Banque du Canada</font><br><br>
	 Taux US Banque du Canada Vente ".$TxCANUSD."<br>
	 Taux US Banque du Canada Achat ".$TxUSDCAN."<br><hr size='2'><br>\n";

$Taux = ChargeCuba("CAD");
	$Facteur = 1/$Taux;
	$Facteur /= 10;
	$Facteur = round($Facteur,4);
	$Facteur *= 10;

echo "<p align=center><font size=+2>Banco Metropolitano</font><br><br>
	 Taux CAN Cuba ".$Taux." Facteur ".$Facteur."<br>\n";
	 
$Taux = ChargeCuba("USD");
	$Facteur = 1/$Taux;
	$Facteur /= 10;
	$Facteur = round($Facteur,4);
	$Facteur *= 10;
echo "Taux US Cuba ".$Taux." Facteur ".$Facteur."<br>
   <hr size='2'><br>
   <br>
   <p align=center>
<font size=+2>Banque Européenne</font><br><br>";

  echo "<font size=+1><b>Conversion en $DEVISE</b></font><br><br>";
  foreach ($t as $k=>$v)
    echo $money->Devise($k)." = ".$v."<br>\n";
?>
   </p>

</body>
</html>