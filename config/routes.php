<?php


return array(

    'adminpanel/blogedit/([0-9]+)'=>'adminpanel/blogedit/$1',
    'adminpanel/userban/([0-9]+)'=>'adminpanel/userban/$1',
    'adminpanel/userdelete/([0-9]+)'=>'adminpanel/userdelete/$1',
    'adminpanel/blogdelete/([0-9]+)'=>'adminpanel/blogdelete/$1',
    'adminpanel/roledelete/([0-9]+)'=>'adminpanel/roledelete/$1',
    'adminpanel/userpermissions'=>'adminpanel/userpermissions',
    'searchadm'=>'adminpanel/searchadm',
    'addblog'=>'adminpanel/addblog',
    'adminpanel/adminpanel/'=>'adminpanel/index',
    'adminpanel'=>'adminpanel/index',
    'search'=>'search/search',
    'about'=>'main/about',
    'reg'=>'main/reg',
    'blog/([0-9]+)'=>'blog/view/$1',
    'blog'=> 'blog/index', //виклик екшин index в контроллері blog
    'index.php'=>'main/index',
    '()'=>'main/index'
);
