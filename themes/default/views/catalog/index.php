<!-- begin auto catalog-->
<div class="container auto-catalog">
    <div class="row">
        <div class="span12"><span class="blue">&lt; <a href="<?php echo $this->createUrl('/site/index', array('do'=>'select_brand')); ?>">Выбрать другую марку</a></span></div>
    </div>
    <div class="row">
        <div class="span6 column1">
            <div class="row num-block">
                <div class="span1 big-num">1</div>
                <div class="span5"><p>Знаешь VIN-номер автомобиля? Введи его сюда:</p>
                    <div class="row">
                        <form action="<?php echo $this->createUrl('/catalog/engines'); ?>" method="GET" class="abaris-form">
                            <div class="span3"><?php echo CHtml::textField('VIN', '', array('class'=>'text-input s-input')); ?></div>
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
                <div class="span4"><p>Выбирите модель. <br>Не хотите долго искать? Выберите Первую букву названия.</p>
                </div>
                <div class="span1">
                    <?php echo CHtml::dropDownList('BrandFirstLettet', $currentFirstLetter, $firstLetters, array('class'=>'choose_letter', 'empty'=>'—')); ?>
                </div>
            </div>
        </div>
    </div>
    <?php if ( count($lastModels) > 0 ): ?>
    <div class="row">
        <div class="span12">
            В последний раз Вы просматривали:
        </div>
    </div>
    <?php endif; ?>
    <div class="auto-catalog">
        <!-- begin 1 row -->
        <?php if ( count($lastModels) > 0 ): ?>
        <div class="row active">
            <?php foreach ( $lastModels as $item ): ?>
            <div class="span4 auto">
                <div class="row">
                    <div class="span2 img">
                        <div class="valign-text">
                            <p><a href="<?php echo $this->createUrl('/catalog/engines', array('model_id'=>$item['id'])); ?>"><img src='<?php echo $item['photo']; ?>' alt=""></a></p>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="valign-text">
                            <p>
                                <a href="<?php echo $this->createUrl('/catalog/engines', array('model_id'=>$item['id'])); ?>"><?php echo $item['name'].' - '.$item['bodytype']; ?></a><br>
                                <span><?php echo $item['release_date'].' - '.$item['end_release_date']; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php
            $counter = 0;
            $rowOpened = false;
        ?>
        <?php foreach ( $autoModels as $item ): ?>
            <?php if ( !$rowOpened ): ?>
                <!-- open row -->
                <div class="row">
                <?php $rowOpened = true; ?>
            <?php endif; ?>
            <div class="span4 auto">
                <div class="row">
                    <div class="span2 img">
                        <div class="valign-text">
                            <p><a href="<?php echo $this->createUrl('/catalog/engines', array('model_id'=>$item->id)); ?>"><?php echo $item->getImage('small'); ?></a></p>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="valign-text">
                            <p>
                                <a href="<?php echo $this->createUrl('/catalog/engines', array('model_id'=>$item->id)); ?>"><?php echo $item->name.' - '.$item->bodytype->name; ?></a><br>
                                <span><?php echo $item->releaseYear.' - '.$item->endReleaseYear; ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <?php $counter++; ?>
            <?php if ( $counter % 3 == 0 and $rowOpened ): ?>
                </div>
                <!-- close row -->
                <?php $rowOpened = false; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ( $rowOpened ): ?>
            </div>
            <!-- close row -->
        <?php endif; ?>
    </div>
</div>
<!-- end auto catalog -->