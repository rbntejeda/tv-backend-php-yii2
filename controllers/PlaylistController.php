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
        $query=Entry::find()->joinWith('playlistEntry');
        $query->andWhere(['playlist_entry.playlist_id'=>$id]);
        // return $query->createCommand()->rawSql;
        $provider = new ActiveDataProvider(['query' => $query]);
        return $provider;
    }

    public function actionNoentry($id)
    {
        $query=Entry::find()->andWhere('NOT EXISTS(SELECT * FROM playlist_entry WHERE playlist_entry.entry_id=entry.id AND playlist_entry.playlist_id=:id)',[':id'=>$id]);
        // $query->andWhere(['<>','playlist_entry.playlist_id',$id]);
        // $query->orWhere(['is', 'playlist_entry.playlist_id', new \yii\db\Expression('null')]);
        
        return $query->createCommand()->rawSql;
        $provider = new ActiveDataProvider(['query' => $query]);
        return $provider;
    }
}