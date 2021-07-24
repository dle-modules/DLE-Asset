<?php
/*
=============================================================================
DLE-Asset — автозагрузка стилей и скриптов для DLE
=============================================================================
Автор:     ПафНутиЙ
URL:       http://pafnuty.name/
twitter:   https://twitter.com/pafnuty_name
email:     pafnuty10@gmail.com
=============================================================================

=============================================================================
Портировал на DLE 14+ zettend. На версиях ниже не проверялось. 
=============================================================================
Автор:     zettend
URL:       https://zettend.ru/
Telegram:  https://t.me/zettend
email:     me@zettend.ru
=============================================================================
 */

if (!defined('DATALIFEENGINE')) {
	die("Hacking attempt!");
}

$assetFolder = !empty($folder) ? str_replace('{THEME}', '/templates/' . $config['skin'], $folder) : false;
$assetIgnore = !empty($ignore) ? str_replace('{THEME}', '/templates/' . $config['skin'], $ignore) : '';

if ($assetFolder) {

	include_once(DLEPlugins::Check(ENGINE_DIR . '/modules/asset/asset.php'));
	$compress = $config['js_min'];

	dleAsset::add(
		explode(',', $assetFolder),
		explode(',', $assetIgnore),
		$compress
	);
}
