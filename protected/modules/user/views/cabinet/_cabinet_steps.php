<div class="container page-title">
    <h2 class="georgia">Личный кабинет</h2>
    <div>
        <span class="blue-line"></span><br>
        <span class="red">Ваш уникальный код пользователя <?Yii::app()->user->id?></span>
    </div>
</div>


<div class="admin-steps container">
    <div class="text">В личном кабинете вы можете:</div>
    <div class="clearfix">
        <div class="step <?php if ($this->getAction()->id == 'cars') echo 'active'; ?>">
            <a href="<?=$this->createUrl('cabinet/cars')?>"><table><tr><td><span class="big">1</span></td><td>Управлять автомобилями</td></tr></table></a>
        </div>
        <div class="step <?php if ($this->getAction()->id == 'sto') echo 'active'; ?>">
            <a href="<?=$this->createUrl('cabinet/sto')?>"><table><tr><td><span class="big">2</span></td><td>Вести учет технического обслуживания автомобилей</td></tr></table></a>
        </div>
        <div class="step <?php if ($this->getAction()->id == 'orders') echo 'active'; ?>">
            <a href="<?=$this->createUrl('cabinet/orders')?>"><table><tr><td><span class="big">3</span></td><td>Просматривать состояние заказа</td></tr></table></a>
        </div>
        <div class="step <?php if ($this->getAction()->id == 'invoices') echo 'active'; ?>">
            <a href="/admin-step4.html"><table><tr><td><span class="big">4</span></td><td>Проверять и оплачивать счета</td></tr></table></a>
        </div>
        <div class="step <?php if ($this->getAction()->id == 'profile') echo 'active'; ?>">
            <a href="/admin-step5.html"><table><tr><td><span class="big">5</span></td><td>Вносить изменения в личные данные</td></tr></table></a>
        </div>
    </div>

    <div class="text">Вы можете привязать один или несколько автомобилей к аккаунту <br> прямо сейчас или сделать это позже в личном кабинете.</div>
</div>