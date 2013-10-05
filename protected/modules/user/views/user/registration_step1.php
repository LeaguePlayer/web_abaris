<?php
$this->breadcrumbs = array(
    'Корзина'=>array('/user/cart'),
    'Оформление заказа'
);
?>
<!-- begin step 1 -->
<div class="container">
    <h3>Регистрация</h3>
    <form class="abaris-form" method="POST" action="">
        <div class="steps">Шаг 1 из 3</div>
        <div class="row-fluid">
            <div class="span8 type">
                <input id="fiz" type="radio" name="type" checked class="css-checkbox">
                <label for="fiz" name="demo_lbl_1" class="css-label">Частное лицо</label>
                <br>
                <input id="ur" type="radio" name="type" class="css-checkbox">
                <label for="ur" name="demo_lbl_1" class="css-label">Юридическое</label>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3"><label>Введите Ваше имя <span class="required">*</span></label></div>
            <div class="span5">
                <input class="text-input" type="text">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3"><label>Введите Вашу фамилию <span class="required">*</span></label></div>
            <div class="span5">
                <input class="text-input" type="text">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3"><label>Введите Ваше E-mail <span class="required">*</span></label></div>
            <div class="span5">
                <input class="text-input error-input" type="email">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3"><label>Введите номер телефона <span class="required">*</span></label></div>
            <div class="span5">
                <input class="text-input error-input" type="email">
                <div class="info">На указанный номер будет отправлено sms с кодом подтвержения</div>
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3"><label>Придумайте пароль</label></div>
            <div class="span5">
                <input class="text-input" type="password">
            </div>
        </div>
        <div class="row-fluid">
            <div class="span3"><label>Повторите пароль</label></div>
            <div class="span5">
                <input class="text-input" type="password">
            </div>
        </div>
        <!--organization-->
        <div class="organization" style="display: none;">
            <div class="row-fluid">
                <div class="span3"><label>Наименование организации</label></div>
                <div class="span5">
                    <input class="text-input" type="text">
                </div>

            </div>
            <div class="row-fluid">
                <div class="span3"><label>Наименование юр. лица</label></div>
                <div class="span5">
                    <input class="text-input" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3"><label>ФИО руководителя</label></div>
                <div class="span5">
                    <input class="text-input" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3"><label>КПП</label></div>
                <div class="span5">
                    <input class="text-input" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3"><label>БИК банка</label></div>
                <div class="span5">
                    <input class="text-input" type="text">
                </div>
            </div>
            <div class="row-fluid">
                <div class="span3"><label>Система налогооблажения</label></div>
                <div class="span5">
                    <select class="text-input">
                        <option>Общая</option>
                        <option>Общая</option>
                        <option>Общая</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row-fluid req-info">
            <div class="span8"><span class="required">*</span> Поля обязательные для заполнения</div>
        </div>
        <div class="garant">
            Сайт гарантирует безопасность введенных личных данных
        </div>
        <div class="row-fluid">
            <div class="span4"><a class="cancel-signup" href="#">Я передумал регестрироваться</a></div>
            <div class="span4"><a class="next-step" href="#">Продолжить <i></i></a></div>
        </div>
    </form>
</div>

<!-- end step 1 -->