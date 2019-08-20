<?php 
function callback($buffer) {
	if ($_SERVER['SERVER_NAME'] == 'mobile.cosat.biz') {
		$buffer = str_replace('http://cosat.biz', 'http://cosat.biz/mobile', $buffer);
		$buffer = preg_replace('/[\n\r\t]+/', '', $buffer);
		$buffer = preg_replace('/\s{2,}/', ' ', $buffer);
    	$buffer = preg_replace('/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i', '$1$3$5<br />', $buffer);
		$buffer = preg_replace('/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|<img[^>]*>|style="[^"]*")|<script[^>]*>.*?<\/script>|<style[^>]*>.*?<\/style>|<!--.*?-->/i', '', $buffer);
		$buffer = preg_replace('/<\/head>/i', '<meta name="robots" content="noindex, nofollow"></head>', $buffer);
	}
	return $buffer;
}
ob_start("callback");

?>