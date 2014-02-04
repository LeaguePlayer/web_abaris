<div class="container ajax-modal">
    <h3>Спасибо!</h3>
    <div class="row-fluid">
        <div class="span12 info">Спасибо, что оформили заказ на сайте Абарис. В личном кабинете Вы сможете отслеживать статус заказа.<br>Когда Ваш товар придет, мы Вам об этом сообщим по указанному номеру телефона и e-mail.</div>
    </div>
    <?php if ( Yii::app()->user->isGuest ): ?>
        <div class="row-fluid">
            <div class="span6"><a class="valign" href="<?php echo $this->createUrl('/user/registration'); ?>">Зарегистрироваться</a></div>
            <div class="span6"><a href="<?php echo $this->createUrl('/pages/sto'); ?>" class="blue-button">Записаться на СТО</a></div>
        </div>
    <?php else: ?>
        <div class="row-fluid">
            <div class="span12"><a href="<?php echo $this->createUrl('/user/cabinet/orders'); ?>">Перейти в личный кабинет</a></div>
        </div>
        <div class="row-fluid">
            <div class="span12"><a href="<?php echo $this->createUrl('/pages/sto'); ?>" class="blue-button">Записаться на СТО</a></div>
        </div>
    <?php endif; ?>
</div>