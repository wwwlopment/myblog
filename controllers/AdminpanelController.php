<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 26.10.17
 * Time: 20:52
 */

include_once ROOT . '/models/Adminpanel.php';


class AdminpanelController
{
    public function actionIndex()
    {
        // додаткова перевірка на адміна

        if ($this->isAdmin()) {
            require_once(ROOT . '/views/adminpanel/index.php');
            return true;
        }
    }

    private function isAdmin()
    {
        if (session_id() == "") {
            session_start();
        }
        if (isset($_SESSION['user']) != null && ($_SESSION['user']) === "1") {
            return true;
        } else {
            return false;
        }
    }

    public function actionAddblog()
    {
        if ($this->isAdmin()) {
            function check_length($value = "", $min, $max)
            {
                $result = (strlen($value) < $min || strlen($value) > $max);
                return !$result;
            }


            if (isset($_POST['blog_title']) && check_length($_POST['blog_title'], 5, 100)
                && check_length($_POST['blog_content'], 5, 10000)) {
                Adminpanel::Addblog();
                require_once(ROOT . '/views/adminpanel/index.php');
                return true;
            } else {
                $add_blog_errors[] = 'Помилка! Недозволена кількість символів в тексті або назві !';
                require_once(ROOT . '/views/adminpanel/index.php');
                return $add_blog_errors;
            }
        }
    }

    public function actionBlogedit($id)
    {
        if ($this->isAdmin()) {

            if ($id) {
                if (!isset($_POST['edit_blog'])) {
                    include_once ROOT . '/models/Blog.php';
                    $blogItem = Blog::getBlogItemById($id);

                    require_once(ROOT . '/views/adminpanel/blogedit.php');
                    return $blogItem;
                } else {
                    $res = Adminpanel::BlogEdit($id);
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    return $res;
                }
            }

        }
    }

    public function actionBlogdelete($id)
    {
        if ($this->isAdmin()) {

            if ($id) {
                if (!isset($_POST['delete_blog'])) {
                    Adminpanel::BlogDelete($id);
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    return true;
                }
            }
        }
    }

    public function actionSearchadm()
    {
        if ($this->isAdmin()) {
            if (isset($_POST['admin_search_input'])) {

                $context = $_POST['admin_search_input'];
                $context = substr($context, 0, 64);
                //вирізаємо всі ненормальні символи
                $context = strip_tags($context);
                $blogList = Adminpanel::getBlogItemBySearch($context);
                require_once(ROOT . '/views/adminpanel/index.php');
                return true;
            }
            require_once(ROOT . '/views/blog/index.php');
            return true;
        }
    }

    public function actionUserban($id)
    {
        if ($this->isAdmin()) {
            Adminpanel::Userban($id);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            return true;


        }

    }

    public function actionUserdelete($id)
    {
        if ($this->isAdmin()) {
            Adminpanel::Userdelete($id);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            return true;


        }

    }

    public function actionRoledelete($id)
    {
        if ($this->isAdmin()) {
            Adminpanel::Roledelete($id);
            header("Location: " . $_SERVER['HTTP_REFERER']);
            return true;


        }

    }

    public function actionUserpermissions()
    {
        if ($this->isAdmin()) {
            $userslist = Adminpanel::getUsersPermissionsList();
            require_once(ROOT . '/views/adminpanel/userpermissions.php');
            return $userslist;
        }

    }


}