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
                    <div class="step active">
                        <a href="<?=$this->createUrl("cabinet/cars")?>"><table><tr><td><span class="big">1</span></td><td>Управлять автомобилями</td></tr></table></a>
                    </div>
                    <div class="step">
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
            <?if ($dataUserListCars){?>
            <div class="catalog-container grid-items">
                <div class="catalog-grid">
                    <div class="catalog-grid-header">
                        <div class="container">
                            <div class="row-fluid">
                                <div class="field span1"><div class="valign-text"><p><span class="check grey-check"></span></p></div></div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p>Марка<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Модель<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Пробег<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Год<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span3">
                                    <div class="valign-text">
                                        <p>VIN номер<br><input type="text"></p>
                                    </div>
                                </div>
                                <div class="field span1">
                                    <div class="valign-text">
                                        <p>Редактировать</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <form action="" method="POST">
						 <?php $this->widget('zii.widgets.CListView', array(
							'id'=>'list_user_cars',
							'template'=>'{items}<div class="catalog-pager">{pager}</div>',
							'dataProvider'=>$dataUserListCars,
							'itemView'=>'_item_list_cars_user',
							'pagerCssClass'=>'container',
							'emptyTagName'=>'div',
							'itemsCssClass'=>'container',
							'pager'=>array(
								'class'=>'application.widgets.ELinkPager',
								'cssFile'=>false,
								'header'=>'',
								'firstPageLabel'=>'',
								'prevPageLabel'=>'',
								'previousPageCssClass'=>'arrow left',
								'nextPageLabel'=>'',
								'nextPageCssClass'=>'arrow right',
								'lastPageLabel'=>'',
								'htmlOptions'=>array(
									'class'=>''
								),
							)
						)); ?>
				</div>
            <div class="subtotal icons">
                <div class="container">
                    <div class="row">
                        <div class="span9"></div>
                        <div class="span1">
                            <a href="<?=$this->createUrl("cabinet/carform")?>"><div class="cart-icon add-icon"></div>Добавить</a>
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
            <?}?>
