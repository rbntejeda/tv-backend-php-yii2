<?php

namespace app\controllers;

use yii\rest\ActiveController;

use app\models\Entry;

use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\DataFilter;

class PlaylistController extends ActiveController
{
    public $modelClass = 'app\models\Playlist';

    public function actionAll(){
        return $this->modelClass::find()->all();
    }

    public function actionReload()
    {
        return ["hola"];
    }

    public function actionEntry($id)
    {
        $query=Entry::find()->joinWith('playlistEntries');
        $provider = new ActiveDataProvider(['query' => $query]);
        return $provider;
    }
}