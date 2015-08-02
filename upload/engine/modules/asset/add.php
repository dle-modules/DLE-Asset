<?php
/*
=============================================================================
DLE-Asset — автозагрузка стилей и скриптов для DLE
=============================================================================
Автор:   ПафНутиЙ
URL:     http://pafnuty.name/
twitter: https://twitter.com/pafnuty_name
google+: http://gplus.to/pafnuty
email:   pafnuty10@gmail.com
=============================================================================
 */

if (!defined('DATALIFEENGINE')) { die("Go fuck yourself!"); }

$assetFolder = !empty($folder) ? str_replace('{THEME}', '/templates/' . $config['skin'], $folder) : false;
$assetIgnore = !empty($ignore) ? str_replace('{THEME}', '/templates/' . $config['skin'], $ignore) : array();

if ($assetFolder) {
	
	require_once ENGINE_DIR . '/modules/asset/asset.php';
	$compress = $config['js_min'];

	dleAsset::add(
		explode(',', $assetFolder),
		explode(',', $assetIgnore),
		$compress
	);

}