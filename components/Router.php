<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 19.09.17
 * Time: 12:14
 */

class Router
{
    private $routes; // масив з роутами

    public function __construct()
    {
        $routesPath = ROOT . '/config/routes.php';
        $this->routes = include($routesPath);
    }

    private function getURI()   //метод вертає строку запроса
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    public function run()
    {
        //перевіряємо строку запроса
        $uri = $this->getURI();

        // перевіряємо чи є такий запрос в наших роутах
        foreach ($this->routes as $uriPattern => $path) {
            //порівнюємо $uriPattern та $uri
            if (preg_match("~$uriPattern~", $uri)) {

                //отримуємо внутрішній шлях із зовнішнього, відповідно до правил
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // забиваємо в масив складові строкИ запроса, розділені слешем
                $segments = explode('/', $internalRoute);

                //затираємо перший елемент масиву, до залишку додаємо Controller
                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName); // робимо першу букву в назві великою

                //те саме робимо з екшинами
                $actionName = 'action' . ucfirst(array_shift($segments));

                // все що залишилося в масиві після array_shift - це параметри
                $parameters = $segments;
                if (SERVICE == 1) {
                    echo '<pre>';
                    echo $uri;
                    echo var_dump('controllerName ' . $controllerName);
                    echo var_dump('actionName ' . $actionName);
                    echo 'parameters ' . var_dump($parameters);
                    echo '</pre>';
                }
                //підключаємо файл класу контроллера
                $controllerFile = ROOT . '/controllers/' . $controllerName . '.php';

                if (SERVICE == 1) { // якщо сервісний режим, то виводимо інфо для відладки
                    echo var_dump($controllerFile);
                }
                if (file_exists($controllerFile)) {
                    //  echo 'file exist';
                    include_once($controllerFile);
                } else {
                    Router::ErrorPage404();
                }
                //створюємо об"єкт класу контроллера
                $controllerObject = new $controllerName;

                if (method_exists($controllerObject, $actionName)) {


                    $result = call_user_func_array(array($controllerObject, $actionName), $parameters);
                } else {
                    Router::ErrorPage404();
                }
                //echo var_dump($result);
                if ($result != null) {
                    break;  // перериває наш цикл пошуку співпадінь роутів
                }


            }

        }



    }

    function ErrorPage404()
    {
        $host = 'http://' . $_SERVER['HTTP_HOST'] . '/';
        header('Location:' . $host . '404.html');

    }
}