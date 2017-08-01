<?php
/*
Plugin Name: Rus Package
Description: Сниппеты для русскоязычного блога. Транслитерация кириллицы в названиях файлов и url создаваемых записей, русификация даты и времени.
Version: 1.0
Author: Anton Lukin
Author URI: https://lukin.me/
 */       

if (!defined('WPINC')) {
	die;
} 

add_action('init', function() {
	new Rus_Transliteration;
});      

class Rus_Transliteration {
	function __construct() {
		add_action('sanitize_title', [$this, 'sanitize'], 0);
		add_action('sanitize_file_name', [$this, 'sanitize'], 0);

		add_filter('the_date', [$this, 'update_time']);
		add_filter('the_time', [$this, 'update_time']);
		add_filter('get_comment_date', [$this, 'update_time']);
		add_filter('the_modified_time', [$this, 'update_time']);
		add_filter('get_the_modified_date', [$this, 'update_time']); 
	}

	public function sanitize($name) {
		$update = [
			"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
			"Е"=>"E","Ё"=>"YO","Ж"=>"ZH",
			"З"=>"Z","И"=>"I","Й"=>"J","К"=>"K","Л"=>"L",
			"М"=>"M","Н"=>"N","О"=>"O","П"=>"P","Р"=>"R",
			"С"=>"S","Т"=>"T","У"=>"U","Ф"=>"F","Х"=>"X",
			"Ц"=>"C","Ч"=>"CH","Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'",
			"Ы"=>"Y","Ь"=>"","Э"=>"E","Ю"=>"YU","Я"=>"YA",
			"а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d",
			"е"=>"e","ё"=>"yo","ж"=>"zh",
			"з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
			"м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
			"с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"x",
			"ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"shh","ъ"=>"",
			"ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya",
			"—"=>"-", "ë" => "yo", "й" => "J",       
			"Ї"=>"Yi","ї"=>"i","Ґ"=>"G","ґ"=>"g",
			"Є"=>"Ye","є"=>"ie","І"=>"I","і"=>"i",
			"Ә"=>"A","Ғ"=>"G","Қ"=>"K","Ң"=>"N","Ө"=>"O","Ұ"=>"U","Ү"=>"U","H"=>"H",
			"ә"=>"a","ғ"=>"g","қ"=>"k","ң"=>"n","ө"=>"o", "ұ"=>"u","h"=>"h"
		];

		$name = strtr($name, $update); 

		if(seems_utf8($name))
			$name = urldecode($name);

		return $name;
	}

	public function update_time($tdate = '') {
		if(substr_count($tdate, '---') > 0) 
			return str_replace('---', '', $tdate);

		$replace = [
			"Январь" => "января", "Февраль" => "февраля", "Март" => "марта", "Апрель" => "апреля", "Май" => "мая", "Июнь" => "июня", "Июль" => "июля", "Август" => "августа","Сентябрь" => "сентября","Октябрь" => "октября", "Ноябрь" => "ноября", "Декабрь" => "декабря",
			"January" => "января","February" => "февраля", "March" => "марта", "April" => "апреля","May" => "мая","June" => "июня","July" => "июля","August" => "августа", "September" => "сентября","October" => "октября","November" => "ноября","December" => "декабря",
			"Sunday" => "воскресенье","Monday" => "понедельник","Tuesday" => "вторник","Wednesday" => "среда","Thursday" => "четверг","Friday" => "пятница","Saturday" => "суббота",
			"Sun" => "воскресенье","Mon" => "понедельник","Tue" => "вторник", "Wed" => "среда","Thu" => "четверг", "Fri" => "пятница", "Sat" => "суббота",
			"th" => "", "st" => "", "nd" => "","rd" => ""
		];

		return strtr($tdate, $replace);
	}    
}
