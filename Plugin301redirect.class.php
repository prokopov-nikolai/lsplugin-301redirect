<?php
/*-------------------------------------------------------
 * Plugin 301 Redirect by Prokopov Nikolai
 * version 0.1 for livestreet 1.0.3
 * site http://www.prokopov-nikolai.ru
 *---------------------------------------------------------
 */

class Plugin301redirect extends Plugin
{
	/**
	 * Активация плагина
	 * В принципе, здесь нам делать ничего не нужно
	 */
	public function Activate()
	{
		if (!$this->isTableExists('prefix_301redirect')) {
			$this->ExportSQL(dirname(__FILE__) . '/sql/install.sql');
		}
		return true;
	}

	/**
	 * Инициализация плагина
	 */
	public function Init()
	{
		$aUrlCurrent = explode('?', $_SERVER['REQUEST_URI']);
		$sUrlCurrent = trim(urldecode($aUrlCurrent[0]), ' /');
//		prex($sUrlCurrent);
		if ($sUrlNew = $this->Plugin301redirect_Url_GetNewActive($sUrlCurrent)) {
			Router::Location(Config::Get('path.root.web').'/'.$sUrlNew.'/'.(isset($aUrlCurrent[1]) && $aUrlCurrent[1] ? '?'.$aUrlCurrent[1]: ''));
		} else {
			// Список Реврайтов по регуляркам
			$aRegExp = $this->Plugin301redirect_Url_GetRegExpList(1);
			if (count($aRegExp)) {
				foreach($aRegExp as $aRE) {
					preg_match($aRE['old'], $sUrlCurrent, $a);
					if (preg_match($aRE['old'], $sUrlCurrent)) {
						// если совпало, то переадресовываем
						$sUrlNew = preg_replace($aRE['old'], $aRE['new'], $sUrlCurrent);
						Router::Location(Config::Get('path.root.web').'/'.$sUrlNew.'/');
					}
				}
			}
		}
	}

	/**
	 * Деактивация плагина
	 * В принципе, тут тоже ничего не нужно делать
	 */
	public function Deactivate()
	{
		if (Config::Get('plugin.301redirect.deactivate.delete')) {
			$this->ExportSQL(dirname(__FILE__) . '/sql/deinstall.sql');
		}
		return true;
	}
}