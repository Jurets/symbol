<?php

/**
 * List of order products
 *
 * @var $model Order
 * @var $this OrdersController
 */

Yii::app()->clientScript->registerScript('qustioni18n', '
	var deleteQuestion = "'.Yii::t('OrdersModule.admin', 'Вы действительно удалить запись?').'";
	var productSuccessAddedToOrder = "'.Yii::t('OrdersModule.admin', 'Продукт успешно добавлен к заказу.').'";
', CClientScript::POS_BEGIN);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'               => 'orderedProducts',
	'enableSorting'    => false,
	'enablePagination' => false,
	'dataProvider'     => $model->getOrderedProducts(),
	'selectableRows'   => 0,
	'template'         => '{items}',
	'columns'          => array(
		array(
			'name'=>'renderFullName',
			'type'=>'raw',
			'header'=>Yii::t('OrdersModule.admin', 'Название')
		),
		'quantity',
		'sku',
		array(
			'name'=>'price',
			'value'=>'StoreProduct::formatPrice($data->price)'
		),
		array(
			'type'=>'raw',
			'value'=>'CHtml::link("&times", "#", array("style"=>"font-weight:bold;", "onclick"=>"deleteOrderedProduct($data->id, $data->order_id, \"'.Yii::app()->request->csrfToken.'\")"))',
		),
	),
));
?>

<script type="text/javascript">
	var orderTotalPrice = '<?php echo $model->total_price ?>';
</script>

<div align="right">
	<table id="orderSummaryTable">
		<thead>
			<tr>
				<td ></td>
				<td></td>
			</tr>
		</thead>
		<tbody>
			<tr align="right">
				<td><b><?php echo Yii::t('OrdersModule.admin','Цена доставки') ?>:</b></td>
				<td><span id="orderDeliveryPrice"><?php echo StoreProduct::formatPrice($model->delivery_price); ?></span></td>
			</tr>
			<tr align="right">
				<td><b><?php echo Yii::t('OrdersModule.admin','Сумма товаров') ?>:</b></td>
				<td><span id="orderTotalPrice"><?php echo StoreProduct::formatPrice($model->total_price) ?></span></td>
			</tr>
			<tr align="right" style="font-size: 14px;">
				<td><b><?php echo Yii::t('OrdersModule.admin','К оплате') ?>:</b></td>
				<td><span id="orderSummary"><?php echo StoreProduct::formatPrice($model->total_price + $model->delivery_price) ?></span></td>
			</tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr align="right">
                <td><b><?php echo Yii::t('OrdersModule.admin','Доставка') ?>:</b></td>
                <td><span><?php echo CHtml::encode($model->delivery_date) . ', ' . CHtml::encode($model->delivery_time_from) . ':00-' . CHtml::encode($model->delivery_time_to).':00'; ?></span></td>
            </tr>
		</tbody>
	</table>
</div>