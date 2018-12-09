<?php

namespace app\controllers;

use yii\rest\ActiveController;

class PlaylistController extends ActiveController
{
    public $modelClass = 'app\models\Entry';

    public function actionAll(){
        return $this->modelClass::find()->all();
    }

    public function actionReload()
    {
        return ["hola"];
    }
}