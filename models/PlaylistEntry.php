<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "playlist_entry".
 *
 * @property int $id
 * @property int $entry_id
 * @property int $playlist_id
 * @property int $indice
 *
 * @property Entry $entry
 * @property Playlist $playlist
 */
class PlaylistEntry extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'playlist_entry';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entry_id', 'playlist_id', 'indice'], 'required'],
            [['entry_id', 'playlist_id', 'indice'], 'integer'],
            [['entry_id', 'playlist_id'], 'unique', 'targetAttribute' => ['entry_id', 'playlist_id']],
            [['entry_id'], 'exist', 'skipOnError' => true, 'targetClass' => Entry::className(), 'targetAttribute' => ['entry_id' => 'id']],
            [['playlist_id'], 'exist', 'skipOnError' => true, 'targetClass' => Playlist::className(), 'targetAttribute' => ['playlist_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entry_id' => 'Entry ID',
            'playlist_id' => 'Playlist ID',
            'indice' => 'Indice',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntry()
    {
        return $this->hasOne(Entry::className(), ['id' => 'entry_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylist()
    {
        return $this->hasOne(Playlist::className(), ['id' => 'playlist_id']);
    }
}
