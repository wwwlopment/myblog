<?php


include_once(ROOT . '/header.php');
if (!isset($_POST['admin_search_input'])) {
    $blogList = Blog::getBlogList();
}
$usersList = Adminpanel::getUsersList();
?>

<link rel="stylesheet" href="../template/css/adminpanel.css" type="text/css" media="all"/>
<div class="c_img">


    <!-- Container -->
    <div id="container">
        <div class="shell">
            <div class="msg msg-error">
                <?php if (isset($add_blog_errors) && is_array($add_blog_errors)): ?>

                    <?php foreach ($add_blog_errors as $add_blog_error): ?>
                        <p><strong> <?php echo $add_blog_error; ?></strong></p>
                        <a href="#" class="close">close</a>
                    <?php endforeach; ?>

                <?php endif; ?>
            </div>
            <!-- End Message Error -->
            <br/>
            <!-- Main -->
            <div id="main">
                <div class="cl">&nbsp;</div>

                <!-- Content -->
                <div id="content">

                    <!-- Box -->
                    <div class="box">
                        <!-- Box Head -->
                        <div class="box-head">
                            <h2 class="left"><?php if (isset($_POST['admin_search_input'])) {
                                    echo 'Результати пошуку: ';
                                } else {
                                    echo 'Список блогів';
                                } ?></h2>
                            <div class="right">
                                <form action="/searchadm/" method="post">
                                    <label>пошук блогу</label>
                                    <input type="text" name="admin_search_input" class="field small-field"/>
                                    <input type="submit" class="button" value="пошук"/>
                                    <a href="/adminpanel/"><input type="button" class="button" value="скидання"/></a>
                                </form>
                            </div>
                        </div>
                        <!-- End Box Head -->

                        <!-- Table -->

                        <div class="table">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">

                                <tr>
                                    <th width="13"></th>
                                    <th>Назва</th>
                                    <th>Дата</th>

                                    <th>Автор</th>
                                    <th width="110" class="ac">Керування контентом</th>
                                </tr>


                                <?php if (isset($blogList)): ?>
                                    <?php $n = 0; ?>
                                    <form action="" name="blog_list_form" method="post">
                                        <?php foreach ($blogList as $blogItem): ?>
                                            <?php $n++; ?>
                                            <tr>
                                                <td><input type="checkbox" class="checkbox"/></td>
                                                <td><h3>
                                                        <a href="/blog/<?php echo $blogItem['id']; ?>"><?php echo $blogItem['title']; ?></a>
                                                    </h3></td>
                                                <td><?php echo $blogItem['date']; ?></td>
                                                <td><?php echo $blogItem['author_name']; ?></td>
                                                <td><a href="/adminpanel/blogdelete/<?php echo $blogItem['id']; ?>"
                                                       class="ico del">Delete</a><a
                                                            href="/adminpanel/blogedit/<?php echo $blogItem['id']; ?>"
                                                            class="ico edit">Edit</a></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </form>

                                <?php endif; ?>
                            </table>




                        </div>
                        <!-- Table -->

                    </div>
                    <!-- End Box -->

                    <!-- Box -->
                    <div class="box">
                        <!-- Box Head -->
                        <div class="box-head">
                            <h2>Додати новий блог</h2>
                        </div>
                        <!-- End Box Head -->

                        <form action="/addblog/" enctype="multipart/form-data" name="add_blog" method="post">

                            <!-- Form -->
                            <div class="form">
                                <p>
                                    <span class="req"></span>
                                    <label>Назва блогу <span>(Обов'язкове поле)</span></label>
                                    <input type="text" class="field size1" placeholder="мін 5 та макс 100 символів"
                                           name="blog_title"/>
                                </p>
                                <p>
                                    <span class="req"></span>
                                    <label>Контент <span>(Обов'язкове поле)</span></label>
                                    <textarea name="blog_content" class="field size1"
                                              placeholder="мін 5 та макс 100 символів" rows="10" cols="30"></textarea>
                                </p>

                                <p><label>Загрузка фото</label></p>
                                <!-- <textarea name="upload"></textarea>-->
                                <p><input style="width: 240px" type="file" name="photo" multiple
                                          accept="image/*,image/jpeg">
                            </div>
                            <!-- End Form -->

                            <!-- Form Buttons -->
                            <div class="buttons">
                                <input type="button" class="button" value="перегляд"/>
                                <input type="submit" class="button" value="опублікувати"/>
                            </div>
                            <!-- End Form Buttons -->
                        </form>
                    </div>
                    <!-- End Box -->

                </div>
                <!-- End Content -->

                <!-- Sidebar -->
                <div id="sidebar">

                    <!-- Box -->
                    <div class="box">


                        <div class="box">

                            <!-- Box Head -->
                            <div class="box-head">
                                <h2>Користувачі</h2>
                            </div>


                            <div class="box-content">
                                <table width="50%" border="0" cellspacing="5" cellpadding="0">
                                    <?php if (isset($usersList)): ?>
                                        <?php foreach ($usersList as $userItem): ?>

                                            <tr>
                                                <td><h3><?php echo $userItem['id']; ?></h3></td>
                                                <td><?php if ($userItem['banned'] != 1):echo $userItem['login']; else: echo "<del><font color = 'red'>" . $userItem['login'] . "</font></del>"; endif; ?></td>
                                                <td><?php echo $userItem['email']; ?></td>
                                                <td><?php if ($userItem['online'] == 1): ?>
                                                   online
                                                    <?php endif; ?></td>
                                                <?php if ($userItem['id'] != '1'): ?>
                                                    <td><a href="/adminpanel/userdelete/<?php echo $userItem['id'] ?>">видалити</a>
                                                    </td>
                                                    <td><a href="/adminpanel/userban/<?php echo $userItem['id'] ?>">забанити</a>
                                                    </td>
                                                <?php endif; ?>

                                            </tr>


                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                </table>
                            </div>

                        </div>
                        <table>
                            <tr>
                                <center><a href="/adminpanel/userpermissions/">права</a></center>
                            </tr>
                        </table>
                    </div>
                    <!-- End Sidebar -->


                    <!-- End Box -->
                    <!-- Main -->
                </div>
            </div>
            <!-- End Container -->
        </div>

        <?php
        include_once(ROOT . '/footer.php');
        ?>


