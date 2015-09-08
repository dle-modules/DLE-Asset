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

if (!defined('DATALIFEENGINE')) {die("Go fuck yourself!");}

$assetFile = !empty($file) ? str_replace('{THEME}', '/templates/' . $config['skin'], $file) : false;

if ($assetFile) {

	require_once ENGINE_DIR . '/modules/asset/asset.php';
	$compress = $config['js_min'];

	dleAsset::addFile($assetFile, $compress);

}