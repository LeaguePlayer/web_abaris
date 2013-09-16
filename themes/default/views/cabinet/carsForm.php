<div class="container">
	<div class="row">
		<?if ($user_car){?>
                <?php $form=$this->beginWidget('CActiveForm', array(
					'id'=>'user-car-form',
					'htmlOptions' => array('class'=> "abaris-form"),
					'enableAjaxValidation'=>false,
				)); ?>
                    <div class="sign-info">Вы можете привязать один или несколько автомобилей к аккаунту прямо сейчас или сделать это позже в личном кабинете.</div>
                    <div class="features">
                        <div class="row-fluid">
                            <div class="span12 blue">Что мне это даст? <br></div>
                        </div>
                        <div class="row-fluid">
                            <div class="span6 clearfix">
                                <span class="big-number blue">1</span>
                                Вы можете вести учет обслуживания Ваших автмобилей.
                            </div>
                            <div class="span6">
                                <span class="big-number blue">2</span>
                                Записываться на СТО не выходя из дома, не заполняя лишних полей.
                            </div>
                        </div>
                    </div>
                    <div class="auto-items">
                        <div class="auto-item">
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car,'brand'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car, "brand", array("class" => "text-input")); ?>
								</div>
							</div>
				
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car,'model'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car, "model", array("class" => "text-input")); ?>
								</div>
							</div>
				
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car,'year'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car, "year", array("class" => "text-input")); ?>
								</div>
							</div>
				
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car,'VIN'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car, "VIN", array("class" => "text-input")); ?>
								</div>
							</div>
				
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car,'mileage'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car, "mileage", array("class" => "text-input")); ?>
								</div>
							</div>
				</div>
				</div>
                 <div class="row-fluid">
                   <div class="span12">
                    <input type="submit" name="submit" class="login-submit" value="Сохранить" />
                   </div>
				<?php $this->endWidget(); ?>
		<?}?>
	</div>
</div>
