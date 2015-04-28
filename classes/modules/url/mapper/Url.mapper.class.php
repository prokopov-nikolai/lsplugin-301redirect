<?php
/*-------------------------------------------------------
 * Plugin 301 Redirect by Prokopov Nikolai
 * version 1.0.1 for livestreet 1.0.3
 * site http://www.prokopov-nikolai.ru
 *---------------------------------------------------------
 */

class Plugin301redirect_ModuleUrl_MapperUrl extends Mapper {
  
    protected $oDb;
  
    public function __construct($oDb){
        $this->oDb = $oDb;
    }

    /**
     * Добавляем связь
     * @param $aUrl
     * @return bool
     */
    public function Add($aLink) {
        $sSql = "INSERT INTO ".Config::Get('plugin.301redirect.table.301redirect')."
                  SET ?a";
        $iId = $this->oDb->query($sSql, $aLink);
	    return $iId;
    }

    /**
     * Меняем статус связи
     * @param $sUrlOld
     * @param $iStatus
     */
    public function ChangeStatus($sUrlOld, $iStatus) {
        $this->oDb->query("UPDATE ".Config::Get('plugin.301redirect.table.301redirect')." SET active = ?d WHERE old = ?", $iStatus, $sUrlOld);
        return true;
    }

    /**
     * Удаляем связь
     * @param $sUrlOld
     * @return bool
     */
    public function Del($sUrlOld) {
        $this->oDb->query("DELETE FROM ".Config::Get('plugin.301redirect.table.301redirect')." WHERE old = ?", $sUrlOld);
        return true;
    }

    /**
     * Извлекаем список реврайтов
     */
    public function GetAll(){
        $sSql = "SELECT *
                  FROM ".Config::Get('plugin.301redirect.table.301redirect')."
                  ORDER BY id DESC";
        return $this->oDb->select($sSql);
    }

    /**
     * Извлекаем новый адрес для реврайта
     * @param $sUrlOld
     */
    public function GetNew($sUrlOld){
        $sSql = "SELECT new
                  FROM ".Config::Get('plugin.301redirect.table.301redirect')."
                  WHERE old = ?
                  LIMIT 1";
        return $this->oDb->selectCell($sSql, $sUrlOld);
    }

    /**
     * Извлекаем активный адрес для реврайта
     * @param $sUrlOld
     */
    public function GetNewActive($sUrlOld){
        $sSql = "SELECT new
                  FROM ".Config::Get('plugin.301redirect.table.301redirect')."
                  WHERE old = ? AND active = 1
                  LIMIT 1";
        return $this->oDb->selectCell($sSql, $sUrlOld);
    }

	/**
	 * Получаем список регулярок для реврайтов
	 */
	public function GetRegExpList($iActive) {
		$sSql = "SELECT *
                  FROM ".Config::Get('plugin.301redirect.table.301redirect')."
                  WHERE `regexp` = 1
                  ".(!is_null($iActive) ? "AND active = ?d" : "");
		return $this->oDb->select($sSql, $iActive);
	}
}