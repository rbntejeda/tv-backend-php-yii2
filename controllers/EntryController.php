<?php

namespace app\controllers;

use yii\rest\ActiveController;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\DataFilter;

class EntryController extends ActiveController
{
    public $modelClass = 'app\models\Entry';

    public function actionAll(){
        return $this->modelClass::find()->all();
    }

    public function actionRefresh()
    {
        return $this->modelClass::RefreshFile();
    }

    public function actionSync()
    {
        return $this->modelClass::SyncEntry();
    }


    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }

    public function actionIndex()
	{
		$model = new $this->modelClass;
		$query=$model->find();

		$dataProvider = new ActiveDataProvider(['query' => $query]);

		$filter = new ActiveDataFilter([
			'searchModel'=>'app\models\Entry',
		]);

		$request=\Yii::$app->request->get();

		if ($filter->load($request)) 
		{ 
		    $filterCondition = $filter->build();
		    if ($filterCondition === false) 
		    {
		        return $filter;
		    }
		    else
		    {
				$query->andWhere($filterCondition);
		    }
		}
		return $dataProvider;
	}
}