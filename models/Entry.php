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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entry';
    }

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntryTags()
    {
        return $this->hasMany(EntryTags::className(), ['entryId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(EntryTags::className(), ['id' => 'tagId'])->viaTable('entry_tags', ['entryId' => 'id']);
    }
}
