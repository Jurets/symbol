<?php

/**
 * Site start view
 */
?>

		<div id="slider_wrap">
			<div id="nav"></div>
			<div class="slider_block">
                <?php
                foreach($slider as $s)
                    $this->renderPartial('_slide', array('data'=>$s));
                ?>

			</div>
		</div>
	</div>
</header>

<!--main-->
<div id="main">
	<aside id="sidebar">
		<nav class="sidebar_menu">
			<ul>
				<?php
						$list = Yii::app()->menumanager->leftMenu();
      					$this->widget('zii.widgets.CMenuLeft', array( 'items' => $list ) );
				?>
			</ul>
		</nav>
		<div class="banner">
			<a href="/page/dostavka-i-oplata"><img src="/themes/default/assets/img/banner.jpg"></a>
		</div>
		<div class="spam_block">
			<strong>подпишись на рассылку</strong>
			<p>и получай уведосмления о самых
				выгодных предложениях и акциях</p>
            <input id="subscribeMail" type="email" placeholder="ваш e-mail"><input onclick="subscribe();"  id="subscribeButton" type="submit" value="ок">
		</div>
		<div class="sidebar_social">
			<strong>символ статуса в соц. сетях</strong>
			<a href="http://vk.com/club59753918"><img src="/themes/default/assets/img/vk.png"><span>Вконтакте</span></a>
			<a href="https://www.facebook.com/symvolstatusa"><img src="/themes/default/assets/img/fb.png"><span>facebook</span></a>
<!--			<a href="#"><img src="/themes/default/assets/img/class.png"><span>одноклассники</span></a> -->
		</div>
	</aside>
	<div id="content">
		<div class="title">хиты продаж</div>
		<div id="product_wrap">

		<?php
			$j = 0;
			foreach($popular as $p)
			{
				$this->renderPartial('_product', array('data'=>$p));
				$j++;
				//if ($j%3==0) echo '<div class="clear"></div>';
			}
		?>

		</div>
	</div>
</div>
<!--footer-->