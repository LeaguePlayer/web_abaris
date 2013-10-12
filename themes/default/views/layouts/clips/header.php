<?php $this->beginClip('header'); ?>
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
                        <?php echo $this->brand['name']; ?><br><a href="<?php echo $this->createUrl('/site/index', array('do'=>'select_brand')); ?>">выбрать другую марку</a>
                    </div>
                    <img class="select-logo" src="<?php echo $this->brand['logo']; ?>" alt="">
                </div>
            </div>
            <div class="header-block span3 cog">
                <a href="#">Станция Технического Обслуживания</a>
            </div>
            <div class="header-block span3">
                <div class="header-phone">
                    +7 <span>(492)</span> 122-22-21<br><a class="fancy_run fancybox.ajax" href="/">напишите нам</a>
                </div>
            </div>
        </div>
    </header>
</div>
<!-- end header block-->
<?php $this->endClip(); ?>