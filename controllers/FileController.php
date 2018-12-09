<?php

namespace app\controllers;

use Yii;
use app\models\Entry;
use yii\web\Controller;

class FileController extends Controller
{
    public function actionIndex()
    {
        return Yii::$app->response->sendContentAsFile(Entry::CurrentFile(), 'lista.m3u', [
            'mimeType' => 'audio/x-mpequrl',
            'inline' => true
        ]);
    }

    public function actionCreate($id)
    {
        return $id;
    }
}