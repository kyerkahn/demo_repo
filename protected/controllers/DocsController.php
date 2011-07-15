<?php

class DocsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
        $users = new Users();

		return array(
			array('allow', 
				'actions'=>array('index','view','download','create','update','delete'),
				'users'=>array('@'),
			),
			/*array('allow', //Чорт, вначале сделал, а потом прочитал, что у всех пользователей одинаковые привилегия... 
				'actions'=>array('index','view','download'),
				'users'=>array('@'),
			),
			array('allow',  
				'actions'=>array('create','update','delete'),
                'users'=>$users->getUserListByRole(array('superior', 'employee', 'admin')),
            ),*/
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin'),
                'users'=>$users->getUserListByRole('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Docs;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Docs']))
		{
			$model->attributes=$_POST['Docs'];

            $model->created_at = date('Y-m-d H:i:s', time());
            $model->updated_at = $model->created_at;

            $model->role = 'client';

            $model->uploadedFile=CUploadedFile::getInstance($model, 'uploadedFile');
            if ($model->uploadedFile instanceof CUploadedFile)
                $model->filename = $model->uploadedFile->name;
            $model->guid = uniqid();

            $model->userList = $_POST['Docs']['userList'];

			if($model->save())
            {
                $model->uploadedFile->saveAs('uploads/'.$model->guid);

                if (isset($model->userList) && is_array($model->userList))
                    foreach ($model->userList as $u) 
                    {
                        $du = new DocsUsers;
                        $du->doc_id = $model->id;
                        $du->user_id = $u;
                        $du->save();
                    }

				$this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        $userList = array();
        foreach ($model->users as $u)
            $userList[] = $u->id;
        $model->userList = $userList;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Docs']))
		{
			$model->attributes=$_POST['Docs'];
            $model->updated_at = date('Y-m-d H:i:s', time());

            $model->uploadedFile=CUploadedFile::getInstance($model, 'uploadedFile');
            if ($model->uploadedFile instanceof CUploadedFile)
                $model->filename = $model->uploadedFile->name;
            $model->guid = uniqid();

            $model->userList = $_POST['Docs']['userList'];

			if($model->save())
            {
                $model->uploadedFile->saveAs('uploads/'.$model->guid);

                $data = DocsUsers::model()->deleteAll('doc_id=:doc_id', array(':doc_id' => $model->id));
                
                if (isset($model->userList) && is_array($model->userList))
                    foreach ($model->userList as $u) 
                    {
                        $du = new DocsUsers;
                        $du->doc_id = $model->id;
                        $du->user_id = $u;
                        $du->save();
                    }

				$this->redirect(array('view','id'=>$model->id));
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new Docs('search');
		$model->unsetAttributes();  // clear any default values
        
		//$model=Docs::model()->findAll('role = :role', array(':role'=>Yii::app()->user->role));
		//$model=Docs::model()->findAll('role = :role', array(':role'=>'employee'));

        $attr = array();
		if(isset($_GET['Docs']))
            $attr = $_GET['Docs'];
        unset($attr['users']);
        $attr['userId'] = Yii::app()->user->userid;
        //$attr['users'] = Users::model()->findByPk(Yii::app()->user->userid);
        //var_dump(Users::model()->findByPk(Yii::app()->user->userid));

        $model->attributes = $attr;

        $dataProvider = $model->search();
        $dataProvider->sort = array(
            'defaultOrder'=>'created_at DESC',
        );
        $dataProvider->pagination = array(
            'pageSize'=>8,
        );

		$this->render('index',array(
            'dataProvider'=>$dataProvider,
            'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Docs('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Docs']))
			$model->attributes=$_GET['Docs'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    public function actionDownload($id)
    {
        $model=$this->loadModel($id);
        $fname='uploads/'.$model->guid;
        $this->renderPartial('download', array(
                'fname' => $fname,
                'lname' => $model->filename,
                'ctype' => 'application/octet-stream',
            ),
            false,
            true
        );
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Docs::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='docs-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
