<!-- begin main 980-->
<div class="container banners">
    <div class="row">
        <div class="span4"><a href="#"><img width="322" src="<?php echo $this->getAssetsUrl(); ?>/img/banner.jpg"></a></div>
        <div class="span4"><a href="#"><img width="322" src="<?php echo $this->getAssetsUrl(); ?>/img/banner.jpg"></a></div>
        <div class="span4"><a href="#"><img width="322" src="<?php echo $this->getAssetsUrl(); ?>/img/banner.jpg"></a></div>
    </div>
</div>

<div class="container page-title">
    <h2 class="georgia">Хотите подобрать автозапчасти?</h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>

<div class="container main980">
    <div class="row">
        <div class="span6 column1">
            <h3 class="georgia">Мы подготовили для Вас 3 простых способа:</h3>
            <div class="row num-block">
                <div class="span1 big-num">1</div>
                <div class="span5"><p>Запчасти можно легко найти по артикулу:</p>
                    <div class="row">
                        <form method="GET" action="<?php echo $this->createUrl('/details/view'); ?>" class="abaris-form">
                            <div class="span3"><input name="article" type="text" value="" class="text-input s-input"></div>
                            <div class="span2"><button type="submit" class="b-button b-button-blue">Найти</button></div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="span5">
                            <div class="or-line">
                                <div class="line">&nbsp;</div>
                                <span class="text">или</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row num-block">
                <div class="span1 big-num">2</div>
                <div class="span5"><p>Не знаете артикул? Можете продолжить поиск по каталогу:</p>
                    <div class="row">
                        <div class="span5"><a href="<?php echo $this->createUrl('/catalog/index'); ?>" class="b-button b-button-blue">Каталог  Абарис</a></div>
                    </div>
                    <div class="row">
                        <div class="span5">
                            <div class="or-line">
                                <div class="line">&nbsp;</div>
                                <span class="text">или</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row num-block">
                <div class="span1 big-num">3</div>
                <div class="span5"><p>Хорошо разбираетесь в устройстве автомобиля? У нас для Вас есть официальный каталог EPC:</p>
                    <div class="row">
                        <div class="span5"><a href="<?php echo $this->createUrl('/eps/index'); ?>" class="b-button b-button-blue">Каталог  EPC</a></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="span6 column2">
            <h3 class="georgia">Расходные материалы можно найти в каталоге:</h3>
            <div class="row">
                <div class="span6">
                    <a href="<?php echo $this->createUrl('/consumable/index'); ?>" class="b-button b-button-red">Каталог расходных материалов</a>
                </div>
            </div>
            <h3 class="georgia">Также на сайте Вы можете подобрать аксессуары:</h3>
            <div class="row">
                <div class="span6">
                    <a href="<?php echo $this->createUrl('/accessory/index'); ?>" class="b-button b-button-red">Каталог аксессуаров</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- end main 980 -->