<?php
/*-------------------------------------------------------
 * Plugin 301 Redirect by Prokopov Nikolai
 * version 1.0.1 for livestreet 1.0.3
 * site http://www.prokopov-nikolai.ru
 *---------------------------------------------------------
 */

$config = array();

$config['table']['301redirect'] = '___db.table.prefix___301redirect';

$config['$root$']['router']['page'][Config::Get('plugin.admin.url').'_301redirect'] = 'Plugin301redirect_ActionAdmin';

$config['admin_menu'] = array(
	array(
		'sort' => 60,
		'url' => '/' . Config::Get('plugin.admin.url') . '/301redirect/',
		'lang_key' => 'plugin.301redirect.menu.301redirect',
		'menu_key' => '301redirect'
	),
);
return $config;
 