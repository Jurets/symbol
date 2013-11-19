<?php

Yii::import('store.models.StoreDeliveryMethod');

/**
 * Used in cart to create new order.
 */
class OrderCreateForm extends CFormModel
{
	public $name;
	public $email;
    public $country;
    public $city;
	public $address;
    public $house;
    public $phone;
	public $comment;
	public $delivery_id;
    public $delivery_date;
    public $delivery_time_from;
    public $delivery_time_to;

	public function init()
	{
		if(!Yii::app()->user->isGuest)
		{
			$profile=Yii::app()->user->getModel()->profile;
			$this->name=$profile->full_name;
			$this->phone=$profile->phone;
            $this->country=$profile->country;
            $this->city=$profile->city;
			$this->address=$profile->delivery_address;
            $this->house=$profile->house;
			$this->email=Yii::app()->user->email;
		}
	}

	/**
	 * Validation
	 * @return array
	 */
	public function rules()
	{
		return array(
			array('name, phone', 'required'),
			array('email', 'email'),
            array('delivery_date', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'dd.MM.yyyy'),
            array('delivery_time_from, delivery_time_to, delivery_id','numerical', 'integerOnly'=>true),
			array('comment', 'length', 'max'=>'500'),
			array('address', 'length', 'max'=>'255'),
			array('email, country, city, house', 'length', 'max'=>'100'),
			array('phone', 'length', 'max'=>'30'),
//			array('delivery_id', 'validateDelivery'),
		);
	}

	public function attributeLabels()
	{
		return array(
			'name'        => Yii::t('OrdersModule.core', 'Имя'),
			'email'       => Yii::t('OrdersModule.core', 'Email'),
			'comment'     => Yii::t('OrdersModule.core', 'Комментарий'),
            'country'     => Yii::t('OrdersModule.core', 'Страна'),
            'city'        => Yii::t('OrdersModule.core', 'Город'),
			'address'     => Yii::t('OrdersModule.core', 'Улица'),
            'house'       => Yii::t('OrdersModule.core', 'Дом'),
			'phone'       => Yii::t('OrdersModule.core', 'Номер телефона'),
			'delivery_id' => Yii::t('OrdersModule.core', 'Способ доставки'),
		);
	}

	/**
	 * Check if delivery method exists
	 */
	public function validateDelivery()
	{
		if(StoreDeliveryMethod::model()->countByAttributes(array('id'=>$this->delivery_id)) == 0)
			$this->addError('delivery_id', Yii::t('OrdersModule.core', 'Необходимо выбрать способ доставки.'));
	}
}
