<div class="ajax-modal">

    <?php
        echo CHtml::hiddenField('quantity', Yii::app()->cart->getCount());
        echo CHtml::hiddenField('cost', Yii::app()->cart->getCost(true));
    ?>

    <div class="row-fluid">
        <div class="span12 info">Вы положили товар в корзину, можете перейти к оформлению заказа или посмотреть другие товары</div>
    </div>
    <div class="row-fluid">
        <div class="span12"><a class="close-button" href="#">Посмотреть еще товары</a></div>
    </div>
    <div class="row-fluid"><div class="span12"><a href="<?php echo $this->createUrl('/user/cart'); ?>" class="blue-button">Перейти к оформлению заказа!</a></div></div>
</div>