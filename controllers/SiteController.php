<?php

namespace app\controllers;

use Yii;
use app\models\Entry;

use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;

use M3uParser\M3uParser; // https://github.com/Gemorroj/M3uParser

class SiteController extends Controller
{
    public function actionIndex(){
//         $file;
//         if(file_exists(Yii::getAlias('@data/lista.m3u')))
//         {
//             $file = file_get_contents(Yii::getAlias('@data/lista.m3u'));
            
//             $m3uParser = new M3uParser();
//             $m3uParser->addDefaultTags();
//             $data = $m3uParser->parseFile(Yii::getAlias('@data/lista.m3u'));
//             // print_r($data);
//             // die();
//             $entries;
//             foreach ($data as $key => $entry) {

//                 // $entry->addExtTag(
//                 //     (new \M3uParser\Tag\ExtTv())
//                 //         ->setIconUrl('https://example.org/icon.png')
//                 //         ->setLanguage('es')
//                 //         ->setXmlTvId('xml-tv-id')
//                 //         ->setTags(['hd', 'sd'])
//                 // );
                
//                 $entries[$key]=[];
//                 $entries[$key]['path']=$entry->getPath();
//                 foreach ($entry->getExtTags() as  $extTag) {
//                     // echo "path : ".$entry->getPath() . "\n";
//                     switch ($extTag) {
//                         case $extTag instanceof \M3uParser\Tag\ExtInf: // If EXTINF tag

//                             $entries[$key]['title']=$extTag->getTitle();
//                             $entries[$key]['duration']=$extTag->getDuration();
//                             // echo "Title : ".$extTag->getTitle() . "\n";
//                             // echo "Duration : ".$extTag->getDuration() . "\n";
            
//                             // if ($extTag->hasAttribute('tvg-name')) { // If tvg-name attribute in EXTINF tag
//                             //     echo "Attribute : ".$extTag->getAttribute('tvg-name') . "\n";
//                             // }
//                             break;
            
//                         case $extTag instanceof \M3uParser\Tag\ExtTv: // If EXTTV tag
//                             echo "Xml : ".$extTag->getXmlTvId() . "\n";
//                             echo "IconUrl : ".$extTag->getIconUrl() . "\n";
//                             echo "Language : ".$extTag->getLanguage() . "\n";
//                             foreach ($extTag->getTags() as $tag) {
//                                 echo "Tags : ".$tag . "\n";
//                             }
//                             break;
//                     }
//                 }
//             }
//             Yii::$app->db
// ->createCommand()
// ->batchInsert('entry', ['path','title', 'duration'],$entries)
// ->execute();
//             // print_r($entries);
//             die();
//             return $data;
//         }
//         else
//         {
//             $file = file_get_contents(Yii::$app->params['m3u']);
//             file_put_contents(Yii::getAlias('@data/lista.m3u'),$file);
//         }
        print_r(Entry::find()->all());
        // Yii::$app->response->sendContentAsFile($file, 'lista.m3u', [
        //     'mimeType' => 'audio/x-mpequrl',
        //     'inline' => true
        // ]);
    }
}
