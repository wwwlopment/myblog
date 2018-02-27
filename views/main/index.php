<?php
require_once(ROOT . '/header.php');
?>

    <!-- weather widget start -->
    <a target="_blank" href="http://www.booked.net/weather/lutsk-33405">
        <img class="banner"
             src="https://w.bookcdn.com/weather/picture/3_33405_1_29_618c35_250_ffffff_333333_08488D_1_ffffff_333333_0_6.png?scode=124&domid=&anc_id=98634"
             alt="booked.net"/>
    </a>
    <!-- weather widget end -->
    <!--Kurs.com.ua main-ukraine 300x130 blue-->
    <div class="banner" id='kurs-com-ua'>
        <a href="//old.kurs.com.ua/ua/informer" id="kurs-com-ua-informer-main-ukraine-300x130-blue"
           title="Курс валют информер Украина" rel="nofollow" target="_blank">Информер курса валют</a></div>
    <script type='text/javascript'>
        (function () {
            var iframe = '<ifr' + 'ame src="//old.kurs.com.ua/ua/informer/inf2?color=618с35" width="300" height="130" frameborder="0" vspace="0" scrolling="no" hspace="0"></ifr' + 'ame>';
            var container = document.getElementById('kurs-com-ua-informer-main-ukraine-300x130-blue');
            container.parentNode.innerHTML = iframe;
        })();
    </script>
    <noscript><img src='//old.kurs.com.ua/static/images/informer/kurs.png' width='52' height='26'
                   alt='kurs.com.ua: курс валют в Украине!' title='Курс валют' border='0'/></noscript>
    <!--//Kurs.com.ua main-ukraine 300x130 blue-->
    <img class="c_img" src="/template/images/vedro.jpg" alt="">
    <style>
        .c_img {
            width: 100%;
            height: auto;
            opacity: .8;
        }

    </style>


<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/footer.php');

