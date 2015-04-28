<style type="text/css">
	.table.redirect label {
		height: 21px;
	}
	.table.redirect .icon-ls-remove {
		margin-top: 2px;
	}
	.table.redirect input[type="checkbox"]:checked + label {
		position: absolute;margin-top: -22px;
	}
</style>

<div style="clear: both; height: 10px;"></div>
<table class="table redirect">
    <tbody>
        {foreach $aUrls as $aUrl}
            <tr class="{if $aUrl.active}active{/if}">
                <td class="cell-checkbox">
                    <input type="checkbox" class="form_plugins_checkbox" data-old="{$aUrl['old']}"{if $aUrl.active} checked="checked" {/if} id="url_{$aUrl.id}">
	                <label for="url_{$aUrl.id}"></label>
                </td>
                <td width="370">{$aUrl['old']}</td>
                <td width="400">{$aUrl['new']}</td>
                <td>
                    <a class="actions-delete icon-ls-remove" data-old="{$aUrl['old']}" onclick="return confirm('{$aLang.plugin.301redirect.link_delete_confirm}');" title="{$aLang.plugin.301redirect.link_delete}" href="#del"></a>
                </td>
            </tr>
        {/foreach}
    </tbody>
</table>
