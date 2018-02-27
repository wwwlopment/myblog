<?php
include_once(ROOT . '/controllers/LoginController.php');
include_once(ROOT . '/models/Blog.php');
LoginController::checkLogged();
if (isset($_POST['vhod'])) {
    $errors = LoginController::actionLogin();
} elseif (isset($_POST['vyhod'])) {
    LoginController::actionLogOut();
} elseif (isset($_POST['registration'])) {
    $regerrors = LoginController::actionRegistration();
    if (!isset($regerrors)) {
        echo "<script> confirm('Ви успішно зареєстровані !');</script>";
    }
} elseif (isset($_POST['publicate_blog_comment'])) {

    Blog::AddBlogComment($_POST['id'], $_POST['comment_area']);
}

?>

<html>
<head>
    <title><?php echo SITE_NAME ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href="/template/css/style.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

<table width="100%" height="150px" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td background="/template/images/index_02.gif">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="c_header"><?php echo SITE_NAME ?></td>

                    </td>
                    <td>
                        <div class="c_avtoriz">
                            <?php if (!isset($_SESSION['user'])): ?>
                                <div class="c_errors">
                                    <?php if (isset($errors) && is_array($errors)): ?>
                                        <ul>
                                            <?php foreach ($errors as $error): ?>
                                                <li> - <?php echo $error; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                </div>
                                <form action="" method="post">
                                    <input type="text" name="login" placeholder="login...">
                                    <input type="password" name="password" placeholder="*******">
                                    <button type="submit" name='vhod'>
                                        <i>Вхід</i>
                                    </button>
                                    <br><a href="../reg/"><i>Зареєструватися</i></a>
                                </form>

                            <?php else: ?>
                            <span class="userhead">Ви зайшли як <?php echo($_SESSION['login'] . "</br>") ?>
                                <?php if (!empty($_SESSION['user'])) {
                                    echo('Ваш IP :' . $_SERVER["REMOTE_ADDR"] . "</br>");
                                } ?>
                                <br>

                        <form action="" method="post">
                            <button type="submit" name='vyhod'>
                                <i>Вийти</i>
                            </button>
                        </form>
                                <?php endif; ?>
                        </div>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
<div class="container">
    <?php $row = $_SERVER['REQUEST_URI'];
    $str = strpos($row, "/");
    $row = substr($row, 0, $str);
    ?>

    <nav>
        <ul class="mcd-menu">
            <li>
                <a href="/" <?php if ($_SERVER['REQUEST_URI'] == "/"): echo('class="active"'); endif; ?> >
                    <i class="fa fa-home"></i>
                    <strong>Головна сторінка</strong>
                    <small>Home page</small>
                </a>
            </li>

            <li>
                <a href="/blog/" <?php if (strstr($_SERVER['REQUEST_URI'], "/blog/")): echo('class="active"'); endif; ?>>
                    <i class="fa fa-comments-o"></i>
                    <strong>Блог</strong>
                    <small>Blog</small>
                </a>
                <?php $MenuBlogList = Blog::getBlogList(); ?>
                <?php if (isset($MenuBlogList)): ?>
                    <ul>
                        <?php $i = 0; ?>
                        <?php foreach ($MenuBlogList as $MenuBlogItem): ?>
                            <?php if ($i++ == 5) break; ?>
                            <li><a href="/blog/<?php echo $MenuBlogItem['id']; ?>"><i
                                            class="fa fa-globe"></i><?php echo $MenuBlogItem['title']; ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
            <?php if (isset($_SESSION['user']) && $_SESSION['user'] == 1): ?>
                <li>
                    <a href="/adminpanel/" <?php if (strstr($_SERVER['REQUEST_URI'], "/adminpanel")): echo('class="active"'); endif; ?>>
                        <i class="fa fa-gift"></i>
                        <strong>Адміністрування</strong>
                        <small>AdminPanel</small>
                    </a>
                </li>
            <?php endif; ?>
            <li>
                <a href="/about/" <?php if ($_SERVER['REQUEST_URI'] == "/about/"): echo('class="active"'); endif; ?>>
                    <i class="fa fa-edit"></i>
                    <strong>Про нас</strong>
                    <small>About us</small>
                </a>
            </li>
            <form action="/search/" method="post">
                <li class="float">
                    <i class="c_search"></i>
                    <input class="c_search_inp" type="text" name="search_text" placeholder="search...">
                    <button type="submit" class="c_search" name="search"><i>пошук</i>
                    </button>
                    </a>
                </li>
            </form>
        </ul>
    </nav>
</div>

</body>
</html>