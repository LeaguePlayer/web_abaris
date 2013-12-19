<div class="container <?php if ( Yii::app()->request->isAjaxRequest ) echo 'ajax-modal'; ?>">
    <h3>Узнать о новых поступлениях</h3>
    <?php $form = $this->beginWidget('CActiveForm', array(
        'enableAjaxValidation'=>false,
        'action'=>array('/site/question', 'questArticle'=>$model->questArticle),
        'htmlOptions'=>array('class'=>'abaris-form')
    )); ?>

        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'phone'); ?></div>
            <div class="span7">
                <?php echo $form->textField($model, 'phone', array('class'=>'text-input')); ?>
                <?php echo $form->error($model, 'phone'); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'email'); ?></div>
            <div class="span7">
                <?php echo $form->textField($model, 'email', array('class'=>'text-input')); ?>
                <div class="info">Чтобы получить ответ по почте, укажите email</div>
                <?php echo $form->error($model, 'email'); ?>
            </div>
        </div>

        <div class="row-fluid">
            <div class="span5"><?php echo $form->labelEx($model, 'comment'); ?></div>
            <div class="span7">
                <?php echo $form->textArea($model, 'comment', array('class'=>'text-input')); ?>
                <div class="info">Оставьте Ваш комментарий</div>
            </div>
        </div>

        <div class="row-fluid req-info">
            <div class="span12"><span class="required">*</span> Поля обязательные для заполнения</div>
        </div>
        <div class="garant">
            Сайт гарантирует безопасность введенных данных
        </div>
        <div class="row-fluid">
            <div class="span6"><a class="close-box" href="#">Отмена</a></div>
            <div class="span6"><button class="next-step">Принять<i></i></button></div>
        </div>

    <?php $this->endWidget(); ?>
</div>