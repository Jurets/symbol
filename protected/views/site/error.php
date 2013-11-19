<?php if (YII_DEBUG===true && $error): ?>
	<h2><?=$error['type']?></h2>

	<div class="error">
		<?=$error['message']?>
	</div>

<?php else: ?>

	<h2><?=Yii::t('core','Ошибка')?></h2>

	<p>
		Произошла ошибка!<br/><br/>
        Позвоните нам! И мы ответим на любой интересующий Вас вопрос!
    </p>
<?php endif ?>