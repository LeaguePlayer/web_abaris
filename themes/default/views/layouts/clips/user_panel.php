<?php $this->beginClip('user_panel'); ?>
    <!-- begin user admin panel-->
    <div class="user-panel-container clearfix">
        <div class="container">
            <ul class="user-panel">
                <li class="up-item no-link"><i class="icon i-user"></i>Здравствуйте, Адексей!</li>
                <li class="up-item"><a href="#" class="active"><i class="icon i-msg"></i>Сообщения</a></li>
                <li class="up-item"><a href="<?=$this->createUrl("cabinet/cars")?>"><i class="icon i-adm"></i>Личный кабинет</a></li>
                <li class="up-item"><a href="#"><i class="icon i-cart"></i>Ваша корзина <span>4</span> товаров <span>4000</span> р.</a></li>
                <li class="up-item"><a href="#"><i class="icon i-logout"></i>Выход</a></li>
            </ul>
        </div>
    </div>
    <!-- end user admin panel-->
<?php $this->endClip(); ?>
