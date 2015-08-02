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

class dleAsset {

	/**
	 * @param array   $folders
	 * @param array   $excludes
	 * @param boolean $compress
	 */
	public static function add($folders, $excludes = array('-', '_'), $compress = false) {
		// Дополняем переданные префиксы префиксами по умолчанию
		$excludes = array_merge($excludes, array('-', '_'));

		// Получаем реальные пути к папкам
		$folders = self::getRealPath($folders);

		// Проверяем включено ли сжатие
		$isMin = $compress;

		// Добавляем скрипты и стили
		self::addAssets($folders, $excludes, $isMin);
	}

	/**
	 * @param array $arPath
	 * @param array $excludes
	 * @param bool  $isMin
	 */
	public static function addAssets($arPath, $excludes, $isMin) {
		foreach ($arPath as $folder) {
			// Сканируем папку
			$f = scandir($folder);

			// Получаем относительный путь
			$localFolder = str_replace($_SERVER['DOCUMENT_ROOT'], '', $folder);

			// Массивы на случай включения сжатия и объединения js и css
			$arCssMin = $arJsMin = array();

			// Пробегаем по массиву файлов
			foreach ($f as $file) {
				// Берём только те файлы, у которых нет исключающего префикса
				if (!self::strposArr($file, $excludes)) {
					// Берём только css и js файлы
					if (preg_match("/(.*?)\.(css|js)$/im", $file, $matches)) {
						// Добавляем параметр, если нужно т.к. файлы кешируются браузером
						$v          = (!$isMin) ? fileatime($folder . $file) : 1;
						$fileToShow = $localFolder . $matches[0];

						switch ($matches[2]) {
							case 'css':
								// добавляем css-файл
								if ($isMin) {
									$arCssMin[] = $fileToShow;
								} else {
									echo '<link rel="stylesheet" href="' . $fileToShow . '?v=' . $v . '" />';
									echo "\n\t\t";
								}
								break;

							case 'js':
								// добавляем js-файл
								//
								if ($isMin) {
									$arJsMin[] = $fileToShow;
								} else {
									echo '<script src="' . $fileToShow . '?v=' . $v . '"></script>';
									echo "\n\t\t";
								}
								break;
						}
					}
				}
			}
			// Если сжатие включено — воспользуемся этой хорошей возможностью.
			if ($isMin) {
				if (!empty($arCssMin)) {
					echo '<link rel="stylesheet" href="/engine/classes/min/index.php?charset=utf-8&amp;f=' . implode(',', $arCssMin) . '" />';
				}

				if (!empty($arJsMin)) {
					echo '<script src="/engine/classes/min/index.php?charset=utf-8&amp;f=' . implode(',', $arJsMin) . '"></script>';
				}
			}
		}
	}

	/**
	 * @param array $array
	 *
	 * @return array
	 */

	protected static function getRealPath($array) {

		foreach ($array as $k => $path) {
			$array[$k] = $_SERVER['DOCUMENT_ROOT'] . $path;
		}

		return $array;

	}

	/**
	 * Небольшое улучшение strpos()
	 *
	 * @param  string $str - строка в кторой будем искать
	 * @param  array  $arr - массив, совпадения с которым ищем.
	 *
	 * @return bool
	 */
	protected static function strposArr($str, $arr) {
		foreach ($arr as $v) {
			if (($pos = strpos($str, $v)) !== false && $pos == '0') {
				return true;
			}
		}

		return false;
	}

	private function __construct() {
	}

}