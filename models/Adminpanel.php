<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 26.10.17
 * Time: 20:55
 */

class Adminpanel
{

    private static function can_upload($file)
    {
        // якщо пусто, значить файл не вибраний
        if ($file['name'] == '')
            return 'Ви не вибрали файл.';

        /* якщо розмір файла 0, значить його не пропустили настройки
        сервера через великий розмір */
        if ($file['size'] == 0)
            return 'Файл надто великий.';

        // разбиваємо ім"я файла по крапці і отримуємо масив
        $getMime = explode('.', $file['name']);
        // нас цікавить останній елемент масиву - розширення
        $mime = strtolower(end($getMime));
        // створимо масив допустимих розширень
        $types = array('jpg', 'png', 'gif', 'bmp', 'jpeg');

        // вернемо якщо розширення не входить в масив допустимих - return
        if (!in_array($mime, $types))
            return 'Недопустимий тип файла.';

        return true;
    }

    private static function make_upload($file)
    {
        // створюємо унікальне ім"я картинки: рандомне число та name
        $name = mt_rand(0, 10000);
        copy($file['tmp_name'], ROOT . '/template/images/blogimages/' . $name);
        $new_name = '/template/images/blogimages/' . $name;
        return $new_name;
    }

    private static function Setphoto()
    {
        if (isset($_FILES['photo'])) {
            // перевіряємо чи можна  завантажувати зображення
            $check = Adminpanel::can_upload($_FILES['photo']);

            if ($check === true) {
                // завантажуємо зображення на сервер
                $new_name = Adminpanel::make_upload($_FILES['photo']);
            } else {
                $new_name = "";
            }
            return $new_name;
        }
    }

    public static function Addblog()
    {
        $new_name = Adminpanel::Setphoto();
        if (session_id() == "") {
            session_start();
        }


        $db = Db::getConnection();
        $data = $db->prepare('INSERT INTO blogs (title, content, short_content, author_name, preview) 
VALUES (?, ?, ?, ?, ?) ');
        $data->bindValue(1, $_POST['blog_title']);
        $data->bindValue(2, htmlentities(nl2br($_POST['blog_content'], ENT_QUOTES)));
        $data->bindValue(3, mb_substr($_POST['blog_content'], 0, 80));
        $data->bindValue(4, $_SESSION['login']);
        $data->bindValue(5, $new_name);
        $data->execute();
        return true;


    }


    public static function BlogEdit($id)
    {
        $new_name = Adminpanel::Setphoto();
        //вертаємо цілочисельне значення ІД
        $id = intval($id);
// якщо ІД - істина, то берем інфу з БД
        if ($id) {
            $db = Db::getConnection();
            $sql = 'UPDATE blogs 
SET title = :title, 
content = :content, 
short_content = :short_content, 
author_name = :author_name, 
preview = :preview 
WHERE id = :id';
            $data = $db->prepare($sql);
            $data->bindValue(':title', $_POST['blog_title']);
            $data->bindValue(':content', $_POST['blog_content']);

            $data->bindValue(':short_content', mb_substr(strip_tags($_POST['blog_content']), 0, 80));
            $data->bindValue(':author_name', $_SESSION['login']);
            $data->bindValue(':preview', $new_name);
            $data->bindValue(':id', $id, PDO::PARAM_INT);

            if ($data->execute()) {
                $res = 'Запис успішно оновлено!';
            } else {
                $res = 'помилка запису!';

            }
            return $res;
        }
    }

    public static function BlogDelete($id)
    {

        //вертаємо цілочисельне значення ІД
        $id = intval($id);
// якщо ІД - істина, то берем інфу з БД
        if ($id) {
            $db = Db::getConnection();
            $sql = 'DELETE FROM blogs WHERE id = :id';
            $data = $db->prepare($sql);
            $data->bindValue(':id', $id, PDO::PARAM_INT);

            if ($data->execute()) {
                return true;
            }
        }
    }

    public static function getBlogItemBySearch($context)
    {

        $db = Db::getConnection();
        $sql = "SELECT * from blogs WHERE title OR content LIKE '%$context%'";
        $result = $db->prepare($sql);
        $result->execute();
        $blogList = $result->fetchAll(PDO::FETCH_ASSOC);
        return $blogList;
    }

    public static function getUsersList()
    {
        //запрос до БД
        $db = Db::getConnection();
        $userslist = array();
        $result = $db->query('SELECT * FROM users ORDER BY login ASC');
        $i = 0;
        while ($row = $result->fetch()) {
            //var_dump($row);
            $userslist[$i]['id'] = $row['id'];
            $userslist[$i]['login'] = $row['login'];
            $userslist[$i]['email'] = $row['email'];
            $userslist[$i]['role_id'] = $row['role_id'];
            $userslist[$i]['banned'] = $row['banned'];
            $userslist[$i]['online'] = $row['online'];
            $i++;
        }
        return $userslist;
    }

    public static function Userban($id)
    {
        //вертаємо цілочисельне значення ІД
        $id = intval($id);
// якщо ІД - істина, то берем інфу з БД
        if ($id) {
            $db = Db::getConnection();
            $sql = 'UPDATE users SET banned = IF(banned = 1, 0 ,1) WHERE id = :id ';
            // умова в  mysql якщо 1, то 0, /якщо 0, то 1
            $data = $db->prepare($sql);
            $data->bindValue(':id', $id, PDO::PARAM_INT);

            if ($data->execute()) {

                return true;
            }
        }
    }


    public static function Userdelete($id)
    {
        //вертаємо цілочисельне значення ІД
        $id = intval($id);
// якщо ІД - істина, то берем інфу з БД
        if ($id) {
//echo 'id='.$id;
            $db = Db::getConnection();
            $sql = 'DELETE FROM users WHERE id = :id';
            $data = $db->prepare($sql);
            $data->bindValue(':id', $id, PDO::PARAM_INT);
            if ($data->execute()) {
                return true;
            }
        }
    }

    private static function AddGroupName($group_name)
    {
        $new_group_name = $_POST['add_group_name'];
        $db = Db::getConnection();

        $sql = 'SELECT * FROM roles WHERE role = :group_name';
        // $row = $result->fetch();
        $result = $db->prepare($sql);
        $result->bindParam(':group_name', $group_name, PDO::PARAM_STR);
        $result->execute();
//перевірка на входження
        $records = $result->fetch(PDO::FETCH_ASSOC);
        if (!$records) {
            $db = Db::getConnection();
            $data = $db->prepare('INSERT INTO roles (role) VALUES (?) ');
            $data->bindValue(1, $new_group_name);
            $data->execute();
            $last_id = $db->lastInsertId();
            $db = Db::getConnection();
            $data = $db->prepare('INSERT INTO priv (id, rule, val ) VALUES (?,?,?) ');
            $data->bindValue(1, $last_id);
            $data->bindValue(2, 'view_comments');
            $data->bindValue(3, 0);
            $data->execute();
            header("Location: " . $_SERVER['HTTP_REFERER']);
            return true;
        }


    }

    public static function getRolesList()
    {

        $db = Db::getConnection();

        $rolelist = array();

        $result = $db->query("SELECT * FROM roles INNER JOIN priv ON roles.id = priv.id ORDER BY roles.role ASC");
        $i = 0;
        while ($row = $result->fetch()) {

            $rolelist[$row['id']][$row['role']][$row['rule']] = $row['val'];
            $i++;
        }
        return $rolelist;
    }

    private static function WorkWithPriv($sql, $id, $rule, $val)
    {
        $db = Db::getConnection();

        $data = $db->prepare($sql);
        $data->bindValue(':id', $id, PDO::PARAM_INT);
        $data->bindValue(':rule', $rule, PDO::PARAM_INT);
        $data->bindValue(':val', $val, PDO::PARAM_INT);
        if ($data->execute()) {
            header("Location: " . $_SERVER['HTTP_REFERER']);
            return true;
        }
    }

    private static function UpdateRules()
    {

// затираємо два нам непотрібних останніх елементи масиву (службові)
        $values = array();
        $values = $_POST;
        array_splice($values, -2);

        $db = Db::getConnection();

        $sql = "SELECT * FROM priv ORDER BY rule ASC ";
        $result = $db->prepare($sql);
        $result->execute();
        $records = $result->fetchAll(PDO::FETCH_ASSOC);
        $a = 0;
        //селектимо з бази всі рули, і перебираємо в циклі, порівнюючи чи є
        //в нашому масиві з ПОСТу співпадіння по рулу та ід.
        // оскільки в ПОСТ попадає тільки лог 1, то якщо відсутній рул в СЕЛЕКТі, пишемо 0 в базу

        foreach ($records as $record => $rec_val) {
            $searched_rule = $records[$a]['rule'];
            $searched_id = $records[$a]['id'];

            if (!empty($values[$searched_rule]) && (in_array($searched_id, $values[$searched_rule]))) {
// перевіряємо значення пишемо апдейт в базу, якщо в базі 0
                if ($records[$a]['val'] == 0) {
                    $val = 1;
                    $sql = "UPDATE priv SET val = :val WHERE id = :id AND rule = :rule";
                    Adminpanel::WorkWithPriv($sql, $searched_id, $searched_rule, $val);
                }
            }

            if ($rec_val['val'] == 1 && !in_array($searched_id, $values[$searched_rule])) {
                $val = 0;
                $sql = "UPDATE priv SET val = :val WHERE id = :id AND rule = :rule";
                Adminpanel::WorkWithPriv($sql, $searched_id, $searched_rule, $val);

            }

            if (!empty($values[$searched_rule])) {
                $values[$searched_rule] = array_flip($values[$searched_rule]); //Міняємо місцями ключі та значення
                unset ($values[$searched_rule][$searched_id]); //Видаляємо елемент масиву
                $values[$searched_rule] = array_flip($values[$searched_rule]);
            }
            $a++;

        }
        if (!empty($values)) {
            foreach ($values as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    $val = 1;
                    $sql = "INSERT INTO priv SET id = :id, rule = :rule, val = :val";
                    Adminpanel::WorkWithPriv($sql, $value2, $key, $val);

                }

            }

        }

    }


    public static function getUsersPermissionsList()
    {

        if (isset($_POST['add_group_name']) && $_POST['add_group_name'] != "") {
            Adminpanel::AddGroupName($_POST['add_group_name']);
        }
        if (isset($_POST['edit_rules'])) {

            Adminpanel::UpdateRules();
        }

        if (isset($_POST['edit_roles'])) {

            Adminpanel::UpdateRoles();
        }

        //запрос до БД

        $db = Db::getConnection();

        $userslist = array();

        $result = $db->query('SELECT * FROM users LEFT JOIN roles USING (id) ORDER BY login ASC');
        $i = 0;
//var_dump($result);

        while ($row = $result->fetch()) {
            //var_dump($row);
            $userslist[$i]['id'] = $row['id'];
            $userslist[$i]['login'] = $row['login'];
            $userslist[$i]['email'] = $row['email'];
            $userslist[$i]['role_id'] = $row['role_id'];
            $userslist[$i]['banned'] = $row['banned'];
            $userslist[$i]['online'] = $row['online'];
            $i++;
        }
        return $userslist;

    }

    public static function Roledelete($id)
    {

        //вертаємо цілочисельне значення ІД
        $id = intval($id);

// якщо ІД - істина, то берем інфу з БД
        if ($id) {

            $db = Db::getConnection();
            $sql = 'DELETE FROM roles WHERE id = :id';
            $data = $db->prepare($sql);
            $data->bindValue(':id', $id, PDO::PARAM_INT);

            if ($data->execute()) {
                return true;
            }

        }

    }

    private static function UpdateRoles()
    {

// затираємо нам непотрібний останній елемент масиву
        $values = array();
        $values = $_POST;
        $db = Db::getConnection();
        foreach ($values as $id => $role) {
            //перебираємо масив, поки ключі - цілі числа.
            if (!is_int($id)) {
                break;
            }
            if (!is_numeric($role)) {
                $role = 0;
            }


            $sql = "UPDATE users SET role_id = IF(role_id = :role, :role, :role) WHERE id = :id ";

            // умова в  mysql якщо 1, то 0, /якщо 0, то 1

            $data = $db->prepare($sql);
            $data->bindValue(':id', $id, PDO::PARAM_INT);
            $data->bindValue(':role', $role, PDO::PARAM_STR);

            $data->execute();

        }

    }


}