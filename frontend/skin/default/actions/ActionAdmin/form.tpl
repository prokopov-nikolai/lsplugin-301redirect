<div style="width:38%; float:left; display: block; padding-right: 3px;">{$aLang.plugin.301redirect.title_old_url}</div>
<div style="width:45%; float:left; display: block;">{$aLang.plugin.301redirect.title_new_url}</div>
<form id="redirect-form" method="POST" onsubmit="ls.redirect.admin.addItem(this); return false;">
    <input type="text" id="old" name="link[old]"  class="old input-text input-width-full" size="50"  style="width:35%;"/> &nbsp;&nbsp;&nbsp;
    <input type="text" id="new" name="link[new]" class="new input-text input-width-full" size="50"  style="width:35%;"/> &nbsp;&nbsp;&nbsp;
	<input type="checkbox" name="link[regexp]" value="1" id="regexp"/> <label for="regexp">Регулярка</label> &nbsp;&nbsp;&nbsp;
    <input type="submit" class="redirect-submit btn btn-primary"value="Добавить"/>
</form>