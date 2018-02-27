<?php
include_once(ROOT . '/header.php');
?>

<link rel="stylesheet" href="/template/css/adminpanel.css" type="text/css" media="all"/>
<br>
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Редагувати групи користувачів</h2>
    </div>

    <div class="box-content">
        <form method="post">
            <table width="30%" border="0" cellspacing="5" cellpadding="0">
                <tr>
                    <th width="5">id</th>
                    <th>Ім'я</th>
                    <th>Емейл</th>
                    <th>Статус онлайн</th>
                    <th>Права</th>

                </tr>
                <?php $rolelist = Adminpanel::getRolesList() ?>

                <?php if (isset($userslist)): ?>
                    <?php foreach ($userslist as $userItem): ?>

                        <tr>
                            <td><?php echo $userItem['id'] . '|'; ?></td>
                            <td><?php if ($userItem['banned'] != 1):echo $userItem['login']; else: echo "<del><font color = 'red'>" . $userItem['login'] . "</font></del>"; endif; ?></td>
                            <td><?php echo $userItem['email']; ?></td>
                            <?php if ($userItem['online'] == 1): ?>
                                <td>online</td>
                            <?php else: echo "<td> </td>" ?>
                            <?php endif; ?>
                            <td>
                                <select name="<?php echo $userItem['id'] ?>">
                                    <option>--not selected--</option>

                                    <?php if (isset($rolelist)): ?>
                                        <?php foreach ($rolelist as $roleItem => $value): ?>
                                            <?php foreach ($value as $key => $value2): ?>

                                                <option value= <?php echo $roleItem . ' ';
                                                if ($userItem['role_id'] == $roleItem):echo 'selected'; else : echo $key; endif; ?>><?php echo $key; ?></option>


                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
            <p><input type="submit" name="edit_roles" value="Внести зміни"></p>
        </form>
    </div>
</div>
<!--блок редагування прав груп пористувачів-->
<div class="box">
    <!-- Box Head -->
    <div class="box-head">
        <h2>Редагувати права груп користувачів</h2>
    </div>

    <div class="box-content">
        <form name="permissions_group_edit" method="post">
            <table width="30%" border="0" cellspacing="5" cellpadding="0">
                <?php $rolelist = Adminpanel::getRolesList() ?>


                <tr>
                    <th width="5">id</th>
                    <th>Група</th>
                    <th>Додавати коментарі</th>
                    <th>Бачити коментарі</th>
                    <th>Редагувати коментарі</th>
                    <th>Видаляти коментарі</th>
                    <th>Видалити групу</th>
                </tr>
                <?php if (isset($rolelist)): ?>
                    <?php foreach ($rolelist as $roleItem => $value): ?>
                        <?php foreach ($value as $key => $value2): ?>
                            <tr>
                                <td><?php echo $roleItem; ?></td>
                                <td><?php echo $key; ?></td>
                                <td>
                                    <input type="checkbox" <?php if (isset($value2['add_comments']) && $value2['add_comments'] == 1):echo 'checked'; endif; ?>
                                           name='add_comments[]' value=<?php echo $roleItem ?>></td>
                                <td>
                                    <input type="checkbox" <?php if (isset($value2['view_comments']) && $value2['view_comments'] == 1):echo 'checked'; endif; ?>
                                           name='view_comments[]' value=<?php echo $roleItem ?>></td>
                                <td>
                                    <input type="checkbox" <?php if (isset($value2['edit_comments']) && $value2['edit_comments'] == 1):echo 'checked'; endif; ?>
                                           name='edit_comments[]' value=<?php echo $roleItem ?>></td>
                                <td>
                                    <input type="checkbox" <?php if (isset($value2['delete_comments']) && $value2['delete_comments'] == 1):echo 'checked'; endif; ?>
                                           name='delete_comments[]' value=<?php echo $roleItem ?>></td>

                                <td><a href="/adminpanel/roledelete/<?php echo $roleItem ?>">
                                        Видалити
                                    </a></td>

                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <form name="add_group_name" method="post">

                    <table width="30%" border="0" cellspacing="5" cellpadding="0">

                        <tr>
                            <td><label>Додати нову групу користувачів</label></td>
                        </tr>

                        <td><input type="text" name="add_group_name" placeholder="Назва групи"/>
                            <button type="submit" name="Add_group">Додати</button>
                        </td>
                        </tr>

                    </table>

                    <br>
                    <p><input type="submit" name="edit_rules" value="Внести зміни"></p>
                </form>
        </form>
    </div>
</div>


<?php
include_once(ROOT . '/footer.php');
?>
