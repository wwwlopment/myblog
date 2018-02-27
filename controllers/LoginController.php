<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 04.10.17
 * Time: 0:35
 */
include_once(ROOT . '/header.php');

class LoginController
{


    public static function actionLogin()
    {
        $login = '';
        $password = '';
        if (isset($_POST['vhod'])) {

            $login = $_POST['login'];
            $password = md5($_POST['password']);
            $errors = false;

            $userId = LoginController::CheckUserData($login, $password);
            if ($userId == false) {

                $errors[] = 'невірний логін або пароль';
                return $errors;
                header("Location: " . $_SERVER['HTTP_REFERER']);
            } else
                LoginController::auth($userId);
            $permissions = LoginController::CheckPermissions($userId);
            $_SESSION['permissions'] = $permissions;
            header("Location: " . $_SERVER['HTTP_REFERER']);
            //  echo 'logged!';
            return true;
        }

    }

    public static function auth($userId)
    {
        session_set_cookie_params(900);
        if (session_id() == "") {
            session_start();
        }
        $_SESSION['user'] = $userId;
        $_SESSION['login'] = $_POST['login'];
        $db = Db::getConnection();
        $sql = 'UPDATE users SET online = 1 WHERE id = ' . $userId;

        $data = $db->prepare($sql);
        $data->execute();


        return true;

    }

    public static function checkLogged()
    {
        if (session_id() == "") {
            session_start();
        }
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];

        }
    }


    public static function CheckUserData($login, $password)
    {
        $db = Db::getConnection();
        $sql = 'SELECT * FROM users WHERE login= :login AND password= :password AND banned !=1';
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':password', $password, PDO::PARAM_STR);
        $result->execute();

        $user = $result->fetch();
        if ($user) {
            return $user['id'];
        }
        return false;
    }

    public static function CheckPermissions($userId)
    {
        $db = Db::getConnection();
        //SELECT * FROM users LEFT JOIN roles USING (id) ORDER BY login ASC'
        $sql = "SELECT rule FROM priv 
                INNER JOIN roles ON roles.id = priv.id 
                INNER JOIN users ON users.role_id = roles.id 
                WHERE users.id= ? AND priv.val = '1'";
        $result = $db->prepare($sql);
        $result->bindParam(1, $userId);
        $result->execute();
        $permissions = $result->fetchAll(PDO::FETCH_ASSOC);
        $perm = array();
        $i = 0;
        if ($permissions) {
            foreach ($permissions as $key) {
                $perm[$i]['rule'] = $key;
                $i++;
            }
            return $perm;
        } else
            LoginController::actionLogOut();

        return false;
    }


    public static function actionLogOut()
    {


        $userId = $_SESSION['user'];
        $db = Db::getConnection();
        $sql = 'UPDATE users SET online = 0 WHERE id =' . $userId;

        $data = $db->prepare($sql);
        $data->execute();
        unset($_SESSION['user']);
        unset($_SESSION['login']);
        session_destroy();
        header("Location: /");
        return true;
    }

    public static function actionRegistration()
    {
        unset($regerrors);
        $name = $_POST['name'];
        $login = $_POST['login'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];

        function check_length($value = "", $min, $max)
        {
            $result = (strlen($value) < $min || strlen($value) > $max);
            return !$result;
        }

        if (!empty($login) &&
            !empty($name) &&
            !empty($email) &&
            !empty($password) &&
            !empty($repassword)) {
            $email_validate = filter_var($email, FILTER_VALIDATE_EMAIL);

            if (!check_length($login, 5, 10)) {
                $regerrors[] = 'Логін повинен бути довжиною від 5 до 10 символів';
            }
            if (!check_length($name, 5, 50)) {
                $regerrors[] = 'Iм\'я та прізвище повинно займати від 5 до 10 символів';
            }
            if (!check_length($password, 5, 10) && !check_length($repassword, 5, 10)) {
                $regerrors[] = 'Пароль повинен займати від 5 до 10 символів';
            }
            if (!$email_validate) {
                $regerrors[] = 'Е-мейл не пройшов валідацію';
            }
            if ($password !== $repassword) {
                $regerrors[] = 'Поля вводу пароля не співпадають';
            }
            if (isset($regerrors)) {
                return $regerrors;
            }
        } else {
            $regerrors[] = "Заповніть порожні поля";
            return $regerrors;
        }

        $db = Db::getConnection();
        $sql = 'SELECT login, email FROM users WHERE login= :login OR email= :email';
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        $result->execute();
//перевірка на входження логіна чи емейла в базі даних
        $records = $result->fetch(PDO::FETCH_ASSOC);
        if ($records) {
            $regerrors[] = 'Такий логін або е-мейл вже існує';
            //header("Location: ".$_SERVER['HTTP_REFERER']);
            return $regerrors;
        } else {
            //запис в БД нового користувача
            $db = Db::getConnection();
            $data = $db->prepare('INSERT INTO users (login, username, email, password, created, role_id, changed, banned) 
VALUES (?, ?, ?, ?, CURRENT_TIMESTAMP, 0, CURRENT_TIMESTAMP, 1)');
            $data->bindValue(1, $login);
            // $data->bindValue(2, $_POST['blog_content']);
            $data->bindValue(2, $name);
            $data->bindValue(3, $email);
            $data->bindValue(4, md5($password));
            if ($data->execute()) {
                $regerrors[] = 'Вітаємо, Ви успішно зареєструвалися ! Ви зможете увійти після активації Адміністратором сайту !';
            }
            return $regerrors;

        }

    }

}



