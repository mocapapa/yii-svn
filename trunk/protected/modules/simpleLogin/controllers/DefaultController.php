<?php
  // $Id$
class DefaultController extends Controller
{
	const LOGIN_STATE = 0;
	const REGISTRATION_STATE = 1;
	public $state = self::LOGIN_STATE;

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image
			// this is used by the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xEBF4FB,
			),
		);
	}

	/**
	 * Displays the login page
	 */
	public function actionIndex()
	{
		$form=new MLoginForm;
		$previousStatus = 'login';

		// collect user input data
		if(isset($_POST['MLoginForm']))
		{
			$previousStatus = isset($_POST['MLoginForm']['passwordRepeat'])? 'register' : 'login';

			$form->scenario='login';
			$form->attributes=$_POST['MLoginForm'];

			if($form->validate() && !$form->errorCode) {
			  // login OK
				$this->redirect(Yii::app()->user->returnUrl);
			  
			} else if ($form->errorCode == MUserIdentity::USER_TO_BE_REGISTERED) {
			  // no user found
				if ($previousStatus == 'login') {
					$this->state = self::REGISTRATION_STATE;

				} else {
					$form->scenario='register';
					$form->attributes=$_POST['MLoginForm'];

					if($form->validate()) {
						$duration=$form->rememberMe ? 3600*24*30 : 0; // 30 days
						$user = new MUser;
						$user->attributes = $form->attributes;

						$passfile=Yii::app()->basePath."/../validuser";
						system("htpasswd -b $passfile $user->username $user->password");

						$user->password = md5($user->password);
						$user->save();
					
						$identity = new MUserIdentity($form->username,$form->password);
						$identity->authenticate();
						Yii::app()->user->login($identity, $duration);
					
						$this->redirect(Yii::app()->user->returnUrl);
					} else {
					  // password error
						$this->state = self::REGISTRATION_STATE;
					}
				}

			} else {
			// password error
				if ($previousStatus == 'login') {
					$this->state = self::LOGIN_STATE;
				} else {
					$this->state = self::REGISTRATION_STATE;
				}
			}
		}

		// display the login form
		$users=MUser::model()->findAll();
		$this->render('login', array('form'=>$form,
					     'state'=>$this->state,
					     'users'=>$users,
					     ));
	}

	/**
	 * Logout the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Delete the user
	 */
	public function actionDelete()
	{
		$user=MUser::model()->find('LOWER(username)=?',array(strtolower(Yii::app()->user->name)));
		$user->delete();
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

}