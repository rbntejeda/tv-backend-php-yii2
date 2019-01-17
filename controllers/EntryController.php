<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\DataFilter;

use app\models\Entry;

use M3uParser\M3uParser; // https://github.com/Gemorroj/M3uParser
use M3uParser\M3uEntry;
use M3uParser\Tag\ExtInf;
use M3uParser\Tag\ExtTv;

class EntryController extends ActiveController
{
    public $modelClass = 'app\models\Entry';

    public function actionAll(){
        return $this->modelClass::find()->all();
    }

    public function actionRefresh()
    {
        $file = file_get_contents(Yii::$app->params['m3u']);
        file_put_contents(Yii::getAlias('@data/lista.m3u'),$file);
	}
	
	public function actionTest()
	{
		
	}

    public function actionSync()
    {
		$m3uParser = new M3uParser();
		$m3uParser->addDefaultTags();
		$data = $m3uParser->parseFile(Yii::getAlias('@data/lista.m3u'));
		$entries=[];
		foreach ($data as $entry) {
			$model = new Entry();
			$model->path=$entry->getPath();
			foreach ($entry->getExtTags() as  $extTag) {
				switch ($extTag) {
					case $extTag instanceof \M3uParser\Tag\ExtInf: // If EXTINF tag

						$model->title=$extTag->getTitle();
						$model->duration=$extTag->getDuration();
						break;
		
					// case $extTag instanceof \M3uParser\Tag\ExtTv: // If EXTTV tag
					//     echo "Xml : ".$extTag->getXmlTvId() . "\n";
					//     echo "IconUrl : ".$extTag->getIconUrl() . "\n";
					//     echo "Language : ".$extTag->getLanguage() . "\n";
					//     foreach ($extTag->getTags() as $tag) {
					//         echo "Tags : ".$tag . "\n";
					//     }
					//     break;
				}
			}
			if($model->validate()){
				$entries[]=$model->getAttributes(['path','title','duration']);
			}
		}
		return Yii::$app->db
			->createCommand()
			->batchInsert('entry', ['path','title', 'duration'],$entries)
			->execute();
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