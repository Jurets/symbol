<?php

/**
 * Display cart
 * @var Controller $this
 * @var SCart $cart
 * @var $totalPrice integer
 */

$this->pageTitle = Yii::t('OrdersModule.core', 'Оформление заказа');

if(empty($items))
{
	echo CHtml::openTag('h2');
	echo Yii::t('OrdersModule.core', 'Корзина пуста');
	echo CHtml::closeTag('h2');
	return;
}
?>
<script type="text/javascript" src="/themes/default/assets/js/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="/themes/default/assets/js/jquery.tooltip.pack.js"></script>

	<script>
		jQuery(function($){
			 $("#order_phone").mask("+7 (999) 999-9999");
             $("#garanty").tooltip( { showURL: false } );
		});
	</script>
    <style>
        #tooltip {
            position: absolute;
            z-index: 3000;
            border: 1px solid #111;
            background-color: #eee;
            padding: 5px;
            opacity: 0.85;
            font-size: 16px;
        }
        #tooltip h3, #tooltip div { margin: 0; }
    </style>

<?php echo CHtml::form() ?>
<div class="title">корзина</div>
		<div class="basket_table">
        <table>
        <tbody>
		<?php foreach($items as $index=>$product): ?>
		<tr>
			<td style="vertical-align:middle;" width="20px">
				<?php
					// Display image
					if($product['model']->mainImage)
						$imgSource = $product['model']->mainImage->getUrl('100x100');
					else
						$imgSource = 'http://placehold.it/100x100';
					echo CHtml::image($imgSource, '', array('class'=>'thumbnail'));
				?>
			</td>
			<td>
					&nbsp;<?php echo CHtml::link(CHtml::encode($product['model']->name), array('/store/frontProduct/view', 'url'=>$product['model']->url)); ?>
			</td>
			<td>
				<?php echo CHtml::textField("quantities[$index]", $product['quantity'], array('class'=>'count')) ?>
			</td>
			<td>
				<?php echo CHtml::link('&#215;', array('/orders/cart/remove', 'index'=>$index), array('class'=>'close')) ?>
				<?php
				echo CHtml::openTag('span', array('class'=>'price'));
				echo StoreProduct::formatPrice(Yii::app()->currency->convert($product['price'] * $product['quantity']));
				echo ' <small>р.</small>';
				echo CHtml::closeTag('span');
				?>
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	</div>



		<div class="basket_buttons">
			<div class="left">
				<button onClick="document.location.href='/';">продолжить покупки</button>
			</div>
			<div class="basket_buttons_r right">
				<button name="recount" type="submit" value="1">Пересчитать</button>
			<?php echo CHtml::endForm() ?>
				<div class="basket_buttons_price">
					<span class="basket_buttons_price_txt">итого:</span>
					<span class="price">
						<?php echo StoreProduct::formatPrice($totalPrice) ?>
					<small>р.</small></span>
				</div>
			</div>
		</div>


		<div class="data_basket">
			<h5>данные заказчика</h5>
				<?php echo CHtml::beginForm('','post',array('id'=>'firstForm')); ?>
					<div class="left">
						<label for="">ваше имя <sup>*</sup></label>
						<?php echo CHtml::activeTextField($this->form, 'name', array('id'=>'order_name')); ?>
					</div>
					<div class="right">
						<label for="">Телефон<sup>*</sup></label>
						<?php echo CHtml::activeTextField($this->form,'phone', array('id'=>'order_phone')); ?>
					</div>
					<div class="clear"></div>
					<div class="data_basket_bottom">
						<a href="#" id="garanty" onClick="return false;" style="cursor: default;" class="left" title="Ваши данные, заполненные на данном шаге корзины, являются служебными и не будут раскрыты третьим лицам.">Гарантия анонимности</a>
						<input type="hidden" name="order" value="1"/>
						<input type="button" id="btnOrderFirst" value="продолжить оформление" class="right button-submit"/>
					</div>
				<?php echo CHtml::endForm() ?>
		</div>