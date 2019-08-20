<?php
// **********************************************************************************************
include("../extra/var_extra.inc");
include("../extra/varcie.inc");

// **********************************************************************************************
// On est accéder alors on enregistre une variable de session  
$_SESSION['isRobot'] = true;  
$_SESSION['isAspi'] = 2;  

// un retour vers le site  
header('Location: ../index.php'); 
?> 