<div class="black-line">
    <div class="container"></div>
</div>

<div class="big-title">
    <div class="container">
        <h2>Нужна запчасть или расходные материалы?</h2>
        <p class="we-help georgia">Мы поможем!</p>
    </div>
</div>
<div class="main-banner"></div>

<div class="container page-title">
    <h2 class="georgia">Выберите марку автомобиля</h2>
    <div>
        <span class="blue-line"></span>
    </div>
</div>

<?if ($brands){?>
	<div class="brends-block">
		<div class="row-rhombs">
			<?php $maxCount = count($brands) < 2 ? count($brands) : 2; ?>
			<?php for ($i = 0; $i < $maxCount; $i++): ?>
				<div class="rhomb"><a href="<?php echo $this->createUrl('/site/changeBrand', array('alias'=>$brands[$i]->alias)); ?>"><?php echo $brands[$i]->getImage('medium'); ?></a></div>
			<?php endfor; ?>
		</div>
		<div class="row-rhombs offset">
			<?php $maxCount = count($brands) > 2 ? count($brands) : 0; ?>
			<?php for ($i = 2; $i < 5; $i++): ?>
				<div class="rhomb"><a href="<?php echo $this->createUrl('/site/changeBrand', array('alias'=>$brands[$i]->alias)); ?>"><?php echo $brands[$i]->getImage('medium'); ?></a></div>
			<?php endfor; ?>
		</div>
	</div>
<?}?>
