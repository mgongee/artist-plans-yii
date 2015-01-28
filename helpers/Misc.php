<?php 

namespace app\helpers;

class Misc {
	/**
	 * Adds http:// to the url if there isn't a http:// or https:// or ftp:// 
	 * @param type $url
	 * @param type $scheme
	 * @return string
	 */
	public static function addScheme($url, $scheme = 'http://')
	{
		if (strlen($url)) return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
		else return false;
	}
}

?>