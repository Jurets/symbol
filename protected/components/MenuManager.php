<?php

/**
 * Manager urls
 */
class MenuManager extends CComponent {

	/**
	 * Init
	 * @access public
	 */
	public function init()
	{

	}

	public function leftMenu()
	{
		Yii::import('application.modules.store.models.StoreCategory');
		$items = StoreCategory::model()->findByPk(1)->asCMenuArray();
		foreach ($items['items'] as $key=>$item)
		{
			$items['items'][$key]['items2'] = $items['items'][$key]['items'];
			unset($items['items'][$key]['items']);
		}
		return $items['items'];
//		print_r($items); die();
	}


}
