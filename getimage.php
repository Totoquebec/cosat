<?php
/****************************************************************************
 * DRBImageVerification
 * http://www.dbscripts.net/imageverification/
 * 
 * Copyright © 2007 Don Barnes 
 ****************************************************************************/
include('lib/config.php');
 
	require_once('extra/challenge.php');
	
	// Create challenge string
	DonneNewMotMagique();
	// Output challenge image to user
	AfficheMotMagique();

?>