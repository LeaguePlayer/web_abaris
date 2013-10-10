<div class="container">
	<div class="row">
		<?if (isset($user_car_STO)){?>
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
									<?php echo $form->labelEx($user_car_STO,'user_car_id'); ?>
								</div>
								<div class="span8">
									<?php echo $form->dropDownList($user_car_STO, "user_car_id", CHtml::ListData($user_cars, "id", "brand"), array("class" => "text-input")); ?>
								</div>
							</div>
				
						</div>
					</div>
                    
                    <div class="auto-items">
                        <div class="auto-item">
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car_STO,'maintenance_date'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car_STO, "maintenance_date", array("class" => "text-input")); ?>
								</div>
							</div>
				
						</div>
					</div>
					
                    <div class="auto-items">
                        <div class="auto-item">
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car_STO,'maintenance_name'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car_STO, "maintenance_name", array("class" => "text-input")); ?>
								</div>
							</div>
				
						</div>
					</div>
					
                    <div class="auto-items">
                        <div class="auto-item">
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car_STO,'maintenance_type'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car_STO, "maintenance_type", array("class" => "text-input")); ?>
								</div>
							</div>
				
						</div>
					</div>
					
                    <div class="auto-items">
                        <div class="auto-item">
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car_STO,'maintenance_cost'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car_STO, "maintenance_cost", array("class" => "text-input")); ?>
								</div>
							</div>
				
						</div>
					</div>
					
                    <div class="auto-items">
                        <div class="auto-item">
							<div class="row-fluid">
								<div class="span4">
									<?php echo $form->labelEx($user_car_STO,'azs_cost'); ?>
								</div>
								<div class="span8">
									<?php echo $form->textField($user_car_STO, "azs_cost", array("class" => "text-input")); ?>
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
