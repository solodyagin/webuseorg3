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

namespace app\views;

use core\user;
use core\config;
use core\utils;

$user = user::getInstance();
$cfg = config::getInstance();
?>
<form action="settings/save" method="post" name="form1" target="_self" class="form-horizontal">
	<div class="container-fluid">
		<div class="row">
			<div class="col-sm-12">
				<div class="alert alert-info">
					Inventory ID: <?= $cfg->inventory_id; ?><br>
					Версия программы: v<?= SITE_VERSION; ?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Общие настройки</h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label for="form_sitename" class="col-sm-2 control-label">Имя сайта:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="form_sitename" id="form_sitename" value="<?= $cfg->sitename; ?>" placeholder="Название сайта...">
							</div>
						</div>
						<div class="form-group">
							<label for="form_sitename" class="col-sm-2 control-label">URL сайта:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" name="urlsite" id="urlsite" value="<?= $cfg->urlsite; ?>" placeholder="http://где_мой_сайт" size="80">
							</div>
						</div>
						<div class="form-group">
							<label for="form_cfg_theme_sl" class="col-sm-2 control-label">Тема:</label>
							<div class="col-sm-10">
								<select class="select2 form-control" name="form_cfg_theme_sl" id="form_cfg_theme_sl">
									<?php
									$themes = utils::getArrayFilesInDir(SITE_ROOT . '/public/themes');
									for ($i = 0; $i < count($themes); $i++) {
										if ($themes[$i] == 'fonts') {
											continue;
										}
										$sl = ($themes[$i] == $cfg->theme) ? 'selected' : '';
										echo "<option value=\"{$themes[$i]}\" $sl>{$themes[$i]}</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Вход через Active Directory</h3>
					</div>
					<div class="panel-body">
						<div class="col-sm-12 checkbox">
							<label>
								<input type="checkbox" name="form_cfg_ad" value="1" <?= ($cfg->ad == '1') ? 'checked' : ''; ?>>Разрешить вход
							</label>
						</div>
						<div class="col-sm-4">
							<label for="form_cfg_ldap" class="control-label">Сервер LDAP:</label>
							<input type="text" class="form-control" name="form_cfg_ldap" id="form_cfg_ldap" value="<?= $cfg->ldap; ?>" placeholder="ldaps://dc1.mydomain.tld">
						</div>
						<div class="col-sm-4">
							<label for="form_cfg_domain1" class="control-label">Домен 1:</label>
							<input type="text" class="form-control" name="form_cfg_domain1" id="form_cfg_domain1" value="<?= $cfg->domain1; ?>" placeholder="mydomain">
						</div>
						<div class="col-sm-4">
							<label for="form_cfg_domain2" class="control-label">Домен 2:</label>
							<input type="text" class="form-control" name="form_cfg_domain2" id="form_cfg_domain2" value="<?= $cfg->domain2; ?>" placeholder="tld">
						</div>
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">Уведомления</h3>
					</div>
					<div class="panel-body">
						<div class="col-sm-12 checkbox">
							<label>
								<?php $ch = ($cfg->sendemail == '1') ? 'checked' : ''; ?>
								<input type="checkbox" name="form_sendemail" id="form_sendemail" value="1" <?= $ch; ?>> Рассылать почтовые уведомления
							</label>
						</div>
						<div class="col-sm-6">
							<label for="form_smtphost" class="control-label">SMTP сервер:</label>
							<input type="text" class="form-control" name="form_smtphost" id="form_smtphost" value="<?= $cfg->smtphost; ?>">
							<div class="checkbox">
								<label>
									<?php $ch = ($cfg->smtpauth == '1') ? 'checked' : ''; ?>
									<input type="checkbox" name="form_smtpauth" id="form_smtpauth" value="1" <?= $ch; ?>>Требуется аутенфикация SMTP
								</label>
							</div>
							<label for="form_smtpusername" class="control-label">SMTP имя пользователя:</label>
							<input type="text" class="form-control" name="form_smtpusername" id="form_smtpusername" value="<?= $cfg->smtpusername; ?>">
							<label for="form_smtppass" class="control-label">SMTP пароль пользователя:</label>
							<input type="password" class="form-control" name="form_smtppass" id="form_smtppass" value="<?= $cfg->smtppass; ?>">
							<label for="form_smtpport" class="control-label">SMTP порт:</label>
							<input type="text" class="form-control" name="form_smtpport" id="form_smtpport" value="<?= $cfg->smtpport; ?>">
						</div>
						<div class="col-sm-6">
							<label for="form_emailadmin" class="control-label">От кого почта (From):</label>
							<input type="text" class="form-control" name="form_emailadmin" id="form_emailadmin" value="<?= $cfg->emailadmin; ?>">
							<label for="form_emailreplyto" class="control-label">Куда посылать ответы (Reply-To):</label>
							<input type="text" class="form-control" name="form_emailreplyto" id="form_emailreplyto" value="<?= $cfg->emailreplyto; ?>">
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<button class="btn btn-primary" type="submit" name="Submit">Сохранить изменения</button>
			</div>
		</div>
	</div>
</form>
<script>
	$(function () {
		$('.select2').select2({theme: 'bootstrap'});

		$('#form_cfg_theme_sl').change(function () {
			$('#bs_theme').attr('href', 'public/themes/' + $(this).val() + '/bootstrap.min.css');
		});
	});
</script>
