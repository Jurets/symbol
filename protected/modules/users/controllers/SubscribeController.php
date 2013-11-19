<?php

/**
 * Realize user subscribe
 */
class SubscribeController extends Controller
{

	/**
	 * @return string
	 */
	public function allowedActions()
	{
		return 'add';
	}

	/**
	 * Subscribe new users
	 */
	public function actionAdd()
	{

		if(Yii::app()->request->isPostRequest && isset($_POST['email']))
		{
            $user = new User('register');

			$user->username = $_POST['email'];
            $user->password = 'statSymb';
            $user->email = $user->username;
			$valid = $user->validate();

			if($valid)
			{
				$user->save();
                die('ok');
			}
            else {
                echo 'errors: ';
                print_r($user->getErrors());
            }

		}
	}

}
