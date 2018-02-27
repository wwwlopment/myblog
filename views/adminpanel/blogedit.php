<?php
include_once(ROOT . '/header.php');
?>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
<link href="css/editor.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="/template/css/adminpanel.css"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/editor.js" type="text/javascript" charset="utf-8"></script>
    <br>

    <div class="box">
        <!-- Box Head -->
        <div class="box-head">
            <h2>Редагувати блог</h2>
        </div>

        <?php if (isset($blogItem)): ?>
        <div class="form">
            <form action="/adminpanel/blogedit/<?php echo $blogItem['id'] ?>" enctype="multipart/form-data"
                  method="post">


                <!-- Form -->
                     <div class="container" style="padding:50px 0;">
                         <textarea id="txtedit"></textarea>
                     </div>

                <script>
                    $('#txtedit').Editor();
                </script>
              <!-- <p>
                    <span class="req"></span>
                    <label>Назва блогу <span>(Обов'язкове поле)</span></label>
                    <input type="text" class="field size1" value="<?php /*echo $blogItem['title'] */?>"
                           placeholder="мін 5 та макс 100 символів" name="blog_title"/>
                </p>
                <p>
                    <span class="req"></span>
                    <label>Контент <span>(Обов'язкове поле)</span></label>
                    <textarea name="blog_content" class="field size1" placeholder="мін 5 та макс 100 символів" rows="10"
                              cols="30"><?php /*echo $blogItem['content'] */?></textarea>
                </p>

                <p><label>Загрузка фото</label></p>
                <?php /*if ($blogItem['preview'] != ""): */?>
                    <?php /*echo '<img class="blog_edit_img"  src=' . $blogItem['preview'] . '>'; */?>
                <?php /*endif; */?>
                <p><input style="width: 240px" type="file" name="photo" multiple accept="image/*,image/jpeg"
                          value="<?php /*echo $blogItem['preview'] */?>"></p>
-->

                <div class="buttons">
                    <input type="button" class="button" value="перегляд"/>
                    <input type="submit" name="edit_blog" class="button" value="опублікувати"/>
                </div>

                <?php else :
                echo $res; ?>
            </form>


            <?php endif; ?>
        </div>
    </div>



<?php
include_once(ROOT . '/footer.php');
?>
