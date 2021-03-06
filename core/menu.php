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

namespace core;

use core\utils;

/**
 * Класс для работы с меню
 */
class menu {

	public $arr_menu = []; // Массив где хранится меню
	public $count = 0;

	/**
	 *  Добавляет пункт меню. Если такой uid уже есть - то обновляем содержимое
	 * @param type $parents (main - первый уровень меню), иначе ссылка вида uid на id "родителя"
	 * @param type $name    Наименование пункта меню
	 * @param type $comment Пояснение
	 * @param type $sort    Сортировка
	 * @param type $uid     Некий идетификатор
	 * @param type $path    Путь для запуска скрипта (подставляется как content_page=$path)
	 */
	public function add($parents, $name, $comment, $sort, $uid, $path) {
		// Если корневой уровень меню - то добавляем его
		if ($parents == 'main') {
			$this->count++;
			$this->arr_menu[$this->count]['sort'] = $sort;
			$this->arr_menu[$this->count]['id'] = $this->count;
			$this->arr_menu[$this->count]['parents'] = 'main';
			$this->arr_menu[$this->count]['name'] = $name;
			$this->arr_menu[$this->count]['comment'] = $comment;
			$this->arr_menu[$this->count]['uid'] = $uid;
			$this->arr_menu[$this->count]['path'] = $path;
		} else {
			// Сначала ищем "родителя"
			foreach ($this->arr_menu as $value) {
				if ($parents == $value['uid']) {
					$this->count++;
					$this->arr_menu[$this->count]['sort'] = $sort;
					$this->arr_menu[$this->count]['id'] = $this->count;
					$this->arr_menu[$this->count]['parents'] = $value['uid'];
					$this->arr_menu[$this->count]['name'] = $name;
					$this->arr_menu[$this->count]['comment'] = $comment;
					$this->arr_menu[$this->count]['uid'] = $uid;
					$this->arr_menu[$this->count]['path'] = $path;
				}
			}
		}
	}

	function getFromFiles($pp) {
		$mfiles = utils::getArrayFilesInDir($pp);
		foreach ($mfiles as $fname) {
			if (is_file("$pp/$fname")) {
				include_once("$pp/$fname");
			}
		}
	}

	function getList($parents) {
		$res = [];
		foreach ($this->arr_menu as $value) {
			if ($parents == $value['parents']) {
				$res[] = $value;
			}
		}
		array_multisort($res);
		return $res;
	}

}
