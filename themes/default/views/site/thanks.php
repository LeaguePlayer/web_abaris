<div class="container <?php if ( Yii::app()->request->isAjaxRequest ) echo 'ajax-modal'; ?>">
    <h3>Спасибо за обращение!</h3>
    <div class="row-fluid">
        <div class="span12 info">Наши специалисты уже приступили к обработке Вашей заявки. Постараемся сделать это максимально быстро!</div>
    </div>

    <div class="row-fluid"><div class="span12">
        <?php if ( Yii::app()->request->isAjaxRequest ): ?>
            <a class="close-box blue-button" href="#">Закрыть</a>
        <?php else: ?>
            <a href="/" class="blue-button">Вернуться на главную страницу</a>
        <?php endif; ?>
    </div></div>
</div>