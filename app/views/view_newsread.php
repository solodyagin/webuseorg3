<?php
/*
 * WebUseOrg3 - учёт оргтехники в организации
 * Лицензия: GPL-3.0
 * Разработчик: Грибов Павел
 * Сайт: http://грибовы.рф
 */
/*
 * Inventory - учёт оргтехники в организации
 * Лицензия: GPL-3.0
 * Разработчик: Сергей Солодягин (solodyagin@gmail.com)
 */

# Запрещаем прямой вызов скрипта.
defined('SITE_EXEC') or die('Доступ запрещён');
?>
<div class="row-fluid">
	<div class="span12 well" id="news_read">
		<span class="label label-info"><?= "$news_title / $news_dt"; ?></span>
		<p><?= $news_body; ?></p>
	</div>
</div>