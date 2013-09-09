<?php

$cs = Yii::app()->clientScript;
$cs->registerCssFile($this->getAssetsUrl().'/css/bootstrap.min.css');
$cs->registerCssFile($this->getAssetsUrl().'/css/bootstrap-responsive.min.css');
$cs->registerCssFile($this->getAssetsUrl().'/css/fancybox/jquery.fancybox.css');
$cs->registerCssFile($this->getAssetsUrl().'/css/main.css');
$cs->registerCssFile($this->getAssetsUrl().'/css/form.css');
$cs->registerCssFile($this->getAssetsUrl().'/css/catalog.css');

$cs->registerCoreScript('jquery');
$cs->registerScriptFile($this->getAssetsUrl().'/js/vendor/fancybox/jquery.fancybox.pack.js', CClientScript::POS_END);
$cs->registerScriptFile($this->getAssetsUrl().'/js/vendor/bootstrap.min.js', CClientScript::POS_END);
$cs->registerScriptFile($this->getAssetsUrl().'/js/main.js', CClientScript::POS_END);
$cs->registerScriptFile($this->getAssetsUrl().'/js/catalog.js', CClientScript::POS_END);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo $this->title; ?></title>
    <meta name="description" content="">
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />

    <!--[if lt IE 9]>
    <script src="<?php echo $this->getAssetsUrl();?>/js/vendor/html5-3.6-respond-1.1.0.min.js"></script>
    <![endif]-->
</head>
<body>
    <!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

    <div class="main-wrapper">
        <!-- begin user admin panel-->
        <?php echo $this->getClip('user_panel'); ?>
        <!-- end user admin panel-->

        <!-- begin header block-->
        <div class="header-container">
            <header class="container">
                <div class="row">
                    <div class="header-block span3">
                        <h1><a class="title" href="/">Abaris</a></h1>
                    </div>
                    <div class="header-block span3">
                        <div class="selected-block clearfix">

                            <div class="selected-mark">
                                выбранная марка<br><a href="#">выбрать другую марку</a>
                            </div>
                            <img class="select-logo" src="img/hyundai.gif" alt="">
                        </div>
                    </div>
                    <div class="header-block span3 cog">
                        <a href="#">Станция Технического Обслуживания</a>
                    </div>
                    <div class="header-block span3">
                        <div class="header-phone">
                            +7 <span>(492)</span> 122-22-21<br><a href="#">напишите нам</a>
                        </div>
                    </div>
                </div>
            </header>
        </div>
        <!-- end header block-->

        <?php echo $content; ?>

    </div>

    <div class="footer-container">
        <footer>
            <div class="footer-menu">
                <div class="menu-blocks clearfix">
                    <div class="menu-block">
                        <p>Общий раздел</p>
                        <ul>
                            <li><a href="#">Как добраться</a></li>
                            <li><a href="#">Оптовикам</a></li>
                            <li><a href="#">Станция технического обслуживания</a></li>
                            <li><a href="#">Бпенды автомобилей</a></li>
                            <li><a href="#">Сеть Абарис</a></li>
                            <li><a href="#">Поддержка</a></li>
                        </ul>
                    </div>
                    <div class="menu-block navbar">
                        <p>Интернет-магазин</p>
                        <ul>
                            <li><a href="#">Как добраться</a></li>
                            <li><a href="#">Оптовикам</a></li>
                            <li><a href="#">Станция технического обслуживания</a></li>
                            <li><a href="#">Бпенды автомобилей</a></li>
                            <li><a href="#">Сеть Абарис</a></li>
                            <li><a href="#">Поддержка</a></li>
                        </ul>
                    </div>
                    <div class="menu-block navbar">
                        <p>Конактная информация</p>
                        <ul>
                            <li><a href="#">Как добраться</a></li>
                            <li><a href="#">Оптовикам</a></li>
                            <li><a href="#">Станция технического обслуживания</a></li>
                            <li><a href="#">Поддержка</a></li>
                        </ul>
                    </div>
                </div>
                <div class="best-company">
                    <a href="http://amobile-studio.ru/" target="_blank"><img src="img/amobile.png" alt=""></a> и Абарис друзья с 2013 года
                </div>
            </div>
            <div class="footer-logo">
                <a href="#inline-modal" class="fancybox"><img src="img/logo_footer.png"></a>
                <div class="copyright">copyright ©  2013 Abarisparts.ru </div>
            </div>
        </footer>
    </div>
</body>
</html>