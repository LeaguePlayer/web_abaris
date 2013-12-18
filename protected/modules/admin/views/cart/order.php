
<?php
    $this->menu=array(
        array('label'=>'Просмотреть корзину','url'=>array('view', 'id'=>$cart->id)),
    );
?>

<h3>Оформление заявки для корзины <?php echo $cart->id ?></h3>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'layout'=>TbHtml::FORM_LAYOUT_HORIZONTAL,
    'htmlOptions'=>array('class'=>'admin-order-form')
)); ?>

    <?php echo $form->errorSummary($model); ?>

    <?php $payTypes = Orders::getPaytypes(); ?>

    <?php echo $form->radioButtonListControlGroup($model, 'paytype', $payTypes); ?>
    <?php echo $form->textFieldControlGroup($model, 'recipient_family'); ?>
    <?php echo $form->textFieldControlGroup($model, 'recipient_firstname'); ?>
    <?php echo $form->textFieldControlGroup($model, 'recipient_lastname'); ?>
    <?php echo $form->textFieldControlGroup($model, 'client_email'); ?>
    <?php echo $form->textFieldControlGroup($model, 'client_phone'); ?>

    <div class="form-actions">
        <?php echo TbHtml::submitButton('Создать', array('color' => TbHtml::BUTTON_COLOR_PRIMARY)); ?>
        <?php echo TbHtml::linkButton('Отмена', array('url'=>array('view', 'id'=>$cart->id))); ?>
    </div>

<?php $this->endWidget(); ?>