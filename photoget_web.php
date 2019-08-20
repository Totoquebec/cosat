<?php
    /* Programme : PhotoGet.php
    * Description : Recherche d'une image rattach� � une oeuvre
    
 
    Exemple #1 Affichage d'une image JPEG vers le navigateur
 
    // Création d'une image vide et ajout d'un texte
    $im = imagecreatetruecolor(120, 20);
    $text_color = imagecolorallocate($im, 233, 14, 91);
    imagestring($im, 1, 5, 5,  'A Simple Text String', $text_color);
    
    // Définit le contenu de l'en-tête - dans ce cas, image/jpeg
    header('Content-Type: image/jpeg');
    
    // Affichage de l'image
    imagejpeg($im);
    
    // Libération de la mémoire
    imagedestroy($im);
      
    Exemple #2 Sauvegarde d'une image JPEG dans un fichier
 
    // Création d'une image vide et ajout d'un texte
    $im = imagecreatetruecolor(120, 20);
    $text_color = imagecolorallocate($im, 233, 14, 91);
    imagestring($im, 1, 5, 5,  'Un texte simple', $text_color);
    
    // Sauvegarde de l'image sous le nom 'simpletext.jpg'
    imagejpeg($im, 'simpletext.jpg');
    
    // Libération de la mémoire
    imagedestroy($im);
    
    
    Exemple #3 Affichage de l'image avec une qualité de 75% vers le navigateur
  
      // Création d'une image vide et ajout d'un texte
    $im = imagecreatetruecolor(120, 20);
    $text_color = imagecolorallocate($im, 233, 14, 91);
    imagestring($im, 1, 5, 5,  'Un texte simple', $text_color);
    
    // Définit le contenu de l'en-tête - dans ce cas,  image/jpeg
    header('Content-Type: image/jpeg');
    
    // On ne fournit pas le nom du fichier (utilisation de la valeur NULL),
    // puis, on définit la qualité à 75%
    imagejpeg($im, NULL, 75);
    
    // Libération de la mémoire
    imagedestroy($im);
      
    
    */
include('lib/config.php');

function MetMessErreur( $Erreur, $Message, $NoErr )
{
  include("lib/varcie.inc");
	$name = "images/nondisp.jpg";
	$handle = fopen($name, "r", 1);
	$size = filesize ($name);
	$data = fread ($handle, $size );
	fclose ($handle);
	
	header("HTTP/1.1 200 OK");
	header("Status: 200 OK");
	Header("Cache-Control: max-age=120, must-revalidate");
	Header("Expires: " . date("D, j M Y H:i:s", time() + 120) . " UTC");
	Header("Pragma: Public");
	
	header("Content-type: image/jpeg; charset=windows-1252");
	header("Content-length: $size");
	header("Content-Disposition: inline; filename=$name"); 
	header("Content-Description: PHP Generated Data");
	include("images/nondisp.jpg");
   exit();
}

$sql = " SELECT * FROM $database.photo WHERE Id='".$_GET['No']."' AND NoPhoto='".$_GET['Idx']."'";
//echo $sql;		 
$result = $mabd->query($sql);
if( !$result ) { 
	MetMessErreur( $mabd->error,"Accès Photo impossible", $mabd->errno );
} elseif (  $result->num_rows != 0 ) {

  $row = $result->fetch_assoc();
	    	
  $data = $row['Photo'];
  $name = $row['FileName'];
  $size = $row['FileSize'];
  $type = $row['FileType'];
 	
	 
  header("HTTP/1.1 200 OK");
  header("Status: 200 OK");
  Header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
  Header("Cache-Control: Public");
  Header("Pragma: Public");

  header("Content-Encoding: AnyTrash");
  header("Content-type: $type; charset=windows-1252");
  header("Content-length: $size");
  header("Content-Disposition: inline; filename=$name"); // inline; filename=$name");attachment
  header("Content-Description: PHP Generated Data");
  echo $data;
}
else {

	$name = "./images/nondisp.jpg";
	$handle = fopen($name, "r", 1);
	$size = filesize ($name);
	$data = fread ($handle, $size );
	fclose ($handle);
	
	header("HTTP/1.1 200 OK");
	header("Status: 200 OK");

//  Header("Expires: -1");
//  Header("Cache-Control: no-cache"); // A �viter
 // Header("Pragma: no-cache");

//  Header("Cache-Control: Public");
//  Header("Expires: " . date("D, j M Y H:i:s", time() + (86400 * 30)) . " UTC");
/*
Controlling Freshness with the Expires HTTP Header

The Expires HTTP header is the basic means of controlling caches; it tells all caches how long the object is fresh for; after that 
time, caches will always check back with the origin server to see if a document is changed. Expires headers are supported by 
practically every client.

Most Web servers allow you to set Expires response headers in a number of ways. Commonly, they will allow setting an absolute time 
to expire, a time based on the last time that the client saw the object (last access time), or a time based on the last time the
document changed on your server (last modification time).

Expires headers are especially good for making static images (like navigation bars and buttons) cacheable. Because they don't 
change much, you can set extremely long expiry time on them, making your site appear much more responsive to your users. They're 
also useful for controlling caching of a page that is regularly changed. For instance, if you update a news page once a day at 
6am, you can set the object to expire at that time, so caches will know when to get a fresh copy, without users having to 
hit 'reload'.

The only value valid in an Expires header is a HTTP date; anything else will most likely be interpreted as 'in the past', so that
the object is uncacheable. Also, remember that the time in a HTTP date is Greenwich Mean Time (GMT), not local time.

For example:
Expires: Fri, 30 Oct 1998 14:19:41 GMT

Cache-Control HTTP Headers
Although the Expires header is useful, it is still somewhat limited; there are many situations where content is cacheable, but the 
HTTP 1.0 protocol lacks methods of telling caches what it is, or how to work with it.

HTTP 1.1 introduces a new class of headers, the Cache-Control response headers, which allow Web publishers to define how pages 
should be handled by caches. They include directives to declare what should be cacheable, what may be stored by caches, 
modifications of the expiration mechanism, and revalidation and reload controls.

Interesting Cache-Control response headers include:

max-age=[seconds] - specifies the maximum amount of time that an object will be considered fresh. Similar to Expires, this 
directive allows more flexibility. [seconds] is the number of seconds from the time of the request you wish the object to be fresh 
for. 
s-maxage=[seconds] - similar to max-age, except that it only applies to proxy (shared) caches. 
public - marks the response as cacheable, even if it would normally be uncacheable. For instance, if your pages are authenticated,
the public directive makes them cacheable. 
no-cache - forces caches (both proxy and browser) to submit the request to the origin server for validation before releasing a 
cached copy, every time. This is useful to assure that authentication is respected (in combination with public), or to maintain 
rigid object freshness, without sacrificing all of the benefits of caching. 
must-revalidate - tells caches that they must obey any freshness information you give them about an object. The HTTP allows caches
to take liberties with the freshness of objects; by specifying this header, you're telling the cache that you want it to strictly
follow your rules. 
proxy-revalidate - similar to must-revalidate, except that it only applies to proxy caches. 
For example:

Cache-Control: max-age=3600, must-revalidate
*/


	Header("Cache-Control: max-age=120, must-revalidate");
	Header("Expires: " . date("D, j M Y H:i:s", time() + 120) . " UTC");
	Header("Pragma: Public");
	
	header("Content-type: image/jpeg; charset=windows-1252");
	header("Content-length: $size");
	header("Content-Disposition: inline; filename=$name"); 
	header("Content-Description: PHP Generated Data");
	include("images/nondisp.jpg");
}
?>
