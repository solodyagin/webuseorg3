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
 * Справочники / Пользователи
 */

$user = User::getInstance();
$cfg = Config::getInstance();

# Проверка: если пользователь - не администратор и не назначена одна из ролей, то
if (!$user->isAdmin() && !$user->TestRoles('1')):
	?>

	<div class="alert alert-danger">
		У вас нет доступа в раздел "Справочники / Пользователи"!<br><br>
		Возможно не назначена <a href="http://грибовы.рф/wiki/doku.php/основы:доступ:роли" target="_blank">роль</a>:
		"Полный доступ".
	</div>

<?php else: ?>

	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-sm-12">
				<table id="list2"></table>
				<div id="pager2"></div>
				<table id="list3"></table>
				<div id="pager3"></div>
				<div id="add_edit"></div>
			</div>
		</div>
	</div>
	<script>
		$('#list2').jqGrid({
			url: 'route/controller/server/users/libre_users.php?org_status=list',
			datatype: 'json',
			colNames: [' ', 'Id', 'Организация', 'ФИО', 'Логин', 'Пароль', 'E-mail', 'Администратор', 'Действия'],
			colModel: [
				{name: 'active', index: 'active', width: 5, search: false},
				{name: 'usersid', index: 'u.id', width: 55, hidden: true},
				{name: 'orgname', index: 'o.name', width: 60},
				{name: 'fio', index: 'fio', width: 45},
				{name: 'login', index: 'login', width: 45, editable: true},
				{name: 'pass', index: 'pass', width: 30, editable: true, edittype: 'password', search: false},
				{name: 'email', index: 'email', width: 30, editable: true},
				{name: 'mode', index: 'mode', width: 30, editable: true, edittype: 'checkbox', editoptions: {value: 'Да:Нет'}, search: false},
				{name: 'myac', width: 80, fixed: true, sortable: false, resize: false, formatter: 'actions', formatoptions: {keys: true}, search: false}
			],
			onSelectRow: function (ids) {
				if (ids == null) {
					ids = 0;
					if ($('#list3').jqGrid('getGridParam', 'records') > 0) {
						$('#list3').jqGrid('setGridParam', {
							url: 'route/controller/server/users/usersroles.php?userid=' + ids + '&orgid=' + defaultorgid
						});
						$('#list3').jqGrid('setGridParam', {
							editurl: 'route/controller/server/users/usersroles.php?userid=' + ids + '&orgid=' + defaultorgid
						}).trigger('reloadGrid');
						GetSubGrid();
					}
				} else {
					$('#list3').jqGrid('setGridParam', {
						url: 'route/controller/server/users/usersroles.php?userid=' + ids + '&orgid=' + defaultorgid
					});
					$('#list3').jqGrid('setGridParam', {
						editurl: 'route/controller/server/users/usersroles.php?userid=' + ids + '&orgid=' + defaultorgid
					}).trigger('reloadGrid');
					GetSubGrid();
				}
			},
			autowidth: true,
			scroll: 1,
			rowNum: 200,
			rowList: [10, 20, 30],
			pager: '#pager2',
			sortname: 'id',
			multiselect: true,
			viewrecords: true,
			sortorder: 'asc',
			editurl: 'route/controller/server/users/libre_users.php?org_status=edit',
			caption: 'Справочник пользователей'
		});
		$('#list2').jqGrid('setGridHeight', $(window).innerHeight() / 2);
		$('#list2').jqGrid('navGrid', '#pager2', {edit: false, add: false, del: false, search: false});
		$('#list2').jqGrid('filterToolbar', {stringResult: true, searchOnEnter: false});
		$('#list2').jqGrid('navButtonAdd', '#pager2', {
			caption: '<i class="fa fa-tag" aria-hidden="true"></i>',
			title: 'Выбор колонок',
			buttonicon: 'none',
			onClickButton: function () {
				$('#list2').jqGrid('columnChooser', {
					width: 550,
					dialog_opts: {
						modal: true,
						minWidth: 470,
						height: 470
					},
					msel_opts: {
						dividerLocation: 0.5
					}
				});
			}
		});
		$('#list2').jqGrid('navButtonAdd', '#pager2', {
			caption: '<i class="fa fa-user-plus" aria-hidden="true"></i>',
			title: 'Добавить',
			buttonicon: 'none',
			onClickButton: function () {
				$('#add_edit').dialog({autoOpen: false, height: 420, width: 400, modal: true, title: 'Добавление пользователя'});
				$('#add_edit').dialog('open');
				$('#add_edit').load('route/controller/client/view/users/user_add.php');
			}
		});
		$('#list2').jqGrid('navButtonAdd', '#pager2', {
			caption: '<i class="fa fa-user-md" aria-hidden="true"></i>',
			title: 'Изменить данные',
			buttonicon: 'none',
			onClickButton: function () {
				var gsr = $('#list2').jqGrid('getGridParam', 'selrow');
				if (gsr) {
					$('#add_edit').dialog({autoOpen: false, height: 420, width: 400, modal: true, title: 'Редактирование пользователя'});
					$('#add_edit').dialog('open');
					$('#add_edit').load('route/controller/client/view/users/user_edit.php?id=' + gsr);
				} else {
					$().toastmessage('showWarningToast', 'Сначала выберите строку!');
				}
			}
		});
		$('#list2').jqGrid('navButtonAdd', '#pager2', {
			caption: '<i class="fa fa-id-card-o" aria-hidden="true"></i>',
			title: 'Профиль',
			buttonicon: 'none',
			onClickButton: function () {
				var gsr = $('#list2').jqGrid('getGridParam', 'selrow');
				if (gsr) {
					$('#add_edit').dialog({autoOpen: false, height: 440, width: 550, modal: true, title: 'Редактирование профиля'});
					$('#add_edit').dialog('open');
					$('#add_edit').load('route/controller/client/view/users/profile_add_edit.php?userid=' + gsr);
				} else {
					$().toastmessage('showWarningToast', 'Сначала выберите строку!');
				}
			}
		});

		function GetSubGrid() {
			var addOptions = {
				top: 0, left: 0, width: 500
			};
			$('#list3').jqGrid({
				height: 100,
				autowidth: true,
				url: 'route/controller/server/users/usersroles.php?userid=',
				datatype: 'json',
				colNames: ['Id', 'Роль', 'Действия'],
				colModel: [
					{name: 'places_users.id', index: 'places_users.id', width: 55, fixed: true},
					{name: 'role', index: 'role', width: 200, editable: true, edittype: 'select', editoptions: {
							editrules: {required: true},
							dataUrl: 'route/controller/server/users/getlistroles.php?orgid=' + defaultorgid
						}},
					{name: 'myac', width: 80, fixed: true, sortable: false, resize: false, formatter: 'actions', formatoptions: {keys: true}}
				],
				rowNum: 5,
				pager: '#pager3',
				sortname: 'id',
				scroll: 1,
				viewrecords: true,
				sortorder: 'asc',
				caption: 'Роли пользователя'
			}).navGrid('#pager3', {add: true, edit: false, del: false, search: false}, {}, addOptions, {}, {multipleSearch: false}, {closeOnEscape: true});
		}
	</script>

<?php endif;