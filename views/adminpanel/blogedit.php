<?php
include_once(ROOT . '/header.php');
?>
    <link rel="stylesheet" href="/template/css/adminpanel.css" type="text/css" media="all"/>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">
    <link href="/views/adminpanel/css/editor.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="/views/adminpanel/js/editor.js"></script>
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
                 <p>
                    <span class="req"></span>
                    <label>Назва блогу <span>(Обов'язкове поле)</span></label>
                    <input type="text" class="field size1" value="<?php echo $blogItem['title']?>"
                           placeholder="мін 5 та макс 100 символів" name="blog_title"/>
                </p>

                <!-- Form -->

 <div class="container" style="padding:50px 0;">


                    <textarea id="txtedit" name="blog_content"></textarea>
     <script>

         $('#txtedit').Editor();
     </script>
       <script type="text/javascript">
           var data = <?php echo json_encode($blogItem['content'], JSON_HEX_TAG); ?>;
           $('#txtedit').Editor("setText", data);
           $('form').submit(function(){
               document.getElementById("txtedit").innerHTML = $('#txtedit').Editor("getText");
               });


     </script>
 </div>
                <p><label>Загрузка фото</label></p>
                <?php if ($blogItem['preview'] != ""): ?>
                    <?php echo '<img class="blog_edit_img"  src=' . $blogItem['preview'] . '>'; ?>
                <?php endif; ?>
                <p><input style="width: 240px" type="file" name="photo" multiple accept="image/*,image/jpeg"
                          value="<?php echo $blogItem['preview'] ?>"></p>


                <div class="buttons">
                    <input type="button" class="button" value="перегляд"/>
                    <input type="submit" id="submit" name="edit_blog" class="button" value="опублікувати" onclick=plus()/>
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