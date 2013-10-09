<?php $this->beginClip('user_panel'); ?>
    <!-- begin user admin panel-->
    <div class="user-panel-container clearfix">
        <div class="container">
            <ul class="user-panel">
                <?php if ( !Yii::app()->user->isGuest ) {
                    $userName = Yii::app()->user->getState('first_name');
                    if ( empty($userName) ) {
                        $userName = Yii::app()->user->getState('username');
                    }
                } else {
                    $userName = 'Гость';
                } ?>
                <li class="up-item no-link"><i class="icon i-user"></i>Здравствуйте, <?php echo $userName; ?>!</li>
                <?php if ( !Yii::app()->user->isGuest ): ?>
                    <li class="up-item"><a href="<?php echo $this->createUrl('/user/messages'); ?>" class="active"><i class="icon i-msg"></i>Сообщения</a></li>
                    <li class="up-item"><a href="<?php echo $this->createUrl('/user/profile'); ?>"><i class="icon i-adm"></i>Личный кабинет</a></li>
                <?php endif; ?>
                <?php
                    $cartCount = Yii::app()->cart->getCount();
                    $cartCost = Yii::app()->cart->getCost();
                ?>
                <li id="cart-info" class="up-item"><a href="<?php echo $this->createUrl('/user/cart'); ?>"><i class="icon i-cart"></i>Ваша корзина <span><?php echo $cartCount; ?></span> <?php echo SiteHelper::pluralize($cartCount, array('товар', 'товара', 'товаров')) ?> <span class="cost"><?php echo SiteHelper::priceFormat($cartCost); ?></span> р.</a></li>
                <?php if ( Yii::app()->user->isGuest ): ?>
                    <li class="up-item"><a href="<?php echo $this->createUrl('/user/login'); ?>"><i class="icon i-auth"></i>Вход</a></li>
                <?php else: ?>
                    <li class="up-item"><a href="<?php echo $this->createUrl('/user/logout'); ?>"><i class="icon i-auth"></i>Выход</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
    <!-- end user admin panel-->
<?php $this->endClip(); ?>
