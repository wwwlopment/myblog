<?php
require_once(ROOT . '/header.php');
?>
<div class="c_img">
    <h1>Реєстрація на сайті</h1>
<div class="c_registr">
    <!--sign up form-->


        <ul style="list-style: none;">
            <div class="c_errors">
                <?php if (isset($regerrors) && is_array($regerrors)): ?>

                        <?php foreach ($regerrors as $regerror): ?>
                            <li> - <?php echo $regerror; ?></li>
                        <?php endforeach; ?>

                <?php endif; ?>
            </div>
            <form action="" method="post">
            <li><input type="text" name="login" placeholder="Логін"/></li>
            <li><input type="text" name="name" placeholder="Ім'я та прізвище"/></li>
            <li><input type="email" name="email" placeholder="E-mail"/></li>
            <li><input type="password" name="password" placeholder="Пароль"/></li>
            <li><input type="password" name="repassword" placeholder="Повторіть введення пароля"/></li>
            <li><input id="inp" type="submit" name="registration" value="Зареєструватися"/></li>
        </ul>
    </form>
    </div>
</div>
<?php
require_once ($_SERVER['DOCUMENT_ROOT'].'/footer.php');
?>
