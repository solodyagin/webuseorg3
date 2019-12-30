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

/*
 * Инструменты / Проверка доступности оргтехники
 */

$user = User::getInstance();
$cfg = Config::getInstance();

# Проверка: если пользователь - не администратор и не назначена одна из ролей, то
if (!$user->isAdmin() && !$user->TestRoles('1')):
	?>

	<div class="alert alert-danger">
		У вас нет доступа в раздел "Инструменты / Проверка доступности ТМЦ"!<br><br>
		Возможно не назначена <a href="http://грибовы.рф/wiki/doku.php/основы:доступ:роли" target="_blank">роль</a>:
		"Полный доступ".
	</div>

<?php else: ?>

	<div class="well">
		<input id="test_ping" class="btn btn-primary" name="test_ping" value="Проверить">
		<div id="ping_add"></div>
	</div>
	<script>
		$('#test_ping').click(function () {
			$('#ping_add').html('<img src="templates/' + theme + '/img/loading.gif">');
			$('#ping_add').load('route/controller/server/common/ping.php?orgid=' + defaultorgid);
		});
	</script>

<?php endif;