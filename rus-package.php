<?php
/*
Plugin Name: Rus Package
Description: Snippets for Russian-language blog. Cyrillic to Latin converation in slugs and declension of nouns on dates.
Version: 1.1
Author: Anton Lukin
Author URI: https://lukin.me/
Plugin URI: https://github.com/antonlukin/rus-package
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

add_action( 'init', function() {
 	load_plugin_textdomain( 'rus-package', false, basename(__DIR__) . '/lang' );

	new Rus_Transliteration;
} );

class Rus_Transliteration {
	public function __construct() {
		add_action( 'sanitize_title',        array( $this, 'sanitize_cyrillic' ), 0 );
		add_action( 'sanitize_file_name',    array( $this, 'sanitize_cyrillic' ), 0 );

		add_filter( 'the_date',              array( $this, 'update_time' ) );
		add_filter( 'the_time',              array( $this, 'update_time' ) );
		add_filter( 'get_the_time',          array( $this, 'update_time' ) );
		add_filter( 'get_the_date',          array( $this, 'update_time' ) );
		add_filter( 'get_post_time',         array( $this, 'update_time' ) );
		add_filter( 'get_comment_date',      array( $this, 'update_time' ) );
		add_filter( 'the_modified_time',     array( $this, 'update_time' ) );
		add_filter( 'get_the_modified_date', array( $this, 'update_time' ) );

	}

	public function sanitize_cyrillic( $name ) {
		$replace = array(
			"А"=>"A","Б"=>"B","В"=>"V","Г"=>"G","Д"=>"D",
			"Е"=>"E","Ё"=>"YO","Ж"=>"ZH","З"=>"Z","И"=>"I",
			"Й"=>"J","К"=>"K","Л"=>"L","М"=>"M","Н"=>"N",
			"О"=>"O","П"=>"P","Р"=>"R","С"=>"S","Т"=>"T",
			"У"=>"U","Ф"=>"F","Х"=>"X","Ц"=>"C","Ч"=>"CH",
			"Ш"=>"SH","Щ"=>"SHH","Ъ"=>"'","Ы"=>"Y","Ь"=>"",
			"Э"=>"E","Ю"=>"YU","Я"=>"YA","а"=>"a","б"=>"b",
			"в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo",
			"ж"=>"zh","з"=>"z","и"=>"i","й"=>"j","к"=>"k",
			"л"=>"l","м"=>"m","н"=>"n","о"=>"o","п"=>"p",
			"р"=>"r","с"=>"s","т"=>"t","у"=>"u","ф"=>"f",
			"х"=>"x","ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"sch",
			"ъ"=>"","ы"=>"y","ь"=>"","э"=>"e","ю"=>"yu",
			"я"=>"ya","ë"=>"yo","й"=>"J","Ї"=>"Yi","ї"=>"i",
			"Ґ"=>"G","ґ"=>"g","Є"=>"Ye","є"=>"ie","І"=>"I",
			"і"=>"i","Ә"=>"A","Ғ"=>"G","Қ"=>"K","Ң"=>"N",
			"Ө"=>"O","Ұ"=>"U","Ү"=>"U","H"=>"H","ә"=>"a",
			"ғ"=>"g","қ"=>"k","ң"=>"n","ө"=>"o","ұ"=>"u",
			"h"=>"h","—"=>"-"
		);

		$name = strtr( $name, $replace );

		if ( seems_utf8( $name ) ) {
			$name = urldecode( $name );
		}

		return $name;
	}

	public function update_time( $date = '' ) {
		$replace = array(
			"Январь"    => "января",
			"Февраль"   => "февраля",
			"Март"      => "марта",
			"Апрель"    => "апреля",
			"Май"       => "мая",
			"Июнь"      => "июня",
			"Июль"      => "июля",
			"Август"    => "августа",
			"Сентябрь"  => "сентября",
			"Октябрь"   => "октября",
			"Ноябрь"    => "ноября",
			"Декабрь"   => "декабря",

			"January"   => "января",
			"February"  => "февраля",
			"March"     => "марта",
			"April"     => "апреля",
			"May"       => "мая",
			"June"      => "июня",
			"July"      => "июля",
			"August"    => "августа",
			"September" => "сентября",
			"October"   => "октября",
			"November"  => "ноября",
			"December"  => "декабря",

			"Sunday"    => "воскресенье",
			"Monday"    => "понедельник",
			"Tuesday"   => "вторник",
			"Wednesday" => "среда",
			"Thursday"  => "четверг",
			"Friday"    => "пятница",
			"Saturday"  => "суббота",

			"Sun" => "воскресенье",
			"Mon" => "понедельник",
			"Tue" => "вторник",
			"Wed" => "среда",
			"Thu" => "четверг",
			"Fri" => "пятница",
			"Sat" => "суббота",

			"th" => "",
			"st" => "",
			"nd" => "",
			"rd" => ""
		);

		return strtr( $date, $replace );
	}
}
