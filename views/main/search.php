<?php
include_once(ROOT . '/header.php');
?>

    <!--    <div class="c_img">-->
    <div class="search_results">
        <?php if ($SearchResult == true) {
            echo 'Результати пошуку : <p>';
            $i = 0;
            foreach ($SearchResult as $record) {
                $i++;
                $link = '<a href=http://' . $_SERVER['HTTP_HOST'] . '/blog/' . $record['id'] . '>';
                echo $i . "  " . $link . $record['title'] . "  " . $record['content'] . '</a><p>';
            }
        } else {
            echo 'В результаті пошуку жодного співпадіння не було виявлено';
        }
        ?>
    </div>
    <!--</div>-->

<?php
include_once(ROOT . '/footer.php');
?>