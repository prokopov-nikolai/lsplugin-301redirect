<?php
/*-------------------------------------------------------
 * Plugin 301 Redirect by Prokopov Nikolai
 * version 1.0.1 for livestreet 1.0.3
 * site http://www.prokopov-nikolai.ru
 *---------------------------------------------------------
 */

class Plugin301redirect_ActionAdmin extends PluginAdmin_ActionPlugin {

    /**
      * Инициализация
      */
    public function Init() {
	    parent::Init();
    }

    /**
     * Регистрация евентов
     */
    protected function RegisterEvent() {
        $this->AddEvent('','ShowAdmin');
        $this->AddEventPreg('/^ajax$/','/^addlink$/', 'AjaxAdd');
        $this->AddEventPreg('/^ajax$/','/^changestatuslink$/', 'AjaxChange');
        $this->AddEventPreg('/^ajax$/','/^dellink$/', 'AjaxDel');
    }

    /**********************************************************************************
     ************************ РЕАЛИЗАЦИЯ ЭКШЕНА ***************************************
     **********************************************************************************
     */

    /**
     * Добавляем новое правило
     */
    public function AjaxAdd(){
        /**
         * Устанавливаем формат Ajax ответа
         */
        $this->Viewer_SetResponseAjax('json');

        $aLink = getRequest('link');
        if($this->Plugin301redirect_Url_GetNew($aLink['old'])) {
            /**
             * Сообщение об ошибке
             */
            $this->Message_AddErrorSingle($this->Lang_Get('plugin.301redirect.error_exists'),$this->Lang_Get('error'));
        } elseif ($iId = $this->Plugin301redirect_Url_Add(getRequest('link'))){
	        $this->Viewer_AssignAjax('id', $iId);
            /**
             * Сообщение что связь добавлена
             */
            $this->Message_AddNoticeSingle($this->Lang_Get('plugin.301redirect.add_ok'));
        } else {
            /**
             * Сообщение об ошибке
             */
            $this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
        }
    }

    /**
     * Меняем статус связи
     */
    public function AjaxChange() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        $this->Viewer_SetResponseAjax('json');
        /**
         * Меняем статус
         */
        $aLink = getRequest('link');
        $this->Plugin301redirect_Url_ChangeStatus($aLink['old'], getRequest('status'));
        if(getRequest('status') == 0){
            /**
             * Сообщение что связь отключена
             */
            $this->Message_AddNoticeSingle($this->Lang_Get('plugin.301redirect.link_off'));
        } else {
            /**
             * Сообщение что связь включена
             */
            $this->Message_AddNoticeSingle($this->Lang_Get('plugin.301redirect.link_on'));
        }

    }

    /**
     * Удаляем связь
     */
    public function AjaxDel() {
        /**
         * Устанавливаем формат Ajax ответа
         */
        $this->Viewer_SetResponseAjax('json');
        $aLink = getRequest('link');
        if (true === $this->Plugin301redirect_Url_Del($aLink['old'])){
            /**
             * Сообщение что связь удалена
             */
            $this->Message_AddNoticeSingle($this->Lang_Get('plugin.301redirect.del_ok'));
        } else {
            /**
             * Сообщение об ошибке
             */
            $this->Message_AddErrorSingle($this->Lang_Get('system_error'),$this->Lang_Get('error'));
        }
    }

    /**
    * Показываем список реврайтов и форму добавления
    */
    public function ShowAdmin() {
	    $this->AppendBreadCrumb(10, '301 Редирект');
        /**
         * Тексты для js
         */
        $this->Lang_AddLangJs(array(
            'plugin.301redirect.link_delete'
          , 'plugin.301redirect.link_delete_confirm'
        ));
        $this->Viewer_AppendScript(Plugin::GetTemplateWebPath(__CLASS__).'js/301redirect.js');
        $this->Viewer_Assign('aUrls', $this->Plugin301redirect_Url_GetAll());
        $this->SetTemplateAction('index');
    }
}


