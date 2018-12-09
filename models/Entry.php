<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entry".
 *
 * @property int $id
 * @property string $path
 * @property string $title
 * @property int $duration
 * @property string $icon
 * @property string $lang
 * @property int $type
 * @property string $state
 * @property string $creado
 * @property string $modificado
 *
 * @property EntryTags[] $entryTags
 * @property EntryTags[] $tags
 */
class Entry extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'entry';
    }

    public function rules()
    {
        return [
            [['path'], 'required'],
            [['duration', 'type'], 'integer'],
            [['lang', 'state'], 'string'],
            [['creado', 'modificado'], 'safe'],
            [['path', 'title', 'icon'], 'string', 'max' => 255],
            [['path'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'path' => 'Path',
            'title' => 'Title',
            'duration' => 'Duration',
            'icon' => 'Icon',
            'lang' => 'Lang',
            'type' => 'Type',
            'state' => 'State',
            'creado' => 'Creado',
            'modificado' => 'Modificado',
        ];
    }

    public function getEntryTags()
    {
        return $this->hasMany(EntryTags::className(), ['entryId' => 'id']);
    }

    public function getTags()
    {
        return $this->hasMany(EntryTags::className(), ['id' => 'tagId'])->viaTable('entry_tags', ['entryId' => 'id']);
    }

    public static function CurrentFile()
    {
        $alias = Yii::getAlias('@data/lista.m3u');
        if(!file_exists($alias))
        {
            static::RefreshFile();
        }
        return file_get_contents($alias);
    }

    public static function RefreshFile()
    {
        $file = file_get_contents(Yii::$app->params['m3u']);
        file_put_contents(Yii::getAlias('@data/lista.m3u'),$file);
    }
}
