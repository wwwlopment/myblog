<?php

include_once ROOT . '/models/Search.php';

class SearchController {

    public function actionSearch()    {

        if (isset($_POST['search_text'])) {
            $search=$_POST['search_text'];
            $SearchResut=array();
//берем перші 64 символа строки для пошуку
            $search = substr($search, 0, 64);
//вирізаємо всі ненормальні символи
            $search = strip_tags($search);
            $SearchResult = Search::getSearch($search);
            require_once(ROOT.'/views/main/search.php');
            return true;
        }

    }
}