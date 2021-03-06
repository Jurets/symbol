<?php

Yii::import('orders.models.*');
Yii::import('store.models.*');

/**
 * Cart controller
 * Display user cart and create new orders
 */
class CartController extends Controller
{

	/**
	 * @var OrderCreateForm
	 */
	public $form;

	public $productId;
	/**
	 * @var bool
	 */
	protected $_errors = false;



    /**
     * Fast order button
     */
    public function actionFast()
    {
        if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('name') && Yii::app()->request->getPost('phone') && Yii::app()->request->getPost('url'))
        {
            $this->form = new OrderCreateForm;
            $this->form->name = Yii::app()->request->getPost('name');
            $this->form->phone = Yii::app()->request->getPost('phone');

            if($this->form->validate())
            {
                $this->createFastOrder();
                die();
            }

        }
    }



	/**
	 * Display list of product added to cart
	 */
	public function actionIndex()
	{
		// Recount
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('recount') && !empty($_POST['quantities']))
			$this->processRecount();

		$this->form = new OrderCreateForm;

		// Next step order
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('order'))
		{
			if(isset($_POST['OrderCreateForm']))
			{
				$this->form->attributes = $_POST['OrderCreateForm'];

				if($this->form->validate())
				{
					$this->render('order', array(
						'items'           => Yii::app()->cart->getDataWithModels(),
						'totalPrice'      => Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice()),
						'deliveryMethods' => $deliveryMethods,
					));
					return;
				}
                else
                {
                	echo CActiveForm::validate($this->form);
                }

     		}
		}


		// Make order
		if(Yii::app()->request->isPostRequest && Yii::app()->request->getPost('create'))
		{
			if(isset($_POST['OrderCreateForm']))
			{
				$this->form->attributes = $_POST['OrderCreateForm'];
				if($this->form->validate())
				{
					$order = $this->createOrder();

					Yii::app()->cart->clear();
					$this->addFlashMessage(Yii::t('OrdersModule.core', 'Спасибо. Ваш заказ принят.'));
					Yii::app()->request->redirect($this->createUrl('view', array('secret_key'=>$order->secret_key)));
				}
			}
		}

		$deliveryMethods = StoreDeliveryMethod::model()
			->applyTranslateCriteria()
			->active()
			->orderByName()
			->findAll();

		$this->render('index', array(
			'items'           => Yii::app()->cart->getDataWithModels(),
			'totalPrice'      => Yii::app()->currency->convert(Yii::app()->cart->getTotalPrice()),
			'deliveryMethods' => $deliveryMethods,
		));
	}

	/**
	 * Find order by secret_key and display.
	 * @throws CHttpException
	 */
	public function actionView()
	{
		$secret_key = Yii::app()->request->getParam('secret_key');
		$model = Order::model()->find('secret_key=:secret_key', array(':secret_key'=>$secret_key));

		if(!$model)
			throw new CHttpException(404, Yii::t('OrdersModule.core', 'Ошибка. Заказ не найден.'));

		$this->render('view', array(
			'model'=>$model,
		));
	}

	/**
	 * Validate POST data and add product to cart
	 */
	public function actionAdd()
	{
		$variants = array();

		// Load product model
		$model = StoreProduct::model()
			->active()
			->findByPk(Yii::app()->request->getPost('product_id', 0));

		// Check product
		if(!isset($model))
			$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Продукт не найден'), true);

		// Update counter
		$model->saveCounters(array('added_to_cart_count'=>1));

		// Process variants
		if(!empty($_POST['eav']))
		{
			foreach($_POST['eav'] as $attribute_id=>$variant_id)
			{
				if(!empty($variant_id))
				{
					// Check if attribute/option exists
					if(!$this->_checkVariantExists($_POST['product_id'], $attribute_id, $variant_id))
						$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Вариант продукта не найден.'));
					else
						array_push($variants, $variant_id);
				}
			}
		}

		// Process configurable products
		if($model->use_configurations)
		{
			// Get last configurable item
			$configurable_id = Yii::app()->request->getPost('configurable_id', 0);

			if(!$configurable_id || !in_array($configurable_id , $model->configurations))
				$this->_addError(Yii::t('OrdersModule.core', 'Ошибка. Выберите вариант продукта.'), true);
		}else
			$configurable_id  = 0;

		Yii::app()->cart->add(array(
			'product_id'      => $model->id,
			'variants'        => $variants,
			'configurable_id' => $configurable_id,
			'quantity'        => (int) Yii::app()->request->getPost('quantity', 1),
			'price'           => $model->price,
		));
        $this->productId = $model->id;
		$this->_finish();
	}

	/**
	 * Remove product from cart and redirect
	 */
	public function actionRemove($index)
	{
		Yii::app()->cart->remove($index);

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Clear cart
	 */
	public function actionClear()
	{
		Yii::app()->cart->clear();

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Render data to display in theme header.
	 */
	public function actionRenderSmallCart()
	{
		$this->renderPartial('_small_cart');
	}


    /**
     * Create new order, fast!
     * @return Order
     */
    public function createFastOrder()
    {
        $order = new Order;

        // Set main data
        $order->user_id      = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
        $order->user_name    = $this->form->name;
        $order->user_phone   = $this->form->phone;
        $order->user_country = 'Russia';
        $order->user_city    = 'FastOrder';
        $order->user_house   = 0;
        $order->delivery_id  = 17;

        if($order->validate())
            $order->save();
        else { print_r($order->getErrors()); print_r($_POST); die('notsave');
            throw new CHttpException(503, Yii::t('OrdersModule.core', 'Ошибка создания заказа')); }


        if (!preg_match ('/.*\/(.*?)\.html/i',Yii::app()->request->getPost('url'), $url))
            throw new CHttpException(503, Yii::t('OrdersModule.core', 'Ошибка создания заказа, url not found'));

        // Process product
        $item = StoreProduct::model()
            ->active()
            ->withUrl($url[1])
            ->find();

        if (!$item) throw new CHttpException(503, Yii::t('OrdersModule.core', 'Ошибка создания заказа, url not found2'));

        $ordered_product = new OrderProduct;
        $ordered_product->order_id        = $order->id;
        $ordered_product->product_id      = $item->id;
        $ordered_product->name            = $item->name;
        $ordered_product->quantity        = 1;
        $ordered_product->sku             = $item->sku;
        $ordered_product->price           = $item->price;

        $ordered_product->save();

        // Reload order data.
        $order->refresh();

        $this->sendAdminEmail($order);

        return $order;
    }


	/**
	 * Create new order
	 * @return Order
	 */
	public function createOrder()
	{
		if(Yii::app()->cart->countItems() == 0)
			return false;

		$order = new Order;

		// Set main data
		$order->user_id      = Yii::app()->user->isGuest ? null : Yii::app()->user->id;
		$order->user_name    = $this->form->name;
		$order->user_email   = $this->form->email;
		$order->user_phone   = $this->form->phone;
        $order->user_country = $this->form->country;
        $order->user_city    = $this->form->city;
		$order->user_address = $this->form->address;
        $order->user_house   = $this->form->house . '-' . addslashes($_POST['korpus']) . '-' . addslashes($_POST['kvartira']);
        $order->delivery_date= $this->form->delivery_date;
        $order->delivery_time_from = $this->form->delivery_time_from;
        $order->delivery_time_to = $this->form->delivery_time_to;
		$order->user_comment = $this->form->comment;
		$order->delivery_id  = $this->form->delivery_id;

		if($order->validate())
			$order->save();
		else { print_r($order->getErrors()); print_r($_POST); die('notsave');
			throw new CHttpException(503, Yii::t('OrdersModule.core', 'Ошибка создания заказа')); }

		// Process products
		foreach(Yii::app()->cart->getDataWithModels() as $item)
		{
			$ordered_product = new OrderProduct;
			$ordered_product->order_id        = $order->id;
			$ordered_product->product_id      = $item['model']->id;
			$ordered_product->configurable_id = $item['configurable_id'];
			$ordered_product->name            = $item['model']->name;
			$ordered_product->quantity        = $item['quantity'];
			$ordered_product->sku             = $item['model']->sku;
			$ordered_product->price           = StoreProduct::calculatePrices($item['model'], $item['variant_models'], $item['configurable_id']);

			// Process configurable product
			if(isset($item['configurable_model']) && $item['configurable_model'] instanceof StoreProduct)
			{
				$configurable_data=array();

				$ordered_product->configurable_name = $item['configurable_model']->name;
				// Use configurable product sku
				$ordered_product->sku = $item['configurable_model']->sku;
				// Save configurable data

				$attributeModels = StoreAttribute::model()->findAllByPk($item['model']->configurable_attributes);
				foreach($attributeModels as $attribute)
				{
					$method = 'eav_'.$attribute->name;
					$configurable_data[$attribute->title]=$item['configurable_model']->$method;
				}
				$ordered_product->configurable_data=serialize($configurable_data);
			}

			// Save selected variants as key/value array
			if(!empty($item['variant_models']))
			{
				$variants = array();
				foreach($item['variant_models'] as $variant)
					$variants[$variant->attribute->title] = $variant->option->value;
				$ordered_product->variants = serialize($variants);
			}

			$ordered_product->save();
		}

		// All products added. Update delivery price
		$order->updateDeliveryPrice();

		// Reload order data.
		$order->refresh();

		// Send email to user.
		$this->sendEmail($order);
        // Send email to admin.
        $this->sendAdminEmail($order);

		return $order;
	}

	/**
	 * Check if product variantion exists
	 * @param $product_id
	 * @param $attribute_id
	 * @param $variant_id
	 * @return string
	 */
	protected function _checkVariantExists($product_id, $attribute_id, $variant_id)
	{
		return StoreProductVariant::model()->countByAttributes(array(
			'id'           => $variant_id,
			'product_id'   => $product_id,
			'attribute_id' => $attribute_id
		));
	}

	/**
	 * Recount product quantity and redirect
	 */
	public function processRecount()
	{
		Yii::app()->cart->recount(Yii::app()->request->getPost('quantities'));

		if(!Yii::app()->request->isAjaxRequest)
			Yii::app()->request->redirect($this->createUrl('index'));
	}

	/**
	 * Add message to errors array.
	 * @param string $message
	 * @param bool $fatal finish request
	 */
	protected function _addError($message, $fatal = false)
	{
		if($this->_errors === false)
			$this->_errors = array();

		array_push($this->_errors, $message);

		if($fatal === true)
			$this->_finish();
	}

	/**
	 * Process result and exit!
	 */
	protected function _finish()
	{
		echo CJSON::encode(array(
			'errors'=>$this->_errors,
			'productId'=>$this->productId,
			'message'=>Yii::t('OrdersModule.core','Продукт успешно добавлен в {cart}', array(
				'{cart}'=>CHtml::link(Yii::t('OrdersModule', 'корзину'), array('/orders/cart/index'))
			)),
		));
		exit;
	}

	/**
	 * Sends email to user after create new order.
	 */
	private function sendEmail(Order $order)
	{
		$theme=Yii::t('OrdersModule', 'Ваш заказ №').$order->id;

		$lang=Yii::app()->language;
		$emailBodyFile=Yii::getPathOfAlias("application.emails.$lang").DIRECTORY_SEPARATOR.'new_order.php';

		// If template file does not exists use default russian translation
		if(!file_exists($emailBodyFile))
			$emailBodyFile=Yii::getPathOfAlias("application.emails.ru").DIRECTORY_SEPARATOR.'new_order.php';
		$body = $this->renderFile($emailBodyFile, array('order'=>$order), true);

		$mailer           = Yii::app()->mail;
		$mailer->From     = Yii::app()->params['adminEmail'];
		$mailer->FromName = Yii::app()->settings->get('core', 'siteName');
		$mailer->Subject  = $theme;
		$mailer->Body     = $body;
		$mailer->AddAddress($order->user_email);
		$mailer->AddReplyTo(Yii::app()->params['adminEmail']);
		$mailer->isHtml(true);
		$mailer->Send();
		$mailer->ClearAddresses();
	}


    /**
     * Sends email to user after create new order.
     */
    private function sendAdminEmail(Order $order)
    {
        $theme=Yii::t('OrdersModule', 'В системе новый заказ №').$order->id;

        $lang=Yii::app()->language;
        $emailBodyFile=Yii::getPathOfAlias("application.emails.$lang").DIRECTORY_SEPARATOR.'new_order.php';

        // If template file does not exists use default russian translation
        if(!file_exists($emailBodyFile))
            $emailBodyFile=Yii::getPathOfAlias("application.emails.ru").DIRECTORY_SEPARATOR.'new_order.php';
        $body = $this->renderFile($emailBodyFile, array('order'=>$order), true);

        $mailer           = Yii::app()->mail;
        $mailer->From     = Yii::app()->params['adminEmail'];
        $mailer->FromName = Yii::app()->settings->get('core', 'siteName');
        $mailer->Subject  = $theme;
        $mailer->Body     = $body;
        $mailer->AddAddress('po4ta199@gmail.com');
        $mailer->AddReplyTo(Yii::app()->params['adminEmail']);
        $mailer->isHtml(true);
        $mailer->Send();
        $mailer->ClearAddresses();
    }



}
