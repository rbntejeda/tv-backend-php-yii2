<?php

namespace app\controllers;

use yii\rest\ActiveController;

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
}