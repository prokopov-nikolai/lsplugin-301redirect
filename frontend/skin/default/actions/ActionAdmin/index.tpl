{extends file="{$aTemplatePathPlugin.admin}layouts/layout.base.tpl"}

{block name='layout_options'}
	{$sMenuSelect = '301redirect'}
{/block}

{block name='layout_content'}
	<h2>{$aLang.plugin.301redirect.title}</h2>
	{include file=$aTemplatePathPlugin.301redirect|cat:"actions/ActionAdmin/form.tpl"}
	{include file=$aTemplatePathPlugin.301redirect|cat:"actions/ActionAdmin/list.tpl"}
{/block}