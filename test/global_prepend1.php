<br />
<?php<br />
function callback($buffer) {<br />
	if ($_SERVER['SERVER_NAME'] == 'mobile.myawesomeblog.com') {<br />
		$buffer = str_replace('http://www.myawesomeblog.com', 'http://mobile.myawesomeblog.com', $buffer);<br />
		$buffer = preg_replace('/[\n\r\t]+/', '', $buffer);<br />
		$buffer = preg_replace('/\s{2,}/', ' ', $buffer);<br />
    		$buffer = preg_replace('/(<a[^>]*>)(<img[^>]+alt=")([^"]*)("[^>]*>)(<\/a>)/i', '$1$3$5<br />', $buffer);<br />
		$buffer = preg_replace('/(<link[^>]+rel="[^"]*stylesheet"[^>]*>|<img[^>]*>|style="[^"]*")|<script[^>]*>.*?<\/script>|<style[^>]*>.*?<\/style>|<!--.*?-->/i', '', $buffer);<br />
		$buffer = preg_replace('/<\/head>/i', '<meta name="robots" content="noindex, nofollow"></head>', $buffer);<br />
	}<br />
	return $buffer;<br />
}<br />
ob_start("callback");<br />
?>