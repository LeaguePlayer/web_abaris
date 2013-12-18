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
                <a href="<?php echo $this->createUrl('/pages/view', array('id'=>'stantsiya_tehnicheskogo_obslujivaniya')) ?>">Станция Технического Обслуживания</a>
            </div>
            <div class="header-block span3">
                <div class="header-phone">

                    +7 <span>(3452)</span> <?=Settings::getOption('phone')?><br><a class="feedback" href="<?php echo $this->createUrl('/site/feedback'); ?>">напишите нам</a>

                </div>
            </div>
        </div>
    </header>
</div>
<!-- end header block-->
<?php $this->endClip(); ?>