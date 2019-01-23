<?php

namespace app\controllers;

use yii\rest\ActiveController;

use app\models\Entry;

use yii\data\ActiveDataFilter;
use yii\data\ActiveDataProvider;
use yii\data\DataFilter;

class PlaylistentryController extends ActiveController
{
    public $modelClass = 'app\models\PlaylistEntry';
}