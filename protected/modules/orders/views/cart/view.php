<?php

/**
 * View order
 * @var Order $model
 */

$title = Yii::t('OrdersModule.core', 'Просмотр заказа #{id}', array('{id}'=>$model->id));
$this->pageTitle = $title;

?>

<h1 class="has_background"><?php echo $title; ?></h1>

<div class="basket_table">
	<table width="100%">
		<thead>
		<tr>
            <td></td>
			<td></td>
			<td>Количество</td>
			<td>Сумма</td>
		</tr>
		</thead>
		<tbody>
		<?php foreach($model->getOrderedProducts()->getData() as $product): ?>
		<tr>
            <td style="vertical-align:middle; padding: 0;" width="20px">
                <?php
                // Display image
                if($product->product->mainImage)
                    $imgSource = $product->product->mainImage->getUrl('100x100');
                else
                    $imgSource = 'http://placehold.it/100x100';
                echo CHtml::image($imgSource, '', array('class'=>'thumbnail'));
                ?>
            </td>
			<td>
				<?php echo CHtml::openTag('h5') ?>
				<?php echo CHtml::link(CHtml::encode($product->getRenderFullName(false)), array('/store/frontProduct/view', 'url'=>$product->product->url)); ?>
				<?php echo CHtml::closeTag('h5') ?>
			</td>
			<td>
				<?php echo $product->quantity ?>
			</td>
			<td>
                <span class="price">
                    <?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($product->price * $product->quantity)); ?>
                    <small>р.</small>
                </span>
			</td>
		</tr>
		<?php endforeach ?>

        <tr>
            <td style="padding: 0;"></td><td></td>
            <td style="padding: 0;">
                Всего к оплате:
            </td>
            <td style="padding: 0;">
                <span class="price">
                    <?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($model->full_price)) ?>
                    <small>р.</small>
                </span>
            </td>
        </tr>

		</tbody>
	</table>

	<div class="order_data mt10">
		<div class="user_data rc5">
			<h4><?php echo Yii::t('OrdersModule.core', 'Данные получателя:') ?></h4>

			<div class="form wide">
				<div class="row">
					<?php echo Yii::t('OrdersModule.core', 'Оплата') ?>:
					<?php echo CHtml::encode($model->delivery_name); ?>
				</div>
                <div class="row">
                    <?php echo CHtml::encode($model->delivery_date); ?>, с <?php echo CHtml::encode($model->delivery_time_from); ?>:00 до <?php echo CHtml::encode($model->delivery_time_to); ?>:00
                </div>
				<div class="row">
					<?php echo Yii::t('OrdersModule.core', 'Стоимость') ?>:
					<?php echo StoreProduct::formatPrice(Yii::app()->currency->convert($model->delivery_price)) ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_name); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_email); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_phone); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_country). ', '. CHtml::encode($model->user_city). ', ' . CHtml::encode($model->user_address) . ', ' . CHtml::encode($model->user_house); ?>
				</div>
				<div class="row">
					<?php echo CHtml::encode($model->user_comment); ?>
				</div>
			</div>
		</div>
	</div>
    <br/>

	<?php foreach($model->deliveryMethod->paymentMethods as $payment): ?>
	<div class="order_data mt10 ">
		<div class="user_data rc5 activeHover">
			<h3><?php echo $payment->name ?></h3>
			<p><?php echo $payment->description ?></p>
			<p><?php echo $payment->renderPaymentForm($model) ?></p>
		</div>
	</div>
	<?php endforeach ?>


	<div style="clear: both;"></div>

</div>
