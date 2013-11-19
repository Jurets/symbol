<?php

	Yii::import('application.modules.store.components.SCompareProducts');
	Yii::import('application.modules.store.models.wishlist.StoreWishlist');

	$assetsManager = Yii::app()->clientScript;
	$assetsManager->registerCoreScript('jquery');
	$assetsManager->registerCoreScript('jquery.ui');

	// jGrowl notifications
	Yii::import('ext.jgrowl.Jgrowl');
	Jgrowl::register();

	// Disable jquery-ui default theme
	$assetsManager->scriptMap=array(
		'jquery-ui.css'=>false,
	);
?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo CHtml::encode($this->pageTitle) ?></title>
	<meta charset="UTF-8"/>
	<meta name="description" content="<?php echo CHtml::encode($this->pageDescription) ?>">
	<meta name="keywords" content="<?php echo CHtml::encode($this->pageKeywords) ?>">

	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/style.css">
	<link rel="stylesheet" href="<?php echo Yii::app()->theme->baseUrl ?>/assets/css/fonts/font.css">

			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery-1.7.1.min.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.placeholder.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.cycle.all.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/ui/ui.core.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/ui/ui.datepicker.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/common.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.uniform.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.radio.js"></script>
			<script src="<?php echo Yii::app()->theme->baseUrl ?>/assets/js/jquery.checkbox.js"></script>
</head>
<body>
<div id="wrapper">
<!--header-->
<header>

	<div id="header">
		<div class="head">
			<div class="logo"><a href="/"><img src="/themes/default/assets/img/logo.png"></a></div>
			<div class="head_right">
				<div class="head_top">
					<div class="head_phone">
						<strong>8 (495) 984-16-53</strong>
						<div>ежедневно <span>10<sup>00</sup> - 21<sup>00</sup></span></div>
					</div>
					<div class="head_basket<?php if (Yii::app()->cart->countItems()) echo ' full';?>" id='cart'>
						<?php $this->renderFile(Yii::getPathOfAlias('orders.views.cart._small_cart').'.php'); ?>
					</div>
				</div>
				<nav class="head_menu">
					<menu>
						<li><a href="/category/main">каталог</a></li>

			<?php
				$this->widget('zii.widgets.CMenu2', array(
					'items'=>array(
						array('label'=>Yii::t('core', 'бренды'), 'url'=>array('/pages/pages/view', 'url'=>'brands')),
						array('label'=>Yii::t('core', 'доставка и оплата'), 'url'=>array('/pages/pages/view', 'url'=>'dostavka-i-oplata')),
						array('label'=>Yii::t('core', 'гарантия'), 'url'=>array('/pages/pages/view', 'url'=>'garantiya')),
						array('label'=>Yii::t('core', 'контакты'), 'url'=>array('/pages/pages/view', 'url'=>'contacts')),
					),
				));
			?>
					</menu>
				</nav>
			</div>
		</div>

		<?php echo $content; ?>


<footer>
	<nav>
		<a href="/category/main">Каталог</a>
		<a href="/page/brands">Бренды</a>
		<a href="/page/dostavka-i-oplata">Доставка и оплата</a>
		<a href="/page/garantiya">Гарантия</a>
		<a href="/page/contacts">Контакты</a>
	</nav>
	<address>
		Copyright © 2013
	</address>
</footer>
</div>
</body>
</html>