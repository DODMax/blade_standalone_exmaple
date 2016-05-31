<?php

require __DIR__ . '/config.php';
require __DIR__ . '/helpers.php';
require __DIR__ . '/vendor/autoload.php';

use Windwalker\Renderer\BladeRenderer;

//Init Blade renderer
$paths = array(__DIR__ . '/views');
$renderer = new BladeRenderer($paths, array('cache_path' => __DIR__ . '/cache'));

//Load page based on uri
$url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pos = strpos($url, BASE_URL);
$path = substr($url, $pos + strlen(BASE_URL) +1);
$dir = scandir(__DIR__ . '/pages/');
$files[] = '';
if (empty($path)) {
    $path = "index";
} 
foreach ($dir as $key) {
    $files[] .= $key;
}
if (!in_array($path . '.php', $files)) {
    header('location: http://' . BASE_URL . '/404');
} else {
    require __DIR__ . '/pages/' . $path . '.php';
}
//Render page
$page = new Page();
echo $page->show($renderer);
