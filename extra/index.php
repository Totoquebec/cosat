<?php

	$langs=explode(",",$_SERVER["HTTP_ACCEPT_LANGUAGE"]);
   if( !strncmp ( $langs[0], "fr", 2 ) )
			header( "Location: indexfr.html");
	elseif(!strncmp ( $langs[0], "en", 2 ))
			header( "Location: indexen.html");
	else
			header( "Location: indexsp.html");
?>