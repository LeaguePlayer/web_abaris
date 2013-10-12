<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('username')); ?>:</b>
	<?php echo CHtml::encode($data->username); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mail')); ?>:</b>
	<?php echo CHtml::encode($data->mail); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('article')); ?>:</b>
	<?php echo CHtml::encode($data->article); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('date_find')); ?>:</b>
	<?php echo CHtml::encode($data->date_find); ?>
	<br />


</div>