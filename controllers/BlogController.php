<?php
include_once ROOT . '/models/Blog.php';

class BlogController
{
    public function actionIndex()
    {
        $blogList = array();
        $blogList = Blog::getBlogList();

        require_once(ROOT . '/views/blog/index.php');
        return true;
    }

    public function actionView($id)
    {
        if (!empty($_POST)) {
            $l = $_POST;
            if (!empty($_POST['blog_comment'])) {
                unset ($l['blog_comment']);
            }
            $l = (array_flip($l));
            $l = reset($l);
            $n = explode('&', $l);
            if ($n[0] == 'delete_comment') {
                Blog::DeleteBlogComment($n[1]);
            } elseif ($n[0] == 'edit_comment') {
                if (!empty($_POST['blog_comment']))
                    Blog::EditBlogComment($n[1]);
                unset($edit_blog_flag);
            } elseif ($n[0] == 'edit') {
                $edit_blog_flag = $n[1];
            }

        }

        if ($id) {
            $blogItem = Blog::getBlogItemById($id);
        }
        require_once(ROOT . '/views/blog/index.php');
        return true;
    }

}