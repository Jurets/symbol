<?php

/**
 * Small cart.
 * This template is loaded thru ajax request after new product added to cart.
 */
?>
						<div class="head_basket_txt">
							<span>Товаров: <b><?php echo Yii::app()->cart->countItems() ?></b></span>
							<span>На сумму: <b><?php echo StoreProduct::formatPrice(Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice())) ?> р.</b></span>
						</div>
						<div class="head_basket_button">
							<a href="/cart">оформить заказ</a>
						</div>