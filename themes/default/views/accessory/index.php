<?php
$this->breadcrumbs = array(
    'Каталог аксессуаров',
);
?>

<!-- begin auto catalog-->
<div class="container auto-catalog">
    <div class="row">
        <div class="span12"><span class="blue">&lt; <a href="<?php echo $this->createUrl('/site/index', array('do'=>'select_brand')); ?>">Выбрать другую марку</a></span></div>
    </div>
    <div class="row">
        <div class="span6 column1">
            <div class="row num-block">
                <div class="span4"><p>Выбирите модель. <br>Не хотите долго искать? Выберите Первую букву названия.</p>
                </div>
                <div class="span2">
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
        <?php $assetsUrl = $this->getAssetsUrl(); ?>
        <!-- begin 1 row -->
        <?php if ( count($lastModels) > 0 ): ?>
            <div class="row active">
                <?php foreach ( $lastModels as $item ): ?>
                    <div class="span4 auto">
                        <div class="row">
                            <div class="span2 img">
                                <div class="valign-text">
                                    <p><a href="<?php echo $this->createUrl('/accessory/engines', array('model_id'=>$item['id'], 'brand'=>$this->brand['alias'])); ?>">
                                            <img src='<?php echo $item['has_photo'] ? $item['photo'] : $assetsUrl.'/img/no-photo.png'; ?>' style="height:62px;" alt="">
                                        </a></p>
                                </div>
                            </div>
                            <div class="span2">
                                <div class="valign-text">
                                    <p>
                                        <a href="<?php echo $this->createUrl('/accessory/engines', array('model_id'=>$item['id'], 'brand'=>$this->brand['alias'])); ?>"><?php echo $item['full_name']; ?></a><br>
                                        <span><?php echo $item['release_range']; ?></span>
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
        <?php if ( count($autoModels) > 0 ): ?>
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
                            <p><a href="<?php echo $this->createUrl('/accessory/engines', array('model_id'=>$item->id, 'brand'=>$this->brand['alias'])); ?>">
                                    <?php echo ( $item->hasImage() ) ? $item->getImage('small') : CHtml::image($assetsUrl.'/img/no-photo.png', '', array('style'=>'height:62px;'));
                                    ?>
                                </a></p>
                        </div>
                    </div>
                    <div class="span2">
                        <div class="valign-text">
                            <p>
                                <a href="<?php echo $this->createUrl('/accessory/engines', array('model_id'=>$item->id, 'brand'=>$this->brand['alias'])); ?>"><?php echo $item->fullName; ?></a><br>
                                <span><?php echo $item->releaseRange; ?></span>
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
            <?php endif ?>
        <?php endforeach ?>
        <?php if ( $rowOpened ): ?>
    </div>
    <!-- close row -->
<?php endif; ?>
<?php else: ?>
    <div class="container">Ничего не найдено</div>
<?php endif ?>
</div>
</div>
<!-- end auto catalog -->