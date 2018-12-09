<?php

namespace app\models;

use Yii;
use M3uParser\M3uParser; // https://github.com/Gemorroj/M3uParser
use M3uParser\M3uEntry;
use M3uParser\Tag\ExtInf;
use M3uParser\Tag\ExtTv;

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
 * @property Tag[] $tags
 * @property PlaylistEntry[] $playlistEntries
 * @property Playlist[] $playlists
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
        return $this->hasMany(Tag::className(), ['id' => 'tagId'])->viaTable('entry_tags', ['entryId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylistEntries()
    {
        return $this->hasMany(PlaylistEntry::className(), ['entry_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlaylists()
    {
        return $this->hasMany(Playlist::className(), ['id' => 'playlist_id'])->viaTable('playlist_entry', ['entry_id' => 'id']);
    }

    public function getM3uEntry()
    {
        $entry = new M3uEntry();
        $entry->setPath($this->path);
        $entry->addExtTag(
            (new ExtInf())
                ->setDuration($this->duration)
                ->setTitle($this->title)
        );
        // $flag = false;
        // $ext = new ExtTv();
        // if(!empty($this->icon))
        // {
        //     $ext->setIconUrl($this->icon);
        //     $flag=true;
        // }
        // if(!empty($this->lang))
        // {
        //     $ext->setLanguage($this->lang);
        //     $flag=true;
        // }
        // if($flag)
        // {
        //     $entry->addExtTag($ext);
        // }
        // $entry->addExtTag(
        //     (new ExtTv())
        //         ->setIconUrl('https://example.org/icon.png')
        //         ->setLanguage('ru')
        //         ->setXmlTvId('xml-tv-id')
        //         ->setTags(['hd', 'sd'])
        // );
        return $entry;
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

    public static function SyncEntry()
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
}
