<?php

/*
 * WebUseOrg3 Lite - учёт оргтехники в организации
 * Лицензия: GPL-3.0
 * Разработчики:
 *   Грибов Павел,
 *   Сергей Солодягин (solodyagin@gmail.com)
 * Сайт: http://грибовы.рф
 */

// Запрещаем прямой вызов скрипта.
defined('WUO') or die('Доступ запрещён');

$cfg = Config::getInstance();

$cfg->quickmenu[] = <<<TXT
<div><i class="fa fa-home fa-fw"></i> <a href="$cfg->rewrite_base">Главная</a></div>
TXT;

$cfg->quickmenu[] = '<hr style="border-top:1px dotted #ccc;margin:2px 0">';
$cfg->quickmenu[] = '<div><i class="fa fa-question fa-fw"></i> <a href="http://xn--90acbu5aj5f.xn--p1ai/wiki/" target="_blank">Справка</a></div>';
$cfg->quickmenu[] = '<hr style="border-top:1px dotted #ccc;margin:2px 0">';
