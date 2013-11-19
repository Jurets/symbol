<?php
/**
 * Product view
 * @var StoreProduct $model
 * @var $this Controller
 */

// Set meta tags
$this->pageTitle = ($model->meta_title) ? $model->meta_title : $model->name;
$this->pageKeywords = $model->meta_keywords;
$this->pageDescription = $model->meta_description;

Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/jquery.reveal.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/galery.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/fancybox/source/jquery.fancybox.js?v=2.1.4', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile( Yii::app()->theme->baseUrl .'/assets/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5', CClientScript::POS_END);

                                                                                                                              /*



// Fancybox ext
/*
$this->widget('application.extensions.fancybox.EFancyBox', array(
	'target'=>'a.thumbnail',
));
*/
// Register main script
//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/product.view.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile($this->module->assetsUrl.'/product.view.configurations.js', CClientScript::POS_END);

// Create breadcrumbs
if($model->mainCategory)
{
	$ancestors = $model->mainCategory->excludeRoot()->ancestors()->findAll();

	foreach($ancestors as $c)
		$this->breadcrumbs[$c->name] = $c->getViewUrl();

	// Do not add root category to breadcrumbs
	if ($model->mainCategory->id != 1)
		$this->breadcrumbs[$model->mainCategory->name] = $model->mainCategory->getViewUrl();
}


?>

<script type="text/javascript" src="/themes/default/assets/js/jquery.maskedinput.min.js"></script>
<script>
    jQuery(function($){
        $("#fastPhone").mask("+7 (999) 999-9999");
    });
</script>

	<link rel="stylesheet" type="text/css" href="/themes/default/assets/js/fancybox/source/jquery.fancybox.css?v=2.1.4" media="screen" />
	<link rel="stylesheet" type="text/css" href="/themes/default/assets/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
	<link rel="stylesheet" type="text/css" href="/themes/default/assets/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />

<div class="product">
	<div class="bread">
		<?php
			$this->widget('zii.widgets.CBreadcrumbs', array(
				'links'=>$this->breadcrumbs,
			));
		?>
	</div>

		<hr/>
		<div class="product_wrap">
			<div class="product_img_wrap">
				<div class="product_img_big">
					<?php
						// Main product image
						if($model->mainImage)
							echo CHtml::link(CHtml::image($model->mainImage->getUrl('336x338', 'resize')), $model->mainImage->getUrl(), array('class'=>'fancybox', 'rel'=>'gallery1'));
						else
							echo CHtml::image('http://placehold.it/336x338');
					?>
				</div>
				<div class="product_imgs">
					<?php
                    echo '<a class="active" rel="' . $model->mainImage->getUrl('336x338'). '">' . CHtml::image($model->mainImage->getUrl('112x112'),'',array('rel'=>$model->mainImage->getUrl('336x338', 'resize'))) . '</a>';

					// Display additional images
					foreach($model->imagesNoMain as $image)
					{
                        echo '<a rel="' . $image->getUrl(). '">' . CHtml::image($image->getUrl('112x112'),'',array('rel'=>$image->getUrl('336x338', 'resize'))) . '</a>';
					}
					?>
				</div>
			</div>
			<div class="product_txt">
			<?php echo CHtml::form(array('/orders/cart/add')); ?>
					<h2><?php echo CHtml::encode($model->name); ?></h2>
					<p><manufacturer><?php echo strtoupper($model->manufacturer->name); ?></manufacturer><br/><?php echo $model->short_description; ?></p>
					<ul>
								<?php
									echo $this->renderPartial('_attributes', array('model'=>$model), true);
								?>
					</ul>
                    <div class="price"><?php echo StoreProduct::formatPrice($model->toCurrentCurrency()); ?> <small>р.</small></div>

		<?php 	echo CHtml::hiddenField('product_id', $model->id);
				echo CHtml::hiddenField('product_price', $model->price);
				echo CHtml::hiddenField('use_configurations', $model->use_configurations);
				echo CHtml::hiddenField('currency_rate', Yii::app()->currency->active->rate);
				echo CHtml::hiddenField('configurable_id', 0);
				echo CHtml::hiddenField('quantity', 1);
				echo CHtml::ajaxSubmitButton(Yii::t('StoreModule.core','в корзину'), array('/orders/cart/add'), array(
						'dataType' => 'json',
						'success'  => 'js:function(data, textStatus, jqXHR){ processCartResponse(data, textStatus, jqXHR) }',
					), array(
						'id'=>'buyButton',
						'class'=>'blue_button'
					));

				echo CHtml::endForm();

		?>
					<div><a href="#" class="fast" data-reveal-id="myModal">Быстрый заказ</a></div>
			</div>
		</div>
<script type="text/javascript" src="//yandex.st/share/share.js"
charset="utf-8"></script>
		<div class="title">описание <div class="yashare-auto-init right" data-yashareL10n="ru"
 data-yashareType="button" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,lj,gplus"></div></div>

		<article>
			<p><?php echo $model->full_description; ?></p>
		</article>



		<?php // $this->renderPartial('_configurations', array('model'=>$model));
		?>


	<?php
		// Related products tab
		if($model->relatedProductCount)
		{
			echo $this->renderPartial('_related', array( 'model'=>$model ), true);
		}
	?>
</div>


<div id="myModal" class="reveal-modal">
	<a class="close-reveal-modal">&#215;</a>
	<div class="title_modal">Быстрый заказ</div>
	<form action="#">
		<div>
			<label for="fastName">ваше имя</label>
			<input type="text" name="fastName" id="fastName"/>
		</div>
		<div>
			<label for="fastPhone">телефон</label>
			<input type="text" name="fastPhone" id="fastPhone"/>
		</div>
		<div class="righttext">
			<input type="submit" value="Отправить" id='btnFastOrder'/>
		</div>
	</form>
	<div class="modal_txt" style='display:none;'>
		<strong>Спасибо за ваш заказ!</strong>
		<p>Наш менеджер свяжется с вами в ближайшее время</p>
	</div>
</div>