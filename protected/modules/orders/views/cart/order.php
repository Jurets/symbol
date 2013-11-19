<?php

/**
 * Display cart
 * @var Controller $this
 * @var SCart $cart
 * @var $totalPrice integer
 */

Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/cart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('cartScript', "var orderTotalPrice = '$totalPrice';", CClientScript::POS_HEAD);
Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl .'/assets/css/uniform.default.css');

$this->pageTitle = Yii::t('OrdersModule.core', 'Оформление заказа');

if(empty($items))
{
	echo '<div class="title">ваша корзина пуста!</div>';
	return;
}
?>
			<script type="text/javascript">
			$(function() {
				$("#datepicker").datepicker({
                    dateFormat : 'dd.mm.yy'
                });
			});
			</script>

<?php echo CHtml::form() ?>
		<div class="title">Оформление заказа</div>
		<div class="order_wrap">
			<div class="order_block">
				<div class="order_numb">1</div>
				<div class="order_title">кому</div>
				<div class="order_inner">
					<div class="order_line">
						<div class="order_line_items">
							<div class="order_line_inner">
								<label for="">имя <sup>*</sup></label>
								<?php echo CHtml::activeTextField($this->form, 'name', array('class'=>'large')); ?>
							</div>
							<div class="order_line_inner">
								<label for="">Телефон  <sup>*</sup></label>
								<?php echo CHtml::activeTextField($this->form, 'phone', array('class'=>'large')); ?>
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
						<div class="order_line_items order_line_items_check">
							<input type="checkbox" class="niceCheck" id="ch4" tabindex="1" />
							<label for="ch4">доставить заказ мне</label>
						</div>
					</div>
				</div>
			</div>
			<div class="order_block">
				<div class="order_numb">2</div>
				<div class="order_title">адрес доставки</div>
				<div class="order_inner">
					<div class="order_line">
						<div class="order_line_items">
							<div class="order_line_inner">
								<label for="">Страна <sup>*</sup></label>
                                <?php echo CHtml::activeTextField($this->form, 'country', array('class'=>'normal')); ?>
							</div>
							<div class="order_line_inner">
								<label for="">Город <sup>*</sup></label>
                                <?php echo CHtml::activeTextField($this->form, 'city', array('class'=>'normal')); ?>
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
						<div class="order_line_items">
							<div class="order_line_inner">
								<label for="">Улица <sup>*</sup></label>
                                <?php echo CHtml::activeTextField($this->form, 'address', array('class'=>'normal')); ?>
							</div>
							<div class="order_line_inner">
								<label for="">Дом <sup>*</sup></label>
                                <?php echo CHtml::activeTextField($this->form, 'house'); ?>
							</div>
							<div class="order_line_inner">
								<label for="">Корпус <sup></sup></label>
								<input type="text" name="korpus" />
							</div>
							<div class="order_line_inner">
								<label for="">Квартира <sup></sup></label>
								<input type="text" name="kvartira" />
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
						<div class="order_line_items">
							<div class="order_line_inner">
								<label for="">Комментарии <sup></sup></label>
                                <?php echo CHtml::activeTextField($this->form, 'comment', array('class'=>'xxlarge')); ?>
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
					</div>
				</div>
			</div>
			<div class="order_block">
				<div class="order_numb">3</div>
				<div class="order_title">время доставки</div>
				<div class="order_inner">
					<div class="order_line">
						<div class="order_line_items">
							<div class="order_line_inner">
								<label for="">дата доставки </label>
								<div class="order_date">
									<label for="">дата</label>
                                    <?php echo CHtml::activeTextField($this->form, 'delivery_date', array('class'=>'smallx', 'id'=>'datepicker')); ?>
								</div>
							</div>
							<div class="order_line_inner">
								<label for="">Удобное время для доставки </label>
								<div class="order_select">
									<div>
										<label for="">с</label>
                                        <?php echo CHtml::activeDropDownList($this->form, 'delivery_time_from', array(
                                            '' => '',
                                            '10' => '10:00',
                                            '11' => '11:00',
                                            '12' => '12:00',
                                            '13' => '13:00',
                                            '14' => '14:00',
                                            '15' => '15:00',
                                            '16' => '16:00',
                                            '17' => '17:00',
                                            '18' => '18:00',
                                            '19' => '19:00',
                                            '20' => '20:00',
                                        ) ); ?>
									</div>
									<div>
										<label for="">до </label>
                                        <?php echo CHtml::activeDropDownList($this->form, 'delivery_time_to', array(
                                            '' => '',
                                            '11' => '11:00',
                                            '12' => '12:00',
                                            '13' => '13:00',
                                            '14' => '14:00',
                                            '15' => '15:00',
                                            '16' => '16:00',
                                            '17' => '17:00',
                                            '18' => '18:00',
                                            '19' => '19:00',
                                            '20' => '20:00',
                                            '21' => '21:00',
                                        ) ); ?>
									</div>
								</div>
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
					</div>
				</div>
			</div>
			<div class="order_block">
				<div class="order_numb">4</div>
				<div class="order_title">способ оплаты</div>
				<div class="order_inner">
					<div class="order_line">
						<div class="order_line_items">
							<div class="order_line_item_radio">
								<div><?php echo CHtml::activeRadioButton($this->form, 'delivery_id', array('class'=>'niceRadio', 'id'=>'myradio1', 'value'=>'14', 'uncheckValue'=>null, 'checked' => 'checked', 'tabindex'=>'1')); ?> <label for="myradio1">Наличными при получении</label></div>
								<div><?php echo CHtml::activeRadioButton($this->form, 'delivery_id', array('class'=>'niceRadio', 'id'=>'myradio2', 'value'=>'15', 'uncheckValue'=>null, 'tabindex'=>'2')); ?> <label for="myradio2">Вызов курьера за оплатой (БЕСПЛАТНО)</label></div>
								<div><?php echo CHtml::activeRadioButton($this->form, 'delivery_id', array('class'=>'niceRadio', 'id'=>'myradio3', 'value'=>'16', 'uncheckValue'=>null, 'tabindex'=>'3')); ?> <label for="myradio3">Банковские карты, Платежные системы, Денежные переводы</label><small>Комиссия системы - 7,9%</small></div>
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
					</div>
				</div>
			</div>
			<div class="order_block">
				<div class="order_numb">5</div>
				<div class="order_title">уведомления по e-mail</div>
				<div class="order_inner">
					<div class="order_line">
						<div class="order_line_items">
							<div class="order_line_inner">
								<div class="order_line_check">
									<div><strong><input type="checkbox" class="niceCheck" id="ch1" tabindex="1" /></strong> <label for="ch1">уведомлять меня о статусе заказа по почте</label></div>
								</div>
							</div>
							<div class="order_line_inner">
								<label for="">ваш e-mail</label>
                                <?php echo CHtml::activeTextField($this->form, 'email', array('class'=>'large')); ?>
							</div>
						</div>
						<br class="clear"/><br class="clear"/>
					</div>
				</div>
			</div>
		</div>
		<div class="order_button">
			<input type="submit" name="create" value="Отправить"/>
		</div>
<?php echo CHtml::endForm() ?>