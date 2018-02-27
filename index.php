<?php


// Загальні налаштування
ini_set('display_errors', 1);
error_reporting(E_ALL); // вмикаємо відображення всіх помилок
define('SERVICE',0); // режим відладки якщо 1
define('SITE_NAME', "Мій сайт на MVC"); // назва сайту

// підключення файлів системи
define('ROOT', dirname(__FILE__));
require_once (ROOT.'/components/Router.php');
require_once (ROOT.'/components/Db.php');



//виклик Router

$router = new Router();
$router->run();