<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entry_tags".
 *
 * @property int $id
 * @property int $entryId
 * @property int $tagId
 *
 * @property Entry $entry
 * @property Tag $tag
 */
class EntryTags extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'entry_tags';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entryId', 'tagId'], 'required'],
            [['entryId', 'tagId'], 'integer'],
            [['entryId', 'tagId'], 'unique', 'targetAttribute' => ['entryId', 'tagId']],
            [['entryId'], 'exist', 'skipOnError' => true, 'targetClass' => Entry::className(), 'targetAttribute' => ['entryId' => 'id']],
            [['tagId'], 'exist', 'skipOnError' => true, 'targetClass' => Tag::className(), 'targetAttribute' => ['tagId' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entryId' => 'Entry ID',
            'tagId' => 'Tag ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(Entry::className(), ['id' => 'entryId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tagId']);
    }
}
