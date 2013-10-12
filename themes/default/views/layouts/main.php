<?php
	$cs = Yii::app()->clientScript;
    $assetsPath = $this->getAssetsUrl('application');
	$cs->registerCssFile($assetsPath.'/css/bootstrap.min.css');
	$cs->registerCssFile($assetsPath.'/css/bootstrap-responsive.min.css');
    $cs->registerCssFile($assetsPath.'/css/fancybox/jquery.fancybox.css');
    $cs->registerCssFile($assetsPath.'/css/main.css', '', 100);
    $cs->registerCssFile($assetsPath.'/css/form.css', '', 200);
	
	$cs->registerCoreScript('jquery');
    //$cs->registerCoreScript('jquery.ui');
    $cs->registerScriptFile($assetsPath.'/js/vendor/jquery-ui-1.9.2.custom.js', CClientScript::POS_HEAD);
	$cs->registerScriptFile($assetsPath.'/js/vendor/fancybox/jquery.fancybox.pack.js', CClientScript::POS_END);
	$cs->registerScriptFile($assetsPath.'/js/vendor/bootstrap.min.js', CClientScript::POS_END);
	$cs->registerScriptFile($assetsPath.'/js/vendor/jquery.maskedinput.js', CClientScript::POS_END);
	$cs->registerScriptFile($assetsPath.'/js/main.js', CClientScript::POS_BEGIN);
    $cs->registerScriptFile($assetsPath.'/js/sign_up.js', CClientScript::POS_END);
?>
<?php echo $this->getClip('head'); ?>
<body>
    <!--[if lt IE 7]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->
    <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html -->

    <div class="main-wrapper">
        <?php echo $this->getClip('user_panel'); ?>
        <?php echo $this->getClip('header'); ?>

        <!-- begin breadcrumbs -->
        <div class="container align-center grey-border">
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'tagName' => 'ul',
                'homeLink'=>'<li><a class="home" href="/">Главная</a></li>',
                'inactiveLinkTemplate'=>'<li class="current">{label}</li>',
                'activeLinkTemplate'=>'<li><a href="{url}">{label}</a></li>',
                'separator'=>'<li class="sep"></li>',
                'htmlOptions'=>array(
                    'class'=>'breadcrumbs clearfix',
                ),
                'links'=>$this->breadcrumbs,
            )); ?>
            <form class="search-form">
                <div class="input-wrap clearfix">
                    <input class="search-input" type="search" name="search-text" placeholder="поиск..."/>
                    <input class="search-button" type="submit" value=""/>
                </div>
            </form>
        </div>
        <!-- end breadcrumbs -->

        <?php echo $content; ?>
        <div class="push"></div>
    </div>
    <?php echo $this->getClip('footer'); ?>
</body>
</html>
