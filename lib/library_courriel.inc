<?php
//* Auteur : Denis Léveillé			Date : 2016-04-05
/*  Adapter avec l'aide de la librairie suivante :

 * PHPMailer - PHP email creation and transport class.
 * PHP Version 5
 * @package PHPMailer
 * @link https://github.com/PHPMailer/PHPMailer/ The PHPMailer GitHub project
 * @author Marcus Bointon (Synchro/coolbru) <phpmailer@synchromedia.co.uk>
 * @author Jim Jagielski (jimjag) <jimjag@gmail.com>
 * @author Andy Prevost (codeworxtech) <codeworxtech@users.sourceforge.net>
 * @author Brent R. Matzelle (original founder)
 * @copyright 2012 - 2014 Marcus Bointon
 * @copyright 2010 - 2012 Jim Jagielski
 * @copyright 2004 - 2009 Andy Prevost
 * @license http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License
 * @note This program is distributed in the hope that it will be useful - WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or
 * FITNESS FOR A PARTICULAR PURPOSE.
*/
// DEBUT FUNCTIONS DIVERS --

/**********************************************************************************************
Table des matières des functions
___________________________
function fixEOL($str)
function utf8CharBoundary($encodedText, $maxLength)
function wrapText($message, $length, $qp_mode = false)
function _mime_types($ext = '')
function mb_pathinfo($path, $options = null)
function filenameToType($filename)

**********************************************************************************************/

// ***** VARIOABLE GLOBALE ***** 
$LE = "\r\n"; 
$CharSet = 'iso-8859-1';
$CRLF = "\r\n"; 
 
function fixEOL($str)
/**
 * Ensure consistent line endings in a string.
 * Changes every end of line from CRLF, CR or LF to $this->LE.
 * @access public
 * @param string $str String to fixEOL
 * @return string
 */
{
global $LE, $CharSet;
    // Normalise to \n
    $nstr = str_replace(array("\r\n", "\r"), "\n", $str);
    // Now convert LE as needed
    if ($LE !== "\n") {
        $nstr = str_replace("\n", $LE, $nstr);
    }
    return $nstr;
} // fixEOL

function utf8CharBoundary($encodedText, $maxLength)
/**
* Find the last character boundary prior to $maxLength in a utf-8
* quoted-printable encoded string.
* Original written by Colin Brown.
* @access public
* @param string $encodedText utf-8 QP text
* @param integer $maxLength Find the last character boundary prior to this length
* @return integer
*/
{
global $LE, $CharSet;
	$foundSplitPos = false;
	$lookBack = 3;
	while (!$foundSplitPos) {
	    $lastChunk = substr($encodedText, $maxLength - $lookBack, $lookBack);
	    $encodedCharPos = strpos($lastChunk, '=');
	    if (false !== $encodedCharPos) {
	        // Found start of encoded character byte within $lookBack block.
	        // Check the encoded byte value (the 2 chars after the '=')
	        $hex = substr($encodedText, $maxLength - $lookBack + $encodedCharPos + 1, 2);
	        $dec = hexdec($hex);
	        if ($dec < 128) {
	            // Single byte character.
	            // If the encoded char was found at pos 0, it will fit
	            // otherwise reduce maxLength to start of the encoded char
	            if ($encodedCharPos > 0) {
	                $maxLength = $maxLength - ($lookBack - $encodedCharPos);
	            }
	            $foundSplitPos = true;
	        } elseif ($dec >= 192) {
	            // First byte of a multi byte character
	            // Reduce maxLength to split at start of character
	            $maxLength = $maxLength - ($lookBack - $encodedCharPos);
	            $foundSplitPos = true;
	        } elseif ($dec < 192) {
	            // Middle byte of a multi byte character, look further back
	            $lookBack += 3;
	        }
	    } else {
	        // No encoded character found
	        $foundSplitPos = true;
	    }
	}
	return $maxLength;
} // utf8CharBoundary


function wrapText($message, $length, $qp_mode = false)
/**
* Word-wrap message.
* For use with mailers that do not automatically perform wrapping
* and for quoted-printable encoded messages.
* Original written by philippe.
* @param string $message The message to wrap
* @param integer $length The line length to wrap to
* @param boolean $qp_mode Whether to run in Quoted-Printable mode
* @access public
* @return string
*/{
global $LE, $CharSet,$CRLF;
	if ($qp_mode) {
	    $soft_break = sprintf(' =%s', $LE);
	} else {
	    $soft_break = $LE;
	}
	// If utf-8 encoding is used, we will need to make sure we don't
	// split multibyte characters when we wrap
	$is_utf8 = (strtolower($CharSet) == 'utf-8');
	$lelen = strlen($LE);
	$crlflen = strlen($CRLF);
	
	$message = fixEOL($message);
	//Remove a trailing line break
	if (substr($message, -$lelen) == $LE) {
	    $message = substr($message, 0, -$lelen);
	}
	
	//Split message into lines
	$lines = explode($LE, $message);
	//Message will be rebuilt in here
	$message = '';
	foreach ($lines as $line) {
	    $words = explode(' ', $line);
	    $buf = '';
	    $firstword = true;
	    foreach ($words as $word) {
	        if ($qp_mode and (strlen($word) > $length)) {
	            $space_left = $length - strlen($buf) - $crlflen;
	            if (!$firstword) {
	                if ($space_left > 20) {
	                    $len = $space_left;
	                    if ($is_utf8) {
	                        $len = utf8CharBoundary($word, $len);
	                    } elseif (substr($word, $len - 1, 1) == '=') {
	                        $len--;
	                    } elseif (substr($word, $len - 2, 1) == '=') {
	                        $len -= 2;
	                    }
	                    $part = substr($word, 0, $len);
	                    $word = substr($word, $len);
	                    $buf .= ' ' . $part;
	                    $message .= $buf . sprintf('=%s', $CRLF);
	                } else {
	                    $message .= $buf . $soft_break;
	                }
	                $buf = '';
	            }
	            while (strlen($word) > 0) {
	                if ($length <= 0) {
	                    break;
	                }
	                $len = $length;
	                if ($is_utf8) {
	                    $len = utf8CharBoundary($word, $len);
	                } elseif (substr($word, $len - 1, 1) == '=') {
	                    $len--;
	                } elseif (substr($word, $len - 2, 1) == '=') {
	                    $len -= 2;
	                }
	                $part = substr($word, 0, $len);
	                $word = substr($word, $len);
	
	                if (strlen($word) > 0) {
	                    $message .= $part . sprintf('=%s', $CRLF);
	                } else {
	                    $buf = $part;
	                }
	            }
	        } else {
	            $buf_o = $buf;
	            if (!$firstword) {
	                $buf .= ' ';
	            }
	            $buf .= $word;
	
	            if (strlen($buf) > $length and $buf_o != '') {
	                $message .= $buf_o . $soft_break;
	                $buf = $word;
	            }
	        }
	        $firstword = false;
	    }
	    $message .= $buf . $CRLF;
	}

	return $message;
} // wrapText

    
function _mime_types($ext = '')
/**
* Get the MIME type for a file extension.
* @param string $ext File extension
* @access public
* @return string MIME type of file.
* @static
*/
{
	$mimes = array(
	    'xl'    => 'application/excel',
	    'js'    => 'application/javascript',
	    'hqx'   => 'application/mac-binhex40',
	    'cpt'   => 'application/mac-compactpro',
	    'bin'   => 'application/macbinary',
	    'doc'   => 'application/msword',
	    'word'  => 'application/msword',
	    'xlsx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	    'xltx'  => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
	    'potx'  => 'application/vnd.openxmlformats-officedocument.presentationml.template',
	    'ppsx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
	    'pptx'  => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	    'sldx'  => 'application/vnd.openxmlformats-officedocument.presentationml.slide',
	    'docx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	    'dotx'  => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
	    'xlam'  => 'application/vnd.ms-excel.addin.macroEnabled.12',
	    'xlsb'  => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
	    'class' => 'application/octet-stream',
	    'dll'   => 'application/octet-stream',
	    'dms'   => 'application/octet-stream',
	    'exe'   => 'application/octet-stream',
	    'lha'   => 'application/octet-stream',
	    'lzh'   => 'application/octet-stream',
	    'psd'   => 'application/octet-stream',
	    'sea'   => 'application/octet-stream',
	    'so'    => 'application/octet-stream',
	    'oda'   => 'application/oda',
	    'pdf'   => 'application/pdf',
	    'ai'    => 'application/postscript',
	    'eps'   => 'application/postscript',
	    'ps'    => 'application/postscript',
	    'smi'   => 'application/smil',
	    'smil'  => 'application/smil',
	    'mif'   => 'application/vnd.mif',
	    'xls'   => 'application/vnd.ms-excel',
	    'ppt'   => 'application/vnd.ms-powerpoint',
	    'wbxml' => 'application/vnd.wap.wbxml',
	    'wmlc'  => 'application/vnd.wap.wmlc',
	    'dcr'   => 'application/x-director',
	    'dir'   => 'application/x-director',
	    'dxr'   => 'application/x-director',
	    'dvi'   => 'application/x-dvi',
	    'gtar'  => 'application/x-gtar',
	    'php3'  => 'application/x-httpd-php',
	    'php4'  => 'application/x-httpd-php',
	    'php'   => 'application/x-httpd-php',
	    'phtml' => 'application/x-httpd-php',
	    'phps'  => 'application/x-httpd-php-source',
	    'swf'   => 'application/x-shockwave-flash',
	    'sit'   => 'application/x-stuffit',
	    'tar'   => 'application/x-tar',
	    'tgz'   => 'application/x-tar',
	    'xht'   => 'application/xhtml+xml',
	    'xhtml' => 'application/xhtml+xml',
	    'zip'   => 'application/zip',
	    'mid'   => 'audio/midi',
	    'midi'  => 'audio/midi',
	    'mp2'   => 'audio/mpeg',
	    'mp3'   => 'audio/mpeg',
	    'mpga'  => 'audio/mpeg',
	    'aif'   => 'audio/x-aiff',
	    'aifc'  => 'audio/x-aiff',
	    'aiff'  => 'audio/x-aiff',
	    'ram'   => 'audio/x-pn-realaudio',
	    'rm'    => 'audio/x-pn-realaudio',
	    'rpm'   => 'audio/x-pn-realaudio-plugin',
	    'ra'    => 'audio/x-realaudio',
	    'wav'   => 'audio/x-wav',
	    'bmp'   => 'image/bmp',
	    'gif'   => 'image/gif',
	    'jpeg'  => 'image/jpeg',
	    'jpe'   => 'image/jpeg',
	    'jpg'   => 'image/jpeg',
	    'png'   => 'image/png',
	    'tiff'  => 'image/tiff',
	    'tif'   => 'image/tiff',
	    'eml'   => 'message/rfc822',
	    'css'   => 'text/css',
	    'html'  => 'text/html',
	    'htm'   => 'text/html',
	    'shtml' => 'text/html',
	    'log'   => 'text/plain',
	    'text'  => 'text/plain',
	    'txt'   => 'text/plain',
	    'rtx'   => 'text/richtext',
	    'rtf'   => 'text/rtf',
	    'vcf'   => 'text/vcard',
	    'vcard' => 'text/vcard',
	    'xml'   => 'text/xml',
	    'xsl'   => 'text/xml',
	    'mpeg'  => 'video/mpeg',
	    'mpe'   => 'video/mpeg',
	    'mpg'   => 'video/mpeg',
	    'mov'   => 'video/quicktime',
	    'qt'    => 'video/quicktime',
	    'rv'    => 'video/vnd.rn-realvideo',
	    'avi'   => 'video/x-msvideo',
	    'movie' => 'video/x-sgi-movie'
	);
	if (array_key_exists(strtolower($ext), $mimes)) {
	    return $mimes[strtolower($ext)];
	}
	return 'application/octet-stream';
} // _mime_types

function mb_pathinfo($path, $options = null)
/**
* Multi-byte-safe pathinfo replacement.
* Drop-in replacement for pathinfo(), but multibyte-safe, cross-platform-safe, old-version-safe.
* Works similarly to the one in PHP >= 5.2.0
* @link http://www.php.net/manual/en/function.pathinfo.php#107461
* @param string $path A filename or path, does not need to exist as a file
* @param integer|string $options Either a PATHINFO_* constant,
*      or a string name to return only the specified piece, allows 'filename' to work on PHP < 5.2
* @return string|array
* @static
*/
{
	$ret = array('dirname' => '', 'basename' => '', 'extension' => '', 'filename' => '');
	$pathinfo = array();
	if (preg_match('%^(.*?)[\\\\/]*(([^/\\\\]*?)(\.([^\.\\\\/]+?)|))[\\\\/\.]*$%im', $path, $pathinfo)) {
	    if (array_key_exists(1, $pathinfo)) {
	        $ret['dirname'] = $pathinfo[1];
	    }
	    if (array_key_exists(2, $pathinfo)) {
	        $ret['basename'] = $pathinfo[2];
	    }
	    if (array_key_exists(5, $pathinfo)) {
	        $ret['extension'] = $pathinfo[5];
	    }
	    if (array_key_exists(3, $pathinfo)) {
	        $ret['filename'] = $pathinfo[3];
	    }
	}
	switch ($options) {
	    case PATHINFO_DIRNAME:
	    case 'dirname':
	        return $ret['dirname'];
	    case PATHINFO_BASENAME:
	    case 'basename':
	        return $ret['basename'];
	    case PATHINFO_EXTENSION:
	    case 'extension':
	        return $ret['extension'];
	    case PATHINFO_FILENAME:
	    case 'filename':
	        return $ret['filename'];
	    default:
	        return $ret;
	}
} // mb_pathinfo(
  
function filenameToType($filename)
/**
* Map a file name to a MIME type.
* Defaults to 'application/octet-stream', i.e.. arbitrary binary data.
* @param string $filename A file name or full path, does not need to exist as a file
* @return string
* @static
*/
{
	// In case the path is a URL, strip any query string before getting extension
	$qpos = strpos($filename, '?');
	if (false !== $qpos) {
	    $filename = substr($filename, 0, $qpos);
	}
	$pathinfo = mb_pathinfo($filename);
	return _mime_types($pathinfo['extension']);
} //filenameToType
  
function Courriel_Attachment( $NomFichier, $ID, $type = '', $name = '', $data=''  )
//-------------------------------------------------------------------------------------------------
//  FUNCTION :  Courriel_Attachment
//-------------------------------------------------------------------------------------------------
//  version : 1.0
//  date : 2016/04/05
//  derniere modif : Denis Léveillé
//  info : 
{
	$LaChaine = '';
	//$NomFichier = '..\\'.$nomFich;
	if( @is_file($NomFichier) ) {
		$filename = basename($NomFichier);
		if ($name == '') 
		        $name = $filename;
		
		$data = file_get_contents($NomFichier); 
		
	}
	else if( strlen($data) ){
		if ($NomFichier == '') 
			$NomFichier = str_replace(".", "", uniqid( '', true));
	}
	else {
		echo "<p>fichier $NomFichier n''existe pas'</p>\n";
		return $LaChaine; 
	}
		
	$filename = basename($NomFichier);
	if ($name == '') 
		$name = $filename;
		
	if ($type == '')
		$type = filenameToType($NomFichier);
	
	$imgData = chunk_split(base64_encode($data));
	$LaChaine ="Content-Type: $type; name='$name'\r\n"
		. "Content-Transfer-Encoding: base64\r\n"
		. "Content-Disposition: inline; filename='$filename'\r\n"
		. "Content-ID: <$ID>\r\n"
		. "\r\n"
		. "$imgData\r\n";
	return $LaChaine;
		
} //  Courriel_Attachment
?>
