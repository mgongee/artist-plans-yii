<?php

namespace app\modules\admin\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class DefaultController extends AdminDefaultController
{
	
	public function behaviors()
    {
		return $this->defaultBehaviors();
    }
	
    public function actionIndex()
    {
        return $this->render('index');
    }
}
