<div class="slide">
    <div class="slide_img">
        <?php echo CHtml::link(CHtml::image($data->mainImage->getUrl('458x458', 'resize')), array('frontProduct/view', 'url'=>$data->url)); ?>
    </div>
    <div class="slider_txt">
        <dl>
            <dt><?php echo CHtml::encode($data->name); ?></dt>
            <dd><?php echo $data->short_description; ?></dd>
        </dl>
        <div class="slide_price"><?php echo StoreProduct::formatPrice($data->toCurrentCurrency()); ?> р.</div>
        <div class="slider_button">
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
                'success'=>'js:function(data, textStatus, jqXHR){processCartResponse(data, textStatus, jqXHR, "'.Yii::app()->createAbsoluteUrl('/store/frontProduct/view', array('url'=>$data->url)).'")}',), array('id'=>'addProduct'.$data->id) );
            ?>
            <?php echo Chtml::endForm() ?>
        </div>
    </div>
</div>

