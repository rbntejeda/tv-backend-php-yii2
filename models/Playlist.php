<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "playlist".
 *
 * @property int $id
 * @property string $title
 * @property string $creado
 *
 * @property PlaylistEntry[] $playlistEntries
 * @property Entry[] $entries
 */
class Playlist extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return 'playlist';
    }

    public function rules()
    {
        return [
            [['title'], 'required'],
            [['creado'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'creado' => 'Creado',
        ];
    }

    public function extraFields()
    {
        return [
            'playlistEntries',
            'cntEntry'
        ];
    }

    public function getPlaylistEntries()
    {
        return $this->hasMany(PlaylistEntry::className(), ['playlist_id' => 'id']);
    }

    public function getEntries()
    {
        return $this->hasMany(Entry::className(), ['id' => 'entry_id'])->viaTable('playlist_entry', ['playlist_id' => 'id']);
    }

    public function getCntEntry()
    {
        return $this->getEntries()->count();
    }
}
