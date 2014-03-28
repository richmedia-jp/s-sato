<?php

define('IMAGES_DIR', dirname($_SERVER['SCRIPT_FILENAME']).'/images');
define('THUMBNAIL_DIR', dirname($_SERVER['SCRIPT_FILENAME']).'/thumbnails');

define('THUMBNAIL_WIDTH', 72);
define('MAX_FILE_SIZE', 307200);	// 300KB = 1KB/1024bytes * 300

error_reporting(E_ALL & ~E_NOTICE);

// GD
if (!function_exists('imagecreatetruecolor')) {
	echo "GDがインストールされていません";
	exit;
}

?>