<?php

/**
 * Category view
 * @var $this CategoryController
 * @var $model StoreCategory
 * @var $provider CActiveDataProvider
 * @var $categoryAttributes
 */

// Set meta tags
$this->pageTitle = ($this->model->meta_title) ? $this->model->meta_title : $this->model->name;
$this->pageKeywords = $this->model->meta_keywords;
$this->pageDescription = $this->model->meta_description;

Yii::app()->clientScript->registerCSSFile(Yii::app()->theme->baseUrl .'/assets/css/uniform.default.css');

// Create breadcrumbs
$ancestors = $this->model->excludeRoot()->ancestors()->findAll();

foreach($ancestors as $c)
	$this->breadcrumbs[$c->name] = $c->getViewUrl();

$this->breadcrumbs[] = $this->model->name;

?>

<div class="catalog_with_sidebar">

		<div class="bread">
			<?php
				$this->widget('zii.widgets.CBreadcrumbs', array(
					'links'=>$this->breadcrumbs,
				));
			?>
		</div>

		<div class="title"><?php echo CHtml::encode($this->model->name); ?></div>

		<div class="filter">
			<div class="filter_left">
				Сортировать по:  цене (<?php echo CHtml::link('возр',array("/store/category/view", "url"=>$this->model->url, 'sort'=>'price' )); ?>/
                <?php echo CHtml::link('убыв',array("/store/category/view", "url"=>$this->model->url, 'sort'=>'price.desc' )); ?>)
			</div>
            
			<div class="filter_right">
<!--				<div>
					<label for="">специфика</label>
					<select>
						<option>Не выбрана</option>
						<option>1</option>
						<option>2</option>
					</select>
				</div>
				<div>
					<label for="">марка</label>
					<select>
						<option></option>
						<option>1</option>
						<option>2</option>
					</select>
				</div>-->
            <?php
                $this->widget('application.modules.store.widgets.filter.SFilterRenderer', array(
                    'model'=>$this->model,
                    'attributes'=>$this->eavAttributes,
                    'view'=>'symbol',
                ));
            ?>
            <script type="text/javascript">
            
                function applyCategorySorter(el)
                {
                window.location = $(el).val();
                } 
                
            </script>
<!--				<div>
					<label for="">цвет</label>
					<select>
						<option></option>
						<option>1</option>
						<option>2</option>
					</select>
				</div>-->
			</div>
		</div>

		<div class="actions">
			<?php
/*				$limits=array(Yii::app()->request->removeUrlParam('/store/category/view', 'per_page')  => $this->allowedPageLimit[0]);
				array_shift($this->allowedPageLimit);
				foreach($this->allowedPageLimit as $l)
					$limits[Yii::app()->request->addUrlParam('/store/category/view', array('per_page'=> $l))]=$l;

				echo Yii::t('StoreModule.core', 'На странице:');
				echo CHtml::dropDownList('per_page', Yii::app()->request->url, $limits, array('onchange'=>'applyCategorySorter(this)'));
		*/	?>

		</div>
		<div id="product_wrap">
        <div class="clear"></div>
		<?php
			$this->widget('zii.widgets.CListView', array(
				'dataProvider'=>$provider,
				'ajaxUpdate'=>false,
				'template'=>'{items} {pager}',
				'itemView'=>$itemView,
				'sortableAttributes'=>array(
					'name', 'price'
				),
			));
		?>
		</div>
	</div>
<!--</div>-->
<!-- catalog_with_sidebar end -->
