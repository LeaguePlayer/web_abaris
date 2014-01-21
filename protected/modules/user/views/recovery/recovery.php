<?php $this->pageTitle=Yii::app()->name . ' - '.UserModule::t("Restore");
$this->breadcrumbs=array(
	UserModule::t("Login") => array('/user/login'),
	UserModule::t("Restore"),
);
?>

<div class="container recovery">
    <div class="page-title">
        <h2 class="georgia"><?php echo UserModule::t("Restore"); ?></h2>
        <div>
            <span class="blue-line"></span>
        </div>
    </div>

    <?php if(Yii::app()->user->hasFlash('recoveryMessage')): ?>
        <div class="success">
            <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
        </div>
    <?php else: ?>

        <div class="form abaris-form" style="padding: 0 2%;">
            <?php echo CHtml::beginForm(); ?>

            <div class="row-fluid">
                <div class="span4">
                    <?php echo CHtml::activeLabel($form,'login_or_email'); ?>
                </div>
                <div class="span8">
                    <?php echo CHtml::activeTextField($form,'login_or_email', array('class' => 'text-input')) ?>
                </div>
            </div>

            <div class="row-fluid submit">
                <div class="span6">
                    <button class="b-button b-button-blue"><?= UserModule::t("Restore") ?></button>
                </div>
            </div>

            <?php echo CHtml::endForm(); ?>
        </div><!-- form -->

    <?php endif; ?>
</div>