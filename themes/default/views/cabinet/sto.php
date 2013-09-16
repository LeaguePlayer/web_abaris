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
                    <div class="step">
                        <a href="<?=$this->createUrl("cabinet/cars")?>"><table><tr><td><span class="big">1</span></td><td>Управлять автомобилями</td></tr></table></a>
                    </div>
                    <div class="step active">
                        <a href="<?=$this->createUrl("cabinet/sto")?>"><table><tr><td><span class="big">2</span></td><td>Вести учет технического обслуживания автомобилей</td></tr></table></a>
                    </div>
                    <div class="step">
                        <a href="/admin-step3.html"><table><tr><td><span class="big">3</span></td><td>Просматривать состояние заказа</td></tr></table></a>
                    </div>
                    <div class="step">
                        <a href="/admin-step4.html"><table><tr><td><span class="big">4</span></td><td>Проверять и оплачивать счета</td></tr></table></a>
                    </div>
                    <div class="step">
                        <a href="/admin-step5.html"><table><tr><td><span class="big">5</span></td><td>Вносить изменения в личные данные</td></tr></table></a>
                    </div>
                </div>

                <div class="text">Вы можете привязать один или несколько автомобилей к аккаунту <br> прямо сейчас или сделать это позже в личном кабинете.</div>
            </div>
            <!-- begin list-->
            <div class="catalog-container grid-items">
                <div class="catalog-grid">
                    <div class="catalog-grid-header">
                        <div class="container">
                            <div class="row-fluid">
                                <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p class="bottom">Автомобиль<br>
                                            <select name="" id="">
                                                <option value="">Привязанные автомобили</option>
                                                <option value="">Привязанные автомобили</option>
                                                <option value="">Привязанные автомобили</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p class="bottom">Дата прохождения ТО<br><input class="calendar" type="text"></p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p class="bottom">Название ТО<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p class="bottom">Вид работ<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p class="bottom">Сумма затрат<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p class="bottom">Затраты на АЗС<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Редакти-<br>ровать</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?if (isset($list_user_car_STO)){?>
                    <form action="" method="POST">
					<?foreach($list_user_car_STO as $sto){?>
                    <div class="catalog-grid-row">
                         <div class="container">
                            <div class="row-fluid">
                                <div class="field span1"><div class="valign-text"><p><span class="un-check blue-check"></span><input type="hidden" name="" value="<?=$sto->id?>" /></p></div></div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p><?=$sto->user_car->brand?></p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p><?=$sto->maintenance_date?></p>
                                    </div>
                                </div>
                                <div class="field span2">
                                    <div class="valign-text">
                                        <p><?=$sto->maintenance_name?></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><?=$sto->maintenance_type?></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><?=$sto->maintenance_cost?></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><?=$sto->azs_cost?></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p><a href="<?=$this->createUrl("cabinet/stoform", array("id" => $sto->id))?>" class="pencil"></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?}?>
                    <?}?>
                </div>
            </div>
            <div class="subtotal icons">
                <div class="container">
                    <div class="row">
                        <div class="span9"></div>
                        <div class="span1">
                            <a href="<?=$this->createUrl("cabinet/stoform")?>"><div class="cart-icon add-icon"></div>Добавить</a>
                        </div>
                        <div class="span1">
                             <input type="submit" class="cart-icon delete-icon" name="submit" value="Удалить" />
                        </div>
                        <!--<div class="span1">
                            <a href="#"><div class="cart-icon save-icon"></div>Сохранить</a>
                        </div>-->
                    </div>
                </div>
            </div>
			</form>
