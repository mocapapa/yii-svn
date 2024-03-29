<?php
Yii::import('application.modules.simpleLdapLogin.models.MUser');

class ProjectController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var CActiveRecord the currently loaded data model instance.
	 */
	private $_model;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform project control for CRUD operations
		);
	}

	/**
	 * Specifies the project control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array project control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('index','view','create','update','delete'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Project;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			$model->username=Yii::app()->user->name;
			$user=MUser::model()->find(new CDbCriteria(array(
				'condition'=>'username = :username',
				'params'=>array(
					':username'=>$model->username,
				),
									 )));
						  
			if($model->save()) {
				$this->generate_validuser($user->username, $user->plainPassword);
				$this->generate_acl();
				$this->generate_rep($model->username, $model->project);
				$this->redirect(array('index'));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}


	/**
         * Updates a particular model.
         * If update is successful, the browser will be redirected to the 'view' page.
         */
	public function actionUpdate()
	{
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Project']))
		{
			$model->attributes=$_POST['Project'];
			if($model->save()) {
				$this->generate_acl();
				$this->redirect(array('view','id'=>$model->id));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 */
	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel();
			if (Yii::app()->user->name == $model->attributes['username']) {
			  // we only allow deletion via POST request
				$proj=$model->attributes['project'];
				$user=Yii::app()->user->name;
				$model->delete();
				$this->generate_acl();
				$this->remove_rep($user, $proj);

				// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
				if(!isset($_GET['ajax']))
					$this->redirect(array('index'));
			}
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */

	public function actionIndex()
	{
	  Yii::import('application.modules.simpleLdapLogin.models.MUser');
	  $user=MUser::model()->find('username = \''.Yii::app()->user->name.'\'');
	  //print_r($user);
	  $project = $this;


        	$dataProvider=new CActiveDataProvider('Project', array(
			'criteria'=>array(
				'condition'=>'username=:username',
				'params'=>array(':username'=>Yii::app()->user->name,)
			),
		));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			$this->_model=Project::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404,'The requested page does not exist.');
		}
		return $this->_model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='project-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	//
	// Generate validuser
	//
	private function generate_validuser($username, $password)
	{
		$file = Yii::app()->basePath.'/../validuser';
		system("htpasswd -b $file $username $password");
	}

	//
	// Generate accesspolicy of dav_svn
	//
	private function generate_acl()
	{
		$root='/var/www/html/yii/demos/yii-svn/';
		$filename='accesspolicy';
		$data=Project::model()->findAll();

		if(count($data)>0)
		{
			$handle=fopen($root.$filename, "w");
			fputs($handle, "# this file is automatically generated by yii-svn application.\n");
			fputs($handle, "# thus please do not modify.\n#\n");
			foreach($data as $i=>$item)
			{
				$proj=$item->attributes['project'];
				$user=$item->attributes['username']."...";
				fputs($handle, "[".$user.$proj.":/]\n*=r\n");
				fputs($handle, $item->attributes['username']."=rw\n\n");
			}
			fclose($handle);
		}
	}

	//
	// Generate actual repository
	//
	private function generate_rep($user, $proj)
	{
		$root='/var/www/html/yii/demos/yii-svn/';
		$repos='repos/';
		$user = $user . '...';
		if (!is_dir("$root$repos$user$proj")) {
			system("/usr/bin/svnadmin --config-dir /var/tmp/apache/.subversion/ create $root$repos$user$proj");
			system("/usr/bin/svn -m 'initial structure' mkdir file://localhost/$root$repos$user$proj/branches file://localhost/$root$repos$user$proj/tags file://localhost/$root$repos$user$proj/trunk");
		}
	}

	//
	// Remove actual repository
	//
	private function remove_rep($user, $proj)
	{
		$root='/var/www/html/yii/demos/yii-svn/';
		$repos='repos/';
		system("rm -r $root$repos$user...$proj");
	}

	private  function system_ex($cmd, $stdin = "")
	{
	  $descriptorspec = array(
				  0 => array("pipe", "r"),
				  1 => array("pipe", "w"),
				  2 => array("pipe", "w")
				  );
	  
	  $process = proc_open($cmd, $descriptorspec, $pipes);
	  $result_message = "";
	  $error_message = "";
	  $return = null;
	  if (is_resource($process))
	    {
	      fputs($pipes[0], $stdin);
	      fclose($pipes[0]);
	      
	      while ($error = fgets($pipes[2])){
		$error_message .= $error;
	      }
	      while ($result = fgets($pipes[1])){
		$result_message .= $result;
	      }
	      foreach ($pipes as $k=>$_rs){
		if (is_resource($_rs)){
		  fclose($_rs);
		}
	      }
	      $return = proc_close($process);
	    }
	  return array(
		       'return' => $return,
		       'stdout' => $result_message,
		       'stderr' => $error_message,
		       );
	}

}
