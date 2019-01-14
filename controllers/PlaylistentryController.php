<?php

namespace app\controllers;

use yii\rest\ActiveController;

class PlaylistController extends ActiveController
{
    public $modelClass = 'app\models\PlaylistEntry';
}