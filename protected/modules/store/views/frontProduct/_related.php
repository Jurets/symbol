<?php

/**
 * Display related product
 * @var StoreProduct $model
 */
?>
<div class="title">похожие товары</div>
<div id="product_wrap">
	<?php foreach($model->relatedProducts as $data):  ?>
		<div class="product_block">
				<figure>
				<?php
				if($data->mainImage)
					$imgSource = $data->mainImage->getUrl('227x227');
				else
					$imgSource = 'http://placehold.it/227x227';
				echo CHtml::link(CHtml::image($imgSource), array('frontProduct/view', 'url'=>$data->url));
				?>
					<figcaption>
							<?php echo CHtml::link(CHtml::encode($data->name), array('frontProduct/view', 'url'=>$data->url)) ?>
					</figcaption>
				</figure>
				<div class="product_buy">
				<?php
					echo '<b>'. StoreProduct::formatPrice($data->toCurrentCurrency()) .' р.</b>';
				?>
				<?php
				echo CHtml::form(array('/orders/cart/add'));
				echo CHtml::hiddenField('product_id', $data->id);
				echo CHtml::hiddenField('product_price', $data->price);
				echo CHtml::hiddenField('use_configurations', $data->use_configurations);
				echo CHtml::hiddenField('currency_rate', Yii::app()->currency->active->rate);
				echo CHtml::hiddenField('configurable_id', 0);
				echo CHtml::hiddenField('quantity', 1);

				echo CHtml::ajaxSubmitButton(Yii::t('StoreModule.core','в корзину'), array('/orders/cart/add'), array(
					'id'=>'addProduct'.$data->id,
					'dataType'=>'json',
					'success'=>'js:function(data, textStatus, jqXHR){processCartResponseFromList(data, textStatus, jqXHR, "'.Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$data->url)).'")}',));
				?>
				<?php echo Chtml::endForm() ?>
				</div>
		</div>
	<?php endforeach; ?>
</div>