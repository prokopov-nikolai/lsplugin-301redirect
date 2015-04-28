<?php
/*-------------------------------------------------------
 * Plugin 301 Redirect by Prokopov Nikolai
 * version 1.0.1 for livestreet 1.0.3
 * site http://www.prokopov-nikolai.ru
 *---------------------------------------------------------
 */

class Plugin301redirect_ModuleUrl extends Module {

    protected $oMapper;

    public function Init() {
        $this->oMapper = Engine::GetMapper(__CLASS__);
    }

    /**
     * Добавляем связь
     * @param $aLink
     * @return mixed
     */
    public function Add($aLink) {
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('url'));
        return $this->oMapper->Add($aLink);
    }

    /**
     * Меняем статус связи
     * @param $sUrlOld
     * @param $iStatus
     */
    public function ChangeStatus($sUrlOld, $iStatus) {
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('url', $sUrlOld, $sUrlOld.'_active', 'regexp_list'));
        return $this->oMapper->ChangeStatus($sUrlOld, $iStatus);
    }
    /**
     * Удаляем связь
     * @param $sUrlOld
     */
    public function Del($sUrlOld){
        $this->Cache_Clean(Zend_Cache::CLEANING_MODE_MATCHING_TAG, array('url'));
        return $this->oMapper->Del($sUrlOld);
    }

    /**
     * Извлекаем весь список связей
     */
    public function GetAll(){
        if (false === ($aUrls = $this->Cache_Get('url'))){
            $aUrls = $this->oMapper->GetAll();
            $this->Cache_Set($aUrls, 'url', array('url'), 60*60*24*3);
        }
      return $aUrls;
    }

    /**
     * Извлекаем новый адрес для реврайта
     * @param $sUrlOld
     */
    public function GetNew($sUrlOld){
        if (false === ($sUrlNew = $this->Cache_Get($sUrlOld))){
            $sUrlNew = $this->oMapper->GetNew($sUrlOld);
            $this->Cache_Set($sUrlNew, $sUrlOld, array('url',$sUrlOld), 60*60*24*3);
        }
        return $sUrlNew;
    }

    /**
     * Извлекаем активный адрес для реврайта
     * @param $sUrlOld
     */
    public function GetNewActive($sUrlOld){
        if (false === ($sUrlNew = $this->Cache_Get($sUrlOld."_active"))){
          $sUrlNew = $this->oMapper->GetNewActive($sUrlOld);
          $this->Cache_Set($sUrlNew, $sUrlOld."_active", array('url',$sUrlOld."_active"), 60*60*24*3);
        }
        return $sUrlNew;
    }

	/**
	 * Получаем список регулярок для реврайтов
	 */
	public function GetRegExpList($iActive = null) {
		if (false === ($aRegExp = $this->Cache_Get("reg_exp_active_".$iActive))){
			$aRegExp = $this->oMapper->GetRegExpList($iActive);
			$this->Cache_Set($aRegExp, "reg_exp_active_".$iActive, array('regexp','regexp_list'), 60*60*24*3);
		}
		return $aRegExp;
	}
}


