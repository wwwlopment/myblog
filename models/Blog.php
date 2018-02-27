<?php
/**
 * Created by PhpStorm.
 * User: bogdan
 * Date: 19.09.17
 * Time: 17:47
 */


class Blog
{

    public static function getBlogItemById($id)
    {
        //вертаємо цілочисельне значення ІД
        $id = intval($id);

// якщо ІД - істина, то берем інфу з БД
        if ($id) {

//echo 'id='.$id;
            $db = Db::getConnection();
            $result = $db->query('SELECT * from blogs WHERE id=' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);
            $blogItem = $result->fetch();

            return $blogItem;

        }
        //запрос до БД
    }


    public static function getBlogList()
    {
        //запрос до БД

        $db = Db::getConnection();

        $bloglist = array();

        $result = $db->query('SELECT * FROM blogs ORDER BY date DESC');
        $i = 0;
//var_dump($result);

        while ($row = $result->fetch()) {
            //var_dump($row);
            $bloglist[$i]['id'] = $row['id'];
            $bloglist[$i]['title'] = $row['title'];
            $bloglist[$i]['date'] = $row['date'];
            $bloglist[$i]['short_content'] = $row['short_content'];
            $bloglist[$i]['author_name'] = $row['author_name'];
            $bloglist[$i]['preview'] = $row ['preview'];
            $i++;
        }
        return $bloglist;

    }

    public static function AddBlogComment($id, $comment)
    {
        unset($result);
        if ((!empty($comment)) && (strlen($comment) > 5)) {
            $db = Db::getConnection();
            $data = $db->prepare('INSERT INTO blog_comments (blog_id, comment, username, created) VALUES (?, ?, ?, CURRENT_TIMESTAMP ) ');
            $data->bindValue(1, $id);
            $data->bindValue(2, $comment);
            $data->bindValue(3, $_SESSION['login']);
            $data->execute();

        } else {
            $result[] = 'Помилка! Порожній або надто короткий коментар !';
            return $result;
        }

    }

    public static function getBlogCommentsList($id)
    {
        //запрос до БД

        $db = Db::getConnection();

        $blogCommentlist = array();

        $result = $db->query('SELECT blog_id, comment_id, comment, username, created FROM blog_comments WHERE blog_id =' . $id);

        $i = 0;

        while ($row = $result->fetch()) {
            //var_dump($row);
            $blogCommentlist[$i]['username'] = $row['username'];
            $blogCommentlist[$i]['comment'] = $row['comment'];
            $blogCommentlist[$i]['created'] = $row['created'];
            $blogCommentlist[$i]['comment_id'] = $row['comment_id'];
            $i++;
        }

        return $blogCommentlist;

    }

    public static function DeleteBlogComment($comment_id)
    {
        $comment_id = intval($comment_id);
// якщо ІД - істина, то берем інфу з БД
        if ($comment_id) {
            $db = Db::getConnection();
            $sql = 'DELETE FROM blog_comments WHERE comment_id = :comment_id';
            $data = $db->prepare($sql);
            $data->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);

            if ($data->execute()) {
                return true;
            }
        }

    }

    public static function EditBlogComment($comment_id)
    {
        $comment_id = intval($comment_id);
// якщо ІД - істина, то берем інфу з БД
        if ($comment_id) {
            $db = Db::getConnection();
            $sql = 'UPDATE blog_comments 
SET comment = :comment 
WHERE comment_id = :comment_id';
            $data = $db->prepare($sql);
            $data->bindValue(':comment', htmlentities(nl2br($_POST['blog_comment'], ENT_QUOTES)));
            $data->bindValue(':comment_id', $comment_id, PDO::PARAM_INT);

            if ($data->execute()) {
                return true;
            }
        }
    }

}